# =========================================================
# FICHIER : siteVitrine/tests/test_contact.py
# Etape 3 - formulaire de contact :
#   - erreurs affichees sous chaque champ
#   - saisie conservee quand le formulaire est refuse
#   - injection d'en-tetes mail bloquee (retour a la ligne dans le nom)
#   - anti-spam (champ invisible "website")
#
# Aucun de ces tests n'envoie de vrai mail : soit le formulaire
# est refuse, soit l'anti-spam l'intercepte avant l'envoi.
# =========================================================

from bs4 import BeautifulSoup

from conftest import assert_full_layout, assert_no_php_error, url

PAGE_CONTACT = url("contact")


def _formulaire(client) -> tuple[str, str]:
    """Ouvre la page Contact : renvoie (premier sujet propose, jeton CSRF)."""
    soup = BeautifulSoup(client.get(PAGE_CONTACT, timeout=10).text, "html.parser")
    options = [o["value"] for o in soup.select("#subject option") if o.get("value")]
    assert options, "Aucun sujet dans la liste : verifiez l'admin Contact"
    return options[0], soup.find("input", {"name": "csrf_token"})["value"]


def _envoyer(client, **champs):
    sujet, jeton = _formulaire(client)
    data = {
        "name": "Jean Test",
        "email": "jean.test@example.com",
        "phone": "",
        "subject": sujet,
        "message": "Message de test automatique.",
        "rgpd": "on",
        "csrf_token": jeton,
    }
    data.update(champs)
    data = {k: v for k, v in data.items() if v is not None}
    return client.post(PAGE_CONTACT, data=data, timeout=10)


def _champs_en_erreur(html: str) -> set:
    soup = BeautifulSoup(html, "html.parser")
    return {el.get("name") for el in soup.select(".is-invalid")}


# ---------------------------------------------------------
# Affichage
# ---------------------------------------------------------

def test_formulaire_contient_le_piege_anti_spam(client):
    response = client.get(PAGE_CONTACT, timeout=10)
    soup = BeautifulSoup(response.text, "html.parser")

    piege = soup.find("input", {"name": "website"})
    assert piege is not None
    assert piege.find_parent(class_="visually-hidden") is not None


# ---------------------------------------------------------
# Validation : erreurs visibles + saisie conservee
# ---------------------------------------------------------

def test_formulaire_vide_affiche_une_erreur_par_champ(client):
    response = client.post(PAGE_CONTACT, data={}, timeout=10)

    assert_full_layout(response)
    assert_no_php_error(response)
    assert {"name", "email", "subject", "message", "rgpd"} <= _champs_en_erreur(response.text)
    assert "Le nom est obligatoire." in response.text


def test_saisie_conservee_si_email_invalide(client):
    response = _envoyer(client, email="pas-un-email", message="Mon long message")
    soup = BeautifulSoup(response.text, "html.parser")

    assert _champs_en_erreur(response.text) == {"email"}
    assert soup.find("input", {"name": "name"})["value"] == "Jean Test"
    assert soup.find("textarea", {"name": "message"}).text == "Mon long message"
    assert soup.find("input", {"name": "rgpd"}).has_attr("checked")


def test_telephone_invalide_est_refuse(client):
    response = _envoyer(client, phone="appelle-moi")

    assert "phone" in _champs_en_erreur(response.text)


def test_sujet_inconnu_est_refuse(client):
    response = _envoyer(client, subject="sujet-invente")

    assert "subject" in _champs_en_erreur(response.text)


def test_message_trop_long_est_refuse(client):
    response = _envoyer(client, message="x" * 5001)

    assert "message" in _champs_en_erreur(response.text)


def test_rgpd_obligatoire(client):
    response = _envoyer(client, rgpd=None)

    assert "rgpd" in _champs_en_erreur(response.text)


# ---------------------------------------------------------
# Securite
# ---------------------------------------------------------

def test_injection_d_en_tetes_dans_le_nom_est_bloquee(client):
    response = _envoyer(client, name="Pirate\r\nBcc: victime@example.com")

    assert "name" in _champs_en_erreur(response.text)
    assert "caractères non autorisés" in response.text


def test_saisie_html_est_echappee(client):
    response = _envoyer(client, email="invalide", name='<script>alert("x")</script>')

    assert '<script>alert("x")</script>' not in response.text


def test_robot_qui_remplit_le_piege_n_envoie_rien(client):
    response = _envoyer(client, website="http://spam.example.com")

    # Le robot croit que c'est envoye (redirection + message de succes)...
    assert "page=contact" in response.url
    assert "Message envoyé" in response.text
    # ...mais aucune erreur d'envoi : mail() n'a jamais ete appele.
    assert "pas pu être envoyé" not in response.text


def test_message_de_succes_ne_s_affiche_qu_une_fois(client):
    _envoyer(client, website="http://spam.example.com")

    response = client.get(PAGE_CONTACT, timeout=10)

    assert "Message envoyé" not in response.text