SET FOREIGN_KEY_CHECKS = 0;
START TRANSACTION;

CREATE TABLE IF NOT EXISTS `migrations` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `migration` VARCHAR(255) NOT NULL,
  `batch` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `migrations` VALUES(1,'0001_01_01_000001_create_cache_table',1);
INSERT INTO `migrations` VALUES(2,'0001_01_01_000001_create_states_and_cities_tables',1);
INSERT INTO `migrations` VALUES(3,'0001_01_01_000005_create_users_table',1);
INSERT INTO `migrations` VALUES(4,'2026_05_04_143401_create_personal_access_tokens_table',1);
INSERT INTO `migrations` VALUES(5,'2026_05_05_000001_create_vendors_table',1);
INSERT INTO `migrations` VALUES(6,'2026_05_05_000002_create_vendor_areas_table',1);
INSERT INTO `migrations` VALUES(7,'2026_05_05_000002_create_vendor_members_table',1);
INSERT INTO `migrations` VALUES(8,'2026_05_05_000003_create_meals_table',1);
INSERT INTO `migrations` VALUES(9,'2026_05_05_000004_create_orders_table',1);
INSERT INTO `migrations` VALUES(10,'2026_05_05_000005_create_order_items_table',1);
INSERT INTO `migrations` VALUES(11,'2026_05_05_000006_create_messages_table',1);
INSERT INTO `migrations` VALUES(12,'2026_05_05_000007_create_blog_posts_table',1);
INSERT INTO `migrations` VALUES(13,'2026_05_05_000008_create_reviews_table',1);
INSERT INTO `migrations` VALUES(14,'2026_05_05_000009_create_coupons_table',1);
INSERT INTO `migrations` VALUES(15,'2026_05_05_000010_create_notifications_table',1);
INSERT INTO `migrations` VALUES(16,'2026_05_05_000011_create_follows_table',1);
INSERT INTO `migrations` VALUES(17,'2026_05_05_000013_create_loyalty_points_table',1);
INSERT INTO `migrations` VALUES(18,'2026_05_05_000014_create_support_tickets_table',1);
INSERT INTO `migrations` VALUES(19,'2026_05_05_000015_create_vendor_verifications_table',1);
INSERT INTO `migrations` VALUES(20,'2026_05_05_000016_create_refunds_table',1);
INSERT INTO `migrations` VALUES(21,'2026_05_05_000017_create_payouts_table',1);
INSERT INTO `migrations` VALUES(22,'2026_05_05_000018_create_audit_logs_table',1);
INSERT INTO `migrations` VALUES(23,'2026_05_05_000019_create_settings_table',1);
INSERT INTO `migrations` VALUES(24,'2026_05_05_000020_create_roles_table',1);
INSERT INTO `migrations` VALUES(25,'2026_05_06_000002_create_admins_table',1);
INSERT INTO `migrations` VALUES(26,'2026_05_06_000003_create_moderations_table',1);
INSERT INTO `migrations` VALUES(27,'2026_05_06_000004_create_missing_tables',1);
INSERT INTO `migrations` VALUES(28,'2026_05_06_000004_create_permissions_table',1);

