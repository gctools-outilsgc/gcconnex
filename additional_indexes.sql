--
-- Additional indexes for GCconnex / larger Elgg systems
--

-- entities table

-- enabled_2
CREATE INDEX `enabled_2` ON `prefix_entities` (enabled,subtype,site_guid,type);
-- sort
CREATE INDEX `sort` ON `prefix_entities` (type,site_guid,enabled,guid);
-- type_2
CREATE INDEX `type_2` ON `prefix_entities` (type,subtype,site_guid);
-- type_3
CREATE INDEX `type_3` ON `prefix_entities` (type,enabled,site_guid);
-- type_enabled
CREATE INDEX `type_enabled` ON `prefix_entities` (type,enabled);
-- type_site_guid
CREATE INDEX `type_site_guid` ON `prefix_entities` (type,site_guid);


-- metadata table

-- metapairs	-> likely the most important one to add, speeds up query by metadata 
CREATE INDEX `metapairs` ON `prefix_metadata` (value_id,name_id);
-- metapairs_plus
CREATE INDEX `metapairs_plus` ON `prefix_metadata` (entity_guid,value_id,name_id);


-- objects_entity

-- fulltext_title
CREATE FULLTEXT INDEX `fulltext_title` ON `prefix_objects_entity` (title);
-- title_2
CREATE INDEX `title_2` ON `prefix_objects_entity` (title);


-- river
-- obj_tar_ena_post
CREATE INDEX `obj_tar_ena_post` ON `prefix_river` (object_guid,target_guid,enabled,posted);



-- remove access_id index from the entities table - necessary for the newsfeed queries
DROP INDEX `access_id` ON `prefix_entities`;