-- Active: 1682529343738@@127.0.0.1@3306@classlink
CREATE TABLE `profiles` (
    `id` INT(11) PRIMARY KEY NOT NULL,
    `last_name` VARCHAR(64), 
    `first_name` VARCHAR(64),
    `birth_date` VARCHAR(10),
    `gender` VARCHAR(255),
    `mail` VARCHAR(255),
    `pp_image` VARCHAR(255),
    `banner_image` VARCHAR(255)
) ENGINE=InnoDB;

CREATE TABLE `pages` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `name` VARCHAR(64) NOT NULL,
    `pp_image` VARCHAR(255),
    `banner_image` VARCHAR(255),
    `description` TEXT,
    `creator_profile_id` INT(11) NOT NULL,
    FOREIGN KEY (creator_profile_id) REFERENCES `profiles`(id)
) ENGINE=InnoDB;

CREATE TABLE `relations` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `user_profile_id` INT(11) NOT NULL,
    `friend_profile_id` INT(11) NOT NULL,
    FOREIGN KEY (`user_profile_id`) REFERENCES `profiles`(id),
    FOREIGN KEY (`friend_profile_id`) REFERENCES `profiles`(id)
) ENGINE=InnoDB;

CREATE TABLE `awaiting_relations` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `seeker_profile_id` INT(11) NOT NULL,
    `receiver_profile_id` INT(11) NOT NULL,
    FOREIGN KEY (`seeker_profile_id`) REFERENCES `profiles`(id),
    FOREIGN KEY (`receiver_profile_id`) REFERENCES `profiles`(id)
) ENGINE=InnoDB;

CREATE TABLE `subscribers_page` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `page_id` INT(11) NOT NULL,
    `profile_id` INT(11) NOT NULL,
    FOREIGN KEY (`page_id`) REFERENCES `pages`(id),
    FOREIGN KEY (`profile_id`) REFERENCES `profiles`(id)
) ENGINE=InnoDB;


CREATE TABLE `groups` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `name` VARCHAR(64) NOT NULL,
    `banner_image` VARCHAR(255),
    `description` TEXT,
    `creator_profile_id` INT(11) NOT NULL,
    `status` VARCHAR (10),
    FOREIGN KEY (`creator_profile_id`) REFERENCES `profiles`(id)
) ENGINE=InnoDB;

CREATE TABLE `group_members` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `group_id` INT(11) NOT NULL,
    `profile_id` INT(11) NOT NULL,
    `admin` BOOLEAN,
    FOREIGN KEY (`group_id`) REFERENCES `groups`(id),
    FOREIGN KEY (`profile_id`) REFERENCES `profiles`(id)
) ENGINE=InnoDB;

CREATE TABLE `publications_profile` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `profile_id` INT(11) NOT NULL,
    `image` VARCHAR(255),
    `text` TEXT,
    FOREIGN KEY (`profile_id`) REFERENCES `profiles`(id),
) ENGINE=InnoDB;

CREATE TABLE `publications_group` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `profile_id` INT(11) NOT NULL,
    `group_id` INT(11) NOT NULL,
    `image` VARCHAR(255),
    `text` TEXT,
    FOREIGN KEY (`profile_id`) REFERENCES `profiles`(id),
    FOREIGN KEY (`group_id`) REFERENCES `groups`(id)
) ENGINE=InnoDB;

CREATE TABLE `publications_page` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `profile_id` INT(11) NOT NULL,
    `page_id` INT(11) NOT NULL,
    `image` VARCHAR(255),
    `text` TEXT,
    FOREIGN KEY (`profile_id`) REFERENCES `profiles`(id),
    FOREIGN KEY (`page_id`) REFERENCES `pages`(id),
) ENGINE=InnoDB;

CREATE TABLE `comments` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `publication_id` INT(11) NOT NULL,
    `text` TEXT,
    `response` TEXT,
    `creator_id` INT(11) NOT NULL,
    FOREIGN KEY (`publication_id`) REFERENCES `publications`(id),
    FOREIGN KEY (`creator_id`) REFERENCES `profiles`(id)
) ENGINE=InnoDB;

CREATE TABLE `reactions` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `type` VARCHAR(64) NOT NULL,
    `publication_id` INT(11) NOT NULL,
    `comment_id` INT(11) NOT NULL,
    FOREIGN KEY (`publication_id`) REFERENCES `publications`(id),
    FOREIGN KEY (`comment_id`) REFERENCES `comments`(id)
) ENGINE=InnoDB;


