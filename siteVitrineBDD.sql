/* ============================================================
   OFLABIM - Base mini CMS (tables + pages + sections) + admin
   - Structure + liens (pas de contenu)
   - + tables role/user pour connexion admin
   ============================================================ */

SET NAMES utf8mb4;
SET time_zone = "+00:00";

-- Drop dans l'ordre FK-safe
DROP TABLE IF EXISTS content_block;
DROP TABLE IF EXISTS section;
DROP TABLE IF EXISTS page;

DROP TABLE IF EXISTS `user`;
DROP TABLE IF EXISTS role;

-- ============================================================
-- ROLE
-- ============================================================
CREATE TABLE role (
  id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
  code        VARCHAR(50)  NOT NULL,          -- ex: admin
  label       VARCHAR(100) NOT NULL DEFAULT '',
  created_at  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_role_code (code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- USER (admin)
-- ============================================================
CREATE TABLE `user` (
  id            INT UNSIGNED NOT NULL AUTO_INCREMENT,
  role_id       INT UNSIGNED NOT NULL,
  email         VARCHAR(190) NOT NULL,
  username      VARCHAR(100) NOT NULL,
  password_hash VARCHAR(255) NOT NULL, -- password_hash() PHP (bcrypt/argon2)
  is_active     TINYINT(1)   NOT NULL DEFAULT 1,
  last_login_at DATETIME     NULL,
  created_at    DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at    DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_user_email (email),
  UNIQUE KEY uq_user_username (username),
  KEY idx_user_role (role_id),
  CONSTRAINT fk_user_role
    FOREIGN KEY (role_id) REFERENCES role(id)
    ON DELETE RESTRICT
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- PAGES
-- ============================================================
CREATE TABLE page (
  id           INT UNSIGNED NOT NULL AUTO_INCREMENT,
  slug         VARCHAR(80)  NOT NULL,
  title        VARCHAR(160) NOT NULL DEFAULT '',
  meta_title   VARCHAR(160) NULL,
  meta_desc    VARCHAR(255) NULL,
  canonical    VARCHAR(255) NULL,
  is_active    TINYINT(1)   NOT NULL DEFAULT 1,
  created_at   DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at   DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_page_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- SECTIONS
-- ============================================================
CREATE TABLE section (
  id           INT UNSIGNED NOT NULL AUTO_INCREMENT,
  page_id      INT UNSIGNED NOT NULL,
  slug         VARCHAR(80)  NOT NULL,
  admin_title  VARCHAR(160) NOT NULL DEFAULT '',
  template     VARCHAR(80)  NULL,
  order_index  INT          NOT NULL DEFAULT 10,
  is_active    TINYINT(1)   NOT NULL DEFAULT 1,
  created_at   DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at   DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_section_page_slug (page_id, slug),
  KEY idx_section_page_order (page_id, order_index),
  CONSTRAINT fk_section_page
    FOREIGN KEY (page_id) REFERENCES page(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- CONTENT BLOCKS
-- ============================================================
CREATE TABLE content_block (
  id           INT UNSIGNED NOT NULL AUTO_INCREMENT,
  section_id   INT UNSIGNED NOT NULL,
  type         ENUM('h1','h2','h3','p','span','badge','img','link','button','iframe','list_item','html')
               NOT NULL DEFAULT 'p',
  slot         VARCHAR(60)  NULL,
  text         MEDIUMTEXT   NULL,
  src          VARCHAR(255) NULL,
  alt          VARCHAR(255) NULL,
  href         VARCHAR(255) NULL,
  order_index  INT          NOT NULL DEFAULT 10,
  is_active    TINYINT(1)   NOT NULL DEFAULT 1,
  created_at   DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at   DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_block_section_order (section_id, order_index),
  KEY idx_block_section_slot (section_id, slot),
  CONSTRAINT fk_block_section
    FOREIGN KEY (section_id) REFERENCES section(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- SEED: 1 rôle admin + 1 user admin
-- ============================================================

INSERT INTO role (code, label) VALUES ('admin', 'Administrateur');

-- ⚠️ Remplace le password_hash par un vrai hash généré en PHP:
-- echo password_hash("TonMotDePasseFort!", PASSWORD_BCRYPT);
-- (je mets une valeur placeholder volontairement)
INSERT INTO `user` (role_id, email, username, password_hash, is_active)
VALUES (
  (SELECT id FROM role WHERE code='admin' LIMIT 1),
  'admin@oflabim.fr',
  'admin',
  '$2y$10$REPLACE_ME_WITH_A_REAL_BCRYPT_HASH..............................',
  1
);

-- ============================================================
-- PAGES (SEO)
-- ============================================================
INSERT INTO page (slug, title, meta_title, meta_desc, canonical, is_active) VALUES
('accueil', 'Accueil',
 'OFLABIM | Bureau d''Études & Ingénierie',
 'Bureau d''études et ingénierie – solutions techniques, BIM et accompagnement de projets.',
 'http://localhost/siteVitrine/index.php?page=accueil', 1),

('presentation', 'Présentation',
 'Présentation | OFLABIM',
 'Découvrez OFLABIM : bureau d’études & ingénierie BIM. Coordination, structures et accompagnement de projets.',
 'http://localhost/siteVitrine/index.php?page=presentation', 1),

('service', 'Services',
 'Services | OFLABIM',
 'Découvrez nos services BIM et structures : coordination, notes de calcul, plans d’exécution.',
 'http://localhost/siteVitrine/index.php?page=service', 1),

('contact', 'Contact',
 'Contact | OFLABIM',
 'Contactez OFLABIM : bureau d’études & ingénierie (BIM, structures). Demande de devis, questions, prise de rendez-vous.',
 'http://localhost/siteVitrine/index.php?page=contact', 1);

-- ============================================================
-- SECTIONS (liens page -> sections)
-- ============================================================
SET @p_accueil      = (SELECT id FROM page WHERE slug='accueil' LIMIT 1);
SET @p_presentation = (SELECT id FROM page WHERE slug='presentation' LIMIT 1);
SET @p_service      = (SELECT id FROM page WHERE slug='service' LIMIT 1);
SET @p_contact      = (SELECT id FROM page WHERE slug='contact' LIMIT 1);

-- ACCUEIL
INSERT INTO section (page_id, slug, admin_title, template, order_index) VALUES
(@p_accueil, 'home-hero',           'Accueil - Hero',               'home-hero',           10),
(@p_accueil, 'home-bim',            'Accueil - Le BIM',             'home-bim',            20),
(@p_accueil, 'home-services-value', 'Accueil - Services & Qualité', 'home-services-value', 30),
(@p_accueil, 'home-about',          'Accueil - À propos',           'home-about',          40),
(@p_accueil, 'home-deliverables',   'Accueil - Livrables',          'home-deliverables',   50),
(@p_accueil, 'home-testimonials',   'Accueil - Témoignages',        'home-testimonials',   60);

-- PRESENTATION
INSERT INTO section (page_id, slug, admin_title, template, order_index) VALUES
(@p_presentation, 'presentation-hero',     'Présentation - Hero',               'presentation-hero',     10),
(@p_presentation, 'presentation-about',    'Présentation - À propos',           'presentation-about',    20),
(@p_presentation, 'presentation-strategy', 'Présentation - Stratégie',          'presentation-strategy', 30),
(@p_presentation, 'presentation-models',   'Présentation - Exemples maquettes', 'presentation-models',   40),
(@p_presentation, 'presentation-path',     'Présentation - Parcours',           'presentation-path',     50);

-- SERVICE
INSERT INTO section (page_id, slug, admin_title, template, order_index) VALUES
(@p_service, 'service-hero',     'Services - Hero',      'service-hero',      10),
(@p_service, 'services-swiper',  'Services - Swiper',    'services-swiper',   20),
(@p_service, 'services-details', 'Services - Détails',   'services-details',  30);

-- CONTACT
INSERT INTO section (page_id, slug, admin_title, template, order_index) VALUES
(@p_contact, 'contact-hero',     'Contact - Hero',         'contact-hero',      10),
(@p_contact, 'contact-content',  'Contact - Contenu',      'contact-content',   20),
(@p_contact, 'contact-location', 'Contact - Localisation', 'contact-location',  30);
