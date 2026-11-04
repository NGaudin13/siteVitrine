# =========================================================
# FICHIER : siteVitrine/tests/test_securite_connexion.py
# Etape 2 - securite de la connexion :
#   - l'ancien mot de passe public ne marche plus
#   - aucun identifiant dans le README
#   - cookie de session protege (HttpOnly, SameSite)
#   - nouvel identifiant de session a la connexion
#   - session reellement detruite a la deconnexion
# =========================================================

from pathlib import Path

import requests

from conftest import ADMIN_EMAIL, MOT_DE_PASSE_PUBLIC, connecter, url

RACINE_PROJET = Path(__file__).resolve().parent.parent
COOKIE_SESSION = "PHPSESSID"


# ---------------------------------------------------------
# Mot de passe
# ---------------------------------------------------------

def test_ancien_mot_de_passe_public_est_refuse(client):
    response = client.post(
        url("login"),
        data={"email": ADMIN_EMAIL, "password": MOT_DE_PASSE_PUBLIC},
        timeout=10,
    )

    assert "Identifiants invalides" in response.text, (
        f"Le mot de passe '{MOT_DE_PASSE_PUBLIC}' fonctionne encore : lancez "
        "scripts/changer_mot_de_passe.php"
    )


def test_readme_ne_contient_aucun_identifiant():
    readme = (RACINE_PROJET / "README.md").read_text(encoding="utf-8")

    assert MOT_DE_PASSE_PUBLIC not in readme
    assert "Mot de passe :" not in readme


def test_aucun_mot_de_passe_en_dur_dans_les_tests():
    for fichier in (RACINE_PROJET / "tests").glob("*.py"):
        if fichier.name == "conftest.py":
            continue  # contient MOT_DE_PASSE_PUBLIC justement pour verifier qu'il est refuse
        assert MOT_DE_PASSE_PUBLIC not in fichier.read_text(encoding="utf-8"), fichier.name


# ---------------------------------------------------------
# Cookie de session
# ---------------------------------------------------------

def test_cookie_de_session_est_protege(client):
    response = client.get(url("accueil"), timeout=10)
    set_cookie = response.headers.get("Set-Cookie", "").lower()

    assert COOKIE_SESSION.lower() in set_cookie
    assert "httponly" in set_cookie, "Cookie lisible en JavaScript"
    assert "samesite=lax" in set_cookie, "Cookie envoye depuis d'autres sites"


# ---------------------------------------------------------
# Cycle de vie de la session
# ---------------------------------------------------------

def test_identifiant_de_session_change_a_la_connexion(client, identifiants_admin):
    client.get(url("login"), timeout=10)
    avant = client.cookies.get(COOKIE_SESSION)

    response = connecter(client)
    apres = client.cookies.get(COOKIE_SESSION)

    assert "page=adminDashboard" in response.url
    assert avant and apres
    assert avant != apres, "Fixation de session possible : l'identifiant n'a pas change"


def test_page_login_redirige_si_deja_connecte(admin):
    response = admin.get(url("login"), timeout=10)

    assert "page=adminDashboard" in response.url


def test_ancienne_session_inutilisable_apres_deconnexion(admin):
    session_volee = admin.cookies.get(COOKIE_SESSION)

    admin.get(url("logout"), timeout=10)

    # Un "pirate" qui aurait copie le cookie avant la deconnexion
    with requests.Session() as pirate:
        pirate.cookies.set(COOKIE_SESSION, session_volee)
        response = pirate.get(url("adminDashboard"), timeout=10)

    assert "page=login" in response.url