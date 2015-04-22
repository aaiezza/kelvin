-- Model: 756 Project 3 Model
-- Author: Alex Aiezza
-- MySQL Workbench Forward Engineering

-- -----------------------------------------------------
-- Schema project3_schema
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `project3_schema`;

-- -----------------------------------------------------
-- Schema project3_schema
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `project3_schema`;
USE `project3_schema`;

-- -----------------------------------------------------
-- Table `Beer`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Beer`;

CREATE TABLE IF NOT EXISTS `Beer` (
  `Name` VARCHAR(50) NOT NULL,
  `Price` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`Name`));


-- -----------------------------------------------------
-- Table `User`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `User`;

CREATE TABLE IF NOT EXISTS `User` (
  `Username` VARCHAR(20) NOT NULL,
  `Password` VARCHAR(50) NOT NULL,
  `Age` INT NOT NULL,
  `AccessLevel` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Username`));


-- -----------------------------------------------------
-- Table `Token`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Token`;

CREATE TABLE IF NOT EXISTS `Token` (
  `TokenHash` VARCHAR(16) NOT NULL,
  `Username` VARCHAR(20) NOT NULL,
  `Expiration` DATETIME NOT NULL DEFAULT DATETIME('now', '+5 minutes'),
  PRIMARY KEY (`TokenHash`),
  UNIQUE INDEX `Username_UNIQUE` (`Username` ASC));


-- -----------------------------------------------------
-- Data for table `Beer`
-- -----------------------------------------------------
BEGIN TRANSACTION;
USE `project3_schema`;
INSERT INTO `Beer` (`Name`, `Price`) VALUES ('Budweiser', 10.49);
INSERT INTO `Beer` (`Name`, `Price`) VALUES ('Coors', 9.99);
INSERT INTO `Beer` (`Name`, `Price`) VALUES ('Corona', 13.49);
INSERT INTO `Beer` (`Name`, `Price`) VALUES ('Genesse', 5.99);
INSERT INTO `Beer` (`Name`, `Price`) VALUES ('Guiness', 14.99);
INSERT INTO `Beer` (`Name`, `Price`) VALUES ('Labatt', 8.99);
INSERT INTO `Beer` (`Name`, `Price`) VALUES ('Sam Adams', 13.99);

COMMIT;


-- -----------------------------------------------------
-- Data for table `User`
-- -----------------------------------------------------
BEGIN TRANSACTION;
USE `project3_schema`;
INSERT INTO `User` (`Username`, `Password`, `Age`, `AccessLevel`) VALUES ('test', 'testing', 25, 1);

COMMIT;