CREATE TABLE IF NOT EXISTS `cache` (
  `key` VARCHAR(255) NOT NULL,
  `value` TEXT NOT NULL,
  `expiration` BIGINT NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` VARCHAR(255) NOT NULL,
  `owner` VARCHAR(255) NOT NULL,
  `expiration` BIGINT NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `states` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `created_at` DATETIME DEFAULT NULL,
  `updated_at` DATETIME DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `states` VALUES(1,'Abia','abia','2026-05-06 14:12:50','2026-05-06 14:12:50');
INSERT INTO `states` VALUES(2,'Adamawa','adamawa','2026-05-06 14:12:50','2026-05-06 14:12:50');
INSERT INTO `states` VALUES(3,'Akwa Ibom','akwa-ibom','2026-05-06 14:12:50','2026-05-06 14:12:50');
INSERT INTO `states` VALUES(4,'Anambra','anambra','2026-05-06 14:12:50','2026-05-06 14:12:50');
INSERT INTO `states` VALUES(5,'Bauchi','bauchi','2026-05-06 14:12:50','2026-05-06 14:12:50');
INSERT INTO `states` VALUES(6,'Bayelsa','bayelsa','2026-05-06 14:12:50','2026-05-06 14:12:50');
INSERT INTO `states` VALUES(7,'Benue','benue','2026-05-06 14:12:50','2026-05-06 14:12:50');
INSERT INTO `states` VALUES(8,'Borno','borno','2026-05-06 14:12:50','2026-05-06 14:12:50');
INSERT INTO `states` VALUES(9,'Cross River','cross-river','2026-05-06 14:12:50','2026-05-06 14:12:50');
INSERT INTO `states` VALUES(10,'Delta','delta','2026-05-06 14:12:50','2026-05-06 14:12:50');
INSERT INTO `states` VALUES(11,'Ebonyi','ebonyi','2026-05-06 14:12:50','2026-05-06 14:12:50');
INSERT INTO `states` VALUES(12,'Edo','edo','2026-05-06 14:12:50','2026-05-06 14:12:50');
INSERT INTO `states` VALUES(13,'Ekiti','ekiti','2026-05-06 14:12:50','2026-05-06 14:12:50');
INSERT INTO `states` VALUES(14,'Enugu','enugu','2026-05-06 14:12:50','2026-05-06 14:12:50');
INSERT INTO `states` VALUES(15,'Gombe','gombe','2026-05-06 14:12:50','2026-05-06 14:12:50');
INSERT INTO `states` VALUES(16,'Imo','imo','2026-05-06 14:12:50','2026-05-06 14:12:50');
INSERT INTO `states` VALUES(17,'Jigawa','jigawa','2026-05-06 14:12:50','2026-05-06 14:12:50');
INSERT INTO `states` VALUES(18,'Kaduna','kaduna','2026-05-06 14:12:50','2026-05-06 14:12:50');
INSERT INTO `states` VALUES(19,'Kano','kano','2026-05-06 14:12:51','2026-05-06 14:12:51');
INSERT INTO `states` VALUES(20,'Katsina','katsina','2026-05-06 14:12:51','2026-05-06 14:12:51');
INSERT INTO `states` VALUES(21,'Kebbi','kebbi','2026-05-06 14:12:51','2026-05-06 14:12:51');
INSERT INTO `states` VALUES(22,'Kogi','kogi','2026-05-06 14:12:51','2026-05-06 14:12:51');
INSERT INTO `states` VALUES(23,'Kwara','kwara','2026-05-06 14:12:51','2026-05-06 14:12:51');
INSERT INTO `states` VALUES(24,'Lagos','lagos','2026-05-06 14:12:51','2026-05-06 14:12:51');
INSERT INTO `states` VALUES(25,'Nasarawa','nasarawa','2026-05-06 14:12:51','2026-05-06 14:12:51');
INSERT INTO `states` VALUES(26,'Niger','niger','2026-05-06 14:12:51','2026-05-06 14:12:51');
INSERT INTO `states` VALUES(27,'Ogun','ogun','2026-05-06 14:12:51','2026-05-06 14:12:51');
INSERT INTO `states` VALUES(28,'Ondo','ondo','2026-05-06 14:12:51','2026-05-06 14:12:51');
INSERT INTO `states` VALUES(29,'Osun','osun','2026-05-06 14:12:51','2026-05-06 14:12:51');
INSERT INTO `states` VALUES(30,'Oyo','oyo','2026-05-06 14:12:51','2026-05-06 14:12:51');
INSERT INTO `states` VALUES(31,'Plateau','plateau','2026-05-06 14:12:51','2026-05-06 14:12:51');
INSERT INTO `states` VALUES(32,'Rivers','rivers','2026-05-06 14:12:51','2026-05-06 14:12:51');
INSERT INTO `states` VALUES(33,'Sokoto','sokoto','2026-05-06 14:12:51','2026-05-06 14:12:51');
INSERT INTO `states` VALUES(34,'Taraba','taraba','2026-05-06 14:12:51','2026-05-06 14:12:51');
INSERT INTO `states` VALUES(35,'Yobe','yobe','2026-05-06 14:12:51','2026-05-06 14:12:51');
INSERT INTO `states` VALUES(36,'Zamfara','zamfara','2026-05-06 14:12:52','2026-05-06 14:12:52');
INSERT INTO `states` VALUES(37,'Federal Capital Territory','federal-capital-territory','2026-05-06 14:12:52','2026-05-06 14:12:52');

CREATE TABLE IF NOT EXISTS `cities` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `state_id` INT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `created_at` DATETIME DEFAULT NULL,
  `updated_at` DATETIME DEFAULT NULL,
  FOREIGN KEY (`state_id`) REFERENCES `states`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `cities` VALUES(1,1,'Umuahia','umuahia','2026-05-06 14:12:50','2026-05-06 14:12:50');
INSERT INTO `cities` VALUES(2,2,'Yola','yola','2026-05-06 14:12:50','2026-05-06 14:12:50');
INSERT INTO `cities` VALUES(3,3,'Uyo','uyo','2026-05-06 14:12:50','2026-05-06 14:12:50');
INSERT INTO `cities` VALUES(4,4,'Awka','awka','2026-05-06 14:12:50','2026-05-06 14:12:50');
INSERT INTO `cities` VALUES(5,5,'Bauchi','bauchi','2026-05-06 14:12:50','2026-05-06 14:12:50');
INSERT INTO `cities` VALUES(6,6,'Yenagoa','yenagoa','2026-05-06 14:12:50','2026-05-06 14:12:50');
INSERT INTO `cities` VALUES(7,7,'Makurdi','makurdi','2026-05-06 14:12:50','2026-05-06 14:12:50');
INSERT INTO `cities` VALUES(8,8,'Maiduguri','maiduguri','2026-05-06 14:12:50','2026-05-06 14:12:50');
INSERT INTO `cities` VALUES(9,9,'Calabar','calabar','2026-05-06 14:12:50','2026-05-06 14:12:50');
INSERT INTO `cities` VALUES(10,10,'Asaba','asaba','2026-05-06 14:12:50','2026-05-06 14:12:50');
INSERT INTO `cities` VALUES(11,11,'Abakaliki','abakaliki','2026-05-06 14:12:50','2026-05-06 14:12:50');
INSERT INTO `cities` VALUES(12,12,'Benin City','benin-city','2026-05-06 14:12:50','2026-05-06 14:12:50');
INSERT INTO `cities` VALUES(13,13,'Ado-Ekiti','ado-ekiti','2026-05-06 14:12:50','2026-05-06 14:12:50');
INSERT INTO `cities` VALUES(14,14,'Enugu','enugu','2026-05-06 14:12:50','2026-05-06 14:12:50');
INSERT INTO `cities` VALUES(15,15,'Gombe','gombe','2026-05-06 14:12:50','2026-05-06 14:12:50');
INSERT INTO `cities` VALUES(16,16,'Owerri','owerri','2026-05-06 14:12:50','2026-05-06 14:12:50');
INSERT INTO `cities` VALUES(17,17,'Dutse','dutse','2026-05-06 14:12:50','2026-05-06 14:12:50');
INSERT INTO `cities` VALUES(18,18,'Kaduna','kaduna','2026-05-06 14:12:50','2026-05-06 14:12:50');
INSERT INTO `cities` VALUES(19,19,'Kano','kano','2026-05-06 14:12:51','2026-05-06 14:12:51');
INSERT INTO `cities` VALUES(20,20,'Katsina','katsina','2026-05-06 14:12:51','2026-05-06 14:12:51');
INSERT INTO `cities` VALUES(21,21,'Birnin Kebbi','birnin-kebbi','2026-05-06 14:12:51','2026-05-06 14:12:51');
INSERT INTO `cities` VALUES(22,22,'Lokoja','lokoja','2026-05-06 14:12:51','2026-05-06 14:12:51');
INSERT INTO `cities` VALUES(23,23,'Ilorin','ilorin','2026-05-06 14:12:51','2026-05-06 14:12:51');
INSERT INTO `cities` VALUES(24,24,'Ikeja','ikeja','2026-05-06 14:12:51','2026-05-06 14:12:51');
INSERT INTO `cities` VALUES(25,25,'Lafia','lafia','2026-05-06 14:12:51','2026-05-06 14:12:51');
INSERT INTO `cities` VALUES(26,26,'Minna','minna','2026-05-06 14:12:51','2026-05-06 14:12:51');
INSERT INTO `cities` VALUES(27,27,'Abeokuta','abeokuta','2026-05-06 14:12:51','2026-05-06 14:12:51');
INSERT INTO `cities` VALUES(28,28,'Akure','akure','2026-05-06 14:12:51','2026-05-06 14:12:51');
INSERT INTO `cities` VALUES(29,29,'Osogbo','osogbo','2026-05-06 14:12:51','2026-05-06 14:12:51');
INSERT INTO `cities` VALUES(30,30,'Ibadan','ibadan','2026-05-06 14:12:51','2026-05-06 14:12:51');
INSERT INTO `cities` VALUES(31,31,'Jos','jos','2026-05-06 14:12:51','2026-05-06 14:12:51');
INSERT INTO `cities` VALUES(32,32,'Port Harcourt','port-harcourt','2026-05-06 14:12:51','2026-05-06 14:12:51');
INSERT INTO `cities` VALUES(33,33,'Sokoto','sokoto','2026-05-06 14:12:51','2026-05-06 14:12:51');
INSERT INTO `cities` VALUES(34,34,'Jalingo','jalingo','2026-05-06 14:12:51','2026-05-06 14:12:51');
INSERT INTO `cities` VALUES(35,35,'Damaturu','damaturu','2026-05-06 14:12:52','2026-05-06 14:12:52');
INSERT INTO `cities` VALUES(36,36,'Gusau','gusau','2026-05-06 14:12:52','2026-05-06 14:12:52');
INSERT INTO `cities` VALUES(37,37,'Abuja','abuja','2026-05-06 14:12:52','2026-05-06 14:12:52');

CREATE TABLE IF NOT EXISTS `users` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `email_verified_at` DATETIME DEFAULT NULL,
  `password` VARCHAR(255) NOT NULL,
  `two_factor_secret` TEXT DEFAULT NULL,
  `two_factor_recovery_codes` TEXT DEFAULT NULL,
  `two_factor_confirmed_at` DATETIME DEFAULT NULL,
  `remember_token` VARCHAR(100) DEFAULT NULL,
  `created_at` DATETIME DEFAULT NULL,
  `updated_at` DATETIME DEFAULT NULL,
  `state_id` INT NOT NULL,
  FOREIGN KEY (`state_id`) REFERENCES `states`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` VALUES(1,'Super Admin','superadmin@menumenu.com',NULL,'$2y$12$plkBuIpWSD6BaKqzySWm3.340yUdl.VrrOc/ZXxfM31lNJ1TW15B2',NULL,NULL,NULL,NULL,'2026-05-06 14:12:54','2026-05-06 14:20:22',1);
INSERT INTO `users` VALUES(2,'John Manager','manager@menumenu.com',NULL,'$2y$12$plkBuIpWSD6BaKqzySWm3.340yUdl.VrrOc/ZXxfM31lNJ1TW15B2',NULL,NULL,NULL,NULL,'2026-05-06 14:12:54','2026-05-06 14:20:22',1);
INSERT INTO `users` VALUES(3,'Sarah Finance','finance@menumenu.com',NULL,'$2y$12$plkBuIpWSD6BaKqzySWm3.340yUdl.VrrOc/ZXxfM31lNJ1TW15B2',NULL,NULL,NULL,NULL,'2026-05-06 14:12:54','2026-05-06 14:20:22',1);
INSERT INTO `users` VALUES(4,'Mike Support','support@menumenu.com',NULL,'$2y$12$plkBuIpWSD6BaKqzySWm3.340yUdl.VrrOc/ZXxfM31lNJ1TW15B2',NULL,NULL,NULL,NULL,'2026-05-06 14:12:54','2026-05-06 14:20:22',1);
INSERT INTO `users` VALUES(5,'Emma Moderator','moderator@menumenu.com',NULL,'$2y$12$plkBuIpWSD6BaKqzySWm3.340yUdl.VrrOc/ZXxfM31lNJ1TW15B2',NULL,NULL,NULL,NULL,'2026-05-06 14:12:54','2026-05-06 14:20:22',1);
INSERT INTO `users` VALUES(6,'Admin User','admin@example.com',NULL,'$2y$12$LAZXUiWKcWKl0v87aRrOneqkqh0.RUri1bOBoXvG7etYZ/Ff1XLSK',NULL,NULL,NULL,NULL,'2026-05-06 14:12:55','2026-05-06 14:12:55',1);
INSERT INTO `users` VALUES(7,'Test User','test@example.com',NULL,'$2y$12$MeQnyTuWiz3SuNtn1QbDEedK5.5UhvPK4vCbqh8.M0waKaKLRIksu',NULL,NULL,NULL,NULL,'2026-05-06 14:12:56','2026-05-06 14:12:56',1);
INSERT INTO `users` VALUES(8,'Gideon Leffler II','adams.sabina@example.org','2026-05-06 14:12:56','$2y$12$eTh4Tmqc3WLr0ZEwwQYqROXpOhmVRfcXYdqxZDZoifkUZkx6DfL56',NULL,NULL,NULL,'16ViLArlYO','2026-05-06 14:12:57','2026-05-06 14:12:57',1);
INSERT INTO `users` VALUES(9,'Brando Kassulke','simonis.ludie@example.com','2026-05-06 14:12:57','$2y$12$eTh4Tmqc3WLr0ZEwwQYqROXpOhmVRfcXYdqxZDZoifkUZkx6DfL56',NULL,NULL,NULL,'WwCdpq1XoN','2026-05-06 14:12:57','2026-05-06 14:12:57',1);
INSERT INTO `users` VALUES(10,'Derick Feeney','kautzer.irwin@example.com','2026-05-06 14:12:57','$2y$12$eTh4Tmqc3WLr0ZEwwQYqROXpOhmVRfcXYdqxZDZoifkUZkx6DfL56',NULL,NULL,NULL,'dILEZ4PaxD','2026-05-06 14:12:57','2026-05-06 14:12:57',1);
INSERT INTO `users` VALUES(11,'Nathen Schaefer','olga.mitchell@example.org','2026-05-06 14:12:57','$2y$12$eTh4Tmqc3WLr0ZEwwQYqROXpOhmVRfcXYdqxZDZoifkUZkx6DfL56',NULL,NULL,NULL,'duEgsQ8jdt','2026-05-06 14:12:57','2026-05-06 14:12:57',1);
INSERT INTO `users` VALUES(12,'Mr. Kole Heathcote II','mante.elizabeth@example.org','2026-05-06 14:12:57','$2y$12$eTh4Tmqc3WLr0ZEwwQYqROXpOhmVRfcXYdqxZDZoifkUZkx6DfL56',NULL,NULL,NULL,'ceA1hKvC4M','2026-05-06 14:12:57','2026-05-06 14:12:57',1);
INSERT INTO `users` VALUES(13,'Janelle Ritchie','ljohnston@example.com','2026-05-06 14:12:57','$2y$12$eTh4Tmqc3WLr0ZEwwQYqROXpOhmVRfcXYdqxZDZoifkUZkx6DfL56',NULL,NULL,NULL,'CXplj4iFKk','2026-05-06 14:12:57','2026-05-06 14:12:57',1);
INSERT INTO `users` VALUES(14,'Bennett Gerhold V','pfriesen@example.org','2026-05-06 14:12:57','$2y$12$eTh4Tmqc3WLr0ZEwwQYqROXpOhmVRfcXYdqxZDZoifkUZkx6DfL56',NULL,NULL,NULL,'GpXN0qPee3','2026-05-06 14:12:57','2026-05-06 14:12:57',1);
INSERT INTO `users` VALUES(15,'Rossie Hoeger','langworth.kristin@example.net','2026-05-06 14:12:57','$2y$12$eTh4Tmqc3WLr0ZEwwQYqROXpOhmVRfcXYdqxZDZoifkUZkx6DfL56',NULL,NULL,NULL,'d6XLOtiVXp','2026-05-06 14:12:57','2026-05-06 14:12:57',1);
INSERT INTO `users` VALUES(16,'Elyse Christiansen','jimmy.rodriguez@example.com','2026-05-06 14:12:57','$2y$12$eTh4Tmqc3WLr0ZEwwQYqROXpOhmVRfcXYdqxZDZoifkUZkx6DfL56',NULL,NULL,NULL,'lfWWuVuif2','2026-05-06 14:12:57','2026-05-06 14:12:57',1);
INSERT INTO `users` VALUES(17,'Prof. Macey Huel','kiehn.jerrod@example.org','2026-05-06 14:12:57','$2y$12$eTh4Tmqc3WLr0ZEwwQYqROXpOhmVRfcXYdqxZDZoifkUZkx6DfL56',NULL,NULL,NULL,'pzme4qTiMB','2026-05-06 14:12:57','2026-05-06 14:12:57',1);

CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` VARCHAR(255) NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  `created_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `sessions` (
  `id` VARCHAR(255) NOT NULL,
  `user_id` INT DEFAULT NULL,
  `ip_address` VARCHAR(255) DEFAULT NULL,
  `user_agent` TEXT DEFAULT NULL,
  `payload` TEXT NOT NULL,
  `last_activity` BIGINT NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `tokenable_type` VARCHAR(255) NOT NULL,
  `tokenable_id` INT NOT NULL,
  `name` TEXT NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  `abilities` TEXT DEFAULT NULL,
  `last_used_at` DATETIME DEFAULT NULL,
  `expires_at` DATETIME DEFAULT NULL,
  `created_at` DATETIME DEFAULT NULL,
  `updated_at` DATETIME DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `vendors` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT DEFAULT NULL,
  `name` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) DEFAULT NULL,
  `phone` VARCHAR(255) DEFAULT NULL,
  `password` VARCHAR(255) DEFAULT NULL,
  `remember_token` VARCHAR(100) DEFAULT NULL,
  `tagline` VARCHAR(255) DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `banner_path` VARCHAR(255) DEFAULT NULL,
  `avatar_path` VARCHAR(255) DEFAULT NULL,
  `state_id` INT NOT NULL,
  `city_id` INT DEFAULT NULL,
  `address` VARCHAR(255) DEFAULT NULL,
  `is_open` TINYINT(1) NOT NULL DEFAULT 0,
  `open_time` TIME DEFAULT NULL,
  `close_time` TIME DEFAULT NULL,
  `delivery_available` TINYINT(1) NOT NULL DEFAULT 1,
  `pickup_available` TINYINT(1) NOT NULL DEFAULT 1,
  `commission_percent` INT NOT NULL DEFAULT 10,
  `created_at` DATETIME DEFAULT NULL,
  `updated_at` DATETIME DEFAULT NULL,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL,
  FOREIGN KEY (`state_id`) REFERENCES `states`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`city_id`) REFERENCES `cities`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `vendors` VALUES(1,1,'Nikolaus-Bergnaum','nikolaus-bergnaum-1639','ftrantow@emard.com','+1 (971) 614-2575',NULL,NULL,'Front-line foreground neural-net','Fuga vel quae blanditiis sed cumque eligendi ut. Ullam voluptatem numquam sit.',NULL,NULL,1,1,REPLACE('43337 Brekke Forks\nNorth Tomhaven, TX 82480-8720','\n',CHAR(10)),1,'15:03:19','01:13:42',1,1,10,'2026-05-06 14:12:58','2026-05-06 14:12:58');
