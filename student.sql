-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2024 at 02:26 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `id` int(11) NOT NULL,
  `patient_id` int(10) NOT NULL,
  `doctor_id` int(3) NOT NULL,
  `service_id` int(10) NOT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`id`, `patient_id`, `doctor_id`, `service_id`, `date`, `time`) VALUES
(1, 9, 4, 1, '2024-11-14', '09:00:00'),
(2, 10, 5, 4, '2024-11-14', '10:00:00'),
(3, 11, 6, 7, '2024-11-15', '11:00:00'),
(4, 12, 7, 8, '2024-11-15', '12:00:00'),
(5, 13, 8, 5, '2024-11-16', '09:30:00'),
(6, 14, 4, 2, '2024-11-16', '10:30:00'),
(7, 15, 5, 5, '2024-11-17', '11:30:00'),
(8, 16, 6, 6, '2024-11-17', '13:00:00'),
(9, 17, 7, 9, '2024-11-18', '09:45:00'),
(10, 18, 8, 3, '2024-11-18', '10:45:00'),
(12, 15, 4, 1, '2024-11-26', '09:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_services`
--

CREATE TABLE `doctor_services` (
  `doctor_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor_services`
--

INSERT INTO `doctor_services` (`doctor_id`, `service_id`) VALUES
(4, 1),
(4, 2),
(4, 3),
(5, 4),
(5, 5),
(6, 1),
(6, 6),
(6, 7),
(7, 8),
(7, 9),
(8, 2),
(8, 3),
(8, 4),
(8, 5);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`) VALUES
(1, 'ALBIREA DINȚILOR'),
(2, 'APARAT DENTAR'),
(3, 'COROANA DENTARĂ'),
(4, 'DETARTRAJ DENTAR'),
(5, 'EXTRACȚIE DENTARĂ'),
(6, 'FAȚETE DENTARE'),
(7, 'IMPLANTUL DENTAR'),
(8, 'SCOATEREA NERVULUI'),
(9, 'PROTEZE DENTARE');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `type` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `name`, `password`, `phone`, `type`) VALUES
(1, 'admin@edoc.com', 'admin', '123', NULL, 'a'),
(2, 'patient@edoc.com', 'Test Patient', '123', NULL, 'p'),
(3, 'doctor@edoc.com', 'Test Doctor', '123', NULL, 'd'),
(4, 'doctor1@edoc.com', 'Dr. Ionescu Andrei', '123', '0712345678', 'd'),
(5, 'doctor2@edoc.com', 'Dr. Popescu Maria', '123', '0723456789', 'd'),
(6, 'doctor3@edoc.com', 'Dr. Vasilescu Mihai', '123', '0734567890', 'd'),
(7, 'doctor4@edoc.com', 'Dr. Dinu Elena', '123', '0745678901', 'd'),
(8, 'doctor5@edoc.com', 'Dr. Grigore Ioana', '123', '0756789012', 'd'),
(9, 'pacient1@edoc.com', 'Ion Popa', '123', '0767890123', 'p'),
(10, 'pacient2@edoc.com', 'Ana Vasile', '123', '0778901234', 'p'),
(11, 'pacient3@edoc.com', 'George Dumitru', '123', '0789012345', 'p'),
(12, 'pacient4@edoc.com', 'Elena Radu', '123', '0790123456', 'p'),
(13, 'pacient5@edoc.com', 'Mihai Enache', '123', '0701234567', 'p'),
(14, 'pacient6@edoc.com', 'Laura Costache', '123', '0712345678', 'p'),
(15, 'pacient7@edoc.com', 'Andrei Stan', '123', '0723456789', 'p'),
(16, 'pacient8@edoc.com', 'Maria Tomescu', '123', '0734567890', 'p'),
(17, 'pacient9@edoc.com', 'Cristina Pavel', '123', '0745678901', 'p'),
(18, 'pacient10@edoc.com', 'Daniela Iliescu', '123', '0756789012', 'p'),
(19, 'poatan@mail.com', 'Po Atan', '123', '0712345678', 'p');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pid` (`patient_id`),
  ADD KEY `scheduleid` (`service_id`);

--
-- Indexes for table `doctor_services`
--
ALTER TABLE `doctor_services`
  ADD PRIMARY KEY (`doctor_id`,`service_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `doctor_services`
--
ALTER TABLE `doctor_services`
  ADD CONSTRAINT `doctor_services_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `doctor_services_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
