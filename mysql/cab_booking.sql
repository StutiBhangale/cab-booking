-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2021 at 08:43 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cab_booking`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `accept_booking` (IN `bid` INT, IN `did` INT)  BEGIN
DECLARE p int;
update booking set status="Accepted" where book_id=bid;
insert into view_books values(did,bid);
select pid into p from booking WHERE book_id=bid;
insert into contact values(p,did);
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getcity` ()  BEGIN
select * from passenger_addr order by city;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_payments` ()  BEGIN
SELECT SUM(amount) as overall FROM payment;
SELECT SUM(amount) as year FROM `booking`,payment WHERE year(booked_at)=year(CURRENT_DATE) and booking.book_id=payment.book_id;
SELECT SUM(amount) as month FROM `booking`,payment WHERE month(booked_at)=month(CURRENT_DATE) and booking.book_id=payment.book_id;
SELECT sum(amount) as today FROM `payment`,booking WHERE booked_at=CURRENT_DATE and payment.book_id=booking.book_id;
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `total_bookings` () RETURNS INT(11) NO SQL
    DETERMINISTIC
BEGIN
declare c int;
select count(book_id) into c from booking;
RETURN c;
end$$

CREATE DEFINER=`root`@`localhost` FUNCTION `total_drivers` () RETURNS INT(11) NO SQL
    DETERMINISTIC
BEGIN
DECLARE c int;
SELECT COUNT(did) into c from driver;
RETURN c;
end$$

CREATE DEFINER=`root`@`localhost` FUNCTION `total_feedbacks` () RETURNS INT(11) BEGIN
DECLARE c int;
SELECT count(fid) into c from feedback;
RETURN c;
end$$

CREATE DEFINER=`root`@`localhost` FUNCTION `total_passengers` () RETURNS INT(11) NO SQL
    DETERMINISTIC
BEGIN
DECLARE c int;
SELECT COUNT(pid) INTO c FROM passenger;
RETURN c;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `book_id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `pick_up` varchar(50) NOT NULL,
  `drop_loc` varchar(50) NOT NULL,
  `no_ppl` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `status` varchar(30) NOT NULL,
  `booked_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`book_id`, `pid`, `car_id`, `pick_up`, `drop_loc`, `no_ppl`, `date`, `time`, `status`, `booked_at`) VALUES
(320, 107, 1001, 'Ahmedabad', 'Amritsar', 1, '2020-12-16', '15:00:00', 'Accepted', '2020-12-06'),
(325, 107, 1002, 'Pune', 'Nashik', 2, '2020-12-24', '14:30:00', 'Accepted', '2020-12-07'),
(336, 107, 1003, 'Ahmedabad', 'Chennai', 1, '2020-12-15', '15:00:00', 'Applied', '2020-12-14'),
(338, 107, 1004, 'Delhi', 'Nashik', 1, '2020-12-17', '11:00:00', 'Applied', '2020-12-16'),
(339, 110, 1005, 'pune', 'pune', 1, '2020-12-24', '12:55:33', 'Applied', '0000-00-00'),
(342, 107, 1014, 'Aurangabad', 'Bangalore', 3, '2021-01-22', '09:30:00', 'Applied', '2021-01-08'),
(343, 107, 1010, 'Bangalore', 'Chennai', 4, '2021-01-14', '14:45:00', 'Applied', '2021-01-08'),
(344, 107, 1001, 'Aurangabad', 'Jaipur', 1, '2021-01-28', '15:00:00', 'Applied', '2021-01-08');

--
-- Triggers `booking`
--
DELIMITER $$
CREATE TRIGGER `del_payment` BEFORE DELETE ON `booking` FOR EACH ROW DELETE FROM payment where book_id=old.book_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `car_id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`car_id`, `type`, `model`) VALUES
(1001, 'Mini', 'Maruti WagonR'),
(1002, 'Mini', 'Maruti Swift'),
(1003, 'Mini', 'Tata Indica'),
(1004, 'Mini', 'Maruti Ritz'),
(1005, 'Mini', 'Nissan Micra'),
(1006, 'Sedan', 'Maruti Swift Dzire'),
(1007, 'Sedan', 'Toyota Etios'),
(1008, 'Sedan', 'Nissan Sunny'),
(1009, 'Sedan', 'Hyundai Xcent'),
(1010, 'Sedan', 'Honda City'),
(1011, 'SUV', 'Mahindra Scorpio'),
(1012, 'SUV', 'Chevrolet Enjoy'),
(1013, 'SUV', 'Chevrolet Tavera'),
(1014, 'SUV', 'Toyota Innova'),
(1015, 'SUV', 'Maruti Ertiga');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `pid` int(11) NOT NULL,
  `did` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`pid`, `did`) VALUES
