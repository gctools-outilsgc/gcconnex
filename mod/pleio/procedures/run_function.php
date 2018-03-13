<?php
set_time_limit(0);

if (PHP_SAPI !== "cli") {
    throw new Exception("Only accessable from the CLI");
}

$input = json_decode(base64_decode($argv[1]), true);
if (!$input) {
    throw new Exception("Invalid input");
}

$_SERVER["HTTP_HOST"] = $input["http_host"];
$_SERVER["HTTPS"] = $input["https"];

foreach ($input["env"] as $key => $value) {
    putenv("${key}=$value");
}

require_once(dirname(__FILE__) . "/../../../engine/start.php");

if (function_exists($input["function"])) {
    call_user_func($input["function"], $input["param"]);
}
