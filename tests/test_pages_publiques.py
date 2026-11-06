# =========================================================
# FICHIER : siteVitrine/tests/test_pages_publiques.py
# Chaque page publique doit repondre 200, avec header + footer,
# et sans aucune erreur PHP affichee.
# =========================================================

import pytest

from conftest import assert_full_layout, assert_no_php_error, url

PAGES_PUBLIQUES = [
    "accueil",
    "presentation",
    "service",
    "contact",
    "conditions",
    "confidentialite",
    "mentions",
    "login",
]


@pytest.mark.parametrize("page", PAGES_PUBLIQUES)
def test_page_publique_s_affiche(client, page):
    response = client.get(url(page), timeout=10)

    assert response.status_code == 200
    assert_full_layout(response)
    assert_no_php_error(response)


def test_page_par_defaut_est_l_accueil(client):
    """index.php sans parametre doit afficher l'accueil."""
    from conftest import BASE_URL

    response = client.get(BASE_URL, timeout=10)

    assert response.status_code == 200
    assert "ofl-hero" in response.text


@pytest.mark.parametrize("page", [p for p in PAGES_PUBLIQUES if p != "login"])
def test_page_publique_a_un_seul_h1(client, page):
    """Un seul grand titre par page (bon pour Google et la lisibilité)."""
    from bs4 import BeautifulSoup

    soup = BeautifulSoup(client.get(url(page), timeout=10).text, "html.parser")

    assert len(soup.find_all("h1")) == 1


@pytest.mark.parametrize("page", ["accueil", "presentation", "service", "contact"])
def test_images_des_bandeaux_en_chemin_absolu(client, page):
    """Dans un style="--x: url(...)", un chemin relatif serait lu depuis assets/css/
    (image introuvable). Les chemins doivent commencer par / ou https://."""
    import re

    html = client.get(url(page), timeout=10).text
    chemins = re.findall(r"url\('([^']+)'\)", html)

    assert chemins, "aucune image de bandeau trouvée"
    for chemin in chemins:
        assert chemin.startswith(("/", "http")), f"chemin relatif : {chemin}"
        assert "/siteVitrine/" not in chemin, f"chemin écrit en dur pour XAMPP : {chemin}"