-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: test_db
-- ------------------------------------------------------
-- Server version	8.3.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `accident_reports`
--

DROP TABLE IF EXISTS `accident_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `accident_reports` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `ar_owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_nationality` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_dateTime` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_injury` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_damage` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_wasInjured` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_ntInjuredReason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ar_agencyInvolved` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_agencyPart` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_accidentType` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_condition` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_unsafeAct` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_factor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_preventiveMeasure` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_safeguard` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_useSafeguard` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_ntSafeguardReason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ar_engineer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_engineer_cost` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_administrative` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_administrative_cost` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_ppe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_ppe_cost` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_affectedWorkers` json DEFAULT NULL,
  `ar_affectedWorkers_count` int NOT NULL,
  `ar_compensation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_compensation_amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_medical` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_burial` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_timeLostDay` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_timeLostDay_hours` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_timeLostDay_mins` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_timeLostSubseq` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_timeLostSubseq_hours` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_timeLostSubseq_mins` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_timeReducedOutput` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_timeReducedOutput_days` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_timeReducedOutput_percent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_machineryDamage` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_machineryDamage_repair` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_machineryDamage_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_machineryDamage_production` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_materialDamage` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_materialDamage_repair` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_materialDamage_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_materialDamage_production` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_equipmentDamage` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_equipmentDamage_repair` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_equipmentDamage_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_equipmentDamage_production` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_safetyOfficer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_safetyOfficer_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ar_employer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_employer_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ar_estabId` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `activity_log`
--

DROP TABLE IF EXISTS `activity_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activity_log` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `log_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `properties` json DEFAULT NULL,
  `batch_uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subject` (`subject_type`,`subject_id`),
  KEY `causer` (`causer_type`,`causer_id`),
  KEY `activity_log_log_name_index` (`log_name`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `banners`
--

DROP TABLE IF EXISTS `banners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `banners` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `data` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `breezy_sessions`
--

DROP TABLE IF EXISTS `breezy_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `breezy_sessions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `authenticatable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `authenticatable_id` bigint unsigned NOT NULL,
  `panel_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guard` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `expires_at` timestamp NULL DEFAULT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `breezy_sessions_authenticatable_type_authenticatable_id_index` (`authenticatable_type`,`authenticatable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employees` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emp_estabId` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `emp_lastName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_firstName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_middleName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_extensionName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_birthday` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_sex` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_civilStatus` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_houseNum` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_street` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_region` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_province` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_barangay` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_wage` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_numDependents` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_serviceLength` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_occupation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_yearsExp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_employmentStatus` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_shiftStart` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_shiftEnd` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_workHours` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_workDays` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_injill` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_injNature` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_injAffected` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_illType` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_illLocation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_dateStart` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_dateReturned` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_daysLost` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_daysCharged` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `establishments`
--

DROP TABLE IF EXISTS `establishments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `establishments` (
  `est_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `est_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `est_street` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `region_id` bigint DEFAULT NULL,
  `province_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city_id` bigint DEFAULT NULL,
  `barangay_id` bigint DEFAULT NULL,
  `psic_section` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `psic_division` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `psic_group` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `psic_class` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `est_products` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `est_class` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `est_tin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `est_sss` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `est_payment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `est_yearImplemented` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `est_numworkMale` int NOT NULL,
  `est_numworkFemale` int NOT NULL,
  `est_numworkManager` int NOT NULL,
  `est_numworkSupervisor` int NOT NULL,
  `est_numworkRanks` int NOT NULL,
  `est_numworkTotal` int NOT NULL,
  `est_permit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `est_govId` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `est_owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `est_designation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `est_telNum` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `est_contactNum` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `est_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `est_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `est_acknowledgement` date DEFAULT NULL,
  `est_certIssuance` date DEFAULT NULL,
  `est_authority` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`est_id`),
  UNIQUE KEY `establishments_est_name_unique` (`est_name`)
) ENGINE=InnoDB AUTO_INCREMENT=553995024661 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `exports`
--

