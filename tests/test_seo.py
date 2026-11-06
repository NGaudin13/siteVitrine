# =========================================================
# FICHIER : siteVitrine/tests/test_seo.py
# Etape 4 - referencement et navigation :
#   - chaque page a SON titre et SA description
#   - URL canonique correcte (plus de "localhost" en dur)
#   - tous les liens du menu "Services" menent a une vraie ancre
#   - l'admin n'est pas indexe par Google
# =========================================================

import re

import pytest
from bs4 import BeautifulSoup

from conftest import url

PAGES_PUBLIQUES = ["accueil", "presentation", "service", "contact", "conditions", "confidentialite", "mentions"]


def _soup(client, page):
    return BeautifulSoup(client.get(url(page), timeout=10).text, "html.parser")


# ---------------------------------------------------------
# Titres et descriptions
# ---------------------------------------------------------

def test_chaque_page_a_un_titre_different(client):
    titres = {page: _soup(client, page).title.text.strip() for page in PAGES_PUBLIQUES}

    assert all(titres.values()), titres
    assert len(set(titres.values())) == len(PAGES_PUBLIQUES), f"Titres en double : {titres}"


@pytest.mark.parametrize("page", PAGES_PUBLIQUES)
def test_chaque_page_a_une_description(client, page):
    meta = _soup(client, page).find("meta", {"name": "description"})

    assert meta is not None
    assert len(meta["content"].strip()) >= 30


@pytest.mark.parametrize("page", PAGES_PUBLIQUES)
def test_url_canonique_pointe_vers_la_page(client, page):
    canonique = _soup(client, page).find("link", {"rel": "canonical"})["href"]

    assert canonique.startswith("http")
    assert canonique.endswith(f"?page={page}")


def test_page_404_a_son_propre_titre(client):
    assert "introuvable" in _soup(client, "nimportequoi").title.text.lower()


# ---------------------------------------------------------
# Liens internes
# ---------------------------------------------------------

def test_liens_vers_les_services_menent_a_une_vraie_ancre(client):
    ancres_existantes = {el["id"] for el in _soup(client, "service").find_all(id=True)}

    liens = set()
    for page in ["accueil", "service", "contact"]:
        for a in _soup(client, page).find_all("a", href=True):
            m = re.search(r"page=service#([\w-]+)", a["href"])
            if m:
                liens.add(m.group(1))

    assert liens, "Aucun lien vers les services trouve"
    cassés = liens - ancres_existantes
    assert not cassés, f"Liens vers des ancres inexistantes : {cassés}"


def test_le_menu_ne_pointe_plus_vers_une_page_inexistante(client):
    html = client.get(url("accueil"), timeout=10).text

    assert "page=expertise" not in html


# ---------------------------------------------------------
# Admin non indexe
# ---------------------------------------------------------

def test_admin_interdit_aux_moteurs_de_recherche(admin):
    response = admin.get(url("adminDashboard"), timeout=10)

    assert "noindex" in response.headers.get("X-Robots-Tag", "")


def test_accueil_a_un_seul_titre_principal(client):
    """Le bandeau a un seul h1, qui dit ce que fait l'entreprise."""
    h1 = _soup(client, "accueil").find_all("h1")

    assert len(h1) == 1
    assert "BIM" in h1[0].get_text()