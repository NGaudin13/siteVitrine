<?php
    // Footer
?>

</main>
<!-- ================= FOOTER ================= -->
<div class="container-fluid bg-dark text-body footer mt-5 pt-3 px-0">
    <div class="container py-5">
        <div class="row g-5">

            <!-- Adresse / Contact -->
            <div class="col-lg-3 col-md-6">
                <h3 class="text-light mb-4">Adresse</h3>

                <p class="mb-2 d-flex justify-content-lg-end">
                    <i class="fa fa-map-marker-alt text-primary me-3"></i>
                    110 cours Tolstoï, 69100 Villeurbanne, FR
                </p>

                <p class="mb-2">
                    <i class="fa fa-phone-alt text-primary me-3"></i>
                    +33 7 66 80 16 68
                </p>

                <p class="mb-2">
                    <i class="fa fa-envelope text-primary me-3"></i>
                    contact@oflabim.fr
                </p>

                <div class="d-flex pt-2">
                    <a class="btn btn-square btn-outline-body me-0" href="#" target="_blank">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>

            <!-- Services -->
            <div class="col-lg-3 col-md-6">
                <h3 class="text-light mb-4">Services</h3>

                <a class="btn btn-link" href="index.php?page=service#bim">Ingénierie BIM</a>
                <a class="btn btn-link" href="index.php?page=service#beton">Structures béton</a>
                <a class="btn btn-link" href="index.php?page=service#metal">Structures métalliques</a>
                <a class="btn btn-link" href="index.php?page=service#bois">Ossature bois</a>
            </div>

            <!-- Liens utiles -->
            <div class="col-lg-3 col-md-6">
                <h3 class="text-light mb-4">Liens utiles</h3>

                <a class="btn btn-link" href="index.php?page=presentation">À propos</a>
                <a class="btn btn-link" href="index.php?page=contact">Contact</a>
                <a class="btn btn-link" href="index.php?page=service">Nos services</a>
                <a class="btn btn-link" href="index.php?page=conditions">Conditions générales</a>
                <a class="btn btn-link" href="index.php?page=confidentialite">Confidentialité</a>
            </div>

            <!-- Call To Action -->
            <div class="col-lg-3 col-md-6">
                <h3 class="text-light mb-4">Contactez-nous</h3>

                <p class="mb-3">
                    Vous pouvez nous contacter directement par téléphone.
                </p>

                <a
                    href="tel:+33766801668"
                    class="btn btn-success py-2 px-4"
                    aria-label="Appeler OFLABIM"
                >
                    <i class="fa fa-phone-alt me-2"></i>
                    Nous joindre
                </a>
            </div>

        </div>
    </div>

    <!-- Copyright -->
    <div class="container-fluid copyright">
        <div class="container">
            <div class="row">
                <div class="text-center text-md-center mb-3">
                    © <?= date('Y') ?> NBsolutions —
                    Réalisé par
                    <a href="#" class="text-decoration-none text-light">
                        NBsolutions - BERTRAND Baptiste -  GAUDIN Nicolas
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ================= JS ================= -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="assets/scripts/services-swiper.js"></script>

</body>
</html>
