-- Model: 756 Project 3 Model
-- Author: Alex Aiezza
-- MySQL Workbench Forward Engineering

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
  `Expiration` DATETIME DEFAULT (DATETIME('NOW', '+5 MINUTES')) NOT NULL,
  PRIMARY KEY (`TokenHash`),
  FOREIGN KEY (`Username`)
    REFERENCES `User` (`Username`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Data for table `Beer`
-- -----------------------------------------------------
BEGIN TRANSACTION;
INSERT INTO `Beer` (`Name`, `Price`) VALUES ('Budweiser', 10.49);
INSERT INTO `Beer` (`Name`, `Price`) VALUES ('Coors', 9.99);
INSERT INTO `Beer` (`Name`, `Price`) VALUES ('Corona', 13.49);
INSERT INTO `Beer` (`Name`, `Price`) VALUES ('Genessee', 5.99);
INSERT INTO `Beer` (`Name`, `Price`) VALUES ('Guinness', 14.99);
INSERT INTO `Beer` (`Name`, `Price`) VALUES ('Labatt', 8.99);
INSERT INTO `Beer` (`Name`, `Price`) VALUES ('Sam Adams', 13.99);

COMMIT;


-- -----------------------------------------------------
-- Data for table `User`
-- -----------------------------------------------------
BEGIN TRANSACTION;
INSERT INTO `User` (`Username`, `Password`, `Age`, `AccessLevel`) VALUES ('test', 'testing', 25, 1);
INSERT INTO `User` (`Username`, `Password`, `Age`, `AccessLevel`) VALUES ('tom', 'pass', 25, 0);
INSERT INTO `User` (`Username`, `Password`, `Age`, `AccessLevel`) VALUES ('sam', 'testing', 19, 1);

COMMIT;
