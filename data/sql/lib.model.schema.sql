
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

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
