
SET AUTOCOMMIT = 0;
START TRANSACTION;

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `num_of_days` int(11) NOT NULL
);

CREATE TABLE `cars` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `model` varchar(255) NOT NULL,
  `number` varchar(255) NOT NULL,
  `seating_capacity` int(11) NOT NULL,
  `rent_per_day` int(11) NOT NULL,
  `agency_user_id` int(11) NOT NULL
);

CREATE TABLE `users` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` varchar(10) NOT NULL
);

COMMIT;

