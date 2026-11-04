# =========================================================
# FICHIER : siteVitrine/tests/test_fiabilite_admin.py
# Etape 5 - fiabilite du back-office :
#   - l'ordre des domaines choisi dans l'admin est respecte sur le site
#   - une sauvegarde refusee ne modifie RIEN (tout ou rien)
#   - les envois d'images dangereux ou invalides sont refuses
# =========================================================

import re
import struct
import zlib
from pathlib import Path

import pytest
from bs4 import BeautifulSoup

from conftest import RACINE_PROJET, envoyer_formulaire, lire_formulaire, url

pytestmark = pytest.mark.admin


# ---------------------------------------------------------
# Aides
# ---------------------------------------------------------

def _titres_domaines(client) -> list[str]:
    soup = BeautifulSoup(client.get(url("accueil"), timeout=10).text, "html.parser")
    return [h3.text.strip() for h3 in soup.select(".domain-card__overlay h3")]


def _sujets_contact(client) -> list[str]:
    soup = BeautifulSoup(client.get(url("contact"), timeout=10).text, "html.parser")
    return [o.text.strip() for o in soup.select("#subject option") if o.get("value")]


def _formulaire(admin, page, **params) -> dict:
    return lire_formulaire(admin.get(url(page, **params), timeout=10).text)


def _regrouper(data: dict, nom: str) -> tuple[dict, list[tuple[int, dict]]]:
    """Separe les champs 'nom[i][x]' du reste. Renvoie (autres, [(i, ligne), ...])."""
    autres, lignes = {}, {}
    for cle, valeur in data.items():
        m = re.fullmatch(rf"{nom}\[(\d+)\]\[(\w+)\]", cle)
        if m:
            lignes.setdefault(int(m.group(1)), {})[m.group(2)] = valeur
        else:
            autres[cle] = valeur
    return autres, sorted(lignes.items())


def _reconstruire(autres: dict, nom: str, lignes: list[tuple[int, dict]]) -> dict:
    """Recree le formulaire avec les lignes DANS L'ORDRE de la liste.

    Comme dans le navigateur : les fleches de l'admin deplacent les lignes
    mais gardent leur numero d'origine (domains[3] peut arriver en premier).
    """
    data = dict(autres)
    for i, ligne in lignes:
        for champ, valeur in ligne.items():
            data[f"{nom}[{i}][{champ}]"] = valeur
    return data


def _png_minuscule() -> bytes:
    """Une vraie image PNG de 1x1 pixel, fabriquee en memoire."""
    def bloc(type_, donnees):
        return struct.pack(">I", len(donnees)) + type_ + donnees + struct.pack(">I", zlib.crc32(type_ + donnees))
    return (b"\x89PNG\r\n\x1a\n"
            + bloc(b"IHDR", struct.pack(">IIBBBBB", 1, 1, 8, 2, 0, 0, 0))
            + bloc(b"IDAT", zlib.compress(b"\x00\xff\x00\x00"))
            + bloc(b"IEND", b""))


# ---------------------------------------------------------
# Ordre des domaines
# ---------------------------------------------------------

def test_ordre_des_domaines_respecte_sur_le_site(admin):
    params = {"section": "home-domains"}
    origine = _formulaire(admin, "adminAccueil", **params)
    autres, domaines = _regrouper(origine, "domains")
    assert len(domaines) >= 2, "Il faut au moins 2 domaines pour tester l'ordre"

    titres_avant = _titres_domaines(admin)
    inverse = list(reversed(domaines))

    try:
        envoyer_formulaire(admin, "adminAccueil", _reconstruire(autres, "domains", inverse), **params)
        assert _titres_domaines(admin) == list(reversed(titres_avant))
    finally:
        envoyer_formulaire(admin, "adminAccueil", origine, **params)

    assert _titres_domaines(admin) == titres_avant


# ---------------------------------------------------------
# Tout ou rien
# ---------------------------------------------------------

def test_domaine_invalide_ne_supprime_aucun_domaine(admin):
    """Avant : les domaines etaient desactives AVANT la validation -> perte de contenu."""
    params = {"section": "home-domains"}
    autres, domaines = _regrouper(_formulaire(admin, "adminAccueil", **params), "domains")
    titres_avant = _titres_domaines(admin)

    domaines[-1][1]["desc"] = ""     # la DERNIERE carte est invalide
    response = envoyer_formulaire(admin, "adminAccueil", _reconstruire(autres, "domains", domaines), **params)

    assert "obligatoires" in response.text
    assert _titres_domaines(admin) == titres_avant, "Des domaines ont disparu du site"


