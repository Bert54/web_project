CREATE DATABASE projet_boisson_db;

USE projet_boisson_db;

CREATE TABLE `users` (
 `nickname` varchar(30) CHARACTER SET utf8 NOT NULL,
 `password` varchar(1000) CHARACTER SET utf8 NOT NULL,
 `first_name` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
 `last_name` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
 `gender` enum('Homme','Femme','Non précisé') DEFAULT NULL,
 `mail_address` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
 `birth_date` date DEFAULT NULL,
 `address_street` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
 `address_number` int(5) DEFAULT NULL,
 `address_town` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
 `phone_number` varchar(30) DEFAULT NULL,
 PRIMARY KEY (`nickname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `user_recipes` (
 `nickname` varchar(30) CHARACTER SET utf8 NOT NULL,
 `fav_recipes` longtext CHARACTER SET utf8,
 PRIMARY KEY (`nickname`),
 CONSTRAINT `nick_f_delete` FOREIGN KEY (`nickname`) REFERENCES `users` (`nickname`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;