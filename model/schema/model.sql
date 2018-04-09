
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema pantofka
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema pantofka
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `pantofka` DEFAULT CHARACTER SET utf8 ;
USE `pantofka` ;

-- -----------------------------------------------------
-- Table `pantofka`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pantofka`.`users` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `user_email` VARCHAR(45) NOT NULL,
  `user_fname` VARCHAR(45) NOT NULL,
  `user_lname` VARCHAR(45) NOT NULL,
  `user_password` VARCHAR(100) NOT NULL,
  `user_gender` VARCHAR(6) NOT NULL,
  `is_admin` TINYINT NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE INDEX `user_email_UNIQUE` (`user_email` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pantofka`.`products`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pantofka`.`products` (
  `product_id` INT NOT NULL AUTO_INCREMENT,
  `product_name` VARCHAR(45) NOT NULL,
  `product_color` VARCHAR(45) NOT NULL,
  `product_price` DOUBLE NOT NULL,
  `product_img_name` VARCHAR(100) NULL DEFAULT 'no_image.jpg',
  `sale_info_state` VARCHAR(45) NULL DEFAULT 'normal',
  `style` VARCHAR(45) NOT NULL,
  `subcategory` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`product_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pantofka`.`sizes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pantofka`.`sizes` (
  `size_id` INT NOT NULL AUTO_INCREMENT,
  `size_number` INT NOT NULL,
  `size_quantity` INT NOT NULL,
  `product_id` INT NOT NULL,
  PRIMARY KEY (`size_id`),
  INDEX `fk_sizes_products1_idx` (`product_id` ASC),
  CONSTRAINT `fk_sizes_products1`
    FOREIGN KEY (`product_id`)
    REFERENCES `pantofka`.`products` (`product_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pantofka`.`orders`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pantofka`.`orders` (
  `order_id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `date` DATETIME(4) NULL,
  `size_id` VARCHAR(45) NOT NULL,
  `product_id` INT NOT NULL,
  PRIMARY KEY (`order_id`),
  INDEX `user_id_idx` (`user_id` ASC),
  INDEX `fk_orders_products1_idx` (`product_id` ASC),
  CONSTRAINT `user_id`
    FOREIGN KEY (`user_id`)
    REFERENCES `pantofka`.`users` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_orders_products1`
    FOREIGN KEY (`product_id`)
    REFERENCES `pantofka`.`products` (`product_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;


ALTER TABLE `pantofka`.`products`
ADD COLUMN `material` VARCHAR(45) NOT NULL AFTER `subcategory`;

ALTER TABLE `pantofka`.`products`
ADD COLUMN `sale_price` INT NULL DEFAULT NULL AFTER `material`;