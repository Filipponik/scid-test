SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `author` (
  `id` int(10) UNSIGNED NOT NULL,
  `f` varchar(255) NOT NULL,
  `i` varchar(255) NOT NULL,
  `o` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `magazine` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `pictureUrl` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `magazine_authors` (
  `id` int(11) NOT NULL,
  `author_id` int(10) UNSIGNED NOT NULL,
  `magazine_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


ALTER TABLE `author`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `magazine`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `magazine_authors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id` (`author_id`),
  ADD KEY `magazine_id` (`magazine_id`);


ALTER TABLE `author`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `magazine`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `magazine_authors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `magazine_authors`
  ADD CONSTRAINT `magazine_authors_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`),
  ADD CONSTRAINT `magazine_authors_ibfk_2` FOREIGN KEY (`magazine_id`) REFERENCES `magazine` (`id`);
COMMIT;