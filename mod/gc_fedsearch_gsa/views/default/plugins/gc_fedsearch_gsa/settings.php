<?php

$gsa_agentstring = $vars['entity']->gsa_agentstring;
if (!$gsa_agentstring) { $vars['entity']->gsa_agentstring = 'gsa-crawler'; }	

// agent string of the crawler
$gsa_user_agentstring_label = "<label>Federated Search GSA Agent-String</label>";
$gsa_user_agentstring = elgg_view('input/text', array(
	'name' => 'params[gsa_agentstring]',
	'value' => $vars['entity']->gsa_agentstring));

// parameters that needs to be passed in and redirect to intranet result page
$gsa_param_keyvalue_label = "<label>Parameters for the GSA federated search page (Parameter name and Parameter value)</label>";
$gsa_param_key = elgg_view('input/text', array(
	'name' => 'params[gsa_param_key]',
	'value' => $vars['entity']->gsa_param_key));
$gsa_param_value = elgg_view('input/text', array(
	'name' => 'params[gsa_param_value]',
	'value' => $vars['entity']->gsa_param_value));

// for testing purposes 
$gsa_user_test_label = "<label>Username to be tested (please leave empty in production)</label>";
$gsa_user_test = elgg_view('input/text', array( 
	'name' => 'params[gsa_test]',
	'value' => $vars['entity']->gsa_test));


// css settings
$gsa_results_pagination_label = "<label>CSS setting for pagination</label>";
$gsa_results_pagination = elgg_view('input/text', array(
	'name' => 'params[gsa_pagination]',
	'value' => $vars['entity']->gsa_pagination));


// display to page
echo "<br/><br/>";
echo "<p>{$gsa_user_agentstring_label}{$gsa_user_agentstring}</p>";
echo "<p>{$gsa_param_keyvalue_label}{$gsa_param_key}{$gsa_param_value}</p>";
echo "<p>{$gsa_user_test_label}{$gsa_user_test}</p>";
echo "<p>{$gsa_results_pagination_label}{$gsa_results_pagination}</p>"; 
 