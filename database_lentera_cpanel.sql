-- Database Export for Hosting / cPanel (Model LENTERA)
-- Generated: 2026-09-22 09:44:31
-- PHP Version: 8.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

-- --------------------------------------------------------
-- Table structure for table `assessments`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `assessments`;
CREATE TABLE `assessments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `module_id` bigint unsigned NOT NULL,
  `judul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `jenis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'stage_assessment',
  `max_skor` int NOT NULL DEFAULT '0',
  `catatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `urutan` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `assessments_module_id_foreign` (`module_id`),
  CONSTRAINT `assessments_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `assessments`

INSERT INTO `assessments` VALUES 
('2', '3', 'Penilaian Diri', NULL, 'penilaian_diri', '0', NULL, '1', '2026-09-19 10:07:45', '2026-09-20 08:08:06'),
('5', '1', 'Penilaian Diri', 'Petunjuk: Pilih satu jawaban yang paling sesuai dengan dirimu.', 'penilaian_diri', '24', NULL, '1', '2026-09-19 10:07:45', '2026-09-19 10:07:45'),
('6', '1', 'Refleksi Diri', 'Bacalah situasi berikut.\nRaka sering dipanggil dengan julukan yang tidak disukainya. Ketika ditanya, Raka mengatakan, “Tidak apa-apa.” Namun, setelah beberapa waktu, Raka mulai lebih sering menyendiri.\nMenurutmu, apa yang perlu diperhatikan?\nPilih jawaban yang paling sesuai.', 'refleksi_diri', '16', 'Catatan: Butir nomor 4 adalah pernyataan negatif sehingga skornya dibalik.', '2', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('7', '1', 'Komitmen Saya', 'Setelah mengikuti kegiatan ini, seberapa sesuai komitmen berikut dengan dirimu?', 'lembar_komitmen', '16', 'Komitmen utama saya: \"Mulai sekarang, saya akan...\"', '3', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('8', '2', 'Penilaian Diri', NULL, 'penilaian_diri', '0', NULL, '1', '2026-09-19 11:10:47', '2026-09-19 11:10:47'),
('9', '2', 'Refleksi Diri', 'Bacalah situasi berikut.\r\nNisa menerima komentar yang mempermalukan dirinya di grup kelas. Ia tidak membalas\r\nkomentar tersebut. Keesokan harinya, Nisa lebih banyak diam dan memilih duduk sendiri.\r\nMenurutmu, bagaimana cara memahami perasaan Nisa?', 'refleksi_diri', '0', NULL, '2', '2026-09-19 11:15:27', '2026-09-19 11:15:27'),
('10', '2', 'Lembar Komitmen', 'Setelah kegiatan ini, saya berkomitmen untuk:', 'lembar_komitmen', '0', NULL, '3', '2026-09-19 11:19:04', '2026-09-19 11:19:04'),
('11', '6', 'Lembar Komitmen Siswa', 'Setelah mengikuti seluruh rangkaian 5 topik Model LENTERA, nyatakan komitmen perilaku empati dan anti-perundungan Anda berikut ini.', 'lembar_komitmen', '0', 'Komitmen ini akan dicantumkan pada halaman belakang Sertifikat Layanan Model LENTERA Anda.', '1', '2026-09-19 11:43:13', '2026-09-20 05:16:09'),
('12', '3', 'Refleksi Diri', 'Bacalah situasi berikut.\r\nKamu melihat seorang teman ditertawakan karena penampilannya. Teman tersebut tersenyum\r\ndan mengatakan, “Santai, cuma bercanda.”', 'refleksi_diri', '0', NULL, '2', '2026-09-20 08:12:17', '2026-09-20 08:12:17'),
('13', '3', 'Lembar Komitmen', 'KOMITMEN SAYA', 'lembar_komitmen', '0', NULL, '3', '2026-09-20 08:14:11', '2026-09-20 08:14:11'),
('14', '4', 'Penilaian Diri', NULL, 'penilaian_diri', '0', NULL, '1', '2026-09-21 12:59:21', '2026-09-21 12:59:21'),
('15', '4', 'Refleksi Diri', 'Kamu melihat seorang teman diejek oleh beberapa siswa. Ia terlihat tidak nyaman, tetapi tidak \r\nmengatakan apa-apa. \r\nRespons mana yang menurutmu dapat menunjukkan kepedulian?', 'refleksi_diri', '0', NULL, '2', '2026-09-21 13:00:09', '2026-09-21 13:00:09'),
('16', '4', 'Lembar Komitmen', 'Mulai sekarang, saya akan:', 'lembar_komitmen', '0', NULL, '3', '2026-09-21 13:01:15', '2026-09-21 13:01:15'),
('17', '5', 'Penilaian Diri', NULL, 'penilaian_diri', '0', NULL, '1', '2026-09-21 13:13:34', '2026-09-21 13:13:34'),
('18', '5', 'Refleksi Diri', 'Dalam grup kelas, beberapa siswa mulai membagikan meme yang mempermalukan seorang \r\nteman. Sebagian siswa hanya melihat tanpa memberikan respons. \r\nApa yang dapat dilakukan untuk menciptakan lingkungan yang lebih aman?', 'refleksi_diri', '0', NULL, '2', '2026-09-21 13:13:52', '2026-09-21 13:18:02'),
('19', '5', 'Lembar Komitmen', NULL, 'lembar_komitmen', '0', NULL, '3', '2026-09-21 13:14:08', '2026-09-21 13:14:08');

-- --------------------------------------------------------
-- Table structure for table `cache`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `cache`

INSERT INTO `cache` VALUES 
('lentera-cache-budi@test|127.0.0.1', 'i:1;', '1789999022'),
('lentera-cache-budi@test|127.0.0.1:timer', 'i:1789999022;', '1789999022'),
('lentera-cache-yuda|127.0.0.1', 'i:1;', '1789893238'),
('lentera-cache-yuda|127.0.0.1:timer', 'i:1789893238;', '1789893238');

-- --------------------------------------------------------
-- Table structure for table `cache_locks`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `certificate_templates`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `certificate_templates`;
CREATE TABLE `certificate_templates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'SERTIFIKAT',
  `sub_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PENYELESAIAN LAYANAN MODEL LENTERA',
  `caption` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Latihan Empati Terstruktur untuk Atasi Perundungan',
  `body_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `topics_list` json NOT NULL,
  `signer_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Guru Bimbingan dan Konseling',
  `signer_mode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'school_counselor',
  `default_signer_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default_signer_nip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cert_number_prefix` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'LTR',
  `cert_number_format` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No: {PREFIX}/{YEAR}/{CLASS}/{ID}',
  `date_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'completion_date',
  `fixed_date` date DEFAULT NULL,
  `recap_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'REKAP CAPAIAN LAYANAN',
  `disclaimer` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `commitment_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'KOMITMEN SAYA',
  `commitment_intro` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Setelah mengikuti rangkaian LENTERA, saya berkomitmen untuk:',
  `commitment_points` json NOT NULL,
  `commitment_personal_prompt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Komitmen pribadi saya:',
  `commitment_personal_subprompt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '“Mulai sekarang, saya akan...”',
  `logo_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `docx_template_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `certificate_templates`

INSERT INTO `certificate_templates` VALUES 
('1', 'SERTIFIKAT', 'PENYELESAIAN LAYANAN MODEL LENTERA', 'Latihan Empati Terstruktur untuk Atasi Perundungan', 'atas partisipasi dan penyelesaian rangkaian layanan Model LENTERA dalam mengembangkan empati dan perilaku positif untuk menciptakan lingkungan pertemanan yang aman, nyaman, dan saling menghargai.', '[\"01 Menyadari Masalah\", \"02 Memahami Emosi\", \"03 Mengambil Perspektif\", \"04 Bertindak Empatik\", \"05 Membudayakan Perilaku Anti-Perundungan\"]', 'Guru Bimbingan dan Konseling', 'school_counselor', 'Guru Bimbingan dan Konseling', '', 'LTR', 'No: {PREFIX}/{YEAR}/{CLASS}/{ID}', 'completion_date', NULL, 'REKAP CAPAIAN LAYANAN', 'Hasil ini merupakan gambaran capaian peserta didik selama mengikuti layanan LENTERA dan bukan merupakan diagnosis psikologis.', 'KOMITMEN SAYA', 'Setelah mengikuti rangkaian LENTERA, saya berkomitmen untuk:', '[\"menghargai perasaan dan keberadaan orang lain;\", \"tidak ikut melakukan atau menyebarkan perundungan;\", \"berusaha memahami sudut pandang orang lain;\", \"menunjukkan kepedulian ketika melihat teman mengalami kesulitan;\", \"ikut menciptakan lingkungan pertemanan yang aman dan saling menghargai.\"]', 'Komitmen pribadi saya:', '“Mulai sekarang, saya akan...”', 'images/certificate/lentera_logo.png', NULL, '1', '2026-09-19 10:07:45', '2026-09-19 10:07:45');

-- --------------------------------------------------------
-- Table structure for table `failed_jobs`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `job_batches`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `jobs`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `kelas`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `kelas`;
CREATE TABLE `kelas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `school_id` bigint unsigned NOT NULL,
  `nama_kelas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tingkat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun_ajaran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kelas_school_id_foreign` (`school_id`),
  CONSTRAINT `kelas_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `kelas`

INSERT INTO `kelas` VALUES 
('1', '1', 'VIII A', 'VIII', '2025/2026', '2026-09-19 10:07:40', '2026-09-19 10:07:40'),
('2', '1', 'VIII B', 'VIII', '2025/2026', '2026-09-19 10:07:40', '2026-09-19 10:07:40'),
('3', '2', 'XI TKJ 1', 'XI', '2025/2026', '2026-09-19 10:07:40', '2026-09-19 10:07:40'),
('4', '3', 'Kelas 1 A', '7', '2025/2026', '2026-09-19 10:11:56', '2026-09-19 10:11:56'),
('5', '4', '1A', 'VII', '2026/2027', '2026-09-21 13:40:49', '2026-09-21 13:40:49');

-- --------------------------------------------------------
-- Table structure for table `konselor_sekolah`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `konselor_sekolah`;
CREATE TABLE `konselor_sekolah` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `konselor_id` bigint unsigned NOT NULL,
  `school_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `konselor_sekolah_konselor_id_school_id_unique` (`konselor_id`,`school_id`),
  KEY `konselor_sekolah_school_id_foreign` (`school_id`),
  CONSTRAINT `konselor_sekolah_konselor_id_foreign` FOREIGN KEY (`konselor_id`) REFERENCES `konselors` (`id`) ON DELETE CASCADE,
  CONSTRAINT `konselor_sekolah_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `konselor_sekolah`

INSERT INTO `konselor_sekolah` VALUES 
('1', '1', '1', '2026-09-19 10:07:41', '2026-09-19 10:07:41'),
('2', '1', '2', '2026-09-19 10:07:41', '2026-09-19 10:07:41'),
('3', '2', '2', '2026-09-19 10:07:41', '2026-09-19 10:07:41'),
('4', '3', '3', '2026-09-19 10:13:29', '2026-09-19 10:13:29'),
('5', '3', '1', '2026-09-19 10:21:06', '2026-09-19 10:21:06'),
('6', '4', '4', '2026-09-21 13:45:12', '2026-09-21 13:45:12');

-- --------------------------------------------------------
-- Table structure for table `konselors`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `konselors`;
CREATE TABLE `konselors` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `nip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `konselors_user_id_foreign` (`user_id`),
  CONSTRAINT `konselors_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `konselors`

INSERT INTO `konselors` VALUES 
('1', '2', '198501012010011001', '081234567890', '2026-09-19 10:07:41', '2026-09-19 10:07:41'),
('2', '3', '199003152015021002', '082345678901', '2026-09-19 10:07:41', '2026-09-19 10:07:41'),
('3', '12', '123456789', '000', '2026-09-19 10:13:29', '2026-09-19 10:13:29'),
('4', '16', '12345', '12345', '2026-09-21 13:45:12', '2026-09-21 13:45:12');

-- --------------------------------------------------------
-- Table structure for table `materials`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `materials`;
CREATE TABLE `materials` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `module_id` bigint unsigned NOT NULL,
  `judul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'materi',
  `isi` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `video` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `situasi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `peran` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `diskusi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `urutan` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `materials_module_id_foreign` (`module_id`),
  CONSTRAINT `materials_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `materials`

INSERT INTO `materials` VALUES 
('1', '1', 'Video / Ilustrasi Kejadian: Empathy Awareness', 'video', '<p>Silakan tonton video / ilustrasi kejadian untuk mengenali situasi empati terkait topik ini.</p>', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, NULL, NULL, NULL, '1', '2026-09-19 10:07:45', '2026-09-19 10:07:45'),
('2', '1', 'Diam Bukan Berarti Setuju', 'kartu_situasi', NULL, NULL, NULL, 'Dimas sering diam saat teman-temannya mengejek seseorang. Mereka menganggap Dimas setuju karena tidak membela. Padahal Dimas takut jika ikut bicara nanti diejek juga.', 'Dimas (siswa)\nDua teman\nSatu pelaku', 'Mengapa Dimas diam?\nBagaimana perasaan Dimas?\nApa yang mungkin Dimas pikirkan?\nApa yang bisa dilakukan Dimas?', '2', '2026-09-19 10:07:45', '2026-09-19 10:07:45'),
('3', '2', 'Video / Ilustrasi Kejadian: Emotional Empathy', 'video', '<p>Silakan tonton video / ilustrasi kejadian untuk mengenali situasi empati terkait topik ini.</p>', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, NULL, NULL, NULL, '1', '2026-09-19 10:07:45', '2026-09-19 10:07:45'),
('4', '2', 'Menghargai Perasaan Teman', 'kartu_situasi', NULL, NULL, NULL, 'Lina menangis sendirian di pojok kelas setelah dituduh mencontek oleh temannya, padahal dia belajar semalaman. Teman-teman lain hanya memandangnya dan berbisik.', 'Lina (korban)\nTeman penuduh\nTeman yang berbisik', 'Bagaimana perasaan Lina saat dituduh?\nKenapa teman-teman lain malah berbisik?\nApa respons empati emosional yang tepat?', '2', '2026-09-19 10:07:45', '2026-09-19 10:07:45'),
('5', '3', 'Video / Ilustrasi Kejadian: Cognitive Empathy / Perspective Taking', 'video', '<p>Silakan tonton video / ilustrasi kejadian untuk mengenali situasi empati terkait topik ini.</p>', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, NULL, NULL, NULL, '1', '2026-09-19 10:07:45', '2026-09-19 10:07:45'),
('6', '3', 'Melihat dari Sudut Pandang Lain', 'kartu_situasi', NULL, NULL, NULL, 'Budi tidak ingin bermain dengan Adi karena Adi selalu memakai sepatu yang usang dan kaos kaki bolong. Budi tidak tahu bahwa Adi bekerja membantu ayahnya setelah sekolah.', 'Budi (siswa)\nAdi (siswa)\nAyah Adi', 'Mengapa Adi memakai sepatu usang?\nBagaimana sudut pandang Adi terhadap ejekan Budi?\nBagaimana jika Budi mengetahui kenyataannya?', '2', '2026-09-19 10:07:45', '2026-09-19 10:07:45'),
('7', '4', 'Video / Ilustrasi Kejadian: Empathic Response', 'video', '<p>Silakan tonton video / ilustrasi kejadian untuk mengenali situasi empati terkait topik ini.</p>', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, NULL, NULL, NULL, '1', '2026-09-19 10:07:45', '2026-09-19 10:07:45'),
('8', '4', 'Memberikan Dukungan Nyata', 'kartu_situasi', NULL, NULL, NULL, 'Roni terlihat sangat sedih karena tidak memiliki uang untuk membayar uang buku. Bimo melihat Roni murung dan memegang buku lamanya yang robek.', 'Roni (siswa)\nBimo (teman Budi)\nPenjual buku', 'Bagaimana cara Bimo memberikan respons empati?\nApa kalimat yang sopan untuk menghibur Roni?\nApa tindakan konkret yang bisa dilakukan?', '2', '2026-09-19 10:07:45', '2026-09-19 10:07:45'),
('9', '5', 'Video / Ilustrasi Kejadian: Prosocial Behavior', 'video', '<p>Silakan tonton video / ilustrasi kejadian untuk mengenali situasi empati terkait topik ini.</p>', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, NULL, NULL, NULL, '1', '2026-09-19 10:07:45', '2026-09-19 10:07:45'),
('10', '5', 'Mewujudkan Empati dalam Aksi', 'kartu_situasi', NULL, NULL, NULL, 'Saat jam istirahat, kelompok siswa menolak Siti bergabung makan siang bersama karena pakaian Siti tampak sederhana dan berasal dari desa.', 'Siti (siswa baru)\nKelompok penolak\nSiswa yang mengajak Siti bergabung', 'Bagaimana dampak penolakan sosial terhadap Siti?\nApa tindakan prososial yang bisa diambil oleh siswa lain?\nBagaimana cara menciptakan inklusi di sekolah?', '2', '2026-09-19 10:07:45', '2026-09-19 10:07:45');

-- --------------------------------------------------------
-- Table structure for table `migrations`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=262 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `migrations`

INSERT INTO `migrations` VALUES 
('228', '0001_01_01_000000_create_roles_table_first', '1'),
('229', '0001_01_01_000000_create_users_table', '1'),
('230', '0001_01_01_000001_create_cache_table', '1'),
('231', '0001_01_01_000002_create_jobs_table', '1'),
('232', '2025_01_01_000002_create_schools_table', '1'),
('233', '2025_01_01_000003_create_kelas_table', '1'),
('234', '2025_01_01_000004_create_konselors_table', '1'),
('235', '2025_01_01_000005_create_konselor_sekolah_table', '1'),
('236', '2025_01_01_000006_create_students_table', '1'),
('237', '2025_01_01_000007_create_modules_table', '1'),
('238', '2025_01_01_000008_create_materials_table', '1'),
('239', '2025_01_01_000009_create_assessments_table', '1'),
('240', '2025_01_01_000010_create_questions_table', '1'),
('241', '2025_01_01_000011_create_question_options_table', '1'),
('242', '2025_01_01_000012_create_student_progress_table', '1'),
('243', '2025_01_01_000013_add_fields_to_modules_and_materials', '1'),
('244', '2025_01_01_000014_add_kartu_situasi_fields_to_materials', '1'),
('245', '2025_01_01_000015_add_image_field_to_questions', '1'),
('246', '2025_01_01_000016_add_guide_fields_to_modules', '1'),
('247', '2025_01_01_000017_add_feedback_steps_to_modules', '1'),
('248', '2026_08_30_143623_create_student_evaluations_table', '1'),
('249', '2026_08_31_152931_rename_minimal_nilai_to_max_skor_in_assessments_table', '1'),
('250', '2026_08_31_163150_drop_feedback_steps_from_modules_table', '1'),
('251', '2026_09_16_161100_add_answers_to_student_progress_table', '1'),
('252', '2026_09_16_171049_add_notes_to_student_evaluations_table', '1'),
('253', '2026_09_17_142603_add_username_to_users_table', '1'),
('254', '2026_09_17_155925_add_score_to_question_options_table', '1'),
('255', '2026_09_17_170757_add_deskripsi_and_catatan_to_assessments_table', '1'),
('256', '2026_09_17_222500_update_assessment_types_to_new_types', '1'),
('257', '2026_09_19_035600_create_certificate_templates_table', '1'),
('258', '2026_09_19_041500_add_docx_template_path_to_certificate_templates_table', '1'),
('259', '2026_09_19_043000_add_metadata_fields_to_certificate_templates_table', '1'),
('260', '2026_09_19_050000_seed_topik_1_assessments_and_questions', '1'),
('261', '2026_09_20_051548_setup_final_commitment_module_and_assessment', '2');

-- --------------------------------------------------------
-- Table structure for table `modules`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `modules`;
CREATE TABLE `modules` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `fokus_utama` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ilustrasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `urutan` int NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `guide_modeling` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `guide_role_playing` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `guide_feedback` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `guide_transfer` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `modules`

INSERT INTO `modules` VALUES 
('1', 'Empathy Awareness', 'kesadaran terhadap bullying', 'Mengenali dan memahami konsep dasar empati serta pentingnya dalam kehidupan sosial.', 'Menyadari bentuk-bentuk bullying dan dampaknya bagi diri sendiri dan orang lain.', 'topics/empathy_awareness.png', '1', '1', '2026-09-19 10:07:45', '2026-09-19 10:07:45', '<p>Konselor mengarahkan jalannya modeling dengan langkah-langkah berikut:</p><ol><li><strong>Pemutaran Video & Pengamatan</strong><p>Putar video modeling yang relevan. Instruksikan siswa untuk mengamati gerak-gerik, mimik wajah, dan dialog antar tokoh di dalam video.</p></li><li><strong>Refleksi & Tanya Jawab</strong><p>Ajak siswa melakukan tanya jawab singkat mengenai perilaku yang mereka saksikan. Tekankan pada perbedaan bercanda dan bullying.</p></li></ol>', '<p>Konselor membagi kelompok dan memandu role playing:</p><ol><li><strong>Pembagian Skenario & Peran</strong><p>Bagi kelas menjadi kelompok kecil (3-4 orang). Berikan kartu situasi dan minta mereka berbagi peran secara adil sesuai skenario.</p></li><li><strong>Simulasi & Peragaan</strong><p>Arahkan kelompok untuk mensimulasikan situasi di kartu secara bergantian, lalu diskusikan pertanyaan pemantik dalam kelompok.</p></li></ol>', '<p>Berikan umpan balik langsung setelah siswa mempraktikkan skenario Kartu Situasi di depan kelas:</p><ol><li><strong>Penguatan Sosial (Social Reinforcement)</strong><p>Puji keaktifan kelompok dalam bermain peran. Sebutkan secara spesifik tindakan empati yang diperagakan dengan baik, seperti cara menenangkan korban, nada bicara yang tenang, atau gestur bersahabat.</p></li><li><strong>Koreksi & Modifikasi Respon</strong><p>Jika ada respon yang kurang tepat (misal: malah ikut terpancing emosi, menyalahkan korban, atau mengabaikan situasi), diskusikan bersama bagaimana cara memperbaikinya dan peragakan ulang respon yang benar.</p></li><li><strong>Diskusi Reflektif</strong><p>Ajak siswa lain (audiens) untuk mengemukakan pendapat mereka mengenai kelebihan dan kekurangan simulasi yang ditampilkan temannya untuk menumbuhkan pemahaman kolektif.</p></li></ol>', '<p>Mendorong integrasi perilaku empati dalam kehidupan sehari-hari siswa:</p><ol><li><strong>Pengisian Lembar Kerja (LKPD)</strong><p>Membagikan LKPD Ujian Online atau mengarahkan peserta didik membuka menu asesmen LKPD di platform LENTERA untuk dijawab secara objektif.</p></li><li><strong>Rencana Tindakan Nyata & Komitmen</strong><p>Meminta siswa merancang satu rencana aksi nyata yang akan mereka terapkan selama satu minggu ke depan dan mengisi Lembar Komitmen Perilaku Anti-Bullying.</p></li></ol>'),
('2', 'Emotional Empathy', 'mengenali dan memahami emosi korban', 'Mengembangkan kemampuan merasakan emosi orang lain secara mendalam.', 'Mengenal dan memahami perasaan seperti takut, sedih, malu, atau tertekan yang dialami korban.', 'topics/emotional_empathy.png', '2', '1', '2026-09-19 10:07:45', '2026-09-19 10:07:45', '<p>Konselor mengarahkan jalannya modeling dengan langkah-langkah berikut:</p><ol><li><strong>Pemutaran Video & Pengamatan</strong><p>Putar video modeling yang relevan. Instruksikan siswa untuk mengamati gerak-gerik, mimik wajah, dan dialog antar tokoh di dalam video.</p></li><li><strong>Refleksi & Tanya Jawab</strong><p>Ajak siswa melakukan tanya jawab singkat mengenai perilaku yang mereka saksikan. Tekankan pada perbedaan bercanda dan bullying.</p></li></ol>', '<p>Konselor membagi kelompok dan memandu role playing:</p><ol><li><strong>Pembagian Skenario & Peran</strong><p>Bagi kelas menjadi kelompok kecil (3-4 orang). Berikan kartu situasi dan minta mereka berbagi peran secara adil sesuai skenario.</p></li><li><strong>Simulasi & Peragaan</strong><p>Arahkan kelompok untuk mensimulasikan situasi di kartu secara bergantian, lalu diskusikan pertanyaan pemantik dalam kelompok.</p></li></ol>', '<p>Berikan umpan balik langsung setelah siswa mempraktikkan skenario Kartu Situasi di depan kelas:</p><ol><li><strong>Penguatan Sosial (Social Reinforcement)</strong><p>Puji keaktifan kelompok dalam bermain peran. Sebutkan secara spesifik tindakan empati yang diperagakan dengan baik, seperti cara menenangkan korban, nada bicara yang tenang, atau gestur bersahabat.</p></li><li><strong>Koreksi & Modifikasi Respon</strong><p>Jika ada respon yang kurang tepat (misal: malah ikut terpancing emosi, menyalahkan korban, atau mengabaikan situasi), diskusikan bersama bagaimana cara memperbaikinya dan peragakan ulang respon yang benar.</p></li><li><strong>Diskusi Reflektif</strong><p>Ajak siswa lain (audiens) untuk mengemukakan pendapat mereka mengenai kelebihan dan kekurangan simulasi yang ditampilkan temannya untuk menumbuhkan pemahaman kolektif.</p></li></ol>', '<p>Mendorong integrasi perilaku empati dalam kehidupan sehari-hari siswa:</p><ol><li><strong>Pengisian Lembar Kerja (LKPD)</strong><p>Membagikan LKPD Ujian Online atau mengarahkan peserta didik membuka menu asesmen LKPD di platform LENTERA untuk dijawab secara objektif.</p></li><li><strong>Rencana Tindakan Nyata & Komitmen</strong><p>Meminta siswa merancang satu rencana aksi nyata yang akan mereka terapkan selama satu minggu ke depan dan mengisi Lembar Komitmen Perilaku Anti-Bullying.</p></li></ol>'),
('3', 'Cognitive Empathy / Perspective Taking', 'melihat situasi dari sudut pandang orang lain', 'Melatih kemampuan memahami sudut pandang dan pemikiran orang lain.', 'Belajar memahami alasan, perasaan, dan pengalaman orang lain dalam situasi tertentu.', 'topics/cognitive_empathy.png', '3', '1', '2026-09-19 10:07:45', '2026-09-19 10:07:45', '<p>Konselor mengarahkan jalannya modeling dengan langkah-langkah berikut:</p><ol><li><strong>Pemutaran Video & Pengamatan</strong><p>Putar video modeling yang relevan. Instruksikan siswa untuk mengamati gerak-gerik, mimik wajah, dan dialog antar tokoh di dalam video.</p></li><li><strong>Refleksi & Tanya Jawab</strong><p>Ajak siswa melakukan tanya jawab singkat mengenai perilaku yang mereka saksikan. Tekankan pada perbedaan bercanda dan bullying.</p></li></ol>', '<p>Konselor membagi kelompok dan memandu role playing:</p><ol><li><strong>Pembagian Skenario & Peran</strong><p>Bagi kelas menjadi kelompok kecil (3-4 orang). Berikan kartu situasi dan minta mereka berbagi peran secara adil sesuai skenario.</p></li><li><strong>Simulasi & Peragaan</strong><p>Arahkan kelompok untuk mensimulasikan situasi di kartu secara bergantian, lalu diskusikan pertanyaan pemantik dalam kelompok.</p></li></ol>', '<p>Berikan umpan balik langsung setelah siswa mempraktikkan skenario Kartu Situasi di depan kelas:</p><ol><li><strong>Penguatan Sosial (Social Reinforcement)</strong><p>Puji keaktifan kelompok dalam bermain peran. Sebutkan secara spesifik tindakan empati yang diperagakan dengan baik, seperti cara menenangkan korban, nada bicara yang tenang, atau gestur bersahabat.</p></li><li><strong>Koreksi & Modifikasi Respon</strong><p>Jika ada respon yang kurang tepat (misal: malah ikut terpancing emosi, menyalahkan korban, atau mengabaikan situasi), diskusikan bersama bagaimana cara memperbaikinya dan peragakan ulang respon yang benar.</p></li><li><strong>Diskusi Reflektif</strong><p>Ajak siswa lain (audiens) untuk mengemukakan pendapat mereka mengenai kelebihan dan kekurangan simulasi yang ditampilkan temannya untuk menumbuhkan pemahaman kolektif.</p></li></ol>', '<p>Mendorong integrasi perilaku empati dalam kehidupan sehari-hari siswa:</p><ol><li><strong>Pengisian Lembar Kerja (LKPD)</strong><p>Membagikan LKPD Ujian Online atau mengarahkan peserta didik membuka menu asesmen LKPD di platform LENTERA untuk dijawab secara objektif.</p></li><li><strong>Rencana Tindakan Nyata & Komitmen</strong><p>Meminta siswa merancang satu rencana aksi nyata yang akan mereka terapkan selama satu minggu ke depan dan mengisi Lembar Komitmen Perilaku Anti-Bullying.</p></li></ol>'),
('4', 'Empathic Response', 'memberikan respons yang mendukung dan membantu', 'Belajar merespons secara tepat dan efektif terhadap emosi orang lain.', 'Memberikan dukungan, bantuan, atau respons positif kepada teman yang membutuhkan.', 'topics/empathic_response.png', '4', '1', '2026-09-19 10:07:45', '2026-09-19 10:07:45', '<p>Konselor mengarahkan jalannya modeling dengan langkah-langkah berikut:</p><ol><li><strong>Pemutaran Video & Pengamatan</strong><p>Putar video modeling yang relevan. Instruksikan siswa untuk mengamati gerak-gerik, mimik wajah, dan dialog antar tokoh di dalam video.</p></li><li><strong>Refleksi & Tanya Jawab</strong><p>Ajak siswa melakukan tanya jawab singkat mengenai perilaku yang mereka saksikan. Tekankan pada perbedaan bercanda dan bullying.</p></li></ol>', '<p>Konselor membagi kelompok dan memandu role playing:</p><ol><li><strong>Pembagian Skenario & Peran</strong><p>Bagi kelas menjadi kelompok kecil (3-4 orang). Berikan kartu situasi dan minta mereka berbagi peran secara adil sesuai skenario.</p></li><li><strong>Simulasi & Peragaan</strong><p>Arahkan kelompok untuk mensimulasikan situasi di kartu secara bergantian, lalu diskusikan pertanyaan pemantik dalam kelompok.</p></li></ol>', '<p>Berikan umpan balik langsung setelah siswa mempraktikkan skenario Kartu Situasi di depan kelas:</p><ol><li><strong>Penguatan Sosial (Social Reinforcement)</strong><p>Puji keaktifan kelompok dalam bermain peran. Sebutkan secara spesifik tindakan empati yang diperagakan dengan baik, seperti cara menenangkan korban, nada bicara yang tenang, atau gestur bersahabat.</p></li><li><strong>Koreksi & Modifikasi Respon</strong><p>Jika ada respon yang kurang tepat (misal: malah ikut terpancing emosi, menyalahkan korban, atau mengabaikan situasi), diskusikan bersama bagaimana cara memperbaikinya dan peragakan ulang respon yang benar.</p></li><li><strong>Diskusi Reflektif</strong><p>Ajak siswa lain (audiens) untuk mengemukakan pendapat mereka mengenai kelebihan dan kekurangan simulasi yang ditampilkan temannya untuk menumbuhkan pemahaman kolektif.</p></li></ol>', '<p>Mendorong integrasi perilaku empati dalam kehidupan sehari-hari siswa:</p><ol><li><strong>Pengisian Lembar Kerja (LKPD)</strong><p>Membagikan LKPD Ujian Online atau mengarahkan peserta didik membuka menu asesmen LKPD di platform LENTERA untuk dijawab secara objektif.</p></li><li><strong>Rencana Tindakan Nyata & Komitmen</strong><p>Meminta siswa merancang satu rencana aksi nyata yang akan mereka terapkan selama satu minggu ke depan dan mengisi Lembar Komitmen Perilaku Anti-Bullying.</p></li></ol>'),
('5', 'Prosocial Behavior', 'mewujudkan empati dalam perilaku sehari-hari', 'Menerapkan perilaku prososial dan kepedulian sosial dalam kehidupan sehari-hari.', 'Menerapkan empati dalam perilaku prososial untuk menciptakan lingkungan sekolah yang aman dan inklusif.', 'topics/prosocial_behavior.png', '5', '1', '2026-09-19 10:07:45', '2026-09-19 10:07:45', '<p>Konselor mengarahkan jalannya modeling dengan langkah-langkah berikut:</p><ol><li><strong>Pemutaran Video & Pengamatan</strong><p>Putar video modeling yang relevan. Instruksikan siswa untuk mengamati gerak-gerik, mimik wajah, dan dialog antar tokoh di dalam video.</p></li><li><strong>Refleksi & Tanya Jawab</strong><p>Ajak siswa melakukan tanya jawab singkat mengenai perilaku yang mereka saksikan. Tekankan pada perbedaan bercanda dan bullying.</p></li></ol>', '<p>Konselor membagi kelompok dan memandu role playing:</p><ol><li><strong>Pembagian Skenario & Peran</strong><p>Bagi kelas menjadi kelompok kecil (3-4 orang). Berikan kartu situasi dan minta mereka berbagi peran secara adil sesuai skenario.</p></li><li><strong>Simulasi & Peragaan</strong><p>Arahkan kelompok untuk mensimulasikan situasi di kartu secara bergantian, lalu diskusikan pertanyaan pemantik dalam kelompok.</p></li></ol>', '<p>Berikan umpan balik langsung setelah siswa mempraktikkan skenario Kartu Situasi di depan kelas:</p><ol><li><strong>Penguatan Sosial (Social Reinforcement)</strong><p>Puji keaktifan kelompok dalam bermain peran. Sebutkan secara spesifik tindakan empati yang diperagakan dengan baik, seperti cara menenangkan korban, nada bicara yang tenang, atau gestur bersahabat.</p></li><li><strong>Koreksi & Modifikasi Respon</strong><p>Jika ada respon yang kurang tepat (misal: malah ikut terpancing emosi, menyalahkan korban, atau mengabaikan situasi), diskusikan bersama bagaimana cara memperbaikinya dan peragakan ulang respon yang benar.</p></li><li><strong>Diskusi Reflektif</strong><p>Ajak siswa lain (audiens) untuk mengemukakan pendapat mereka mengenai kelebihan dan kekurangan simulasi yang ditampilkan temannya untuk menumbuhkan pemahaman kolektif.</p></li></ol>', '<p>Mendorong integrasi perilaku empati dalam kehidupan sehari-hari siswa:</p><ol><li><strong>Pengisian Lembar Kerja (LKPD)</strong><p>Membagikan LKPD Ujian Online atau mengarahkan peserta didik membuka menu asesmen LKPD di platform LENTERA untuk dijawab secara objektif.</p></li><li><strong>Rencana Tindakan Nyata & Komitmen</strong><p>Meminta siswa merancang satu rencana aksi nyata yang akan mereka terapkan selama satu minggu ke depan dan mengisi Lembar Komitmen Perilaku Anti-Bullying.</p></li></ol>'),
('6', 'Lembar Komitmen Siswa', 'Tahap Akhir Layanan Model LENTERA', 'Nyatakan komitmen perilaku empati dan anti-perundungan Anda setelah menyelesaikan seluruh rangkaian 5 topik pembelajaran Model LENTERA.', NULL, NULL, '6', '1', '2026-09-19 11:38:42', '2026-09-20 05:16:09', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------
-- Table structure for table `password_reset_tokens`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `question_options`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `question_options`;
CREATE TABLE `question_options` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `question_id` bigint unsigned NOT NULL,
  `label` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `option` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `score` int NOT NULL DEFAULT '0',
  `is_correct` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `question_options_question_id_foreign` (`question_id`),
  CONSTRAINT `question_options_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=336 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `question_options`

