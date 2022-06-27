-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2022 at 03:51 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mogetest2`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_getAbsentAtd` (IN `pm` FLOAT, IN `ci` CHAR(10), IN `lim` INT)  BEGIN
	select p.class_id, p.ptc_id, p.ptc_name, count(*) as total_absent 
	from v_attendance v, 
	participant p 
	where v.ptc_id=p.ptc_id and (percent_meeting<pm or percent_meeting is null) and p.class_id=ci
	group by p.class_id, p.ptc_id, p.ptc_name
	order by count(*) desc, p.ptc_name
    LIMIT lim;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_getAtdMeeting` (IN `pm` FLOAT, IN `jt` FLOAT, IN `cs` CHAR(10))  BEGIN
SELECT DISTINCT a.MEETING_ID, a.PTC_ID, p.PTC_NAME, func_statusAtd(a.join_time, a.percent_meeting,pm,jt) as status
FROM `v_attendance` a,
participant p
WHERE a.ptc_id =p.ptc_id and p.CLASS_ID=cs;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_getAvgAtd` (IN `pm` FLOAT, IN `ci` CHAR(10))  BEGIN
	select avg(a.ptc_total) as averageAtd from (
    select a.class_id, meeting_id, count(ptc_id)/sb.registered as ptc_total from v_attendance a, 
    (select class_id, count(ptc_id) as registered 
    from participant where class_id=ci group by class_id) as sb where  a.class_id=sb.class_id and a.percent_meeting>=pm group by class_id, meeting_id, sb.registered) as a;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_getAvgAtdById` (IN `ci` CHAR(10), IN `pi` CHAR(10), IN `pm` FLOAT)  BEGIN
select COUNT(PTC_ID)/(
    SELECT COUNT(*)
    FROM v_attendance 
    WHERE PTC_ID=pi) 
    AS averageAtd 
    FROM v_attendance 
    WHERE percent_meeting>=pm and ptc_id=pi and class_id=ci;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_getCountDetailJoinLeave` (IN `ci` CHAR(10), IN `pi` CHAR(10))  BEGIN
	
select m.meeting_id, COUNT(a.ATD_ID) as total from attendance a join meeting m where m.MEETING_ID=a.MEETING_ID AND m.class_id=ci and a.PTC_ID=pi GROUP BY m.MEETING_ID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_getDetailAtd` (IN `ci` CHAR(10), IN `pi` CHAR(10))  BEGIN
select m.meeting_id, m.start_time, m.end_time, a.ptc_id, a.join_time, a.leave_time from meeting m join attendance a where a.meeting_id=m.meeting_id and m.class_id=ci and a.ptc_id=pi order by join_time, meeting_id ASC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_getDiagramData` (IN `pm` FLOAT, IN `jt` INT, IN `ci` CHAR(10))  BEGIN
SELECT 'in time' as label, class_id, count(ptc_id) as total FROM `v_attendance` where class_id=ci and percent_meeting>pm and join_time<=jt GROUP BY class_id union 
SELECT 'late' as label, class_id, count(ptc_id) as total FROM `v_attendance` where class_id=ci and percent_meeting>=pm and join_time>jt GROUP BY class_id union
SELECT 'absent' as label, class_id, count(ptc_id) as total FROM `v_attendance` where class_id=ci and percent_meeting<pm GROUP BY class_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_getEvaluation` (IN `pm` FLOAT, IN `ci` CHAR(10))  BEGIN
select a.ptc_email, a.ptc_name,  COUNT(a.PTC_ID)/(
SELECT COUNT(*)
FROM v_attendance WHERE PTC_ID=a.PTC_ID)  AS averageAtd   from participant a, v_attendance b where a.PTC_ID=b.ptc_id
and percent_meeting>=pm and a.class_id=ci GROUP BY a.ptc_email, a.ptc_name;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_getInTimeAtd` (IN `pm` FLOAT, IN `jt` INT, IN `ci` CHAR(10), IN `lim` INT)  BEGIN
select p.class_id, p.ptc_id, p.ptc_name, count(v.percent_meeting) as total_present 
	from v_attendance v, 
	participant p 
	where v.ptc_id=p.ptc_id and percent_meeting>=pm and join_time<=jt and p.class_id=ci
	group by p.class_id, p.ptc_id, p.ptc_name
	order by count(v.percent_meeting) desc, p.ptc_name
    LIMIT lim;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_getJoinLeave` ()  BEGIN
select a.PTC_ID, ptc_name, COUNT(JOIN_TIME) as join_times 
from attendance a,
participant p 
WHERE a. PTC_ID=p.PTC_ID
GROUP BY PTC_ID, ptc_name ORDER BY COUNT(JOIN_TIME) DESC LIMIT 5;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_getLateAtd` (IN `pm` FLOAT, IN `jt` INT, IN `ci` CHAR(10), IN `lim` INT)  BEGIN
	SELECT v.PTC_ID, v.class_id ,SUM(join_time) as late, ptc_name 
    FROM `v_attendance` v, participant p 
    WHERE v.ptc_id=p.ptc_id and join_time>jt and percent_meeting>=pm and p.class_id=ci
    GROUP BY PTC_ID, class_id 
    ORDER BY sum(join_time) 
    DESC Limit lim;
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `func_statusAtd` (`join_time` FLOAT, `percent_meeting` FLOAT, `pm` FLOAT, `jt` FLOAT) RETURNS INT(1) BEGIN
    DECLARE status INT(1);

    IF (join_time<=jt AND percent_meeting>=pm)  THEN
		SET status= 1;
    ELSEIF (join_time>jt AND percent_meeting>=pm) THEN
        SET status= 2;
    ELSEIF percent_meeting<pm THEN
        SET status= 0;
    END IF;
	RETURN (status);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `MEETING_ID` int(10) UNSIGNED ZEROFILL NOT NULL,
  `PTC_ID` int(10) UNSIGNED ZEROFILL NOT NULL,
  `ATD_ID` int(10) UNSIGNED ZEROFILL NOT NULL,
  `JOIN_TIME` timestamp NULL DEFAULT NULL,
  `LEAVE_TIME` timestamp NULL DEFAULT NULL,
  `DATE` date DEFAULT NULL,
  `DURATION` decimal(10,5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`MEETING_ID`, `PTC_ID`, `ATD_ID`, `JOIN_TIME`, `LEAVE_TIME`, `DATE`, `DURATION`) VALUES
