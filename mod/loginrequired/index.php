<?php
/**
 * Elgg index page for web-based applications
 *
 * @package Elgg
 * @subpackage Core
 */

//grab the login form
$login = elgg_view("core/account/login_box");

$params = array('login' => $login);

$body = elgg_view_layout('loginrequired_index', $params);
echo elgg_view_page('', $body);
