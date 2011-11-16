
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- user
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user`
(
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`username` VARCHAR(255),
	`username_canonical` VARCHAR(255),
	`email` VARCHAR(255),
	`email_canonical` VARCHAR(255),
	`enabled` TINYINT(1),
	`algorithm` VARCHAR(50) NOT NULL,
	`salt` VARCHAR(255) NOT NULL,
	`password` VARCHAR(255) NOT NULL,
	`last_login` DATETIME,
	`locked` TINYINT(1),
	`expires_at` DATETIME,
	`confirmation_token` VARCHAR(255),
	`password_requested_at` DATETIME,
	`credentials_expire_at` DATETIME,
	`super_admin` TINYINT(1),
	PRIMARY KEY (`id`),
	UNIQUE INDEX `user_U_1` (`username_canonical`),
	UNIQUE INDEX `user_U_2` (`email_canonical`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- user_role
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user_role`;

CREATE TABLE `user_role`
(
	`user_id` INTEGER NOT NULL,
	`role_id` INTEGER NOT NULL,
	PRIMARY KEY (`user_id`,`role_id`),
	INDEX `user_role_FI_2` (`role_id`),
	CONSTRAINT `user_role_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `user` (`id`),
	CONSTRAINT `user_role_FK_2`
		FOREIGN KEY (`role_id`)
		REFERENCES `role` (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- role
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `role`;

CREATE TABLE `role`
(
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- group
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `group`;

CREATE TABLE `group`
(
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- group_role
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `group_role`;

CREATE TABLE `group_role`
(
	`group_id` INTEGER NOT NULL,
	`role_id` INTEGER NOT NULL,
	PRIMARY KEY (`group_id`,`role_id`),
	INDEX `group_role_FI_2` (`role_id`),
	CONSTRAINT `group_role_FK_1`
		FOREIGN KEY (`group_id`)
		REFERENCES `group` (`id`),
	CONSTRAINT `group_role_FK_2`
		FOREIGN KEY (`role_id`)
		REFERENCES `role` (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- user_group
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user_group`;

CREATE TABLE `user_group`
(
	`user_id` INTEGER NOT NULL,
	`group_id` INTEGER NOT NULL,
	PRIMARY KEY (`user_id`,`group_id`),
	INDEX `user_group_FI_2` (`group_id`),
	CONSTRAINT `user_group_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `user` (`id`),
	CONSTRAINT `user_group_FK_2`
		FOREIGN KEY (`group_id`)
		REFERENCES `group` (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- pull_request
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `pull_request`;

CREATE TABLE `pull_request`
(
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`user_id` INTEGER NOT NULL COMMENT 'The use who have create the pull request',
	`title` VARCHAR(255) NOT NULL,
	`description` TEXT,
	`repository_src_id` INTEGER NOT NULL COMMENT 'The from repository',
	`repository_src_branch` VARCHAR(255) NOT NULL,
	`repository_target_id` INTEGER NOT NULL COMMENT 'The target repository',
	`repository_target_branch` VARCHAR(255) NOT NULL,
	`start_rev` VARCHAR(255) NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `pull_request_FI_1` (`user_id`),
	INDEX `pull_request_FI_2` (`repository_src_id`),
	INDEX `pull_request_FI_3` (`repository_target_id`),
	CONSTRAINT `pull_request_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `user` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	CONSTRAINT `pull_request_FK_2`
		FOREIGN KEY (`repository_src_id`)
		REFERENCES `repository` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	CONSTRAINT `pull_request_FK_3`
		FOREIGN KEY (`repository_target_id`)
		REFERENCES `repository` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- repository
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `repository`;

CREATE TABLE `repository`
(
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`user_id` INTEGER NOT NULL,
	`name` VARCHAR(255) NOT NULL COMMENT 'The repository name',
	`description` VARCHAR(555),
	`bare_path` TEXT COMMENT 'The path to find the repository in server related to app/',
	`clone_path` TEXT COMMENT 'The path to find the clonned repository in server related to app/',
	`forked_from_id` INTEGER COMMENT 'The original repository',
	`forked_at` VARCHAR(555) COMMENT 'The hash of the last commint on the main repository when you fork',
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `repository_U_1` (`name`, `user_id`),
	INDEX `repository_I_1` (`name`),
	INDEX `repository_FI_1` (`user_id`),
	INDEX `repository_FI_2` (`forked_from_id`),
	CONSTRAINT `repository_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `user` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	CONSTRAINT `repository_FK_2`
		FOREIGN KEY (`forked_from_id`)
		REFERENCES `repository` (`id`)
		ON UPDATE CASCADE
		ON DELETE SET NULL
) ENGINE=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
