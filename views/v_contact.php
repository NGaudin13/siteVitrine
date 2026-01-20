<?php
// SEO (si ton controller ne les définit pas déjà)
$pageTitle = $pageTitle ?? "Contact | OFLABIM";
$metaDesc  = $metaDesc  ?? "Contactez OFLABIM : bureau d’études & ingénierie (BIM, structures). Demande de devis, questions, prise de rendez-vous.";
$canonical = $canonical ?? "http://localhost/siteVitrine/index.php?page=contact";

require_once(PATH_VIEWS . 'header.php');
?>

<?php require_once(PATH_VIEWS . 'alert.php'); ?>

<!-- ================= PAGE CONTACT / HEADER ================= -->
<section
  class="header-contact page-header-contact mt-4 py-5 mb-5"
  style="
    background-image: url('https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=1600&q=80');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
   "
  >
  <div class="container py-5">

    <h1 class="display-5 text-white mb-3">
      Contact
    </h1>

    <p class="lead text-white-50 mb-4" style="max-width: 700px;">
      Une question, un besoin BIM ou structure ?  
      Décrivez votre projet, on vous répond rapidement.
    </p>

    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">

      <!-- Breadcrumb -->
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb text-uppercase mb-0">
          <li class="breadcrumb-item">
            <a
              class="text-white-50 text-decoration-none"
              href="index.php?page=accueil"
            >
              Accueil
            </a>
          </li>
          <li class="breadcrumb-item text-white active" aria-current="page">
            Contact
          </li>
        </ol>
      </nav>

      <!-- CTA WhatsApp -->
      <a
        href="https://wa.me/33766801668"
        class="btn btn-success btn-lg d-inline-flex align-items-center"
        target="_blank"
        rel="noopener noreferrer"
      >
        <i class="fab fa-whatsapp me-2"></i>
        Nous-Joindre
      </a>

    </div>
  </div>
</section>

<!-- ================= CONTACT CONTENT ================= -->
<section id=contact-content class="contact-content py-3">
  <div class="container">

    <div class="text-center mx-auto mb-3" style="max-width: 700px;">
      <h2 class="h4 mb-2">Nous contacter</h2>
      <p class="text-muted mb-0">
        Vous avez une question ou souhaitez un devis ? Remplissez le formulaire, nous vous répondrons rapidement.
      </p>
    </div><br>

    <div class="row g-5">

      <!-- ===== LEFT: COORDONNÉES (icône à gauche, texte à droite, XS safe) ===== -->
      <div class="col-lg-6">
        <div class="d-flex flex-column justify-content-between h-100">

          <!-- Téléphone -->
          <div class="bg-light d-flex align-items-center w-100 p-3 p-sm-4 mb-4 rounded-3">
            <div class="d-flex flex-shrink-0 align-items-center justify-content-center bg-dark rounded"
                 style="width:55px;height:55px;">
              <i class="fa fa-phone-alt text-white"></i>
            </div>
            <div class="ms-3 ms-sm-4 flex-grow-1" style="min-width:0;">
              <p class="mb-1 text-muted">Téléphone</p>
              <a class="fw-semibold text-decoration-none text-break d-block" href="tel:+33766801668">
                +33 7 66 80 16 68
              </a>
            </div>
          </div>

          <!-- Email -->
          <div class="bg-light d-flex align-items-center w-100 p-3 p-sm-4 mb-4 rounded-3">
            <div class="d-flex flex-shrink-0 align-items-center justify-content-center bg-dark rounded"
                 style="width:55px;height:55px;">
              <i class="fa fa-envelope-open text-white"></i>
            </div>
            <div class="ms-3 ms-sm-4 flex-grow-1" style="min-width:0;">
              <p class="mb-1 text-muted">Email</p>
              <a class="fw-semibold text-decoration-none text-break d-block" href="mailto:contact@oflabim.fr">
                contact@oflabim.fr
              </a>
            </div>
          </div>

          <!-- Zone d’intervention -->
          <div class="bg-light d-flex align-items-center w-100 p-3 p-sm-4 mb-4 rounded-3">
            <div class="d-flex flex-shrink-0 align-items-center justify-content-center bg-dark rounded"
                 style="width:55px;height:55px;">
              <i class="fa fa-map-marker-alt text-white"></i>
            </div>
            <div class="ms-3 ms-sm-4 flex-grow-1" style="min-width:0;">
              <p class="mb-1 text-muted">Zone d’intervention</p>
              <div class="fw-semibold text-break">
                France – interventions à distance possibles
              </div>
            </div>
          </div>

          <!-- Horaires + liens -->
          <div class="bg-light d-flex align-items-start w-100 p-3 p-sm-4 rounded-3">
            <div class="d-flex flex-shrink-0 align-items-center justify-content-center bg-dark rounded"
                 style="width:55px;height:55px;">
              <i class="fa fa-clock text-white"></i>
            </div>

            <div class="ms-3 ms-sm-4 flex-grow-1" style="min-width:0;">
              <p class="mb-1 text-muted">Horaires</p>
              <div class="fw-semibold">Lun – Ven : 9h00 – 18h00</div>
              <div class="text-muted">Réponse sous 24–48h ouvrées</div>
            </div>
          </div>

        </div>
      </div>

      <!-- ===== RIGHT: FORMULAIRE ===== -->
      <div class="col-lg-6">
        <p class="mb-4 text-muted">
          Décrivez votre besoin (BIM, structure, étude…). Nous revenons vers vous sous 24–48h ouvrées.
        </p>

        <form method="post" action="index.php?page=contact">
          <div class="row g-3">

            <div class="col-md-6">
              <label class="form-label" for="name">Nom</label>
              <input class="form-control" id="name" name="name" type="text" required>
            </div>

            <div class="col-md-6">
              <label class="form-label" for="email">Email</label>
              <input class="form-control" id="email" name="email" type="email" required>
            </div>

            <div class="col-md-6">
              <label class="form-label" for="phone">Téléphone (optionnel)</label>
              <input class="form-control" id="phone" name="phone" type="tel" placeholder="+33…">
            </div>

            <div class="col-md-6">
              <label class="form-label" for="subject">Sujet</label>
              <select class="form-select" id="subject" name="subject" required>
                <option value="" selected disabled>Choisir…</option>
                <option value="devis">Demande de devis</option>
                <option value="rdv">Prise de rendez-vous</option>
                <option value="bim">Ingénierie BIM</option>
                <option value="autre">Autre</option>
              </select>
            </div>

            <div class="col-12">
              <label class="form-label" for="message">Message</label>
              <textarea class="form-control" id="message" name="message" rows="6" required></textarea>
            </div>

            <div class="col-12">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="rgpd" name="rgpd" required>
                <label class="form-check-label" for="rgpd">
                  J’accepte que mes informations soient utilisées pour être recontacté.
                </label>
              </div>
            </div>

            <div class="col-12">
              <button class="btn btn-primary w-100 py-3" type="submit">
                Envoyer le message
              </button>
            </div>

            <div class="col-12">
              <a
                class="btn btn-outline-success w-100 py-3 d-inline-flex align-items-center justify-content-center"
                href="https://wa.me/33766801668"
                target="_blank"
                rel="noopener noreferrer"
              >
                <i class="fab fa-whatsapp me-2"></i>
                WhatsApp
              </a>
            </div>

          </div>
        </form>

        <small class="text-muted d-block mt-3">
          * Les informations envoyées ne sont utilisées que pour répondre à votre demande.
        </small>
      </div>

    </div>
  </div>
