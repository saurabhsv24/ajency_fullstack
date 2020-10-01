-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 30, 2020 at 10:39 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_movies`
--

CREATE TABLE `tbl_movies` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `featured_image` varchar(255) NOT NULL,
  `length` varchar(20) NOT NULL,
  `release_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_movies`
--

INSERT INTO `tbl_movies` (`id`, `title`, `description`, `featured_image`, `length`, `release_date`) VALUES
(1, 'Joker', 'In Gotham City, mentally troubled comedian Arthur Fleck is disregarded and mistreated by society. He then embarks on a downward spiral of revolution and bloody crime. This path brings him face-to-face with his alter-ego: the Joker.', 'joker.jpg', '122', '2019-10-04'),
(2, '3 idiots', 'Two friends are searching for their long lost companion. They revisit their college days and recall the memories of their friend who inspired them to think differently, even as the rest of the world called them \"idiots\".\r\n', '3idiots.jpg', '170', '2009-12-25'),
(3, 'The Jungle Book', 'Raised by a family of wolves since birth, Mowgli (Neel Sethi) must leave the only home he is ever known when the fearsome tiger Shere Khan (Idris Elba) unleashes his mighty roar. Guided by a no-nonsense panther (Ben Kingsley) and a free-spirited bear (Bill Murray), the young boy meets an array of jungle animals, including a slithery python and a smooth-talking ape. Along the way, Mowgli learns valuable life lessons as his epic journey of self-discovery leads to fun and adventure', 'jungle.jpg', '90', '2016-04-06'),
(4, 'Dil Bechara', 'The emotional journey of two hopelessly in love youngsters, a young girl, Kizie, suffering from cancer, and a boy, Manny, whom she meets at a support group.', 'dilbechara.jpg', '101', '2020-07-24'),
(5, 'Angrezi Medium', 'When his daughter decides to further her studies in London, a hardworking Rajasthani businessman does everything in power to make her dreams come true.', 'angerzimedium.jpg', '145', '2020-03-13'),
(6, 'Spider-Man: Into the Spider-Verse (2018)', 'Teen Miles Morales becomes the Spider-Man of his universe, and must join with five spider-powered individuals from other dimensions to stop a threat for all realities.', 'spiderman.jpg', '117', '2016-04-23'),
(7, 'Avengers: Endgame ', 'After the devastating events of Avengers: Infinity War (2018), the universe is in ruins. With the help of remaining allies, the Avengers assemble once more in order to reverse Thanos\' actions and restore balance to the universe.', 'avenger.jpg', '181', '2019-04-26'),
(8, 'Broken Embraces', 'Handsome 25-year-old Cesar (Eduardo Noriega) had it all -- a successful career, expensive cars, a swank bachelors pad, and an endless string of beautiful and willing women. He is then thrown into a strange psychological mystery after a car accident scars his face and lands him in prison.', 'broken.jpg', '127', '2010-01-15'),
(9, 'Lost in Hong Kong', 'While on a sightseeing trip with his wife and brother-in-law, a man becomes involved in a murder investigation in Hong Kong.	', 'lostin.jpg', '115', '2015-09-25'),
(10, 'Amori', 'Shirish kelekar left Goa and settled in London 25 years ago. Then one day his past comes back to haunt him, taking him all the way back to his native place. He must deal with broken family ties, a powerful politician and most importantly, the harsh reality of the village resources. Can he make the community aware of something it has ignored for so long?', 'amori.jpg', '107', '2019-09-06'),
(11, 'Baahubali: The Beginning', 'In the kingdom of Mahishmati, while pursuing his love, Shivudu learns about the conflict-ridden past of his family and his legacy. He must now prepare himself to face his new-found archenemy.', 'bahubali.jpg', '130', '2015-07-01'),
(12, 'Natsamrat', 'A retired actor and his wife fall on hard times after their childrens ingratitude leaves them without anything.', 'natsamrat.jpg', '140', '2016-01-01');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_movie_categories`
--

CREATE TABLE `tbl_movie_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` enum('Language','Genre') NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_movie_categories`
--

INSERT INTO `tbl_movie_categories` (`id`, `type`, `value`) VALUES
(1, 'Language', 'English'),
(2, 'Language', 'Hindi'),
(3, 'Language', 'Marathi'),
(4, 'Language', 'Konkani'),
(5, 'Language', 'Chinese'),
(6, 'Language', 'Spanish'),
(7, 'Language', 'Tamil'),
(8, 'Genre', 'Comedy'),
(9, 'Genre', 'Romance'),
(10, 'Genre', 'Drama'),
(11, 'Genre', 'Biography'),
(12, 'Genre', 'Documentation'),
(13, 'Genre', 'Art'),
(14, 'Genre', 'Crime'),
(15, 'Genre', 'Action'),
(16, 'Genre', 'Animation');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_movie_relation`
--

CREATE TABLE `tbl_movie_relation` (
  `id` int(10) UNSIGNED NOT NULL,
  `movie_id` int(10) UNSIGNED NOT NULL,
  `taxonomy_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_movie_relation`
--

INSERT INTO `tbl_movie_relation` (`id`, `movie_id`, `taxonomy_id`) VALUES
(1, 1, 1),
(2, 1, 10),
(3, 2, 2),
(4, 2, 10),
(5, 3, 1),
(6, 3, 8),
(7, 4, 2),
(8, 4, 9),
(9, 5, 2),
(10, 5, 8),
(11, 6, 1),
(12, 6, 16),
(13, 7, 1),
(14, 7, 15),
(15, 8, 6),
(16, 8, 9),
(17, 9, 5),
(18, 9, 14),
(19, 10, 4),
(20, 10, 10),
(21, 11, 7),
(22, 11, 8),
(23, 11, 12),
(24, 12, 3),
(25, 12, 10),
(26, 13, 1),
(27, 13, 16);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_movies`
--
ALTER TABLE `tbl_movies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_movie_categories`
--
ALTER TABLE `tbl_movie_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_movie_relation`
--
ALTER TABLE `tbl_movie_relation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `movie_id` (`movie_id`,`taxonomy_id`),
  ADD KEY `taxonomy_id` (`taxonomy_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_movies`
--
ALTER TABLE `tbl_movies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_movie_categories`
--
ALTER TABLE `tbl_movie_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_movie_relation`
--
ALTER TABLE `tbl_movie_relation`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
