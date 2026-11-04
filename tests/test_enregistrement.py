# =========================================================
# FICHIER : siteVitrine/tests/test_enregistrement.py
# Enregistrement REEL en base, verifie sur le site public.
#
# Chaque test :
#   1) lit le formulaire admin (valeurs actuelles + jeton CSRF)
#   2) modifie UN champ avec un marqueur unique
#   3) verifie que le marqueur apparait sur la page publique
#   4) remet TOUJOURS la valeur d'origine (bloc finally),
#      meme si le test echoue.
# =========================================================

import uuid
from contextlib import contextmanager

import pytest
from bs4 import BeautifulSoup

from conftest import assert_no_php_error, url

pytestmark = pytest.mark.admin


def _lire_formulaire(html: str) -> dict:
    """Recupere tous les champs du formulaire POST (jeton CSRF compris)."""
    soup = BeautifulSoup(html, "html.parser")
    jeton = soup.find("input", {"name": "csrf_token"})
    assert jeton is not None, "Formulaire sans jeton CSRF"
    form = jeton.find_parent("form")

    data = {}
    for champ in form.find_all(["input", "textarea"]):
        nom = champ.get("name")
        if not nom or champ.get("type") == "file":
            continue
        data[nom] = champ.text if champ.name == "textarea" else champ.get("value", "")
    return data


def _envoyer(admin, page, data, **params):
    """Recharge le formulaire pour un jeton frais, puis envoie `data`."""
    adresse = url(page, **params)
    data = dict(data, csrf_token=_lire_formulaire(admin.get(adresse, timeout=10).text)["csrf_token"])
    response = admin.post(adresse, data=data, timeout=10)
    assert_no_php_error(response)
    return response


@contextmanager
def _modification_temporaire(admin, page, champ, **params):
    """Modifie `champ` avec un marqueur unique, puis restaure l'original."""
    origine = _lire_formulaire(admin.get(url(page, **params), timeout=10).text)
    marqueur = f"TEST-{uuid.uuid4().hex[:8]}"

    modifie = dict(origine)
    modifie[champ] = f"{origine[champ]} {marqueur}".strip()

    try:
        _envoyer(admin, page, modifie, **params)
        yield marqueur
    finally:
        _envoyer(admin, page, origine, **params)


# ---------------------------------------------------------
# Tests
# ---------------------------------------------------------

def test_titre_accueil_enregistre_et_affiche(admin):
    with _modification_temporaire(admin, "adminAccueil", "title", section="home-intro") as marqueur:
        assert marqueur in admin.get(url("accueil"), timeout=10).text

    assert marqueur not in admin.get(url("accueil"), timeout=10).text, "Valeur d'origine non restauree"


def test_texte_a_propos_enregistre_et_affiche(admin):
    with _modification_temporaire(admin, "adminAccueil", "text_1", section="home-about") as marqueur:
        assert marqueur in admin.get(url("accueil"), timeout=10).text

    assert marqueur not in admin.get(url("accueil"), timeout=10).text


def test_titre_parcours_presentation_enregistre_et_affiche(admin):
    with _modification_temporaire(admin, "adminPresentation", "col1_title", section="presentation-path") as marqueur:
        assert marqueur in admin.get(url("presentation"), timeout=10).text

    assert marqueur not in admin.get(url("presentation"), timeout=10).text


def test_horaires_enregistres_et_affiches_sur_contact(admin):
    with _modification_temporaire(admin, "adminDashboard", "opening_hours") as marqueur:
        assert marqueur in admin.get(url("contact"), timeout=10).text

    assert marqueur not in admin.get(url("contact"), timeout=10).text


def test_nouveau_sujet_de_contact_apparait_dans_la_liste(admin):
    params = {"section": "contact-nature-demande"}
    origine = _lire_formulaire(admin.get(url("adminContact", **params), timeout=10).text)

    # Ajoute une ligne "subjects[N]" apres les sujets existants
    numeros = [int(k.split("[")[1].split("]")[0]) for k in origine if k.startswith("subjects[")]
    n = max(numeros, default=0) + 1
    libelle = f"Sujet TEST-{uuid.uuid4().hex[:6]}"

    modifie = dict(origine)
    modifie.update({
        f"subjects[{n}][label]": libelle,
        f"subjects[{n}][value]": "",          # genere automatiquement depuis le libelle
        f"subjects[{n}][order]": str(n * 10),
        f"subjects[{n}][active]": "1",
    })

    try:
        _envoyer(admin, "adminContact", modifie, **params)
        assert libelle in admin.get(url("contact"), timeout=10).text
    finally:
        _envoyer(admin, "adminContact", origine, **params)

    assert libelle not in admin.get(url("contact"), timeout=10).text