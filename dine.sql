-- A very simple database for the Dine application
DROP SCHEMA IF EXISTS dine;  
CREATE SCHEMA dine;
USE dine;
GRANT ALL ON dine.* TO 'XXX';
DROP TABLE users; 
CREATE TABLE users(
	id INT(11)  NOT NULL AUTO_INCREMENT,
	username VARCHAR(50) NOT NULL, 
	pwd VARCHAR(50) NOT NULL,
	realname VARCHAR(50),
    description VARCHAR(500),
	PRIMARY KEY(id)
);

CREATE TABLE `genreDesc` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(250) NOT NULL,
    `description` VARCHAR(350) NOT NULL, 
    PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `recipe`;
CREATE TABLE `recipe` (
  `idrecipe` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `time` varchar(1000) DEFAULT NULL,
  `difficulty` varchar(45) DEFAULT NULL,
  `iduser` INT(11) NOT NULL,
  `pictureid` int(11),
  `genre` varchar(150),
  `picture` LONGBLOB,
  `imageType` VARCHAR(150),
  PRIMARY KEY (`idrecipe`),
  CONSTRAINT `iduser` FOREIGN KEY (`iduser`) REFERENCES `users` (`id`), 
  CONSTRAINT `idpic` FOREIGN KEY (`pictureid`) REFERENCES `picture` (`id`)
); 

CREATE TABLE `ingredients` (
	`recipeid` int(11) NOT NULL,
    `name` VARCHAR(100) NOT NULL, 
    PRIMARY KEY (`recipeid`,`name`), 
    CONSTRAINT `rID` FOREIGN KEY (`recipeid`) REFERENCES `recipe` (`idrecipe`)
);


CREATE TABLE genre (
	id int(11) NOT NULL auto_increment, 
    name varchar(45), 
    primary key(id)
); 

-- idr (recipe id) & ids (user id)
CREATE TABLE likes (
	idr int(11) NOT NULL,
    ids int(11) NOT NULL, 
    PRIMARY KEY (`idr`,`ids`)
); 


INSERT INTO genre (name) VALUES("Healthy");
INSERT INTO genre (name) VALUES("Vegetarian");
INSERT INTO genre (name) VALUES("Bakery");
INSERT INTO genre (name) VALUES("Breakfast & Lunch");
INSERT INTO genre (name) VALUES("Fast & Easy");

CREATE TABLE difficulty (
	id int(11) NOT NULL auto_increment, 
    name varchar(45), 
    PRIMARY KEY(id)
); 

INSERT INTO difficulty (name) VALUES ("Easy"); 
INSERT INTO difficulty (name) VALUES ("Medium"); 
INSERT INTO difficulty (name) VALUES ("Hard"); 

CREATE TABLE picture (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`location` varchar(128) DEFAULT NULL,
	`picture` blob,
     PRIMARY KEY (`id`)
)		ENGINE = InnoDB; 


CREATE TABLE `userpicture` (
	`userid` int(11) NOT NULL,
	`pictureid` int(11) NOT NULL,
	PRIMARY KEY (`userid`,`pictureid`)
); 

DROP TABLE step; 
CREATE TABLE `step` (
	`step` int(11) NOT NULL AUTO_INCREMENT,
	`id` int(11) NOT NULL, 
	`description` varchar(300) NOT NULL,
	PRIMARY KEY (step, id), 
    CONSTRAINT `stepID` FOREIGN KEY (`id`) REFERENCES `recipe` (`idrecipe`)
); 