</section>

<!-- ================= CONTACT / LOCALISATION ================= -->
<section class="contact-location py-5">
  <div class="container">

    <div class="contact-location__head text-center mx-auto mb-4" style="max-width: 720px;">
      <h2 class="h4 mb-2">Nous localiser</h2>
      <p class="text-muted mb-0">
        Retrouvez-nous sur la carte. Interventions en France, et à distance selon les projets.
      </p>
    </div>

    <div class="row g-4 align-items-stretch">

      <!-- Infos -->
      <div class="col-lg-4">
        <div class="contact-location__info h-100 bg-light p-4 rounded-3">
          <h3 class="h6 mb-3">Adresse</h3>

          <div class="d-flex gap-3 mb-3">
            <div class="contact-location__icon d-flex align-items-center justify-content-center bg-dark rounded"
                 style="width:42px;height:42px;">
              <i class="fa fa-map-marker-alt text-white"></i>
            </div>
            <div>
              <div class="fw-semibold">OFLABIM</div>
              <div class="text-muted">
                110 cours Tolstoï<br>
                69100 Villeurbanne, France
              </div>
            </div>
          </div>

          <div class="d-flex gap-3 mb-3">
            <div class="contact-location__icon d-flex align-items-center justify-content-center bg-dark rounded"
                 style="width:42px;height:42px;">
              <i class="fa fa-phone-alt text-white"></i>
            </div>
            <div>
              <div class="fw-semibold">Téléphone</div>
              <a class="text-decoration-none" href="tel:+33766801668">+33 7 66 80 16 68</a>
            </div>
          </div>

          <div class="d-flex gap-3">
            <div class="contact-location__icon d-flex align-items-center justify-content-center bg-dark rounded"
                 style="width:42px;height:42px;">
              <i class="fa fa-envelope text-white"></i>
            </div>
            <div>
              <div class="fw-semibold">Email</div>
              <a class="text-decoration-none" href="mailto:contact@oflabim.fr">contact@oflabim.fr</a>
            </div>
          </div>

          <hr class="my-4">

          <a
            class="btn btn-outline-primary w-100 d-inline-flex align-items-center justify-content-center"
            href="https://www.google.com/maps?q=110+cours+Tolsto%C3%AF,+69100+Villeurbanne"
            target="_blank"
            rel="noopener noreferrer"
          >
            <i class="fa fa-directions me-2"></i>
            Itinéraire Google Maps
          </a>
        </div>
      </div>

      <!-- Carte -->
      <div class="col-lg-8">
        <div class="contact-location__map bg-light rounded-3 overflow-hidden h-100">
          <div class="contact-location__map-inner ratio ratio-16x9">
            <iframe
              title="Carte - OFLABIM"
              loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"
              src="https://www.google.com/maps?q=110%20cours%20Tolsto%C3%AF%2069100%20Villeurbanne&output=embed"
              allowfullscreen
            ></iframe>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>



<?php require_once(PATH_VIEWS . 'footer.php'); ?>
