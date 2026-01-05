<?php
// Footer
?>

<!-- ================= FOOTER ================= -->
<div class="container-fluid bg-dark text-body footer mt-5 pt-3 px-0">
    <div class="container py-5">
        <div class="row g-5">

            <!-- Adresse / Contact -->
            <div class="col-lg-3 col-md-6">
                <h3 class="text-light mb-4">Adresse</h3>

                <p class="mb-2">
                    <i class="fa fa-map-marker-alt text-primary me-3"></i>
                    Lyon, 69100 Villeurbanne, FR
                </p>

                <p class="mb-2">
                    <i class="fa fa-phone-alt text-primary me-3"></i>
                    +33 6 12 34 56 78
                </p>

                <p class="mb-2">
                    <i class="fa fa-envelope text-primary me-3"></i>
                    contact@nbsolutions.fr
                </p>

                <div class="d-flex pt-2">
                    <a class="btn btn-square btn-outline-body me-1" href="#" target="_blank">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a class="btn btn-square btn-outline-body me-1" href="#" target="_blank">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a class="btn btn-square btn-outline-body me-1" href="#" target="_blank">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a class="btn btn-square btn-outline-body me-0" href="#" target="_blank">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>

            <!-- Services -->
            <div class="col-lg-3 col-md-6">
                <h3 class="text-light mb-4">Services</h3>

                <a class="btn btn-link" href="index.php?page=expertise">Ingénierie BIM</a>
                <a class="btn btn-link" href="index.php?page=expertise">Modélisation 3D</a>
                <a class="btn btn-link" href="index.php?page=expertise">Études techniques</a>
                <a class="btn btn-link" href="index.php?page=expertise">Coordination de projet</a>
                <a class="btn btn-link" href="index.php?page=expertise">Assistance MOE</a>
            </div>

            <!-- Liens utiles -->
            <div class="col-lg-3 col-md-6">
                <h3 class="text-light mb-4">Liens utiles</h3>

                <a class="btn btn-link" href="index.php?page=presentation">À propos</a>
                <a class="btn btn-link" href="index.php?page=contact">Contact</a>
                <a class="btn btn-link" href="index.php?page=expertise">Nos services</a>
                <a class="btn btn-link" href="index.php?page=conditions">Conditions générales</a>
                <a class="btn btn-link" href="index.php?page=confidentialite">Confidentialité</a>
            </div>

            <!-- Call To Action -->
            <div class="col-lg-3 col-md-6">
                <h3 class="text-light mb-4">Contactez-nous</h3>

                <p class="mb-3">
                    Vous pouvez nous contacter directement via WhatsApp.
                </p>

                <a
                    href="https://wa.me/33612345678"
                     class="btn btn-success py-2 px-4"
                    target="_blank"
                >
                    <i class="fab fa-whatsapp me-2"></i>
                    Appeler-Nous
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
                        NBsolutions
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ================= JS ================= -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
