
CREATE TABLE IF NOT EXISTS `notification_digest` (
  `id` int NOT NULL AUTO_INCREMENT,
  `entity_guid` bigint(20),
  `user_guid` bigint(20),
  `entry_type` text,
  `group_name` text,
  `action_type` text,
  `notification_entry` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8; 


#ALTER TABLE `notification_digest` ADD INDEX idx_notification_digest (`entity_guid`, `user_guid`);
