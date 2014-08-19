<?php

global $CONFIG;

?>
#
# Sphinx configuration file for Elgg
#


# Your database information.  Copy details from elgg/engine/settings.php
source elgg
{
	type            = mysql

	sql_host        = <?php echo $CONFIG->dbhost; ?>
	
	sql_user        = <?php echo $CONFIG->dbuser; ?>
	
	sql_pass        = <?php echo $CONFIG->dbpass; ?>
	
	sql_db          = <?php echo $CONFIG->dbname; ?>
	
}

source entities : elgg
{
	sql_query			= \
		SELECT guid as id, guid, type, subtype, owner_guid, \
		       site_guid, container_guid, access_id, time_created, \
		       time_updated, last_action \
		FROM <?php echo $CONFIG->dbprefix; ?>entities \
		WHERE e.enabled = 'yes'

	sql_attr_uint       = guid
	sql_attr_string     = type
	sql_attr_uint       = subtype
	sql_attr_uint       = owner_guid
	sql_attr_uint       = site_guid
	sql_attr_uint       = container_guid
	sql_attr_uint       = access_id
	sql_attr_timestamp	= time_created
	sql_attr_timestamp	= time_updated
	sql_attr_timestamp	= last_action

	# sql_query_info	= SELECT * FROM <?php echo $CONFIG->dbprefix; ?>entities WHERE guid=$id

	# multi-valued attribute (MVA) attribute declaration
	# multi-value (an arbitrary number of attributes is allowed), optional
	# MVA values are variable length lists of unsigned 32-bit integers
	#
	# syntax is ATTR-TYPE ATTR-NAME 'from' SOURCE-TYPE [;QUERY] [;RANGE-QUERY]
	# ATTR-TYPE is 'uint' or 'timestamp'
	# SOURCE-TYPE is 'field', 'query', or 'ranged-query'
	# QUERY is SQL query used to fetch all ( docid, attrvalue ) pairs
	# RANGE-QUERY is SQL query used to fetch min and max ID values, similar to 'sql_query_range'
	#
	# sql_attr_multi		= uint tag from query; SELECT id, tag FROM tags
	# sql_attr_multi		= uint tag from ranged-query; \
	#	SELECT id, tag FROM tags WHERE id>=$start AND id<=$end; \
	#	SELECT MIN(id), MAX(id) FROM tags
	
	# TODO: add tags, categories as MVA's
}

source objects : entities
{
	sql_query		= \
		SELECT e.guid as id, e.guid as guid, type, subtype, owner_guid, \
		       site_guid, container_guid, access_id, time_created, \
		       time_updated, last_action, \
		       o.title as title, o.description as description \
		FROM <?php echo $CONFIG->dbprefix; ?>entities e, \
		     <?php echo $CONFIG->dbprefix; ?>objects_entity o \
		WHERE o.guid = e.guid AND e.enabled = 'yes'

	sql_query_info		= \
		SELECT guid, title \
		FROM <?php echo $CONFIG->dbprefix; ?>objects_entity \
		WHERE guid=$id

}

source groups : entities
{
	sql_query		= \
		SELECT e.guid as id, e.guid as guid, type, subtype, owner_guid, \
		       site_guid, container_guid, access_id, time_created, \
		       time_updated, last_action, \
		       g.name as name, g.description as description \
		FROM <?php echo $CONFIG->dbprefix; ?>entities e, \
		     <?php echo $CONFIG->dbprefix; ?>groups_entity g \
		WHERE g.guid = e.guid AND e.enabled = 'yes'

	sql_query_info		= \
		SELECT guid, name \
		FROM <?php echo $CONFIG->dbprefix; ?>groups_entity \
		WHERE guid=$id
}

source users : entities
{
	sql_query		= \
		SELECT e.guid as id, e.guid as guid, type, subtype, owner_guid, \
		       site_guid, container_guid, access_id, time_created, \
		       time_updated, e.last_action, \
		       u.name as name, u.username as username \
		FROM <?php echo $CONFIG->dbprefix; ?>entities e, \
		     <?php echo $CONFIG->dbprefix; ?>users_entity u \
		WHERE u.guid = e.guid AND e.enabled = 'yes'

	sql_query_info		= \
		SELECT guid, name, username \
		FROM <?php echo $CONFIG->dbprefix; ?>users_entity \
		WHERE guid=$id
}

index groups
{
	source          = groups
	path            = <?php echo $CONFIG->dataroot; ?>sphinx/indexes/groups
	prefix_fields   = name
	min_prefix_len	= 3
	min_word_len = 3
	enable_star = 1
	morphology  = stem_en, soundex, metaphone
	html_strip = 1
	expand_keywords = 1
}

index objects
{
	source          = objects
	path            = <?php echo $CONFIG->dataroot; ?>sphinx/indexes/objects
	prefix_fields   = title
	min_prefix_len	= 3
	min_word_len = 3
	enable_star = 1
	morphology  = stem_en, soundex, metaphone
	html_strip = 1
	expand_keywords = 1
}

index users
{
	source          = users
	path            = <?php echo $CONFIG->dataroot; ?>sphinx/indexes/users
	prefix_fields   = name, username
	min_prefix_len	= 3
	min_word_len = 3
	enable_star = 1
	morphology  = stem_en, soundex, metaphone
	html_strip = 1
	expand_keywords = 1
}

indexer
{
	mem_limit       = 256M
}

searchd
{
	listen          = 9312
	listen          = 9306:mysql41
	log             = <?php echo $CONFIG->dataroot; ?>sphinx/log/searchd.log
	query_log       = <?php echo $CONFIG->dataroot; ?>sphinx/log/query.log
	read_timeout    = 5
	client_timeout	= 300
	max_children    = 30
	pid_file        = <?php echo $CONFIG->dataroot; ?>sphinx/log/searchd.pid
	binlog_path 	= <?php echo $CONFIG->dataroot; ?>sphinx/log
	max_matches     = 1000
	seamless_rotate = 1
	preopen_indexes = 1
	unlink_old      = 1
	mva_updates_pool	= 1M
	max_packet_size		= 8M
	max_filters		= 256
	max_filter_values	= 4096
	max_batch_queries	= 32
	workers         = threads # for RT to work
	compat_sphinxql_magics = 0
}
