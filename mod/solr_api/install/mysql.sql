CREATE TABLE IF NOT EXISTS `deleted_object_tracker` (
	`id` bigint(20) NOT NULL,
	`time_deleted` int(11),
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8