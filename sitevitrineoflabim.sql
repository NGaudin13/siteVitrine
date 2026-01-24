-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 24 jan. 2026 à 01:46
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `sitevitrineoflabim`
--

-- --------------------------------------------------------

--
-- Structure de la table `content_block`
--

CREATE TABLE `content_block` (
  `id` int(10) UNSIGNED NOT NULL,
  `section_id` int(10) UNSIGNED NOT NULL,
  `type` enum('h1','h2','h3','p','span','badge','img','link','button','iframe','list_item','html') NOT NULL DEFAULT 'p',
  `slot` varchar(60) DEFAULT NULL,
  `text` mediumtext DEFAULT NULL,
  `src` varchar(255) DEFAULT NULL,
  `alt` varchar(255) DEFAULT NULL,
  `href` varchar(255) DEFAULT NULL,
  `order_index` int(11) NOT NULL DEFAULT 10,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `content_block`
--

INSERT INTO `content_block` (`id`, `section_id`, `type`, `slot`, `text`, `src`, `alt`, `href`, `order_index`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 2, 'h2', 'title', 'Le BIM, au cœur de la coordination de vos projets', NULL, NULL, NULL, 10, 1, '2026-01-21 20:22:18', '2026-01-24 01:11:48'),
(2, 2, 'p', 'text_1', 'Le BIM (Building Information Modeling) repose sur une maquette numérique 3D qui centralise l’ensemble des données techniques du projet. Elle devient une base commune de travail pour tous les intervenants.', NULL, NULL, NULL, 20, 1, '2026-01-21 20:22:18', '2026-01-24 01:11:48'),
(3, 2, 'p', 'text_2', 'Cette approche collaborative permet de mieux anticiper les contraintes, d’aligner les décisions techniques et de fiabiliser les échanges tout au long du projet, de la conception au chantier. La maquette BIM ne se limite pas à un modèle 3D : elle intègre l’ensemble des données techniques du bâtiment (matériaux, quantités, performances, coûts, planning), faisant de l’ingénieur BIM le garant de la cohérence, de la qualité et de la gestion des informations du projet.', NULL, NULL, NULL, 30, 1, '2026-01-21 20:22:18', '2026-01-24 01:11:48'),
(4, 2, 'img', 'image', NULL, 'assets/images/accueil_homeBim2.jpg', 'Coordination BIM et travail collaboratif autour d’une maquette numérique', NULL, 40, 1, '2026-01-21 20:22:18', '2026-01-24 01:11:48'),
(15, 4, 'h2', 'title', 'À propos de nous', NULL, NULL, NULL, 10, 1, '2026-01-24 00:15:43', '2026-01-24 01:12:18'),
(16, 4, 'p', 'text_1', 'OFLABIM accompagne vos projets de construction avec une approche claire et rigoureuse : modélisation BIM, coordination, études techniques et optimisation des solutions.', NULL, NULL, NULL, 20, 1, '2026-01-24 00:15:43', '2026-01-24 01:12:18'),
(17, 4, 'p', 'text_2', 'Notre objectif : sécuriser les décisions, réduire les risques et livrer un résultat exploitable par tous les acteurs du projet.', NULL, NULL, NULL, 30, 1, '2026-01-24 00:15:43', '2026-01-24 01:12:18'),
(18, 4, 'img', 'image', NULL, 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?auto=format&fit=crop&w=1400&q=70', 'Bureau d’études et ingénierie BIM', NULL, 40, 1, '2026-01-24 00:15:43', '2026-01-24 01:12:18'),
(161, 18, 'h2', 'col1_title', 'Réalisations & expérience', NULL, NULL, NULL, 10, 1, '2026-01-24 01:42:54', '2026-01-24 01:42:54'),
(162, 18, 'p', 'col1_intro', 'Des missions menées sur le terrain, avec une approche orientée coordination, méthode et livrables fiables.', NULL, NULL, NULL, 20, 1, '2026-01-24 01:42:54', '2026-01-24 01:42:54'),
(163, 18, 'span', 'timeline_1_title', 'Coordination BIM', NULL, NULL, NULL, 110, 1, '2026-01-24 01:42:54', '2026-01-24 01:42:54'),
(164, 18, 'p', 'timeline_1_desc', 'Pilotage de maquettes, coordination multi-lots, synthèse.', NULL, NULL, NULL, 111, 1, '2026-01-24 01:42:54', '2026-01-24 01:42:54'),
(165, 18, 'span', 'timeline_1_date', '2012 – Aujourd’hui', NULL, NULL, NULL, 112, 1, '2026-01-24 01:42:54', '2026-01-24 01:42:54'),
(166, 18, 'span', 'timeline_2_title', 'Ingénierie structure', NULL, NULL, NULL, 120, 1, '2026-01-24 01:42:54', '2026-01-24 01:42:54'),
(167, 18, 'p', 'timeline_2_desc', 'Études techniques, notes de calcul, optimisation structure.', NULL, NULL, NULL, 121, 1, '2026-01-24 01:42:54', '2026-01-24 01:42:54'),
(168, 18, 'span', 'timeline_2_date', '2010 – 2012', NULL, NULL, NULL, 122, 1, '2026-01-24 01:42:54', '2026-01-24 01:42:54'),
(169, 18, 'span', 'timeline_3_title', 'Modélisation & plans', NULL, NULL, NULL, 130, 1, '2026-01-24 01:42:54', '2026-01-24 01:42:54'),
(170, 18, 'p', 'timeline_3_desc', 'Modélisation 3D, plans d’exécution, quantitatifs.', NULL, NULL, NULL, 131, 1, '2026-01-24 01:42:54', '2026-01-24 01:42:54'),
(171, 18, 'span', 'timeline_3_date', '2008 – 2010', NULL, NULL, NULL, 132, 1, '2026-01-24 01:42:54', '2026-01-24 01:42:54'),
(172, 18, 'span', 'timeline_4_title', 'Bureau d’études', NULL, NULL, NULL, 140, 1, '2026-01-24 01:42:54', '2026-01-24 01:42:54'),
(173, 18, 'p', 'timeline_4_desc', 'Méthodes, relevés, dossiers techniques.', NULL, NULL, NULL, 141, 1, '2026-01-24 01:42:54', '2026-01-24 01:42:54'),
(174, 18, 'span', 'timeline_4_date', '2007', NULL, NULL, NULL, 142, 1, '2026-01-24 01:42:54', '2026-01-24 01:42:54'),
(175, 18, 'h2', 'col3_title', 'Compétences & formations', NULL, NULL, NULL, 310, 1, '2026-01-24 01:42:54', '2026-01-24 01:42:54'),
(176, 18, 'p', 'col3_intro', 'Des compétences internes solides, renforcées par une spécialisation BIM et structure.', NULL, NULL, NULL, 320, 1, '2026-01-24 01:42:54', '2026-01-24 01:42:54'),
(177, 18, 'span', 'edu_1_title', 'BIM — Coordination & méthodes', NULL, NULL, NULL, 510, 1, '2026-01-24 01:42:54', '2026-01-24 01:42:54'),
(178, 18, 'p', 'edu_1_desc', 'Process, BEP, standards, structuration des maquettes.', NULL, NULL, NULL, 511, 1, '2026-01-24 01:42:54', '2026-01-24 01:42:54'),
(179, 18, 'span', 'edu_1_level', 'Niveau : avancé', NULL, NULL, NULL, 512, 1, '2026-01-24 01:42:54', '2026-01-24 01:42:54'),
(180, 18, 'span', 'edu_2_title', 'Génie civil — Structures', NULL, NULL, NULL, 520, 1, '2026-01-24 01:42:54', '2026-01-24 01:42:54'),
(181, 18, 'p', 'edu_2_desc', 'Dimensionnement, notes de calcul, optimisation.', NULL, NULL, NULL, 521, 1, '2026-01-24 01:42:54', '2026-01-24 01:42:54'),
(182, 18, 'span', 'edu_2_level', 'Niveau : confirmé', NULL, NULL, NULL, 522, 1, '2026-01-24 01:42:54', '2026-01-24 01:42:54'),
(183, 18, 'span', 'edu_3_title', 'Structure métal & bois', NULL, NULL, NULL, 530, 1, '2026-01-24 01:42:54', '2026-01-24 01:42:54'),
(184, 18, 'p', 'edu_3_desc', 'Conception, détails, plans d’exécution.', NULL, NULL, NULL, 531, 1, '2026-01-24 01:42:54', '2026-01-24 01:42:54'),
(185, 18, 'span', 'edu_3_level', 'Niveau : confirmé', NULL, NULL, NULL, 532, 1, '2026-01-24 01:42:54', '2026-01-24 01:42:54'),
(186, 18, 'span', 'edu_4_title', 'Qualité & livrables', NULL, NULL, NULL, 540, 1, '2026-01-24 01:42:54', '2026-01-24 01:42:54'),
(187, 18, 'p', 'edu_4_desc', 'Nommage, versions, livrables exploitables.', NULL, NULL, NULL, 541, 1, '2026-01-24 01:42:54', '2026-01-24 01:42:54'),
(188, 18, 'span', 'edu_4_level', 'Niveau : structuré', NULL, NULL, NULL, 542, 1, '2026-01-24 01:42:54', '2026-01-24 01:42:54');

-- --------------------------------------------------------

--
-- Structure de la table `page`
--

CREATE TABLE `page` (
  `id` int(10) UNSIGNED NOT NULL,
  `slug` varchar(80) NOT NULL,
  `title` varchar(160) NOT NULL DEFAULT '',
  `meta_title` varchar(160) DEFAULT NULL,
  `meta_desc` varchar(255) DEFAULT NULL,
  `canonical` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `page`
--

INSERT INTO `page` (`id`, `slug`, `title`, `meta_title`, `meta_desc`, `canonical`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'accueil', 'Accueil', 'OFLABIM | Bureau d\'Études & Ingénierie', 'Bureau d\'études et ingénierie – solutions techniques, BIM et accompagnement de projets.', 'http://localhost/siteVitrine/index.php?page=accueil', 1, '2026-01-21 18:29:34', '2026-01-21 18:29:34'),
(2, 'presentation', 'Présentation', 'Présentation | OFLABIM', 'Découvrez OFLABIM : bureau d’études & ingénierie BIM. Coordination, structures et accompagnement de projets.', 'http://localhost/siteVitrine/index.php?page=presentation', 1, '2026-01-21 18:29:34', '2026-01-21 18:29:34'),
(3, 'service', 'Services', 'Services | OFLABIM', 'Découvrez nos services BIM et structures : coordination, notes de calcul, plans d’exécution.', 'http://localhost/siteVitrine/index.php?page=service', 1, '2026-01-21 18:29:34', '2026-01-21 18:29:34'),
(4, 'contact', 'Contact', 'Contact | OFLABIM', 'Contactez OFLABIM : bureau d’études & ingénierie (BIM, structures). Demande de devis, questions, prise de rendez-vous.', 'http://localhost/siteVitrine/index.php?page=contact', 1, '2026-01-21 18:29:34', '2026-01-21 18:29:34');

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(50) NOT NULL,
  `label` varchar(100) NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id`, `code`, `label`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Administrateur', '2026-01-21 18:29:34', '2026-01-21 18:29:34');

-- --------------------------------------------------------

--
-- Structure de la table `section`
--

CREATE TABLE `section` (
  `id` int(10) UNSIGNED NOT NULL,
  `page_id` int(10) UNSIGNED NOT NULL,
  `slug` varchar(80) NOT NULL,
  `admin_title` varchar(160) NOT NULL DEFAULT '',
  `template` varchar(80) DEFAULT NULL,
  `order_index` int(11) NOT NULL DEFAULT 10,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `section`
--

INSERT INTO `section` (`id`, `page_id`, `slug`, `admin_title`, `template`, `order_index`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 1, 'home-bim', 'Accueil - Le BIM', 'home-bim', 20, 1, '2026-01-21 18:29:34', '2026-01-21 18:29:34'),
(4, 1, 'home-about', 'Accueil - À propos', 'home-about', 40, 1, '2026-01-21 18:29:34', '2026-01-21 18:29:34'),
(18, 2, 'presentation-path', 'Présentation - Parcours (Entreprise)', 'presentation-path', 30, 1, '2026-01-24 01:02:54', '2026-01-24 01:02:54');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `email` varchar(190) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `username` varchar(100) NOT NULL,
  `company_name` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `last_login_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `opening_hours` varchar(120) DEFAULT NULL,
  `response_delay` varchar(120) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `role_id`, `email`, `phone`, `address`, `username`, `company_name`, `password_hash`, `is_active`, `last_login_at`, `created_at`, `updated_at`, `opening_hours`, `response_delay`) VALUES
(1, 1, 'contact@oflabim.fr', '+33 7 66 80 16 68', '110 cours Tolstoï, 69100 Villeurbanne, FR', 'OFLABIM', 'OFLABIM', '$2y$10$REPLACE_ME_WITH_A_REAL_BCRYPT_HASH..............................', 1, NULL, '2026-01-21 18:29:34', '2026-01-24 00:00:21', 'Lun – Ven : 9h00 – 18h30', 'Réponse sous 24–48h ouvrées');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `content_block`
--
ALTER TABLE `content_block`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_block_section_order` (`section_id`,`order_index`),
  ADD KEY `idx_block_section_slot` (`section_id`,`slot`);

--
-- Index pour la table `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_page_slug` (`slug`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_role_code` (`code`);

--
-- Index pour la table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_section_page_slug` (`page_id`,`slug`),
  ADD KEY `idx_section_page_order` (`page_id`,`order_index`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_user_email` (`email`),
  ADD UNIQUE KEY `uq_user_username` (`username`),
  ADD KEY `idx_user_role` (`role_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `content_block`
--
ALTER TABLE `content_block`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=189;

--
-- AUTO_INCREMENT pour la table `page`
--
ALTER TABLE `page`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `section`
--
ALTER TABLE `section`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `content_block`
--
ALTER TABLE `content_block`
  ADD CONSTRAINT `fk_block_section` FOREIGN KEY (`section_id`) REFERENCES `section` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `section`
--
ALTER TABLE `section`
  ADD CONSTRAINT `fk_section_page` FOREIGN KEY (`page_id`) REFERENCES `page` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_role` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