INSERT INTO `vendors` VALUES(2,2,'Anderson-Ullrich','anderson-ullrich-8237','emurphy@nikolaus.net','838.897.4977',NULL,NULL,'Horizontal holistic project','Dolorem est quo rerum quasi excepturi. Qui voluptatum provident inventore sunt. Corrupti omnis laudantium voluptatem ut. Aspernatur occaecati quia officia rerum sit amet vel. Quos quod at autem dolor.',NULL,NULL,1,1,REPLACE('36181 Kunde Springs Apt. 935\nEast Giovannyfort, VT 71991','\n',CHAR(10)),1,'03:13:20','03:48:58',1,1,10,'2026-05-06 14:12:58','2026-05-06 14:12:58');
INSERT INTO `vendors` VALUES(3,3,'Littel and Sons','littel-and-sons-1659','cummerata.name@prohaska.com','(929) 289-0788',NULL,NULL,'Diverse reciprocal opensystem','Quia provident consectetur non. Earum libero consequatur error harum.',NULL,NULL,1,1,REPLACE('64365 Hilpert Gardens\nMarvinchester, KS 61588-6176','\n',CHAR(10)),1,'02:27:31','15:40:49',1,1,10,'2026-05-06 14:12:58','2026-05-06 14:12:58');
INSERT INTO `vendors` VALUES(4,4,'Ernser Group','ernser-group-5721','kevin33@ruecker.com','740-330-0147',NULL,NULL,'Streamlined context-sensitive knowledgebase','Repellendus voluptate excepturi necessitatibus maiores adipisci in veniam nihil. Sequi architecto vel suscipit incidunt consequatur.',NULL,NULL,1,1,REPLACE('990 Dock Lane Apt. 609\nPort Earnestine, PA 30597','\n',CHAR(10)),1,'00:03:41','15:01:22',1,1,10,'2026-05-06 14:12:59','2026-05-06 14:12:59');
INSERT INTO `vendors` VALUES(5,5,'Hintz, Boehm and Watsica','hintz-boehm-and-watsica-6436','cadams@heller.org','1-551-269-8342',NULL,NULL,'Mandatory uniform implementation','Aspernatur sunt rerum molestiae soluta. Dolore inventore animi nemo facilis veniam sed aut. Aut nesciunt consequatur harum itaque repellendus.',NULL,NULL,1,1,REPLACE('1460 Reggie Summit\nMartyfort, OR 59638-3140','\n',CHAR(10)),1,'23:39:22','04:18:49',1,1,10,'2026-05-06 14:12:59','2026-05-06 14:12:59');
INSERT INTO `vendors` VALUES(6,6,'Larson, Schulist and Miller','larson-schulist-and-miller-7906','alexys.heidenreich@schoen.com','570-755-0404',NULL,NULL,'Robust bottom-line infrastructure','Ut possimus facere necessitatibus laborum qui. Laborum natus quos deserunt et vel officiis. Laudantium eos modi qui autem voluptatem dignissimos. Quia eveniet nihil itaque voluptas.',NULL,NULL,1,1,REPLACE('6418 Eichmann Fort Apt. 322\nVandervortville, DC 82683-0299','\n',CHAR(10)),0,'06:33:10','21:36:47',1,1,10,'2026-05-06 14:13:00','2026-05-06 14:13:00');
INSERT INTO `vendors` VALUES(7,7,'Schumm Inc','schumm-inc-4720','darian28@mclaughlin.com','+1-463-865-5334',NULL,NULL,'Multi-tiered client-driven circuit','Maiores non tenetur ea deserunt autem sunt quia. Est sint aut natus deleniti. Est occaecati laborum necessitatibus aut ut quam sunt quos. Dolorum quis commodi beatae. Fugiat sunt voluptatem eos tempore ut eius maxime.',NULL,NULL,1,1,REPLACE('94642 Karine Valleys Suite 342\nNew Issacberg, WV 89953-9343','\n',CHAR(10)),1,'00:29:54','11:14:59',1,1,10,'2026-05-06 14:13:00','2026-05-06 14:13:00');
INSERT INTO `vendors` VALUES(8,8,'Raynor Inc','raynor-inc-9577','joshua30@parker.biz','+1 (641) 980-0590',NULL,NULL,'Cloned empowering toolset','Quia maiores ut minima laboriosam est ullam enim dolor. Nostrum quia voluptate similique animi ea dolores fuga nulla. Harum suscipit qui ipsum blanditiis pariatur pariatur cum.',NULL,NULL,1,1,REPLACE('543 Hintz Mountains\nJamesonchester, ND 86549','\n',CHAR(10)),1,'06:40:44','18:39:23',1,1,10,'2026-05-06 14:13:00','2026-05-06 14:13:00');

