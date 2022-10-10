-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 24, 2022 at 07:50 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `report`
--

-- --------------------------------------------------------

--
-- Table structure for table `answer`
--

CREATE TABLE `answer` (
  `id` int(10) NOT NULL,
  `question_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `body` longtext COLLATE utf8mb4_persian_ci NOT NULL,
  `date` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Dumping data for table `answer`
--

INSERT INTO `answer` (`id`, `question_id`, `user_id`, `body`, `date`) VALUES
(1, 7, 2, 'جواب تستی برای سوال با id=7\r\n ', 1663751448),
(2, 1, 2, 'ddddddddd', 1663995009),
(3, 1, 2, 'aaaaaaaaaaaaaaaaaaaa', 1663995015),
(4, 1, 2, 'aaaaaaaaaaaaaaaaaaaa', 1663995046),
(5, 2, 2, 'پاسخ 1\r\n\r\n\r\n', 1663995166),
(6, 2, 2, 'پاسخ 2\r\n', 1663995179),
(7, 2, 2, 'سومین پاسخ', 1663995188),
(8, 2, 3, 'جواب تستی از رضا', 1663997534);

-- --------------------------------------------------------

--
-- Table structure for table `archive`
--

CREATE TABLE `archive` (
  `id` int(11) NOT NULL,
  `type` varchar(256) COLLATE utf8mb4_persian_ci NOT NULL,
  `file_name` varchar(256) COLLATE utf8mb4_persian_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Dumping data for table `archive`
--

INSERT INTO `archive` (`id`, `type`, `file_name`, `description`) VALUES
(10, 'interview', '448109892073284298358041DFD0.docx', 'sss'),
(11, 'Contract', '440862655166Screenshot (84).png', 'توضیح');

-- --------------------------------------------------------

--
-- Table structure for table `letter`
--

CREATE TABLE `letter` (
  `id` int(11) NOT NULL,
  `type` varchar(560) COLLATE utf8mb4_persian_ci NOT NULL,
  `recipient` varchar(256) COLLATE utf8mb4_persian_ci NOT NULL,
  `title` varchar(256) COLLATE utf8mb4_persian_ci NOT NULL,
  `body` longtext COLLATE utf8mb4_persian_ci NOT NULL,
  `annex` varchar(560) COLLATE utf8mb4_persian_ci DEFAULT NULL,
  `date` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Dumping data for table `letter`
--

INSERT INTO `letter` (`id`, `type`, `recipient`, `title`, `body`, `annex`, `date`) VALUES
(1, '1', 'ثثث', 'ث', 'ث', '335', 1663128535),
(2, '1', 'ریاست محترم امور مالی شهرداری ', 'درخواست همکاری', 'باسلام \r\n\r\nاحتراما پیرو آگهی استخدام آن شرکت در … مورخ … جهت همکاری در بخش … در آن شرکت، به پیوست رزومه اینجانب … را جهت استحضار آن مدیریت محترم و اعلام آمادگی اینجانب جهت همکاری تقدیم می دارم.\r\n\r\nامیدوارم سوابق شغلی و تحصیلات اینجانب، تسلط کامل به زبان …، داشتن مهارت های ارتباطی بالا، روحیه تیمی، اعتماد به نفس، شوق به یادگیری مداوم و به روز کردن اطلاعات شغلی مورد توجه شما واقع شده و برایم فرصتی را فراهم سازد تا بتوانم با همکاری با آن شرکت، خواسته ها و خدمات مورد نیاز شرکت را برآورده سازم.\r\n\r\nضمن آرزوی توفیق روزافزون برای جنابعالی، پیشاپیش از اینکه وقتتان را برای بررسی رزومه من در اختصاص می دهید تشکر فراوان داشته و آمادگی خود را جهت حضور در آن شرکت برای مصاحبه حضوری اعلام می دارم.\r\n\r\nبا تشکر\r\n\r\nنام و نام خانوادگی و امضاء متقاضی', '656', 1663132172);

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `id` int(10) NOT NULL,
  `title` varchar(500) COLLATE utf8mb4_persian_ci NOT NULL,
  `body` longtext COLLATE utf8mb4_persian_ci NOT NULL,
  `user_id` int(10) NOT NULL,
  `category` varchar(50) COLLATE utf8mb4_persian_ci NOT NULL,
  `Priority` int(3) NOT NULL,
  `file_name` varchar(200) COLLATE utf8mb4_persian_ci DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0,
  `date` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`id`, `title`, `body`, `user_id`, `category`, `Priority`, `file_name`, `status`, `date`) VALUES
(1, '۱', '۱۱', 2, 'اداری', 1, '59498887Screenshot (8).png', 1, 1663750018),
(2, 'سوال تستی 1', 'متن سوال تستی ۱', 2, 'اداری', 3, '23188768Screenshot (15).png', 0, 1663650018),
(3, 'q', 'q', 3, 'اداری', 1, '95261352Screenshot (14).png', 1, 1663720018),
(4, 'f', 'f', 2, 'اداری', 1, NULL, 0, 1663750018),
(5, 'w', 'w', 2, 'اداری', 1, NULL, 0, 1663759518),
(6, 'w', 'ddd', 3, 'اداری', 4, '94269883Screenshot (80).png', 0, 1663750018),
(7, '1234456', 'kjjhakbaf;udvhav', 2, 'اداری', 1, NULL, 0, 1663750018);

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` varchar(10) COLLATE utf8mb4_persian_ci NOT NULL,
  `time_start` varchar(10) COLLATE utf8mb4_persian_ci NOT NULL,
  `time_end` varchar(10) COLLATE utf8mb4_persian_ci NOT NULL,
  `time_teach` varchar(10) COLLATE utf8mb4_persian_ci NOT NULL,
  `description` text COLLATE utf8mb4_persian_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`id`, `user_id`, `date`, `time_start`, `time_end`, `time_teach`, `description`) VALUES
