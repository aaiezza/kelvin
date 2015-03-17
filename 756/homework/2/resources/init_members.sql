SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

USE `axa9070` ;

-- -----------------------------------------------------
-- Table `axa9070`.`phone_types`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `axa9070`.`phone_types` ;

CREATE  TABLE IF NOT EXISTS `axa9070`.`phone_types` (
  `type` VARCHAR(25) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL ,
  PRIMARY KEY (`type`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;

-- -----------------------------------------------------
-- Table `axa9070`.`phone_numbers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `axa9070`.`phone_numbers` ;

CREATE  TABLE IF NOT EXISTS `axa9070`.`phone_numbers` (
  `phone_number_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `area_code` VARCHAR(3) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL ,
  `number` VARCHAR(7) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL ,
  `type` VARCHAR(25) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL,
  PRIMARY KEY (`phone_number_id`) ,
  INDEX `phone_number_id` (`phone_number_id` ASC) ,
  CONSTRAINT `type`
    FOREIGN KEY (`type`)
    REFERENCES `axa9070`.`phone_types` (`type`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;

-- -----------------------------------------------------
-- Table `axa9070`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `axa9070`.`users` ;

CREATE  TABLE IF NOT EXISTS `axa9070`.`users` (
  `username` VARCHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL ,
  `first_name` VARCHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL ,
  `last_name` VARCHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL ,
  PRIMARY KEY (`username`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `axa9070`.`user_phone`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `axa9070`.`user_phone` ;

CREATE  TABLE IF NOT EXISTS `axa9070`.`user_phone` (
  `username` VARCHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL ,
  `phone_number_id` int(10) unsigned NOT NULL ,
  PRIMARY KEY (`username`, `phone_number_id`) ,
  INDEX `username` (`username` ASC) ,
  INDEX `phone_number_id` (`phone_number_id` ASC) ,
  CONSTRAINT `phone_number_id`
    FOREIGN KEY (`phone_number_id`)
    REFERENCES `axa9070`.`phone_numbers` (`phone_number_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `username`
    FOREIGN KEY (`username`)
    REFERENCES `axa9070`.`users` (`username`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `axa9070`.`phone_types`
-- -----------------------------------------------------
START TRANSACTION;
USE `axa9070`;
INSERT INTO `axa9070`.`phone_types` (`type`) VALUES ('home');
INSERT INTO `axa9070`.`phone_types` (`type`) VALUES ('office');
INSERT INTO `axa9070`.`phone_types` (`type`) VALUES ('cell');
INSERT INTO `axa9070`.`phone_types` (`type`) VALUES ('other');

COMMIT;