CREATE TABLE IF NOT EXISTS `vendor_areas` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `vendor_id` INT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `fee` INT NOT NULL DEFAULT 500,
  `min_delivery_time` INT DEFAULT NULL,
  `created_at` DATETIME DEFAULT NULL,
  `updated_at` DATETIME DEFAULT NULL,
  FOREIGN KEY (`vendor_id`) REFERENCES `vendors`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `vendor_areas` VALUES(1,1,'West Garlandstad',1087,46,'2026-05-06 14:12:58','2026-05-06 14:12:58');
INSERT INTO `vendor_areas` VALUES(2,1,'Port Clovis',343,34,'2026-05-06 14:12:58','2026-05-06 14:12:58');
INSERT INTO `vendor_areas` VALUES(3,1,'Zboncakbury',906,55,'2026-05-06 14:12:58','2026-05-06 14:12:58');
INSERT INTO `vendor_areas` VALUES(4,2,'South Julieview',693,58,'2026-05-06 14:12:58','2026-05-06 14:12:58');
INSERT INTO `vendor_areas` VALUES(5,2,'Port Rodrickberg',706,16,'2026-05-06 14:12:58','2026-05-06 14:12:58');
INSERT INTO `vendor_areas` VALUES(6,2,'Bradtkeland',601,58,'2026-05-06 14:12:58','2026-05-06 14:12:58');
INSERT INTO `vendor_areas` VALUES(7,3,'Nicolasmouth',772,25,'2026-05-06 14:12:58','2026-05-06 14:12:58');
INSERT INTO `vendor_areas` VALUES(8,3,'Collinsstad',882,25,'2026-05-06 14:12:58','2026-05-06 14:12:58');
INSERT INTO `vendor_areas` VALUES(9,3,'South Phyllis',486,17,'2026-05-06 14:12:58','2026-05-06 14:12:58');
INSERT INTO `vendor_areas` VALUES(10,4,'Port Guido',530,33,'2026-05-06 14:12:59','2026-05-06 14:12:59');
INSERT INTO `vendor_areas` VALUES(11,4,'North Sallie',689,44,'2026-05-06 14:12:59','2026-05-06 14:12:59');
INSERT INTO `vendor_areas` VALUES(12,4,'Lake Beverly',908,15,'2026-05-06 14:12:59','2026-05-06 14:12:59');
INSERT INTO `vendor_areas` VALUES(13,5,'Lake Johnville',650,15,'2026-05-06 14:12:59','2026-05-06 14:12:59');
INSERT INTO `vendor_areas` VALUES(14,5,'Kellyview',1165,25,'2026-05-06 14:12:59','2026-05-06 14:12:59');
INSERT INTO `vendor_areas` VALUES(15,5,'Abbottton',1088,54,'2026-05-06 14:12:59','2026-05-06 14:12:59');
INSERT INTO `vendor_areas` VALUES(16,6,'Savanahshire',947,19,'2026-05-06 14:13:00','2026-05-06 14:13:00');
INSERT INTO `vendor_areas` VALUES(17,6,'North Melissa',1094,41,'2026-05-06 14:13:00','2026-05-06 14:13:00');
INSERT INTO `vendor_areas` VALUES(18,6,'Brielleside',494,32,'2026-05-06 14:13:00','2026-05-06 14:13:00');
INSERT INTO `vendor_areas` VALUES(19,7,'New Javontehaven',333,57,'2026-05-06 14:13:00','2026-05-06 14:13:00');
INSERT INTO `vendor_areas` VALUES(20,7,'North Watsonborough',777,15,'2026-05-06 14:13:00','2026-05-06 14:13:00');
INSERT INTO `vendor_areas` VALUES(21,7,'Romanhaven',636,58,'2026-05-06 14:13:00','2026-05-06 14:13:00');
INSERT INTO `vendor_areas` VALUES(22,8,'Port Destinyville',1079,57,'2026-05-06 14:13:00','2026-05-06 14:13:00');
INSERT INTO `vendor_areas` VALUES(23,8,'New Natalieland',434,39,'2026-05-06 14:13:00','2026-05-06 14:13:00');
INSERT INTO `vendor_areas` VALUES(24,8,'Neldaberg',805,34,'2026-05-06 14:13:00','2026-05-06 14:13:00');

