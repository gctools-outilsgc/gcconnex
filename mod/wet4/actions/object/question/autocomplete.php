<?php

$name = get_input('name');
$owner = get_input('owner');

//return question
echo json_encode([
    'question' => $content,
]);
?>
