# =========================================================
# FICHIER : siteVitrine/tests/conftest.py
# Outils partages par tous les tests (fixtures pytest).
#
# Principe : tests "boite noire". Ils interrogent le site comme
# un navigateur, sans lire le PHP.
#
# ISOLATION : les tests ne touchent JAMAIS la vraie base.
# A chaque lancement :
#   1) la base `sitevitrineoflabim_test` est recreee a partir
#      de sitevitrineoflabim.sql (etat connu, identique a chaque fois)
#   2) un serveur PHP dedie est lance sur le port 8071,
#      configure pour utiliser CETTE base (variable SITE_DB_NAME)
#   3) il est arrete a la fin des tests
# => seul MySQL doit etre demarre dans XAMPP (Apache n'est pas utilise).
#
# Identifiants admin : JAMAIS dans le code.
# Ils sont lus dans tests/.env.local (ignore par Git).
# =========================================================

import os
import re
import subprocess
import time
from collections.abc import Iterator
from pathlib import Path

import pytest
import requests
from bs4 import BeautifulSoup


def _charger_env_local() -> None:
    """Lit tests/.env.local (lignes CLE=valeur) sans ecraser l'environnement."""
    fichier = Path(__file__).with_name(".env.local")
    if not fichier.exists():
        return
    for ligne in fichier.read_text(encoding="utf-8-sig").splitlines():
        ligne = ligne.strip()
        if not ligne or ligne.startswith("#") or "=" not in ligne:
            continue
        cle, valeur = ligne.split("=", 1)
        os.environ.setdefault(cle.strip(), valeur.strip())


_charger_env_local()

# ---------------------------------------------------------
# Configuration
# ---------------------------------------------------------

RACINE_PROJET = Path(__file__).resolve().parent.parent
FICHIER_SQL = RACINE_PROJET / "sitevitrineoflabim.sql"

XAMPP_DIR = Path(os.environ.get("XAMPP_DIR", r"C:\xampp"))
PHP_EXE = XAMPP_DIR / "php" / "php.exe"
MYSQL_EXE = XAMPP_DIR / "mysql" / "bin" / "mysql.exe"

DB_TEST = "sitevitrineoflabim_test"          # base dediee aux tests
DB_USER = os.environ.get("DB_USER", "root")
DB_PASSWORD = os.environ.get("DB_PASSWORD", "")
DB_PORT = os.environ.get("DB_PORT", "3306")

PORT_TEST = int(os.environ.get("TEST_PORT", "8071"))
BASE_URL = f"http://127.0.0.1:{PORT_TEST}/index.php"

ADMIN_EMAIL = os.environ.get("ADMIN_EMAIL", "contact@oflabim.fr")
ADMIN_PASSWORD = os.environ.get("ADMIN_PASSWORD", "")

# Ancien mot de passe publie dans le README : il ne doit plus fonctionner.
MOT_DE_PASSE_PUBLIC = "admin123"

# Ce que PHP affiche quand display_errors est actif.
PHP_ERROR_PATTERN = re.compile(
    r"(Fatal error|Parse error|Warning|Notice|Deprecated)</b>:"
    r"|Uncaught \w+"
    r"|headers already sent",
    re.IGNORECASE,
)


# ---------------------------------------------------------
# Base de test + serveur PHP dedie
# ---------------------------------------------------------

def _mysql(*sql: str, stdin=None, base: str | None = None) -> str:
    """Execute du SQL avec le client mysql de XAMPP."""
    args = [str(MYSQL_EXE), f"--user={DB_USER}", "--host=127.0.0.1", f"--port={DB_PORT}",
            "--default-character-set=utf8mb4", "--batch", "--skip-column-names"]
    if DB_PASSWORD:
        args.append(f"--password={DB_PASSWORD}")
    if base:
        args.append(f"--database={base}")
    if sql:
        args.append("--execute=" + "; ".join(sql))
    resultat = subprocess.run(args, stdin=stdin, capture_output=True, text=True)
    if resultat.returncode != 0:
        pytest.exit(f"Erreur MySQL : {resultat.stderr.strip()}", returncode=2)
    return resultat.stdout


def _hash_mot_de_passe(mot_de_passe: str) -> str:
    """Hash bcrypt calcule par PHP lui-meme (meme algorithme que le site)."""
    resultat = subprocess.run(
        [str(PHP_EXE), "-r", "echo password_hash(getenv('MDP_TEST'), PASSWORD_DEFAULT);"],
        env={**os.environ, "MDP_TEST": mot_de_passe},
        capture_output=True, text=True, check=True,
    )
    return resultat.stdout.strip()


