<?php

/**
 * MySQL database table setup: tracks all the content deletion, this would only store fragment of the information
 * The main purpose for this is for updating the Solr Indexing Documents, removing removed records or content
 */

run_sql_script(__DIR__ . '/install/mysql.sql');


/**
 * Note: If there is already an existing table, please make sure to fully clear the indices
 */