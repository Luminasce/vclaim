-- dashboard.konfig_api_k definition

-- Create the database
CREATE DATABASE IF NOT EXISTS dashboard;

-- Use the created database
USE dashboard;

-- Create the table konfig_api_k
CREATE TABLE IF NOT EXISTS `konfig_api_k` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cons_id` varchar(255) DEFAULT NULL,
  `timestamp` varchar(255) DEFAULT NULL,
  `signature` varchar(255) DEFAULT NULL,
  `api_vclaim` varchar(350) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Insert data into konfig_api_k
INSERT INTO `konfig_api_k` (id, cons_id, `timestamp`, signature, api_vclaim)
VALUES
  (1, '21540', '1716523102', '2Yw7aEHydXGkwnFP7mTwR4MnmAVb7LkEgRGMAt60Or8=', 'https://apijkn.bpjs-kesehatan.go.id/vclaim-rest/');
