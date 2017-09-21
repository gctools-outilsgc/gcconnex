<?php

global $CONFIG;

$query = "CREATE TABLE IF NOT EXISTS email_invitations (id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY (id), email CHAR(255), inviter INT, invitee INT, time_sent INT, time_accepted INT)";

$connection = mysqli_connect($CONFIG->dbhost, $CONFIG->dbuser, $CONFIG->dbpass, $CONFIG->dbname);
if (mysqli_connect_errno($connection)) elgg_log("gcRegistration_invitation - Failed to connect to MySQL: ".mysqli_connect_errno(), 'NOTICE');
$result = mysqli_query($connection,$query);
mysqli_close($connection);
