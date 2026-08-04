/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE TABLE IF NOT EXISTS `evaluation_criteria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_th` varchar(255) DEFAULT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `criteria_active` int(2) NOT NULL DEFAULT 1,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL DEFAULT 0,
  `updated_by` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

INSERT INTO `evaluation_criteria` (`id`, `title_th`, `title_en`, `criteria_active`, `created`, `updated`, `created_by`, `updated_by`) VALUES
	(1, 'ความรู้ในงาน', 'Knowledge in job', 1, '2023-12-22 07:12:56', NULL, 12, 0),
	(2, 'คุณภาพงาน', 'Quality of work', 1, '2023-12-22 07:18:44', NULL, 12, 0),
	(3, 'ความเป็นผู้นำ', 'Leadership', 1, '2023-12-22 07:19:04', NULL, 12, 0),
	(4, 'การทำงานเป็นทีม', 'Team player', 1, '2023-12-22 07:19:17', NULL, 12, 0),
	(5, 'ทักษะในการสื่อสาร', 'Communication skills', 1, '2023-12-22 07:19:31', NULL, 12, 0),
	(6, 'ทัศนคติในการทำงาน', 'Job attitude', 1, '2023-12-22 07:19:44', NULL, 12, 0),
	(7, 'ความร่วมมือในกิจกรรมของบริษัท', 'Participation in company activities', 1, '2023-12-22 07:19:59', NULL, 12, 0),
	(8, 'ความคิดริเริ่มและสร้างสรรค์', 'Initiative and innovation', 1, '2023-12-22 07:20:11', NULL, 12, 0),
	(13, 'ความปลอดภัยในการทำงาน‎‎', 'Work in a Safe Way', 1, '2023-12-22 07:20:11', NULL, 12, 0);

CREATE TABLE IF NOT EXISTS `factory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

INSERT INTO `factory` (`id`, `name`, `created`, `updated`) VALUES
	(1, 'MIL', '2023-12-26 13:44:17', NULL),
	(2, 'MTL', '2023-12-26 13:44:17', NULL);

CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `group_form` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_th` varchar(255) DEFAULT NULL,
  `form_en` varchar(255) DEFAULT NULL,
  `form_type` text DEFAULT NULL,
  `form_year_use_start` text NOT NULL,
  `form_year_use_end` text DEFAULT NULL,
  `form_ref` text DEFAULT NULL,
  `code1` text DEFAULT NULL,
  `code2` text DEFAULT NULL,
  `code3` text DEFAULT NULL,
  `code4` text DEFAULT NULL,
  `code5` text DEFAULT NULL,
  `criteria_weight_status` int(2) DEFAULT NULL,
  `criteria_weight` text DEFAULT NULL,
  `compliance_weight_status` int(2) DEFAULT NULL,
  `compliance_weight` text DEFAULT NULL,
  `revise` int(11) DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `create_date` date DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

INSERT INTO `group_form` (`id`, `form_th`, `form_en`, `form_type`, `form_year_use_start`, `form_year_use_end`, `form_ref`, `code1`, `code2`, `code3`, `code4`, `code5`, `criteria_weight_status`, `criteria_weight`, `compliance_weight_status`, `compliance_weight`, `revise`, `status`, `created`, `create_date`, `updated`, `created_by`, `updated_by`) VALUES
	(1, 'พนักงานฝ่ายผลิตระดับปฏิบัติการ', 'Shopfloor Basic', 'Shopfloor Basic', '2023', '2023', 'F1', 'MIL', 'HR', 'P01', 'F1', '0', 1, '2', 1, '1', 7, 1, '2023-12-26 04:28:03', '2023-12-26', '2024-01-21 06:45:47', 12, 12),
	(2, 'พนักงานฝ่ายผลิตระดับบังคับบัญชา', 'Shop Floor with Subordinates)', 'Shop Floor with Subordinates)', '2023', '2023', 'F2', 'MIL', 'HR', 'P01', 'F2', '0', 1, '1', 1, '1', 1, 1, '2024-01-03 16:27:22', '2024-01-03', '2024-01-21 06:47:53', 12, 12),
	(3, 'พนักงานสำนักงานระดับปฏิบัติการ', 'Office Basic', 'Office Basic', '2023', '2023', 'F3', 'MIL', 'HR', 'P01', 'F3', '0', 1, '1', 1, '1', 2, 1, '2024-01-03 16:27:22', '2024-01-03', '2024-01-23 18:02:29', 12, 14),
	(4, 'พนักงานสำนักงานระดับบังคับบัญชา', 'Office with Subordinates', 'Office with Subordinates', '2023', '2023', 'F4', 'MIL', 'HR', 'P01', 'F4', '0', 1, '1', 1, '1', 1, 1, '2024-01-22 06:02:20', '2024-01-03', '2024-01-21 06:48:25', 12, 12),
	(8, 'พนักงานสำนักงานระดับบังคับบัญชา', 'Office with Subordinates', 'Office with Subordinates', '2024', '2024', 'F4', 'MIL', 'HR', 'P01', 'F4', '0', 1, '1', 1, '1', 7, 0, '2024-01-22 06:20:32', '2024-01-22', '2024-01-22 06:26:40', 12, 12);

CREATE TABLE IF NOT EXISTS `group_form_score_level` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_form_id` int(11) DEFAULT NULL,
  `score_start` int(11) DEFAULT NULL,
  `score_end` int(11) DEFAULT NULL,
  `score_level_th` text DEFAULT NULL,
  `score_level_en` text DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `group_form_id` (`group_form_id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

INSERT INTO `group_form_score_level` (`id`, `group_form_id`, `score_start`, `score_end`, `score_level_th`, `score_level_en`, `created`, `updated`, `created_by`, `updated_by`) VALUES
	(25, 1, 1, 3, 'ต่ำกว่ามาตรฐาน', 'Below Standard', '2024-01-21 06:45:47', NULL, 12, NULL),
	(26, 1, 4, 7, 'มาตรฐาน', 'Standard', '2024-01-21 06:45:47', NULL, 12, NULL),
	(27, 1, 8, 10, 'สูงกว่ามาตรฐาน', 'Above Standard', '2024-01-21 06:45:48', NULL, 12, NULL),
	(28, 2, 1, 3, 'ต่ำกว่ามาตรฐาน', 'Below Standard', '2024-01-21 06:47:53', NULL, 12, NULL),
	(29, 2, 4, 7, 'มาตรฐาน', 'Standard', '2024-01-21 06:47:53', NULL, 12, NULL),
	(30, 2, 8, 10, 'สูงกว่ามาตรฐาน', 'Above Standard', '2024-01-21 06:47:53', NULL, 12, NULL),
	(34, 4, 1, 3, 'ต่ำกว่ามาตรฐาน', 'Below Standard', '2024-01-21 06:48:26', NULL, 12, NULL),
	(35, 4, 4, 7, 'มาตรฐาน', 'Standard', '2024-01-21 06:48:26', NULL, 12, NULL),
	(36, 4, 8, 10, 'สูงกว่ามาตรฐาน', 'Above Standard', '2024-01-21 06:48:26', NULL, 12, NULL),
	(61, 8, 1, 3, 'ต่ำกว่ามาตรฐาน', 'Below Standard', '2024-01-22 06:26:40', NULL, 12, NULL),
	(62, 8, 4, 7, 'มาตรฐาน', 'Standard', '2024-01-22 06:26:40', NULL, 12, NULL),
	(63, 8, 8, 10, 'สูงกว่ามาตรฐาน', 'Above Standard', '2024-01-22 06:26:40', NULL, 12, NULL),
	(64, 3, 1, 3, 'ต่ำกว่ามาตรฐาน', 'Below Standard', '2024-01-23 18:02:29', NULL, 14, NULL),
	(65, 3, 4, 7, 'มาตรฐาน', 'Standard', '2024-01-23 18:02:30', NULL, 14, NULL),
	(66, 3, 8, 10, 'สูงกว่ามาตรฐาน', 'Above Standard', '2024-01-23 18:02:30', NULL, 14, NULL);

CREATE TABLE IF NOT EXISTS `group_form_topic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_form_id` int(11) DEFAULT NULL,
  `evaluation_criteria_id` int(11) DEFAULT NULL,
  `topic_weight` text DEFAULT NULL,
  `detail_high_th` text DEFAULT NULL,
  `detail_high_en` text DEFAULT NULL,
  `detail_medium_th` text DEFAULT NULL,
  `detail_medium_en` text DEFAULT NULL,
  `detail_low_th` text DEFAULT NULL,
  `detail_low_en` text DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `evaluation_criteria_id` (`evaluation_criteria_id`),
  KEY `group_form_id` (`group_form_id`)
) ENGINE=InnoDB AUTO_INCREMENT=172 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

INSERT INTO `group_form_topic` (`id`, `group_form_id`, `evaluation_criteria_id`, `topic_weight`, `detail_high_th`, `detail_high_en`, `detail_medium_th`, `detail_medium_en`, `detail_low_th`, `detail_low_en`, `created`, `updated`, `created_by`, `updated_by`) VALUES
	(55, 1, 1, '1', 'มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่น\nได้', 'Expert in all facets ot the job, can teach others how \nto do', 'มีความรู้เพียงพอที่จะปฏิบัติงานได้', 'Has sufficient knowledge of how to do the job', 'ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน', 'Needs further coaching/training on how to do his/\nher job', '2024-01-21 06:45:48', NULL, 12, NULL),
	(56, 1, 2, '2', 'มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่น\nได้', 'Expert in all facets ot the job, can teach others how \nto do', 'มีความรู้เพียงพอที่จะปฏิบัติงานได้', 'Has sufficient knowledge of how to do the job', 'ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน', 'Needs further coaching/training on how to do his/\nher job', '2024-01-21 06:45:48', NULL, 12, NULL),
	(57, 1, 4, '0.5', 'มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่น\nได้', 'Expert in all facets ot the job, can teach others how \nto do', 'มีความรู้เพียงพอที่จะปฏิบัติงานได้', 'Has sufficient knowledge of how to do the job', 'ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน', 'Needs further coaching/training on how to do his/\nher job', '2024-01-21 06:45:48', NULL, 12, NULL),
	(58, 1, 6, '1', 'มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่น\nได้', 'Expert in all facets ot the job, can teach others how \nto do', 'มีความรู้เพียงพอที่จะปฏิบัติงานได้', 'Has sufficient knowledge of how to do the job', 'ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน', 'Needs further coaching/training on how to do his/\nher job', '2024-01-21 06:45:48', NULL, 12, NULL),
	(59, 1, 13, '1', 'มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่น\nได้', 'Expert in all facets ot the job, can teach others how \nto do', 'มีความรู้เพียงพอที่จะปฏิบัติงานได้', 'Has sufficient knowledge of how to do the job', 'ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน', 'Needs further coaching/training on how to do his/\nher job', '2024-01-21 06:45:48', NULL, 12, NULL),
	(60, 1, 7, '1', 'มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่น\nได้', 'Expert in all facets ot the job, can teach others how \nto do', 'มีความรู้เพียงพอที่จะปฏิบัติงานได้', 'Has sufficient knowledge of how to do the job', 'ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน', 'Needs further coaching/training on how to do his/\nher job', '2024-01-21 06:45:48', NULL, 12, NULL),
	(61, 1, 8, '0.5', 'มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่น\nได้', 'Expert in all facets ot the job, can teach others how \nto do', 'มีความรู้เพียงพอที่จะปฏิบัติงานได้', 'Has sufficient knowledge of how to do the job', 'ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน', 'Needs further coaching/training on how to do his/\nher job', '2024-01-21 06:45:49', NULL, 12, NULL),
	(62, 2, 1, '1', 'มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่น\nได้', 'Expert in all facets ot the job, can teach others how \nto do', 'มีความรู้เพียงพอที่จะปฏิบัติงานได้', 'Has sufficient knowledge of how to do the job', 'ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน', 'Needs further coaching/training on how to do his/\nher job', '2024-01-21 06:47:54', NULL, 12, NULL),
	(63, 2, 2, '1', 'มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่น\nได้', 'Expert in all facets ot the job, can teach others how \nto do', 'มีความรู้เพียงพอที่จะปฏิบัติงานได้', 'Has sufficient knowledge of how to do the job', 'ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน', 'Needs further coaching/training on how to do his/\nher job', '2024-01-21 06:47:54', NULL, 12, NULL),
	(64, 2, 3, '1', 'มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่น\nได้', 'Expert in all facets ot the job, can teach others how \nto do', 'มีความรู้เพียงพอที่จะปฏิบัติงานได้', 'Has sufficient knowledge of how to do the job', 'ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน', 'Needs further coaching/training on how to do his/\nher job', '2024-01-21 06:47:54', NULL, 12, NULL),
	(65, 2, 4, '1', 'มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่น\nได้', 'Expert in all facets ot the job, can teach others how \nto do', 'มีความรู้เพียงพอที่จะปฏิบัติงานได้', 'Has sufficient knowledge of how to do the job', 'ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน', 'Needs further coaching/training on how to do his/\nher job', '2024-01-21 06:47:54', NULL, 12, NULL),
	(66, 2, 5, '0.5', 'มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่น\nได้', 'Expert in all facets ot the job, can teach others how \nto do', 'มีความรู้เพียงพอที่จะปฏิบัติงานได้', 'Has sufficient knowledge of how to do the job', 'ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน', 'Needs further coaching/training on how to do his/\nher job', '2024-01-21 06:47:54', NULL, 12, NULL),
	(67, 2, 6, '1', 'มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่น\nได้', 'Expert in all facets ot the job, can teach others how \nto do', 'มีความรู้เพียงพอที่จะปฏิบัติงานได้', 'Has sufficient knowledge of how to do the job', 'ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน', 'Needs further coaching/training on how to do his/\nher job', '2024-01-21 06:47:55', NULL, 12, NULL),
	(68, 2, 13, '0.5', 'มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่น\nได้', 'Expert in all facets ot the job, can teach others how \nto do', 'มีความรู้เพียงพอที่จะปฏิบัติงานได้', 'Has sufficient knowledge of how to do the job', 'ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน', 'Needs further coaching/training on how to do his/\nher job', '2024-01-21 06:47:55', NULL, 12, NULL),
	(69, 2, 7, '1', 'มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่น\nได้', 'Expert in all facets ot the job, can teach others how \nto do', 'มีความรู้เพียงพอที่จะปฏิบัติงานได้', 'Has sufficient knowledge of how to do the job', 'ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน', 'Needs further coaching/training on how to do his/\nher job', '2024-01-21 06:47:55', NULL, 12, NULL),
	(70, 2, 8, '1', 'มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่น\nได้', 'Expert in all facets ot the job, can teach others how \nto do', 'มีความรู้เพียงพอที่จะปฏิบัติงานได้', 'Has sufficient knowledge of how to do the job', 'ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน', 'Needs further coaching/training on how to do his/\nher job', '2024-01-21 06:47:55', NULL, 12, NULL),
	(78, 4, 1, '1', 'มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่น\nได้', 'Expert in all facets ot the job, can teach others how \nto do', 'มีความรู้เพียงพอที่จะปฏิบัติงานได้', 'Has sufficient knowledge of how to do the job', 'ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน', 'Needs further coaching/training on how to do his/\nher job', '2024-01-21 06:48:26', NULL, 12, NULL),
	(79, 4, 2, '1', 'มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่น\nได้', 'Expert in all facets ot the job, can teach others how \nto do', 'มีความรู้เพียงพอที่จะปฏิบัติงานได้', 'Has sufficient knowledge of how to do the job', 'ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน', 'Needs further coaching/training on how to do his/\nher job', '2024-01-21 06:48:26', NULL, 12, NULL),
	(80, 4, 3, '1', 'มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่น\nได้', 'Expert in all facets ot the job, can teach others how \nto do', 'มีความรู้เพียงพอที่จะปฏิบัติงานได้', 'Has sufficient knowledge of how to do the job', 'ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน', 'Needs further coaching/training on how to do his/\nher job', '2024-01-21 06:48:26', NULL, 12, NULL),
	(81, 4, 4, '1', 'มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่น\nได้', 'Expert in all facets ot the job, can teach others how \nto do', 'มีความรู้เพียงพอที่จะปฏิบัติงานได้', 'Has sufficient knowledge of how to do the job', 'ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน', 'Needs further coaching/training on how to do his/\nher job', '2024-01-21 06:48:26', NULL, 12, NULL),
	(82, 4, 5, '1', 'มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่น\nได้', 'Expert in all facets ot the job, can teach others how \nto do', 'มีความรู้เพียงพอที่จะปฏิบัติงานได้', 'Has sufficient knowledge of how to do the job', 'ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน', 'Needs further coaching/training on how to do his/\nher job', '2024-01-21 06:48:27', NULL, 12, NULL),
	(83, 4, 6, '1', 'มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่น\nได้', 'Expert in all facets ot the job, can teach others how \nto do', 'มีความรู้เพียงพอที่จะปฏิบัติงานได้', 'Has sufficient knowledge of how to do the job', 'ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน', 'Needs further coaching/training on how to do his/\nher job', '2024-01-21 06:48:27', NULL, 12, NULL),
	(84, 4, 7, '1', 'มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่น\nได้', 'Expert in all facets ot the job, can teach others how \nto do', 'มีความรู้เพียงพอที่จะปฏิบัติงานได้', 'Has sufficient knowledge of how to do the job', 'ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน', 'Needs further coaching/training on how to do his/\nher job', '2024-01-21 06:48:27', NULL, 12, NULL),
	(85, 4, 8, '1', 'มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่น\nได้', 'Expert in all facets ot the job, can teach others how \nto do', 'มีความรู้เพียงพอที่จะปฏิบัติงานได้', 'Has sufficient knowledge of how to do the job', 'ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน', 'Needs further coaching/training on how to do his/\nher job', '2024-01-21 06:48:27', NULL, 12, NULL),
	(150, 8, 1, '1', 'มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่น\nได้', 'Expert in all facets ot the job, can teach others how \nto do', 'มีความรู้เพียงพอที่จะปฏิบัติงานได้', 'Has sufficient knowledge of how to do the job', 'ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน', 'Needs further coaching/training on how to do his/\nher job', '2024-01-22 06:26:40', NULL, 12, NULL),
	(151, 8, 2, '1', 'มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่น\nได้', 'Expert in all facets ot the job, can teach others how \nto do', 'มีความรู้เพียงพอที่จะปฏิบัติงานได้', 'Has sufficient knowledge of how to do the job', 'ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน', 'Needs further coaching/training on how to do his/\nher job', '2024-01-22 06:26:40', NULL, 12, NULL),
	(152, 8, 3, '1', 'มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่น\nได้', 'Expert in all facets ot the job, can teach others how \nto do', 'มีความรู้เพียงพอที่จะปฏิบัติงานได้', 'Has sufficient knowledge of how to do the job', 'ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน', 'Needs further coaching/training on how to do his/\nher job', '2024-01-22 06:26:40', NULL, 12, NULL),
	(153, 8, 4, '1', 'มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่น\nได้', 'Expert in all facets ot the job, can teach others how \nto do', 'มีความรู้เพียงพอที่จะปฏิบัติงานได้', 'Has sufficient knowledge of how to do the job', 'ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน', 'Needs further coaching/training on how to do his/\nher job', '2024-01-22 06:26:41', NULL, 12, NULL),
	(154, 8, 5, '1', 'มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่น\nได้', 'Expert in all facets ot the job, can teach others how \nto do', 'มีความรู้เพียงพอที่จะปฏิบัติงานได้', 'Has sufficient knowledge of how to do the job', 'ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน', 'Needs further coaching/training on how to do his/\nher job', '2024-01-22 06:26:41', NULL, 12, NULL),
	(155, 8, 6, '1', 'มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่น\nได้', 'Expert in all facets ot the job, can teach others how \nto do', 'มีความรู้เพียงพอที่จะปฏิบัติงานได้', 'Has sufficient knowledge of how to do the job', 'ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน', 'Needs further coaching/training on how to do his/\nher job', '2024-01-22 06:26:41', NULL, 12, NULL),
	(156, 8, 7, '1', 'มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่น\nได้', 'Expert in all facets ot the job, can teach others how \nto do', 'มีความรู้เพียงพอที่จะปฏิบัติงานได้', 'Has sufficient knowledge of how to do the job', 'ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน', 'Needs further coaching/training on how to do his/\nher job', '2024-01-22 06:26:41', NULL, 12, NULL),
	(157, 8, 8, '1', 'มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่น\nได้', 'Expert in all facets ot the job, can teach others how \nto do', 'มีความรู้เพียงพอที่จะปฏิบัติงานได้', 'Has sufficient knowledge of how to do the job', 'ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน', 'Needs further coaching/training on how to do his/\nher job', '2024-01-22 06:26:41', NULL, 12, NULL),
	(158, 3, 1, '1', 'มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่น\nได้', 'Expert in all facets ot the job, can teach others how \nto do', 'มีความรู้เพียงพอที่จะปฏิบัติงานได้', 'Has sufficient knowledge of how to do the job', 'ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน', 'Needs further coaching/training on how to do his/\nher job', '2024-01-23 18:02:31', NULL, 14, NULL),
	(159, 3, 2, '2', 'มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่น\nได้', 'Expert in all facets ot the job, can teach others how \nto do', 'มีความรู้เพียงพอที่จะปฏิบัติงานได้', 'Has sufficient knowledge of how to do the job', 'ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน', 'Needs further coaching/training on how to do his/\nher job', '2024-01-23 18:02:31', NULL, 14, NULL),
	(160, 3, 4, '1', 'มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่น\nได้', 'Expert in all facets ot the job, can teach others how \nto do', 'มีความรู้เพียงพอที่จะปฏิบัติงานได้', 'Has sufficient knowledge of how to do the job', 'ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน', 'Needs further coaching/training on how to do his/\nher job', '2024-01-23 18:02:31', NULL, 14, NULL),
	(161, 3, 5, '1', 'มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่น\nได้', 'Expert in all facets ot the job, can teach others how \nto do', 'มีความรู้เพียงพอที่จะปฏิบัติงานได้', 'Has sufficient knowledge of how to do the job', 'ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน', 'Needs further coaching/training on how to do his/\nher job', '2024-01-23 18:02:31', NULL, 14, NULL),
	(162, 3, 6, '1', 'มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่น\nได้', 'Expert in all facets ot the job, can teach others how \nto do', 'มีความรู้เพียงพอที่จะปฏิบัติงานได้', 'Has sufficient knowledge of how to do the job', 'ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน', 'Needs further coaching/training on how to do his/\nher job', '2024-01-23 18:02:31', NULL, 14, NULL),
	(163, 3, 7, '1', 'มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่น\nได้', 'Expert in all facets ot the job, can teach others how \nto do', 'มีความรู้เพียงพอที่จะปฏิบัติงานได้', 'Has sufficient knowledge of how to do the job', 'ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน', 'Needs further coaching/training on how to do his/\nher job', '2024-01-23 18:02:32', NULL, 14, NULL),
	(164, 3, 8, '1', 'มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่น\nได้', 'Expert in all facets ot the job, can teach others how \nto do', 'มีความรู้เพียงพอที่จะปฏิบัติงานได้', 'Has sufficient knowledge of how to do the job', 'ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน', 'Needs further coaching/training on how to do his/\nher job', '2024-01-23 18:02:32', NULL, 14, NULL);

CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2023_05_28_090500_add_login_fields_to_users_table', 1),
	(6, '2023_06_11_075700_create_permission_tables', 1),
	(7, '2023_06_12_013333_add_profile_photo_path_column_to_users_table', 1),
	(20, '2023_11_23_042011_create_tb_manage_employee', 11),
	(28, '2023_11_09_031620_create_tb_pa_timeline_action', 16),
	(29, '2023_11_09_031312_create_tb_pa_timeline', 17),
	(35, '2023_12_11_031531_create_tb_section', 22),
	(36, '2023_11_21_022929_create_tb_position', 23),
	(37, '2023_11_21_022943_create_tb_department', 24),
	(38, '2023_11_21_022952_create_tb_division', 25);

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `tb_budget` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) DEFAULT NULL,
  `year` varchar(100) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `created_by` varchar(191) DEFAULT NULL,
  `updated_by` varchar(191) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tb_budget` (`id`, `title`, `year`, `date`, `created`, `updated`, `created_by`, `updated_by`) VALUES
	(2, 'Budget Year 2023', '2023', '2023-11-23', '2023-11-23 06:08:20', '2023-11-23 06:08:20', NULL, NULL);

CREATE TABLE IF NOT EXISTS `tb_budget_action` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `budget_id` varchar(191) NOT NULL,
  `grade_name` varchar(191) NOT NULL,
  `budget_range_start` float(10,2) DEFAULT NULL,
  `budget_range_end` float(10,2) DEFAULT NULL,
  `std` float(10,2) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `created_by` varchar(191) DEFAULT NULL,
  `updated_by` varchar(191) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tb_budget_action` (`id`, `budget_id`, `grade_name`, `budget_range_start`, `budget_range_end`, `std`, `created`, `updated`, `created_by`, `updated_by`) VALUES
	(9, '2', 'AR', 1.50, 1.50, 1.50, '2023-11-23 07:25:33', '2024-01-12 09:58:54', NULL, NULL),
	(10, '2', 'P', 10.00, 12.00, 10.00, '2023-11-23 07:25:46', '2023-11-23 07:25:46', NULL, NULL),
	(11, '2', 'A', 5.50, 6.50, 6.00, '2023-11-23 07:26:02', '2023-11-23 07:26:02', NULL, NULL),
	(12, '2', 'B', 4.00, 5.00, 4.50, '2023-11-23 07:26:17', '2023-11-23 07:26:17', NULL, NULL),
	(13, '2', 'C', 2.50, 3.50, 3.00, '2023-11-23 07:26:33', '2023-11-23 07:26:33', NULL, NULL),
	(14, '2', 'D', 1.00, 1.50, 1.00, '2023-11-23 07:26:44', '2023-11-23 07:26:44', NULL, NULL),
	(15, '2', 'E', 0.25, 0.50, 0.25, '2023-11-23 07:28:15', '2023-11-23 07:32:22', NULL, NULL),
	(16, '2', 'U', NULL, NULL, NULL, '2024-01-16 08:09:56', '2024-01-16 08:09:56', NULL, NULL),
	(17, '2', 'CD', NULL, NULL, NULL, '2024-01-16 08:10:03', '2024-01-16 08:10:03', NULL, NULL);

CREATE TABLE IF NOT EXISTS `tb_department` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `department_code` varchar(191) NOT NULL,
  `department_description` varchar(191) NOT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `created_by` varchar(191) DEFAULT NULL,
  `updated_by` varchar(191) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tb_department` (`id`, `department_code`, `department_description`, `created`, `updated`, `created_by`, `updated_by`) VALUES
	(38, '1200', 'CE-Production', '2023-12-11 06:53:32', '2023-12-11 06:53:32', NULL, NULL),
	(39, '1600', 'CE-Production Engineering', '2023-12-11 06:53:34', '2023-12-11 06:53:34', NULL, NULL),
	(40, '2200', 'AAP-Production', '2023-12-11 06:53:34', '2023-12-11 06:53:34', NULL, NULL),
	(41, '6200', 'PVD-Production', '2023-12-11 06:53:34', '2023-12-11 06:53:34', NULL, NULL),
	(42, '6300', 'PVD-Laboratory & QA', '2023-12-11 06:53:34', '2023-12-11 06:53:34', NULL, NULL),
	(43, '6400', 'PVD-Maintenance', '2023-12-11 06:53:34', '2023-12-11 06:53:34', NULL, NULL),
	(44, '7200', 'SS-Production', '2023-12-11 06:53:34', '2023-12-11 06:53:34', NULL, NULL),
	(45, '8200', 'HA-Production', '2023-12-11 06:53:34', '2023-12-11 06:53:34', NULL, NULL),
	(46, '8600', 'HA-Production Engineering', '2023-12-11 06:53:34', '2023-12-11 06:53:34', NULL, NULL),
	(47, '9100', 'CB-Production Planning & Material Control', '2023-12-11 06:53:34', '2023-12-11 06:53:34', NULL, NULL),
	(48, '9200', 'CB-Production', '2023-12-11 06:53:34', '2023-12-11 06:53:34', NULL, NULL),
	(49, '9300', 'CB-Printing', '2023-12-11 06:53:34', '2023-12-11 06:53:34', NULL, NULL),
	(50, '9400', 'CB-General Maintenance', '2023-12-11 06:53:34', '2023-12-11 06:53:34', NULL, NULL),
	(51, 'G100', 'Executive Office', '2023-12-11 06:53:34', '2023-12-11 06:53:34', NULL, NULL),
	(52, 'G200', 'Human Resources & Adminstration', '2023-12-11 06:53:34', '2023-12-11 06:53:34', NULL, NULL),
	(53, 'G300', 'Finance', '2023-12-11 06:53:34', '2023-12-11 06:53:34', NULL, NULL),
	(54, 'G400', 'Management Information System', '2023-12-11 06:53:34', '2023-12-11 06:53:34', NULL, NULL),
	(55, 'G500', 'Purchasing', '2023-12-11 06:53:34', '2023-12-11 06:53:34', NULL, NULL),
	(56, 'G600', 'Shipping', '2023-12-11 06:53:34', '2023-12-11 06:53:34', NULL, NULL),
	(57, 'G800', 'Satety & Security', '2023-12-11 06:53:34', '2023-12-11 06:53:34', NULL, NULL),
	(58, 'G900', 'Process Improvement', '2023-12-11 06:53:34', '2023-12-11 06:53:34', NULL, NULL),
	(59, 'P000', 'Engineering Maintenance', '2023-12-11 06:53:35', '2023-12-11 06:53:35', NULL, NULL),
	(60, 'P100', 'Design Engineering', '2023-12-11 06:53:35', '2023-12-11 06:53:35', NULL, NULL),
	(61, 'P200', 'Industrial Engineering', '2023-12-11 06:53:35', '2023-12-11 06:53:35', NULL, NULL),
	(62, 'P300', 'Laboratory', '2023-12-11 06:53:35', '2023-12-11 06:53:35', NULL, NULL),
	(63, 'P400', 'Quality Assurance', '2023-12-11 06:53:35', '2023-12-11 06:53:35', NULL, NULL),
	(64, 'P500', 'Production Engineering', '2023-12-11 06:53:35', '2023-12-11 06:53:35', NULL, NULL),
	(65, 'P600', 'Supply Chain Management', '2023-12-11 06:53:35', '2023-12-11 06:53:35', NULL, NULL),
	(66, 'P700', 'Environment', '2023-12-11 06:53:35', '2023-12-11 06:53:35', NULL, NULL),
	(67, 'P800', 'Automation', '2023-12-11 06:53:35', '2023-12-11 06:53:35', NULL, NULL),
	(68, 'P900', 'MSB', '2023-12-11 06:53:35', '2023-12-11 06:53:35', NULL, NULL),
	(69, 'PAAA', 'Manufacturing Office', '2023-12-11 06:53:35', '2023-12-11 06:53:35', NULL, NULL),
	(70, 'PBBB', 'Material Control', '2023-12-11 06:53:36', '2023-12-11 06:53:36', NULL, NULL),
	(71, 'PDDD', 'R&D', '2023-12-11 06:53:36', '2023-12-11 06:53:36', NULL, NULL),
	(72, 'Y200', 'GL-Production', '2023-12-11 06:53:36', '2023-12-11 06:53:36', NULL, NULL),
	(73, 'Z100', 'MS-Production Planning & Material', '2023-12-11 06:53:36', '2023-12-11 06:53:36', NULL, NULL),
	(74, 'Z200', 'MS-Production', '2023-12-11 06:53:36', '2023-12-11 06:53:36', NULL, NULL);

CREATE TABLE IF NOT EXISTS `tb_division` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `division_code` varchar(191) NOT NULL,
  `division_description` varchar(191) NOT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `created_by` varchar(191) DEFAULT NULL,
  `updated_by` varchar(191) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tb_division` (`id`, `division_code`, `division_description`, `created`, `updated`, `created_by`, `updated_by`) VALUES
	(11, '1000', 'Cookware', '2023-12-11 06:53:30', '2023-12-11 06:53:30', NULL, NULL),
	(12, '2000', 'AAP', '2023-12-11 06:53:30', '2023-12-11 06:53:30', NULL, NULL),
	(13, '6000', 'PVD', '2023-12-11 06:53:30', '2023-12-11 06:53:30', NULL, NULL),
	(14, '7000', 'Stainless Steel', '2023-12-11 06:53:31', '2023-12-11 06:53:31', NULL, NULL),
	(15, '8000', 'Hard Anodized', '2023-12-11 06:53:31', '2023-12-11 06:53:31', NULL, NULL),
	(16, '9000', 'Carton Box', '2023-12-11 06:53:31', '2023-12-11 06:53:31', NULL, NULL),
	(17, 'G000', 'General Office', '2023-12-11 06:53:31', '2023-12-11 06:53:31', NULL, NULL),
	(18, 'P000', 'General Production', '2023-12-11 06:53:31', '2023-12-11 06:53:31', NULL, NULL),
	(19, 'Y000', 'Manufacturing Support', '2023-12-11 06:53:31', '2023-12-11 06:53:31', NULL, NULL),
	(20, 'Z000', 'Manufacturing Support', '2023-12-11 06:53:32', '2023-12-11 06:53:32', NULL, NULL);

