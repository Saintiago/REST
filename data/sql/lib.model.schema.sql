
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- video
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `video`;


CREATE TABLE `video`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255)  NOT NULL,
	`width` INTEGER,
	`height` INTEGER,
	`video_bitrate` FLOAT,
	`audio_bitrate` FLOAT,
	`user_id` INTEGER  NOT NULL,
	`filename` VARCHAR(255),
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`)
)Engine=InnoDB;

#-----------------------------------------------------------------------------
#-- status
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `status`;


CREATE TABLE `status`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255)  NOT NULL,
	PRIMARY KEY (`id`)
)Engine=InnoDB;

#-----------------------------------------------------------------------------
#-- queue
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `queue`;


CREATE TABLE `queue`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`video_id` INTEGER  NOT NULL,
	`status` INTEGER  NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `queue_FI_1` (`video_id`),
	CONSTRAINT `queue_FK_1`
		FOREIGN KEY (`video_id`)
		REFERENCES `video` (`id`)
		ON DELETE CASCADE,
	INDEX `queue_FI_2` (`status`),
	CONSTRAINT `queue_FK_2`
		FOREIGN KEY (`status`)
		REFERENCES `status` (`id`)
		ON DELETE CASCADE
)Engine=InnoDB;

#-----------------------------------------------------------------------------
#-- video_link
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `video_link`;


CREATE TABLE `video_link`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`original` INTEGER  NOT NULL,
	`converted` INTEGER  NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `video_link_FI_1` (`original`),
	CONSTRAINT `video_link_FK_1`
		FOREIGN KEY (`original`)
		REFERENCES `video` (`id`)
		ON DELETE CASCADE,
	INDEX `video_link_FI_2` (`converted`),
	CONSTRAINT `video_link_FK_2`
		FOREIGN KEY (`converted`)
		REFERENCES `video` (`id`)
		ON DELETE CASCADE
)Engine=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
