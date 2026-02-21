-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 21 fév. 2026 à 20:50
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
(1, 2, 'h2', 'title', 'Le BIM, au cœur de la coordination de vos projets', NULL, NULL, NULL, 10, 1, '2026-01-21 20:22:18', '2026-02-20 23:50:46'),
(2, 2, 'p', 'text_1', 'Le BIM (Building Information Modeling) repose sur une maquette numérique 3D qui centralise l’ensemble des données techniques du projet. Elle devient une base commune de travail pour tous les intervenants.', NULL, NULL, NULL, 20, 1, '2026-01-21 20:22:18', '2026-02-20 23:50:46'),
(3, 2, 'p', 'text_2', 'Cette approche collaborative permet de mieux anticiper les contraintes, d’aligner les décisions techniques et de fiabiliser les échanges tout au long du projet, de la conception au chantier. La maquette BIM ne se limite pas à un modèle 3D : elle intègre l’ensemble des données techniques du bâtiment (matériaux, quantités, performances, coûts, planning), faisant de l’ingénieur BIM le garant de la cohérence, de la qualité et de la gestion des informations du projet.', NULL, NULL, NULL, 30, 1, '2026-01-21 20:22:18', '2026-02-20 23:50:46'),
(4, 2, 'img', 'image', NULL, 'assets/images/accueil_home-bim_20260220_235046.jpg', 'Coordination BIM et travail collaboratif autour d’une maquette numérique', NULL, 40, 1, '2026-01-21 20:22:18', '2026-02-20 23:50:46'),
(161, 18, 'h2', 'col1_title', 'Réalisations & expérience', NULL, NULL, NULL, 10, 1, '2026-01-24 01:42:54', '2026-02-20 16:08:54'),
(162, 18, 'p', 'col1_intro', 'Des missions menées sur le terrain, avec une approche orientée coordination, méthode et livrables fiables.', NULL, NULL, NULL, 20, 1, '2026-01-24 01:42:54', '2026-02-20 16:08:54'),
(163, 18, 'span', 'timeline_1_title', 'Installations de traitement d’eau & STEP', NULL, NULL, NULL, 110, 1, '2026-01-24 01:42:54', '2026-02-20 16:08:54'),
(164, 18, 'p', 'timeline_1_desc', 'Modélisation d’ouvrages hydrauliques, équipements et réseaux techniques, coordination multi-lots.', NULL, NULL, NULL, 111, 1, '2026-01-24 01:42:54', '2026-02-20 16:08:54'),
(165, 18, 'span', 'timeline_1_date', 'Aujourd’hui', NULL, NULL, NULL, 112, 1, '2026-01-24 01:42:54', '2026-02-20 16:08:54'),
(166, 18, 'span', 'timeline_2_title', 'Bâtiments techniques & hospitaliers – CVC', NULL, NULL, NULL, 120, 1, '2026-01-24 01:42:54', '2026-02-20 16:08:54'),
(167, 18, 'p', 'timeline_2_desc', 'Coordination des systèmes CVC, intégration des réseaux en environnement contraint.', NULL, NULL, NULL, 121, 1, '2026-01-24 01:42:54', '2026-02-20 16:08:54'),
(168, 18, 'span', 'timeline_2_date', 'Aujourd’hui', NULL, NULL, NULL, 122, 1, '2026-01-24 01:42:54', '2026-02-20 16:08:54'),
(169, 18, 'span', 'timeline_3_title', 'Projets industriels (méthanisation / process)', NULL, NULL, NULL, 130, 1, '2026-01-24 01:42:54', '2026-02-20 16:08:54'),
(170, 18, 'p', 'timeline_3_desc', 'Maquettes techniques intégrant structures, équipements et réseaux, structuration des données BIM.', NULL, NULL, NULL, 131, 1, '2026-01-24 01:42:54', '2026-02-20 16:08:54'),
(171, 18, 'span', 'timeline_3_date', 'Aujourd’hui', NULL, NULL, NULL, 132, 1, '2026-01-24 01:42:54', '2026-02-20 16:08:54'),
(172, 18, 'span', 'timeline_4_title', 'Bureau d’études technique', NULL, NULL, NULL, 140, 1, '2026-01-24 01:42:54', '2026-02-20 16:08:54'),
(173, 18, 'p', 'timeline_4_desc', 'Modélisation 3D, plans d’exécution, dossiers techniques et préparation DOE.', NULL, NULL, NULL, 141, 1, '2026-01-24 01:42:54', '2026-02-20 16:08:54'),
(174, 18, 'span', 'timeline_4_date', 'Aujourd’hui', NULL, NULL, NULL, 142, 1, '2026-01-24 01:42:54', '2026-02-20 16:08:54'),
(175, 18, 'h2', 'col3_title', 'Compétences & formations', NULL, NULL, NULL, 310, 1, '2026-01-24 01:42:54', '2026-02-20 16:08:54'),
(176, 18, 'p', 'col3_intro', 'Des compétences internes solides, renforcées par une spécialisation BIM et structure.', NULL, NULL, NULL, 320, 1, '2026-01-24 01:42:54', '2026-02-20 16:08:54'),
(177, 18, 'span', 'edu_1_title', 'BIM — Modélisation & coordination', NULL, NULL, NULL, 510, 1, '2026-01-24 01:42:54', '2026-02-20 16:08:54'),
(178, 18, 'p', 'edu_1_desc', 'Revit, maquettes disciplinaires, coordination multi-métiers, ACC.', NULL, NULL, NULL, 511, 1, '2026-01-24 01:42:54', '2026-02-20 16:08:54'),
(179, 18, 'span', 'edu_1_level', 'Niveau : avancé', NULL, NULL, NULL, 512, 1, '2026-01-24 01:42:54', '2026-02-20 16:08:54'),
(180, 18, 'span', 'edu_2_title', 'Installations techniques (Eau / CVC / Process)', NULL, NULL, NULL, 520, 1, '2026-01-24 01:42:54', '2026-02-20 16:08:54'),
(181, 18, 'p', 'edu_2_desc', 'Modélisation d’ouvrages hydrauliques, équipements techniques et réseaux industriels.', NULL, NULL, NULL, 521, 1, '2026-01-24 01:42:54', '2026-02-20 16:08:54'),
(182, 18, 'span', 'edu_2_level', 'Niveau : confirmé', NULL, NULL, NULL, 522, 1, '2026-01-24 01:42:54', '2026-02-20 16:08:54'),
(183, 18, 'span', 'edu_3_title', 'Processus BIM & CDE', NULL, NULL, NULL, 530, 1, '2026-01-24 01:42:54', '2026-02-20 16:08:54'),
(184, 18, 'p', 'edu_3_desc', 'Structuration des maquettes, organisation des dossiers, workflows et BEP.', NULL, NULL, NULL, 531, 1, '2026-01-24 01:42:54', '2026-02-20 16:08:54'),
(185, 18, 'span', 'edu_3_level', 'Niveau : confirmé', NULL, NULL, NULL, 532, 1, '2026-01-24 01:42:54', '2026-02-20 16:08:54'),
(186, 18, 'span', 'edu_4_title', 'DOE & fiabilisation des données', NULL, NULL, NULL, 540, 1, '2026-01-24 01:42:54', '2026-02-20 16:08:54'),
(187, 18, 'p', 'edu_4_desc', 'Nettoyage maquettes, IFC conformes, paramètres structurés et exploitables.', NULL, NULL, NULL, 541, 1, '2026-01-24 01:42:54', '2026-02-20 16:08:54'),
(188, 18, 'span', 'edu_4_level', 'Niveau : structuré', NULL, NULL, NULL, 542, 1, '2026-01-24 01:42:54', '2026-02-20 16:08:54'),
(189, 4, 'h2', 'title', 'À propos de nous', NULL, NULL, NULL, 10, 1, '2026-01-24 02:48:32', '2026-02-16 17:09:27'),
(190, 4, 'p', 'text_1', 'Nous accompagnons les maîtres d’ouvrage, maîtres d’œuvre et industriels dans la maîtrise et la sécurisation de leurs projets grâce au BIM appliqué aux installations techniques. Notre démarche repose sur la fiabilité des données, la cohérence des maquettes numériques et la continuité de l’information sur l’ensemble du cycle de vie des ouvrages.\r\n\r\nForts de notre expérience dans les secteurs de l’eau, de l’air, des déchets, du CVC, de l’industrie et du pharmaceutique, nous produisons des livrables conformes aux exigences contractuelles et directement exploitables sur le terrain, garantissant la performance et la pérennité des installations', NULL, NULL, NULL, 20, 1, '2026-01-24 02:48:32', '2026-02-16 17:09:27'),
(191, 4, 'span', 'stat_1_value', '50+', NULL, NULL, NULL, 30, 1, '2026-01-24 02:48:32', '2026-02-16 17:09:27'),
(192, 4, 'span', 'stat_1_label', 'Projets terminés', NULL, NULL, NULL, 31, 1, '2026-01-24 02:48:32', '2026-01-24 02:48:32'),
(193, 4, 'span', 'stat_2_value', '100%', NULL, NULL, NULL, 40, 1, '2026-01-24 02:48:32', '2026-02-16 17:09:27'),
(194, 4, 'span', 'stat_2_label', 'Clients satisfaits', NULL, NULL, NULL, 41, 1, '2026-01-24 02:48:32', '2026-01-24 02:48:32'),
(195, 4, 'img', 'image', NULL, 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?auto=format&fit=crop&w=1400&q=70', 'Bureau d’études et ingénierie BIM', NULL, 50, 1, '2026-01-24 02:48:32', '2026-02-16 17:09:27'),
(214, 19, 'p', 'subject_devis', 'Demande de devis', NULL, NULL, NULL, 30, 1, '2026-01-24 05:32:29', '2026-01-24 06:10:37'),
(215, 19, 'p', 'subject_rdv', 'Prise de rendez-vous', NULL, NULL, NULL, 10, 1, '2026-01-24 05:32:29', '2026-01-24 06:10:37'),
(216, 19, 'p', 'subject_bim', 'Ingénierie BIM', NULL, NULL, NULL, 20, 1, '2026-01-24 05:32:29', '2026-01-24 06:10:37'),
(217, 19, 'p', 'subject_autre', 'Autre', NULL, NULL, NULL, 40, 1, '2026-01-24 05:32:29', '2026-01-24 06:10:37'),
(227, 18, 'span', 'edu_5_title', 'testtest', NULL, NULL, NULL, 550, 0, '2026-02-16 22:17:42', '2026-02-20 16:08:54'),
(228, 18, 'p', 'edu_5_desc', 'test', NULL, NULL, NULL, 551, 0, '2026-02-16 22:17:42', '2026-02-20 16:08:54'),
(229, 18, 'span', 'edu_5_level', '', NULL, NULL, NULL, 552, 0, '2026-02-16 22:17:42', '2026-02-20 16:08:54'),
(250, 21, 'h2', 'title', 'Domaines d’intervention', NULL, NULL, NULL, 10, 1, '2026-02-20 22:44:55', '2026-02-21 18:39:56'),
(251, 21, 'p', 'intro', 'OFLABIM accompagne des projets techniques et industriels complexes, nécessitant une forte maîtrise des méthodes BIM et de la coordination.', NULL, NULL, NULL, 20, 1, '2026-02-20 22:44:55', '2026-02-21 18:39:56'),
(252, 21, 'h3', 'domain_1_title', 'Traitement de l’eau potable', NULL, NULL, NULL, 110, 1, '2026-02-20 22:44:55', '2026-02-21 18:39:56'),
(253, 21, 'p', 'domain_1_desc', 'Projets intégrant réseaux, équipements et ouvrages techniques, avec une approche BIM orientée coordination et exploitation.', NULL, NULL, NULL, 111, 1, '2026-02-20 22:44:55', '2026-02-21 18:39:56'),
(254, 21, 'img', 'domain_1_img', NULL, 'assets/images/traitements-pour-rendre-l-eau-potable.jpg', 'Installation de traitement de l’eau potable', NULL, 112, 1, '2026-02-20 22:44:55', '2026-02-21 18:39:56'),
(255, 21, 'h3', 'domain_2_title', 'Stations d’épuration', NULL, NULL, NULL, 120, 1, '2026-02-20 22:44:55', '2026-02-21 18:39:56'),
(256, 21, 'p', 'domain_2_desc', 'Environnements multi-lots à forte contrainte technique, nécessitant une structuration BIM rigoureuse.', NULL, NULL, NULL, 121, 1, '2026-02-20 22:44:55', '2026-02-21 18:39:56'),
(257, 21, 'img', 'domain_2_img', NULL, 'assets/images/stationEpuration.jpg', 'Station d’épuration industrielle', NULL, 122, 1, '2026-02-20 22:44:55', '2026-02-21 18:39:56'),
(258, 21, 'h3', 'domain_3_title', 'Postes de relevage', NULL, NULL, NULL, 130, 1, '2026-02-20 22:44:55', '2026-02-21 18:39:57'),
(259, 21, 'p', 'domain_3_desc', 'Modélisation des ouvrages hydrauliques, coordination des réseaux et préparation des données techniques.', NULL, NULL, NULL, 131, 1, '2026-02-20 22:44:55', '2026-02-21 18:39:57'),
(260, 21, 'img', 'domain_3_img', NULL, 'assets/images/accueil_home-domains_3_20260221_183956.jpg', 'Poste de relevage hydraulique', NULL, 132, 1, '2026-02-20 22:44:55', '2026-02-21 18:39:57'),
(261, 21, 'h3', 'domain_4_title', 'Unités de méthanisation', NULL, NULL, NULL, 140, 1, '2026-02-20 22:44:55', '2026-02-21 18:39:57'),
(262, 21, 'p', 'domain_4_desc', 'Projets industriels intégrant process, structures et réseaux, avec une attention portée à la cohérence des maquettes.', NULL, NULL, NULL, 141, 1, '2026-02-20 22:44:55', '2026-02-21 18:39:57'),
(263, 21, 'img', 'domain_4_img', NULL, 'assets/images/uniteMethanisation.jpg', 'Unité industrielle de méthanisation', NULL, 142, 1, '2026-02-20 22:44:55', '2026-02-21 18:39:57'),
(264, 21, 'h3', 'domain_5_title', 'Bâtiments hospitaliers – CVC', NULL, NULL, NULL, 150, 1, '2026-02-20 22:44:55', '2026-02-21 18:39:57'),
(265, 21, 'p', 'domain_5_desc', 'Modélisation et coordination des systèmes CVC dans des environnements sensibles.', NULL, NULL, NULL, 151, 1, '2026-02-20 22:44:55', '2026-02-21 18:39:57'),
(266, 21, 'img', 'domain_5_img', NULL, 'assets/images/hopitalCVC2.jpg', 'Systèmes CVC en bâtiment hospitalier', NULL, 152, 1, '2026-02-20 22:44:55', '2026-02-21 18:39:57'),
(267, 21, 'h3', 'domain_6_title', 'Bâtiments industriels & techniques', NULL, NULL, NULL, 160, 1, '2026-02-20 22:44:55', '2026-02-21 18:39:57'),
(268, 21, 'p', 'domain_6_desc', 'Projets industriels intégrant process, structures et réseaux, avec une approche BIM orientée coordination et fiabilité des données.', NULL, NULL, NULL, 161, 1, '2026-02-20 22:44:55', '2026-02-21 18:39:57'),
(269, 21, 'img', 'domain_6_img', NULL, 'assets/images/HP_IMG-Entreprise.png', 'Bâtiment industriel technique', NULL, 162, 1, '2026-02-20 22:44:55', '2026-02-21 18:39:57');

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
(18, 2, 'presentation-path', 'Présentation - Réalisations et compétences dans  l\'entreprise', 'presentation-path', 30, 1, '2026-01-24 01:02:54', '2026-01-24 04:01:51'),
(19, 4, 'contact-nature-demande', 'Contact – Nature de la demande', 'contact-form', 10, 1, '2026-01-24 05:12:53', '2026-01-24 05:52:14'),
(21, 1, 'home-domains', 'Accueil - Domaines d’intervention', 'home-domains', 30, 1, '2026-02-20 22:44:55', '2026-02-20 22:44:55');

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
(1, 1, 'contact@oflabim.fr', '+33 7 66 80 16 68', '110 cours Tolstoï, 69100 Villeurbanne, FR', 'OFLABIM', 'OFLABIM', '$2y$10$REPLACE_ME_WITH_A_REAL_BCRYPT_HASH..............................', 1, NULL, '2026-01-21 18:29:34', '2026-02-21 18:25:43', 'Lun – Ven : 9h00 – 19h00', 'Réponse sous 24–48h ouvrées');

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=279;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

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