(1, 1, '22', '09:04', '13:00', '03:00', NULL),
(2, 1, '22-09-06', '09:04', '13:00', '03:00', NULL),
(3, 1, '22-09-06', '09:04', '13:00', '03:00', NULL),
(4, 1, '22-09-06', '09:04', '13:00', '03:00', NULL),
(5, 1, '22-09-06', '09:04', '13:00', '03:00', NULL),
(6, 1, '22-09-06', '09:04', '13:00', '03:00', NULL),
(7, 1, '22-09-06', '04:00', '', '', NULL),
(8, 1, '22-09-06', '', '00:03', '', NULL),
(9, 1, '22-09-06', '04:00', '', '', NULL),
(10, 1, '22-09-06', '', '00:03', '', NULL),
(11, 1, '22-09-06', '04:00', '', '', NULL),
(12, 1, '22-09-06', '', '00:03', '', NULL),
(13, 1, '22-09-06', '04:00', '', '', NULL),
(14, 1, '22-09-06', '', '00:03', '', NULL),
(23, 1, '22-09-07', '00:03', '00:03', '00:02', '1'),
(24, 1, '22-09-07', '08:00', '02:00', '03:00', 'تمرین php'),
(25, 1, '22-09-07', '00:03', '00:03', '00:03', '000'),
(26, 1, '22-09-07', '00:03', '00:02', '00:02', 'ddd'),
(27, 1, '22-09-07', '00:03', '00:03', '00:02', 's'),
(28, 1, '22-09-07', '00:00', '00:00', '00:00', '111'),
(29, 1, '22-09-07', '00:02', '00:02', '00:00', 'qqq'),
(30, 2, '22-09-10', '00:09', '06:00', '00:00', 'df.ndl'),
(31, 2, '22-09-13', '00:08', '00:09', '07:00', 'کار خاصی انجام ندادم');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(20) NOT NULL,
  `username` varchar(156) COLLATE utf8mb4_persian_ci NOT NULL,
  `password` varchar(156) COLLATE utf8mb4_persian_ci NOT NULL,
  `first_name` varchar(256) COLLATE utf8mb4_persian_ci NOT NULL,
  `last_name` varchar(256) COLLATE utf8mb4_persian_ci NOT NULL,
  `gender` int(1) NOT NULL COMMENT '0=man;1=woman\r\n',
  `admin` int(2) DEFAULT 0 COMMENT '1=isadmin\r\n0=isnotadmin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `first_name`, `last_name`, `gender`, `admin`) VALUES
