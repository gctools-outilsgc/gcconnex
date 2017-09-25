<?php
global $CONFIG;

function apiadmin_deltree($dirname) {
    // Sanity check
    if ( !file_exists($dirname) ) { return false; }
    // Simple delete if it is an ordinary file or link
    if ( is_file($dirname) || is_link($dirname) ) {
        return unlink($dirname);
    }
    // Loop through each entry in the folder
    $dir = dir($dirname);
    while ( false !== ($entry = $dir->read()) ) {
        // Skip special pointers
        if ( $entry == '.' || $entry == '..' ) {
            continue;
        }
        // Recurse - if $entry is a file, this method will delete it and return
        elgglp_deltree("$dirname/$entry");
    }
    // Clean up
    $dir->close();
    return rmdir($dirname);
}

// if user doesn't need stats tables to be kept
if ( elgg_get_plugin_setting('keep_tables', 'apiadmin') != 'on' ) {
    // delete stats tables
    run_sql_script("{$CONFIG->path}mod/apiadmin/schema/mysql_undo.sql");
}

if ( is_dir($browscapdir = elgg_get_data_path() . 'phpbrowscap') ) {
    apiadmin_deltree($browscapdir);
}

// plugin can be deactivated
return true;
