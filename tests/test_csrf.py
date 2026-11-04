# =========================================================
# FICHIER : siteVitrine/tests/test_csrf.py
# Etape 4 - protection CSRF :
#   chaque formulaire porte un jeton secret, et toute requete
#   POST sans le bon jeton est refusee AVANT traitement.
# =========================================================

import pytest
from bs4 import BeautifulSoup

from conftest import ADMIN_EMAIL, ADMIN_PASSWORD, url

SECTIONS_ADMIN = [
    ("adminAccueil", "home-intro"),
    ("adminAccueil", "home-about"),
    ("adminAccueil", "home-domains"),
    ("adminPresentation", "presentation-path"),
    ("adminContact", "contact-nature-demande"),
]


def _formulaires_post(html: str):
    soup = BeautifulSoup(html, "html.parser")
    return [f for f in soup.find_all("form") if f.get("method", "").lower() == "post"]


# ---------------------------------------------------------
# Tous les formulaires contiennent le jeton
# ---------------------------------------------------------

@pytest.mark.parametrize("page", ["login", "contact"])
def test_formulaires_publics_ont_un_jeton(client, page):
    formulaires = _formulaires_post(client.get(url(page), timeout=10).text)

    assert formulaires
    for form in formulaires:
        assert form.find("input", {"name": "csrf_token"}), f"Formulaire sans jeton sur {page}"


def test_formulaire_parametres_generaux_a_un_jeton(admin):
    formulaires = _formulaires_post(admin.get(url("adminDashboard"), timeout=10).text)

    assert formulaires
    assert all(f.find("input", {"name": "csrf_token"}) for f in formulaires)


@pytest.mark.parametrize("page, section", SECTIONS_ADMIN)
def test_formulaires_des_sections_ont_un_jeton(admin, page, section):
    formulaires = _formulaires_post(admin.get(url(page, section=section), timeout=10).text)

    assert formulaires, f"Aucun formulaire pour la section {section}"
    assert all(f.find("input", {"name": "csrf_token"}) for f in formulaires)


# ---------------------------------------------------------
# Les requetes sans jeton (ou avec un faux) sont refusees
# ---------------------------------------------------------

def test_connexion_sans_jeton_refusee_meme_avec_le_bon_mot_de_passe(client, identifiants_admin):
    response = client.post(
        url("login"),
        data={"email": ADMIN_EMAIL, "password": ADMIN_PASSWORD},
        timeout=10,
    )

    assert response.status_code == 403
    assert "Formulaire expiré" in response.text
    assert "page=adminDashboard" not in response.url


@pytest.mark.parametrize("jeton", [None, "faux-jeton"])
def test_enregistrement_admin_sans_bon_jeton_refuse(admin, jeton):
    data = {"section_slug": "home-intro", "title": "PIRATE"}
    if jeton:
        data["csrf_token"] = jeton

    response = admin.post(url("adminAccueil", section="home-intro"), data=data, timeout=10)

    assert response.status_code == 403
    assert "Formulaire expiré" in response.text
    assert "Section mise à jour" not in response.text


def test_titre_non_modifie_apres_attaque(admin):
    admin.post(
        url("adminAccueil", section="home-intro"),
        data={"section_slug": "home-intro", "title": "PIRATE"},
        timeout=10,
    )

    accueil = admin.get(url("accueil"), timeout=10)

    assert "PIRATE" not in accueil.text


def test_contact_sans_jeton_refuse(client):
    response = client.post(
        url("contact"),
        data={"name": "Jean", "email": "jean@example.com", "message": "x", "rgpd": "on"},
        timeout=10,
    )

    assert "a expiré" in response.text
    assert "Message envoyé" not in response.text