def test_aucun_sujet_ne_vide_pas_le_formulaire_de_contact(admin):
    """Avant : tous les sujets etaient desactives puis l'erreur s'affichait."""
    params = {"section": "contact-nature-demande"}
    autres, _ = _regrouper(_formulaire(admin, "adminContact", **params), "subjects")
    sujets_avant = _sujets_contact(admin)

    response = envoyer_formulaire(admin, "adminContact", autres, **params)   # zero sujet

    assert "Ajoutez au moins un sujet" in response.text
    assert _sujets_contact(admin) == sujets_avant


def test_parcours_invalide_ne_modifie_rien(admin):
    params = {"section": "presentation-path"}
    origine = _formulaire(admin, "adminPresentation", **params)
    page_avant = admin.get(url("presentation"), timeout=10).text

    modifie = dict(origine, col1_title="", col3_title="TITRE-QUI-NE-DOIT-PAS-APPARAITRE")
    response = envoyer_formulaire(admin, "adminPresentation", modifie, **params)

    assert "obligatoires" in response.text
    assert "TITRE-QUI-NE-DOIT-PAS-APPARAITRE" not in admin.get(url("presentation"), timeout=10).text
    assert admin.get(url("presentation"), timeout=10).text == page_avant


def test_ajout_d_un_sujet_avec_accents(admin):
    params = {"section": "contact-nature-demande"}
    origine = _formulaire(admin, "adminContact", **params)
    autres, sujets = _regrouper(origine, "subjects")

    nouveau = (len(sujets) + 1, {"label": "Étude spécifique", "value": "", "order": "999", "active": "1"})
    try:
        envoyer_formulaire(admin, "adminContact", _reconstruire(autres, "subjects", sujets + [nouveau]), **params)
        html = admin.get(url("contact"), timeout=10).text
        assert 'value="etude-specifique"' in html
        assert "Étude spécifique" in _sujets_contact(admin)
    finally:
        envoyer_formulaire(admin, "adminContact", origine, **params)


# ---------------------------------------------------------
# Envoi d'images
# ---------------------------------------------------------

@pytest.mark.parametrize("nom, contenu", [
    ("photo.jpg", b"ceci n'est pas une image"),
    ("photo.jpg", b"<?php echo 'pirate'; ?>"),
    ("script.php", b"<?php echo 'pirate'; ?>"),
])
def test_faux_fichiers_image_refuses(admin, nom, contenu):
    params = {"section": "home-intro"}
    origine = _formulaire(admin, "adminAccueil", **params)
    fichiers_avant = set((RACINE_PROJET / "assets" / "images").iterdir())

    response = envoyer_formulaire(admin, "adminAccueil", origine,
                                  fichiers={"image_file": (nom, contenu)}, **params)

    assert "Format non autorisé" in response.text
    assert _formulaire(admin, "adminAccueil", **params)["image_src"] == origine["image_src"]
    assert set((RACINE_PROJET / "assets" / "images").iterdir()) == fichiers_avant, "Fichier ecrit sur le disque"


def test_vraie_image_acceptee_avec_un_nom_genere(admin):
    params = {"section": "home-intro"}
    origine = _formulaire(admin, "adminAccueil", **params)
    nouveau_fichier = None

    try:
        envoyer_formulaire(admin, "adminAccueil", origine,
                           fichiers={"image_file": ("../../index.php", _png_minuscule(), "image/png")},
                           **params)

        src = _formulaire(admin, "adminAccueil", **params)["image_src"]
        nouveau_fichier = RACINE_PROJET / src

        # Nom genere par le serveur, extension imposee, dans le bon dossier
        assert re.fullmatch(r"assets/images/accueil_home-intro_\d{8}_\d{6}_[0-9a-f]{6}\.png", src), src
        assert nouveau_fichier.exists()
        assert src in admin.get(url("accueil"), timeout=10).text
    finally:
        envoyer_formulaire(admin, "adminAccueil", origine, **params)
        if nouveau_fichier and nouveau_fichier.exists():
            nouveau_fichier.unlink()     # on ne laisse pas d'image de test dans le projet