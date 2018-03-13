<?php
$id = (int) get_input("id");
$result = get_input("result");

$accessRequests = new ModPleio\AccessRequests();
$accessRequest = $accessRequests->get($id);

if (!$accessRequest) {
    register_error("pleio:could_not_find");
    forward(REFERER);
}

if ($result == "approve") {
    if ($accessRequest->approve()) {
        
    }
} elseif ($result == "decline") {
    $accessRequest->decline();
}

forward(REFERER);