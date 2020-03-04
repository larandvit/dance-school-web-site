-- ----------------------------------------------------------------------------
-- MySQL Workbench Migration
-- Migrated Schemata: dance_school
-- Created: Mon Mar  2 23:16:09 2020
-- Workbench Version: 6.3.8
-- ----------------------------------------------------------------------------

SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------------------------------------------------------
-- Schema dance_school
-- ----------------------------------------------------------------------------
DROP SCHEMA IF EXISTS `dance_school` ;
CREATE SCHEMA IF NOT EXISTS `dance_school` ;

-- ----------------------------------------------------------------------------
-- Table dance_school.album
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `dance_school`.`album` (
  `ShowAlbum` TINYINT(4) NOT NULL DEFAULT '0',
  `AlbumDate` DATE NOT NULL,
  `AlbumCaption` VARCHAR(50) NOT NULL,
  `ShowAlbumMainPage` TINYINT(4) NOT NULL DEFAULT '0',
  `AlbumFolder` VARCHAR(50) NOT NULL,
  `Id` INT(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`Id`),
  UNIQUE INDEX `AlbumCaption_UNIQUE` (`AlbumCaption` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 11
DEFAULT CHARACTER SET = latin1;

-- ----------------------------------------------------------------------------
-- Table dance_school.album_pictures
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `dance_school`.`album_pictures` (
  `PictureName` VARCHAR(50) NOT NULL,
  `AlbumId` INT(11) NOT NULL,
  `Id` INT(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`Id`),
  UNIQUE INDEX `PictureName_AlbumId_UNIQUE` (`PictureName` ASC, `AlbumId` ASC),
  INDEX `fk_album_pictures_album_idx` (`AlbumId` ASC),
  CONSTRAINT `fk_album_pictures_album`
    FOREIGN KEY (`AlbumId`)
    REFERENCES `dance_school`.`album` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 88
DEFAULT CHARACTER SET = latin1;

-- ----------------------------------------------------------------------------
-- Table dance_school.color_name
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `dance_school`.`color_name` (
  `Id` INT(11) NOT NULL,
  `ColorName` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`Id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

-- ----------------------------------------------------------------------------
-- Table dance_school.dance_class
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `dance_school`.`dance_class` (
  `Id` INT(11) NOT NULL,
  `ClassName` VARCHAR(100) CHARACTER SET 'latin1' NOT NULL,
  `ColorName` VARCHAR(50) NOT NULL,
  `CoachName` VARCHAR(100) NULL DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE INDEX `class_ClassName_UN` (`ClassName` ASC),
  INDEX `class_color_FK` (`ColorName` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = cp1251;

-- ----------------------------------------------------------------------------
-- Table dance_school.dayofweek
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `dance_school`.`dayofweek` (
  `Id` INT(11) NOT NULL,
  `Name` VARCHAR(10) NOT NULL,
  PRIMARY KEY (`Id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = cp1251;

-- ----------------------------------------------------------------------------
-- Table dance_school.events
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `dance_school`.`events` (
  `ShowEvent` TINYINT(4) NOT NULL DEFAULT '1',
  `EventDate` VARCHAR(10) NOT NULL,
  `EventCaption` VARCHAR(50) NOT NULL,
  `EventText` VARCHAR(5000) NULL DEFAULT NULL,
  `ShowEventMainPage` TINYINT(4) NOT NULL DEFAULT '0',
  `ShowEventMainPageFlag` TINYINT(4) NOT NULL DEFAULT '0',
  `MainPageEventText` VARCHAR(500) NULL DEFAULT NULL,
  `EventTextShowCharsMainPage` INT(11) NOT NULL DEFAULT '0',
  `Id` INT(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`Id`),
  UNIQUE INDEX `EventDate_UNIQUE` (`EventDate` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 12
DEFAULT CHARACTER SET = latin1;

-- ----------------------------------------------------------------------------
-- Table dance_school.fee
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `dance_school`.`fee` (
  `PeriodName` VARCHAR(45) NOT NULL,
  `FirstClass` VARCHAR(45) NOT NULL,
  `LastClass` VARCHAR(45) NOT NULL,
  `PostDatedCheques` VARCHAR(255) NOT NULL,
  `DeadlineFullSessionPayment` VARCHAR(45) NOT NULL,
  `SessionDuration` VARCHAR(45) NOT NULL,
  `MakeupLessons` VARCHAR(255) NOT NULL,
  `MergedPeriods` VARCHAR(45) NULL DEFAULT NULL,
  `Id` INT(11) NOT NULL,
  PRIMARY KEY (`Id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

-- ----------------------------------------------------------------------------
-- Table dance_school.fee_group_lessons
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `dance_school`.`fee_group_lessons` (
  `FeeId` INT(11) NOT NULL,
  `Duration` VARCHAR(45) NOT NULL,
  `Payments` VARCHAR(255) NOT NULL,
  `ShowFee` INT(11) NOT NULL DEFAULT '0',
  `FeeOrder` INT(11) NOT NULL DEFAULT '0',
  `Id` INT(11) NOT NULL,
  PRIMARY KEY (`Id`),
  INDEX `fk_fee_group_lessons_idx` (`FeeId` ASC),
  CONSTRAINT `fk_fee_group_lessons_fee`
    FOREIGN KEY (`FeeId`)
    REFERENCES `dance_school`.`fee` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

-- ----------------------------------------------------------------------------
-- Table dance_school.fee_private_lessons
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `dance_school`.`fee_private_lessons` (
  `FeeId` INT(11) NOT NULL,
  `Level` VARCHAR(45) NOT NULL,
  `Payment` VARCHAR(45) NOT NULL,
  `ShowFee` INT(11) NOT NULL DEFAULT '0',
  `FeeOrder` INT(11) NOT NULL DEFAULT '255',
  `Id` INT(11) NOT NULL,
  PRIMARY KEY (`Id`),
  INDEX `fk_fee_private_lessons_1_idx` (`FeeId` ASC),
  CONSTRAINT `fk_fee_private_lessons_fee`
    FOREIGN KEY (`FeeId`)
    REFERENCES `dance_school`.`fee` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

-- ----------------------------------------------------------------------------
-- Table dance_school.fee_special_instructions
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `dance_school`.`fee_special_instructions` (
  `FeeId` INT(11) NOT NULL,
  `LineText` VARCHAR(255) NOT NULL,
  `ShowFee` INT(11) NOT NULL DEFAULT '0',
  `FeeOrder` INT(11) NOT NULL DEFAULT '255',
  `Id` INT(11) NOT NULL,
  PRIMARY KEY (`FeeId`, `Id`),
  CONSTRAINT `fk_fee_special_instructions_fee`
    FOREIGN KEY (`FeeId`)
    REFERENCES `dance_school`.`fee` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

-- ----------------------------------------------------------------------------
-- Table dance_school.news
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `dance_school`.`news` (
  `ShowNews` TINYINT(1) NOT NULL DEFAULT '1',
  `NewsDate` VARCHAR(10) NOT NULL,
  `NewsText` VARCHAR(5000) NOT NULL,
  `ShowNewsMainPage` TINYINT(1) NOT NULL DEFAULT '0',
  `ShowNewsMainPageFlag` TINYINT(4) NOT NULL DEFAULT '2',
  `MainPageNewsText` VARCHAR(500) NULL DEFAULT NULL,
  `NewsTextShowCharsMainPage` INT(11) NOT NULL DEFAULT '0',
  `Id` INT(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`Id`),
  UNIQUE INDEX `NewsDate_UNIQUE` (`NewsDate` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 9
DEFAULT CHARACTER SET = latin1;

-- ----------------------------------------------------------------------------
-- Table dance_school.schedule
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `dance_school`.`schedule` (
  `ScheduleName` VARCHAR(45) NOT NULL,
  `IsActive` INT(11) NOT NULL DEFAULT '1',
  `FirstClass` VARCHAR(45) NOT NULL,
  `LastClass` VARCHAR(45) NOT NULL,
  `NoGroupLessons` VARCHAR(255) NULL DEFAULT NULL,
  `ScheduleOrder` TINYINT(3) UNSIGNED NOT NULL,
  `Id` INT(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`Id`),
  UNIQUE INDEX `ScheduleName_UNIQUE` (`ScheduleName` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 14
DEFAULT CHARACTER SET = cp1251;

-- ----------------------------------------------------------------------------
-- Table dance_school.schedule_detail
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `dance_school`.`schedule_detail` (
  `ScheduleId` INT(11) NOT NULL,
  `DayOfWeekId` INT(11) NOT NULL,
  `ClassId` INT(11) NOT NULL,
  `TimeFrom` VARCHAR(5) NOT NULL,
  `TimeTo` VARCHAR(5) NOT NULL,
  `Id` INT(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`Id`),
  INDEX `fk_schedule_detail_schedule_idx` (`ScheduleId` ASC),
  INDEX `fk_schedule_detail_dancing_class_idx` (`ClassId` ASC),
  INDEX `schedule_detail_dayofweek_FK` (`DayOfWeekId` ASC),
  CONSTRAINT `schedule_detail_class_FK`
    FOREIGN KEY (`ClassId`)
    REFERENCES `dance_school`.`dance_class` (`Id`),
  CONSTRAINT `schedule_detail_dayofweek_FK`
    FOREIGN KEY (`DayOfWeekId`)
    REFERENCES `dance_school`.`dayofweek` (`Id`),
  CONSTRAINT `schedule_detail_schedule_FK`
    FOREIGN KEY (`ScheduleId`)
    REFERENCES `dance_school`.`schedule` (`Id`))
ENGINE = InnoDB
AUTO_INCREMENT = 26
DEFAULT CHARACTER SET = cp1251;

-- ----------------------------------------------------------------------------
-- Table dance_school.users
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `dance_school`.`users` (
  `LoginName` VARCHAR(50) NOT NULL,
  `Password` VARCHAR(255) NOT NULL,
  `FirstName` VARCHAR(50) NOT NULL,
  `LastName` VARCHAR(50) NOT NULL,
  `Id` INT(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`Id`),
  UNIQUE INDEX `LoginNme_UNIQUE` (`LoginName` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = latin1;
SET FOREIGN_KEY_CHECKS = 1;
