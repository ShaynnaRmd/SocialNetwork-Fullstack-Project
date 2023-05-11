<<<<<<<< HEAD:classlink_messaging/database/classlink_messaging.sql
CREATE TABLE `private_chats` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `relation_id` INT(11) NOT NULL,

) ENGINE=InnoDB;

CREATE TABLE `messages` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `private_chat_id` INT(11) NOT NULL,
    `group_chat_id` INT(11) NOT NULL,
    `creator_profile_id` INT(11) NOT NULL
    `text` TEXT    
) ENGINE=InnoDB;

CREATE TABLE `group_chats` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `name` VARCHAR (64) NOT NULL,
    `pp_image` VARCHAR(255)
) ENGINE=InnoDB;
========
CREATE TABLE `private_chats` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `relation_id` INT(11) NOT NULL,

) ENGINE=InnoDB;

CREATE TABLE `messages` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `private_chat_id` INT(11) NOT NULL,
    `group_chat_id` INT(11) NOT NULL,
    `creator_profile_id` INT(11) NOT NULL
    `text` TEXT    
) ENGINE=InnoDB;

CREATE TABLE `group_chats` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `name` VARCHAR (64) NOT NULL,
    `pp_image` VARCHAR(255)
) ENGINE=InnoDB;
>>>>>>>> 101fbc524d88c1a12eb69bf6462e2981933cbdc7:DATABASES/Messaging.sql
