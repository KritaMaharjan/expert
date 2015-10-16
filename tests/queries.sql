CREATE TABLE IF NOT EXISTS `user_address` (
  `id` int(11) NOT NULL,
  `is_current` tinyint(1) DEFAULT NULL COMMENT 'mark it as current( current can be only one)\n',
  `ex_users_id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL,
  `address_type_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1;


CREATE TABLE IF NOT EXISTS `user_phone` (
  `id` int(11) NOT NULL,
  `phone_id` varchar(45) DEFAULT NULL,
  `is_current` tinyint(1) DEFAULT NULL COMMENT 'mark it as current( current can be only one)\n',
  `ex_users_id` int(11) NOT NULL,
  `phones_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1;


ALTER TABLE `user_address`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_user_address_ex_user1_idx` (`ex_users_id`), ADD KEY `fk_user_address_addresses1_idx` (`address_id`), ADD KEY `fk_user_address_address_types1_idx` (`address_type_id`);

ALTER TABLE `user_phone`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_user_phone_ex_users_idx` (`ex_users_id`), ADD KEY `fk_user_phone_phones1_idx` (`phones_id`);

ALTER TABLE `user_address`
ADD CONSTRAINT `fk_user_address_address_types1` FOREIGN KEY (`address_type_id`) REFERENCES `address_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_user_address_addresses1` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_user_address_ex_users1` FOREIGN KEY (`ex_users_id`) REFERENCES `ex_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;


ALTER TABLE `user_phone`
ADD CONSTRAINT `fk_user_phone_ex_users` FOREIGN KEY (`ex_users_id`) REFERENCES `ex_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_user_phone_phones1` FOREIGN KEY (`phones_id`) REFERENCES `phones` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `user_address` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `user_phone` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ex_users` ADD `title` VARCHAR(155) NULL AFTER `remember_token`, ADD `added_by_users_id` INT NULL AFTER `title`;

ALTER TABLE `ex_users` ADD `username` VARCHAR(55) NULL AFTER `surname`;

ALTER TABLE `ex_users` ADD UNIQUE(`username`);

/* 13th August */
ALTER TABLE `new_applicant_loans` ADD `application_id` INT NOT NULL ;
ALTER TABLE `new_applicant_loans`
ADD CONSTRAINT `fk_application_loans_application1_idx` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

CREATE TABLE `applicant_phone` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `phone_id` varchar(45) DEFAULT NULL,
 `is_current` tinyint(1) DEFAULT NULL COMMENT 'mark it as current( current can be only one)\n',
 `applicants_id` int(11) NOT NULL,
 `phones_id` int(11) NOT NULL,
 PRIMARY KEY (`id`),
 KEY `fk_applicant_phone_applicants_idx` (`applicants_id`),
 KEY `fk_applicant_phone_phones1_idx` (`phones_id`),
 CONSTRAINT `fk_applicant_phone_ex_applicants` FOREIGN KEY (`applicants_id`) REFERENCES `applicants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
 CONSTRAINT `fk_applicant_phone_phones1` FOREIGN KEY (`phones_id`) REFERENCES `phones` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
)

ALTER TABLE `valuation_access`
ADD CONSTRAINT `fk_valuation_access_property1_idx` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `income`
ADD CONSTRAINT `fk_income_property1_idx` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `existing_loans`
ADD CONSTRAINT `fk_existing_loans_property1_idx` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `existing_loans`
ADD CONSTRAINT `fk_existing_loans_ownership1_idx` FOREIGN KEY (`ownership`) REFERENCES `applicants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `other_income`
ADD CONSTRAINT `fk_other_income_ownership1_idx` FOREIGN KEY (`applicant_id`) REFERENCES `applicants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;


ALTER TABLE `lenders` ADD `job_title` VARCHAR(255) NOT NULL AFTER `contact_name`, ADD `title` VARCHAR(255) NOT NULL AFTER `job_title`, ADD `preferred_name` VARCHAR(100) NOT NULL AFTER `title`, ADD `first_name` VARCHAR(55) NOT NULL AFTER `preferred_name`, ADD `last_name` VARCHAR(55) NOT NULL AFTER `first_name`, ADD `phone` VARCHAR(20) NOT NULL AFTER `last_name`, ADD `email` VARCHAR(255) NOT NULL AFTER `phone`, ADD `abn` VARCHAR(255) NOT NULL AFTER `email`, ADD `occupation` VARCHAR(255) NOT NULL AFTER `abn`, ADD `commission` DECIMAL(11,2) NOT NULL AFTER `occupation`;


ALTER TABLE `ex_client_leads_assign` ADD `added_by_users_id` INT NOT NULL AFTER `assign_to`;

ALTER TABLE `ex_client_leads_assign` ADD INDEX(`added_by_users_id`);

SET foreign_key_checks = 0;# MySQL returned an empty result set (i.e. zero rows). ALTER TABLE `ex_client_leads_assign` ADD FOREIGN KEY (`added_by_users_id`) REFERENCES `expert_finance`.`ex_users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;# MySQL returned an empty result set (i.e. zero rows). SET foreign_key_checks = 1;# MySQL returned an empty result set (i.e. zero rows).

ALTER TABLE `ex_client_leads_assign` ADD `accepted_date` DATETIME NOT NULL AFTER `added_by_users_id`;

ALTER TABLE `ex_client_leads_assign` CHANGE `accepted_date` `accepted_date` DATETIME NULL;