DROP TABLE IF EXISTS `exports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `exports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `completed_at` timestamp NULL DEFAULT NULL,
  `file_disk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exporter` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `processed_rows` int unsigned NOT NULL DEFAULT '0',
  `total_rows` int unsigned NOT NULL,
  `successful_rows` int unsigned NOT NULL DEFAULT '0',
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `failed_import_rows`
--

DROP TABLE IF EXISTS `failed_import_rows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_import_rows` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `data` json NOT NULL,
  `import_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `validation_error` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `filament_exceptions_table`
--

DROP TABLE IF EXISTS `filament_exceptions_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `filament_exceptions_table` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `line` int NOT NULL,
  `trace` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `query` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `cookies` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `flexible_work_temps`
--

DROP TABLE IF EXISTS `flexible_work_temps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `flexible_work_temps` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fwa_startDate` date DEFAULT NULL,
  `fwa_endDate` date DEFAULT NULL,
  `fwa_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fwa_typeSpecify` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fwa_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fwa_reasonSpecify` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fwa_affectedWorkers` json DEFAULT NULL,
  `fwa_estabId` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `flexible_works`
--

DROP TABLE IF EXISTS `flexible_works`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `flexible_works` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fwa_startDate` date DEFAULT NULL,
  `fwa_endDate` date DEFAULT NULL,
  `fwa_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fwa_typeSpecify` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fwa_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fwa_reasonSpecify` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fwa_affectedWorkers` json DEFAULT NULL,
  `fwa_agreement` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fwa_owner` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fwa_designation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fwa_contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fwa_estabId` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `geocodes`
--

DROP TABLE IF EXISTS `geocodes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `geocodes` (
  `geo_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `geo_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`geo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1999908011 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `i_a_reports`
--

DROP TABLE IF EXISTS `i_a_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `i_a_reports` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `ia_owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ia_nationality` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ia_dateTime` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ia_injury` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ia_damage` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ia_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ia_wasInjured` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ia_ntInjuredReason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ia_agencyInvolved` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ia_agencyPart` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ia_accidentType` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ia_condition` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ia_unsafeAct` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ia_factor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ia_preventiveMeasure` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ia_safeguard` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ia_useSafeguard` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ia_ntSafeguardReason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ia_affectedWorkers` json DEFAULT NULL,
  `ia_affectedWorkers_count` int NOT NULL,
  `ia_compensation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ia_compensation_amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ia_medical` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ia_burial` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ia_timeLostDay` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ia_timeLostDay_hours` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ia_timeLostDay_mins` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ia_timeLostSubseq` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ia_timeLostSubseq_hours` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ia_timeLostSubseq_mins` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ia_timeReducedOutput` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ia_timeReducedOutput_days` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ia_timeReducedOutput_percent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ia_machineryDamage` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ia_machineryDamage_repair` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ia_machineryDamage_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ia_machineryDamage_production` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ia_materialDamage` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ia_materialDamage_repair` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ia_materialDamage_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ia_materialDamage_production` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ia_equipmentDamage` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ia_equipmentDamage_repair` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ia_equipmentDamage_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ia_equipmentDamage_production` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ia_safetyOfficer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ia_safetyOfficer_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ia_employer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ia_employer_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ia_estabId` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `illness_reports`
--

DROP TABLE IF EXISTS `illness_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `illness_reports` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `ip_owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_nationality` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_engineering` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_engineering_cost` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_administrative` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_administrative_cost` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_ppe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_ppe_cost` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_affectedWorkers` json DEFAULT NULL,
  `ip_affectedWorkers_count` int NOT NULL,
  `ip_safetyOfficer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_safetyOfficer_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_employer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_employer_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_estabId` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `imports`
--

DROP TABLE IF EXISTS `imports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `imports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `completed_at` timestamp NULL DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `importer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `processed_rows` int unsigned NOT NULL DEFAULT '0',
  `total_rows` int unsigned NOT NULL,
  `successful_rows` int unsigned NOT NULL DEFAULT '0',
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `media` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `collection_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conversions_disk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` bigint unsigned NOT NULL,
  `manipulations` json NOT NULL,
  `custom_properties` json NOT NULL,
  `generated_conversions` json NOT NULL,
  `responsive_images` json NOT NULL,
  `order_column` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `media_uuid_unique` (`uuid`),
  KEY `media_model_type_model_id_index` (`model_type`,`model_id`),
  KEY `media_order_column_index` (`order_column`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `month13ths`
--

DROP TABLE IF EXISTS `month13ths`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `month13ths` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `month13th_yearCovered` int NOT NULL,
  `month13th_numWorkers` int NOT NULL,
  `month13th_amount` int NOT NULL,
  `month13th_ownRep` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `month13th_designation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `month13th_contact` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `month13th_lessFive` int NOT NULL,
  `month13th_fiveTen` int NOT NULL,
  `month13th_tenTwenty` int NOT NULL,
  `month13th_twentyThirty` int NOT NULL,
  `month13th_thirtyForty` int NOT NULL,
  `month13th_fortyFifty` int NOT NULL,
  `month13th_fiftySixty` int NOT NULL,
  `month13th_sixtySeventy` int NOT NULL,
  `month13th_seventyEighty` int NOT NULL,
  `month13th_eightyNinety` int NOT NULL,
  `month13th_ninetyHundred` int NOT NULL,
  `month13th_moreHundred` int NOT NULL,
  `month13th_estabId` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `n_i_a_reports`
--

DROP TABLE IF EXISTS `n_i_a_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `n_i_a_reports` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `nia_owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nia_nationality` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nia_safetyOfficer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nia_safetyOfficer_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nia_employer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nia_employer_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nia_estabId` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `otp_codes`
--

DROP TABLE IF EXISTS `otp_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `otp_codes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `psic_classes`
--

DROP TABLE IF EXISTS `psic_classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `psic_classes` (
  `class_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `class_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`class_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `psic_divisions`
--

DROP TABLE IF EXISTS `psic_divisions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `psic_divisions` (
  `division_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `division_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `division_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`division_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `psic_groups`
--

DROP TABLE IF EXISTS `psic_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `psic_groups` (
  `group_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `group_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `psic_sections`
--

DROP TABLE IF EXISTS `psic_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `psic_sections` (
  `section_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `section_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `section_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`section_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locked` tinyint(1) NOT NULL DEFAULT '0',
  `payload` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_group_name_unique` (`group`,`name`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tele_report_branches`
--

DROP TABLE IF EXISTS `tele_report_branches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tele_report_branches` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `teleBranch_estabId` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `teleBranch_manageMale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `teleBranch_manageFemale` int NOT NULL,
  `teleBranch_superMale` int NOT NULL,
  `teleBranch_superFemale` int NOT NULL,
  `teleBranch_rankMale` int NOT NULL,
  `teleBranch_rankFemale` int NOT NULL,
  `teleBranch_total` int NOT NULL,
  `teleBranch_disabMale` int NOT NULL,
  `teleBranch_disabFemale` int NOT NULL,
  `teleBranch_soloperMale` int NOT NULL,
  `teleBranch_soloperFemale` int NOT NULL,
  `teleBranch_immunoMale` int NOT NULL,
  `teleBranch_immunoFemale` int NOT NULL,
  `teleBranch_mentalMale` int NOT NULL,
  `teleBranch_mentalFemale` int NOT NULL,
  `teleBranch_seniorMale` int NOT NULL,
  `teleBranch_seniorFemale` int NOT NULL,
  `teleBranch_specialTotal` int NOT NULL,
  `teleBranch_workspace` json NOT NULL,
  `teleBranch_workspace_others` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `teleBranch_areasCovered` json NOT NULL,
  `teleBranch_areasCovered_others` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `teleBranch_program` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `teleBranch_employer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `teleBranch_designation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `teleBranch_contact` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tele_report_heads`
--

DROP TABLE IF EXISTS `tele_report_heads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tele_report_heads` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `teleHead_estabId` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `teleHead_manageMale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `teleHead_manageFemale` int NOT NULL,
  `teleHead_superMale` int NOT NULL,
  `teleHead_superFemale` int NOT NULL,
  `teleHead_rankMale` int NOT NULL,
  `teleHead_rankFemale` int NOT NULL,
  `teleHead_total` int NOT NULL,
  `teleHead_disabMale` int NOT NULL,
  `teleHead_disabFemale` int NOT NULL,
  `teleHead_soloperMale` int NOT NULL,
  `teleHead_soloperFemale` int NOT NULL,
  `teleHead_immunoMale` int NOT NULL,
  `teleHead_immunoFemale` int NOT NULL,
  `teleHead_mentalMale` int NOT NULL,
  `teleHead_mentalFemale` int NOT NULL,
  `teleHead_seniorMale` int NOT NULL,
  `teleHead_seniorFemale` int NOT NULL,
  `teleHead_specialTotal` int NOT NULL,
  `teleHead_workspace` json NOT NULL,
  `teleHead_workspace_others` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `teleHead_areasCovered` json NOT NULL,
  `teleHead_areasCovered_others` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `teleHead_program` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `teleHead_employer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `teleHead_designation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `teleHead_contact` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tele_report_temps`
--

DROP TABLE IF EXISTS `tele_report_temps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tele_report_temps` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `teleBranch_estabId` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `teleBranch_manageMale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `teleBranch_manageFemale` int NOT NULL,
  `teleBranch_superMale` int NOT NULL,
  `teleBranch_superFemale` int NOT NULL,
  `teleBranch_rankMale` int NOT NULL,
  `teleBranch_rankFemale` int NOT NULL,
  `teleBranch_total` int NOT NULL,
  `teleBranch_disabMale` int NOT NULL,
  `teleBranch_disabFemale` int NOT NULL,
  `teleBranch_soloperMale` int NOT NULL,
  `teleBranch_soloperFemale` int NOT NULL,
  `teleBranch_immunoMale` int NOT NULL,
  `teleBranch_immunoFemale` int NOT NULL,
  `teleBranch_mentalMale` int NOT NULL,
  `teleBranch_mentalFemale` int NOT NULL,
  `teleBranch_seniorMale` int NOT NULL,
  `teleBranch_seniorFemale` int NOT NULL,
  `teleBranch_specialTotal` int NOT NULL,
  `teleBranch_workspace` json NOT NULL,
  `teleBranch_workspace_others` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `teleBranch_areasCovered` json NOT NULL,
  `teleBranch_areasCovered_others` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tele_reports`
--

DROP TABLE IF EXISTS `tele_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tele_reports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tele_reportType` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tele_reportId` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tele_estabId` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `temp_emps`
--

DROP TABLE IF EXISTS `temp_emps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `temp_emps` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emp_estabId` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `emp_lastName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_firstName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_middleName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_extensionName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_birthday` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_sex` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_civilStatus` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_houseNum` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_street` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_region` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_province` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_barangay` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_wage` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_numDependents` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_serviceLength` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_occupation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_yearsExp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_employmentStatus` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_shiftStart` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_shiftEnd` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_workHours` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_workDays` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_injill` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_injNature` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_injAffected` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_illType` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_illLocation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_dateStart` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_dateReturned` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_daysLost` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_daysCharged` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `est_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `authority` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `password_expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wairs`
--

DROP TABLE IF EXISTS `wairs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wairs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `wairs_reportType` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `wairs_reportId` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `wairs_estabId` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-09-16 12:10:27