(0000000023, 0000000021, 0000000121, '2022-06-17 01:44:31', '2022-06-17 01:52:50', '2022-06-17', '8.00000'),
(0000000023, 0000000022, 0000000122, '2022-06-17 01:44:55', '2022-06-17 01:52:50', '2022-06-17', '7.00000'),
(0000000025, 0000000021, 0000000125, '2022-06-17 03:41:35', '2022-06-17 03:48:49', '2022-06-17', '7.00000'),
(0000000025, 0000000022, 0000000126, '2022-06-17 03:42:56', '2022-06-17 03:48:03', '2022-06-17', '5.00000'),
(0000000034, 0000000021, 0000000144, '2022-06-19 15:01:28', '2022-06-19 15:16:50', '2022-06-19', '15.00000'),
(0000000034, 0000000022, 0000000143, '2022-06-19 15:01:18', '2022-06-19 15:16:50', '2022-06-19', '15.00000');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `CLASS_ID` int(10) UNSIGNED ZEROFILL NOT NULL,
  `USER_ID` int(10) UNSIGNED ZEROFILL NOT NULL,
  `TITLE_CLASS` varchar(255) NOT NULL,
  `DETAIL_CLASS` varchar(255) DEFAULT NULL,
  `ROOM` varchar(255) DEFAULT NULL,
  `NUM_MEETINGS` int(10) NOT NULL,
  `COLOR` varchar(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`CLASS_ID`, `USER_ID`, `TITLE_CLASS`, `DETAIL_CLASS`, `ROOM`, `NUM_MEETINGS`, `COLOR`) VALUES
(0000000003, 0000000002, 'Proyek 8', 'Tugas Akhir JTK', '3B', 16, 'BDE6F1'),
(0000000005, 0000000002, 'Citra Digital', '3A JTK', '2B', 16, '53BF9D'),
(0000000011, 0000000002, 'PRPL', 'JTK 2018', '2A', 16, 'BDE6F1');

-- --------------------------------------------------------

--
-- Table structure for table `meeting`
--

