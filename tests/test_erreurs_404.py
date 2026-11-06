# =========================================================
# FICHIER : siteVitrine/tests/test_erreurs_404.py
# Etape 1 - bugs corriges :
#   - URL inconnue = page blanche
#   - message d'alerte affiche "Array"
#   - page adminServices = erreur fatale
# =========================================================

import pytest

from conftest import assert_full_layout, assert_no_php_error, url


@pytest.mark.parametrize("page", ["nimportequoi", "adminServices", "references"])
def test_page_inconnue_affiche_une_vraie_404(client, page):
    response = client.get(url(page), timeout=10)

    assert response.status_code == 404
    assert "Page introuvable" in response.text
    assert_full_layout(response)          # plus de page blanche
    assert_no_php_error(response)         # plus d'erreur fatale


def test_message_404_n_affiche_pas_array(client):
    response = client.get(url("nimportequoi"), timeout=10)

    assert "Array" not in response.text
    # Texte de TEXTE_PAGE_404 (l'apostrophe est échappée en HTML, on teste le début)
    assert "Oops, la page demandée" in response.text


def test_caracteres_speciaux_dans_page_sont_neutralises(client):
    """Le routeur doit nettoyer ?page= : pas d'injection possible."""
    response = client.get(url("<script>alert(1)</script>"), timeout=10)

    assert response.status_code == 404
    assert "<script>alert(1)</script>" not in response.text