SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";



-- Database: `misc`
--

-- --------------------------------------------------------

--
-- Table structure for table `autos`


CREATE TABLE `autos` (
  `autos_id` int(11) NOT NULL,
  `make` varchar(255) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `mileage` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


