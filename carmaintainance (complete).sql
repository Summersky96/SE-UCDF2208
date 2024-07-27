-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2024 at 06:26 PM
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
-- Database: `carmaintainance`
--

-- --------------------------------------------------------

--
-- Table structure for table `admininfo`
--

CREATE TABLE `admininfo` (
  `adminid` int(11) NOT NULL,
  `adminemail` varchar(500) NOT NULL,
  `adminpassword` varchar(20) NOT NULL,
  `adminpic` varchar(500) NOT NULL,
  `status` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admininfo`
--

INSERT INTO `admininfo` (`adminid`, `adminemail`, `adminpassword`, `adminpic`, `status`, `name`) VALUES
(1, 'admin@gmail.com', '123', 'pfp/music.gif', 'Active now', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `bookingid` int(11) NOT NULL,
  `carname` varchar(50) NOT NULL,
  `cusphone` varchar(20) NOT NULL,
  `plate` varchar(500) NOT NULL,
  `date` date NOT NULL,
  `service` varchar(255) NOT NULL,
  `otherService` varchar(255) NOT NULL,
  `userid` int(11) NOT NULL,
  `status` varchar(10) NOT NULL,
  `customer` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`bookingid`, `carname`, `cusphone`, `plate`, `date`, `service`, `otherService`, `userid`, `status`, `customer`) VALUES
(45, 'BMW', '01123456678', 'BFS 5378', '2024-06-22', 'Air Conds', '', 5, 'Confirmed', 'Jalen'),
(46, 'Mercedes', '0123746567', 'VUD 7654', '2024-06-30', 'Others', 'Exhaust Pipe ', 5, 'Rejected', 'Bryan'),
(47, 'Proton', '0123456', 'VUD 6789', '2024-07-05', 'Modification', '', 5, 'Confirmed', 'Jalen'),
(48, 'Bwm', '0123456', 'BFS 5378', '2024-05-21', 'Car Battery', '', 5, 'Expired', 'Jalen'),
(49, 'BMW', '0123456', 'BFS 5378', '2024-08-13', 'Tyres', '', 0, 'Confirmed', 'Jalen'),
(50, 'BMW', '0123456', 'BFS 5378', '2024-08-21', 'Tyres', '', 5, 'Rejected', 'Jalen');

-- --------------------------------------------------------

--
-- Table structure for table `codes`
--

CREATE TABLE `codes` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `code` varchar(5) NOT NULL,
  `expire` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `codes`
--

INSERT INTO `codes` (`id`, `email`, `code`, `expire`) VALUES
(2, 'jinnxiang08@gmail.com', '71591', 1716995649),
(3, 'jinnxiang08@gmail.com', '29234', 1717007578),
(4, 'jinnxiang08@gmail.com', '81329', 1717007712),
(5, 'jinnxiang08@gmail.com', '61461', 1717007898),
(6, 'jinnxiang08@gmail.com', '17177', 1717008028),
(7, 'jinnxiang08@gmail.com', '57488', 1717008393),
(8, 'jinnxiang08@gmail.com', '77405', 1717008526),
(9, 'jinnxiang08@gmail.com', '36959', 1717037483),
(10, 'bryanlowzy25@gmail.com', '32362', 1717255232),
(11, 'bryanlowzy25@gmail.com', '18008', 1717258067),
(12, 'bryanlowzy25@gmail.com', '19792', 1717259706),
(13, 'bryanlowzy25@gmail.com', '31660', 1717260517),
(14, 'bryanlowzy25@gmail.com', '63170', 1717260664),
(15, 'bryanlowzy25@gmail.com', '40320', 1717353868),
(16, 'b@gmail.com', '15774', 1717392259),
(17, 'bryanlowzy25@gmail.com', '15904', 1717392469),
(18, 'bryanlowzy25@gmail.com', '39642', 1717392673),
(19, 'bryanlowzy25@gmail.com', '93436', 1717392681),
(20, 'bryanlowzy25@gmail.com', '42878', 1717392733),
(21, 'bryanlowzy25@gmail.com', '27710', 1717404226),
(22, 'bryanlowzy25@gmail.com', '90919', 1717404416),
(23, 'bryanlowzy25@gmail.com', '79318', 1717404466),
(24, 'bryanlowzy25@gmail.com', '22478', 1717404570),
(25, 'bryanlowzy25@gmail.com', '42153', 1717410293),
(26, 'bryanlowzy25@gmail.com', '80146', 1718964290),
(27, 'bryanlowzy25@gmail.com', '91034', 1718964473);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `commentsid` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_role` enum('customer','mechanic','admin') NOT NULL,
  `content` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`commentsid`, `post_id`, `user_email`, `user_role`, `content`, `created_at`) VALUES