CREATE TABLE `meeting` (
  `MEETING_ID` int(10) UNSIGNED ZEROFILL NOT NULL,
  `CLASS_ID` int(10) UNSIGNED ZEROFILL NOT NULL,
  `DATE` date DEFAULT NULL,
  `START_TIME` timestamp NULL DEFAULT NULL,
  `END_TIME` timestamp NULL DEFAULT NULL,
  `DURATION` decimal(10,5) DEFAULT NULL,
  `MEETING_ORDER` varchar(10) DEFAULT NULL,
  `UUID` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `meeting`
--

INSERT INTO `meeting` (`MEETING_ID`, `CLASS_ID`, `DATE`, `START_TIME`, `END_TIME`, `DURATION`, `MEETING_ORDER`, `UUID`) VALUES
(0000000023, 0000000003, '2022-06-17', '2022-06-17 01:43:37', '2022-06-17 01:52:50', '9.21667', '1', '87833490239'),
(0000000025, 0000000003, '2022-06-17', '2022-06-17 03:40:13', '2022-06-17 03:48:03', '7.83333', '2', '83995691086'),
(0000000034, 0000000003, '2022-06-19', '2022-06-19 15:00:40', '2022-06-19 15:16:50', '16.16667', '3', '84835285547');

-- --------------------------------------------------------

--
-- Table structure for table `participant`
--

CREATE TABLE `participant` (
  `PTC_ID` int(10) UNSIGNED ZEROFILL NOT NULL,
  `CLASS_ID` int(10) UNSIGNED ZEROFILL NOT NULL,
  `PTC_EMAIL` varchar(255) NOT NULL,
  `PTC_NAME` varchar(255) NOT NULL,
  `ZOOM_ID` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `participant`
--

INSERT INTO `participant` (`PTC_ID`, `CLASS_ID`, `PTC_EMAIL`, `PTC_NAME`, `ZOOM_ID`) VALUES
(0000000021, 0000000003, 'rahmaaghniya@gmail.com', 'D3_02_Aghniya Rahma Yudha', 'itJDIZTKSOaAjbrsFA6RnA'),
(0000000022, 0000000003, 'resvi30@gmail.com', 'Resvi Widiana', '21vVTonXSVuA9DnnR8GRvw'),
(0000000040, 0000000005, 'juanisata@mapa.com', 'Juanisa', 'hjahjsbdc092jjn'),
(0000000042, 0000000005, 'Marya@haja.com', 'Marya', 'sjhga7ahas'),
(0000000044, 0000000005, 'basu@malx.com', 'Pirya', 'kjbuaej9810k2lw');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `USER_ID` int(10) UNSIGNED ZEROFILL NOT NULL,
  `EMAIL` varchar(255) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `FIRST_NAME` varchar(255) DEFAULT NULL,
  `LAST_NAME` varchar(255) DEFAULT NULL,
  `ACCESS_TOKEN` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`USER_ID`, `EMAIL`, `PASSWORD`, `FIRST_NAME`, `LAST_NAME`, `ACCESS_TOKEN`) VALUES
(0000000002, 'rahmaaghniya@gmail.com', '1234yudha', 'aghniya', 'rahma', 'eyJhbGciOiJIUzUxMiIsInYiOiIyLjAiLCJraWQiOiJlMjNhOWIxNy00OTNmLTRhNDAtYjY5Ny1lYTNkMTRmMTQ3NmIifQ.eyJ2ZXIiOjcsImF1aWQiOiI4MjM3YTFjMGM2ZjcwMGI4YTk0M2RhOTkzZDEyMjVmZSIsImNvZGUiOiJZcXpINThkRG9uXzlZVlVGT1hNVDZLeXk2d20tV0NrU1EiLCJpc3MiOiJ6bTpjaWQ6OVpYRXpGM0dSbjJSTXpqdU54akw3ZyIsImdubyI6MCwidHlwZSI6MCwidGlkIjowLCJhdWQiOiJodHRwczovL29hdXRoLnpvb20udXMiLCJ1aWQiOiI5WVZVRk9YTVQ2S3l5NndtLVdDa1NRIiwibmJmIjoxNjU1NjgxOTA1LCJleHAiOjE2NTU2ODU1MDUsImlhdCI6MTY1NTY4MTkwNSwiYWlkIjoiYVQxVmM0blhSNzZmb2o3d0ZubXM5USIsImp0aSI6IjEwNmRkN2RhLTNlNDYtNDY4ZC05OGUxLTM3YTdlZjA3OWQ0YyJ9.5Pxgzd7il8-bP18KBiF6wn662rzG6sYp1W0JgR85tXj4BKSbA9P-HK6fjwDVBiGXGYVZVemo_tMYsr0pogBUjQ');

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_attendance`
-- (See below for the actual view)
--
CREATE TABLE `v_attendance` (
`MEETING_ID` int(10) unsigned zerofill
,`ptc_id` int(10) unsigned zerofill
,`class_id` int(10) unsigned zerofill
,`durations` decimal(32,5)
,`meeting_duration` decimal(10,5)
,`percent_meeting` decimal(41,9)
,`join_time` decimal(19,4)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_avg_atd`
-- (See below for the actual view)
--
CREATE TABLE `v_avg_atd` (
`class_id` int(10) unsigned zerofill
,`meeting_id` int(10) unsigned zerofill
,`ptc_total` decimal(24,4)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_present`
-- (See below for the actual view)
--
CREATE TABLE `v_present` (
`ptc_id` int(10) unsigned zerofill
,`ptc_name` varchar(255)
,`total_present` bigint(21)
);

-- --------------------------------------------------------

--
-- Structure for view `v_attendance`
--
DROP TABLE IF EXISTS `v_attendance`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_attendance`  AS  select `m`.`MEETING_ID` AS `MEETING_ID`,`p`.`PTC_ID` AS `ptc_id`,`m`.`CLASS_ID` AS `class_id`,sum(`a`.`DURATION`) AS `durations`,`m`.`DURATION` AS `meeting_duration`,sum(`a`.`DURATION`) / `m`.`DURATION` AS `percent_meeting`,(min(`a`.`JOIN_TIME`) - `m`.`START_TIME`) / 100 AS `join_time` from ((`meeting` `m` join `participant` `p` on(`m`.`CLASS_ID` = `p`.`CLASS_ID`)) left join `attendance` `a` on(`p`.`PTC_ID` = `a`.`PTC_ID` and `m`.`MEETING_ID` = `a`.`MEETING_ID`)) group by `m`.`MEETING_ID`,`p`.`PTC_ID` ;

-- --------------------------------------------------------

--
-- Structure for view `v_avg_atd`
--
DROP TABLE IF EXISTS `v_avg_atd`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_avg_atd`  AS  select `a`.`class_id` AS `class_id`,`a`.`MEETING_ID` AS `meeting_id`,count(`a`.`ptc_id`) / `sb`.`registered` AS `ptc_total` from (`v_attendance` `a` join (select `participant`.`CLASS_ID` AS `class_id`,count(`participant`.`PTC_ID`) AS `registered` from `participant` group by `participant`.`CLASS_ID`) `sb`) where `a`.`class_id` = `sb`.`class_id` and `a`.`percent_meeting` >= 0.8 and `a`.`join_time` <= 15 group by `a`.`class_id`,`a`.`MEETING_ID`,`sb`.`registered` ;

-- --------------------------------------------------------

--
-- Structure for view `v_present`
--
DROP TABLE IF EXISTS `v_present`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_present`  AS  select `p`.`PTC_ID` AS `ptc_id`,`p`.`PTC_NAME` AS `ptc_name`,count(`v`.`percent_meeting`) AS `total_present` from (`v_attendance` `v` join `participant` `p`) where `v`.`ptc_id` = `p`.`PTC_ID` and `v`.`percent_meeting` >= 0.8 and `v`.`join_time` <= 15 group by `p`.`PTC_ID`,`p`.`PTC_NAME` order by count(`v`.`percent_meeting`) desc,`p`.`PTC_NAME` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`MEETING_ID`,`PTC_ID`,`ATD_ID`),
  ADD KEY `ATD_ID` (`ATD_ID`),
  ADD KEY `FK_MENGHADIRI2` (`PTC_ID`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`CLASS_ID`),
  ADD KEY `FK_USERTOCLASS` (`USER_ID`);

--
-- Indexes for table `meeting`
--
ALTER TABLE `meeting`
  ADD PRIMARY KEY (`MEETING_ID`),
  ADD KEY `FK_CLASSTOMEETING` (`CLASS_ID`);

--
-- Indexes for table `participant`
--
ALTER TABLE `participant`
  ADD PRIMARY KEY (`PTC_ID`),
  ADD UNIQUE KEY `ZOOM_ID` (`ZOOM_ID`),
  ADD KEY `FK_CLASSTOPARTICIPANT` (`CLASS_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`USER_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `ATD_ID` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `CLASS_ID` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `meeting`
--
ALTER TABLE `meeting`
  MODIFY `MEETING_ID` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `participant`
--
ALTER TABLE `participant`
  MODIFY `PTC_ID` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `USER_ID` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `FK_ATTENDANCETOMEETING` FOREIGN KEY (`MEETING_ID`) REFERENCES `meeting` (`MEETING_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_MENGHADIRI2` FOREIGN KEY (`PTC_ID`) REFERENCES `participant` (`PTC_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `class`
--
ALTER TABLE `class`
  ADD CONSTRAINT `FK_USERTOCLASS` FOREIGN KEY (`USER_ID`) REFERENCES `users` (`USER_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `meeting`
--
ALTER TABLE `meeting`
  ADD CONSTRAINT `FK_CLASSTOMEETING` FOREIGN KEY (`CLASS_ID`) REFERENCES `class` (`CLASS_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `participant`
--
ALTER TABLE `participant`
  ADD CONSTRAINT `FK_CLASSTOPARTICIPANT` FOREIGN KEY (`CLASS_ID`) REFERENCES `class` (`CLASS_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
