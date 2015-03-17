-- -----------------------------------------------------
-- ATTACH DATABASE 'project1_members.db' as Project1_members
-- -----------------------------------------------------
-- SQLite does NOT support cross-database foreign key contstraints
-- -----------------------------------------------------

PRAGMA foreign_keys = ON;

-- -----------------------------------------------------
--
---- MEMBERS
--
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Table `roles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `user_role`;
DROP TABLE IF EXISTS `roles`;

CREATE TABLE IF NOT EXISTS `roles` (
  `role` VARCHAR(25) NOT NULL,
  PRIMARY KEY (`role`) );


-- -----------------------------------------------------
-- Table `users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `user_role`;
DROP TABLE IF EXISTS `users`;

CREATE TABLE IF NOT EXISTS `users` (
  `username` VARCHAR(16) NOT NULL,
  `password` VARCHAR(50) NOT NULL,
  `enabled` TINYINT(1) NULL DEFAULT NULL,
  `first_name` VARCHAR(50) NOT NULL,
  `last_name` VARCHAR(50) NOT NULL,
  `email` VARCHAR(50) NOT NULL,
  `date_joined` DATETIME DEFAULT (DATETIME('NOW', 'LOCALTIME')) NOT NULL,
  `last_online` DATETIME DEFAULT (DATETIME('NOW', 'LOCALTIME')) NOT NULL,
  PRIMARY KEY (`username`) );


-- -----------------------------------------------------
-- Table `user_role`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `user_role`;

CREATE TABLE IF NOT EXISTS `user_role` (
  `username` VARCHAR(50) NOT NULL,
  `role` VARCHAR(25) NOT NULL,
  PRIMARY KEY (`username`, `role`),
  FOREIGN KEY (`username`)
    REFERENCES `users` (`username`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  FOREIGN KEY (`role`)
    REFERENCES `roles` (`role`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

-- -----------------------------------------------------
-- Data for table `roles`
-- -----------------------------------------------------
INSERT INTO `roles` (`role`) VALUES ('ROLE_ADMIN');
INSERT INTO `roles` (`role`) VALUES ('ROLE_USER');

-- -----------------------------------------------------
-- Need an admin for first startup
-- Password: admin
-- -----------------------------------------------------
INSERT INTO `users` (`username`, `password`, `enabled` , `first_name`, `last_name`, `email`)
  VALUES (
    'admin',
    'd033e22ae348aeb5660fc2140aec35850c4da997',
    1 ,
    'Gregor',
    'Mendel',
    'g.mendel@kelvin.ist.rit.edu');
INSERT INTO `user_role` (`username`, `role`)
  VALUES (
    'admin',
    'ROLE_USER');
INSERT INTO `user_role` (`username`, `role`)
  VALUES (
    'admin',
    'ROLE_ADMIN');

-- -----------------------------------------------------
--
---- PRODUCTS
--
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Table `products`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `user_cart`;
DROP TABLE IF EXISTS `products`;

CREATE TABLE IF NOT EXISTS `products` (
  `ProductId` INTEGER PRIMARY KEY AUTOINCREMENT,
  `Name` VARCHAR(50) NOT NULL,
  `Description` VARCHAR(200) NOT NULL,
  `Price` INTEGER NOT NULL,
  `Quantity` INTEGER NOT NULL DEFAULT 1,
  `OnSale` TINYINT(1) NULL DEFAULT NULL,
  `Sale` INTEGER NOT NULL,
  `ImagePath` VARCHAR(100) NOT NULL,
  UNIQUE (`Name` ASC));

-- -----------------------------------------------------
-- Table `user_cart`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `user_cart`;

CREATE TABLE IF NOT EXISTS `user_cart` (
  `username` VARCHAR(16) NOT NULL,
  `ProductId` INTEGER NOT NULL,
  `quantity` INTEGER NOT NULL DEFAULT 1,
  PRIMARY KEY (`username`, `ProductId`),
  FOREIGN KEY (`username`)
    REFERENCES `user` (`username`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  FOREIGN KEY (`ProductId`)
    REFERENCES `products` (`ProductId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);