def _preparer_base_de_test() -> None:
    _mysql(
        f"DROP DATABASE IF EXISTS `{DB_TEST}`",
        f"CREATE DATABASE `{DB_TEST}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci",
    )
    with open(FICHIER_SQL, "rb") as dump:
        subprocess.run(
            [str(MYSQL_EXE), f"--user={DB_USER}", "--host=127.0.0.1", f"--port={DB_PORT}",
             "--default-character-set=utf8mb4", f"--database={DB_TEST}"]
            + ([f"--password={DB_PASSWORD}"] if DB_PASSWORD else []),
            stdin=dump, check=True, capture_output=True,
        )

    # Le dump contient l'ancien hash : on applique le mot de passe des tests
    if ADMIN_PASSWORD:
        hash_mdp = _hash_mot_de_passe(ADMIN_PASSWORD)
        _mysql(
            f"UPDATE user SET password_hash = '{hash_mdp}' WHERE email = '{ADMIN_EMAIL}'",
            base=DB_TEST,
        )


@pytest.fixture(scope="session", autouse=True)
def serveur_de_test():
    """Prepare la base de test, lance le serveur PHP dedie, l'arrete a la fin."""
    for exe in (PHP_EXE, MYSQL_EXE):
        if not exe.exists():
            pytest.exit(f"Introuvable : {exe} (reglez XAMPP_DIR dans tests/.env.local)", returncode=2)

    try:
        requests.get(BASE_URL, timeout=1)
        pytest.exit(f"Le port {PORT_TEST} est deja utilise (reglez TEST_PORT).", returncode=2)
    except requests.ConnectionError:
        pass

    _mysql("SELECT 1")   # echoue avec un message clair si MySQL est arrete
    _preparer_base_de_test()

    serveur = subprocess.Popen(
        [str(PHP_EXE), "-S", f"127.0.0.1:{PORT_TEST}", "-t", str(RACINE_PROJET)],
        cwd=RACINE_PROJET,
        env={**os.environ, "SITE_DB_NAME": DB_TEST},
        stdout=subprocess.DEVNULL,
        stderr=subprocess.DEVNULL,
    )

    try:
        for _ in range(50):
            try:
                requests.get(BASE_URL, timeout=1)
                break
            except requests.ConnectionError:
                time.sleep(0.2)
        else:
            pytest.exit("Le serveur PHP de test ne demarre pas.", returncode=2)

        yield
    finally:
        serveur.terminate()
        serveur.wait(timeout=10)


# ---------------------------------------------------------
# Aides pour les tests
# ---------------------------------------------------------

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


def jeton_csrf(session: requests.Session, page: str, **params) -> str:
    """Ouvre une page et recupere le jeton CSRF de son formulaire."""
    html = session.get(url(page, **params), timeout=10).text
    champ = BeautifulSoup(html, "html.parser").find("input", {"name": "csrf_token"})
    assert champ is not None, f"Pas de jeton CSRF dans le formulaire de la page {page}"
    return champ["value"]


def tenter_connexion(session: requests.Session, email: str, mot_de_passe: str) -> requests.Response:
    """Envoie le formulaire de connexion comme un vrai navigateur (avec le jeton)."""
    return session.post(
        url("login"),
        data={
            "email": email,
            "password": mot_de_passe,
            "csrf_token": jeton_csrf(session, "login"),
        },
        timeout=10,
    )


def connecter(session: requests.Session) -> requests.Response:
    """Connecte la session au back-office et renvoie la reponse finale."""
    return tenter_connexion(session, ADMIN_EMAIL, ADMIN_PASSWORD)


# ---------------------------------------------------------
# Fixtures
# ---------------------------------------------------------

@pytest.fixture
def identifiants_admin():
    """Saute proprement les tests admin si le mot de passe n'est pas configure."""
    if not ADMIN_PASSWORD:
        pytest.skip(
            "Mot de passe admin non configure : renseignez ADMIN_PASSWORD "
            "dans tests/.env.local."
        )


@pytest.fixture
def client() -> Iterator[requests.Session]:
    """Un 'navigateur' vierge, sans connexion."""
    with requests.Session() as session:
        yield session


@pytest.fixture
def admin(client: requests.Session, identifiants_admin) -> requests.Session:
    """Un 'navigateur' deja connecte au back-office."""
    response = connecter(client)
    assert "page=adminDashboard" in response.url, (
        "Connexion admin impossible : verifiez ADMIN_EMAIL / ADMIN_PASSWORD "
        "dans tests/.env.local."
    )
    return client