# =========================================================
# FICHIER : siteVitrine/tests/test_admin.py
# Back-office : protection, connexion, onglets, enregistrement.
# =========================================================

import pytest
from bs4 import BeautifulSoup

from conftest import assert_full_layout, assert_no_php_error, url

pytestmark = pytest.mark.admin

PAGES_ADMIN = ["adminDashboard", "adminAccueil", "adminPresentation", "adminContact"]


# ---------------------------------------------------------
# Protection : sans connexion, l'admin est inaccessible
# ---------------------------------------------------------

@pytest.mark.parametrize("page", PAGES_ADMIN)
def test_admin_redirige_vers_login_si_non_connecte(client, page):
    response = client.get(url(page), timeout=10)

    assert "page=login" in response.url
    assert "Administration" not in response.text


def test_login_refuse_un_mauvais_mot_de_passe(client):
    response = client.post(
        url("login"),
        data={"email": "contact@oflabim.fr", "password": "mauvais-mot-de-passe"},
        timeout=10,
    )

    assert "Identifiants invalides" in response.text
    assert "page=adminDashboard" not in response.url


# ---------------------------------------------------------
# Une fois connecte
# ---------------------------------------------------------

@pytest.mark.parametrize("page", PAGES_ADMIN)
def test_pages_admin_s_affichent(admin, page):
    response = admin.get(url(page), timeout=10)

    assert response.status_code == 200
    assert "Administration" in response.text
    assert_full_layout(response)
    assert_no_php_error(response)


def test_onglet_services_est_desactive(admin):
    """Etape 1 : l'onglet ne doit plus pointer vers une page inexistante."""
    response = admin.get(url("adminDashboard"), timeout=10)

    assert "(bientôt)" in response.text
    assert "page=adminServices" not in response.text


def test_logout_deconnecte(admin):
    admin.get(url("logout"), timeout=10)
    response = admin.get(url("adminDashboard"), timeout=10)

    assert "page=login" in response.url


# ---------------------------------------------------------
# Enregistrement d'une section (etape 1 : double session_start)
# On renvoie les valeurs ACTUELLES : le contenu ne change pas.
# ---------------------------------------------------------

def _lire_formulaire(html: str) -> dict:
    """Recupere tous les champs du formulaire de section (hors upload)."""
    soup = BeautifulSoup(html, "html.parser")
    form = soup.find("input", {"name": "section_slug"}).find_parent("form")

    data = {}
    for field in form.find_all(["input", "textarea"]):
        name = field.get("name")
        if not name or field.get("type") == "file":
            continue
        data[name] = field.text if field.name == "textarea" else field.get("value", "")
    return data


def test_enregistrer_section_home_intro(admin):
    page_section = url("adminAccueil", section="home-intro")

    formulaire = admin.get(page_section, timeout=10)
    assert_no_php_error(formulaire)

    data = _lire_formulaire(formulaire.text)
    assert data["section_slug"] == "home-intro"

    response = admin.post(page_section, data=data, timeout=10)

    assert "Section mise à jour" in response.text
    assert_no_php_error(response)   # plus de notice session_start / headers already sent