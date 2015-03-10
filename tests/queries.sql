CREATE  TABLE IF NOT EXISTS `FastBook`.`profile` (
  `user_id` INT NOT NULL ,
  `personal_email_setting` TEXT NULL ,
  `support_email_setting` TEXT NULL ,
  `social_security_number` INT NULL ,
  `phone` BIGINT(15) NULL ,
  `address` VARCHAR(100) NULL ,
  `postcode` VARCHAR(10) NULL ,
  `town` VARCHAR(45) NULL ,
  `comment` TEXT NULL ,
  `taxt_card` VARCHAR(15) NULL ,
  `vacation_fund_percentage` FLOAT NULL )
ENGINE = InnoDB;

CREATE  TABLE IF NOT EXISTS `customers` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT 'customer id\n' ,
  `user_id` INT NOT NULL ,
  `type` TINYINT(1) NULL DEFAULT 1 COMMENT '1 - human\n2 - company' ,
  `name` VARCHAR(45) NULL COMMENT 'name of a customer (human or company)' ,
  `dob` DATE NULL COMMENT 'dob of human' ,
  `street_name` VARCHAR(70) NULL COMMENT 'street address of a customer' ,
  `street_number` VARCHAR(15) NULL COMMENT 'street number of a customer' ,
  `postcode` VARCHAR(10) NULL COMMENT 'postcode of a customer' ,
  `town` VARCHAR(55) NULL COMMENT 'town of a customer' ,
  `telephone` BIGINT(15) NULL COMMENT 'telephone number of a customer' ,
  `mobile` BIGINT(15) NULL COMMENT 'mobile number of customer' ,
  `image` VARCHAR(50) NULL COMMENT 'image or logo of a customer' ,
  `status` TINYINT(1) NULL DEFAULT 1 COMMENT '1 - active\n0 - inactive' ,
  `created_at` TIMESTAMP NULL COMMENT 'created date of a customer' ,
  `updated_at` TIMESTAMP NULL COMMENT 'updated date of a customer' ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
COMMENT = 'Customer of a tenant';

ALTER TABLE `fb_users` CHANGE `status` `status` INT(10) UNSIGNED NOT NULL COMMENT '1: activated, 2: pending, 3: blocked';