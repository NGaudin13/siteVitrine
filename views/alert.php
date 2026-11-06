<?php
// =========================================================
// FICHIER : siteVitrine/views/alert.php
// =========================================================

// Variables fournies par le contrôleur qui inclut cette vue
// (déclarées ici pour VS Code / Intelephense).
/** @var array|null $alert */

if(isset($alert))
{
?>
	<div class="alert alert-<?= isset($alert['classAlert']) ? $alert['classAlert'] : 'danger' ?>">
		<strong><?= $alert['messageAlert'] ?></strong>
	</div>
<?php
}