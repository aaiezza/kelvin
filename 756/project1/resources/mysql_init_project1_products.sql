SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

-- DROP SCHEMA IF EXISTS `project1`;
-- CREATE SCHEMA IF NOT EXISTS `project1` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

-- -----------------------------------------------------
-- Table `project1`.`Poducts` | IDEALLY
-- Table `axa9070`.`Project1_Products`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `axa9070`.`Project1_Products` ;

CREATE TABLE IF NOT EXISTS `axa9070`.`Project1_Products` (
  `ProductId` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL,
  `Description` VARCHAR(200) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL,
  `Price` INT NOT NULL,
  `Quantity` INT NOT NULL DEFAULT 1,
  `Sale` INT NOT NULL,
  `ImagePath` VARCHAR(100) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL,
  PRIMARY KEY (`ProductId`),
  UNIQUE INDEX `Name_UNIQUE` (`Name` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;