(5, 3, 'mec1@gmail.com', 'customer', 'dsadsadsa', '2024-06-19 21:01:16'),
(6, 4, 'mec1@gmail.com', 'customer', 'dsaasd', '2024-06-19 21:07:09'),
(7, 4, 'mec1@gmail.com', 'customer', 'dsad', '2024-06-19 21:07:12'),
(8, 5, 'admin@gmail.com', 'customer', 'dasd', '2024-06-19 21:07:33'),
(9, 4, 'admin@gmail.com', 'customer', 'asddada', '2024-06-19 21:07:36'),
(11, 7, 'j@gmail.com', 'customer', 'dassd', '2024-06-19 21:40:38'),
(12, 9, 'j@gmail.com', 'customer', 'dsaasd', '2024-06-19 21:43:17'),
(13, 6, 'j@gmail.com', 'customer', 'dasdsa', '2024-06-19 21:43:23'),
(14, 7, 'j@gmail.com', 'customer', 'dassda', '2024-06-19 21:49:11'),
(16, 9, 'j@gmail.com', 'customer', 'dsa', '2024-06-19 21:49:20'),
(17, 7, 'j@gmail.com', 'customer', 'sads', '2024-06-19 21:49:23'),
(18, 9, 'mec1@gmail.com', 'customer', 'dsasda', '2024-06-19 21:58:07'),
(19, 7, 'mec1@gmail.com', 'customer', 'dsasd', '2024-06-19 21:58:11'),
(20, 7, 'mec1@gmail.com', 'customer', 'dsadsa', '2024-06-19 21:58:15'),
(23, 10, 'j@gmail.com', 'customer', 'adasdsa', '2024-06-20 10:36:41'),
(24, 10, 'admin@gmail.com', 'customer', 'dsadsa', '2024-06-21 09:03:34'),
(25, 12, 'mec1@gmail.com', 'customer', 'Glad that you like it😊', '2024-06-21 14:42:09'),
(26, 14, 'admin@gmail.com', 'customer', '🔥🔥🔥🔥', '2024-06-21 14:44:19'),
(27, 12, 'admin@gmail.com', 'customer', 'Thanks for choosing AutoMate 🫶🫶', '2024-06-21 14:45:07'),
(28, 12, 'j@gmail.com', 'customer', 'Thnak you AutoMate', '2024-06-21 14:45:41');

-- --------------------------------------------------------

--
-- Table structure for table `earnings`
--

