--
-- Database: `swApp_db`
--

CREATE DATABASE IF NOT EXISTS `swApp_db`;
USE `swApp_db`;


-- ENTITIES

--
-- Struttura della tabella `role`
--

CREATE TABLE IF NOT EXISTS `role` (
	`nam` varchar(40) ,
	
	-- RELAZIONI

	`_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT 

);




--
-- Struttura della tabella `role`
--

CREATE TABLE IF NOT EXISTS `role` (
	`description` varchar(40) ,
	`name` varchar(40)  NOT NULL,
	
	-- RELAZIONI

	`_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT 

);




--
-- Struttura della tabella `user`
--

CREATE TABLE IF NOT EXISTS `user` (
	`mail` varchar(40)  NOT NULL,
	`name` varchar(40) ,
	`password` varchar(40)  NOT NULL,
	`roles` varchar(40) ,
	`surname` varchar(40) ,
	`username` varchar(40)  NOT NULL UNIQUE,
	
	-- RELAZIONI

	`_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT 

);



-- relation m:m user_role User - Role
CREATE TABLE IF NOT EXISTS `User_user_role` (
    `_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `id_User` int(11)  NOT NULL REFERENCES User(_id),
    `id_Role` int(11)  NOT NULL REFERENCES Role(_id)
);







INSERT INTO `swApp_db`.`user` (`username`, `password`, `_id`) VALUES ('admin', '1a1dc91c907325c69271ddf0c944bc72', 1);

CREATE TABLE IF NOT EXISTS `roles` (
	`role` varchar(30) ,
	
	-- RELAZIONI

	`_user` int(11)  NOT NULL REFERENCES user(_id),
	`_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT 

);
INSERT INTO `swApp_db`.`roles` (`role`, `_user`, `_id`) VALUES ('ADMIN', '1', 1);