<p>This plugin uses elements from the Bootstrap framework. Without Bootstrap the file input will not display or function correctly. If your site does not have Bootstrap loaded, you can enable a modified version of Bootstrap to be loaded below. This version will only be loaded on the file upload page.</p>
<?php
$plugin = $vars["entity"];

$name = "load_custom_bs";

$checkbox_options = array("name" => "params[" . $name . "]", "value" => "1", 'label' => "Load modified bootstrap");
if ($plugin->$name == "1") {
    $checkbox_options["checked"] = "checked";
}

$body .= '<div>'.elgg_view("input/checkbox", $checkbox_options).'</div>';

echo $body;
?>