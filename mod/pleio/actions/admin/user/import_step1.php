<?php

$forward_url = REFERER;

if(($csv = get_uploaded_file("csv")) && !empty($csv)){
    $tmp_location = $_FILES["csv"]["tmp_name"];

    if($fh = fopen($tmp_location, "r")){
        $columns = fgetcsv($fh, 0, ";");
        $sample = fgetcsv($fh, 0, ";");

        if ($columns && $sample) {
            $new_location = tempnam(sys_get_temp_dir(), "import_" . get_config("site_guid"));
            move_uploaded_file($tmp_location, $new_location);

            $_SESSION["import"] = array(
                "location" => $new_location,
                "columns" => $columns,
                "sample" => $sample
            );

            $forward_url = elgg_get_site_url() . "admin/users/import?step=2";

            system_message(elgg_echo("pleio:users_import:step1:success"));
        } else {
            register_error(elgg_echo("pleio:users_import:step1:error"));
        }
    } else {
        register_error(elgg_echo("pleio:users_import:step1:error"));
    }
} else {
    register_error(elgg_echo("pleio:users_import:step1:error"));
}

forward($forward_url);