(107, 201);

-- --------------------------------------------------------

--
-- Table structure for table `driver`
--

CREATE TABLE `driver` (
  `did` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `yr_exp` int(11) NOT NULL,
  `vehicle_no` varchar(20) NOT NULL,
  `vehicle_type` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `driver`
--

INSERT INTO `driver` (`did`, `username`, `password`, `fname`, `lname`, `yr_exp`, `vehicle_no`, `vehicle_type`, `created_at`) VALUES
(200, 'admin', 'admin', '', '', 0, '', '', '2020-11-21 14:41:06'),
(201, 'harry123', '$2y$10$veEpmnZCl7GKq.elxbyM2.8y.0Ji6bIPu6/CWJkH.F7QnqU3oYyju', 'Harry', '', 2, 'MH-12-GD-7560', 'Prime Sedan', '2020-11-21 15:46:00'),
(202, 'aman12', '$2y$10$TnkZDSXItTH4qFOhbfPPW.uJHnCXkrFPqx0BYI.Cx1C9ncafc/POK', 'Aman', 'Jain', 1, 'MH-12-GD-7561', 'Mini', '2020-12-14 00:40:49'),
(204, 'admin1', '$2y$10$VWFk9U38TyngL9V2ORQc..ySAgO2iopT0hFCGgzSLNvGAYWdhqrsy', 'asdf', '', 0, '', 'Mini', '2021-01-08 17:10:33');

--
-- Triggers `driver`
--
DELIMITER $$
CREATE TRIGGER `del_driver` BEFORE DELETE ON `driver` FOR EACH ROW BEGIN
DELETE FROM driver_phone WHERE did=old.did;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `driver_phone`
--

CREATE TABLE `driver_phone` (
  `did` int(11) NOT NULL,
  `phno` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `driver_phone`
--

INSERT INTO `driver_phone` (`did`, `phno`) VALUES
(201, 8788092797),
(201, 7898456512),
(202, 7896541230),
(202, 8978455623),
(202, 7946138945),
(204, 9876543210);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `fid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `rating` varchar(50) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`fid`, `pid`, `rating`, `message`) VALUES
(1000, 100, 'Good', 'Test message'),
(1003, 107, 'Excellent', 'test'),
(1005, 107, 'Good', 'nice service'),
(1006, 107, 'Good', 'Test Feedback');

-- --------------------------------------------------------

--
-- Table structure for table `passenger`
--

CREATE TABLE `passenger` (
  `pid` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fname` varchar(25) NOT NULL,
  `lname` varchar(25) NOT NULL,
  `dob` date NOT NULL,
  `zip_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `passenger`
--

INSERT INTO `passenger` (`pid`, `email`, `password`, `fname`, `lname`, `dob`, `zip_id`, `created_at`) VALUES
(100, 'admin', 'admin', '', '', '0000-00-00', 4001, '2020-11-18 00:29:03'),
(107, 'vaishnavij2000@gmail.com', '$2y$10$fOn/ML2G/7LMAVpubEPSl.JoA8qyjfUhzwVWIIgGi4lttXHbmcOOi', 'Vaishnavi', 'Jagtap', '2000-12-24', 4001, '2020-11-18 01:38:49'),
(108, 'a@b.com', '$2y$10$yEn1XYuhGC6tZ9EiGM2YSuFv3ct8tLHWvCJau/mlLTIFbsIpf7zY.', 'Neel', 'More', '0000-00-00', 4003, '2020-11-21 15:05:39'),
(109, 'tejaswinikadam2205@gmail.com', '$2y$10$l8yl1OWBGA162WM04OiLQObpVvY6QdtsrtEze4kAEGXshLJgZ9t1q', 'Tejaswini', 'Kadam', '2000-05-22', 4001, '2020-12-08 22:15:15'),
(110, 'stutibhangale@gmail.com', '$2y$10$4JfZWtNiCoWiJUP2rsrJPeBdRrj89LMJpjnzFrp9BflLMsIKDlgsC', 'Stuti', 'Bhangale', '2000-10-17', 4001, '2020-12-18 16:11:04'),
(114, 'v@j.com', '$2y$10$jExuCHoYgWvhtSe813ejMeeYHFLDUJEJn1d4aQ0.dcRhzpAsXBU5i', 'vaishu', 'jag', '2000-12-25', 4001, '2020-12-30 20:28:39'),
(115, 'svsdv@g.c', '$2y$10$/ay89p3tESEQJymTA9KflOm/vmXEBXvp8ij.4L3aDAW9Pn9J2H8Bu', 'asdf', 'Jagtap', '0000-00-00', 4003, '2020-12-30 20:32:06'),
(116, 'harry@gmail.com', '$2y$10$z84tyntk9oKuyfHCC1EolugG.GJz0wkFnAxj0czxo1XBhcgzMi/aa', 'harry', '', '0000-00-00', 4001, '2020-12-30 20:32:53'),
(117, 'harry2@gmail.com', '$2y$10$y7l7KY.aUEpThs7/QKEcbeN0TY/qVRmksZ2aygmWZ85XzCnndhKr2', 'asdf', '', '0000-00-00', 4009, '2020-12-30 20:37:14'),
(118, 'harr22@gmail.com', '$2y$10$CEbgD20CaEtgKm7g2iQKBujem7.cX346S.yTXxKqFYbnMp4372KtC', 'asdf', '', '0000-00-00', 4004, '2020-12-30 20:38:31'),
(119, 'aman@gmail.com', '$2y$10$S1atKAuIgIoNL8fKhLAmtOa60w6BAi75Xbghnr2Mk4hYFlEGxhdom', 'Aman', '', '0000-00-00', 4008, '2020-12-30 20:42:42'),
(120, 'ab@gmail.com', '$2y$10$Hkv2D.r1cFJMkb0f1eS/JuAS8Z4lall1zDP5jghD0S0zFXRe.w4QG', 'asdf', '', '0000-00-00', 4002, '2020-12-30 20:47:55'),
(121, 'a1@b.com', '$2y$10$7F5xRl.Dl/8ngmfeo6mzWOu.F4e875TcVf9judsMV4w1XGnFvzf9i', 'asdf', '', '0000-00-00', 4002, '2020-12-30 20:50:46'),
(122, 'a@b.comm', '$2y$10$MmMvLtkGyifO4FM20XZ1L.s1L6DZp.I/4qHxO1F/G4HiLIOujsnWi', 'asdf', '', '0000-00-00', 4006, '2020-12-30 20:52:23'),
(123, 'a@b.coml', '$2y$10$feetnNoM.yjPa04eVu3sZO3Y1xOKrlzXvFSlGE1j2yf9DWg0vVr/W', 'Vaishnavi', '', '0000-00-00', 4009, '2020-12-30 20:54:46'),
(124, 'a@b.comp', '$2y$10$9tYS7fdiN6OFGioqbu8KZeA04L865NPfW1OsnWhjBbidG7jGoQ16i', 'Aman', '', '0000-00-00', 4002, '2020-12-30 20:57:31'),
(125, 'rs@gmail.com', '$2y$10$sl1pMSzs08VnpV1tfcQ84ujvOFJGKZncWngyV4ZUuMOm4pAJjBb9e', 'Rohit', 'Saraf', '1996-12-08', 4002, '2021-01-08 15:58:58');

--
-- Triggers `passenger`
--
DELIMITER $$
CREATE TRIGGER `del_passenger` BEFORE DELETE ON `passenger` FOR EACH ROW BEGIN
DELETE FROM passenger_phone WHERE pid=old.pid;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `passenger_addr`
--

CREATE TABLE `passenger_addr` (
  `zip_id` int(11) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `latitude` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `passenger_addr`
--

INSERT INTO `passenger_addr` (`zip_id`, `city`, `state`, `latitude`) VALUES
(4001, 'Pune', 'Maharashtra', '18.531282106360827,73.84456305753343'),
(4002, 'Mumbai', 'Maharashtra', '19.082555252374405,72.86731055133454'),
(4003, 'Nashik', 'Maharashtra', '20.00022482644077,73.7878565238708'),
(4004, 'Delhi', 'Delhi', '28.742446165372403,77.08428939385423'),
(4005, 'Bangalore', 'Karnataka', '12.983122348890015,77.59106164720646'),
(4006, 'Hyderabad', 'Telangana', '17.391169029921528,78.48974359485838'),
(4007, 'Ahmedabad', 'Gujarat', '23.02823911452712,72.57286376591465'),
(4008, 'Chennai', 'Tamil Nadu', '13.093860369028153,80.26457763344277'),
(4009, 'Kolkata', 'West Bengal', '22.578464944936147,88.36126451538543'),
(4010, 'Jaipur', 'Rajasthan', '26.91774885649188,75.78642593807488'),
(4011, 'Aurangabad', 'Maharashtra', '19.87807373225493,75.34244882292413'),
(4012, 'Amritsar', 'Punjab', '31.63579042844317,74.87097572218875'),
(4018, 'Nagpur', 'Maharashtra', '21.151582838769436,79.08829047387462');

-- --------------------------------------------------------

--
-- Table structure for table `passenger_phone`
--

CREATE TABLE `passenger_phone` (
  `pid` int(11) NOT NULL,
  `phno` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `passenger_phone`
--

INSERT INTO `passenger_phone` (`pid`, `phno`) VALUES
(107, 8983921060),
(108, 9876543212),
(109, 7028472039),
(110, 7889455612),
(114, 9876543210),
(115, 9876543210),
(116, 9876543210),
(117, 9876543210),
(118, 9876543210),
(119, 7889456512),
(120, 9876543210),
(121, 9876543210),
(122, 9876543210),
(123, 9876543210),
(124, 9876543210),
(124, 8983921060),
(118, 8983921060),
(118, 7889455612),
(118, 8978455612),
(125, 8983921060),
(107, 1234567890);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `pay_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `method` varchar(50) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`pay_id`, `book_id`, `method`, `amount`) VALUES
(513, 320, 'Debit Card', 1459),
(516, 325, 'Credit Card', 1443),
(523, 336, 'Cash', 817),
(524, 338, 'Cash', 964),
(528, 342, 'Debit Card', 8032),
(530, 343, 'Paytm', 2318),
(531, 344, 'Debit Card', 4704);

-- --------------------------------------------------------

--
-- Table structure for table `view_books`
--

CREATE TABLE `view_books` (
  `did` int(11) DEFAULT NULL,
  `book_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`book_id`),
  ADD KEY `pid` (`pid`),
  ADD KEY `car_id` (`car_id`);

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`car_id`),
  ADD UNIQUE KEY `model` (`model`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`pid`,`did`),
  ADD KEY `did` (`did`);

--
-- Indexes for table `driver`
--
ALTER TABLE `driver`
  ADD PRIMARY KEY (`did`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `driver_phone`
--
ALTER TABLE `driver_phone`
  ADD KEY `did` (`did`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `pid` (`pid`);

--
-- Indexes for table `passenger`
--
ALTER TABLE `passenger`
  ADD PRIMARY KEY (`pid`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `zip_id` (`zip_id`);

--
-- Indexes for table `passenger_addr`
--
ALTER TABLE `passenger_addr`
  ADD PRIMARY KEY (`zip_id`);

--
-- Indexes for table `passenger_phone`
--
ALTER TABLE `passenger_phone`
  ADD KEY `pid` (`pid`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`pay_id`),
  ADD UNIQUE KEY `book_id` (`book_id`);

--
-- Indexes for table `view_books`
--
ALTER TABLE `view_books`
  ADD PRIMARY KEY (`book_id`),
  ADD KEY `did` (`did`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=345;

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1016;

--
-- AUTO_INCREMENT for table `driver`
--
ALTER TABLE `driver`
  MODIFY `did` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=205;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1007;

--
-- AUTO_INCREMENT for table `passenger`
--
ALTER TABLE `passenger`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT for table `passenger_addr`
--
ALTER TABLE `passenger_addr`
  MODIFY `zip_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4019;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `pay_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=532;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `passenger` (`pid`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`car_id`) REFERENCES `cars` (`car_id`);

--
-- Constraints for table `contact`
--
ALTER TABLE `contact`
  ADD CONSTRAINT `contact_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `passenger` (`pid`),
  ADD CONSTRAINT `contact_ibfk_2` FOREIGN KEY (`did`) REFERENCES `driver` (`did`);

--
-- Constraints for table `driver_phone`
--
ALTER TABLE `driver_phone`
  ADD CONSTRAINT `driver_phone_ibfk_1` FOREIGN KEY (`did`) REFERENCES `driver` (`did`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `passenger` (`pid`);

--
-- Constraints for table `passenger`
--
ALTER TABLE `passenger`
  ADD CONSTRAINT `passenger_ibfk_1` FOREIGN KEY (`zip_id`) REFERENCES `passenger_addr` (`zip_id`);

--
-- Constraints for table `passenger_phone`
--
ALTER TABLE `passenger_phone`
  ADD CONSTRAINT `passenger_phone_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `passenger` (`pid`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `booking` (`book_id`);

--
-- Constraints for table `view_books`
--
ALTER TABLE `view_books`
  ADD CONSTRAINT `view_books_ibfk_1` FOREIGN KEY (`did`) REFERENCES `driver` (`did`),
  ADD CONSTRAINT `view_books_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `booking` (`book_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
