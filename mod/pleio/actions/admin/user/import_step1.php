<?php
$forward_url = REFERER;

$directory = elgg_get_config("dataroot") . 'tmp/';
if(!file_exists($directory)) {
    mkdir($directory, 0755, true);
}

if(($csv = get_uploaded_file("csv")) && !empty($csv)){
    $tmp_location = $_FILES["csv"]["tmp_name"];

    if($fh = fopen($tmp_location, "r")){
        $columns = fgetcsv($fh, 0, ";");
        $sample = fgetcsv($fh, 0, ";");

        if ($columns && $sample) {
            $location =  $directory . get_config("site_guid") . '.csv';
            move_uploaded_file($tmp_location, $location);

            $_SESSION["import"] = array(
                "location" => $location,
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