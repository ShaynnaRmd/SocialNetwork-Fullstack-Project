<<<<<<< Updated upstream
=======
-- Active: 1684333270027@@containers-us-west-61.railway.app@7074@railway
>>>>>>> Stashed changes
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

CREATE TABLE `relation` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `id_demandeur` INT(11) NOT NULL,
    `id_receveur` INT(11) NOT NULL,
    `statut` INT(11) NOT NULL,
    `id_bloqueur` int(255) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- CREATE TABLE `awaiting_relations` (
--     `id` INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
--     `seeker_profile_id` INT(11) NOT NULL,
--     `receiver_profile_id` INT(11) NOT NULL,
--     FOREIGN KEY (`seeker_profile_id`) REFERENCES `profiles`(id),
--     FOREIGN KEY (`receiver_profile_id`) REFERENCES `profiles`(id)
-- ) ENGINE=InnoDB;

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
    `description` VARCHAR(255),
    `creator_profile_id` INT(11) NOT NULL,
    `status` VARCHAR(10),
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

CREATE TABLE `test_publications` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `titre` VARCHAR(255),
    `text` TEXT,
    `image` VARCHAR(255),
    `date_time_publication` DATETIME,
    `profile_id` INT(11) NOT NULL,
    FOREIGN KEY (`profile_id`) REFERENCES `profiles`(id)
) ENGINE=InnoDB;

CREATE TABLE `likes` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `test_publications_id` INT(11),
    `profile_id` INT(11) NOT NULL,
    FOREIGN KEY (`profile_id`) REFERENCES `profiles`(id)
) ENGINE=InnoDB;

CREATE TABLE `dislikes` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `test_publications_id` INT(11),
    `profile_id` INT(11) NOT NULL,
    FOREIGN KEY (`profile_id`) REFERENCES `profiles`(id)
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

CREATE TABLE `comments_publications` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `pseudo` VARCHAR(64),
    `commentaire` TEXT,
    `id_publication` INT(11)
) ENGINE=InnoDB;

CREATE TABLE `reactions` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `type` VARCHAR(64) NOT NULL,
    `publication_profile_id` INT(11) NOT NULL,
    `comment_id` INT(11) NOT NULL,
    FOREIGN KEY (`publication_profile_id`) REFERENCES `publications_profile`(id),
    FOREIGN KEY (`comment_id`) REFERENCES `comments`(id)
) ENGINE=InnoDB;

ALTER TABLE `profiles` ADD COLUMN `username` VARCHAR(32);

ALTER TABLE `groups` MODIFY `status` VARCHAR(10);

RENAME TABLE `groups` TO `groups_table`;

ALTER TABLE `profiles` ADD COLUMN `status` VARCHAR(7);