CREATE TABLE `earnings` (
  `earningid` int(11) NOT NULL,
  `date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `method` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `customer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `earnings`
--

INSERT INTO `earnings` (`earningid`, `date`, `amount`, `method`, `description`, `customer`) VALUES
(1, '2024-06-01', 200.00, '', 'Car Service', 'Bryan'),
(2, '2024-06-05', 150.00, '', 'Tyres', 'Jason'),
(3, '2024-06-10', 300.00, '', 'Engines', 'Lim Jun Yang'),
(4, '2024-06-15', 250.00, '', 'Air Conds', 'Janice'),
(5, '2024-06-20', 400.00, '', 'Modification', 'John'),
(6, '2024-06-10', 3000.00, '', 'Tyres', 'John'),
(8, '2024-06-10', 3000.00, '', 'Audio', 'John'),
(9, '2024-06-11', 200.00, '', 'Air Conds', 'Megan'),
(10, '2024-06-12', 500.00, 'Credit Card', 'Car Battery', 'Jane'),
(11, '2024-06-17', 3000.00, 'Credit Card', 'Engines', 'Bryan'),
(12, '2024-05-01', 20.00, 'Cash', 'Engines', 'John'),
(13, '2024-05-09', 3000.00, 'Credit Card', 'Engines', 'Megandasas');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `expensesid` int(11) NOT NULL,
  `date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`expensesid`, `date`, `amount`, `description`) VALUES
(1, '2024-06-01', 500.00, 'Rent'),
(2, '2024-06-05', 200.00, 'Utilities'),
(3, '2024-06-10', 1500.00, 'Payroll'),
(4, '2024-06-15', 300.00, 'Parts'),
(5, '2024-06-20', 100.00, 'External Fees'),
(6, '2024-06-10', 20.00, 'Utilities'),
(7, '2024-06-11', 30.00, 'External Fees'),
(8, '2024-06-12', 5000.00, 'Parts');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedbackid` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `problem_description` text NOT NULL,
  `admin_response` text DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedbackid`, `username`, `user_email`, `problem_description`, `admin_response`, `timestamp`) VALUES
(32, 'Mechanic 1', 'mec1@gmail.com', 'dsasasda', 'dassdadas', '2024-06-21 01:41:42'),
(34, 'Jalen', 'j@gmail.com', 'I services are great but its a little bit expensive', 'Thanks for the feedback, we will work on it.', '2024-06-21 15:10:56');

-- --------------------------------------------------------

--
-- Table structure for table `mechanicinfo`
--

CREATE TABLE `mechanicinfo` (
  `mecid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(500) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `mecpassword` varchar(20) NOT NULL,
  `mecpic` varchar(500) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mechanicinfo`
--

INSERT INTO `mechanicinfo` (`mecid`, `name`, `email`, `telephone`, `mecpassword`, `mecpic`, `status`) VALUES
(1, 'Mechanic 1', 'mec1@gmail.com', '123456', '123', 'pfp/kisspng-petronas-dagangan-berhad-logo-organization-company-conference-vector-5ad86d8fd18868.8423139615241332638583.png', 'Offline now');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `msg_id` int(11) NOT NULL,
  `incoming_msg_id` varchar(255) NOT NULL,
  `outgoing_msg_id` varchar(255) NOT NULL,
  `msg` varchar(1000) NOT NULL,
  `status` enum('read','unread') DEFAULT 'unread'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`msg_id`, `incoming_msg_id`, `outgoing_msg_id`, `msg`, `status`) VALUES
(312, 'mec1@gmail.com', 'j@gmail.com', 'Hi', 'read'),
(313, 'mec1@gmail.com', 'j@gmail.com', 'When will my car be ready?', 'read'),
(314, 'j@gmail.com', 'mec1@gmail.com', 'Hi', 'read'),
(315, 'j@gmail.com', 'mec1@gmail.com', 'It will be ready by next Tuesday', 'read'),
(316, 'j@gmail.com', 'mec1@gmail.com', 'Thanks for asking😊', 'read');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `post` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(11) NOT NULL,
  `seen` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `subject`, `post`, `content`, `time`, `user_id`, `seen`) VALUES
(32, 'dadsa', '', 'dadsa', '2024-06-21 09:12:29', 0, 1),
(33, 'dsaasd', '', 'dsaasd', '2024-06-21 09:12:29', 0, 1),
(34, 'dsaasd', '', 'dasasd', '2024-06-21 09:12:29', 0, 1),
(35, 'dsadsa', '', 'dasdsa', '2024-06-21 09:12:29', 0, 1),
(36, 'dasasd', '', 'dsadsads', '2024-06-21 09:12:29', 0, 1),
(37, 'dsadsadsa', '', 'dasdsadsa', '2024-06-21 09:12:29', 0, 1),
(38, 'dsasda', '', 'dasdsa', '2024-06-21 09:13:10', 0, 1),
(39, 'dsadsa', '', 'dasdsadsa', '2024-06-21 09:14:09', 0, 1),
(40, 'dsa', '', 'dsaasd', '2024-06-21 09:35:34', 0, 1),
(41, 'dsa', '', 'dsadsads', '2024-06-21 09:36:19', 0, 1),
(42, 'dsaasd', '', 'dasdsaasd', '2024-06-21 10:53:51', 0, 1),
(43, 'Monday Public Holiday!', '', 'On this day, our shop AutoMate will be closed on this day as worker need rest on public holiday. dsdsss asd sadd asdsandaklask dsaas dshaj hsadh haskhd dywasdh jki dajjsduauwhkadj uhwj asidhwi  ioadiihdau ydushjwba sdj uih wah dkahsid hu awudhahdhwna uuh', '2024-06-21 11:22:07', 0, 1),
(44, 'Hey', '', 'dsad ASas dsaD sad a dsA asd a Ddwas DAED wASDC AD asd ASD AF Dwf DSVSDVGBSD FZSD AASDsd adcASvc csc sf sDFfew SDfsa fS FS', '2024-06-21 12:11:24', 0, 1),
(45, 'dasasd', '', 'dsasdaasd', '2024-06-21 12:21:08', 0, 1),
(46, 'Please Support Us', 'notification-media/Screenshot 2023-03-28 122350.png', 'dsaasd', '2024-06-21 15:50:06', 0, 1),
(47, 'Happy Haji', 'notification-media/forgorvid.mp4', 'dasdsaasd', '2024-06-21 15:50:06', 0, 1),
(48, 'Shop Close', 'notification-media/carservice.png', 'On this day, our shop AutoMate will be closed on this day as worker need rest on public holiday. dsdsss asd sadd asdsandaklask dsaas dshaj hsadh haskhd dywasdh jki dajjsduauwhkadj uhwj asidhwi ioadiihdau ydushjwba sdj uih wah dkahsid hu awudhahdhwna uuh', '2024-06-21 15:50:06', 0, 1),
(49, 'Hey', 'notification-media/carbattery.png', 'dsaasd', '2024-06-21 16:21:28', 0, 0),
(50, 'dsa', NULL, 'dsa', '2024-06-21 16:24:34', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `partsid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) DEFAULT 'shipping'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`partsid`, `name`, `price`, `quantity`, `total_price`, `order_date`, `status`) VALUES
(20, 'Suspension', 500.00, 6, 3000.00, '2024-06-11 22:24:32', 'Received'),
(21, 'Head Lights', 1000.00, 1, 1000.00, '2024-06-11 22:25:51', 'Received'),
(22, 'Head Lights', 1000.00, 1, 1000.00, '2024-06-11 22:26:20', 'Received'),
(23, 'Head Lights', 1000.00, 9, 9000.00, '2024-06-12 03:30:39', 'Received'),
(24, 'Suspension', 500.00, 9, 4500.00, '2024-06-12 03:55:24', 'Received'),
(25, 'Head Lights', 1000.00, 1, 1000.00, '2024-06-12 14:32:05', 'Received'),
(26, 'Head Lights', 1000.00, 1, 1000.00, '2024-06-12 14:32:28', 'Received'),
(27, 'Tyre Rim', 350.00, 1, 350.00, '2024-06-12 14:32:28', 'Received'),
(28, 'Engine Air Filters', 200.00, 1, 200.00, '2024-06-12 14:32:28', 'Received'),
(29, 'Break Pads', 1500.00, 1, 1500.00, '2024-06-12 14:32:28', 'Received'),
(30, 'Suspension', 500.00, 1, 500.00, '2024-06-12 14:32:28', 'Received'),
(31, 'Head Lights', 1000.00, 1, 1000.00, '2024-06-12 14:35:33', 'Received'),
(32, 'Suspension', 500.00, 11, 5500.00, '2024-06-12 15:44:34', 'Received'),
(33, 'Head Lights', 1000.00, 6, 6000.00, '2024-06-12 15:44:34', 'Received'),
(34, 'Suspension', 500.00, 6, 3000.00, '2024-06-12 16:09:49', 'Received'),
(35, 'Head Lights', 1000.00, 6, 6000.00, '2024-06-12 16:09:49', 'Received'),
(36, 'Head Lights', 1000.00, 6, 6000.00, '2024-06-13 10:29:22', 'Received'),
(37, 'Suspension', 500.00, 9, 4500.00, '2024-06-17 07:53:50', 'Received'),
(38, 'Mirrors', 240.00, 6, 1440.00, '2024-06-20 03:42:35', 'Shipping'),
(39, 'Batteries', 1200.00, 1, 1200.00, '2024-06-20 03:42:35', 'Shipping'),
(40, 'Windshield Wiper', 60.00, 1, 60.00, '2024-06-20 03:42:35', 'Shipping'),
(41, 'Suspension', 500.00, 1, 500.00, '2024-06-20 14:26:17', 'Shipping'),
(42, 'Engine Air Filters', 200.00, 1, 200.00, '2024-06-20 14:26:17', 'Received');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `paymentid` int(11) NOT NULL,
  `date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `method` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL,
  `customer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`paymentid`, `date`, `amount`, `method`, `status`, `customer`) VALUES
