<?php

elgg_make_sticky_form('ticket-submit');

//get values from form
$api_key = elgg_get_plugin_setting("apikey", "freshdesk_help");
$yourdomain = elgg_get_plugin_setting("domain", "freshdesk_help");

//create ticket
$ticket_data = array(
  "description" => get_input('description'),
  "subject" => get_input('subject'),
  "email" => get_input('email'),
  "priority" => 1,
  "status" => 2,
  'source' => 2,
  "product_id" => (int) elgg_get_plugin_setting("product_id", "freshdesk_help"),
);

$url = "https://".$yourdomain.".freshdesk.com/api/v2/tickets";

$ch = curl_init($url);

//json if no file present
if(empty($_FILES['attachment']['name'])){
  $ticket_data = json_encode($ticket_data);
  $header[] = "Content-type: application/json";
  curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
//add file to ticket data
} else {
  $ticket_data["attachments[]"] = curl_file_create((string) $_FILES['attachment']["tmp_name"], (string) $_FILES['attachment']['type'], (string) $_FILES['attachment']['name']);
}

curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_USERPWD, "$api_key:x");
curl_setopt($ch, CURLOPT_POSTFIELDS, $ticket_data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

$server_output = curl_exec($ch);
$info = curl_getinfo($ch);
$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$headers = substr($server_output, 0, $header_size);
$response = substr($server_output, $header_size);

if($info['http_code'] == 201) {
  system_message(elgg_echo('freshdesk:ticket:submit:confirmed'));
  elgg_clear_sticky_form('ticket-submit');
} else {
  error_log('freshdesk debug -> '.$response);
  register_error(elgg_echo('freshdesk:ticket:submit:denied').$info['http_code']);
}

curl_close($ch);

?>
