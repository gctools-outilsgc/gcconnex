
CREATE TABLE IF NOT EXISTS `notification_digest` (
  `id` int NOT NULL AUTO_INCREMENT, 
  `user_guid` bigint(20),
  `entry_type` text, 
  `notification_entry` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8; 
