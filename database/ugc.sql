-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2024 at 09:44 PM
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
-- Database: `ugc`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_section`
--

CREATE TABLE `about_section` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about_section`
--

INSERT INTO `about_section` (`id`, `content`) VALUES
(1, 'The University Grants Commission (UGC) is a statutory body set up by the Government of Bangladesh to determine, and maintain standards of higher education.'),
(2, 'Our mission is to promote and maintain the quality of higher education in Bangladesh by providing necessary support and guidance to universities.'),
(3, 'The UGC facilitates academic cooperation, helps in the development of educational infrastructure, and ensures the well-being of students and faculty.'),
(4, 'We are committed to ensuring equitable access to quality education for all and fostering an environment that encourages research and innovation.'),
(5, 'Through various initiatives and funding programs, the UGC aims to enhance the research capabilities of higher education institutions in Bangladesh.');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(2, 'mridula', 'mridula123@gmail.com', 'All the features are working correctly.', '2024-11-23 19:51:34'),
(3, 'elma', 'elma123@gmail.com', 'This navigation bar color is good.', '2024-11-23 19:59:55');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `news_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`news_id`, `title`, `content`, `created_at`) VALUES
(1, 'New Courses Offered', 'We are excited to announce new courses for the upcoming semester. Check our website for more details.', '2024-11-05 09:47:22'),
(2, 'University Rankings Released', 'The latest university rankings have been published. Congratulations to all our universities!', '2024-11-05 09:47:22'),
(4, 'Ranking Realities : Bangladesh’s higher education strategy needs a redesign', 'The announcement of university rankings has caused a considerable stir. For the cynics, the absence of any Bangladeshi university among the top 800 institutions recently ranked by Times Higher Education World University Rankings (THEWUR) 2025 is unacceptable. Optimists view the presence of five universities in the 801-1000 bracket as a significant achievement. There are four new entries in this category: Bangabandhu Sheikh Mujibur Rahman Agricultural University (BSMRAU), Jahangirnagar University, Daffodil International University (DIU), and Jashore University of Science and Technology (JUST), joined by North South University (NSU).', '2024-11-18 05:50:15'),
(5, 'Mind the gap in centralised university admissions', 'The University Grants Commission (UGC) in Bangladesh recently unveiled the draft of the Central Admission Examination Authority Ordinance for the 2023-24 academic year. This ordinance is poised to revolutionise university admissions across the country, bringing all universities—including those that have historically resisted the cluster system in favour of institutional autonomy—under the umbrella of a National Testing Authority.', '2024-11-18 05:52:00');

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE `resources` (
  `resource_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `link` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resources`
--

INSERT INTO `resources` (`resource_id`, `title`, `description`, `link`, `created_at`) VALUES
(1, 'Scholarship Opportunities', 'Explore various scholarship options available for students in USA for session 2025-26.', 'https://www.scholars4dev.com/category/country/usa-scholarships/', '2024-11-05 10:40:45'),
(2, 'Library Access', 'Access our online library for a wealth of information and research of NSU.', 'https://library.northsouth.edu/', '2024-11-05 10:40:45'),
(3, 'Scholarship for International Students at Green University of Bangladesh', 'Green University of Bangladesh (GUB) is dedicated to fostering global academic excellence by offering a range of scholarships for international students. With a commitment to making quality education accessible to talented students worldwide, GUB provides financial assistance based on merit. Our scholarships aim to support bright minds from around the globe in pursuing their academic goals while experiencing a diverse and inclusive learning environment at one of Bangladesh\'s leading private universities. Join GUB and take the next step in your educational journey with the support of our scholarship programs. GUB particularly supports students from low or lower-middle-income countries, with preference given to those applicants for scholarship opportunities.', 'https://green.edu.bd/international-scholarship', '2024-11-18 05:58:21');

-- --------------------------------------------------------

--
-- Table structure for table `universities`
--

CREATE TABLE `universities` (
  `university_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `departments` text NOT NULL,
  `subjects` text NOT NULL,
  `global_ranking` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `universities`
--

INSERT INTO `universities` (`university_id`, `name`, `departments`, `subjects`, `global_ranking`) VALUES
(2, 'Rajshahi University of Engineering & Technology', 'Department of Engineering, Department of Humanities', 'Mechanical Engineering, History, Philosophy', 601),
(3, 'North South University', 'Department of ECE, DEpartment of Pharmacy', 'EEE, CSE, Pharmacy, CS', 801),
(4, 'Daffodil International University', 'Department of ECE', 'CSE, EEE, CS', 1200),
(5, 'Dhaka University', 'Department of Science, Department of Arts, Department of Humanities', 'Physics, Chemistry, Biology, Math, Sociology', 1001),
(6, 'Bangladesh University of Engineering and Technology', 'Architecture, Biomedical Engineering, Chemical Engineering, CIVIL ENGINEERING, Mechanical Engineering', 'EEE, CSE, ME, Civil', 761),
(7, 'Rajshahi University', 'Science, Arts, Humanities', 'Bangla, English, Math, Physics, Statistics', 1076);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL,
  `security_question` varchar(255) NOT NULL,
  `security_answer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role`, `security_question`, `security_answer`) VALUES
(1, 'admin', 'admin@123', 'admin', 'What is your birth name?', 'supri'),
(5, 'user1', 'User@123', 'user', 'What is your birth place?', 'dhaka'),
(6, 'tanzim', 'Tanzim@123', 'user', 'What is your birth place?', 'nobabganj'),
(7, 'Mridula', 'Mridula@123', 'user', 'What is your favourite university?', 'NSU');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_section`
--
ALTER TABLE `about_section`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`news_id`);

--
-- Indexes for table `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`resource_id`);

--
-- Indexes for table `universities`
--
ALTER TABLE `universities`
  ADD PRIMARY KEY (`university_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_section`
--
ALTER TABLE `about_section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `news_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `resources`
--
ALTER TABLE `resources`
  MODIFY `resource_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `universities`
--
ALTER TABLE `universities`
  MODIFY `university_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
