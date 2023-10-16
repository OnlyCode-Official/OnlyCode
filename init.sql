CREATE TABLE `users` (
  `id` INT PRIMARY KEY NULL AUTO_INCREMENT,
  `username` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `repo` INT NOT NULL DEFAULT 0,
  `pr` INT NOT NULL DEFAULT 0,
  `issue` INT NOT NULL DEFAULT 0,
  `admin` BOOLEAN NOT NULL DEFAULT FALSE,
  `flagged` BOOLEAN NOT NULL DEFAULT FALSE,
  `suspended` BOOLEAN NOT NULL DEFAULT FALSE,
  `terminated` BOOLEAN NOT NULL DEFAULT FALSE,
  `signup_ip` VARCHAR(128) NOT NULL,
  `current_ip` VARCHAR(128) NOT NULL
);

CREATE TABLE `repos` (
  `id` INT PRIMARY KEY NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `visibility` VARCHAR(10) NOT NULL,
  `owner` VARCHAR(100) NOT NULL,
  `collaborators` TEXT NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `flagged` BOOLEAN NOT NULL DEFAULT FALSE,
  `deleted` BOOLEAN NOT NULL DEFAULT FALSE
);