# =========================================================
# FICHIER : siteVitrine/tests/test_comparateur.py
# Accueil - comparateur Réel / BIM :
#   - les deux images existent et ont EXACTEMENT les mêmes dimensions
#     (sinon les équipements ne se superposent plus)
#   - la page les utilise bien
# =========================================================

import struct
from pathlib import Path

from bs4 import BeautifulSoup

from conftest import RACINE_PROJET, url

IMAGES = RACINE_PROJET / "assets" / "images"
REEL = IMAGES / "comparateur-reel.png"
BIM = IMAGES / "comparateur-bim.png"


def _taille_png(chemin: Path) -> tuple[int, int]:
    """Lit largeur x hauteur dans l'en-tête PNG (sans bibliothèque d'image)."""
    data = chemin.read_bytes()[:24]
    assert data[:8] == b"\x89PNG\r\n\x1a\n", f"{chemin.name} n'est pas un PNG"
    return struct.unpack(">II", data[16:24])


def test_les_deux_images_existent():
    assert REEL.exists(), "assets/images/comparateur-reel.png manquant"
    assert BIM.exists(), "assets/images/comparateur-bim.png manquant"


def test_les_deux_images_ont_les_memes_dimensions():
    assert _taille_png(REEL) == _taille_png(BIM), "Les 2 images doivent avoir le même format pour être alignées"


def test_format_3_2_comme_le_cadre():
    largeur, hauteur = _taille_png(REEL)
    assert abs(largeur / hauteur - 3 / 2) < 0.01, "Le cadre CSS du comparateur est en 3/2"


def test_la_page_utilise_la_paire(client):
    soup = BeautifulSoup(client.get(url("accueil"), timeout=10).text, "html.parser")
    sources = {img["src"] for img in soup.select("[data-comparateur] img")}

    assert sources == {"assets/images/comparateur-reel.png", "assets/images/comparateur-bim.png"}