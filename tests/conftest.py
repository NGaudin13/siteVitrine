# =========================================================
# FICHIER : siteVitrine/tests/conftest.py
# Outils partages par tous les tests (fixtures pytest).
#
# Principe : ces tests sont des tests "boite noire".
# Ils ne lisent pas le PHP : ils interrogent le site qui tourne
# dans XAMPP, exactement comme le ferait un navigateur.
# => Apache + MySQL doivent etre demarres avant de lancer pytest.
# =========================================================

import os
import re

import pytest
import requests

# Adresse du site (modifiable sans toucher au code) :
#   $env:SITE_URL = "http://localhost/siteVitrine/index.php"
BASE_URL = os.environ.get("SITE_URL", "http://localhost/siteVitrine/index.php")

# Identifiants admin (a passer en variables d'environnement
# des que le mot de passe sera change a l'etape 2).
ADMIN_EMAIL = os.environ.get("ADMIN_EMAIL", "contact@oflabim.fr")
ADMIN_PASSWORD = os.environ.get("ADMIN_PASSWORD", "admin123")

# Ce que PHP affiche quand display_errors est actif.
PHP_ERROR_PATTERN = re.compile(
    r"(Fatal error|Parse error|Warning|Notice|Deprecated)</b>:"
    r"|Uncaught \w+"
    r"|headers already sent",
    re.IGNORECASE,
)


def url(page: str, **params) -> str:
    """Construit l'URL d'une page : url('contact') -> ...index.php?page=contact"""
    query = "&".join([f"page={page}"] + [f"{k}={v}" for k, v in params.items()])
    return f"{BASE_URL}?{query}"


def assert_no_php_error(response: requests.Response) -> None:
    """Echoue si la page contient une erreur/notice PHP visible."""
    match = PHP_ERROR_PATTERN.search(response.text)
    assert match is None, (
        f"Erreur PHP sur {response.url} : "
        f"...{response.text[max(0, match.start() - 80):match.end() + 200]}..."
    )


def assert_full_layout(response: requests.Response) -> None:
    """Verifie que la page a bien le header ET le footer (pas de page blanche)."""
    assert "<nav" in response.text, f"Pas de menu (header) sur {response.url}"
    assert "</html>" in response.text, f"Pas de footer / page tronquee sur {response.url}"


@pytest.fixture(scope="session", autouse=True)
def site_disponible():
    """Arrete tout de suite avec un message clair si XAMPP n'est pas lance."""
    try:
        requests.get(url("accueil"), timeout=5)
    except requests.ConnectionError:
        pytest.exit(
            f"Site injoignable sur {BASE_URL}. Demarrez Apache et MySQL dans XAMPP.",
            returncode=2,
        )


@pytest.fixture
def client() -> requests.Session:
    """Un 'navigateur' vierge, sans connexion."""
    with requests.Session() as session:
        yield session


@pytest.fixture
def admin(client: requests.Session) -> requests.Session:
    """Un 'navigateur' deja connecte au back-office."""
    response = client.post(
        url("login"),
        data={"email": ADMIN_EMAIL, "password": ADMIN_PASSWORD},
        timeout=10,
    )
    assert "page=adminDashboard" in response.url, (
        "Connexion admin impossible : verifiez ADMIN_EMAIL / ADMIN_PASSWORD."
    )
    return client