# =========================================================
# FICHIER : siteVitrine/tests/test_juridique.py
# Etape 6 - obligations legales :
#   - mentions legales presentes (loi LCEN) et accessibles partout
#   - vraie politique de confidentialite (RGPD), differente des CGU
#   - Google Maps / YouTube affiches, et signales dans la confidentialite
#   - marque OFLABIM partout, plus de "NBsolutions" ni de fautes
# =========================================================

import pytest
from bs4 import BeautifulSoup

from conftest import assert_full_layout, assert_no_php_error, url

PAGES_PUBLIQUES = ["accueil", "presentation", "service", "contact",
                   "conditions", "confidentialite", "mentions"]


def _soup(client, page):
    return BeautifulSoup(client.get(url(page), timeout=10).text, "html.parser")


# ---------------------------------------------------------
# Mentions legales
# ---------------------------------------------------------

def test_page_mentions_legales_existe(client):
    response = client.get(url("mentions"), timeout=10)

    assert response.status_code == 200
    assert_full_layout(response)
    assert_no_php_error(response)
    for rubrique in ["Éditeur du site", "Hébergement", "Directeur de la publication", "SIRET"]:
        assert rubrique in response.text, f"Rubrique obligatoire manquante : {rubrique}"


def test_mentions_reprennent_les_coordonnees_de_l_admin(client):
    html = client.get(url("mentions"), timeout=10).text

    assert "contact@oflabim.fr" in html          # email saisi dans l'admin
    assert "Villeurbanne" in html                 # adresse saisie dans l'admin


@pytest.mark.parametrize("page", PAGES_PUBLIQUES)
def test_liens_legaux_presents_sur_chaque_page(client, page):
    liens = {a["href"] for a in _soup(client, page).find_all("a", href=True)}

    assert "index.php?page=mentions" in liens
    assert "index.php?page=confidentialite" in liens


@pytest.mark.xfail(reason="A COMPLETER AVANT LIVRAISON : infos legales dans views/mentions.php", strict=False)
def test_mentions_legales_completees(client):
    """Passe en XPASS une fois les [À COMPLÉTER] remplis : rappel avant livraison."""
    assert "[À COMPLÉTER]" not in client.get(url("mentions"), timeout=10).text


# ---------------------------------------------------------
# Confidentialite
# ---------------------------------------------------------

def test_confidentialite_est_une_vraie_politique_rgpd(client):
    texte = _soup(client, "confidentialite").get_text(" ")

    for notion in ["Responsable du traitement", "Base légale", "Durée de conservation",
                   "Vos droits", "CNIL", "Cookies"]:
        assert notion in texte, f"Notion RGPD manquante : {notion}"


def test_confidentialite_n_est_plus_une_copie_des_cgu(client):
    confidentialite = _soup(client, "confidentialite").find("main").get_text(" ")
    conditions = _soup(client, "conditions").find("main").get_text(" ")

    assert "Prestations & informations" not in confidentialite
    assert confidentialite != conditions


# ---------------------------------------------------------
# Medias externes (affiches directement, a la demande du client)
# ---------------------------------------------------------

def test_carte_google_maps_affichee_sur_contact(client):
    iframe = _soup(client, "contact").find("iframe")

    assert iframe is not None and "google.com/maps" in iframe["src"]


def test_video_youtube_affichee_sur_presentation(client):
    iframe = _soup(client, "presentation").find("iframe")

    assert iframe is not None and "youtube.com/embed/" in iframe["src"]


def test_confidentialite_mentionne_les_cookies_google(client):
    texte = _soup(client, "confidentialite").get_text(" ")

    assert "Google Maps" in texte and "YouTube" in texte
    assert "que si vous cliquez" not in texte   # ne doit pas promettre un clic qui n'existe pas


# ---------------------------------------------------------
# Marque et orthographe
# ---------------------------------------------------------

@pytest.mark.parametrize("page", PAGES_PUBLIQUES)
def test_marque_oflabim_et_orthographe(client, page):
    soup = _soup(client, page)
    html = str(soup)

    assert "piéces" not in html
    assert "NBsolutions" not in soup.title.text
    assert "© " in html and "OFLABIM" in soup.select_one(".copyright").get_text()