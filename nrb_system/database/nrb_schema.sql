-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2026 at 06:03 AM
-- Server version: 8.0.46
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nrb_national_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `Address_ID` int NOT NULL,
  `TA` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `District` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`Address_ID`, `TA`, `District`) VALUES
(1, 'Mbelwa', 'Mzuzu'),
(2, 'Chilombo', 'Lilongwe'),
(3, 'Machinjiri', 'Blantyre');

-- --------------------------------------------------------

--
-- Table structure for table `bio_data`
--

CREATE TABLE `bio_data` (
  `Biometric_ID` int NOT NULL,
  `Fingerprint` blob,
  `Photograph` blob,
  `Signature` blob,
  `Person_ID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bio_data`
--

INSERT INTO `bio_data` (`Biometric_ID`, `Fingerprint`, `Photograph`, `Signature`, `Person_ID`) VALUES
(1, NULL, NULL, NULL, 1),
(2, NULL, NULL, NULL, 2),
(3, NULL, NULL, NULL, 3);

-- --------------------------------------------------------

--
-- Table structure for table `center_location`
--

CREATE TABLE `center_location` (
  `Center_ID` int NOT NULL,
  `Location` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dependent`
--

CREATE TABLE `dependent` (
  `Person_ID` int NOT NULL,
  `Dependent_Name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `DoB` date DEFAULT NULL,
  `Gender` enum('M','F','O') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Nationality` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Contact_No` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dependent`
--

INSERT INTO `dependent` (`Person_ID`, `Dependent_Name`, `DoB`, `Gender`, `Nationality`, `Contact_No`) VALUES
(1, 'Sarah Mwale', '2015-04-10', 'F', 'Malawian', NULL),
(1, 'Tom Mwale', '2018-09-22', 'M', 'Malawian', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `district`
--

CREATE TABLE `district` (
  `District_ID` int NOT NULL,
  `District_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Region_ID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `district`
--

INSERT INTO `district` (`District_ID`, `District_name`, `Region_ID`) VALUES
(3, 'Blantyre', 3),
(2, 'Lilongwe', 2),
(1, 'Mzuzu', 1);

-- --------------------------------------------------------

--
-- Table structure for table `identification_document`
--

CREATE TABLE `identification_document` (
  `Document_ID` int NOT NULL,
  `Document_type` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Document_No` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Person_ID` int NOT NULL,
  `Application_ID` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `identification_document`
--

INSERT INTO `identification_document` (`Document_ID`, `Document_type`, `Document_No`, `Person_ID`, `Application_ID`) VALUES
(1, 'Birth Certificate', 'BC-2015-0001', 1, 1),
(2, 'Passport', 'PP-2020-0002', 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `malawian_citizen`
--

CREATE TABLE `malawian_citizen` (
  `Person_ID` int NOT NULL,
  `Fname` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Lname` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `DoB` date NOT NULL,
  `Gender` enum('M','F','O') COLLATE utf8mb4_unicode_ci NOT NULL,
  `Nationality` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Malawian',
  `District_ID` int NOT NULL,
  `Address_ID` int DEFAULT NULL,
  `Citizen_ID` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `National_ID` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `malawian_citizen`
--

INSERT INTO `malawian_citizen` (`Person_ID`, `Fname`, `Lname`, `DoB`, `Gender`, `Nationality`, `District_ID`, `Address_ID`, `Citizen_ID`, `National_ID`) VALUES
(1, 'Alice', 'Mwale', '1990-05-12', 'F', 'Malawian', 1, 1, 'MW-CIT-0001', 'MW-NID-10001'),
(2, 'Brian', 'Phiri', '1988-03-20', 'M', 'Malawian', 2, 2, 'MW-CIT-0002', ''),
(3, 'Carol', 'Banda', '1995-11-08', 'F', 'Malawian', 3, 3, 'MW-CIT-0003', NULL),
(4, 'John', 'Doe', '2003-10-26', 'F', 'Malawian', 3, NULL, 'MW-CIT-95870', 'MW-NID-77777'),
(5, 'Nafe', 'Kape', '2004-01-03', 'M', 'Malawian', 1, NULL, 'MW-CIT-92710', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `national_id_card`
--

CREATE TABLE `national_id_card` (
  `Card_ID` int NOT NULL,
  `National_ID_No` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Issue_date` date NOT NULL,
  `Expired_date` date DEFAULT NULL,
  `Card_Status` enum('Active','Suspended','Revoked','Expired') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `Person_ID` int NOT NULL,
  `Application_ID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `national_id_card`
--

INSERT INTO `national_id_card` (`Card_ID`, `National_ID_No`, `Issue_date`, `Expired_date`, `Card_Status`, `Person_ID`, `Application_ID`) VALUES
(1, 'MW-NID-10001', '2026-09-15', '2036-09-15', 'Active', 1, 1),
(2, 'MW-NID-55555', '2026-10-22', '2036-10-22', 'Active', 2, 2),
(3, 'MW-NID-77777', '2026-10-22', '2036-10-22', 'Active', 4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `new_application`
--

CREATE TABLE `new_application` (
  `Application_ID` int NOT NULL,
  `Application_type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'New',
  `Application_date` date NOT NULL,
  `Application_status` enum('Pending','Approved','Rejected','Issued') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `Person_ID` int NOT NULL,
  `Officer_ID` int DEFAULT NULL,
  `Registration_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `new_application`
--

INSERT INTO `new_application` (`Application_ID`, `Application_type`, `Application_date`, `Application_status`, `Person_ID`, `Officer_ID`, `Registration_date`) VALUES
(1, 'New', '2026-09-01', 'Approved', 1, 1, '2026-09-01'),
(2, 'New', '2026-09-05', 'Approved', 2, 1, '2026-09-05'),
(4, 'New', '2026-10-21', 'Issued', 4, NULL, '2026-10-21'),
(5, 'New', '2026-10-22', 'Approved', 5, NULL, '2026-10-22');

-- --------------------------------------------------------

--
-- Table structure for table `non_citizen`
--

CREATE TABLE `non_citizen` (
  `Person_ID` int NOT NULL,
  `Fname` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Lname` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `DoB` date NOT NULL,
  `Gender` enum('M','F','O') COLLATE utf8mb4_unicode_ci NOT NULL,
  `Nationality` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `District_ID` int NOT NULL,
  `Address_ID` int DEFAULT NULL,
  `Resident_ID` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Visa_No` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Permit_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Expiry_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `non_citizen`
--

INSERT INTO `non_citizen` (`Person_ID`, `Fname`, `Lname`, `DoB`, `Gender`, `Nationality`, `District_ID`, `Address_ID`, `Resident_ID`, `Visa_No`, `Permit_type`, `Expiry_date`) VALUES
(1, 'David', 'Smith', '1985-07-15', 'M', 'British', 2, 2, 'MW-RES-0001', 'V-2026-001', 'Work Permit', '2027-12-31');

-- --------------------------------------------------------

--
-- Table structure for table `officer`
--

CREATE TABLE `officer` (
  `Officer_ID` int NOT NULL,
  `First_name` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Last_name` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Position` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Contact_No` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Is_Registration_Officer` tinyint(1) NOT NULL DEFAULT '0',
  `Is_Supervisor` tinyint(1) NOT NULL DEFAULT '0',
  `Supervised_By` int DEFAULT NULL,
  `Center_ID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `officer`
--

INSERT INTO `officer` (`Officer_ID`, `First_name`, `Last_name`, `Position`, `Contact_No`, `Is_Registration_Officer`, `Is_Supervisor`, `Supervised_By`, `Center_ID`) VALUES
(1, 'John', 'Banda', 'Registration Officer', '0991111111', 1, 0, NULL, 1),
(2, 'Mary', 'Phiri', 'Supervisor', '0992222222', 0, 1, NULL, 1),
(3, 'James', 'Mwale', 'Registration Officer', '0993333333', 1, 0, NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `person_contact`
--

CREATE TABLE `person_contact` (
  `Person_ID` int NOT NULL,
  `Contact_No` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Person_Type` enum('CITIZEN','NON_CITIZEN') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `person_contact`
--

INSERT INTO `person_contact` (`Person_ID`, `Contact_No`, `Person_Type`) VALUES
(1, '+265991000001', 'CITIZEN'),
(2, '+265991000002', 'CITIZEN'),
(3, '+265991000003', 'CITIZEN');

-- --------------------------------------------------------

--
-- Table structure for table `region`
--

CREATE TABLE `region` (
  `Region_ID` int NOT NULL,
  `Region_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `region`
--

INSERT INTO `region` (`Region_ID`, `Region_name`) VALUES
(2, 'Central'),
(1, 'Northern'),
(3, 'Southern');

-- --------------------------------------------------------

--
-- Table structure for table `registration_center`
--

CREATE TABLE `registration_center` (
  `Center_ID` int NOT NULL,
  `Center_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `District_ID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `registration_center`
--

INSERT INTO `registration_center` (`Center_ID`, `Center_name`, `Address`, `District_ID`) VALUES
(1, 'Mzuzu Main NRB', 'Katoto Road', 1),
(2, 'Lilongwe City NRB', 'Area 3', 2);

-- --------------------------------------------------------

--
-- Table structure for table `replacement`
--

CREATE TABLE `replacement` (
  `Application_ID` int NOT NULL,
  `Application_type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Replacement',
  `Application_date` date NOT NULL,
  `Application_status` enum('Pending','Approved','Rejected','Issued') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `Person_ID` int NOT NULL,
  `Officer_ID` int DEFAULT NULL,
  `Reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`Address_ID`);

--
-- Indexes for table `bio_data`
--
ALTER TABLE `bio_data`
  ADD PRIMARY KEY (`Biometric_ID`),
  ADD UNIQUE KEY `uq_bio_person` (`Person_ID`);

--
-- Indexes for table `center_location`
--
ALTER TABLE `center_location`
  ADD PRIMARY KEY (`Center_ID`,`Location`);

--
-- Indexes for table `dependent`
--
ALTER TABLE `dependent`
  ADD PRIMARY KEY (`Person_ID`,`Dependent_Name`);

--
-- Indexes for table `district`
--
ALTER TABLE `district`
  ADD PRIMARY KEY (`District_ID`),
  ADD UNIQUE KEY `uq_district_name` (`District_name`,`Region_ID`),
  ADD KEY `fk_district_region` (`Region_ID`);

--
-- Indexes for table `identification_document`
--
ALTER TABLE `identification_document`
  ADD PRIMARY KEY (`Document_ID`),
  ADD KEY `fk_doc_person` (`Person_ID`),
  ADD KEY `fk_doc_application` (`Application_ID`);

--
-- Indexes for table `malawian_citizen`
--
ALTER TABLE `malawian_citizen`
  ADD PRIMARY KEY (`Person_ID`),
  ADD UNIQUE KEY `uq_citizen_id` (`Citizen_ID`),
  ADD UNIQUE KEY `uq_national_id` (`National_ID`),
  ADD KEY `fk_citizen_district` (`District_ID`),
  ADD KEY `fk_citizen_address` (`Address_ID`);

--
-- Indexes for table `national_id_card`
--
ALTER TABLE `national_id_card`
  ADD PRIMARY KEY (`Card_ID`),
  ADD UNIQUE KEY `uq_nid_no` (`National_ID_No`),
  ADD UNIQUE KEY `uq_card_app` (`Application_ID`),
  ADD KEY `fk_card_person` (`Person_ID`);

--
-- Indexes for table `new_application`
--
ALTER TABLE `new_application`
  ADD PRIMARY KEY (`Application_ID`),
  ADD KEY `fk_newapp_person` (`Person_ID`),
  ADD KEY `fk_newapp_officer` (`Officer_ID`);

--
-- Indexes for table `non_citizen`
--
ALTER TABLE `non_citizen`
  ADD PRIMARY KEY (`Person_ID`),
  ADD UNIQUE KEY `uq_resident_id` (`Resident_ID`),
  ADD KEY `fk_noncit_district` (`District_ID`),
  ADD KEY `fk_noncit_address` (`Address_ID`);

--
-- Indexes for table `officer`
--
ALTER TABLE `officer`
  ADD PRIMARY KEY (`Officer_ID`),
  ADD KEY `fk_officer_supervisor` (`Supervised_By`),
  ADD KEY `fk_officer_center` (`Center_ID`);

--
-- Indexes for table `person_contact`
--
ALTER TABLE `person_contact`
  ADD PRIMARY KEY (`Person_ID`,`Contact_No`);

--
-- Indexes for table `region`
--
ALTER TABLE `region`
  ADD PRIMARY KEY (`Region_ID`),
  ADD UNIQUE KEY `uq_region_name` (`Region_name`);

--
-- Indexes for table `registration_center`
--
ALTER TABLE `registration_center`
  ADD PRIMARY KEY (`Center_ID`),
  ADD KEY `fk_center_district` (`District_ID`);

--
-- Indexes for table `replacement`
--
ALTER TABLE `replacement`
  ADD PRIMARY KEY (`Application_ID`),
  ADD KEY `fk_repl_person` (`Person_ID`),
  ADD KEY `fk_repl_officer` (`Officer_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `Address_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bio_data`
--
ALTER TABLE `bio_data`
  MODIFY `Biometric_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `district`
--
ALTER TABLE `district`
  MODIFY `District_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `identification_document`
--
ALTER TABLE `identification_document`
  MODIFY `Document_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `malawian_citizen`
--
ALTER TABLE `malawian_citizen`
  MODIFY `Person_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `national_id_card`
--
ALTER TABLE `national_id_card`
  MODIFY `Card_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `new_application`
--
ALTER TABLE `new_application`
  MODIFY `Application_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `non_citizen`
--
ALTER TABLE `non_citizen`
  MODIFY `Person_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `officer`
--
ALTER TABLE `officer`
  MODIFY `Officer_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `region`
--
ALTER TABLE `region`
  MODIFY `Region_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `registration_center`
--
ALTER TABLE `registration_center`
  MODIFY `Center_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `replacement`
--
ALTER TABLE `replacement`
  MODIFY `Application_ID` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bio_data`
--
ALTER TABLE `bio_data`
  ADD CONSTRAINT `fk_bio_person` FOREIGN KEY (`Person_ID`) REFERENCES `malawian_citizen` (`Person_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `center_location`
--
ALTER TABLE `center_location`
  ADD CONSTRAINT `fk_centerloc_center` FOREIGN KEY (`Center_ID`) REFERENCES `registration_center` (`Center_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dependent`
--
ALTER TABLE `dependent`
  ADD CONSTRAINT `fk_dependent_person` FOREIGN KEY (`Person_ID`) REFERENCES `malawian_citizen` (`Person_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `district`
--
ALTER TABLE `district`
  ADD CONSTRAINT `fk_district_region` FOREIGN KEY (`Region_ID`) REFERENCES `region` (`Region_ID`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `identification_document`
--
ALTER TABLE `identification_document`
  ADD CONSTRAINT `fk_doc_application` FOREIGN KEY (`Application_ID`) REFERENCES `new_application` (`Application_ID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_doc_person` FOREIGN KEY (`Person_ID`) REFERENCES `malawian_citizen` (`Person_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `malawian_citizen`
--
ALTER TABLE `malawian_citizen`
  ADD CONSTRAINT `fk_citizen_address` FOREIGN KEY (`Address_ID`) REFERENCES `address` (`Address_ID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_citizen_district` FOREIGN KEY (`District_ID`) REFERENCES `district` (`District_ID`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `national_id_card`
--
ALTER TABLE `national_id_card`
  ADD CONSTRAINT `fk_card_application` FOREIGN KEY (`Application_ID`) REFERENCES `new_application` (`Application_ID`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_card_person` FOREIGN KEY (`Person_ID`) REFERENCES `malawian_citizen` (`Person_ID`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `new_application`
--
ALTER TABLE `new_application`
  ADD CONSTRAINT `fk_newapp_officer` FOREIGN KEY (`Officer_ID`) REFERENCES `officer` (`Officer_ID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_newapp_person` FOREIGN KEY (`Person_ID`) REFERENCES `malawian_citizen` (`Person_ID`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `non_citizen`
--
ALTER TABLE `non_citizen`
  ADD CONSTRAINT `fk_noncit_address` FOREIGN KEY (`Address_ID`) REFERENCES `address` (`Address_ID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_noncit_district` FOREIGN KEY (`District_ID`) REFERENCES `district` (`District_ID`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `officer`
--
ALTER TABLE `officer`
  ADD CONSTRAINT `fk_officer_center` FOREIGN KEY (`Center_ID`) REFERENCES `registration_center` (`Center_ID`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_officer_supervisor` FOREIGN KEY (`Supervised_By`) REFERENCES `officer` (`Officer_ID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `registration_center`
--
ALTER TABLE `registration_center`
  ADD CONSTRAINT `fk_center_district` FOREIGN KEY (`District_ID`) REFERENCES `district` (`District_ID`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `replacement`
--
ALTER TABLE `replacement`
  ADD CONSTRAINT `fk_repl_officer` FOREIGN KEY (`Officer_ID`) REFERENCES `officer` (`Officer_ID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_repl_person` FOREIGN KEY (`Person_ID`) REFERENCES `malawian_citizen` (`Person_ID`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