(1, '2024-06-01', 200.00, 'Cash', 'paid', 'Bryan'),
(2, '2024-06-05', 150.00, 'Credit Card', 'pending', ' Jason'),
(3, '2024-06-10', 300.00, 'Online Payments', 'paid', 'Lim Jun Yang'),
(4, '2024-06-15', 250.00, 'Cash', 'paid', 'Janice'),
(5, '2024-06-20', 400.00, 'Credit Card', 'pending', 'John');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `postsid` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_role` enum('customer','mechanic','admin') NOT NULL,
  `content` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `media_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `userinfo`
--

CREATE TABLE `userinfo` (
  `userid` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(500) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `user_password` varchar(20) NOT NULL,
  `userpic` varchar(500) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userinfo`
--

INSERT INTO `userinfo` (`userid`, `username`, `email`, `telephone`, `user_password`, `userpic`, `status`) VALUES
(5, 'Jalen', 'j@gmail.com', '0123456', '123', 'pfp/olli-the-polite-cat.webp', 'Active now'),
(7, 'Lim', 'l@gmail.com', '12345', '123', 'pfp/padoru_mai-removebg-preview.png', 'Offline now'),
(15, 'Bryan', 'bryanlowzy25@gmail.com', '0123456', '123', 'pfp/userimage.png', 'Active now');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admininfo`
--
ALTER TABLE `admininfo`
  ADD PRIMARY KEY (`adminid`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`bookingid`);

--
-- Indexes for table `codes`
--
ALTER TABLE `codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `code` (`code`),
  ADD KEY `expire` (`expire`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`commentsid`);

--
-- Indexes for table `earnings`
--
ALTER TABLE `earnings`
  ADD PRIMARY KEY (`earningid`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`expensesid`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedbackid`);

--
-- Indexes for table `mechanicinfo`
--
ALTER TABLE `mechanicinfo`
  ADD PRIMARY KEY (`mecid`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`msg_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`partsid`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`paymentid`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`postsid`);

--
-- Indexes for table `userinfo`
--
ALTER TABLE `userinfo`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admininfo`
--
ALTER TABLE `admininfo`
  MODIFY `adminid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `bookingid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `codes`
--
ALTER TABLE `codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `commentsid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `earnings`
--
ALTER TABLE `earnings`
  MODIFY `earningid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `expensesid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedbackid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `mechanicinfo`
--
ALTER TABLE `mechanicinfo`
  MODIFY `mecid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=318;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `partsid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `paymentid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `postsid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `userinfo`
--
ALTER TABLE `userinfo`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