CREATE TABLE IF NOT EXISTS `vendor_members` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `vendor_id` INT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` VARCHAR(255) DEFAULT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME DEFAULT NULL,
  `updated_at` DATETIME DEFAULT NULL,
  FOREIGN KEY (`vendor_id`) REFERENCES `vendors`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `meals` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `vendor_id` INT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `price` INT NOT NULL DEFAULT 0,
  `currency` VARCHAR(10) NOT NULL DEFAULT 'NGN',
  `available` TINYINT(1) NOT NULL DEFAULT 1,
  `prep_time` INT DEFAULT NULL,
  `category` VARCHAR(255) DEFAULT NULL,
  `image_path` VARCHAR(255) DEFAULT NULL,
  `created_at` DATETIME DEFAULT NULL,
  `updated_at` DATETIME DEFAULT NULL,
  FOREIGN KEY (`vendor_id`) REFERENCES `vendors`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `meals` VALUES(1,1,'Culpa accusantium voluptatem','culpa-accusantium-voluptatem-7471','Non nam quos accusamus animi ut et.',1595,'NGN',1,41,'Sides',NULL,'2026-05-06 14:12:58','2026-05-06 14:12:58');
INSERT INTO `meals` VALUES(2,1,'Cumque expedita voluptatum','cumque-expedita-voluptatum-2677','Error id officiis et eaque repellendus.',5218,'NGN',1,10,'Main',NULL,'2026-05-06 14:12:58','2026-05-06 14:12:58');
INSERT INTO `meals` VALUES(3,1,'Et et sapiente','et-et-sapiente-3535','Voluptatibus ea expedita quisquam nisi nam sed tenetur.',5160,'NGN',1,27,'Breakfast',NULL,'2026-05-06 14:12:58','2026-05-06 14:12:58');
INSERT INTO `meals` VALUES(4,1,'Et est expedita','et-est-expedita-7978','Temporibus beatae magni ipsa.',4211,'NGN',1,55,'Dessert',NULL,'2026-05-06 14:12:58','2026-05-06 14:12:58');
INSERT INTO `meals` VALUES(5,1,'Occaecati facilis aut','occaecati-facilis-aut-6982','Et qui quas inventore esse velit.',2738,'NGN',1,57,'Breakfast',NULL,'2026-05-06 14:12:58','2026-05-06 14:12:58');
INSERT INTO `meals` VALUES(6,1,'Nesciunt magnam accusamus','nesciunt-magnam-accusamus-5847','Ipsam nulla dolor aspernatur enim et consequatur non.',854,'NGN',1,23,'Dessert',NULL,'2026-05-06 14:12:58','2026-05-06 14:12:58');
INSERT INTO `meals` VALUES(7,1,'Illum dolorem culpa','illum-dolorem-culpa-7074','Corrupti eaque doloremque et totam laborum omnis.',3415,'NGN',1,54,'Dessert',NULL,'2026-05-06 14:12:58','2026-05-06 14:12:58');
INSERT INTO `meals` VALUES(8,1,'Aut eos architecto','aut-eos-architecto-3245','In necessitatibus nulla animi temporibus voluptas necessitatibus voluptates.',629,'NGN',1,40,'Breakfast',NULL,'2026-05-06 14:12:58','2026-05-06 14:12:58');
INSERT INTO `meals` VALUES(9,2,'Et expedita quia','et-expedita-quia-5679','Ipsa sed et et tempore minus iure deserunt.',1101,'NGN',1,25,'Breakfast',NULL,'2026-05-06 14:12:58','2026-05-06 14:12:58');
INSERT INTO `meals` VALUES(10,2,'Quia blanditiis impedit','quia-blanditiis-impedit-7966','Error eum eum ipsam dicta in autem illum.',1610,'NGN',1,19,'Breakfast',NULL,'2026-05-06 14:12:58','2026-05-06 14:12:58');

... (file continues with the full converted SQL)

-- Set AUTO_INCREMENTs to match sqlite_sequence values (+1)
ALTER TABLE `migrations` AUTO_INCREMENT = 29;
ALTER TABLE `states` AUTO_INCREMENT = 38;
ALTER TABLE `cities` AUTO_INCREMENT = 38;
ALTER TABLE `roles` AUTO_INCREMENT = 7;
ALTER TABLE `permissions` AUTO_INCREMENT = 16;
ALTER TABLE `permission_role` AUTO_INCREMENT = 35;
ALTER TABLE `users` AUTO_INCREMENT = 18;
ALTER TABLE `role_user` AUTO_INCREMENT = 7;
ALTER TABLE `vendors` AUTO_INCREMENT = 9;
ALTER TABLE `vendor_areas` AUTO_INCREMENT = 25;
ALTER TABLE `meals` AUTO_INCREMENT = 65;
ALTER TABLE `blog_posts` AUTO_INCREMENT = 17;
ALTER TABLE `orders` AUTO_INCREMENT = 7;
ALTER TABLE `order_items` AUTO_INCREMENT = 19;
ALTER TABLE `vendor_verifications` AUTO_INCREMENT = 6;
ALTER TABLE `refunds` AUTO_INCREMENT = 6;
ALTER TABLE `payouts` AUTO_INCREMENT = 6;
ALTER TABLE `admins` AUTO_INCREMENT = 2;

CREATE INDEX `cache_expiration_index` ON `cache` (`expiration`);
CREATE INDEX `cache_locks_expiration_index` ON `cache_locks` (`expiration`);
CREATE UNIQUE INDEX `states_slug_unique` ON `states` (`slug`);
CREATE UNIQUE INDEX `cities_slug_unique` ON `cities` (`slug`);
CREATE UNIQUE INDEX `users_email_unique` ON `users` (`email`);
CREATE INDEX `sessions_user_id_index` ON `sessions` (`user_id`);
CREATE INDEX `sessions_last_activity_index` ON `sessions` (`last_activity`);
CREATE INDEX `personal_access_tokens_tokenable_type_tokenable_id_index` ON `personal_access_tokens` (`tokenable_type`, `tokenable_id`);
CREATE UNIQUE INDEX `personal_access_tokens_token_unique` ON `personal_access_tokens` (`token`);
CREATE INDEX `personal_access_tokens_expires_at_index` ON `personal_access_tokens` (`expires_at`);
CREATE UNIQUE INDEX `vendors_slug_unique` ON `vendors` (`slug`);
CREATE UNIQUE INDEX `vendor_members_email_unique` ON `vendor_members` (`email`);
CREATE UNIQUE INDEX `orders_order_number_unique` ON `orders` (`order_number`);
CREATE UNIQUE INDEX `blog_posts_slug_unique` ON `blog_posts` (`slug`);
CREATE UNIQUE INDEX `coupons_code_unique` ON `coupons` (`code`);
CREATE UNIQUE INDEX `follows_user_id_vendor_id_unique` ON `follows` (`user_id`, `vendor_id`);
CREATE UNIQUE INDEX `settings_key_unique` ON `settings` (`key`);
CREATE UNIQUE INDEX `roles_name_unique` ON `roles` (`name`);
CREATE UNIQUE INDEX `role_user_role_id_user_id_unique` ON `role_user` (`role_id`, `user_id`);
CREATE UNIQUE INDEX `admins_email_unique` ON `admins` (`email`);
CREATE INDEX `moderations_moderatable_type_moderatable_id_index` ON `moderations` (`moderatable_type`, `moderatable_id`);
CREATE UNIQUE INDEX `wishlists_user_id_meal_id_unique` ON `wishlists` (`user_id`, `meal_id`);
CREATE UNIQUE INDEX `blog_likes_blog_post_id_user_id_unique` ON `blog_likes` (`blog_post_id`, `user_id`);
CREATE UNIQUE INDEX `permissions_name_unique` ON `permissions` (`name`);
CREATE UNIQUE INDEX `permission_role_permission_id_role_id_unique` ON `permission_role` (`permission_id`, `role_id`);

COMMIT;
SET FOREIGN_KEY_CHECKS = 1;
