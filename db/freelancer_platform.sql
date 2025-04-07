-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 22, 2025 at 09:42 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `freelancer_platform`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `client_id` int(11) NOT NULL,
  `performer_id` int(11) NOT NULL,
  `date` varchar(100) NOT NULL,
  `message` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`id`, `first_name`, `last_name`, `client_id`, `performer_id`, `date`, `message`) VALUES
(210, 'რატი', 'ჯიქია', 39, 31, '23-02-2025 12:38', 'გამარჯობა'),
(211, 'test', 'test', 39, 31, '23-02-2025 12:38', 'გამარჯობა რატი'),
(212, 'test', 'test', 39, 32, '23-02-2025 12:40', 'გამარჯობა'),
(213, 'მარიამ', 'ხვედელიძე', 39, 32, '23-02-2025 12:41', 'გამარჯობა 😆');

-- --------------------------------------------------------

--
-- Table structure for table `chat_config`
--

CREATE TABLE `chat_config` (
  `id` int(11) NOT NULL,
  `client_first_name` varchar(100) NOT NULL,
  `client_last_name` varchar(100) NOT NULL,
  `client_id` int(11) NOT NULL,
  `performer_id` int(11) NOT NULL,
  `professions` varchar(100) NOT NULL,
  `days` varchar(100) NOT NULL,
  `client_job_descriptions` mediumtext NOT NULL,
  `publish_time` varchar(100) NOT NULL,
  `client_email` varchar(100) NOT NULL,
  `client_budget` varchar(100) NOT NULL,
  `client_budget_type` varchar(100) NOT NULL,
  `image` varchar(1000) NOT NULL,
  `performer_first_name` varchar(100) NOT NULL,
  `performer_last_name` varchar(100) NOT NULL,
  `performer_email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat_config`
--

INSERT INTO `chat_config` (`id`, `client_first_name`, `client_last_name`, `client_id`, `performer_id`, `professions`, `days`, `client_job_descriptions`, `publish_time`, `client_email`, `client_budget`, `client_budget_type`, `image`, `performer_first_name`, `performer_last_name`, `performer_email`) VALUES
(59, 'test', 'test', 39, 31, '.ვებ-დეველოპერი.', '10', '111', '23-02-2025 12:38', 'test@gmail.com', '1000', 'პროექტის დასრულებისას', 's-l1200.jpg', 'რატი', 'ჯიქია', 'rati.jiqia4@gmail.com'),
(60, 'test', 'test', 39, 32, '.Full-stack დეველოპერი.', '1', 'ქეწე', '23-02-2025 12:39', 'test@gmail.com', '1000', 'პროექტის დასრულებისას', '1492a5fb-ae6.jpg', 'მარიამ', 'ხვედელიძე', 'mariamkhvedelidze@gmail.com'),
(61, 'test', 'test', 39, 32, '.ვებ-დეველოპერი.', '10', '111', '23-02-2025 12:38', 'test@gmail.com', '1000', 'პროექტის დასრულებისას', '1492a5fb-ae6.jpg', 'მარიამ', 'ხვედელიძე', 'mariamkhvedelidze@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `client_task`
--

CREATE TABLE `client_task` (
  `id` int(11) NOT NULL,
  `professions` varchar(500) NOT NULL,
  `days` varchar(100) NOT NULL,
  `job_description` mediumtext NOT NULL,
  `publish_time` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `budget` int(11) NOT NULL,
  `budget_type` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client_task`
--

INSERT INTO `client_task` (`id`, `professions`, `days`, `job_description`, `publish_time`, `user_id`, `budget`, `budget_type`, `first_name`, `last_name`, `email`) VALUES
(57, '.ვებ-დეველოპერი.', '10', '111', '23-02-2025 12:38', 39, 1000, 'პროექტის დასრულებისას', 'test', 'test', 'test@gmail.com'),
(58, '.Full-stack დეველოპერი.', '1', 'ქეწე', '23-02-2025 12:39', 39, 1000, 'პროექტის დასრულებისას', 'test', 'test', 'test@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(6) UNSIGNED NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `city` varchar(50) NOT NULL,
  `user_type` varchar(100) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `description` mediumtext NOT NULL DEFAULT '\'თქვენ ჯერ არ გაქვთ თქვენი პროფილი აღწერილი\'',
  `image` varchar(1000) NOT NULL,
  `online` varchar(100) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `gender`, `city`, `user_type`, `created_at`, `description`, `image`, `online`) VALUES
(31, 'რატი', 'ჯიქია', 'rati.jiqia4@gmail.com', '12345678', 'კაცი', 'მცხეთა', 'შემსრულებელი', '18-01-2025 09:12', 'მე ვარ რატი ჯიქია 25 წლის დავამთავრე ინფორმაციული ტექნოლოგიების აკადემია კომპიუტერული ქსელები და სისტემები ასევე ვარ თვითნასწავლი დეველოპერი ეს არის ჩემი პროფილის აღწერა asffa afaffa', 's-l1200.jpg', '0'),
(32, 'მარიამ', 'ხვედელიძე', 'mariamkhvedelidze@gmail.com', '12345678', 'ქალი', 'თბილისი', 'შემსრულებელი', '18-01-2025 09:25', 'მე ვარ მარიამ ხვედელიძე დავამთავრე საქართველოს ტექნიკური უნივერსიტეტი ვებ დეველოპერის მიმართულებით მაქვს საკმაოდ დიდი გამოცდილება', '1492a5fb-ae6.jpg', '0'),
(38, 'სანდრო', 'სანდრო', 'sandro@gmail.com', '12345678', 'კაცი', 'თბილისი', 'შემსრულებელი', '24-01-2025 09:04', 'გამარჯობა მე ვარ სანდრო ქსელის ადმინისტრატორი', '', '0'),
(39, 'test', 'test', 'test@gmail.com', '12345678', 'კაცი', 'რუსთავი', 'დამკვეთი', '23-02-2025 12:37', '\'თქვენ ჯერ არ გაქვთ თქვენი პროფილი აღწერილი\'', '', '1');

-- --------------------------------------------------------

--
-- Table structure for table `user_jobrequests`
--

CREATE TABLE `user_jobrequests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_type` varchar(100) NOT NULL,
  `user_created_at` varchar(100) NOT NULL,
  `image` varchar(1000) NOT NULL,
  `request_created_at` varchar(100) NOT NULL,
  `client_id` int(11) NOT NULL,
  `professions` varchar(100) NOT NULL,
  `accepted` varchar(100) NOT NULL DEFAULT '0',
  `days` varchar(100) NOT NULL,
  `client_job_description` mediumtext NOT NULL,
  `publish_time` varchar(100) NOT NULL,
  `client_budget` varchar(100) NOT NULL,
  `budget_type` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `description` mediumtext NOT NULL,
  `client_first_name` varchar(100) NOT NULL,
  `client_last_name` varchar(100) NOT NULL,
  `client_email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_jobrequests`
--

INSERT INTO `user_jobrequests` (`id`, `user_id`, `user_type`, `user_created_at`, `image`, `request_created_at`, `client_id`, `professions`, `accepted`, `days`, `client_job_description`, `publish_time`, `client_budget`, `budget_type`, `first_name`, `last_name`, `email`, `gender`, `city`, `description`, `client_first_name`, `client_last_name`, `client_email`) VALUES
(58, 31, 'შემსრულებელი', '18-01-2025 09:12', 's-l1200.jpg', '23-02-2025 12:38', 39, '.ვებ-დეველოპერი.', '1', '10', '111', '23-02-2025 12:38', '1000', 'პროექტის დასრულებისას', 'რატი', 'ჯიქია', 'rati.jiqia4@gmail.com', 'კაცი', 'მცხეთა', 'მე ვარ რატი ჯიქია 25 წლის დავამთავრე ინფორმაციული ტექნოლოგიების აკადემია კომპიუტერული ქსელები და სისტემები ასევე ვარ თვითნასწავლი დეველოპერი ეს არის ჩემი პროფილის აღწერა asffa afaffa', 'test', 'test', 'test@gmail.com'),
(59, 32, 'შემსრულებელი', '18-01-2025 09:25', '1492a5fb-ae6.jpg', '23-02-2025 12:40', 39, '.Full-stack დეველოპერი.', '1', '1', 'ქეწე', '23-02-2025 12:39', '1000', 'პროექტის დასრულებისას', 'მარიამ', 'ხვედელიძე', 'mariamkhvedelidze@gmail.com', 'ქალი', 'თბილისი', 'მე ვარ მარიამ ხვედელიძე დავამთავრე საქართველოს ტექნიკური უნივერსიტეტი ვებ დეველოპერის მიმართულებით მაქვს საკმაოდ დიდი გამოცდილება', 'test', 'test', 'test@gmail.com'),
(60, 32, 'შემსრულებელი', '18-01-2025 09:25', '1492a5fb-ae6.jpg', '23-02-2025 12:40', 39, '.ვებ-დეველოპერი.', '1', '10', '111', '23-02-2025 12:38', '1000', 'პროექტის დასრულებისას', 'მარიამ', 'ხვედელიძე', 'mariamkhvedelidze@gmail.com', 'ქალი', 'თბილისი', 'მე ვარ მარიამ ხვედელიძე დავამთავრე საქართველოს ტექნიკური უნივერსიტეტი ვებ დეველოპერის მიმართულებით მაქვს საკმაოდ დიდი გამოცდილება', 'test', 'test', 'test@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chat_config`
--
ALTER TABLE `chat_config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client_task`
--
ALTER TABLE `client_task`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_jobrequests`
--
ALTER TABLE `user_jobrequests`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=214;

--
-- AUTO_INCREMENT for table `chat_config`
--
ALTER TABLE `chat_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `client_task`
--
ALTER TABLE `client_task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `user_jobrequests`
--
ALTER TABLE `user_jobrequests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
