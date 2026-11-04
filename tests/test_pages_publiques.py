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
    assert "homeHeroCarousel" in response.text