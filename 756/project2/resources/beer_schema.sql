SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Must use axa9070 schema on Kelvin
-- -----------------------------------------------------
USE `axa9070`;

-- -----------------------------------------------------
-- Table `axa9070`.`Beer`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `axa9070`.`Beer`;

CREATE TABLE IF NOT EXISTS `axa9070`.`Beer` (
  `BeerId` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(50) NOT NULL,
  `Price` FLOAT NOT NULL,
  PRIMARY KEY (`BeerId`),
  UNIQUE INDEX `Name_UNIQUE` (`Name` ASC))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Initialize some values in `axa9070`.`Beer`
-- -----------------------------------------------------

SET autocommit=0;

START TRANSACTION;

INSERT INTO `axa9070`.`Beer` ( `Name`, `Price` )  VALUES ( 'Budweiser', 10.49 );
INSERT INTO `axa9070`.`Beer` ( `Name`, `Price` )  VALUES ( 'Coors', 9.99 );
INSERT INTO `axa9070`.`Beer` ( `Name`, `Price` )  VALUES ( 'Corona', 13.49 );
INSERT INTO `axa9070`.`Beer` ( `Name`, `Price` )  VALUES ( 'Genesee', 5.99 );
INSERT INTO `axa9070`.`Beer` ( `Name`, `Price` )  VALUES ( 'Labatt', 8.99 );
INSERT INTO `axa9070`.`Beer` ( `Name`, `Price` )  VALUES ( 'Sam Adams', 13.99 );

COMMIT;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