INSERT INTO `question_options` VALUES 
('49', '13', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-19 10:07:45', '2026-09-19 10:07:45'),
('50', '13', 'S', 'Sesuai', '3', '0', '2026-09-19 10:07:45', '2026-09-19 10:07:45'),
('51', '13', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-19 10:07:45', '2026-09-19 10:07:45'),
('52', '13', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-19 10:07:45', '2026-09-19 10:07:45'),
('53', '14', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-19 10:07:45', '2026-09-19 10:07:45'),
('54', '14', 'S', 'Sesuai', '3', '0', '2026-09-19 10:07:45', '2026-09-19 10:07:45'),
('55', '14', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-19 10:07:45', '2026-09-19 10:07:45'),
('56', '14', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-19 10:07:45', '2026-09-19 10:07:45'),
('57', '15', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-19 10:07:45', '2026-09-19 10:07:45'),
('58', '15', 'S', 'Sesuai', '3', '0', '2026-09-19 10:07:45', '2026-09-19 10:07:45'),
('59', '15', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-19 10:07:45', '2026-09-19 10:07:45'),
('60', '15', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-19 10:07:45', '2026-09-19 10:07:45'),
('61', '16', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-19 10:07:45', '2026-09-19 10:07:45'),
('62', '16', 'S', 'Sesuai', '3', '0', '2026-09-19 10:07:45', '2026-09-19 10:07:45'),
('63', '16', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('64', '16', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('65', '17', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('66', '17', 'S', 'Sesuai', '3', '0', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('67', '17', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('68', '17', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('69', '18', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('70', '18', 'S', 'Sesuai', '3', '0', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('71', '18', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('72', '18', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('73', '19', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('74', '19', 'S', 'Sesuai', '3', '0', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('75', '19', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('76', '19', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('77', '20', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('78', '20', 'S', 'Sesuai', '3', '0', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('79', '20', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('80', '20', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('81', '21', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('82', '21', 'S', 'Sesuai', '3', '0', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('83', '21', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('84', '21', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('85', '22', 'SS', 'Sangat Sesuai', '1', '0', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('86', '22', 'S', 'Sesuai', '2', '0', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('87', '22', 'KS', 'Kurang Sesuai', '3', '0', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('88', '22', 'TS', 'Tidak Sesuai', '4', '1', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('89', '23', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('90', '23', 'S', 'Sesuai', '3', '0', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('91', '23', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('92', '23', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('93', '24', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('94', '24', 'S', 'Sesuai', '3', '0', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('95', '24', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('96', '24', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('97', '25', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('98', '25', 'S', 'Sesuai', '3', '0', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('99', '25', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('100', '25', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('101', '26', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('102', '26', 'S', 'Sesuai', '3', '0', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('103', '26', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('104', '26', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('105', '28', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-19 11:13:00', '2026-09-19 11:13:00'),
('106', '28', 'S', 'Sesuai', '3', '0', '2026-09-19 11:13:00', '2026-09-19 11:13:00'),
('107', '28', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-19 11:13:00', '2026-09-19 11:13:00'),
('108', '28', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-19 11:13:00', '2026-09-19 11:13:00'),
('109', '29', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-19 11:13:28', '2026-09-19 11:13:28'),
('110', '29', 'S', 'Sesuai', '3', '0', '2026-09-19 11:13:28', '2026-09-19 11:13:28'),
('111', '29', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-19 11:13:28', '2026-09-19 11:13:28'),
('112', '29', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-19 11:13:28', '2026-09-19 11:13:28'),
('113', '30', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-19 11:13:46', '2026-09-19 11:13:46'),
('114', '30', 'S', 'Sesuai', '3', '0', '2026-09-19 11:13:47', '2026-09-19 11:13:47'),
('115', '30', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-19 11:13:47', '2026-09-19 11:13:47'),
('116', '30', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-19 11:13:47', '2026-09-19 11:13:47'),
('117', '31', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-19 11:14:05', '2026-09-19 11:14:05'),
('118', '31', 'S', 'Sesuai', '3', '0', '2026-09-19 11:14:05', '2026-09-19 11:14:05'),
('119', '31', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-19 11:14:05', '2026-09-19 11:14:05'),
('120', '31', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-19 11:14:05', '2026-09-19 11:14:05'),
('121', '32', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-19 11:14:23', '2026-09-19 11:14:23'),
('122', '32', 'S', 'Sesuai', '3', '0', '2026-09-19 11:14:23', '2026-09-19 11:14:23'),
('123', '32', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-19 11:14:23', '2026-09-19 11:14:23'),
('124', '32', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-19 11:14:23', '2026-09-19 11:14:23'),
('125', '33', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-19 11:14:38', '2026-09-19 11:14:38'),
('126', '33', 'S', 'Sesuai', '3', '0', '2026-09-19 11:14:38', '2026-09-19 11:14:38'),
('127', '33', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-19 11:14:38', '2026-09-19 11:14:38'),
('128', '33', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-19 11:14:38', '2026-09-19 11:14:38'),
('129', '34', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-19 11:15:47', '2026-09-19 11:15:47'),
('130', '34', 'S', 'Sesuai', '3', '0', '2026-09-19 11:15:47', '2026-09-19 11:15:47'),
('131', '34', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-19 11:15:47', '2026-09-19 11:15:47'),
('132', '34', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-19 11:15:47', '2026-09-19 11:15:47'),
('133', '35', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-19 11:16:07', '2026-09-19 11:16:07'),
('134', '35', 'S', 'Sesuai', '3', '0', '2026-09-19 11:16:07', '2026-09-19 11:16:07'),
('135', '35', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-19 11:16:07', '2026-09-19 11:16:07'),
('136', '35', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-19 11:16:07', '2026-09-19 11:16:07'),
('137', '36', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-19 11:16:25', '2026-09-19 11:16:25'),
('138', '36', 'S', 'Sesuai', '3', '0', '2026-09-19 11:16:25', '2026-09-19 11:16:25'),
('139', '36', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-19 11:16:25', '2026-09-19 11:16:25'),
('140', '36', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-19 11:16:25', '2026-09-19 11:16:25'),
('141', '37', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-19 11:17:15', '2026-09-19 11:17:15'),
('142', '37', 'S', 'Sesuai', '3', '0', '2026-09-19 11:17:15', '2026-09-19 11:17:15'),
('143', '37', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-19 11:17:15', '2026-09-19 11:17:15'),
('144', '37', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-19 11:17:15', '2026-09-19 11:17:15'),
('145', '38', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-19 11:20:48', '2026-09-19 11:20:48'),
('146', '38', 'S', 'Sesuai', '3', '0', '2026-09-19 11:20:48', '2026-09-19 11:20:48'),
('147', '38', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-19 11:20:48', '2026-09-19 11:20:48'),
('148', '38', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-19 11:20:48', '2026-09-19 11:20:48');
INSERT INTO `question_options` VALUES 
('149', '39', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-19 11:21:18', '2026-09-19 11:21:18'),
('150', '39', 'S', 'Sesuai', '3', '0', '2026-09-19 11:21:18', '2026-09-19 11:21:18'),
('151', '39', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-19 11:21:18', '2026-09-19 11:21:18'),
('152', '39', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-19 11:21:18', '2026-09-19 11:21:18'),
('153', '40', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-19 11:22:02', '2026-09-19 11:22:02'),
('154', '40', 'S', 'Sesuai', '3', '0', '2026-09-19 11:22:02', '2026-09-19 11:22:02'),
('155', '40', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-19 11:22:02', '2026-09-19 11:22:02'),
('156', '40', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-19 11:22:02', '2026-09-19 11:22:02'),
('157', '41', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-19 11:22:31', '2026-09-19 11:22:31'),
('158', '41', 'S', 'Sesuai', '3', '0', '2026-09-19 11:22:31', '2026-09-19 11:22:31'),
('159', '41', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-19 11:22:31', '2026-09-19 11:22:31'),
('160', '41', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-19 11:22:31', '2026-09-19 11:22:31'),
('163', '43', 'A', 'Menghargai perasaan dan keberadaan orang lain', '0', '0', '2026-09-20 05:16:09', '2026-09-20 05:16:09'),
('164', '43', 'B', 'Tidak ikut melakukan atau menyebarkan perundungan', '0', '0', '2026-09-20 05:16:09', '2026-09-20 05:16:09'),
('165', '43', 'C', 'Berusaha memahami sudut pandang dan perasaan orang lain', '0', '0', '2026-09-20 05:16:09', '2026-09-20 05:16:09'),
('166', '43', 'D', 'Menunjukkan kepedulian dan membantu teman yang mengalami kesulitan', '0', '0', '2026-09-20 05:16:09', '2026-09-20 05:16:09'),
('167', '43', 'E', 'Ikut menciptakan lingkungan pertemanan yang aman, nyaman, dan saling menghargai', '0', '0', '2026-09-20 05:16:09', '2026-09-20 05:16:09'),
('168', '45', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-20 08:09:57', '2026-09-20 08:09:57'),
('169', '45', 'S', 'Sesuai', '3', '0', '2026-09-20 08:09:57', '2026-09-20 08:09:57'),
('170', '45', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-20 08:09:57', '2026-09-20 08:09:57'),
('171', '45', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-20 08:09:57', '2026-09-20 08:09:57'),
('172', '46', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-20 08:10:17', '2026-09-20 08:10:17'),
('173', '46', 'S', 'Sesuai', '3', '0', '2026-09-20 08:10:17', '2026-09-20 08:10:17'),
('174', '46', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-20 08:10:17', '2026-09-20 08:10:17'),
('175', '46', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-20 08:10:17', '2026-09-20 08:10:17'),
('176', '47', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-20 08:10:30', '2026-09-20 08:10:30'),
('177', '47', 'S', 'Sesuai', '3', '0', '2026-09-20 08:10:30', '2026-09-20 08:10:30'),
('178', '47', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-20 08:10:30', '2026-09-20 08:10:30'),
('179', '47', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-20 08:10:30', '2026-09-20 08:10:30'),
('180', '48', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-20 08:10:50', '2026-09-20 08:10:50'),
('181', '48', 'S', 'Sesuai', '3', '0', '2026-09-20 08:10:50', '2026-09-20 08:10:50'),
('182', '48', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-20 08:10:50', '2026-09-20 08:10:50'),
('183', '48', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-20 08:10:50', '2026-09-20 08:10:50'),
('184', '49', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-20 08:11:07', '2026-09-20 08:11:07'),
('185', '49', 'S', 'Sesuai', '3', '0', '2026-09-20 08:11:07', '2026-09-20 08:11:07'),
('186', '49', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-20 08:11:07', '2026-09-20 08:11:07'),
('187', '49', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-20 08:11:07', '2026-09-20 08:11:07'),
('188', '50', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-20 08:11:27', '2026-09-20 08:11:27'),
('189', '50', 'S', 'Sesuai', '3', '0', '2026-09-20 08:11:27', '2026-09-20 08:11:27'),
('190', '50', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-20 08:11:27', '2026-09-20 08:11:27'),
('191', '50', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-20 08:11:27', '2026-09-20 08:11:27'),
('192', '51', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-20 08:12:35', '2026-09-20 08:12:35'),
('193', '51', 'S', 'Sesuai', '3', '0', '2026-09-20 08:12:35', '2026-09-20 08:12:35'),
('194', '51', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-20 08:12:35', '2026-09-20 08:12:35'),
('195', '51', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-20 08:12:35', '2026-09-20 08:12:35'),
('196', '52', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-20 08:12:51', '2026-09-20 08:12:51'),
('197', '52', 'S', 'Sesuai', '3', '0', '2026-09-20 08:12:51', '2026-09-20 08:12:51'),
('198', '52', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-20 08:12:51', '2026-09-20 08:12:51'),
('199', '52', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-20 08:12:51', '2026-09-20 08:12:51'),
('200', '53', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-20 08:13:14', '2026-09-20 08:13:14'),
('201', '53', 'S', 'Sesuai', '3', '0', '2026-09-20 08:13:14', '2026-09-20 08:13:14'),
('202', '53', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-20 08:13:14', '2026-09-20 08:13:14'),
('203', '53', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-20 08:13:14', '2026-09-20 08:13:14'),
('204', '54', 'SS', 'Sangat Sesuai', '1', '1', '2026-09-20 08:13:39', '2026-09-20 08:13:39'),
('205', '54', 'S', 'Sesuai', '2', '0', '2026-09-20 08:13:39', '2026-09-20 08:13:39'),
('206', '54', 'KS', 'Kurang Sesuai', '3', '0', '2026-09-20 08:13:39', '2026-09-20 08:13:39'),
('207', '54', 'TS', 'Tidak Sesuai', '4', '0', '2026-09-20 08:13:39', '2026-09-20 08:13:39'),
('208', '55', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-20 08:14:42', '2026-09-20 08:14:42'),
('209', '55', 'S', 'Sesuai', '3', '0', '2026-09-20 08:14:43', '2026-09-20 08:14:43'),
('210', '55', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-20 08:14:43', '2026-09-20 08:14:43'),
('211', '55', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-20 08:14:43', '2026-09-20 08:14:43'),
('212', '56', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-20 08:15:07', '2026-09-20 08:15:07'),
('213', '56', 'S', 'Sesuai', '3', '0', '2026-09-20 08:15:07', '2026-09-20 08:15:07'),
('214', '56', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-20 08:15:07', '2026-09-20 08:15:07'),
('215', '56', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-20 08:15:07', '2026-09-20 08:15:07'),
('216', '57', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-20 08:15:26', '2026-09-20 08:15:26'),
('217', '57', 'S', 'Sesuai', '3', '0', '2026-09-20 08:15:26', '2026-09-20 08:15:26'),
('218', '57', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-20 08:15:26', '2026-09-20 08:15:26'),
('219', '57', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-20 08:15:26', '2026-09-20 08:15:26'),
('220', '58', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-20 08:15:41', '2026-09-20 08:15:41'),
('221', '58', 'S', 'Sesuai', '3', '0', '2026-09-20 08:15:41', '2026-09-20 08:15:41'),
('222', '58', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-20 08:15:41', '2026-09-20 08:15:41'),
('223', '58', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-20 08:15:41', '2026-09-20 08:15:41'),
('224', '60', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-21 13:03:58', '2026-09-21 13:03:58'),
('225', '60', 'S', 'Sesuai', '3', '0', '2026-09-21 13:03:58', '2026-09-21 13:03:58'),
('226', '60', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-21 13:03:58', '2026-09-21 13:03:58'),
('227', '60', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-21 13:03:58', '2026-09-21 13:03:58'),
('228', '61', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-21 13:05:21', '2026-09-21 13:05:21'),
('229', '61', 'S', 'Sesuai', '3', '0', '2026-09-21 13:05:21', '2026-09-21 13:05:21'),
('230', '61', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-21 13:05:21', '2026-09-21 13:05:21'),
('231', '61', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-21 13:05:21', '2026-09-21 13:05:21'),
('232', '62', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-21 13:05:48', '2026-09-21 13:05:48'),
('233', '62', 'S', 'Sesuai', '3', '0', '2026-09-21 13:05:48', '2026-09-21 13:05:48'),
('234', '62', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-21 13:05:48', '2026-09-21 13:05:48'),
('235', '62', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-21 13:05:48', '2026-09-21 13:05:48'),
('236', '63', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-21 13:06:17', '2026-09-21 13:06:17'),
('237', '63', 'S', 'Sesuai', '3', '0', '2026-09-21 13:06:17', '2026-09-21 13:06:17'),
('238', '63', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-21 13:06:17', '2026-09-21 13:06:17'),
('239', '63', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-21 13:06:17', '2026-09-21 13:06:17'),
('240', '64', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-21 13:06:36', '2026-09-21 13:06:36'),
('241', '64', 'S', 'Sesuai', '3', '0', '2026-09-21 13:06:36', '2026-09-21 13:06:36'),
('242', '64', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-21 13:06:36', '2026-09-21 13:06:36'),
('243', '64', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-21 13:06:36', '2026-09-21 13:06:36'),
('244', '65', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-21 13:06:58', '2026-09-21 13:06:58'),
('245', '65', 'S', 'Sesuai', '3', '0', '2026-09-21 13:06:58', '2026-09-21 13:06:58'),
('246', '65', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-21 13:06:58', '2026-09-21 13:06:58'),
('247', '65', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-21 13:06:58', '2026-09-21 13:06:58'),
('248', '66', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-21 13:08:23', '2026-09-21 13:08:23'),
('249', '66', 'S', 'Sesuai', '3', '0', '2026-09-21 13:08:23', '2026-09-21 13:08:23'),
('250', '66', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-21 13:08:23', '2026-09-21 13:08:23');
INSERT INTO `question_options` VALUES 
('251', '66', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-21 13:08:23', '2026-09-21 13:08:23'),
('252', '67', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-21 13:08:42', '2026-09-21 13:08:42'),
('253', '67', 'S', 'Sesuai', '3', '0', '2026-09-21 13:08:42', '2026-09-21 13:08:42'),
('254', '67', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-21 13:08:42', '2026-09-21 13:08:42'),
('255', '67', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-21 13:08:42', '2026-09-21 13:08:42'),
('256', '68', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-21 13:09:02', '2026-09-21 13:09:02'),
('257', '68', 'S', 'Sesuai', '3', '0', '2026-09-21 13:09:02', '2026-09-21 13:09:02'),
('258', '68', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-21 13:09:02', '2026-09-21 13:09:02'),
('259', '68', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-21 13:09:02', '2026-09-21 13:09:02'),
('260', '69', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-21 13:09:19', '2026-09-21 13:09:19'),
('261', '69', 'S', 'Sesuai', '3', '0', '2026-09-21 13:09:19', '2026-09-21 13:09:19'),
('262', '69', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-21 13:09:19', '2026-09-21 13:09:19'),
('263', '69', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-21 13:09:19', '2026-09-21 13:09:19'),
('264', '70', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-21 13:10:30', '2026-09-21 13:10:30'),
('265', '70', 'S', 'Sesuai', '3', '0', '2026-09-21 13:10:30', '2026-09-21 13:10:30'),
('266', '70', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-21 13:10:30', '2026-09-21 13:10:30'),
('267', '70', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-21 13:10:30', '2026-09-21 13:10:30'),
('268', '71', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-21 13:10:48', '2026-09-21 13:10:48'),
('269', '71', 'S', 'Sesuai', '3', '0', '2026-09-21 13:10:48', '2026-09-21 13:10:48'),
('270', '71', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-21 13:10:48', '2026-09-21 13:10:48'),
('271', '71', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-21 13:10:48', '2026-09-21 13:10:48'),
('272', '72', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-21 13:11:04', '2026-09-21 13:11:04'),
('273', '72', 'S', 'Sesuai', '3', '0', '2026-09-21 13:11:04', '2026-09-21 13:11:04'),
('274', '72', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-21 13:11:04', '2026-09-21 13:11:04'),
('275', '72', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-21 13:11:04', '2026-09-21 13:11:04'),
('276', '73', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-21 13:11:22', '2026-09-21 13:11:22'),
('277', '73', 'S', 'Sesuai', '3', '0', '2026-09-21 13:11:22', '2026-09-21 13:11:22'),
('278', '73', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-21 13:11:22', '2026-09-21 13:11:22'),
('279', '73', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-21 13:11:22', '2026-09-21 13:11:22'),
('280', '74', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-21 13:15:12', '2026-09-21 13:15:12'),
('281', '74', 'S', 'Sesuai', '3', '0', '2026-09-21 13:15:12', '2026-09-21 13:15:12'),
('282', '74', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-21 13:15:12', '2026-09-21 13:15:12'),
('283', '74', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-21 13:15:12', '2026-09-21 13:15:12'),
('284', '75', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-21 13:15:30', '2026-09-21 13:15:30'),
('285', '75', 'S', 'Sesuai', '3', '0', '2026-09-21 13:15:30', '2026-09-21 13:15:30'),
('286', '75', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-21 13:15:30', '2026-09-21 13:15:30'),
('287', '75', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-21 13:15:30', '2026-09-21 13:15:30'),
('288', '76', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-21 13:15:46', '2026-09-21 13:15:46'),
('289', '76', 'S', 'Sesuai', '3', '0', '2026-09-21 13:15:46', '2026-09-21 13:15:46'),
('290', '76', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-21 13:15:46', '2026-09-21 13:15:46'),
('291', '76', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-21 13:15:46', '2026-09-21 13:15:46'),
('292', '77', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-21 13:16:18', '2026-09-21 13:16:18'),
('293', '77', 'S', 'Sesuai', '3', '0', '2026-09-21 13:16:18', '2026-09-21 13:16:18'),
('294', '77', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-21 13:16:18', '2026-09-21 13:16:18'),
('295', '77', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-21 13:16:18', '2026-09-21 13:16:18'),
('296', '78', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-21 13:16:36', '2026-09-21 13:16:36'),
('297', '78', 'S', 'Sesuai', '3', '0', '2026-09-21 13:16:36', '2026-09-21 13:16:36'),
('298', '78', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-21 13:16:36', '2026-09-21 13:16:36'),
('299', '78', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-21 13:16:36', '2026-09-21 13:16:36'),
('300', '79', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-21 13:16:55', '2026-09-21 13:16:55'),
('301', '79', 'S', 'Sesuai', '3', '0', '2026-09-21 13:16:55', '2026-09-21 13:16:55'),
('302', '79', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-21 13:16:55', '2026-09-21 13:16:55'),
('303', '79', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-21 13:16:55', '2026-09-21 13:16:55'),
('304', '80', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-21 13:18:25', '2026-09-21 13:18:25'),
('305', '80', 'S', 'Sesuai', '3', '0', '2026-09-21 13:18:25', '2026-09-21 13:18:25'),
('306', '80', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-21 13:18:25', '2026-09-21 13:18:25'),
('307', '80', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-21 13:18:25', '2026-09-21 13:18:25'),
('308', '81', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-21 13:18:41', '2026-09-21 13:18:41'),
('309', '81', 'S', 'Sesuai', '3', '0', '2026-09-21 13:18:41', '2026-09-21 13:18:41'),
('310', '81', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-21 13:18:41', '2026-09-21 13:18:41'),
('311', '81', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-21 13:18:41', '2026-09-21 13:18:41'),
('312', '82', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-21 13:18:57', '2026-09-21 13:18:57'),
('313', '82', 'S', 'Sesuai', '3', '0', '2026-09-21 13:18:57', '2026-09-21 13:18:57'),
('314', '82', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-21 13:18:57', '2026-09-21 13:18:57'),
('315', '82', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-21 13:18:58', '2026-09-21 13:18:58'),
('316', '83', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-21 13:19:12', '2026-09-21 13:19:12'),
('317', '83', 'S', 'Sesuai', '3', '0', '2026-09-21 13:19:12', '2026-09-21 13:19:12'),
('318', '83', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-21 13:19:12', '2026-09-21 13:19:12'),
('319', '83', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-21 13:19:12', '2026-09-21 13:19:12'),
('320', '84', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-21 13:20:11', '2026-09-21 13:20:11'),
('321', '84', 'S', 'Sesuai', '3', '0', '2026-09-21 13:20:11', '2026-09-21 13:20:11'),
('322', '84', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-21 13:20:11', '2026-09-21 13:20:11'),
('323', '84', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-21 13:20:11', '2026-09-21 13:20:11'),
('324', '85', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-21 13:20:32', '2026-09-21 13:20:32'),
('325', '85', 'S', 'Sesuai', '3', '0', '2026-09-21 13:20:32', '2026-09-21 13:20:32'),
('326', '85', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-21 13:20:32', '2026-09-21 13:20:32'),
('327', '85', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-21 13:20:32', '2026-09-21 13:20:32'),
('328', '86', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-21 13:20:47', '2026-09-21 13:20:47'),
('329', '86', 'S', 'Sesuai', '3', '0', '2026-09-21 13:20:47', '2026-09-21 13:20:47'),
('330', '86', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-21 13:20:47', '2026-09-21 13:20:47'),
('331', '86', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-21 13:20:47', '2026-09-21 13:20:47'),
('332', '87', 'SS', 'Sangat Sesuai', '4', '1', '2026-09-21 13:21:00', '2026-09-21 13:21:00'),
('333', '87', 'S', 'Sesuai', '3', '0', '2026-09-21 13:21:00', '2026-09-21 13:21:00'),
('334', '87', 'KS', 'Kurang Sesuai', '2', '0', '2026-09-21 13:21:00', '2026-09-21 13:21:00'),
('335', '87', 'TS', 'Tidak Sesuai', '1', '0', '2026-09-21 13:21:00', '2026-09-21 13:21:00');

-- --------------------------------------------------------
-- Table structure for table `questions`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `questions`;
CREATE TABLE `questions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `assessment_id` bigint unsigned NOT NULL,
  `question` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'multiple_choice',
  `score` int NOT NULL DEFAULT '1',
  `urutan` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `questions_assessment_id_foreign` (`assessment_id`),
  CONSTRAINT `questions_assessment_id_foreign` FOREIGN KEY (`assessment_id`) REFERENCES `assessments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `questions`

INSERT INTO `questions` VALUES 
('13', '5', 'Saya dapat membedakan bercanda dengan perilaku yang dapat menyakiti orang lain.', NULL, 'multiple_choice', '4', '1', '2026-09-19 10:07:45', '2026-09-19 10:07:45'),
('14', '5', 'Saya memperhatikan perasaan teman ketika melihat perlakuan yang tidak menyenangkan.', NULL, 'multiple_choice', '4', '2', '2026-09-19 10:07:45', '2026-09-19 10:07:45'),
('15', '5', 'Saya menyadari bahwa perundungan dapat memberikan dampak kepada korban.', NULL, 'multiple_choice', '4', '3', '2026-09-19 10:07:45', '2026-09-19 10:07:45'),
('16', '5', 'Saya tidak langsung menganggap seseorang baik-baik saja hanya karena ia tersenyum.', NULL, 'multiple_choice', '4', '4', '2026-09-19 10:07:45', '2026-09-19 10:07:45'),
('17', '5', 'Saya dapat mengenali perubahan perilaku seseorang ketika mengalami masalah.', NULL, 'multiple_choice', '4', '5', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('18', '5', 'Saya menyadari bahwa teman yang melihat perundungan juga memiliki peran.', NULL, 'multiple_choice', '4', '6', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('19', '6', 'Perasaan Raka perlu diperhatikan meskipun ia mengatakan tidak apa-apa.', NULL, 'multiple_choice', '4', '1', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('20', '6', 'Perubahan perilaku Raka dapat menjadi tanda bahwa ia mengalami masalah.', NULL, 'multiple_choice', '4', '2', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('21', '6', 'Kita perlu memahami situasi sebelum memberikan penilaian.', NULL, 'multiple_choice', '4', '3', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('22', '6', 'Pendapat pelaku saja sudah cukup untuk menentukan bahwa tindakan tersebut tidak bermasalah.', NULL, 'multiple_choice', '4', '4', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('23', '7', 'Saya akan lebih memperhatikan keadaan teman di sekitar saya.', NULL, 'multiple_choice', '4', '1', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('24', '7', 'Saya tidak akan langsung menganggap ejekan sebagai candaan.', NULL, 'multiple_choice', '4', '2', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('25', '7', 'Saya tidak akan ikut menertawakan teman yang menjadi sasaran.', NULL, 'multiple_choice', '4', '3', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('26', '7', 'Saya akan mencari bantuan ketika melihat situasi yang sulit saya tangani sendiri.', NULL, 'multiple_choice', '4', '4', '2026-09-19 10:07:46', '2026-09-19 10:07:46'),
('27', '7', 'Saya berkomitmen untuk :', NULL, 'essay', '1', '5', '2026-09-19 10:14:08', '2026-09-19 10:14:08'),
('28', '8', 'Saya dapat mengenali perasaan seseorang melalui\r\nperilaku atau ekspresinya', NULL, 'single_choice', '1', '1', '2026-09-19 11:13:00', '2026-09-19 11:13:00'),
('29', '8', 'Saya memahami bahwa seseorang dapat\r\nmenyembunyikan perasaan yang sebenarnya.', NULL, 'single_choice', '1', '2', '2026-09-19 11:13:28', '2026-09-19 11:13:28'),
('30', '8', 'Saya berusaha memahami perasaan teman sebelum\r\nmemberikan penilaian.', NULL, 'single_choice', '1', '3', '2026-09-19 11:13:46', '2026-09-19 11:13:46'),
('31', '8', 'Saya menyadari bahwa satu kejadian dapat\r\nmenimbulkan perasaan yang berbeda pada setiap\r\norang.', NULL, 'single_choice', '1', '4', '2026-09-19 11:14:05', '2026-09-19 11:14:05'),
('32', '8', 'Saya dapat mempertimbangkan perasaan korban\r\nketika melihat peristiwa perundungan.', NULL, 'single_choice', '1', '5', '2026-09-19 11:14:23', '2026-09-19 11:14:23'),
('33', '8', 'Saya dapat menunjukkan kepedulian ketika melihat\r\nteman merasa tidak nyaman.', NULL, 'single_choice', '1', '6', '2026-09-19 11:14:38', '2026-09-19 11:14:38'),
('34', '9', 'Nisa mungkin merasa malu karena komentar tersebut\r\ndilihat oleh teman-temannya.', NULL, 'single_choice', '1', '1', '2026-09-19 11:15:47', '2026-09-19 11:15:47'),
('35', '9', 'Nisa mungkin merasa tidak nyaman meskipun tidak\r\nmengatakannya secara langsung.', NULL, 'single_choice', '1', '2', '2026-09-19 11:16:07', '2026-09-19 11:16:07'),
('36', '9', 'Perubahan perilaku Nisa perlu diperhatikan untuk\r\nmemahami keadaannya', NULL, 'single_choice', '1', '3', '2026-09-19 11:16:25', '2026-09-19 11:16:25'),
('37', '9', 'Karena Nisa tidak membalas komentar, berarti Nisa\r\ntidak merasa terganggu.', NULL, 'single_choice', '1', '4', '2026-09-19 11:17:15', '2026-09-19 11:17:15'),
('38', '10', 'Memperhatikan perasaan teman sebelum\r\nmemberikan komentar.', NULL, 'single_choice', '1', '1', '2026-09-19 11:20:48', '2026-09-19 11:20:48'),
('39', '10', 'Tidak menggunakan kelemahan teman sebagai bahan\r\ncandaan.', NULL, 'single_choice', '1', '2', '2026-09-19 11:21:18', '2026-09-19 11:21:18'),
('40', '10', 'Bertanya dengan baik ketika melihat teman tampak\r\ntidak nyaman.', NULL, 'single_choice', '1', '3', '2026-09-19 11:22:02', '2026-09-19 11:22:02'),
('41', '10', 'Berusaha memahami perasaan orang lain sebelum\r\nbertindak.', NULL, 'single_choice', '1', '4', '2026-09-19 11:22:31', '2026-09-19 11:22:31'),
('42', '10', 'Komitmen utama saya\r\nMulai sekarang, saya akan:', NULL, 'essay', '1', '5', '2026-09-19 11:25:11', '2026-09-19 11:25:11'),
('43', '11', 'Setelah mengikuti rangkaian layanan Model LENTERA, saya berkomitmen untuk:', NULL, 'checklist', '0', '1', '2026-09-19 11:44:49', '2026-09-20 05:16:09'),
('44', '11', 'Komitmen pribadi saya:', NULL, 'essay', '0', '2', '2026-09-19 11:45:07', '2026-09-20 05:16:09'),
('45', '2', 'Saya dapat membayangkan bagaimana perasaan\r\norang lain dalam suatu situasi.', NULL, 'single_choice', '1', '1', '2026-09-20 08:09:57', '2026-09-20 08:09:57'),
('46', '2', 'Saya dapat melihat suatu masalah dari sudut pandang\r\norang lain.', NULL, 'single_choice', '1', '2', '2026-09-20 08:10:17', '2026-09-20 08:10:17'),
('47', '2', 'Saya tidak hanya mempertimbangkan sudut pandang\r\ndiri sendiri.', NULL, 'single_choice', '1', '3', '2026-09-20 08:10:30', '2026-09-20 08:10:30'),
('48', '2', 'Saya mempertimbangkan pengalaman seseorang\r\nsebelum menilai tindakannya.', NULL, 'single_choice', '1', '4', '2026-09-20 08:10:50', '2026-09-20 08:10:50'),
('49', '2', 'Saya memahami bahwa orang yang berbeda dapat\r\nmemiliki perasaan berbeda dalam situasi yang sama.', NULL, 'single_choice', '1', '5', '2026-09-20 08:11:07', '2026-09-20 08:11:07'),
('50', '2', 'Saya berusaha memahami keadaan orang lain\r\nsebelum memberikan penilaian.', NULL, 'single_choice', '1', '6', '2026-09-20 08:11:27', '2026-09-20 08:11:27'),
('51', '12', 'Saya mungkin merasa malu karena menjadi perhatian\r\nbanyak orang.', NULL, 'single_choice', '1', '1', '2026-09-20 08:12:35', '2026-09-20 08:12:35'),
('52', '12', 'Saya mungkin merasa tidak nyaman meskipun\r\nmencoba tersenyum.', NULL, 'single_choice', '1', '2', '2026-09-20 08:12:51', '2026-09-20 08:12:51'),
('53', '12', 'Saya mungkin berharap teman memahami bahwa\r\nsaya tidak nyaman.', NULL, 'single_choice', '1', '3', '2026-09-20 08:13:14', '2026-09-20 08:13:14'),
('54', '12', 'Karena saya tersenyum, berarti saya pasti menikmati\r\ncandaan tersebut', NULL, 'single_choice', '1', '4', '2026-09-20 08:13:38', '2026-09-20 08:13:38'),
('55', '13', 'Saya akan mencoba melihat situasi dari sudut\r\npandang orang lain.', NULL, 'single_choice', '1', '1', '2026-09-20 08:14:42', '2026-09-20 08:14:42'),
('56', '13', 'Saya tidak akan menilai perasaan orang lain hanya\r\ndari apa yang terlihat.', NULL, 'single_choice', '1', '2', '2026-09-20 08:15:07', '2026-09-20 08:15:07'),
('57', '13', 'Saya akan mempertimbangkan dampak tindakan saya\r\nterhadap orang lain.', NULL, 'single_choice', '1', '3', '2026-09-20 08:15:26', '2026-09-20 08:15:26'),
('58', '13', 'Saya akan berusaha memahami sebelum memberikan\r\npenilaian.', NULL, 'single_choice', '1', '4', '2026-09-20 08:15:41', '2026-09-20 08:15:41'),
('59', '13', 'Komitmen utama saya\r\nMulai sekarang, saya akan:', NULL, 'essay', '1', '5', '2026-09-20 08:15:53', '2026-09-20 08:15:53'),
('60', '14', 'Saya bersedia menunjukkan kepedulian ketika melihat \r\nteman mengalami kesulitan.', NULL, 'single_choice', '1', '1', '2026-09-21 13:03:58', '2026-09-21 13:03:58'),
('61', '14', 'Saya dapat memilih cara yang tepat untuk membantu \r\nteman.', NULL, 'single_choice', '1', '2', '2026-09-21 13:05:21', '2026-09-21 13:05:21'),
('62', '14', 'Saya dapat membantu tanpa mempermalukan orang yang \r\nsedang mengalami masalah.', NULL, 'single_choice', '1', '3', '2026-09-21 13:05:48', '2026-09-21 13:05:48'),
('63', '14', 'Saya bersedia meminta bantuan orang dewasa ketika \r\nsituasi sulit saya tangani.', NULL, 'single_choice', '1', '4', '2026-09-21 13:06:17', '2026-09-21 13:06:17'),
('64', '14', 'Saya tidak ikut melakukan tindakan yang dapat \r\nmemperburuk keadaan.', NULL, 'single_choice', '1', '5', '2026-09-21 13:06:36', '2026-09-21 13:06:36'),
('65', '14', 'Saya mempertimbangkan keamanan sebelum bertindak \r\nketika melihat perundungan.', NULL, 'single_choice', '1', '6', '2026-09-21 13:06:58', '2026-09-21 13:06:58'),
('66', '15', 'Mendekati teman tersebut dan menanyakan keadaannya.', NULL, 'single_choice', '1', '1', '2026-09-21 13:08:23', '2026-09-21 13:08:23'),
('67', '15', 'Mengajaknya pergi dari situasi tersebut jika ia merasa tidak \r\nnyaman.', NULL, 'single_choice', '1', '2', '2026-09-21 13:08:42', '2026-09-21 13:08:42'),
('68', '15', 'Meminta bantuan guru jika situasi sulit ditangani sendiri.', NULL, 'single_choice', '1', '3', '2026-09-21 13:09:02', '2026-09-21 13:09:02'),
('69', '15', 'Membalas pelaku dengan tindakan yang sama agar mereka \r\nmerasakan akibatnya.', NULL, 'single_choice', '1', '4', '2026-09-21 13:09:19', '2026-09-21 13:09:19'),
('70', '16', 'Saya akan membantu teman yang membutuhkan dukungan.', NULL, 'single_choice', '1', '1', '2026-09-21 13:10:30', '2026-09-21 13:10:30'),
('71', '16', 'Saya akan menggunakan cara yang aman ketika \r\nmenghadapi perundungan.', NULL, 'single_choice', '1', '2', '2026-09-21 13:10:48', '2026-09-21 13:10:48'),
('72', '16', 'Saya akan meminta bantuan orang dewasa jika diperlukan.', NULL, 'single_choice', '1', '3', '2026-09-21 13:11:04', '2026-09-21 13:11:04'),
('73', '16', 'Saya tidak akan memperburuk keadaan dengan membalas \r\ntindakan pelaku.', NULL, 'single_choice', '1', '4', '2026-09-21 13:11:22', '2026-09-21 13:11:22'),
('74', '17', 'Saya ikut menjaga lingkungan pertemanan agar aman dan saling menghargai.', NULL, 'single_choice', '1', '1', '2026-09-21 13:15:12', '2026-09-21 13:15:12'),
('75', '17', 'Saya tidak ikut menyebarkan konten yang mempermalukan \r\norang lain.', NULL, 'single_choice', '1', '2', '2026-09-21 13:15:30', '2026-09-21 13:15:30'),
('76', '17', 'Saya berani menunjukkan sikap tidak setuju terhadap \r\nperundungan.', NULL, 'single_choice', '1', '3', '2026-09-21 13:15:46', '2026-09-21 13:15:46'),
('77', '17', 'Saya menghargai perbedaan karakter, penampilan, kemampuan, dan latar belakang teman.', NULL, 'single_choice', '1', '4', '2026-09-21 13:16:18', '2026-09-21 13:16:18'),
('78', '17', 'Saya dapat mengajak teman untuk membangun interaksi \r\nyang positif.', NULL, 'single_choice', '1', '5', '2026-09-21 13:16:36', '2026-09-21 13:16:36'),
('79', '17', 'Saya menyadari bahwa pencegahan perundungan \r\nmerupakan tanggung jawab bersama.', NULL, 'single_choice', '1', '6', '2026-09-21 13:16:55', '2026-09-21 13:16:55'),
('80', '18', 'Tidak ikut menyebarkan konten tersebut.', NULL, 'single_choice', '1', '1', '2026-09-21 13:18:25', '2026-09-21 13:18:25'),
('81', '18', 'Mengingatkan anggota grup dengan cara yang tepat.', NULL, 'single_choice', '1', '2', '2026-09-21 13:18:41', '2026-09-21 13:18:41'),
('82', '18', 'Memberikan dukungan kepada teman yang menjadi \r\nsasaran.', NULL, 'single_choice', '1', '3', '2026-09-21 13:18:57', '2026-09-21 13:18:57'),
('83', '18', 'Membiarkan karena kejadian tersebut bukan masalah \r\npribadi saya.', NULL, 'single_choice', '1', '4', '2026-09-21 13:19:12', '2026-09-21 13:19:12'),
('84', '19', 'Saya akan menjaga komunikasi yang menghargai orang \r\nlain.', NULL, 'single_choice', '1', '1', '2026-09-21 13:20:11', '2026-09-21 13:20:11'),
('85', '19', 'Saya tidak akan ikut menyebarkan penghinaan atau \r\nmempermalukan teman.', NULL, 'single_choice', '1', '2', '2026-09-21 13:20:32', '2026-09-21 13:20:32'),
('86', '19', 'Saya akan mendukung teman yang membutuhkan bantuan.', NULL, 'single_choice', '1', '3', '2026-09-21 13:20:47', '2026-09-21 13:20:47'),
('87', '19', 'Saya akan ikut menciptakan lingkungan pertemanan yang \r\naman dan nyaman.', NULL, 'single_choice', '1', '4', '2026-09-21 13:21:00', '2026-09-21 13:21:00'),
('88', '19', 'Mulai sekarang, saya akan:', NULL, 'essay', '1', '5', '2026-09-21 13:22:30', '2026-09-21 13:22:30');

-- --------------------------------------------------------
-- Table structure for table `roles`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `roles`

INSERT INTO `roles` VALUES 
('1', 'admin', '2026-09-19 10:07:40', '2026-09-19 10:07:40'),
('2', 'konselor', '2026-09-19 10:07:40', '2026-09-19 10:07:40'),
('3', 'siswa', '2026-09-19 10:07:40', '2026-09-19 10:07:40');

-- --------------------------------------------------------
-- Table structure for table `schools`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `schools`;
CREATE TABLE `schools` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `telepon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `npsn` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `schools`

INSERT INTO `schools` VALUES 
('1', 'SMP Negeri Model Blitar', 'Jl. Jenderal Sudirman No. 10, Blitar', '0342-801234', '20100001', NULL, '1', '2026-09-19 10:07:40', '2026-09-19 10:07:40'),
('2', 'SMK Negeri 2 Bandung', 'Jl. Ciliwung No. 4, Bandung', '022-7654321', '20200002', NULL, '1', '2026-09-19 10:07:40', '2026-09-19 10:07:40'),
('3', 'SMP 1 BATU', 'BATU', '0000', NULL, NULL, '1', '2026-09-19 10:11:13', '2026-09-19 10:11:27'),
('4', 'SMP 1 TANGGUL', 'JL.Raya Tanggul', '1234', '12345', NULL, '1', '2026-09-21 13:40:04', '2026-09-21 13:40:04');

-- --------------------------------------------------------
-- Table structure for table `sessions`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `sessions`

INSERT INTO `sessions` VALUES 
('CaMlANLhXhi06H9FVOGoEdVLyzSrwKKYAQUu8ShA', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', 'eyJfdG9rZW4iOiJSMU9jczNpUkVmRjdYUHI5YVgzSVJ6WU5IQUpVcHo1a1NNNXlmejh0IiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvbGVudGVyYS13ZWIudGVzdFwvbG9naW4iLCJyb3V0ZSI6ImxvZ2luIn19', '1790060490'),
('D0jArTW7XZvupZIOsMfE5Xr0CYYC8MdoD7JUiRPP', '15', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', 'eyJfdG9rZW4iOiJRdXlKbFE4MHVLSk94Wm1ENjJJeTZBb2Z3ZFpkQ1d0ckd0UnRkUmZZIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xlbnRlcmEtd2ViLnRlc3RcL3N0dWRlbnRcL2Fzc2Vzc21lbnRcLzExXC9yZXN1bHQiLCJyb3V0ZSI6InN0dWRlbnQuYXNzZXNzbWVudC5yZXN1bHQifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6MTV9', '1790046224'),
('VZE31hEIpYSFz0WpgqVjLcdKeFNnvYoDl629nXbI', '16', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', 'eyJfdG9rZW4iOiJxQ0YzblJuZ1BhVXEwQnNlTTdMOUZMZVdOQkZtTXhVaGxSb1YwaHhSIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvbGVudGVyYS13ZWIudGVzdFwvY291bnNlbG9yXC9zdHVkZW50c1wvMTFcL2NlcnRpZmljYXRlIiwicm91dGUiOiJjb3Vuc2Vsb3IubW9uaXRvcmluZy5zdHVkZW50LmNlcnRpZmljYXRlIn0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoxNn0=', '1790001111');

-- --------------------------------------------------------
-- Table structure for table `student_evaluations`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `student_evaluations`;
CREATE TABLE `student_evaluations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint unsigned NOT NULL,
  `module_id` bigint unsigned NOT NULL,
  `lkpd_score` int DEFAULT NULL,
  `lkpd_note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `self_score` int DEFAULT NULL,
  `self_note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `commitment_score` int DEFAULT NULL,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `commitment_note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_evaluations_student_id_module_id_unique` (`student_id`,`module_id`),
  KEY `student_evaluations_module_id_foreign` (`module_id`),
  CONSTRAINT `student_evaluations_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE,
  CONSTRAINT `student_evaluations_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `student_evaluations`

INSERT INTO `student_evaluations` VALUES 
('1', '8', '1', '14', 'Siswa ini baik', '22', 'Siswa ini baik', '15', 'Siswa ini baik', 'Siswa ini baik', '2026-09-19 10:15:01', '2026-09-19 10:20:24'),
('2', '8', '2', '12', NULL, '20', NULL, '14', NULL, NULL, '2026-09-19 11:26:06', '2026-09-19 11:27:23'),
('3', '8', '3', '12', NULL, NULL, NULL, '14', NULL, NULL, '2026-09-20 07:49:29', '2026-09-20 08:39:16'),
('4', '8', '4', '3', NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-20 07:49:53', '2026-09-20 07:49:53'),
('5', '8', '5', '1', NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-20 07:50:10', '2026-09-20 07:50:10'),
('6', '8', '6', NULL, NULL, NULL, NULL, '5', NULL, NULL, '2026-09-20 07:50:42', '2026-09-20 07:50:42'),
('7', '1', '1', '14', NULL, '21', NULL, '17', NULL, NULL, '2026-09-21 08:43:55', '2026-09-21 08:45:23'),
('8', '1', '2', '14', NULL, '20', NULL, '15', NULL, NULL, '2026-09-21 08:46:34', '2026-09-21 08:47:42'),
('9', '1', '3', '13', NULL, '21', NULL, '15', NULL, NULL, '2026-09-21 08:48:38', '2026-09-21 08:49:43'),
('10', '1', '4', '2', NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-21 08:50:21', '2026-09-21 08:50:21'),
('11', '1', '5', '3', NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-21 08:57:43', '2026-09-21 08:57:43'),
('12', '1', '6', NULL, NULL, NULL, NULL, '6', NULL, NULL, '2026-09-21 09:02:01', '2026-09-21 09:02:01'),
('13', '11', '1', '12', 'teruslah belajar lebih giat lagi.', '23', 'teruslah belajar lebih giat lagi.', '17', 'teruslah belajar lebih giat lagi.', 'teruslah belajar lebih giat lagi.', '2026-09-21 14:06:18', '2026-09-21 14:31:16'),
('14', '11', '2', '16', NULL, '24', NULL, '17', NULL, NULL, '2026-09-21 14:14:11', '2026-09-21 14:15:38'),
('15', '11', '3', '13', NULL, '24', NULL, '17', NULL, NULL, '2026-09-21 14:17:41', '2026-09-21 14:19:40'),
('16', '11', '4', '9', NULL, '18', NULL, '14', NULL, NULL, '2026-09-21 14:22:49', '2026-09-21 14:23:46'),
('17', '11', '5', '14', NULL, '19', NULL, '15', NULL, NULL, '2026-09-21 14:24:29', '2026-09-21 14:25:37'),
('18', '11', '6', NULL, NULL, NULL, NULL, '6', NULL, NULL, '2026-09-21 14:27:27', '2026-09-21 14:27:27');

-- --------------------------------------------------------
-- Table structure for table `student_progress`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `student_progress`;
CREATE TABLE `student_progress` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint unsigned NOT NULL,
  `module_id` bigint unsigned NOT NULL,
  `assessment_id` bigint unsigned DEFAULT NULL,
  `status` enum('belum_mulai','sedang_mengerjakan','selesai') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'belum_mulai',
  `nilai` decimal(5,2) DEFAULT NULL,
  `answers` json DEFAULT NULL,
  `started_at` timestamp NULL DEFAULT NULL,
  `finished_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `student_progress_student_id_foreign` (`student_id`),
  KEY `student_progress_module_id_foreign` (`module_id`),
  KEY `student_progress_assessment_id_foreign` (`assessment_id`),
  CONSTRAINT `student_progress_assessment_id_foreign` FOREIGN KEY (`assessment_id`) REFERENCES `assessments` (`id`) ON DELETE SET NULL,
  CONSTRAINT `student_progress_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE,
  CONSTRAINT `student_progress_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `student_progress`

INSERT INTO `student_progress` VALUES 
('1', '8', '1', '5', 'selesai', '91.67', '{\"13\": \"49\", \"14\": \"53\", \"15\": \"58\", \"16\": \"61\", \"17\": \"66\", \"18\": \"69\"}', '2026-09-19 10:14:52', '2026-09-19 10:20:25', '2026-09-19 10:14:52', '2026-09-19 10:20:25'),
('2', '8', '1', '6', 'selesai', '87.50', '{\"19\": \"73\", \"20\": \"77\", \"21\": \"81\", \"22\": \"86\"}', '2026-09-19 10:15:13', '2026-09-19 10:20:25', '2026-09-19 10:15:13', '2026-09-19 10:20:25'),
('3', '8', '1', '7', 'selesai', '88.24', '{\"23\": \"89\", \"24\": \"94\", \"25\": \"98\", \"26\": \"101\", \"27\": \"Saya akan jujur\"}', '2026-09-19 10:17:36', '2026-09-19 10:20:25', '2026-09-19 10:17:36', '2026-09-19 10:20:25'),
('4', '8', '2', '8', 'selesai', '83.30', '{\"28\": \"106\", \"29\": \"110\", \"30\": \"114\", \"31\": \"117\", \"32\": \"121\", \"33\": \"126\"}', '2026-09-19 11:25:55', '2026-09-19 11:26:06', '2026-09-19 11:25:55', '2026-09-19 11:26:06'),
('5', '8', '2', '9', 'selesai', '75.00', '{\"34\": \"129\", \"35\": \"134\", \"36\": \"139\", \"37\": \"142\"}', '2026-09-19 11:26:21', '2026-09-19 11:26:33', '2026-09-19 11:26:21', '2026-09-19 11:26:33'),
('6', '8', '2', '10', 'selesai', '82.40', '{\"38\": \"145\", \"39\": \"150\", \"40\": \"154\", \"41\": \"158\", \"42\": \"Saya tidak membuli\"}', '2026-09-19 11:26:47', '2026-09-19 11:27:23', '2026-09-19 11:26:47', '2026-09-19 11:27:23'),
('7', '8', '3', '2', 'selesai', '33.30', '{\"4\": \"13\", \"5\": \"18\", \"6\": \"22\"}', '2026-09-20 07:49:22', '2026-09-20 07:49:29', '2026-09-20 07:49:22', '2026-09-20 07:49:29'),
('8', '8', '4', NULL, 'selesai', '100.00', '{\"7\": \"25\", \"8\": \"29\", \"9\": \"33\"}', '2026-09-20 07:49:44', '2026-09-20 07:49:53', '2026-09-20 07:49:44', '2026-09-20 07:49:53'),
('9', '8', '5', NULL, 'selesai', '33.30', '{\"10\": \"38\", \"11\": \"42\", \"12\": \"45\"}', '2026-09-20 07:50:05', '2026-09-20 07:50:10', '2026-09-20 07:50:05', '2026-09-20 07:50:10'),
('10', '8', '6', '11', 'selesai', '250.00', '{\"43\": [\"163\", \"165\", \"166\", \"167\"], \"44\": \"msdmsdmsdjjsd\\r\\ndkdhd\\r\\nsjdjdk\"}', '2026-09-20 07:50:25', '2026-09-20 07:50:42', '2026-09-20 07:50:25', '2026-09-20 07:50:42'),
('11', '8', '3', '13', 'selesai', '82.40', '{\"55\": \"208\", \"56\": \"213\", \"57\": \"217\", \"58\": \"221\", \"59\": \"skhfs\\r\\nsdjfgs\\r\\nsjdf\"}', '2026-09-20 08:39:02', '2026-09-20 08:39:16', '2026-09-20 08:16:18', '2026-09-20 08:39:16'),
('12', '8', '3', '12', 'selesai', '75.00', '{\"51\": \"192\", \"52\": \"197\", \"53\": \"201\", \"54\": \"205\"}', '2026-09-20 08:24:52', '2026-09-20 08:27:26', '2026-09-20 08:24:31', '2026-09-20 08:27:26'),
('13', '1', '1', '5', 'selesai', '87.50', '{\"13\": \"49\", \"14\": \"53\", \"15\": \"57\", \"16\": \"62\", \"17\": \"66\", \"18\": \"70\"}', '2026-09-21 08:43:39', '2026-09-21 08:43:55', '2026-09-21 08:43:39', '2026-09-21 08:43:55'),
('14', '1', '1', '6', 'selesai', '87.50', '{\"19\": \"73\", \"20\": \"77\", \"21\": \"81\", \"22\": \"86\"}', '2026-09-21 08:44:14', '2026-09-21 08:44:25', '2026-09-21 08:44:14', '2026-09-21 08:44:25'),
('15', '1', '1', '7', 'selesai', '100.00', '{\"23\": \"89\", \"24\": \"93\", \"25\": \"97\", \"26\": \"101\", \"27\": \"menolong teman yg terjatuh.\"}', '2026-09-21 08:44:37', '2026-09-21 08:45:23', '2026-09-21 08:44:37', '2026-09-21 08:45:23'),
('16', '1', '2', '8', 'selesai', '83.30', '{\"28\": \"105\", \"29\": \"109\", \"30\": \"114\", \"31\": \"118\", \"32\": \"122\", \"33\": \"126\"}', '2026-09-21 08:46:19', '2026-09-21 08:46:34', '2026-09-21 08:46:19', '2026-09-21 08:46:34'),
('17', '1', '2', '9', 'selesai', '87.50', '{\"34\": \"129\", \"35\": \"133\", \"36\": \"138\", \"37\": \"142\"}', '2026-09-21 08:46:48', '2026-09-21 08:46:58', '2026-09-21 08:46:48', '2026-09-21 08:46:58'),
('18', '1', '2', '10', 'selesai', '88.20', '{\"38\": \"145\", \"39\": \"149\", \"40\": \"154\", \"41\": \"158\", \"42\": \"saya akan menghormati guru.\"}', '2026-09-21 08:47:13', '2026-09-21 08:47:42', '2026-09-21 08:47:13', '2026-09-21 08:47:42'),
('19', '1', '3', '2', 'selesai', '87.50', '{\"45\": \"168\", \"46\": \"172\", \"47\": \"176\", \"48\": \"181\", \"49\": \"185\", \"50\": \"189\"}', '2026-09-21 08:48:28', '2026-09-21 08:48:38', '2026-09-21 08:48:28', '2026-09-21 08:48:38'),
('20', '1', '3', '12', 'selesai', '81.30', '{\"51\": \"192\", \"52\": \"196\", \"53\": \"201\", \"54\": \"205\"}', '2026-09-21 08:48:52', '2026-09-21 08:49:11', '2026-09-21 08:48:52', '2026-09-21 08:49:11'),
('21', '1', '3', '13', 'selesai', '88.20', '{\"55\": \"208\", \"56\": \"212\", \"57\": \"217\", \"58\": \"221\", \"59\": \"saya akan rajin menabung.\"}', '2026-09-21 08:49:23', '2026-09-21 08:49:43', '2026-09-21 08:49:23', '2026-09-21 08:49:43'),
('22', '1', '4', NULL, 'selesai', '66.70', '{\"7\": \"25\", \"8\": \"29\", \"9\": \"34\"}', '2026-09-21 08:50:12', '2026-09-21 08:50:21', '2026-09-21 08:50:12', '2026-09-21 08:50:21'),
('23', '1', '5', NULL, 'selesai', '100.00', '{\"10\": \"37\", \"11\": \"41\", \"12\": \"45\"}', '2026-09-21 08:57:18', '2026-09-21 08:57:43', '2026-09-21 08:57:18', '2026-09-21 08:57:43'),
('24', '1', '6', '11', 'selesai', '300.00', '{\"43\": [\"163\", \"164\", \"165\", \"166\", \"167\"], \"44\": \"saya akan menjadi charger yg baik utk teman2 dikelas.\"}', '2026-09-21 09:00:52', '2026-09-21 09:02:01', '2026-09-21 09:00:52', '2026-09-21 09:02:01'),
('25', '11', '1', '5', 'selesai', '95.83', '{\"13\": \"49\", \"14\": \"53\", \"15\": \"57\", \"16\": \"61\", \"17\": \"65\", \"18\": \"70\"}', '2026-09-21 14:04:48', '2026-09-21 14:31:16', '2026-09-21 14:04:48', '2026-09-21 14:31:16'),
('26', '11', '1', '6', 'selesai', '75.00', '{\"19\": \"75\", \"20\": \"78\", \"21\": \"81\", \"22\": \"87\"}', '2026-09-21 14:07:02', '2026-09-21 14:31:16', '2026-09-21 14:07:02', '2026-09-21 14:31:16'),
('27', '11', '1', '7', 'selesai', '100.00', '{\"23\": \"89\", \"24\": \"93\", \"25\": \"97\", \"26\": \"101\", \"27\": \"saya akan menolong teman.\"}', '2026-09-21 14:10:48', '2026-09-21 14:31:16', '2026-09-21 14:10:48', '2026-09-21 14:31:16'),
('28', '11', '2', '8', 'selesai', '100.00', '{\"28\": \"105\", \"29\": \"109\", \"30\": \"113\", \"31\": \"117\", \"32\": \"121\", \"33\": \"125\"}', '2026-09-21 14:14:01', '2026-09-21 14:14:11', '2026-09-21 14:14:01', '2026-09-21 14:14:11'),
('29', '11', '2', '9', 'selesai', '100.00', '{\"34\": \"129\", \"35\": \"133\", \"36\": \"137\", \"37\": \"141\"}', '2026-09-21 14:14:26', '2026-09-21 14:14:34', '2026-09-21 14:14:26', '2026-09-21 14:14:34'),
('30', '11', '2', '10', 'selesai', '100.00', '{\"38\": \"145\", \"39\": \"149\", \"40\": \"153\", \"41\": \"157\", \"42\": \"saya akan menabung.\"}', '2026-09-21 14:14:49', '2026-09-21 14:15:38', '2026-09-21 14:14:49', '2026-09-21 14:15:38'),
('31', '11', '3', '2', 'selesai', '100.00', '{\"45\": \"168\", \"46\": \"172\", \"47\": \"176\", \"48\": \"180\", \"49\": \"184\", \"50\": \"188\"}', '2026-09-21 14:17:31', '2026-09-21 14:17:41', '2026-09-21 14:17:31', '2026-09-21 14:17:41'),
('32', '11', '3', '12', 'selesai', '81.30', '{\"51\": \"192\", \"52\": \"196\", \"53\": \"200\", \"54\": \"204\"}', '2026-09-21 14:17:54', '2026-09-21 14:18:14', '2026-09-21 14:17:54', '2026-09-21 14:18:14'),
('33', '11', '3', '13', 'selesai', '100.00', '{\"55\": \"208\", \"56\": \"212\", \"57\": \"216\", \"58\": \"220\", \"59\": \"menjaga kebersihan.\"}', '2026-09-21 14:19:06', '2026-09-21 14:19:40', '2026-09-21 14:19:06', '2026-09-21 14:19:40'),
('34', '11', '4', '14', 'selesai', '75.00', '{\"60\": \"224\", \"61\": \"228\", \"62\": \"232\", \"63\": \"238\", \"64\": \"242\", \"65\": \"246\"}', '2026-09-21 14:22:32', '2026-09-21 14:22:49', '2026-09-21 14:22:32', '2026-09-21 14:22:49'),
('35', '11', '4', '15', 'selesai', '56.30', '{\"66\": \"250\", \"67\": \"254\", \"68\": \"257\", \"69\": \"262\"}', '2026-09-21 14:23:09', '2026-09-21 14:23:20', '2026-09-21 14:23:09', '2026-09-21 14:23:20'),
('36', '11', '4', '16', 'selesai', '87.50', '{\"70\": \"264\", \"71\": \"268\", \"72\": \"273\", \"73\": \"277\"}', '2026-09-21 14:23:37', '2026-09-21 14:23:46', '2026-09-21 14:23:37', '2026-09-21 14:23:46'),
('37', '11', '5', '17', 'selesai', '79.20', '{\"74\": \"280\", \"75\": \"285\", \"76\": \"289\", \"77\": \"293\", \"78\": \"297\", \"79\": \"301\"}', '2026-09-21 14:24:12', '2026-09-21 14:24:29', '2026-09-21 14:24:12', '2026-09-21 14:24:29'),
('38', '11', '5', '18', 'selesai', '87.50', '{\"80\": \"304\", \"81\": \"309\", \"82\": \"313\", \"83\": \"316\"}', '2026-09-21 14:24:42', '2026-09-21 14:24:50', '2026-09-21 14:24:42', '2026-09-21 14:24:50'),
('39', '11', '5', '19', 'selesai', '88.20', '{\"84\": \"320\", \"85\": \"325\", \"86\": \"328\", \"87\": \"333\", \"88\": \"saya akan bangun pagi.\"}', '2026-09-21 14:25:01', '2026-09-21 14:25:37', '2026-09-21 14:25:01', '2026-09-21 14:25:37'),
('40', '11', '6', '11', 'selesai', '300.00', '{\"43\": [\"163\", \"164\", \"165\", \"166\", \"167\"], \"44\": \"saya akan bangun pagi dan membersihkan tempat tidur,tidak lupa saya juga menggosok gigi.\"}', '2026-09-21 14:26:09', '2026-09-21 14:27:27', '2026-09-21 14:26:09', '2026-09-21 14:27:27');

-- --------------------------------------------------------
-- Table structure for table `students`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `students`;
CREATE TABLE `students` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `kelas_id` bigint unsigned NOT NULL,
  `nis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kelamin` enum('L','P') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `students_user_id_foreign` (`user_id`),
  KEY `students_kelas_id_foreign` (`kelas_id`),
  CONSTRAINT `students_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `students_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `students`

INSERT INTO `students` VALUES 
('1', '4', '1', '10001', 'L', '2010-01-18', '2026-09-19 10:07:42', '2026-09-19 10:07:42'),
('2', '5', '1', '10002', 'L', '2009-01-15', '2026-09-19 10:07:42', '2026-09-19 10:07:42'),
('3', '6', '1', '10003', 'P', '2011-01-03', '2026-09-19 10:07:43', '2026-09-19 10:07:43'),
('4', '7', '2', '10004', 'P', '2009-01-11', '2026-09-19 10:07:43', '2026-09-19 10:07:43'),
('5', '8', '2', '10005', 'L', '2009-04-19', '2026-09-19 10:07:44', '2026-09-19 10:07:44'),
('6', '9', '3', '20001', 'P', '2009-12-24', '2026-09-19 10:07:44', '2026-09-19 10:07:44'),
('7', '10', '3', '20002', 'L', '2011-05-24', '2026-09-19 10:07:45', '2026-09-19 10:07:45'),
('8', '11', '4', '1234567', 'L', '2000-09-09', '2026-09-19 10:12:54', '2026-09-19 10:12:54'),
('9', '13', '4', '0987654', 'L', '2000-09-09', '2026-09-19 11:48:30', '2026-09-19 11:48:30'),
('10', '14', '4', '12344', 'L', '2000-09-09', '2026-09-20 07:37:14', '2026-09-20 07:37:14'),
('11', '15', '5', '1001', 'L', '2018-09-09', '2026-09-21 13:43:12', '2026-09-21 13:43:12');

-- --------------------------------------------------------
-- Table structure for table `users`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `role_id` bigint unsigned NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `last_login` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`),
  KEY `users_role_id_foreign` (`role_id`),
  CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `users`

INSERT INTO `users` VALUES 
('1', '1', NULL, 'admin@lentera.test', '$2y$12$/M20lZmOSonaXkas.ZYKu..EdF/HMOUIJ8ogZuY6xT0oBHFsUFpH6', 'Administrator', '1', NULL, NULL, '2026-09-19 10:07:40', '2026-09-19 10:07:40'),
('2', '2', NULL, 'novia@lentera.test', '$2y$12$krp.Vc0yzol0nF23gU0Z6eojuMw06rhNohdGSX3Vms1N5X9RyWRpW', 'Novia Hendratno, M.Pd.', '1', NULL, NULL, '2026-09-19 10:07:40', '2026-09-19 10:07:40'),
('3', '2', NULL, 'konselor2@lentera.test', '$2y$12$BlvmzMJgSOVXx.QEIV0.Yu6ggf0yxtUzlen8O42rp0nS6wQj4vBMu', 'Budi Santoso, M.Pd.', '1', NULL, NULL, '2026-09-19 10:07:41', '2026-09-19 10:07:41'),
('4', '3', 'siswa1', 'siswa1@lentera.test', '$2y$12$CbvxzMiVqlfcjZaYe8LMBOp8MjhLZcQNDw3km8DErCAoCd0sQPZiu', 'Andi Pratama', '1', NULL, NULL, '2026-09-19 10:07:42', '2026-09-19 10:07:42'),
('5', '3', 'siswa2', 'siswa2@lentera.test', '$2y$12$GbGMXB2xCYbR8pL6uJB9ruFjaG24ZXQsUrjLPbUOk2rHXkYEPoL4i', 'Budi Setiawan', '1', NULL, NULL, '2026-09-19 10:07:42', '2026-09-19 10:07:42'),
('6', '3', 'siswa3', 'siswa3@lentera.test', '$2y$12$voYcUaNrj5MfgRux1jt/9uIfQG.0/rvV7fz5sD8ERdaeMkZI7oYay', 'Citra Dewi', '1', NULL, NULL, '2026-09-19 10:07:43', '2026-09-19 10:07:43'),
('7', '3', 'siswa4', 'siswa4@lentera.test', '$2y$12$yo8N0VP9r5ISysQr2TG4u.BnOOM60rO4SafYjhNvm0YhgG3DJ6Vg2', 'Dina Rahmawati', '1', NULL, NULL, '2026-09-19 10:07:43', '2026-09-19 10:07:43'),
('8', '3', 'siswa5', 'siswa5@lentera.test', '$2y$12$6I.0CdA4pzti9G6.9cRYkOCwx3KUtsf2tLy.N3/OEHEyOvsuZgQUm', 'Eko Prasetyo', '1', NULL, NULL, '2026-09-19 10:07:44', '2026-09-19 10:07:44'),
('9', '3', 'siswa6', 'siswa6@lentera.test', '$2y$12$vX/SqtafkpgfWUMr744w5OQrZa7gZiG1xHVhouv4BNx4qhX/8uYXS', 'Fitri Handayani', '1', NULL, NULL, '2026-09-19 10:07:44', '2026-09-19 10:07:44'),
('10', '3', 'siswa7', 'siswa7@lentera.test', '$2y$12$nDVTlmCrpoSkElcqJma6se6R0NtGC1wWHj483nRh8bkXXeuzaCujS', 'Gilang Ramadhan', '1', NULL, NULL, '2026-09-19 10:07:45', '2026-09-19 10:07:45'),
('11', '3', 'baskoro', NULL, '$2y$12$4lRNnplP3I5bcFigtYnBKO1sYJINoW5M47mr6D3tcBHqeOqkvs81u', 'baskoro', '1', NULL, NULL, '2026-09-19 10:12:54', '2026-09-19 10:12:54'),
('12', '2', NULL, 'yuda@lentera.test', '$2y$12$eMSlw5UWbDHTkuuWqI5MJe.pl0BB89.y.N.od/DPkELfZzmO2MoQC', 'Yuda', '1', NULL, NULL, '2026-09-19 10:13:29', '2026-09-19 10:13:29'),
('13', '3', 'baskoro123', NULL, '$2y$12$dpRtmUJbQuvNLmGXVSdlpOEv4CtNzFjRq97u.KIHtB3ansnueNXM2', 'Earlyano Yuda Bakoro', '1', NULL, NULL, '2026-09-19 11:48:29', '2026-09-19 11:49:58'),
('14', '3', 'tejo123', NULL, '$2y$12$5o.hvjR0CVHyAzME9cINpeB.AGmeF69Xo5Tq8snghs1eJUzqmeKBK', 'tejo', '1', NULL, NULL, '2026-09-20 07:37:14', '2026-09-20 07:37:14'),
('15', '3', 'IVAN', NULL, '$2y$12$eIGZd/yuSRdXv0wZFyj0LOmQslmYK7FOUcpd5gETZANfS57678CyG', 'IVAN', '1', NULL, NULL, '2026-09-21 13:43:12', '2026-09-21 13:43:12'),
('16', '2', NULL, 'budi@lentera.test', '$2y$12$avy/Z6gfDGZ33kk2bmMuEOQR4xDIfaC8hqB76OCADpbMS.9zEnKcm', 'Budi', '1', NULL, NULL, '2026-09-21 13:45:12', '2026-09-21 13:45:27');

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
COMMIT;