(1, '1250662310', '202cb962ac59075b964b07152d234b70', 'علی', 'علوی', 0, 0),
(2, '1250662311', '202cb962ac59075b964b07152d234b70', 'محمدرضا', 'همایونی', 0, 1),
(3, '1250662312', '202cb962ac59075b964b07152d234b70', 'رضا', 'رضوی', 0, 0),
(4, '1250662313', '202cb962ac59075b964b07152d234b70', 'محمد', 'محمدی', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `vacation`
--

CREATE TABLE `vacation` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` varchar(10) COLLATE utf8mb4_persian_ci NOT NULL,
  `type` varchar(110) COLLATE utf8mb4_persian_ci NOT NULL,
  `duration` varchar(110) COLLATE utf8mb4_persian_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_persian_ci NOT NULL,
  `status` int(2) NOT NULL DEFAULT 3 COMMENT '0=under investigation\r\n1=Approved\r\n2=Rejected\r\n3=Displayed',
  `created_at` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Dumping data for table `vacation`
--

INSERT INTO `vacation` (`id`, `user_id`, `date`, `type`, `duration`, `description`, `status`, `created_at`) VALUES
(1, 2, '1401', 'hoursly', '30m', 'ddd', 1, 1663144208),
(2, 2, '1401', 'hoursly', '30m', 'dddd', 1, 1663144659),
(3, 2, '1401', 'hoursly', '30m', 'dddd', 2, 1663145018),
(4, 2, '1401', 'hoursly', '30m', 'dddd', 2, 1663145026),
(5, 2, '1401/06/23', 'hoursly', '30m', 'dddd', 2, 1663145190),
(6, 2, '1401/06/23', 'hoursly', '30m', 'dddd', 2, 1663145208),
(7, 2, '1401/06/23', 'hoursly', '30m', 'dddd', 1, 1663145265),
(8, 2, '1401/06/23', 'hoursly', '30m', 'dddd', 1, 1663145339),
(9, 2, '1401/06/23', 'daily', '1d', 'nfhvhhcjgxb gd', 1, 1663145353),
(10, 2, '1401/06/23', 'daily', '1d', 'nfhvhhcjgxb gd', 1, 1663145423),
(11, 1, '1401/06/27', 'hoursly', '1h', 'سلام خسته ام میخوام زودتر برم', 0, 1663491398),
(12, 3, '1401/06/23', 'hoursly', '1h', 'کار مهم دارم باید برم', 1, 1663491423),
(13, 1, '1401/06/23', 'hoursly', '1h', 'حالم خوب نیست', 0, 1663562066),
(14, 1, '1401/06/23', 'hoursly', '1h', 'حالم خوب نیست', 2, 1663562181),
(15, 1, '1401/06/23', 'hoursly', '1h', 'حالم خوب نیست', 0, 1663562224),
(16, 1, '1401/06/23', 'hoursly', '1h', 'کار دارم', 0, 1663562405),
(17, 2, '22/09/19', 'hoursly', '1h', 'یییی', 2, 1663566118),
(18, 1, '22/09/19', 'hoursly', '1h', 'hhhhhhhhh', 1, 1663566667);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `archive`
--
ALTER TABLE `archive`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `letter`
--
ALTER TABLE `letter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vacation`
--
ALTER TABLE `vacation`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answer`
--
ALTER TABLE `answer`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `archive`
--
ALTER TABLE `archive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `letter`
--
ALTER TABLE `letter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vacation`
--
ALTER TABLE `vacation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