CREATE TABLE IF NOT EXISTS `tb_employee` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `employee_import_id` int(11) DEFAULT NULL,
  `users_id` int(11) DEFAULT NULL,
  `orisoft_no` varchar(6) DEFAULT NULL,
  `title_en` varchar(20) DEFAULT NULL,
  `title_th` varchar(20) DEFAULT NULL,
  `employee_local_name_th` varchar(191) DEFAULT NULL,
  `employee_local_name_en` varchar(191) DEFAULT NULL,
  `division_code` varchar(4) DEFAULT NULL,
  `division_code_transferred` varchar(255) DEFAULT NULL,
  `division_description` varchar(191) DEFAULT NULL,
  `department_code` varchar(4) DEFAULT NULL,
  `department_code_transferred` varchar(255) DEFAULT NULL,
  `department_description` varchar(255) DEFAULT NULL,
  `section_code` varchar(4) DEFAULT NULL,
  `section_code_transferred` varchar(255) DEFAULT NULL,
  `section_description` varchar(191) DEFAULT NULL,
  `position_code` varchar(3) DEFAULT NULL,
  `position_description` varchar(191) DEFAULT NULL,
  `grade_code` varchar(4) DEFAULT NULL,
  `grade_description` varchar(191) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `ref_log_id` varchar(191) DEFAULT NULL,
  `birth_date` datetime DEFAULT NULL,
  `date_joined` datetime DEFAULT NULL,
  `employee_type` varchar(1) DEFAULT NULL,
  `employee_type_description` varchar(20) DEFAULT NULL,
  `home_contact_1` varchar(20) DEFAULT NULL,
  `mail_address_1` text DEFAULT NULL,
  `date_resigned` datetime DEFAULT NULL,
  `date_retirement` datetime DEFAULT NULL,
  `date_confirmed` datetime DEFAULT NULL,
  `employee_status` varchar(1) DEFAULT NULL,
  `employee_status_description` varchar(20) DEFAULT NULL,
  `service_days` int(11) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `transferred_effective_date` date DEFAULT NULL,
  `resign_effective_date` date DEFAULT NULL,
  `created_by` varchar(191) DEFAULT NULL,
  `updated_by` varchar(191) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orisoft_no` (`orisoft_no`),
  UNIQUE KEY `users_id` (`users_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tb_employee` (`id`, `employee_import_id`, `users_id`, `orisoft_no`, `title_en`, `title_th`, `employee_local_name_th`, `employee_local_name_en`, `division_code`, `division_code_transferred`, `division_description`, `department_code`, `department_code_transferred`, `department_description`, `section_code`, `section_code_transferred`, `section_description`, `position_code`, `position_description`, `grade_code`, `grade_description`, `category`, `ref_log_id`, `birth_date`, `date_joined`, `employee_type`, `employee_type_description`, `home_contact_1`, `mail_address_1`, `date_resigned`, `date_retirement`, `date_confirmed`, `employee_status`, `employee_status_description`, `service_days`, `sort`, `transferred_effective_date`, `resign_effective_date`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
	(1, NULL, NULL, '001618', NULL, NULL, 'ละอองดาว  วงมาเกษ', 'RAONGDAO  WONGMAKATE', 'G000', NULL, 'General Office', 'G200', NULL, 'Human Resources & Adminstration', 'G2GA', NULL, 'General Affairs', '600', 'Maid', 'L800', 'Daily Worker ', NULL, NULL, NULL, '2003-04-07 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-01-23 09:49:05', NULL),
	(2, NULL, NULL, '015344', NULL, NULL, 'พิกุล  พินิจนอก', 'PIKUL  PINIJNOG', 'G000', NULL, 'General Office', 'G200', NULL, 'Human Resources & Adminstration', 'G2GA', NULL, 'General Affairs', '600', 'Maid', 'L800', 'Daily Worker ', NULL, NULL, NULL, '2012-07-04 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Passed', NULL, NULL, NULL, NULL, NULL, NULL, '2024-01-23 09:49:05', NULL),
	(3, NULL, NULL, '014276', NULL, NULL, 'เตือนใจ  วงเจริญ', 'TUEANCHAI  WONGCHAROEN', 'G000', NULL, 'General Office', 'G200', NULL, 'Human Resources & Adminstration', 'G2GA', NULL, 'General Affairs', '600', 'Maid', 'L800', 'Daily Worker ', NULL, NULL, NULL, '2012-01-13 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Passed', NULL, NULL, NULL, NULL, NULL, NULL, '2024-01-23 09:49:05', NULL),
	(4, NULL, NULL, '019832', NULL, NULL, 'สงกรานต์  โยยรัมย์', 'SONGKRAN  YOIRAM', 'G000', NULL, 'General Office', 'G200', NULL, 'Human Resources & Adminstration', 'G2GA', NULL, 'General Affairs', '601', 'Gardener', 'L800', 'Daily Worker ', NULL, NULL, NULL, '2021-11-10 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Passed', NULL, NULL, NULL, NULL, NULL, NULL, '2024-01-23 09:49:06', NULL),
	(5, NULL, NULL, '018264', NULL, NULL, 'มนัสชัย  กลัดเจริญ', 'MANATZCHAI  KLADJARERN', 'G000', NULL, 'General Office', 'G200', NULL, 'Human Resources & Adminstration', 'G2ER', NULL, 'Employee Relation', '406', 'Officer', 'L700', 'Below Section Head (TH)', NULL, NULL, NULL, '2013-08-23 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-01-23 09:49:06', NULL),
	(6, NULL, NULL, '019847', NULL, NULL, 'กรกมล  เพียวงค์', 'KORNKAMON  PIAWONG', 'G000', NULL, 'General Office', 'G200', NULL, 'Human Resources & Adminstration', 'G2ER', NULL, 'Employee Relation', '406', 'Officer', 'L700', 'Below Section Head (TH)', NULL, NULL, NULL, '2022-03-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Passed', NULL, NULL, NULL, NULL, NULL, NULL, '2024-01-23 09:49:06', NULL),
	(7, NULL, NULL, '000255', 'นาง/Mrs.', 'นาง', 'วันเพ็ญ  ทาเอื้อ', 'WANPEN  TAAER', 'G000', NULL, 'General Office', 'G200', NULL, 'Human Resources & Adminstration', 'G2GA', NULL, 'General Affairs', '301', 'Supervisor', 'L700', 'Below Section Head (TH)', NULL, NULL, NULL, '1993-04-19 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Passed', NULL, NULL, NULL, NULL, NULL, '13', '2024-01-23 09:49:07', '2024-01-23 09:49:22'),
	(8, NULL, NULL, '002131', NULL, NULL, 'ธัญยรัตน์  ประกอบผล', 'THANYARAT  PRAKOBPHON', 'G000', NULL, 'General Office', 'G200', NULL, 'Human Resources & Adminstration', 'G2GA', NULL, 'General Affairs', '425', 'Clerk', 'L700', 'Below Section Head (TH)', NULL, NULL, NULL, '2004-02-24 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Passed', NULL, NULL, NULL, NULL, NULL, NULL, '2024-01-23 09:49:07', NULL),
	(9, NULL, NULL, '003788', NULL, NULL, 'ธเนศร์  เกตุเกล้า', 'THANED  KETKOA', 'G000', NULL, 'General Office', 'G200', NULL, 'Human Resources & Adminstration', 'G2GA', NULL, 'General Affairs', '513', 'Team Leader', 'L700', 'Below Section Head (TH)', NULL, NULL, NULL, '2005-08-24 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Passed', NULL, NULL, NULL, NULL, NULL, NULL, '2024-01-23 09:49:07', NULL),
	(10, NULL, NULL, '010618', NULL, NULL, 'อรุณ  มงคลทิพย์', 'AROON  MONGKOLTHIP', 'G000', NULL, 'General Office', 'G200', NULL, 'Human Resources & Adminstration', 'G2GA', NULL, 'General Affairs', '429', 'Driver', 'L700', 'Below Section Head (TH)', NULL, NULL, NULL, '2010-03-15 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Passed', NULL, NULL, NULL, NULL, NULL, NULL, '2024-01-23 09:49:07', NULL),
	(11, NULL, NULL, '011298', NULL, NULL, 'เรืองสุข  เท่งเจียว', 'RUENGSUK  TENGJIAW', 'G000', NULL, 'General Office', 'G200', NULL, 'Human Resources & Adminstration', 'G2GA', NULL, 'General Affairs', '429', 'Driver', 'L700', 'Below Section Head (TH)', NULL, NULL, NULL, '2010-06-03 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Passed', NULL, NULL, NULL, NULL, NULL, NULL, '2024-01-23 09:49:08', NULL),
	(12, NULL, NULL, '018478', NULL, NULL, 'ศิริพร  ศิลมงคล', 'SIRIPORN  SILMONGKOL', 'G000', NULL, 'General Office', 'G200', NULL, 'Human Resources & Adminstration', 'G2GA', NULL, 'General Affairs', '428', 'Receptionist', 'L700', 'Below Section Head (TH)', NULL, NULL, NULL, '2013-12-07 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Passed', NULL, NULL, NULL, NULL, NULL, NULL, '2024-01-23 09:49:08', NULL),
	(13, NULL, NULL, '019983', NULL, NULL, 'พิมพ์วิภา  เหลืองอ่อน', 'PIMWIPA  LUEANGON', 'G000', NULL, 'General Office', 'G200', NULL, 'Human Resources & Adminstration', 'G2GA', NULL, 'General Affairs', '406', 'Officer', 'L700', 'Below Section Head (TH)', NULL, NULL, NULL, '2022-10-24 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Passed', NULL, NULL, NULL, NULL, NULL, NULL, '2024-01-23 09:49:08', NULL),
	(14, NULL, NULL, '017457', 'นาย/Mr.', 'นาย', 'วัธนพล  พงษ์อักษร', 'WHATTHANAPON  PHONGAKSON', 'G000', NULL, 'General Office', 'G200', NULL, 'Human Resources & Adminstration', 'G2OD', NULL, 'Organization Development', '301', 'Supervisor', 'L700', 'Below Section Head (TH)', NULL, NULL, NULL, '2013-04-26 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Passed', NULL, NULL, NULL, NULL, NULL, '13', '2024-01-23 09:49:08', '2024-01-23 09:49:22'),
	(15, NULL, NULL, '019807', NULL, NULL, 'พิมพร  ส้มจีน', 'PIMPORN  SOMJEEN', 'G000', NULL, 'General Office', 'G200', NULL, 'Human Resources & Adminstration', 'G2OD', NULL, 'Organization Development', '406', 'Officer', 'L700', 'Below Section Head (TH)', NULL, NULL, NULL, '2021-06-07 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Passed', NULL, NULL, NULL, NULL, NULL, NULL, '2024-01-23 09:49:09', NULL),
	(16, NULL, NULL, '000213', 'นาง/Mrs.', 'นาง', 'สิรัชชา  วุฒิพิทักษ์', 'SIRACHCHA  WUTTHIPHITHAK', 'G000', NULL, 'General Office', 'G200', NULL, 'Human Resources & Adminstration', 'G2PS', NULL, 'Personnel & Salary Admin', '301', 'Supervisor', 'L700', 'Below Section Head (TH)', NULL, NULL, NULL, '1992-10-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Passed', NULL, NULL, NULL, NULL, NULL, '13', '2024-01-23 09:49:09', '2024-01-23 09:49:23'),
	(17, NULL, NULL, '018835', NULL, NULL, 'จีรนันท์  โมลี', 'JEERANAN  MOLEE', 'G000', NULL, 'General Office', 'G200', NULL, 'Human Resources & Adminstration', 'G2PS', NULL, 'Personnel & Salary Admin', '424', 'Senior Clerk', 'L700', 'Below Section Head (TH)', NULL, NULL, NULL, '2015-05-04 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Passed', NULL, NULL, NULL, NULL, NULL, NULL, '2024-01-23 09:49:09', NULL),
	(18, NULL, NULL, '018836', NULL, NULL, 'รัตญา  แก้วบุญเรือง', 'RATTAYA  KAEOBUNRUEANG', 'G000', NULL, 'General Office', 'G200', NULL, 'Human Resources & Adminstration', 'G2PS', NULL, 'Personnel & Salary Admin', '424', 'Senior Clerk', 'L700', 'Below Section Head (TH)', NULL, NULL, NULL, '2015-05-04 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Passed', NULL, NULL, NULL, NULL, NULL, NULL, '2024-01-23 09:49:10', NULL),
	(19, NULL, NULL, '019630', NULL, NULL, 'อชิรญา  เนาวรัตน์กิตติกุล', 'ACHIRAYA  NAOWARATKITTIKUL', 'G000', NULL, 'General Office', 'G200', NULL, 'Human Resources & Adminstration', 'G2PS', NULL, 'Personnel & Salary Admin', '302', 'Asst Supervisor', 'L700', 'Below Section Head (TH)', NULL, NULL, NULL, '2019-03-11 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Passed', NULL, NULL, NULL, NULL, NULL, NULL, '2024-01-23 09:49:10', NULL),
	(20, NULL, NULL, '019820', NULL, NULL, 'พรศักดิ์  พันธุ์จบสิงห์', 'PORNSAK  PANJOBSING', 'G000', NULL, 'General Office', 'G200', NULL, 'Human Resources & Adminstration', 'G2PS', NULL, 'Personnel & Salary Admin', '406', 'Officer', 'L700', 'Below Section Head (TH)', NULL, NULL, NULL, '2021-08-16 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Passed', NULL, NULL, NULL, NULL, NULL, NULL, '2024-01-23 09:49:10', NULL),
	(21, NULL, NULL, '000435', NULL, NULL, 'อารีย์รัตน์  ศรีประยูร', 'AREERAT  SRIPRAYOON', 'G000', NULL, 'General Office', 'G200', NULL, 'Human Resources & Adminstration', 'G2RM', NULL, 'Recruitment', '405', 'Senior Officer', 'L700', 'Below Section Head (TH)', NULL, NULL, NULL, '1996-05-13 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Passed', NULL, NULL, NULL, NULL, NULL, NULL, '2024-01-23 09:49:11', NULL),
	(22, NULL, NULL, '019834', NULL, NULL, 'ชญานิน  เนตรภักดี', 'CHAYANIN  NETPHAKDEE', 'G000', NULL, 'General Office', 'G200', NULL, 'Human Resources & Adminstration', 'G2RM', NULL, 'Recruitment', '405', 'Senior Officer', 'L700', 'Below Section Head (TH)', NULL, NULL, NULL, '2021-11-29 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Passed', NULL, NULL, NULL, NULL, NULL, NULL, '2024-01-23 09:49:11', NULL),
	(23, NULL, 14, '019492', 'นางสาว/Ms.', 'นางสาว', 'พิมพ์ณดา  จรูญโภคทรัพย์', 'PIMNADA JAROONPOKKASUB  ', 'G000', NULL, 'General Office', 'G200', NULL, 'Human Resources & Adminstration', 'G2PS', NULL, 'Personnel & Salary Admin', '105', 'Manager', 'L400', 'Manager (TH)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-01-23 09:49:22', NULL),
	(24, NULL, 13, '000060', 'นาง/Mrs.', 'นาง', 'วรรณกร  โชคชลวัฒน์', 'WANNAKORN  CHOKCHONLAWAT', 'G000', NULL, 'General Office', 'G200', NULL, 'Human Resources & Adminstration', 'G2PS', NULL, 'Personnel & Salary Admin', '106', 'Asst. Manager', 'L500', 'AM (TH)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-01-23 09:49:22', NULL);

CREATE TABLE IF NOT EXISTS `tb_employee_attendance_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_file` int(11) DEFAULT NULL,
  `rec_year` varchar(255) DEFAULT NULL,
  `employee_no` varchar(6) DEFAULT NULL,
  `service_days` varchar(255) DEFAULT NULL,
  `attendance_sl` float(10,2) NOT NULL DEFAULT 0.00,
  `attendance_pl` float(10,2) NOT NULL DEFAULT 0.00,
  `attendance_late` float(10,2) NOT NULL DEFAULT 0.00,
  `attendance_abs` float(10,2) NOT NULL DEFAULT 0.00,
  `attendance_abt` float(10,2) NOT NULL DEFAULT 0.00,
  `attendance_sus` float(10,2) NOT NULL DEFAULT 0.00,
  `attendance_wwar` float(10,2) NOT NULL DEFAULT 0.00,
  `attendance_vwar` float(10,2) NOT NULL DEFAULT 0.00,
  `form_import` varchar(255) DEFAULT NULL,
  `group_form_id` int(11) DEFAULT NULL,
  `evaluator_no` varchar(255) DEFAULT NULL,
  `evaluator_name_th` varchar(255) DEFAULT NULL,
  `evaluator_name_en` varchar(255) DEFAULT NULL,
  `evaluation_criteria_score1` varchar(255) DEFAULT NULL,
  `evaluation_criteria_score2` varchar(255) DEFAULT NULL,
  `evaluation_criteria_score3` varchar(255) DEFAULT NULL,
  `evaluation_criteria_score4` varchar(255) DEFAULT NULL,
  `evaluation_criteria_score5` varchar(255) DEFAULT NULL,
  `evaluation_criteria_score6` varchar(255) DEFAULT NULL,
  `evaluation_criteria_score7` varchar(255) DEFAULT NULL,
  `evaluation_criteria_score8` varchar(255) DEFAULT NULL,
  `evaluation_criteria_score9` varchar(255) DEFAULT NULL,
  `evaluation_criteria_score10` varchar(255) DEFAULT NULL,
  `attendance_score` varchar(255) DEFAULT NULL,
  `total_score` varchar(255) DEFAULT NULL,
  `pa_grade` varchar(255) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `created_by` int(11) NOT NULL DEFAULT 0,
  `updated_by` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_no` (`employee_no`),
  KEY `id_file` (`id_file`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*!40000 ALTER TABLE `tb_employee_attendance_log` DISABLE KEYS */;
INSERT INTO `tb_employee_attendance_log` (`id`, `id_file`, `rec_year`, `employee_no`, `service_days`, `attendance_sl`, `attendance_pl`, `attendance_late`, `attendance_abs`, `attendance_abt`, `attendance_sus`, `attendance_wwar`, `attendance_vwar`, `form_import`, `group_form_id`, `evaluator_no`, `evaluator_name_th`, `evaluator_name_en`, `evaluation_criteria_score1`, `evaluation_criteria_score2`, `evaluation_criteria_score3`, `evaluation_criteria_score4`, `evaluation_criteria_score5`, `evaluation_criteria_score6`, `evaluation_criteria_score7`, `evaluation_criteria_score8`, `evaluation_criteria_score9`, `evaluation_criteria_score10`, `attendance_score`, `total_score`, `pa_grade`, `remark`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
	(1, 1, '2023', '001618', '7240', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 0, '2024-01-23 09:49:05', NULL),
	(2, 1, '2023', '015344', '3864', 9.50, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 0, '2024-01-23 09:49:05', NULL),
	(3, 1, '2023', '014276', '4037', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 0, '2024-01-23 09:49:05', NULL),
	(4, 1, '2023', '019832', '448', 1.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 0, '2024-01-23 09:49:06', NULL),
	(5, 1, '2023', '018264', '3449', 19.25, 2.00, 11.33, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 0, '2024-01-23 09:49:06', NULL),
	(6, 1, '2023', '019847', '337', 6.81, 0.25, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 0, '2024-01-23 09:49:06', NULL),
	(7, 1, '2023', '000255', '10880', 5.38, 0.00, 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 0, '2024-01-23 09:49:07', NULL),
	(8, 1, '2023', '002131', '6917', 17.88, 1.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 0, '2024-01-23 09:49:07', NULL),
	(9, 1, '2023', '003788', '6370', 18.63, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 0, '2024-01-23 09:49:07', NULL),
	(10, 1, '2023', '010618', '4706', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 0, '2024-01-23 09:49:07', NULL),
	(11, 1, '2023', '011298', '4626', 17.13, 0.00, 0.00, 0.50, 1.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 0, '2024-01-23 09:49:08', NULL),
	(12, 1, '2023', '018478', '3343', 14.13, 0.13, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 0, '2024-01-23 09:49:08', NULL),
	(13, 1, '2023', '019983', '100', 4.50, 0.00, 0.33, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 0, '2024-01-23 09:49:08', NULL),
	(14, 1, '2023', '017457', '3568', 2.43, 15.50, 33.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 0, '2024-01-23 09:49:08', NULL),
	(15, 1, '2023', '019807', '604', 21.68, 0.00, 0.33, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 0, '2024-01-23 09:49:09', NULL),
	(16, 1, '2023', '000213', '11080', 18.06, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 0, '2024-01-23 09:49:09', NULL),
	(17, 1, '2023', '018835', '2830', 21.50, 0.50, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 0, '2024-01-23 09:49:09', NULL),
	(18, 1, '2023', '018836', '2830', 11.75, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 0, '2024-01-23 09:49:09', NULL),
	(19, 1, '2023', '019630', '1423', 16.75, 0.38, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 0, '2024-01-23 09:49:10', NULL),
	(20, 1, '2023', '019820', '534', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 0, '2024-01-23 09:49:10', NULL),
	(21, 1, '2023', '000435', '9760', 28.37, 0.25, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 0, '2024-01-23 09:49:11', NULL),
	(22, 1, '2023', '019834', '429', 7.37, 0.81, 0.33, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 0, '2024-01-23 09:49:11', NULL);
/*!40000 ALTER TABLE `tb_employee_attendance_log` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `tb_employee_evaluator` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `import_id` int(11) DEFAULT NULL,
  `rec_year` varchar(255) DEFAULT NULL,
  `employee_no` varchar(6) DEFAULT NULL,
  `evaluator_active` int(2) NOT NULL DEFAULT 0,
  `employee_name_th` varchar(255) DEFAULT NULL,
  `employee_name_en` varchar(255) DEFAULT NULL,
  `approve_pa_score_by` varchar(6) DEFAULT NULL,
  `approve_name_en` varchar(255) DEFAULT NULL,
  `created_by` int(11) NOT NULL DEFAULT 0,
  `updated_by` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `import_id` (`import_id`),
  KEY `employee_no` (`employee_no`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

INSERT INTO `tb_employee_evaluator` (`id`, `import_id`, `rec_year`, `employee_no`, `evaluator_active`, `employee_name_th`, `employee_name_en`, `approve_pa_score_by`, `approve_name_en`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
	(1, 1, '2023', '019492', 1, 'พิมพ์ณดา  จรูญโภคทรัพย์', 'PIMNADA JAROONPOKKASUB  ', '019492', NULL, 13, 0, '2024-01-23 09:49:22', NULL),
	(2, 1, '2023', '000060', 1, 'วรรณกร  โชคชลวัฒน์', 'WANNAKORN  CHOKCHONLAWAT', '019492', NULL, 13, 0, '2024-01-23 09:49:22', NULL),
	(3, 1, '2023', '000255', 1, 'วันเพ็ญ  ทาเอื้อ', 'WANPEN  TAAER', '019492', NULL, 13, 0, '2024-01-23 09:49:22', NULL),
	(4, 1, '2023', '017457', 1, 'วัธนพล  พงษ์อักษร', 'WHATTHANAPON  PHONGAKSON', '019492', NULL, 13, 0, '2024-01-23 09:49:22', NULL),
	(5, 1, '2023', '000213', 1, 'สิรัชชา  วุฒิพิทักษ์', 'SIRACHCHA  WUTTHIPHITHAK', '019492', NULL, 13, 0, '2024-01-23 09:49:23', NULL),
	(6, NULL, '2023', '000435', 0, 'อารีย์รัตน์  ศรีประยูร', 'AREERAT  SRIPRAYOON', NULL, NULL, 6, 0, '2024-01-24 07:31:47', NULL);

CREATE TABLE IF NOT EXISTS `tb_employee_evaluator_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_file` int(11) DEFAULT NULL,
  `rec_year` varchar(255) DEFAULT NULL,
  `employee_no` varchar(6) DEFAULT NULL,
  `approve_pa_score_by` varchar(6) DEFAULT NULL,
  `created_by` int(11) NOT NULL DEFAULT 0,
  `updated_by` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_file` (`id_file`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*!40000 ALTER TABLE `tb_employee_evaluator_log` DISABLE KEYS */;
INSERT INTO `tb_employee_evaluator_log` (`id`, `id_file`, `rec_year`, `employee_no`, `approve_pa_score_by`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
	(1, 1, '2023', '019492', '019492', 13, 0, '2024-01-23 09:49:21', NULL),
	(2, 1, '2023', '000060', '019492', 13, 0, '2024-01-23 09:49:22', NULL),
	(3, 1, '2023', '000255', '019492', 13, 0, '2024-01-23 09:49:22', NULL),
	(4, 1, '2023', '017457', '019492', 13, 0, '2024-01-23 09:49:22', NULL),
	(5, 1, '2023', '000213', '019492', 13, 0, '2024-01-23 09:49:22', NULL);
/*!40000 ALTER TABLE `tb_employee_evaluator_log` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `tb_employee_final_score` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `import_id` int(11) DEFAULT NULL,
  `import_score_id` int(11) DEFAULT NULL,
  `rec_year` varchar(255) DEFAULT NULL,
  `employee_no` varchar(6) DEFAULT NULL,
  `status_assessed` int(2) NOT NULL DEFAULT 0,
  `service_days` varchar(255) DEFAULT NULL,
  `attendance_sl` float(10,2) NOT NULL DEFAULT 0.00,
  `attendance_pl` float(10,2) NOT NULL DEFAULT 0.00,
  `attendance_late` float(10,2) NOT NULL DEFAULT 0.00,
  `attendance_abs` float(10,2) NOT NULL DEFAULT 0.00,
  `attendance_abt` float(10,2) NOT NULL DEFAULT 0.00,
  `attendance_sus` float(10,2) NOT NULL DEFAULT 0.00,
  `attendance_wwar` float(10,2) NOT NULL DEFAULT 0.00,
  `attendance_vwar` float(10,2) NOT NULL DEFAULT 0.00,
  `form_import` varchar(255) DEFAULT NULL,
  `group_form_id` int(11) DEFAULT NULL,
  `evaluator_no` varchar(255) DEFAULT NULL,
  `evaluator_active` int(2) NOT NULL DEFAULT 0,
  `evaluator_name_th` varchar(255) DEFAULT NULL,
  `evaluator_name_en` varchar(255) DEFAULT NULL,
  `evaluation_criteria_id` varchar(255) DEFAULT NULL,
  `criteria_score_old` varchar(255) DEFAULT NULL,
  `criteria_score_new` varchar(255) DEFAULT NULL,
  `evaluation_criteria_score1` varchar(255) DEFAULT NULL,
  `evaluation_criteria_score2` varchar(255) DEFAULT NULL,
  `evaluation_criteria_score3` varchar(255) DEFAULT NULL,
  `evaluation_criteria_score4` varchar(255) DEFAULT NULL,
  `evaluation_criteria_score5` varchar(255) DEFAULT NULL,
  `evaluation_criteria_score6` varchar(255) DEFAULT NULL,
  `evaluation_criteria_score7` varchar(255) DEFAULT NULL,
  `evaluation_criteria_score8` varchar(255) DEFAULT NULL,
  `evaluation_criteria_score9` varchar(255) DEFAULT NULL,
  `evaluation_criteria_score10` varchar(255) DEFAULT NULL,
  `evaluation_criteria_score_old1` varchar(255) DEFAULT NULL,
  `evaluation_criteria_score_old2` varchar(255) DEFAULT NULL,
  `evaluation_criteria_score_old3` varchar(255) DEFAULT NULL,
  `evaluation_criteria_score_old4` varchar(255) DEFAULT NULL,
  `evaluation_criteria_score_old5` varchar(255) DEFAULT NULL,
  `evaluation_criteria_score_old6` varchar(255) DEFAULT NULL,
  `evaluation_criteria_score_old7` varchar(255) DEFAULT NULL,
  `evaluation_criteria_score_old8` varchar(255) DEFAULT NULL,
  `evaluation_criteria_score_old9` varchar(255) DEFAULT NULL,
  `evaluation_criteria_score_old10` varchar(255) DEFAULT NULL,
  `compliance_score` float(10,2) DEFAULT 0.00,
  `attendance_score` float(10,2) DEFAULT 0.00,
  `total_score` float(10,2) DEFAULT 0.00,
  `total_score_old` float(10,2) DEFAULT 0.00,
  `pa_grade` varchar(255) DEFAULT NULL,
  `adjust_grade` varchar(255) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `status_evaluation` int(4) NOT NULL DEFAULT 0,
  `salary_type` varchar(255) DEFAULT NULL,
  `salary_old` float(10,2) DEFAULT 0.00,
  `l800avg_wage` float(10,2) DEFAULT 0.00,
  `bsalary_wage` float(10,2) DEFAULT 0.00,
  `salary_month_old` float(10,2) DEFAULT 0.00,
  `company_suggested_per` float(10,2) DEFAULT 0.00,
  `company_suggestged_amount` float(10,2) DEFAULT 0.00,
  `company_suggestged_new_basic` float(10,2) DEFAULT 0.00,
  `grade_proposed_old` varchar(255) DEFAULT NULL,
  `grade_proposed` varchar(255) DEFAULT NULL,
  `percent_proposed_old` float(10,2) DEFAULT 0.00,
  `percent_proposed` float(10,2) DEFAULT 0.00,
  `amount_proposed` float(10,2) DEFAULT 0.00,
  `salary_new` float(10,2) DEFAULT 0.00,
  `salary_month_new` float(10,2) DEFAULT 0.00,
  `final_by_md_gm_amount` float(10,2) DEFAULT 0.00,
  `edit_by_dmgm` int(2) NOT NULL DEFAULT 0,
  `status_salary` int(11) NOT NULL DEFAULT 0,
  `status_pa` int(11) NOT NULL DEFAULT 0,
  `approve_date` date DEFAULT NULL,
  `remark_grade` varchar(255) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `created_by` int(11) NOT NULL DEFAULT 0,
  `updated_by` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `import_id` (`import_id`),
  KEY `employee_no` (`employee_no`),
  KEY `group_form_id` (`group_form_id`),
  KEY `evaluator_no` (`evaluator_no`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

INSERT INTO `tb_employee_final_score` (`id`, `import_id`, `import_score_id`, `rec_year`, `employee_no`, `status_assessed`, `service_days`, `attendance_sl`, `attendance_pl`, `attendance_late`, `attendance_abs`, `attendance_abt`, `attendance_sus`, `attendance_wwar`, `attendance_vwar`, `form_import`, `group_form_id`, `evaluator_no`, `evaluator_active`, `evaluator_name_th`, `evaluator_name_en`, `evaluation_criteria_id`, `criteria_score_old`, `criteria_score_new`, `evaluation_criteria_score1`, `evaluation_criteria_score2`, `evaluation_criteria_score3`, `evaluation_criteria_score4`, `evaluation_criteria_score5`, `evaluation_criteria_score6`, `evaluation_criteria_score7`, `evaluation_criteria_score8`, `evaluation_criteria_score9`, `evaluation_criteria_score10`, `evaluation_criteria_score_old1`, `evaluation_criteria_score_old2`, `evaluation_criteria_score_old3`, `evaluation_criteria_score_old4`, `evaluation_criteria_score_old5`, `evaluation_criteria_score_old6`, `evaluation_criteria_score_old7`, `evaluation_criteria_score_old8`, `evaluation_criteria_score_old9`, `evaluation_criteria_score_old10`, `compliance_score`, `attendance_score`, `total_score`, `total_score_old`, `pa_grade`, `adjust_grade`, `remark`, `status_evaluation`, `salary_type`, `salary_old`, `l800avg_wage`, `bsalary_wage`, `salary_month_old`, `company_suggested_per`, `company_suggestged_amount`, `company_suggestged_new_basic`, `grade_proposed_old`, `grade_proposed`, `percent_proposed_old`, `percent_proposed`, `amount_proposed`, `salary_new`, `salary_month_new`, `final_by_md_gm_amount`, `edit_by_dmgm`, `status_salary`, `status_pa`, `approve_date`, `remark_grade`, `comment`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
	(1, 1, NULL, '2023', '001618', 0, '7240', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'F1', 1, '019492', 0, 'พิมพ์ณดา  จรูญโภคทรัพย์', 'PIMNADA JAROONPOKKASUB  ', '1,2,4,6,13,7,8', ',,,,,,,', ',,,,,,,', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, 0.00, 'B', 'B', NULL, 0, 'Daily', 500.00, 0.00, 500.00, 13000.00, 4.50, 446.30, 946.00, 'D', 'CD', 4.50, 10.00, 50.00, 550.00, 14300.00, 14300.00, 0, 1, 14, '2024-01-24', NULL, NULL, 13, 0, '2024-01-23 09:49:05', '2024-01-23 09:49:05'),
	(2, 1, NULL, '2023', '015344', 0, '3864', 9.50, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'F3', 3, '019492', 0, 'พิมพ์ณดา  จรูญโภคทรัพย์', 'PIMNADA JAROONPOKKASUB  ', '1,2,4,5,6,7,8', '5,5,5,5,,5,5,', '5,5,5,5,5,5,5,', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 9.50, 56.00, 0.00, 'B', 'B', NULL, 3, 'Daily', 419.00, 0.00, 419.00, 10894.00, 4.50, 199.60, 619.00, 'D', 'D', 0.00, 1.00, 5.00, 505.00, 13130.00, 13130.00, 0, 1, 8, NULL, NULL, NULL, 13, 0, '2024-01-23 09:49:05', '2024-01-23 09:49:05'),
	(3, 1, NULL, '2023', '014276', 0, '4037', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'F3', 3, '019492', 0, 'พิมพ์ณดา  จรูญโภคทรัพย์', 'PIMNADA JAROONPOKKASUB  ', '1,2,4,5,6,7,8', '6,6,6,6,6,6,,', '6,6,6,6,6,6,6,', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 68.00, 0.00, 'C', 'C', NULL, 3, 'Daily', 354.00, 345.00, 345.00, 8970.00, 3.00, 114.47, 468.00, 'C', 'C', 0.00, 3.00, 10.35, 364.35, 9473.10, 9473.10, 0, 1, 8, NULL, NULL, NULL, 13, 0, '2024-01-23 09:49:06', '2024-01-23 09:49:06'),
	(4, 1, NULL, '2023', '019832', 0, '448', 1.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'F4', 4, '019492', 0, 'พิมพ์ณดา  จรูญโภคทรัพย์', 'PIMNADA JAROONPOKKASUB  ', '1,2,3,4,5,6,7,8', '4,4,4,4,4,4,4,,', '4,4,4,4,4,4,4,4,', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 1.00, 52.00, 0.00, 'A', 'A', NULL, 3, 'Daily', 515.00, 0.00, 515.00, 13390.00, 6.00, 37.93, 553.00, 'E', 'E', 0.00, 0.25, 1.25, 501.25, 13032.50, 13032.50, 0, 1, 8, NULL, NULL, NULL, 13, 0, '2024-01-23 09:49:06', '2024-01-23 09:49:06'),
	(5, 1, NULL, '2023', '018264', 0, '3449', 19.25, 2.00, 11.33, 0.00, 0.00, 0.00, 0.00, 0.00, 'F3', 3, '019492', 0, 'พิมพ์ณดา  จรูญโภคทรัพย์', 'PIMNADA JAROONPOKKASUB  ', '1,2,4,5,6,7,8', '10,10,10,10,10,10,,', '10,10,10,10,10,10,10,', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 32.58, 91.00, 0.00, 'B', 'B', NULL, 3, 'Monthly', 10000.00, 0.00, 10000.00, 10000.00, 4.50, 450.00, 10450.00, NULL, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 14, '2024-01-24', NULL, NULL, 13, 0, '2024-01-23 09:49:06', '2024-01-23 09:49:06'),
	(6, 1, NULL, '2023', '019847', 0, '337', 6.81, 0.25, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'F4', 4, '019492', 0, 'พิมพ์ณดา  จรูญโภคทรัพย์', 'PIMNADA JAROONPOKKASUB  ', '1,2,3,4,5,6,7,8', '8,8,8,8,7,7,7,,', '8,8,8,8,7,7,7,6,', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 7.06, 76.00, 0.00, 'C', 'C', NULL, 3, 'Monthly', 10000.00, 0.00, 10000.00, 10000.00, 3.00, 300.00, 10300.00, 'C', 'C', 0.00, 3.00, 300.00, 10300.00, 10300.00, 10300.00, 0, 1, 14, '2024-01-24', NULL, NULL, 13, 0, '2024-01-23 09:49:06', '2024-01-23 09:49:06'),
	(7, 1, NULL, '2023', '000255', 0, '10880', 5.38, 0.00, 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'F1', 1, '019492', 1, 'พิมพ์ณดา  จรูญโภคทรัพย์', 'PIMNADA JAROONPOKKASUB  ', '1,2,4,6,13,7,8', '10,10,10,10,10,10,,', '10,10,10,10,10,10,10,', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 7.38, 94.00, 0.00, 'A', 'A', NULL, 3, 'Monthly', 10000.00, 0.00, 10000.00, 10000.00, 6.00, 600.00, 10600.00, 'A', 'A', 0.00, 6.00, 600.00, 10600.00, 10600.00, 10600.00, 0, 1, 14, '2024-01-24', NULL, NULL, 13, 0, '2024-01-23 09:49:07', '2024-01-23 09:49:07'),
	(8, 1, NULL, '2023', '002131', 0, '6917', 17.88, 1.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'F2', 2, '019492', 0, 'พิมพ์ณดา  จรูญโภคทรัพย์', 'PIMNADA JAROONPOKKASUB  ', '1,2,3,4,5,6,13,7,8', '9,9,10,9,9,9,9,9,9,', '9,9,10,9,9,9,9,9,10,', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 18.88, 85.00, 0.00, 'B', 'B', NULL, 3, 'Monthly', 10000.00, 0.00, 10000.00, 10000.00, 4.50, 450.00, 10450.00, 'B', 'B', 0.00, 4.50, 450.00, 10450.00, 10450.00, 10450.00, 0, 1, 14, '2024-01-24', NULL, NULL, 13, 0, '2024-01-23 09:49:07', '2024-01-23 09:49:07'),
	(9, 1, NULL, '2023', '003788', 0, '6370', 18.63, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'F2', 2, '019492', 0, 'พิมพ์ณดา  จรูญโภคทรัพย์', 'PIMNADA JAROONPOKKASUB  ', '1,2,3,4,5,6,13,7,8', '7,7,7,7,7,7,7,5,4,', '7,7,7,7,7,7,7,5,5,', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 18.63, 63.00, 0.00, 'C', 'C', NULL, 3, 'Monthly', 10000.00, 0.00, 10000.00, 10000.00, 3.00, 300.00, 10300.00, 'C', 'C', 0.00, 3.00, 300.00, 10300.00, 10300.00, 10300.00, 0, 1, 14, '2024-01-24', NULL, NULL, 13, 0, '2024-01-23 09:49:07', '2024-01-23 09:49:07'),
	(10, 1, NULL, '2023', '010618', 0, '4706', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'F2', 2, '019492', 0, 'พิมพ์ณดา  จรูญโภคทรัพย์', 'PIMNADA JAROONPOKKASUB  ', '1,2,3,4,5,6,13,7,8', '8,8,8,8,8,8,8,8,,', '8,8,8,8,8,8,8,8,8,', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 6.00, 82.00, 0.00, 'C', 'C', NULL, 3, 'Monthly', 10000.00, 0.00, 10000.00, 10000.00, 3.00, 300.00, 10300.00, 'C', 'C', 0.00, 3.00, 300.00, 10300.00, 10300.00, 10300.00, 0, 1, 14, '2024-01-24', NULL, NULL, 13, 0, '2024-01-23 09:49:07', '2024-01-23 09:49:07'),
	(11, 1, NULL, '2023', '011298', 0, '4626', 17.13, 0.00, 0.00, 0.50, 1.00, 0.00, 0.00, 0.00, 'F2', 2, '019492', 0, 'พิมพ์ณดา  จรูญโภคทรัพย์', 'PIMNADA JAROONPOKKASUB  ', '1,2,3,4,5,6,13,7,8', '9,9,9,9,9,9,9,9,,', '9,9,9,9,9,9,9,9,9,', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1.00, 17.63, 84.00, 0.00, 'B', 'B', NULL, 3, 'Monthly', 10000.00, 0.00, 10000.00, 10000.00, 4.50, 450.00, 10450.00, 'B', 'B', 0.00, 4.50, 450.00, 10450.00, 10450.00, 10450.00, 0, 1, 14, '2024-01-24', NULL, NULL, 13, 0, '2024-01-23 09:49:08', '2024-01-23 09:49:08'),
	(12, 1, NULL, '2023', '018478', 0, '3343', 14.13, 0.13, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'F3', 3, '019492', 0, 'พิมพ์ณดา  จรูญโภคทรัพย์', 'PIMNADA JAROONPOKKASUB  ', '1,2,4,5,6,7,8', '7,7,7,7,7,7,,', '7,7,7,7,7,7,7,', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 14.26, 69.00, 0.00, 'C', 'C', NULL, 3, 'Monthly', 10000.00, 0.00, 10000.00, 10000.00, 3.00, 300.00, 10300.00, 'C', 'C', 0.00, 3.00, 300.00, 10300.00, 10300.00, 10300.00, 0, 1, 14, '2024-01-24', NULL, NULL, 13, 0, '2024-01-23 09:49:08', '2024-01-23 09:49:08'),
	(13, 1, NULL, '2023', '019983', 0, '100', 4.50, 0.00, 0.33, 0.00, 0.00, 0.00, 0.00, 0.00, 'F4', 4, '019492', 0, 'พิมพ์ณดา  จรูญโภคทรัพย์', 'PIMNADA JAROONPOKKASUB  ', '1,2,3,4,5,6,7,8', '4,4,4,4,4,4,4,,', '4,4,4,4,4,4,4,4,', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 4.83, 50.00, 0.00, 'E', 'E', NULL, 3, 'Monthly', 10000.00, 0.00, 10000.00, 10000.00, 0.25, 25.00, 10025.00, 'E', 'E', 0.00, 0.25, 25.00, 10025.00, 10025.00, 10025.00, 0, 1, 14, '2024-01-24', NULL, NULL, 13, 0, '2024-01-23 09:49:08', '2024-01-23 09:49:08'),
	(14, 1, NULL, '2023', '017457', 0, '3568', 2.43, 15.50, 33.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'F3', 3, '019492', 1, 'พิมพ์ณดา  จรูญโภคทรัพย์', 'PIMNADA JAROONPOKKASUB  ', '1,2,4,5,6,7,8', '8,7,8,7,8,7,,', '8,7,8,7,8,7,8,', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 50.93, 71.00, 0.00, 'C', 'C', NULL, 3, 'Monthly', 10000.00, 0.00, 10000.00, 10000.00, 3.00, 300.00, 10300.00, 'C', 'C', 0.00, 3.00, 300.00, 10300.00, 10300.00, 10300.00, 0, 1, 14, '2024-01-24', NULL, NULL, 13, 0, '2024-01-23 09:49:09', '2024-01-23 09:49:09'),
	(15, 1, NULL, '2023', '019807', 0, '604', 21.68, 0.00, 0.33, 0.00, 0.00, 0.00, 0.00, 0.00, 'F4', 4, '019492', 0, 'พิมพ์ณดา  จรูญโภคทรัพย์', 'PIMNADA JAROONPOKKASUB  ', '1,2,3,4,5,6,7,8', '9,9,9,8,8,8,7,,', '9,9,9,8,8,8,7,7,', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 22.01, 76.00, 0.00, 'C', 'C', NULL, 3, 'Monthly', 10000.00, 0.00, 10000.00, 10000.00, 3.00, 300.00, 10300.00, 'C', 'C', 0.00, 3.00, 300.00, 10300.00, 10300.00, 10300.00, 0, 1, 14, '2024-01-24', NULL, NULL, 13, 0, '2024-01-23 09:49:09', '2024-01-23 09:49:09'),
	(16, 1, NULL, '2023', '000213', 0, '11080', 18.06, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'F1', 1, '019492', 1, 'พิมพ์ณดา  จรูญโภคทรัพย์', 'PIMNADA JAROONPOKKASUB  ', '1,2,4,6,13,7,8', '8,8,8,8,6,6,,', '8,8,8,8,6,6,5,', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 18.06, 62.50, 0.00, 'D', 'D', NULL, 3, 'Monthly', 10000.00, 0.00, 10000.00, 10000.00, 1.00, 100.00, 10100.00, 'D', 'D', 0.00, 1.00, 100.00, 10100.00, 10100.00, 10100.00, 0, 1, 14, '2024-01-24', NULL, NULL, 13, 0, '2024-01-23 09:49:09', '2024-01-23 09:49:09'),
	(17, 1, NULL, '2023', '018835', 0, '2830', 21.50, 0.50, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'F3', 3, '019492', 0, 'พิมพ์ณดา  จรูญโภคทรัพย์', 'PIMNADA JAROONPOKKASUB  ', '1,2,4,5,6,7,8', '8,6,6,1,7,7,7,', '8,6,6,8,7,7,7,', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 22.00, 66.00, 0.00, 'C', 'C', NULL, 3, 'Monthly', 10000.00, 0.00, 10000.00, 10000.00, 3.00, 300.00, 10300.00, 'C', 'C', 0.00, 3.00, 300.00, 10300.00, 10300.00, 10300.00, 0, 1, 14, '2024-01-24', NULL, NULL, 13, 0, '2024-01-23 09:49:09', '2024-01-23 09:49:09'),
	(18, 1, NULL, '2023', '018836', 0, '2830', 11.75, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'F3', 3, '019492', 0, 'พิมพ์ณดา  จรูญโภคทรัพย์', 'PIMNADA JAROONPOKKASUB  ', '1,2,4,5,6,7,8', '10,10,10,10,10,10,,', '10,10,10,10,10,10,9,', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 11.75, 94.00, 0.00, 'B', 'A', NULL, 3, 'Monthly', 10000.00, 0.00, 10000.00, 10000.00, 6.00, 600.00, 10600.00, 'A', 'A', 0.00, 6.00, 600.00, 10600.00, 10600.00, 10600.00, 0, 1, 14, '2024-01-24', NULL, NULL, 13, 0, '2024-01-23 09:49:10', '2024-01-23 09:49:10'),
	(19, 1, NULL, '2023', '019630', 0, '1423', 16.75, 0.38, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'F3', 3, '019492', 0, 'พิมพ์ณดา  จรูญโภคทรัพย์', 'PIMNADA JAROONPOKKASUB  ', '1,2,4,5,6,7,8', '10,9,9,9,9,9,9,', '9,9,9,9,9,9,9,', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 17.13, 83.00, 0.00, 'B', 'B', NULL, 3, 'Monthly', 10000.00, 0.00, 10000.00, 10000.00, 4.50, 450.00, 10450.00, 'C', 'C', 0.00, 3.00, 300.00, 10300.00, 10300.00, 10300.00, 0, 1, 14, '2024-01-24', NULL, NULL, 13, 0, '2024-01-23 09:49:10', '2024-01-23 09:49:10'),
	(20, 1, NULL, '2023', '019820', 0, '534', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'F4', 4, '019492', 0, 'พิมพ์ณดา  จรูญโภคทรัพย์', 'PIMNADA JAROONPOKKASUB  ', '1,2,3,4,5,6,7,8', '8,8,8,8,7,7,7,,', '8,8,8,8,7,7,7,7,', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 80.00, 0.00, 'C', 'C', NULL, 3, 'Monthly', 10000.00, 0.00, 10000.00, 10000.00, 3.00, 300.00, 10300.00, 'C', 'C', 0.00, 3.00, 300.00, 10300.00, 10300.00, 10300.00, 0, 1, 14, '2024-01-24', NULL, NULL, 13, 0, '2024-01-23 09:49:10', '2024-01-23 09:49:10'),
	(21, 1, NULL, '2023', '000435', 0, '9760', 28.37, 0.25, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'F1', 1, '019492', 0, 'พิมพ์ณดา  จรูญโภคทรัพย์', 'PIMNADA JAROONPOKKASUB  ', '1,2,4,6,13,7,8', '8,8,8,8,8,8,,', '8,8,8,8,8,8,9,', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 28.62, 68.50, 0.00, 'C', 'C', NULL, 3, 'Monthly', 10000.00, 0.00, 10000.00, 10000.00, 3.00, 300.00, 10300.00, 'C', 'C', 0.00, 3.00, 300.00, 10300.00, 10300.00, 10300.00, 0, 1, 14, '2024-01-24', NULL, NULL, 13, 0, '2024-01-23 09:49:11', '2024-01-23 09:49:11'),
	(22, 1, NULL, '2023', '019834', 0, '429', 7.37, 0.81, 0.33, 0.00, 0.00, 0.00, 0.00, 0.00, 'F4', 4, '019492', 0, 'พิมพ์ณดา  จรูญโภคทรัพย์', 'PIMNADA JAROONPOKKASUB  ', '1,2,3,4,5,6,7,8', '8,8,7,6,5,4,4,,', '8,8,7,6,5,4,4,5,', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 8.51, 63.00, 0.00, 'D', 'D', NULL, 3, 'Monthly', 10000.00, 0.00, 10000.00, 10000.00, 1.00, 100.00, 10100.00, 'D', 'D', 0.00, 1.00, 100.00, 10100.00, 10100.00, 10100.00, 0, 1, 14, '2024-01-24', NULL, NULL, 13, 0, '2024-01-23 09:49:11', '2024-01-23 09:49:11');

CREATE TABLE IF NOT EXISTS `tb_employee_final_score_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_file` int(11) DEFAULT NULL,
  `rec_year` varchar(255) DEFAULT NULL,
  `employee_no` varchar(6) DEFAULT NULL,
  `service_days` varchar(255) DEFAULT NULL,
  `attendance_sl` float(10,2) NOT NULL DEFAULT 0.00,
  `attendance_pl` float(10,2) NOT NULL DEFAULT 0.00,
  `attendance_late` float(10,2) NOT NULL DEFAULT 0.00,
  `attendance_abs` float(10,2) NOT NULL DEFAULT 0.00,
  `attendance_abt` float(10,2) NOT NULL DEFAULT 0.00,
  `attendance_sus` float(10,2) NOT NULL DEFAULT 0.00,
  `attendance_wwar` float(10,2) NOT NULL DEFAULT 0.00,
  `attendance_vwar` float(10,2) NOT NULL DEFAULT 0.00,
  `form_import` varchar(255) DEFAULT NULL,
  `group_form_id` int(11) DEFAULT NULL,
  `evaluator_no` varchar(255) DEFAULT NULL,
  `evaluator_name_th` varchar(255) DEFAULT NULL,
  `evaluator_name_en` varchar(255) DEFAULT NULL,
  `evaluation_criteria_score1` varchar(255) DEFAULT NULL,
  `evaluation_criteria_score2` varchar(255) DEFAULT NULL,
  `evaluation_criteria_score3` varchar(255) DEFAULT NULL,
  `evaluation_criteria_score4` varchar(255) DEFAULT NULL,
  `evaluation_criteria_score5` varchar(255) DEFAULT NULL,
  `evaluation_criteria_score6` varchar(255) DEFAULT NULL,
  `evaluation_criteria_score7` varchar(255) DEFAULT NULL,
  `evaluation_criteria_score8` varchar(255) DEFAULT NULL,
  `evaluation_criteria_score9` varchar(255) DEFAULT NULL,
  `evaluation_criteria_score10` varchar(255) DEFAULT NULL,
  `attendance_score` varchar(255) DEFAULT NULL,
  `total_score` varchar(255) DEFAULT NULL,
  `pa_grade` varchar(255) DEFAULT NULL,
  `adjust_grade` varchar(255) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `created_by` int(11) NOT NULL DEFAULT 0,
  `updated_by` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_no` (`employee_no`),
  KEY `id_file` (`id_file`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*!40000 ALTER TABLE `tb_employee_final_score_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_employee_final_score_log` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `tb_employee_log` (
  `ID_EMPLOYEE` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ID_FILE` int(11) DEFAULT NULL,
  `ORISOFT_NO` varchar(100) DEFAULT NULL,
  `ENG_TITLE` varchar(100) DEFAULT NULL,
  `TH_TITLE` varchar(100) DEFAULT NULL,
  `EMPLOYEE_LOCAL_NAME` varchar(100) DEFAULT NULL,
  `EMPLOYEE_NAME` varchar(100) DEFAULT NULL,
  `GRADE_CODE` varchar(100) DEFAULT NULL,
  `DIVISION_CODE` varchar(100) DEFAULT NULL,
  `DEPARTMENT_CODE` varchar(100) DEFAULT NULL,
  `SECTION_CODE` varchar(100) DEFAULT NULL,
  `POSITION_DESCRIPTION` varchar(100) DEFAULT NULL,
  `SECTION_DESCRIPTION` varchar(100) DEFAULT NULL,
  `DEPARTMENT_DESCRIPTION` varchar(100) DEFAULT NULL,
  `DIVISION_DESCRIPTION` varchar(100) DEFAULT NULL,
  `GRADE_DESCRIPTION` varchar(100) DEFAULT NULL,
  `ID` varchar(100) DEFAULT NULL,
  `BIRTH_DATE` datetime DEFAULT NULL,
  `DATE_JOINED` date DEFAULT NULL,
  `EMPLOYEE_TYPE` varchar(100) DEFAULT NULL,
  `EMPLOYEE_TYPE_DESCRIPTION` varchar(100) DEFAULT NULL,
  `HOME_CONTACT1` varchar(100) DEFAULT NULL,
  `MAIL_ADDRESS1` text DEFAULT NULL,
  `POSITION_CODE` int(10) DEFAULT NULL,
  `DATE_RESIGNED` varchar(100) DEFAULT NULL,
  `DATE_RETIREMENT` varchar(100) DEFAULT NULL,
  `DATE_CONFIRMED` varchar(100) DEFAULT NULL,
  `EMPLOYEE_STATUS` varchar(100) DEFAULT NULL,
  `EMPLOYEE_STATUS_DESCRIPTION` varchar(100) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`ID_EMPLOYEE`),
  KEY `ORISOFT_NO` (`ORISOFT_NO`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*!40000 ALTER TABLE `tb_employee_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_employee_log` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `tb_employee_salary_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_file` int(11) DEFAULT NULL,
  `rec_year` varchar(255) DEFAULT NULL,
  `branch` varchar(255) DEFAULT NULL,
  `employee_no` varchar(6) DEFAULT NULL,
  `employee_name` varchar(255) DEFAULT NULL,
  `division_code` varchar(255) DEFAULT NULL,
  `department_code` varchar(255) DEFAULT NULL,
  `section_code` varchar(255) DEFAULT NULL,
  `grade_code` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `position_code` varchar(255) DEFAULT NULL,
  `position_description` varchar(255) DEFAULT NULL,
  `salary` varchar(255) DEFAULT NULL,
  `salary_month` varchar(255) DEFAULT NULL,
  `date_joined` varchar(255) DEFAULT NULL,
  `created_by` int(11) NOT NULL DEFAULT 0,
  `updated_by` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_no` (`employee_no`),
  KEY `id_file` (`id_file`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*!40000 ALTER TABLE `tb_employee_salary_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_employee_salary_log` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `tb_grade` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) DEFAULT NULL,
  `year` varchar(100) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `active` int(2) NOT NULL DEFAULT 1,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `created_by` varchar(191) DEFAULT NULL,
  `updated_by` varchar(191) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tb_grade` (`id`, `title`, `year`, `date`, `active`, `created`, `updated`, `created_by`, `updated_by`) VALUES
	(1, '% Grade Year 2023', '2023', '2023-11-23', 1, '2023-11-23 08:26:35', '2023-11-23 08:26:35', NULL, NULL);

CREATE TABLE IF NOT EXISTS `tb_grade_action` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `grade_id` varchar(191) NOT NULL,
  `grade_name` varchar(191) NOT NULL,
  `percent` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `created_by` varchar(191) DEFAULT NULL,
  `updated_by` varchar(191) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tb_grade_action` (`id`, `grade_id`, `grade_name`, `percent`, `created`, `updated`, `created_by`, `updated_by`) VALUES
	(1, '1', 'AR', 0, '2023-11-23 08:35:33', '2023-11-23 08:36:12', NULL, NULL),
	(2, '1', 'P', 0, '2024-01-12 10:42:58', '2024-01-19 03:53:04', NULL, NULL),
	(3, '1', 'A', 10, '2024-01-12 10:43:06', '2024-01-12 10:43:06', NULL, NULL),
	(4, '1', 'B', 20, '2024-01-12 10:43:27', '2024-01-12 10:43:27', NULL, NULL),
	(5, '1', 'C', 50, '2024-01-12 10:43:49', '2024-01-12 10:43:49', NULL, NULL),
	(6, '1', 'D', 15, '2024-01-12 10:43:49', '2024-01-17 04:41:18', NULL, NULL),
	(7, '1', 'E', 5, '2024-01-12 10:43:49', '2024-01-12 10:43:49', NULL, NULL),
	(8, '1', 'U', 0, '2024-01-12 10:43:49', '2024-01-12 10:43:49', NULL, NULL),
	(9, '1', 'CD', 0, '2024-01-12 10:43:49', '2024-01-12 10:43:49', NULL, NULL);

CREATE TABLE IF NOT EXISTS `tb_grade_code` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `grade_code` varchar(191) NOT NULL,
  `grade_description` varchar(191) NOT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `created_by` varchar(191) DEFAULT NULL,
  `updated_by` varchar(191) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tb_grade_code` (`id`, `grade_code`, `grade_description`, `created`, `updated`, `created_by`, `updated_by`) VALUES
	(1, 'E000', 'GM and above', '2024-01-05 02:46:22', NULL, '12', NULL),
	(2, 'E100', 'Manager (HK)', '2024-01-05 02:46:22', NULL, '12', NULL),
	(3, 'E101', 'Manager (HK1)', '2024-01-05 02:46:22', NULL, '12', NULL),
	(4, 'E310', 'Below AM (HK2)', '2024-01-05 02:46:22', NULL, '12', NULL),
	(5, 'E340', 'Below AM (Other Foreign)', '2024-01-05 02:46:22', NULL, '12', NULL),
	(6, 'L400', 'Manager (TH)', '2024-01-05 02:46:23', NULL, '12', NULL),
	(7, 'L500', 'AM (TH)', '2024-01-05 02:46:23', NULL, '12', NULL),
	(8, 'L510', 'AM (HK3)', '2024-01-05 02:46:23', NULL, '12', NULL),
	(9, 'L600', 'Below AM (TH)', '2024-01-05 02:46:23', NULL, '12', NULL),
	(10, 'L700', 'Below Section Head (TH)', '2024-01-05 02:46:23', NULL, '12', NULL),
	(11, 'L800', 'Daily Worker ', '2024-01-05 02:46:23', NULL, '12', NULL),
	(12, 'L810', 'Daily Worker (Subcontract)', '2024-01-05 02:46:23', NULL, '12', NULL),
	(13, 'L820', 'Daily Worker (Term Subcontract)', '2024-01-05 02:46:23', NULL, '12', NULL);

CREATE TABLE IF NOT EXISTS `tb_import_employee` (
  `id_file` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_file`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;


CREATE TABLE IF NOT EXISTS `tb_import_employee_attendance` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

INSERT INTO `tb_import_employee_attendance` (`id`, `name`, `path`, `size`, `created_at`, `updated_at`) VALUES
	(1, '2.1 Final- Attendance  Feb.2022to Jan.2023 ALL copy.xlsx', '/upload/employee/20240123-094905-2.1 Final- Attendance  Feb.2022to Jan.2023 ALL copy.xlsx', 44587, '2024-01-23 09:49:05', NULL);

CREATE TABLE IF NOT EXISTS `tb_import_employee_evt` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

INSERT INTO `tb_import_employee_evt` (`id`, `name`, `path`, `size`, `created_at`, `updated_at`) VALUES
	(1, '2023 Evaluator and Manager Approal List_20230929 copy.xlsx', '/upload/employee/20240123-094921-2023 Evaluator and Manager Approal List_20230929 copy.xlsx', 18889, '2024-01-23 09:49:21', NULL);

CREATE TABLE IF NOT EXISTS `tb_import_employee_salary` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;


CREATE TABLE IF NOT EXISTS `tb_import_employee_score_pa` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;


CREATE TABLE IF NOT EXISTS `tb_manage_employee` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `year` varchar(191) NOT NULL,
  `date` date NOT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `created_by` varchar(191) DEFAULT NULL,
  `updated_by` varchar(191) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tb_manage_employee` (`id`, `name`, `year`, `date`, `created`, `updated`, `created_by`, `updated_by`) VALUES
	(1, 'Employee List Year 2023', '2023', '2024-01-18', '2024-01-18 10:57:52', '2024-01-18 10:57:52', NULL, NULL);

CREATE TABLE IF NOT EXISTS `tb_pa_timeline` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) NOT NULL,
  `year` varchar(191) NOT NULL,
  `date` date NOT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `created_by` varchar(191) DEFAULT NULL,
  `updated_by` varchar(191) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tb_pa_timeline` (`id`, `title`, `year`, `date`, `created`, `updated`, `created_by`, `updated_by`) VALUES
	(1, 'Performance Appraisal and 2023 annual increment', '2023', '2023-11-27', '2023-11-27 04:46:40', '2023-11-27 04:46:40', NULL, NULL),
	(2, 'Performance Appraisal and 2024 annual increment', '2024', '2024-01-17', '2024-01-17 14:48:24', '2024-01-17 14:48:24', NULL, NULL);

CREATE TABLE IF NOT EXISTS `tb_pa_timeline_action` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pa_timeline_id` varchar(191) NOT NULL,
  `action_name` varchar(191) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `start_date_real` date DEFAULT NULL,
  `end_date_real` date DEFAULT NULL,
  `hr` enum('active','inactive') NOT NULL DEFAULT 'inactive',
  `manager` enum('active','inactive') NOT NULL DEFAULT 'inactive',
  `dm` enum('active','inactive') NOT NULL DEFAULT 'inactive',
  `gm` enum('active','inactive') NOT NULL DEFAULT 'inactive',
  `hr_select` varchar(6) DEFAULT NULL,
  `manager_select` varchar(6) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `created_by` varchar(191) DEFAULT NULL,
  `updated_by` varchar(191) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tb_pa_timeline_action` (`id`, `pa_timeline_id`, `action_name`, `start_date`, `end_date`, `start_date_real`, `end_date_real`, `hr`, `manager`, `dm`, `gm`, `hr_select`, `manager_select`, `created`, `updated`, `created_by`, `updated_by`) VALUES
	(1, '1', 'Review Evaluator Lists', '2023-02-10', '2023-02-17', '2023-02-10', '2023-02-17', 'active', 'active', 'inactive', 'inactive', NULL, NULL, '2023-11-27 04:46:40', '2023-12-26 08:01:46', NULL, NULL),
	(2, '1', 'HR distributes PA Forms to Managers', '2023-03-01', '2023-03-01', '2023-03-01', '2023-03-01', 'active', 'inactive', 'inactive', 'inactive', NULL, NULL, '2023-11-27 04:46:40', '2023-12-26 08:02:17', NULL, NULL),
	(3, '1', 'Managers return the completed PA Forms to HR', '2023-03-10', '2023-03-10', '2023-03-10', '2023-03-10', 'inactive', 'active', 'inactive', 'inactive', NULL, NULL, '2023-11-27 04:46:40', '2023-12-26 08:02:37', NULL, NULL),
	(4, '1', 'HR Inputs PA Scores into a summary Excel file', '2023-03-11', '2023-03-15', '2023-03-11', '2023-03-15', 'active', 'inactive', 'inactive', 'inactive', NULL, NULL, '2023-11-27 04:46:40', '2023-11-27 04:46:40', NULL, NULL),
	(5, '1', 'Discuss and Finalise the annual increment budget with GM', '2023-03-16', '2023-03-23', '2023-03-20', '2023-03-30', 'active', 'inactive', 'active', 'active', NULL, NULL, '2023-11-27 04:46:40', '2023-11-27 04:46:40', NULL, NULL),
	(6, '1', 'Meeting with managers to inform the timeline, %increment budget of each PA Grade, and Guideline.', '2023-03-23', '2023-03-23', '2023-04-03', '2023-04-03', 'active', 'inactive', 'active', 'inactive', NULL, NULL, '2023-11-27 04:46:40', '2023-11-27 04:46:40', NULL, NULL),
	(7, '1', 'HR distributed Annual Increment Excel', '2023-03-23', '2023-03-24', '2023-04-03', '2023-04-03', 'active', 'inactive', 'inactive', 'inactive', NULL, NULL, '2023-11-27 04:46:41', '2023-11-27 04:46:41', NULL, NULL),
	(8, '1', 'Managers complete annual increment Excel file and review their increment proposal with director of\n            manufacturing or GM for approval (this step shall depending on the organization ', '2023-03-24', '2023-03-31', '2023-04-03', '2023-04-07', 'inactive', 'active', 'active', 'active', NULL, NULL, '2023-11-27 04:46:41', '2023-11-27 04:46:41', NULL, NULL),
	(9, '1', 'Announce the annual increment to all MIL staff', '2023-03-31', '2023-03-31', '2023-04-03', '2023-04-03', 'active', 'inactive', 'inactive', 'inactive', NULL, NULL, '2023-11-27 04:46:41', '2023-11-27 04:46:41', NULL, NULL),
	(10, '1', 'For all Daily Workers/Operators: Managers submit the final/approved increment to HR', '2023-04-07', '2023-04-07', '2023-04-07', '2023-04-07', 'inactive', 'active', 'inactive', 'inactive', NULL, NULL, '2023-11-27 04:46:41', '2023-11-27 04:46:41', NULL, NULL),
	(11, '1', 'For all Monthly Employees: Managers submit the final/approved increment to HR', '2023-04-07', '2023-04-07', '2023-04-07', '2023-04-07', 'inactive', 'active', 'inactive', 'active', NULL, NULL, '2023-11-27 04:46:41', '2023-11-27 04:46:41', NULL, NULL),
	(12, '1', 'HR summarize the results of increment of all divisions/departments and send to GM for final review', '2023-04-21', '2023-04-21', '2023-04-21', '2023-04-21', 'active', 'inactive', 'inactive', 'inactive', NULL, NULL, '2023-11-27 04:46:41', '2023-11-27 04:46:41', NULL, NULL),
	(13, '1', 'Payment new salary Apr 2023 - Daily Workers', '2023-04-24', '2023-04-24', '2023-04-24', '2023-04-24', 'active', 'inactive', 'inactive', 'inactive', NULL, NULL, '2023-11-27 04:46:41', '2023-11-27 04:46:41', NULL, NULL),
	(14, '1', 'Payment new salary Apr 2023 - Monthly Employee', '2023-04-28', '2023-04-28', '2023-04-28', '2023-04-28', 'active', 'inactive', 'inactive', 'inactive', NULL, NULL, '2023-11-27 04:46:41', '2023-11-27 04:46:41', NULL, NULL),
	(15, '2', 'Review Evaluator Lists', NULL, NULL, NULL, NULL, 'inactive', 'inactive', 'inactive', 'inactive', NULL, NULL, '2024-01-17 14:48:24', '2024-01-17 14:48:24', NULL, NULL),
	(16, '2', 'HR distributes PA Forms to Managers', NULL, NULL, NULL, NULL, 'inactive', 'inactive', 'inactive', 'inactive', NULL, NULL, '2024-01-17 14:48:25', '2024-01-17 14:48:25', NULL, NULL),
	(17, '2', 'Managers return the completed PA Forms to HR', NULL, NULL, NULL, NULL, 'inactive', 'inactive', 'inactive', 'inactive', NULL, NULL, '2024-01-17 14:48:25', '2024-01-17 14:48:25', NULL, NULL),
	(18, '2', 'HR Inputs PA Scores into a summary Excel file', NULL, NULL, NULL, NULL, 'inactive', 'inactive', 'inactive', 'inactive', NULL, NULL, '2024-01-17 14:48:25', '2024-01-17 14:48:25', NULL, NULL),
	(19, '2', 'Discuss and Finalise the annual increment budget with GM', NULL, NULL, NULL, NULL, 'inactive', 'inactive', 'inactive', 'inactive', NULL, NULL, '2024-01-17 14:48:25', '2024-01-17 14:48:25', NULL, NULL),
	(20, '2', 'Meeting with managers to inform the timeline, %increment budget of each PA Grade, and Guideline.', NULL, NULL, NULL, NULL, 'inactive', 'inactive', 'inactive', 'inactive', NULL, NULL, '2024-01-17 14:48:25', '2024-01-17 14:48:25', NULL, NULL),
	(21, '2', 'HR distributed Annual Increment Excel', NULL, NULL, NULL, NULL, 'inactive', 'inactive', 'inactive', 'inactive', NULL, NULL, '2024-01-17 14:48:25', '2024-01-17 14:48:25', NULL, NULL),
	(22, '2', 'Managers complete annual increment Excel file and review their increment proposal with director of\n            manufacturing or GM for approval (this step shall depending on the organization ', NULL, NULL, NULL, NULL, 'inactive', 'inactive', 'inactive', 'inactive', NULL, NULL, '2024-01-17 14:48:25', '2024-01-17 14:48:25', NULL, NULL),
	(23, '2', 'Announce the annual increment to all MIL staff', NULL, NULL, NULL, NULL, 'inactive', 'inactive', 'inactive', 'inactive', NULL, NULL, '2024-01-17 14:48:25', '2024-01-17 14:48:25', NULL, NULL),
	(24, '2', 'For all Daily Workers/Operators: Managers submit the final/approved increment to HR', NULL, NULL, NULL, NULL, 'inactive', 'inactive', 'inactive', 'inactive', NULL, NULL, '2024-01-17 14:48:25', '2024-01-17 14:48:25', NULL, NULL),
	(25, '2', 'For all Monthly Employees: Managers submit the final/approved increment to HR', NULL, NULL, NULL, NULL, 'inactive', 'inactive', 'inactive', 'inactive', NULL, NULL, '2024-01-17 14:48:25', '2024-01-17 14:48:25', NULL, NULL),
	(26, '2', 'HR summarize the results of increment of all divisions/departments and send to GM for final review', NULL, NULL, NULL, NULL, 'inactive', 'inactive', 'inactive', 'inactive', NULL, NULL, '2024-01-17 14:48:25', '2024-01-17 14:48:25', NULL, NULL),
	(27, '2', 'Payment new salary Apr 2024 - Daily Workers', NULL, NULL, NULL, NULL, 'inactive', 'inactive', 'inactive', 'inactive', NULL, NULL, '2024-01-17 14:48:26', '2024-01-17 14:48:26', NULL, NULL),
	(28, '2', 'Payment new salary Apr 2024 - Monthly Employee', NULL, NULL, NULL, NULL, 'inactive', 'inactive', 'inactive', 'inactive', NULL, NULL, '2024-01-17 14:48:26', '2024-01-17 14:48:26', NULL, NULL);

CREATE TABLE IF NOT EXISTS `tb_percent_department` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) DEFAULT NULL,
  `year` varchar(100) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `active` int(2) NOT NULL DEFAULT 1,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `created_by` varchar(191) DEFAULT NULL,
  `updated_by` varchar(191) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tb_percent_department` (`id`, `title`, `year`, `date`, `active`, `created`, `updated`, `created_by`, `updated_by`) VALUES
	(1, '% Department Year 2023', '2023', '2024-01-12', 1, '2024-01-12 11:24:48', '2024-01-12 11:24:48', NULL, NULL);

CREATE TABLE IF NOT EXISTS `tb_percent_department_action` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `percent_department_id` int(11) NOT NULL DEFAULT 0,
  `division_code` varchar(255) DEFAULT NULL,
  `department_code` varchar(255) DEFAULT NULL,
  `section_code` varchar(255) DEFAULT NULL,
  `percent_daily` varchar(255) DEFAULT NULL,
  `percent_monthly` varchar(255) DEFAULT NULL,
  `approve_by1` varchar(6) DEFAULT NULL,
  `approve_by2` varchar(6) DEFAULT NULL,
  `active` int(2) NOT NULL DEFAULT 1,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `created_by` varchar(191) DEFAULT NULL,
  `updated_by` varchar(191) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tb_percent_department_action` (`id`, `percent_department_id`, `division_code`, `department_code`, `section_code`, `percent_daily`, `percent_monthly`, `approve_by1`, `approve_by2`, `active`, `created`, `updated`, `created_by`, `updated_by`) VALUES
	(1, 1, 'G000', 'G200', 'G2ER', '2.71', '3.87', '019492', '019492', 1, '2024-01-18 10:20:31', '2024-01-18 10:47:15', NULL, NULL),
	(2, 1, 'G000', 'G200', 'G2GA', '2.71', '3.87', '019492', '019492', 1, '2024-01-18 10:20:31', '2024-01-18 10:47:15', NULL, NULL),
	(3, 1, 'G000', 'G200', 'G2OD', '2.71', '3.87', '019492', '019492', 1, '2024-01-18 10:20:31', '2024-01-18 10:47:15', NULL, NULL),
	(4, 1, 'G000', 'G200', 'G2PS', '2.71', '3.87', '019492', '019492', 1, '2024-01-18 10:20:31', '2024-01-18 10:47:15', NULL, NULL),
	(5, 1, 'G000', 'G200', 'G2RM', '2.71', '3.87', '019492', '019492', 1, '2024-01-18 10:20:31', '2024-01-18 10:47:15', NULL, NULL);

CREATE TABLE IF NOT EXISTS `tb_position` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `position_code` varchar(191) NOT NULL,
  `position_description` varchar(191) NOT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `created_by` varchar(191) DEFAULT NULL,
  `updated_by` varchar(191) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tb_position` (`id`, `position_code`, `position_description`, `created`, `updated`, `created_by`, `updated_by`) VALUES
	(56, '100', 'Managing Director', '2023-12-11 06:53:36', '2023-12-11 06:53:36', NULL, NULL),
	(57, '101', 'General Manager', '2023-12-11 06:53:36', '2023-12-11 06:53:36', NULL, NULL),
	(58, '103', 'Production Manager', '2023-12-11 06:53:36', '2023-12-11 06:53:36', NULL, NULL),
	(59, '105', 'Manager', '2023-12-11 06:53:36', '2023-12-11 06:53:36', NULL, NULL),
	(60, '106', 'Asst. Manager', '2023-12-11 06:53:36', '2023-12-11 06:53:36', NULL, NULL),
	(61, '114', 'Director of Manufacturing ', '2023-12-11 06:53:36', '2023-12-11 06:53:36', NULL, NULL),
	(62, '200', 'Superintendent', '2023-12-11 06:53:36', '2023-12-11 06:53:36', NULL, NULL),
	(63, '201', 'Department Head', '2023-12-11 06:53:36', '2023-12-11 06:53:36', NULL, NULL),
	(64, '202', 'Asst Dept Head', '2023-12-11 06:53:36', '2023-12-11 06:53:36', NULL, NULL),
	(65, '203', 'Section Head', '2023-12-11 06:53:37', '2023-12-11 06:53:37', NULL, NULL),
	(66, '301', 'Supervisor', '2023-12-11 06:53:37', '2023-12-11 06:53:37', NULL, NULL),
	(67, '302', 'Asst Supervisor', '2023-12-11 06:53:37', '2023-12-11 06:53:37', NULL, NULL),
	(68, '303', 'Senior Engineer', '2023-12-11 06:53:37', '2023-12-11 06:53:37', NULL, NULL),
	(69, '304', 'Engineer', '2023-12-11 06:53:37', '2023-12-11 06:53:37', NULL, NULL),
	(71, '307', 'Asst. Engineer', '2023-12-11 06:53:37', '2023-12-11 06:53:37', NULL, NULL),
	(72, '308', 'System Analyst', '2023-12-11 06:53:37', '2023-12-11 06:53:37', NULL, NULL),
	(74, '402', 'Senior Programmer', '2023-12-11 06:53:37', '2023-12-11 06:53:37', NULL, NULL),
	(76, '403', 'Programmer', '2023-12-11 06:53:37', '2023-12-11 06:53:37', NULL, NULL),
	(77, '405', 'Senior Officer', '2023-12-11 06:53:37', '2023-12-11 06:53:37', NULL, NULL),
	(79, '406', 'Officer', '2023-12-11 06:53:37', '2023-12-11 06:53:37', NULL, NULL),
	(80, '407', 'PPMC Planner', '2023-12-11 06:53:37', '2023-12-11 06:53:37', NULL, NULL),
	(82, '408', 'Asst. PPMC Planner', '2023-12-11 06:53:37', '2023-12-11 06:53:37', NULL, NULL),
	(83, '416', 'Draftman', '2023-12-11 06:53:37', '2023-12-11 06:53:37', NULL, NULL),
	(84, '424', 'Senior Clerk', '2023-12-11 06:53:37', '2023-12-11 06:53:37', NULL, NULL),
	(85, '425', 'Clerk', '2023-12-11 06:53:37', '2023-12-11 06:53:37', NULL, NULL),
	(86, '427', 'Storekeeper', '2023-12-11 06:53:37', '2023-12-11 06:53:37', NULL, NULL),
	(87, '428', 'Receptionist', '2023-12-11 06:53:37', '2023-12-11 06:53:37', NULL, NULL),
	(88, '429', 'Driver', '2023-12-11 06:53:37', '2023-12-11 06:53:37', NULL, NULL),
	(89, '435', 'Senior Designer', '2023-12-11 06:53:38', '2023-12-11 06:53:38', NULL, NULL),
	(90, '436', 'Senior Planner', '2023-12-11 06:53:38', '2023-12-11 06:53:38', NULL, NULL),
	(91, '439', 'Coordinator', '2023-12-11 06:53:38', '2023-12-11 06:53:38', NULL, NULL),
	(92, '445', 'Senior IT Support', '2023-12-11 06:53:38', '2023-12-11 06:53:38', NULL, NULL),
	(94, '446', 'IT Support', '2023-12-11 06:53:38', '2023-12-11 06:53:38', NULL, NULL),
	(95, '448', 'ERP Support', '2023-12-11 06:53:38', '2023-12-11 06:53:38', NULL, NULL),
	(97, '449', 'Senior Designer', '2023-12-11 06:53:38', '2023-12-11 06:53:38', NULL, NULL),
	(98, '450', 'Security Administrator', '2023-12-11 06:53:38', '2023-12-11 06:53:38', NULL, NULL),
	(100, '451', 'Senior Project Coordinator', '2023-12-11 06:53:38', '2023-12-11 06:53:38', NULL, NULL),
	(101, '500', 'Senior Foreman', '2023-12-11 06:53:38', '2023-12-11 06:53:38', NULL, NULL),
	(103, '501', 'Foreman', '2023-12-11 06:53:38', '2023-12-11 06:53:38', NULL, NULL),
	(104, '502', 'Asst. Foreman', '2023-12-11 06:53:38', '2023-12-11 06:53:38', NULL, NULL),
	(105, '503', 'Senior Technician', '2023-12-11 06:53:38', '2023-12-11 06:53:38', NULL, NULL),
	(106, '504', 'Technician', '2023-12-11 06:53:38', '2023-12-11 06:53:38', NULL, NULL),
	(107, '505', 'Asst. Technician', '2023-12-11 06:53:38', '2023-12-11 06:53:38', NULL, NULL),
	(108, '506', 'Electrician', '2023-12-11 06:53:38', '2023-12-11 06:53:38', NULL, NULL),
	(109, '508', 'Senior Inspector', '2023-12-11 06:53:39', '2023-12-11 06:53:39', NULL, NULL),
	(110, '513', 'Team Leader', '2023-12-11 06:53:39', '2023-12-11 06:53:39', NULL, NULL),
	(111, '514', 'Monthly Worker', '2023-12-11 06:53:39', '2023-12-11 06:53:39', NULL, NULL),
	(113, '515', 'Senior Team Leader', '2023-12-11 06:53:39', '2023-12-11 06:53:39', NULL, NULL),
	(114, '517', 'Senior Electrician', '2023-12-11 06:53:39', '2023-12-11 06:53:39', NULL, NULL),
	(116, '600', 'Maid', '2023-12-11 06:53:39', '2023-12-11 06:53:39', NULL, NULL),
	(118, '605', 'Skill Worker', '2023-12-11 06:53:39', '2023-12-11 06:53:39', NULL, NULL),
	(119, '606', 'Worker', '2023-12-11 06:53:39', '2023-12-11 06:53:39', NULL, NULL),
	(121, '608', 'Senior Operator', '2023-12-11 06:53:39', '2023-12-11 06:53:39', NULL, NULL),
	(122, '609', 'Operator', '2023-12-11 06:53:39', '2023-12-11 06:53:39', NULL, NULL),
	(123, '610', 'Skilled Operator', '2023-12-11 06:53:39', '2023-12-11 06:53:39', NULL, NULL),
	(126, '601', 'Gardener', NULL, NULL, NULL, NULL);

CREATE TABLE IF NOT EXISTS `tb_section` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `section_code` varchar(191) NOT NULL,
  `section_description` varchar(191) NOT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `created_by` varchar(191) DEFAULT NULL,
  `updated_by` varchar(191) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=217 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tb_section` (`id`, `section_code`, `section_description`, `created`, `updated`, `created_by`, `updated_by`) VALUES
	(109, '12AB', 'Assembly', '2023-12-11 06:53:22', '2023-12-11 06:53:22', NULL, NULL),
	(110, '12CI', 'Interior Coating', '2023-12-11 06:53:22', '2023-12-11 06:53:22', NULL, NULL),
	(111, '12CX', 'Exterior Coating', '2023-12-11 06:53:22', '2023-12-11 06:53:22', NULL, NULL),
	(112, '12MF', 'Manufacturing Service', '2023-12-11 06:53:22', '2023-12-11 06:53:22', NULL, NULL),
	(113, '12PK', 'Packing', '2023-12-11 06:53:22', '2023-12-11 06:53:22', NULL, NULL),
	(114, '12PL', 'Polishing', '2023-12-11 06:53:22', '2023-12-11 06:53:22', NULL, NULL),
	(115, '12PO', 'Production Office', '2023-12-11 06:53:22', '2023-12-11 06:53:22', NULL, NULL),
	(116, '12SP', 'Stamping', '2023-12-11 06:53:22', '2023-12-11 06:53:22', NULL, NULL),
	(117, '12WH', 'Warehouse', '2023-12-11 06:53:23', '2023-12-11 06:53:23', NULL, NULL),
	(118, '16PE', 'Production Engineering', '2023-12-11 06:53:23', '2023-12-11 06:53:23', NULL, NULL),
	(119, '22CT', 'Coating', '2023-12-11 06:53:23', '2023-12-11 06:53:23', NULL, NULL),
	(120, '22PK', 'Packing', '2023-12-11 06:53:23', '2023-12-11 06:53:23', NULL, NULL),
	(121, '22PO', 'Production Office', '2023-12-11 06:53:23', '2023-12-11 06:53:23', NULL, NULL),
	(122, '22SP', 'Stamping', '2023-12-11 06:53:23', '2023-12-11 06:53:23', NULL, NULL),
	(123, '22WH', 'Warehouse', '2023-12-11 06:53:23', '2023-12-11 06:53:23', NULL, NULL),
	(124, '62MF', 'Manufacturing Service', '2023-12-11 06:53:23', '2023-12-11 06:53:23', NULL, NULL),
	(125, '62PE', 'Production Engineering', '2023-12-11 06:53:23', '2023-12-11 06:53:23', NULL, NULL),
	(126, '62PL', 'Polishing', '2023-12-11 06:53:23', '2023-12-11 06:53:23', NULL, NULL),
	(127, '62PO', 'Production Office', '2023-12-11 06:53:23', '2023-12-11 06:53:23', NULL, NULL),
	(128, '62PV', 'PVD', '2023-12-11 06:53:23', '2023-12-11 06:53:23', NULL, NULL),
	(129, '63LB', 'Laboratory & QA', '2023-12-11 06:53:23', '2023-12-11 06:53:23', NULL, NULL),
	(130, '64MT', 'Maintenance', '2023-12-11 06:53:24', '2023-12-11 06:53:24', NULL, NULL),
	(131, '72AB', 'Assembly', '2023-12-11 06:53:24', '2023-12-11 06:53:24', NULL, NULL),
	(132, '72BK', 'Blanking', '2023-12-11 06:53:24', '2023-12-11 06:53:24', NULL, NULL),
	(133, '72CT', 'Coating', '2023-12-11 06:53:24', '2023-12-11 06:53:24', NULL, NULL),
	(134, '72EB', 'Emboossing ', '2023-12-11 06:53:24', '2023-12-11 06:53:24', NULL, NULL),
	(135, '72FB', 'Friction Bonding', '2023-12-11 06:53:24', '2023-12-11 06:53:24', NULL, NULL),
	(136, '72PK', 'Packing', '2023-12-11 06:53:24', '2023-12-11 06:53:24', NULL, NULL),
	(137, '72PL', 'Polishing', '2023-12-11 06:53:24', '2023-12-11 06:53:24', NULL, NULL),
	(138, '72PO', 'Production Office', '2023-12-11 06:53:24', '2023-12-11 06:53:24', NULL, NULL),
	(139, '72SP', 'Stamping', '2023-12-11 06:53:25', '2023-12-11 06:53:25', NULL, NULL),
	(140, '72SR', 'Sunray', '2023-12-11 06:53:25', '2023-12-11 06:53:25', NULL, NULL),
	(141, '72WH', 'Warehouse', '2023-12-11 06:53:25', '2023-12-11 06:53:25', NULL, NULL),
	(142, '82AB', 'Assembly', '2023-12-11 06:53:25', '2023-12-11 06:53:25', NULL, NULL),
	(143, '82CT', 'Coating', '2023-12-11 06:53:25', '2023-12-11 06:53:25', NULL, NULL),
	(144, '82CV', 'Cover', '2023-12-11 06:53:25', '2023-12-11 06:53:25', NULL, NULL),
	(145, '82FB', 'Friction Bonding', '2023-12-11 06:53:25', '2023-12-11 06:53:25', NULL, NULL),
	(146, '82HA', 'Hard Anodizing', '2023-12-11 06:53:25', '2023-12-11 06:53:25', NULL, NULL),
	(147, '82PK', 'Packing', '2023-12-11 06:53:25', '2023-12-11 06:53:25', NULL, NULL),
	(148, '82PL', 'Polishing ', '2023-12-11 06:53:25', '2023-12-11 06:53:25', NULL, NULL),
	(149, '82PO', 'Production Office', '2023-12-11 06:53:26', '2023-12-11 06:53:26', NULL, NULL),
	(150, '82SP', 'Stamping', '2023-12-11 06:53:26', '2023-12-11 06:53:26', NULL, NULL),
	(151, '82SR', 'Sunray', '2023-12-11 06:53:26', '2023-12-11 06:53:26', NULL, NULL),
	(152, '82WH', 'Warehouse', '2023-12-11 06:53:26', '2023-12-11 06:53:26', NULL, NULL),
	(153, '86PE', 'Production Engineering', '2023-12-11 06:53:26', '2023-12-11 06:53:26', NULL, NULL),
	(154, '91PC', 'Planning & Control', '2023-12-11 06:53:26', '2023-12-11 06:53:26', NULL, NULL),
	(155, '92AD', 'Auto Diecutting', '2023-12-11 06:53:26', '2023-12-11 06:53:26', NULL, NULL),
	(156, '92AL', 'Auto Lamination', '2023-12-11 06:53:26', '2023-12-11 06:53:26', NULL, NULL),
	(157, '92BD', 'Block Diecutting and Pallet Making', '2023-12-11 06:53:26', '2023-12-11 06:53:26', NULL, NULL),
	(158, '92BP', 'Baling Press', '2023-12-11 06:53:26', '2023-12-11 06:53:26', NULL, NULL),
	(159, '92CG', 'Corrugation', '2023-12-11 06:53:26', '2023-12-11 06:53:26', NULL, NULL),
	(160, '92DC', 'Diecutting', '2023-12-11 06:53:26', '2023-12-11 06:53:26', NULL, NULL),
	(161, '92LM', 'Lamination and Stitching', '2023-12-11 06:53:26', '2023-12-11 06:53:26', NULL, NULL),
	(162, '92PO', 'Production Office', '2023-12-11 06:53:26', '2023-12-11 06:53:26', NULL, NULL),
	(163, '92PT', 'Printing', '2023-12-11 06:53:26', '2023-12-11 06:53:26', NULL, NULL),
	(164, '92SG', 'Slitting', '2023-12-11 06:53:27', '2023-12-11 06:53:27', NULL, NULL),
	(165, '92SO', 'Slotting', '2023-12-11 06:53:27', '2023-12-11 06:53:27', NULL, NULL),
	(166, '92WH', 'Warehouse', '2023-12-11 06:53:27', '2023-12-11 06:53:27', NULL, NULL),
	(167, '93CD', 'Calendaring', '2023-12-11 06:53:27', '2023-12-11 06:53:27', NULL, NULL),
	(168, '93DF', 'Printing Down Frame', '2023-12-11 06:53:27', '2023-12-11 06:53:27', NULL, NULL),
	(169, '93OP', 'Offset Printing', '2023-12-11 06:53:27', '2023-12-11 06:53:27', NULL, NULL),
	(170, '93SC', 'Sheet Cutting', '2023-12-11 06:53:27', '2023-12-11 06:53:27', NULL, NULL),
	(171, '93VN', 'Varnishing', '2023-12-11 06:53:27', '2023-12-11 06:53:27', NULL, NULL),
	(172, '94MT', 'General Maintenance', '2023-12-11 06:53:27', '2023-12-11 06:53:27', NULL, NULL),
	(173, 'G1EO', 'Executive Office', '2023-12-11 06:53:27', '2023-12-11 06:53:27', NULL, NULL),
	(174, 'G2ER', 'Employee Relation', '2023-12-11 06:53:27', '2023-12-11 06:53:27', NULL, NULL),
	(175, 'G2GA', 'General Affairs', '2023-12-11 06:53:27', '2023-12-11 06:53:27', NULL, NULL),
	(176, 'G2OD', 'Organization Development', '2023-12-11 06:53:27', '2023-12-11 06:53:27', NULL, NULL),
	(177, 'G2PS', 'Personnel & Salary Admin', '2023-12-11 06:53:27', '2023-12-11 06:53:27', NULL, NULL),
	(178, 'G2RM', 'Recruitment', '2023-12-11 06:53:27', '2023-12-11 06:53:27', NULL, NULL),
	(179, 'G3AC', 'Accounting', '2023-12-11 06:53:27', '2023-12-11 06:53:27', NULL, NULL),
	(180, 'G3TC', 'Treasury & Costing', '2023-12-11 06:53:27', '2023-12-11 06:53:27', NULL, NULL),
	(181, 'G4MS', 'MIS', '2023-12-11 06:53:27', '2023-12-11 06:53:27', NULL, NULL),
	(182, 'G5PU', 'Purchasing', '2023-12-11 06:53:27', '2023-12-11 06:53:27', NULL, NULL),
	(183, 'G6BO', 'BOI', '2023-12-11 06:53:27', '2023-12-11 06:53:27', NULL, NULL),
	(184, 'G6EX', 'Export', '2023-12-11 06:53:27', '2023-12-11 06:53:27', NULL, NULL),
	(185, 'G6IM', 'Import', '2023-12-11 06:53:28', '2023-12-11 06:53:28', NULL, NULL),
	(186, 'G8SS', 'Safety & Security', '2023-12-11 06:53:28', '2023-12-11 06:53:28', NULL, NULL),
	(187, 'G9PI', 'Process Improvement', '2023-12-11 06:53:28', '2023-12-11 06:53:28', NULL, NULL),
	(188, 'P0E1', 'Engineering Maintenance - CE', '2023-12-11 06:53:28', '2023-12-11 06:53:28', NULL, NULL),
	(189, 'P0E7', 'Engineering Maintenance - SS', '2023-12-11 06:53:28', '2023-12-11 06:53:28', NULL, NULL),
	(190, 'P0E8', 'Engineering Maintenance - HA', '2023-12-11 06:53:28', '2023-12-11 06:53:28', NULL, NULL),
	(191, 'P0EA', 'Engineering Administration', '2023-12-11 06:53:28', '2023-12-11 06:53:28', NULL, NULL),
	(192, 'P0EM', 'Expert Team', '2023-12-11 06:53:28', '2023-12-11 06:53:28', NULL, NULL),
	(193, 'P1DE', 'Design Engineering Administration', '2023-12-11 06:53:28', '2023-12-11 06:53:28', NULL, NULL),
	(194, 'P1PD', 'Packaging Design Engineering', '2023-12-11 06:53:28', '2023-12-11 06:53:28', NULL, NULL),
	(195, 'P2IE', 'Industrial Engineering', '2023-12-11 06:53:28', '2023-12-11 06:53:28', NULL, NULL),
	(196, 'P3LB', 'Laboratory', '2023-12-11 06:53:29', '2023-12-11 06:53:29', NULL, NULL),
	(197, 'P4QA', 'QA', '2023-12-11 06:53:29', '2023-12-11 06:53:29', NULL, NULL),
	(198, 'P5TL', 'Tooling', '2023-12-11 06:53:29', '2023-12-11 06:53:29', NULL, NULL),
	(199, 'P6SM', 'SCM', '2023-12-11 06:53:29', '2023-12-11 06:53:29', NULL, NULL),
	(200, 'P7EV', 'Environment', '2023-12-11 06:53:29', '2023-12-11 06:53:29', NULL, NULL),
	(201, 'P8AT', 'Automation', '2023-12-11 06:53:29', '2023-12-11 06:53:29', NULL, NULL),
	(202, 'P9PO', 'MSB Production Office', '2023-12-11 06:53:29', '2023-12-11 06:53:29', NULL, NULL),
	(203, 'P9WH', 'Globle Warehouse', '2023-12-11 06:53:29', '2023-12-11 06:53:29', NULL, NULL),
	(204, 'PAPD', 'Production', '2023-12-11 06:53:29', '2023-12-11 06:53:29', NULL, NULL),
	(205, 'PBMC', 'material Control', '2023-12-11 06:53:29', '2023-12-11 06:53:29', NULL, NULL),
	(206, 'PDRD', 'R&D', '2023-12-11 06:53:29', '2023-12-11 06:53:29', NULL, NULL),
	(207, 'Y2AB', 'GL-Assembly', '2023-12-11 06:53:30', '2023-12-11 06:53:30', NULL, NULL),
	(208, 'Y2GF', 'GL-Glass Forming', '2023-12-11 06:53:30', '2023-12-11 06:53:30', NULL, NULL),
	(209, 'Y2PO', 'GL-Production Office', '2023-12-11 06:53:30', '2023-12-11 06:53:30', NULL, NULL),
	(210, 'Y2RF', 'GL-Rim Forming', '2023-12-11 06:53:30', '2023-12-11 06:53:30', NULL, NULL),
	(211, 'Y2RP', 'GL-Rim Polishing', '2023-12-11 06:53:30', '2023-12-11 06:53:30', NULL, NULL),
	(212, 'Y2SG', 'GL-Slitting', '2023-12-11 06:53:30', '2023-12-11 06:53:30', NULL, NULL),
	(213, 'Z1PC', 'MS-PPMC', '2023-12-11 06:53:30', '2023-12-11 06:53:30', NULL, NULL),
	(214, 'Z2AB', 'MS-Assembly', '2023-12-11 06:53:30', '2023-12-11 06:53:30', NULL, NULL),
	(215, 'Z2MT', 'MS-Metal Forming', '2023-12-11 06:53:30', '2023-12-11 06:53:30', NULL, NULL),
	(216, 'Z2PH', 'MS-Phenolic Molding', '2023-12-11 06:53:30', '2023-12-11 06:53:30', NULL, NULL);

CREATE TABLE IF NOT EXISTS `tb_total_all` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `year` varchar(191) NOT NULL,
  `total_type` int(2) NOT NULL DEFAULT 0,
  `current_salary_wage` float(10,2) DEFAULT 0.00,
  `L800_avg_wage_mwa` float(10,2) DEFAULT 0.00,
  `salary_wage_calculation` float(10,2) DEFAULT NULL,
  `current_salary_wage_month` float(10,2) DEFAULT 0.00,
  `company_suggested_percent` float(10,2) DEFAULT 0.00,
  `company_suggested_amount` float(10,2) DEFAULT 0.00,
  `company_suggested_new_basic` float(10,2) DEFAULT 0.00,
  `inc_percent_proposed` float(10,2) DEFAULT 0.00,
  `inc_amount_proposed` float(10,2) DEFAULT 0.00,
  `new_basic_wage_proposed` float(10,2) DEFAULT 0.00,
  `new_salary_wage_month` float(10,2) DEFAULT 0.00,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` varchar(191) DEFAULT NULL,
  `updated_by` varchar(191) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tb_total_all` (`id`, `year`, `total_type`, `current_salary_wage`, `L800_avg_wage_mwa`, `salary_wage_calculation`, `current_salary_wage_month`, `company_suggested_percent`, `company_suggested_amount`, `company_suggested_new_basic`, `inc_percent_proposed`, `inc_amount_proposed`, `new_basic_wage_proposed`, `new_salary_wage_month`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
	(1, '2023', 0, 1788.00, 345.00, 1779.00, 46254.00, 44.63, 798.30, 2586.00, 14.25, 66.60, 1920.60, 49935.60, '2024-01-24 02:51:50', '2024-01-24 02:51:50', NULL, NULL),
	(2, '2023', 1, 180000.00, 0.00, 180000.00, 180000.00, 3.29, 5925.00, 185925.00, 53.25, 5325.00, 175325.00, 175325.00, '2024-01-24 02:51:50', '2024-01-24 02:51:50', NULL, NULL),
	(3, '2023', 2, 181788.00, 345.00, 181779.00, 226254.00, 47.92, 6723.30, 188511.00, 67.50, 5391.60, 177245.59, 225260.59, '2024-01-24 02:51:50', '2024-01-24 02:51:50', NULL, NULL);

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `orisoft_code` varchar(10) DEFAULT NULL,
  `name` varchar(191) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `profile_photo_path` varchar(2048) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) DEFAULT NULL,
  `avatar` varchar(191) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_login_at` datetime DEFAULT NULL,
  `last_login_ip` varchar(191) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `orisoft_code` (`orisoft_code`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `orisoft_code`, `name`, `email`, `profile_photo_path`, `email_verified_at`, `password`, `avatar`, `remember_token`, `created_at`, `updated_at`, `last_login_at`, `last_login_ip`) VALUES
	(1, NULL, 'User LV : Developer', 'developer@demo.com', NULL, '2023-11-06 03:19:23', '$2y$10$3.GvbX0N3/cyuqlVrbKY2OxigkThc/UFwx7mJOIrangKFRmsn5wU.', NULL, NULL, '2023-11-06 03:19:23', '2024-01-26 12:23:35', '2024-01-26 19:23:35', '::1'),
	(2, NULL, 'User LV : Admin', 'admin@demo.com', NULL, '2023-11-06 03:19:23', '$2y$10$3.GvbX0N3/cyuqlVrbKY2OxigkThc/UFwx7mJOIrangKFRmsn5wU.', NULL, NULL, '2023-11-06 03:19:23', '2024-01-18 21:33:54', '2024-01-19 04:33:54', '::1'),
	(3, NULL, 'User LV : HR', 'hr@demo.com', NULL, '2023-11-06 03:19:24', '$2y$10$3.GvbX0N3/cyuqlVrbKY2OxigkThc/UFwx7mJOIrangKFRmsn5wU.', NULL, '8nL4cnxGdo', '2023-11-06 03:19:24', '2023-11-06 03:19:24', NULL, NULL),
	(4, NULL, 'HR Asst', 'hr.asst@demo.com', NULL, '2023-11-06 03:19:24', '$2y$10$3.GvbX0N3/cyuqlVrbKY2OxigkThc/UFwx7mJOIrangKFRmsn5wU.', NULL, 'PMF16kmEPcbicepkxvC5eU8fzNw40hfwueqB5mIB1YIOir0WR6h1pK0lZVRN', '2023-11-06 03:19:24', '2024-01-19 00:54:11', '2024-01-19 07:54:11', '::1'),
	(5, NULL, 'HR-G2PS', 'hr.g2ps@demo.com', NULL, '2023-11-06 03:19:24', '$2y$10$3.GvbX0N3/cyuqlVrbKY2OxigkThc/UFwx7mJOIrangKFRmsn5wU.', NULL, 'sevCxKEw2K', '2023-11-06 03:19:24', '2023-11-06 03:19:24', NULL, NULL),
	(6, NULL, 'Dept. Manager', 'dept.manager@demo.com', NULL, '2023-11-06 03:19:24', '$2y$10$3.GvbX0N3/cyuqlVrbKY2OxigkThc/UFwx7mJOIrangKFRmsn5wU.', NULL, 'j6qIxpbQ1FTupTCX9rdlnDkQLHfmyrR9bw3ba2tRQrCwpQ91RDqIn6A677Sc', '2023-11-06 03:19:24', '2024-01-24 02:27:35', '2024-01-24 09:27:35', '180.183.15.228'),
	(7, NULL, 'Evaluator1', 'evaluator@demo.com', NULL, '2023-11-06 03:19:24', '$2y$10$3.GvbX0N3/cyuqlVrbKY2OxigkThc/UFwx7mJOIrangKFRmsn5wU.', NULL, '7x0rGSKKpWkTvlY5PRGzS3juRm4UUISgSHA0JJcKq9NOFw9hQ6zwJVLf9mDa', '2023-11-06 03:19:24', '2024-01-24 00:24:28', '2024-01-24 07:24:28', '180.183.15.228'),
	(8, NULL, 'Evaluator2', 'evaluator2@demo.com', NULL, '2023-11-06 03:19:24', '$2y$10$3.GvbX0N3/cyuqlVrbKY2OxigkThc/UFwx7mJOIrangKFRmsn5wU.', NULL, 'Sf1vIpFmkm', '2023-11-06 03:19:24', '2024-01-18 08:37:07', NULL, NULL),
	(9, NULL, 'HR Asst.2', 'hr.asst2@demo.com', NULL, '2023-11-06 03:19:24', '$2y$10$3.GvbX0N3/cyuqlVrbKY2OxigkThc/UFwx7mJOIrangKFRmsn5wU.', NULL, '5B6W41fUDY', '2023-11-06 03:19:24', '2023-11-06 03:19:24', NULL, NULL),
	(10, NULL, 'HR-G2PS2', 'hr.g2ps2@demo.com', NULL, '2023-11-06 03:19:24', '$2y$10$3.GvbX0N3/cyuqlVrbKY2OxigkThc/UFwx7mJOIrangKFRmsn5wU.', NULL, 'TF3y0XfA93', '2023-11-06 03:19:24', '2023-11-06 03:19:24', NULL, NULL),
	(11, NULL, 'User LV : HR Manager 2', 'hr2@demo.com', NULL, '2023-11-06 03:19:24', '$2y$10$3.GvbX0N3/cyuqlVrbKY2OxigkThc/UFwx7mJOIrangKFRmsn5wU.', NULL, 'KFQlEFy8qV', '2023-11-06 03:19:24', '2023-11-06 03:19:24', NULL, NULL),
	(12, NULL, 'Admin', 'demo@demo.com', NULL, '2023-11-06 03:19:24', '$2y$10$3.GvbX0N3/cyuqlVrbKY2OxigkThc/UFwx7mJOIrangKFRmsn5wU.', NULL, 'I93R2fNIYlCjfajYRhwUJ0mFH6164yhd75KXEZfxa3GyLHRVwIX0JrEdvTmi', '2023-11-06 03:19:24', '2024-02-01 00:34:37', '2024-02-01 07:34:37', '::1'),
	(13, '000060', 'Wannakorn', 'wannakornc@meyer-mil.com', NULL, NULL, '$2y$10$ZecGke.XuKcFxms3ppwCnOqbQaTidanPhv/1nCy5zq2QyUVb/ddiu', NULL, NULL, '2024-01-17 22:49:43', '2024-01-24 02:57:09', '2024-01-24 09:57:09', '180.183.15.228'),
	(14, '019492', 'pimnada', 'pimnadaj@meyer-mil.com', NULL, NULL, '$2y$10$wu/y/CYx1yf4/BucOUzPYuEv9fp9ePewPgpm04SBFe/3asZZnwGba', NULL, NULL, '2024-01-18 07:43:21', '2024-01-24 01:44:06', '2024-01-24 08:44:06', '180.183.15.228'),
	(15, NULL, 'GM', 'gm@demo.com', NULL, NULL, '$2y$10$rfK1R0jKCd9z9iFq2wq0UO7dn.G3Z3EWT.IszDqXZtsZL5vd2D2sm', NULL, NULL, '2024-01-23 02:28:45', '2024-01-24 02:50:05', '2024-01-24 09:50:05', '180.183.15.228');

CREATE TABLE IF NOT EXISTS `users_model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`) USING BTREE,
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`) USING BTREE,
  CONSTRAINT `FK_users_model_has_permissions_users_permissions` FOREIGN KEY (`permission_id`) REFERENCES `users_permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;


CREATE TABLE IF NOT EXISTS `users_model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`) USING BTREE,
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`) USING BTREE,
  CONSTRAINT `FK_users_model_has_roles_users_roles` FOREIGN KEY (`role_id`) REFERENCES `users_roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

INSERT INTO `users_model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
	(1, 'App\\Models\\User', 1),
	(2, 'App\\Models\\User', 12),
	(3, 'App\\Models\\User', 14),
	(4, 'App\\Models\\User', 13),
	(6, 'App\\Models\\User', 6),
	(7, 'App\\Models\\User', 2),
	(7, 'App\\Models\\User', 15),
	(8, 'App\\Models\\User', 7),
	(8, 'App\\Models\\User', 8),
	(8, 'App\\Models\\User', 14);

CREATE TABLE IF NOT EXISTS `users_permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `guard_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

INSERT INTO `users_permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'view dashboards', 'web', '2023-12-11 00:31:13', '2023-12-11 00:31:13'),
	(2, 'view pa timeline history', 'web', '2023-12-11 00:31:13', '2023-12-11 00:31:13'),
	(3, 'create pa timeline history', 'web', '2023-12-11 00:31:13', '2023-12-11 00:31:13'),
	(4, 'view task status tracking', 'web', '2023-12-11 00:31:13', '2023-12-11 00:31:13'),
	(5, 'view evaluation criteria', 'web', '2023-12-11 00:31:13', '2023-12-11 00:31:13'),
	(6, 'create evaluation criteria', 'web', '2023-12-11 00:31:13', '2023-12-11 00:31:13'),
	(7, 'edit evaluation criteria', 'web', '2023-12-11 00:31:13', '2023-12-11 00:31:13'),
	(8, 'view pa form groups', 'web', '2023-12-11 00:31:13', '2023-12-11 00:31:13'),
	(9, 'create pa form groups', 'web', '2023-12-11 00:31:13', '2023-12-11 00:31:13'),
	(10, 'edit pa form groups', 'web', '2023-12-11 00:31:14', '2023-12-11 00:31:14'),
	(11, 'active pa form groups', 'web', '2023-12-11 00:31:14', '2023-12-11 00:31:14'),
	(12, 'view upload evaluators', 'web', '2023-12-11 00:31:14', '2023-12-11 00:31:14'),
	(13, 'upload upload evaluators', 'web', '2023-12-11 00:31:14', '2023-12-11 00:31:14'),
	(14, 'view set budget', 'web', '2023-12-11 00:31:14', '2023-12-11 00:31:14'),
	(15, 'create set budget', 'web', '2023-12-11 00:31:14', '2023-12-11 00:31:14'),
	(16, 'edit set budget', 'web', '2023-12-11 00:31:14', '2023-12-11 00:31:14'),
	(17, 'view set pa grades', 'web', '2023-12-11 00:31:14', '2023-12-11 00:31:14'),
	(18, 'create set pa grades', 'web', '2023-12-11 00:31:14', '2023-12-11 00:31:14'),
	(19, 'edit set pa grades', 'web', '2023-12-11 00:31:14', '2023-12-11 00:31:14'),
	(20, 'view set increase', 'web', '2023-12-11 00:31:14', '2023-12-11 00:31:14'),
	(21, 'create set increase', 'web', '2023-12-11 00:31:14', '2023-12-11 00:31:14'),
	(22, 'edit set increase', 'web', '2023-12-11 00:31:14', '2023-12-11 00:31:14'),
	(23, 'view employee', 'web', '2023-12-11 00:31:15', '2023-12-11 00:31:15'),
	(24, 'create employee', 'web', '2023-12-11 00:31:15', '2023-12-11 00:31:15'),
	(25, 'edit employee', 'web', '2023-12-11 00:31:15', '2023-12-11 00:31:15'),
	(26, 'view users', 'web', '2023-12-11 00:31:15', '2023-12-11 00:31:15'),
	(27, 'create users', 'web', '2023-12-11 00:31:15', '2023-12-11 00:31:15'),
	(28, 'edit users', 'web', '2023-12-11 00:31:15', '2023-12-11 00:31:15'),
	(29, 'view roles', 'web', '2023-12-11 00:31:15', '2023-12-11 00:31:15'),
	(30, 'create roles', 'web', '2023-12-11 00:31:15', '2023-12-11 00:31:15'),
	(31, 'edit roles', 'web', '2023-12-11 00:31:15', '2023-12-11 00:31:15'),
	(32, 'view permissions', 'web', '2023-12-11 00:31:15', '2023-12-11 00:31:15'),
	(33, 'create permissions', 'web', '2023-12-11 00:31:15', '2023-12-11 00:31:15'),
	(34, 'edit permissions', 'web', '2023-12-11 00:31:15', '2023-12-11 00:31:15'),
	(35, 'view evaluate employees', 'web', '2023-12-11 00:31:15', '2023-12-11 00:31:15'),
	(36, 'edit evaluate employees', 'web', '2023-12-11 00:31:15', '2023-12-11 00:31:15'),
	(37, 'evaluate evaluate employees', 'web', '2023-12-11 00:31:15', '2023-12-11 00:31:15'),
	(38, 'view review pa results', 'web', '2023-12-11 00:31:15', '2023-12-11 00:31:15'),
	(39, 'view salary increase', 'web', '2023-12-11 00:31:15', '2023-12-11 00:31:15'),
	(40, 'view review salary', 'web', '2023-12-11 00:31:15', '2023-12-11 00:31:15'),
	(41, 'approve review salary', 'web', '2023-12-11 00:31:15', '2023-12-11 00:31:15'),
	(42, 'view pa grading', 'web', '2023-12-11 00:31:15', '2023-12-11 00:31:15'),
	(43, 'edit pa grading', 'web', '2023-12-11 00:31:15', '2023-12-11 00:31:15'),
	(44, 'view approve salary', 'web', '2023-12-11 00:31:15', '2023-12-11 00:31:15'),
	(45, 'edit approve salary', 'web', '2023-12-11 00:31:15', '2023-12-11 00:31:15'),
	(46, 'export approve salary', 'web', '2023-12-11 00:31:15', '2023-12-11 00:31:15'),
	(47, 'view review evaluate employees', 'web', '2023-12-11 00:31:15', '2023-12-11 00:31:15'),
	(48, 'edit review evaluate employees', 'web', '2023-12-11 00:31:16', '2023-12-11 00:31:16'),
	(49, 'view set evaluators pa form', 'web', '2023-12-11 00:31:16', '2023-12-11 00:31:16'),
	(50, 'edit set evaluators pa form', 'web', '2023-12-11 00:31:16', '2023-12-11 00:31:16');

CREATE TABLE IF NOT EXISTS `users_permissions_menu` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` int(10) unsigned NOT NULL DEFAULT 0,
  `name` varchar(250) DEFAULT NULL,
  `name_th` varchar(250) DEFAULT NULL,
  `code` varchar(250) DEFAULT NULL,
  `view` enum('Y','N') DEFAULT 'N',
  `create` enum('Y','N') DEFAULT 'N',
  `edit` enum('Y','N') DEFAULT 'N',
  `delete` enum('Y','N') DEFAULT 'N',
  `active` enum('Y','N') DEFAULT 'N',
  `evaluate` enum('Y','N') DEFAULT 'N',
  `approve` enum('Y','N') DEFAULT 'N',
  `upload` enum('Y','N') DEFAULT 'N',
  `export` enum('Y','N') DEFAULT 'N',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

INSERT INTO `users_permissions_menu` (`id`, `key`, `name`, `name_th`, `code`, `view`, `create`, `edit`, `delete`, `active`, `evaluate`, `approve`, `upload`, `export`, `created_at`, `updated_at`) VALUES
	(1, 0, 'Dashboards', 'Dashboards', 'dashboards', 'Y', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-12-11 04:36:44', '2023-12-11 07:15:50'),
	(2, 0, 'PA timeline', 'PA timeline', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-12-11 04:36:44', '2023-12-11 06:32:30'),
	(3, 2, 'PA Timeline History', 'จัดการPA timeline', 'pa timeline history', 'Y', 'Y', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-12-11 04:36:44', '2023-12-11 07:16:01'),
	(4, 2, 'Task Status Tracking', 'ติดตามสถานะงาน', 'task status tracking', 'Y', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-12-11 04:36:44', '2023-12-11 07:16:03'),
	(5, 0, 'PA Form', 'ฟอร์มประเมิน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-12-11 04:36:44', '2023-12-11 06:32:40'),
	(6, 5, 'Create Evaluation Criteria', 'สร้างเกณฑ์การประเมิน', 'evaluation criteria', 'Y', 'Y', 'Y', NULL, NULL, NULL, NULL, NULL, NULL, '2023-12-11 04:36:54', '2023-12-11 07:16:18'),
	(7, 5, 'Create PA Form Groups', 'สร้างกลุ่มแบบฟอร์มการประเมิน', 'pa form groups', 'Y', 'Y', 'Y', NULL, 'Y', NULL, NULL, NULL, NULL, '2023-12-11 04:36:55', '2023-12-11 07:16:20'),
	(8, 0, 'Settings', 'ตั้งค่า', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-12-11 04:39:45', '2023-12-11 06:33:08'),
	(9, 8, 'Upload Evaluators and Attendance Data', 'อัพโหลดผู้ประเมินและ ข้อมูล Attendance', 'upload evaluators', 'Y', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', NULL, '2023-12-11 04:39:53', '2023-12-11 07:25:39'),
	(10, 8, 'Set Budget', 'กำหนด Budget', 'set budget', 'Y', 'Y', 'Y', NULL, NULL, NULL, NULL, NULL, NULL, '2023-12-11 04:40:01', '2023-12-11 07:16:48'),
	(11, 8, 'Set PA Grades', 'กำหนดเกรด PA', 'set pa grades', 'Y', 'Y', 'Y', NULL, NULL, NULL, NULL, NULL, NULL, '2023-12-11 04:40:05', '2023-12-11 07:16:47'),
	(12, 8, 'Set %Increase by Dept.', 'กำหนด %การปรับเงินแต่ละแผนก', 'set increase', 'Y', 'Y', 'Y', NULL, NULL, NULL, NULL, NULL, NULL, '2023-12-11 04:40:06', '2023-12-11 07:16:46'),
	(13, 8, 'Employee Data Management', 'จัดการข้อมูลพนักงาน', 'employee', 'Y', 'Y', 'Y', NULL, NULL, NULL, NULL, NULL, NULL, '2023-12-11 04:40:16', '2023-12-11 07:16:45'),
	(14, 8, 'User Management', 'จัดการข้อมูลผู้ใช้ระบบ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-12-11 04:40:17', '2023-12-11 06:32:52'),
	(15, 14, 'Users', 'จัดการ Users', 'users', 'Y', 'Y', 'Y', NULL, NULL, NULL, NULL, NULL, NULL, '2023-12-11 04:40:25', '2023-12-11 07:17:07'),
	(16, 14, 'Roles', 'จัดการ Roles', 'roles', 'Y', 'Y', 'Y', NULL, NULL, NULL, NULL, NULL, NULL, '2023-12-11 04:40:29', '2023-12-11 07:17:06'),
	(17, 14, 'Permissions', 'จัดการ Permissions', 'permissions', 'Y', 'Y', 'Y', NULL, NULL, NULL, NULL, NULL, NULL, '2023-12-11 04:40:29', '2023-12-11 07:17:06'),
	(18, 0, 'Evaluate employees', 'ประเมินพนักงาน', 'evaluate employees', 'Y', NULL, 'Y', NULL, NULL, 'Y', NULL, NULL, NULL, '2023-12-11 04:47:42', '2023-12-11 07:25:54'),
	(19, 0, 'Review and Approve PA Results', 'ทบทวนและอนุมัติผลการประเมิน', 'review pa results', 'Y', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-12-11 04:47:53', '2023-12-11 07:26:18'),
	(20, 0, 'Salary Increase', 'การปรับขึ้นเงินเดือน', 'salary increase', 'Y', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-12-11 04:48:24', '2023-12-11 07:17:15'),
	(21, 0, 'Review and Approve Salary Increase', 'ทบทวนและอนุมัติการปรับขึ้นเงินเดือน', 'review salary', 'Y', NULL, NULL, NULL, NULL, NULL, 'Y', NULL, NULL, '2023-12-11 04:48:30', '2023-12-11 07:26:30'),
	(22, 0, 'PA Grading', 'ตัดเกรด PA', 'pa grading', 'Y', NULL, 'Y', NULL, NULL, NULL, NULL, NULL, NULL, '2023-12-11 04:49:26', '2023-12-11 07:17:13'),
	(23, 0, 'Approved Salary', 'เงินเดือนที่ได้รับการอนุมัติแล้ว', 'approve salary', 'Y', NULL, 'Y', NULL, NULL, NULL, NULL, NULL, 'Y', '2023-12-11 04:49:33', '2023-12-11 07:26:49'),
	(24, 0, 'Evaluation Schedule', 'กำหนดการประเมิน\r\n', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-12-11 04:49:34', '2023-12-11 06:32:57'),
	(25, 24, 'Review Lists of Evaluated Employees', 'ตรวจสอบรายชื่อพนักงานผู้ถูกประเมิน', 'review evaluate employees', 'Y', NULL, 'Y', NULL, NULL, NULL, NULL, NULL, NULL, '2023-12-11 04:50:56', '2023-12-11 07:27:03'),
	(26, 24, 'Set Evaluators and PA Forms', 'กำหนดผู้ประเมิน และฟอร์มการประเมิน', 'set evaluators pa form', 'Y', NULL, 'Y', NULL, NULL, NULL, NULL, NULL, NULL, '2023-12-11 04:51:02', '2023-12-11 07:27:18');

CREATE TABLE IF NOT EXISTS `users_roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL COMMENT 'role key name',
  `detail` varchar(191) DEFAULT NULL,
  `guard_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

INSERT INTO `users_roles` (`id`, `name`, `detail`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'Developer', 'Developer', 'web', '2023-11-06 03:19:24', '2023-11-06 03:19:24'),
	(2, 'Admin', 'Application Admin', 'web', '2023-11-06 03:19:24', '2023-11-06 03:19:24'),
	(3, 'HR Manager', 'HR Manager', 'web', '2023-11-06 03:19:24', '2023-12-11 00:53:02'),
	(4, 'HR Assistant', 'HR Asst. Manager', 'web', '2023-11-06 03:19:24', '2023-11-06 03:19:24'),
	(5, 'HR-G2PS', 'HR-G2PS', 'web', '2023-11-06 03:19:24', '2023-11-06 03:19:24'),
	(6, 'Dept-Manager', 'Dept. Manager', 'web', '2023-11-06 03:19:24', '2023-11-06 03:19:24'),
	(7, 'Top Management', 'Top Management (GM/DM)', 'web', '2023-11-06 03:19:24', '2023-11-06 03:19:24'),
	(8, 'Evaluator', 'Evaluator', 'web', '2023-11-06 03:19:24', '2023-11-06 03:19:24');

CREATE TABLE IF NOT EXISTS `users_role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`) USING BTREE,
  KEY `role_has_permissions_role_id_foreign` (`role_id`) USING BTREE,
  CONSTRAINT `FK_users_role_has_permissions_users_permissions` FOREIGN KEY (`permission_id`) REFERENCES `users_permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_users_role_has_permissions_users_roles` FOREIGN KEY (`role_id`) REFERENCES `users_roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

INSERT INTO `users_role_has_permissions` (`permission_id`, `role_id`) VALUES
	(1, 1),
	(1, 2),
	(1, 3),
	(1, 4),
	(2, 1),
	(2, 2),
	(2, 3),
	(2, 4),
	(3, 1),
	(3, 2),
	(3, 3),
	(3, 4),
	(4, 1),
	(4, 2),
	(4, 3),
	(4, 4),
	(5, 1),
	(5, 2),
	(5, 3),
	(5, 4),
	(6, 1),
	(6, 2),
	(6, 3),
	(6, 4),
	(7, 1),
	(7, 2),
	(7, 3),
	(7, 4),
	(8, 1),
	(8, 2),
	(8, 3),
	(8, 4),
	(9, 1),
	(9, 2),
	(9, 3),
	(9, 4),
	(10, 1),
	(10, 2),
	(10, 3),
	(10, 4),
	(11, 1),
	(11, 2),
	(11, 3),
	(11, 4),
	(12, 1),
	(12, 2),
	(12, 3),
	(12, 4),
	(12, 5),
	(13, 1),
	(13, 2),
	(13, 3),
	(13, 4),
	(14, 1),
	(14, 2),
	(14, 3),
	(14, 4),
	(15, 1),
	(15, 2),
	(15, 3),
	(15, 4),
	(16, 1),
	(16, 2),
	(16, 3),
	(16, 4),
	(17, 1),
	(17, 2),
	(17, 3),
	(17, 4),
	(18, 1),
	(18, 2),
	(18, 3),
	(18, 4),
	(19, 1),
	(19, 2),
	(19, 4),
	(20, 1),
	(20, 2),
	(20, 3),
	(20, 4),
	(21, 1),
	(21, 2),
	(21, 3),
	(21, 4),
	(22, 1),
	(22, 2),
	(22, 3),
	(22, 4),
	(23, 1),
	(23, 2),
	(23, 3),
	(23, 4),
	(24, 1),
	(24, 2),
	(24, 3),
	(24, 4),
	(25, 1),
	(25, 2),
	(25, 3),
	(25, 4),
	(26, 1),
	(26, 2),
	(26, 3),
	(26, 4),
	(27, 1),
	(27, 2),
	(28, 1),
	(28, 2),
	(28, 3),
	(28, 4),
	(29, 1),
	(29, 2),
	(30, 1),
	(31, 1),
	(31, 2),
	(32, 1),
	(33, 1),
	(34, 1),
	(35, 1),
	(35, 2),
	(35, 8),
	(36, 1),
	(36, 2),
	(37, 1),
	(37, 2),
	(37, 8),
	(38, 1),
	(38, 2),
	(38, 6),
	(39, 1),
	(39, 2),
	(39, 6),
	(40, 1),
	(40, 2),
	(40, 4),
	(40, 7),
	(41, 1),
	(41, 2),
	(41, 4),
	(41, 7),
	(42, 1),
	(42, 2),
	(42, 3),
	(42, 4),
	(43, 1),
	(43, 2),
	(43, 3),
	(43, 4),
	(44, 1),
	(44, 2),
	(44, 3),
	(44, 4),
	(45, 1),
	(45, 2),
	(45, 3),
	(45, 4),
	(46, 1),
	(46, 2),
	(46, 3),
	(46, 4),
	(47, 1),
	(47, 2),
	(47, 6),
	(48, 1),
	(48, 2),
	(48, 6),
	(49, 1),
	(49, 2),
	(49, 6),
	(50, 1),
	(50, 2),
	(50, 6);

SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE DEFINER=`meyer`@`%` TRIGGER `meyer_mil`.`users_after_delete` AFTER DELETE ON `users` FOR EACH ROW BEGIN
	DELETE FROM `users_model_has_roles` WHERE `model_id`=OLD.id;
	UPDATE `tb_employee` SET `users_id`=NULL WHERE `orisoft_no`=OLD.orisoft_code;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE DEFINER=`meyer`@`%` TRIGGER `meyer_mil`.`users_after_insert` AFTER INSERT ON `users` FOR EACH ROW BEGIN
	IF NEW.orisoft_code THEN
		UPDATE `tb_employee` SET `users_id`=NEW.id WHERE `orisoft_no`=NEW.orisoft_code;
	END IF;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE DEFINER=`meyer`@`%` TRIGGER `meyer_mil`.`users_after_update` AFTER UPDATE ON `users` FOR EACH ROW BEGIN
	UPDATE `tb_employee` SET `users_id`=NEW.id WHERE `orisoft_no`=NEW.orisoft_code;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE DEFINER=`meyer`@`%` TRIGGER `meyer_mil`.`users_before_update` BEFORE UPDATE ON `users` FOR EACH ROW BEGIN
	UPDATE `tb_employee` SET `users_id`=NULL WHERE `orisoft_no`=NEW.orisoft_code;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
