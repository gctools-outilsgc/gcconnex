--
-- Additional indexes for GCconnex / larger Elgg systems
--

-- entities table

-- enabled_2
CREATE INDEX enabled_2 ON entities (enabled,subtype,site_guid,type);
-- sort
CREATE INDEX sort ON entities (type,site_guid,enabled,guid);
-- type_2
CREATE INDEX type_2 ON entities (type,subtype,site_guid);
-- type_3
CREATE INDEX type_3 ON entities (type,enabled,site_guid);
-- type_enabled
CREATE INDEX type_enabled ON entities (type,enabled);
-- type_site_guid
CREATE INDEX type_site_guid ON entities (type,site_guid);


