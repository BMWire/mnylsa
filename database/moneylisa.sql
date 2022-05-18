-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 18, 2022 at 09:09 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `moneylisa`
--

-- --------------------------------------------------------

--
-- Table structure for table `art`
--

CREATE TABLE `art` (
  `id` int(11) NOT NULL,
  `artist_id` int(11) DEFAULT NULL,
  `artist_name` varchar(128) DEFAULT NULL,
  `title` varchar(128) NOT NULL,
  `story` longtext NOT NULL,
  `price` int(128) NOT NULL,
  `palletes` int(128) DEFAULT NULL,
  `img_path` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `art`
--

INSERT INTO `art` (`id`, `artist_id`, `artist_name`, `title`, `story`, `price`, `palletes`, `img_path`, `created_at`) VALUES
(13, 28, 'Matt Moloney', 'Black and Black', 'A man, with a camera and black shoes with black pants', 40000, NULL, 'uploads/art/matt-moloney-black-and-black.jpg', '2022-05-06 11:15:10'),
(14, 28, 'Matt Moloney', 'February', 'Perhaps, this would do with some better lighting.', 45000, NULL, 'uploads/art/matt-moloney-february.jpg', '2022-05-06 11:17:40'),
(15, 28, 'Matt Moloney', 'Red Dot', 'I made a piece, \r\nand stained it with a red dot. I thought it looked better before. It looks much better now. ', 50000, NULL, 'uploads/art/matt-moloney-red-dot.jpg', '2022-05-06 11:18:30'),
(16, 29, 'Charvis the Painter', 'Chaos', 'There was chaos in my mind. I chose black and white to show it to the world. Not it is there no more. ', 50000, NULL, 'uploads/art/charvis-harrell-chaos.jpg', '2022-05-06 11:28:57'),
(17, 28, 'Matt Moloney', 'The abyss', 'Created in Feb', 30000, NULL, 'uploads/art/matt-moloney-the-abyss.jpg', '2022-05-06 11:44:48'),
(18, 30, 'Dhir Jakaria', 'Circle of Life', 'We eat and get eaten. We love and get loved. We die and get born again. It is the circle of Life. Enjoy it.', 50000, NULL, 'uploads/art/dhir-jakaria-circle_of_life.jpeg', '2022-05-17 20:09:44'),
(20, 30, 'Dhir Jakaria', 'Coming for you', 'The wild. We are in the wild. I am your predator - your greatest nightmare. I am coming for you.', 55000, NULL, 'uploads/art/dhir-jakaria-coming_for_you.jpeg', '2022-05-17 20:11:11'),
(22, 30, 'Dhir Jakaria', 'Life is beautiful', 'At the end of the day. What matters the most is the small things. These things that we take for granted. The things that we overlook. These - we should appreciate the most. They make life beautiful.', 40000, NULL, 'uploads/art/dhir-jakaria-life_is_beautiful.jpeg', '2022-05-17 20:14:56'),
(25, 30, 'Dhir Jakaria', 'Right Moment', 'Sometimes, though not so often, you can capture a magical moment. Such times, you need to be primed and ready, to pull the trigger or push the button at the Right Moment', 50000, NULL, 'uploads/art/dhir-jakaria-right_moment.jpeg', '2022-05-17 20:22:40'),
(26, 30, 'Dhir Jakaria', 'Rise of the giant', 'Some people have seen this piece already and think that the giant is the sun. Others think that the elephant, the massive mammal that walks the earth is the giant. It would only be justice for me as an artist to let you decide. Who is the giant?', 70000, NULL, 'uploads/art/dhir-jakaria-rise_of_the_giant.jpeg', '2022-05-17 20:33:44');

-- --------------------------------------------------------

--
-- Table structure for table `artist_details`
--

CREATE TABLE `artist_details` (
  `id` int(11) NOT NULL,
  `artist_id` int(11) NOT NULL,
  `artist_name` varchar(128) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `building` varchar(255) DEFAULT NULL,
  `street` varchar(255) NOT NULL,
  `town` varchar(255) NOT NULL,
  `county` varchar(255) NOT NULL,
  `story` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `artist_details`
--

INSERT INTO `artist_details` (`id`, `artist_id`, `artist_name`, `profile_image`, `building`, `street`, `town`, `county`, `story`, `created_at`) VALUES
(1, 12, 'Chuy Ramires', 'uploads/artists/chuy-ramires.jpeg', '45 Newell Heights', 'Newell Road', 'Palo Alto', 'Kiambu', 'I\'m Mexican. What do you expect.', '2022-04-30 18:05:23'),
(3, 9, 'Russ Hannermann', 'uploads/artists/rene-magritte.webp', 'Tres Comma', '348 Queensway Road', 'Nairobi', 'Nairobi', 'It has a lot of \"shwaaaaag\". You guys know that I love shwaaag, don\'t you?', '2022-05-01 14:28:46'),
(4, 28, 'Matt Moloney', 'uploads/artists/matt-moloney.jpg', 'Alliance Francaise Building', 'Loita Street', 'Nairobi', 'Nairobi', 'I just loved fiddling with my grandfather\'s camera ever since I was a boy. ', '2022-05-06 11:13:53'),
(5, 29, 'Charvis the Painter', 'uploads/artists/charvis-harrell.jpg', 'Alliance Francaise Building', 'Loita Street', 'Nairobi', 'Nairobi', 'Sometimes, people just love to play with colors. A little black, some white and some red and yellow as well.', '2022-05-06 11:27:05'),
(6, 30, 'Dhir Jakaria', 'uploads/artists/dhir-jakaria_dp.jpg', 'Maasai Mara', 'Wanyama avenue', 'Narok', 'Narok', 'I am a 19 year old Kenyan who enjoys wildlife photography assignments. These make me infinite.', '2022-05-17 20:02:32'),
(7, 31, 'Taiyo Sertanju', 'uploads/artists/taiyo-lady.jpeg', 'National Museums of Kenya', 'Museum Hill Road', 'Nairobi', 'Nairobi', 'That the strands of a horse can be made into magical tools that bring sheer color and water and wax into life got me sold and engrossed in art since I was 6 years old.', '2022-05-17 21:12:56');

-- --------------------------------------------------------

--
-- Table structure for table `art_orders`
--

CREATE TABLE `art_orders` (
  `id` int(11) NOT NULL,
  `piece_id` int(11) NOT NULL,
  `artist_id` int(11) NOT NULL,
  `piece_title` varchar(255) NOT NULL,
  `piece_price` int(128) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `isPaid` tinyint(1) DEFAULT 0,
  `isCollected` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `art_orders`
--

INSERT INTO `art_orders` (`id`, `piece_id`, `artist_id`, `piece_title`, `piece_price`, `user_id`, `user_name`, `isPaid`, `isCollected`, `created_at`) VALUES
(102, 12, 25, 'Old shoes', 30000, 8, 'Gavin Belson', 1, 1, '2022-05-04 08:08:16'),
(103, 15, 28, 'Red Dot', 50000, 8, 'Gavin Belson', 1, 1, '2022-05-06 11:35:04'),
(104, 16, 29, 'Chaos', 50000, 8, 'Gavin Belson', 1, 1, '2022-05-06 13:27:59'),
(106, 17, 28, 'The abyss', 30000, 20, 'Jack Barker', 0, 0, '2022-05-17 17:47:19'),
(107, 13, 28, 'Black and Black', 40000, 20, 'Jack Barker', 0, 0, '2022-05-17 18:37:22'),
(108, 14, 28, 'February', 45000, 20, 'Jack Barker', 0, 0, '2022-05-17 20:12:52');

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

CREATE TABLE `galleries` (
  `id` int(11) NOT NULL,
  `artist_id` int(11) DEFAULT NULL,
  `artist_name` varchar(128) DEFAULT NULL,
  `coverImg` varchar(255) DEFAULT NULL,
  `title` varchar(128) NOT NULL,
  `location` varchar(128) NOT NULL,
  `story` varchar(255) NOT NULL,
  `fee` int(128) NOT NULL,
  `date` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `galleries`
--

INSERT INTO `galleries` (`id`, `artist_id`, `artist_name`, `coverImg`, `title`, `location`, `story`, `fee`, `date`, `created_at`) VALUES
(17, 25, 'AnneMarie Kerubo', 'uploads/gallery/elisa-maesano-contemporary.jpg', 'IWD', '389 Newell Road, Room 5', 'Women', 40000, '2022-05-13 00:00:00', '2022-05-04 08:14:05'),
(18, 29, 'Charvis the Painter', 'uploads/gallery/oladimeji-odunsi-blm.jpg', 'Nairobi Art Week', 'Alliance Francaise', 'Not only Black Lives Matter, all these other lives do too. Let us preserve the bodaboda\'s life with as much diligence and care as the mkulima\'s life. Let us all see life as it will be tomorrow. ', 3500, '2022-05-31 00:00:00', '2022-05-06 13:14:25'),
(20, 30, 'Dhir Jakaria', 'uploads/gallery/dhir-jakaria-wild_life_gall.jpeg', 'Wild Life', 'Alliance Francaise', 'I have come from the wild. I was on a hunt - not for game - for the loveliest combinations, the right moments, the giants on the rise so that I can understand the circle of life. Join me as we consume this. ', 4500, '2022-06-03 00:00:00', '2022-05-17 20:37:22');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_orders`
--

CREATE TABLE `gallery_orders` (
  `id` int(11) NOT NULL,
  `gallery_id` int(11) NOT NULL,
  `artist_id` int(11) NOT NULL,
  `gallery_title` varchar(255) NOT NULL,
  `gallery_fee` varchar(255) NOT NULL,
  `ticket_total` int(255) DEFAULT NULL,
  `ticket_quantity` int(11) DEFAULT 1,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `isPaid` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gallery_orders`
--

INSERT INTO `gallery_orders` (`id`, `gallery_id`, `artist_id`, `gallery_title`, `gallery_fee`, `ticket_total`, `ticket_quantity`, `user_id`, `user_name`, `isPaid`, `created_at`) VALUES
(22, 17, 25, 'IWD', '40000', 40000, 1, 8, 'Gavin Belson', 1, '2022-05-04 08:14:25'),
(25, 18, 29, 'Nairobi Art Week', '3500', 3500, 1, 8, 'Gavin Belson', 1, '2022-05-06 13:20:27'),
(26, 18, 29, 'Nairobi Art Week', '3500', 3500, 1, 22, 'Angie Wire', 1, '2022-05-06 13:43:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `isAdmin` varchar(20) DEFAULT 'no',
  `isArtist` varchar(20) DEFAULT 'no',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `isAdmin`, `isArtist`, `created_at`) VALUES
(2, 'Richard Hendricks', 'richard@pallopa.com', '$2y$10$dMNYK30UTstqluR3jz2.BehB4sGvYeE6dM9dZ/36kRZZ3OemhvEZ.', 'no', 'no', '2022-04-19 18:05:57'),
(4, 'Dinesh Chuggtai', 'dinny@pallopa.com', '$2y$10$MAa1d3RG/8JCRs6qubfhvept4oTPTXYO3keUcpZ83r69LehxuXcFG', 'no', 'no', '2022-04-19 18:05:57'),
(5, 'Monica Hall', 'monica@riviga.com', '$2y$10$VjgZpHmAJno5xcY3QXrA7uPvmuro6eucJykUj.GtVWIQMWEYch3mC', 'no', 'no', '2022-04-19 18:05:57'),
(6, 'Lorey Bream', 'lorey@riviga.com', '$2y$10$Vq6N.hjT1dJt1NidHyj01uDSLml6HN7XKQovZHy3QZ/0FnN1f8fcW', 'no', 'no', '2022-04-19 18:05:57'),
(8, 'Gavin Belson', 'belson@hooli.com', '$2y$10$yXWNMpbO/mNZaL9rETiolugxGQDTLvBb0M..EMmzzhkc4JJkaQrPO', 'no', 'no', '2022-04-19 18:05:57'),
(12, 'Chuy Ramires', 'chuy@mural.com', '$2y$10$7zv6Pto8krPWQNkdA9svM.hpjom6tRkNjDKvaYxLGnawjMHdHt7yy', 'no', 'yes', '2022-04-19 18:05:57'),
(13, 'Andy Warhol', 'warhol@mnylsa.com', '$2y$10$4kgUcWKPELsBGx/FrFbC8.3D4yzDkCp.Ga9KadpYfKvwHiJo.9BAa', 'no', 'yes', '2022-04-19 18:05:57'),
(14, 'Grant Wood', 'grant@og.com', '$2y$10$e1ODmhdsLT4gzWtGQWgOn.p8M2iaA/3i1ZzZEoTVVahyo4Zev7EeO', 'no', 'yes', '2022-04-19 18:05:57'),
(15, 'Ashley Smith', 'ash@unsplash.com', '$2y$10$0jH58gi7TS7Bi7gZJD.RGuy/mHUgQwmlhozeab.1x4eBzkcFeR3z.', 'no', 'yes', '2022-04-19 18:05:57'),
(16, 'Bertram Gilfolyle', 'gilfoyle@pallopa.com', '$2y$10$cb6/1h9wVz7VXqlCiUUQD.qN7O4TkXZNEgVdG3VhB1fsziV4/qIxO', 'no', 'no', '2022-04-19 18:05:57'),
(17, 'Mia Hackr', 'mia@alcatraz.com', '$2y$10$itLCO64QXR8/zk.gUH2FzOjf0IbUJrUgdUo/z15i.7ZaZs2BxT66K', 'no', 'no', '2022-04-19 18:05:57'),
(18, 'Katie Moum', 'katie@welcome.com', '$2y$10$3lf/SObqswmWN5lwiiW7He1pOfbiyznl9gl6W3F0YkBa9QF9YNnF6', 'no', 'no', '2022-04-19 18:05:57'),
(20, 'Jack Barker', 'actionjack@hooli.con', '$2y$10$yE0PxHwgeqCTMk8PrCRhtOeaTffhkFbe1wtNaEWVUc.fYCF8TPeTq', 'no', 'no', '2022-04-19 18:05:57'),
(22, 'Angie Wire', 'angie@rhineland.du', '$2y$10$bRPsEdkzDR7dpVzn35ITa.AQFVuc3ig0EoeU3sgMXxNzciFCVJBka', 'no', 'no', '2022-04-21 16:54:55'),
(25, 'AnneMarie Kerubo', 'ann@iwd.co.ke', '$2y$10$9E7xJv8aUPj6NQG6fv/TM.9Mb.2bQc/BUtF4q3YP0mBVCeXumPAei', 'no', 'no', '2022-04-22 08:41:35'),
(26, 'Barry Notartist', 'barry@isartist.com', '$2y$10$2.mLG7MzudfYfDUIUcAgM.DlwHqZC7v6rMGhVoMjYM2WLbzG.zxxW', 'no', 'yes', '2022-04-22 15:17:15'),
(27, 'Barry Wire', 'bmwemawire@gmail.com', '$2y$10$j5WPexwlEzlqZ3Hjv3xPluwJ5p.NOPEfDsB14sc8gslCjnA6I/cpW', 'yes', 'no', '2022-05-04 05:17:48'),
(28, 'Matt Moloney', 'matt@unsplash.com', '$2y$10$he3TxkQaUDYRBqKTSAj6LOj7PE1Ddj9rCMv.W66Eg9dyldvNAtlv6', 'no', 'yes', '2022-05-06 11:11:30'),
(29, 'Charvis the Painter', 'charvis@unsplash.com', '$2y$10$ECOcmovYN0Ib38UjotHbg.ji9Vq4p1E7ttzeOAaS6c4F1KTu0IgDS', 'no', 'yes', '2022-05-06 11:25:32'),
(30, 'Dhir Jakaria', 'dhir@twitter.com', '$2y$10$sVLh8kwiobQRkn2Y7yJMGu.PcMgKeW12fQHuYXsrT9tuC3p6qL7Jy', 'no', 'yes', '2022-05-17 19:54:27'),
(31, 'Taiyo Sertanju', 'taiyo@1840.com', '$2y$10$hy/g27CjsxXpwAahx84TzeXd3UVmXeuPqJqUy/CKmIeNVhT7phS8m', 'no', 'yes', '2022-05-17 21:10:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `art`
--
ALTER TABLE `art`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `artist_details`
--
ALTER TABLE `artist_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `art_orders`
--
ALTER TABLE `art_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery_orders`
--
ALTER TABLE `gallery_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `art`
--
ALTER TABLE `art`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `artist_details`
--
ALTER TABLE `artist_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `art_orders`
--
ALTER TABLE `art_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `gallery_orders`
--
ALTER TABLE `gallery_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `art`
--
ALTER TABLE `art`
  ADD CONSTRAINT `art_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE NO ACTION;

--
-- Constraints for table `galleries`
--
ALTER TABLE `galleries`
  ADD CONSTRAINT `galleries_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `gallery_orders`
--
ALTER TABLE `gallery_orders`
  ADD CONSTRAINT `gallery_orders_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
