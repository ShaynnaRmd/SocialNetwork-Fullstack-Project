-- Active: 1682529343738@@127.0.0.1@3306@classlink_authentification

CREATE TABLE `users` (
	`id` INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
	`username` VARCHAR(32) NOT NULL,
	`password` VARCHAR(255) NOT NULL,
    `question` VARCHAR(255) NOT NULL,
    `response` VARCHAR(255) NOT NULL,
    `last_name` VARCHAR(64),
    `first_name` VARCHAR(64),
    `birth_date` VARCHAR(10),
    `gender` VARCHAR(255),
    `mail` VARCHAR(255)
) ENGINE=InnoDB;

CREATE TABLE `token` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
	`user_id` INT(11) NOT NULL,
	`token` VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES `users`(id)
) ENGINE=InnoDB;