<?php
/*
 * Preset all plugin settings.
 */
elgg_set_plugin_setting('mission_version', 13, 'missions');

elgg_set_plugin_setting('search_limit', '100', 'missions');
elgg_set_plugin_setting('river_message_limit', '100', 'missions');
elgg_set_plugin_setting('advanced_element_limit', 6, 'missions');
elgg_set_plugin_setting('river_element_limit', 10, 'missions');
elgg_set_plugin_setting('search_result_per_page', 9, 'missions');
elgg_set_plugin_setting('mission_developer_tools_on', 'NO', 'missions');
elgg_set_plugin_setting('mission_analytics_on', 'YES', 'missions');
elgg_set_plugin_setting('mission_front_page_limit', 3, 'missions');

elgg_set_plugin_setting('mission_card_height', 450, 'missions');
elgg_set_plugin_setting('mission_card_width', 360, 'missions');

elgg_set_plugin_setting('mission_max_applicants', 10, 'missions');

elgg_set_plugin_setting('mission_job_title_card_cutoff', 50, 'missions');
elgg_set_plugin_setting('mission_session_variable_timeout', 300, 'missions');

$hour_string = ',00,01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23';
elgg_set_plugin_setting('hour_string', $hour_string, 'missions');

// $minute_string = ' ,00,01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,31,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59';
$minute_string = ',00,15,30,45';
elgg_set_plugin_setting('minute_string', $minute_string, 'missions');

$language_string = ',A,B,C';
elgg_set_plugin_setting('language_string', $language_string, 'missions');

$day_string = 'missions:mon' . ',' . 'missions:tue' . ',' . 'missions:wed' . ',' . 'missions:thu' . ','
		. 'missions:fri' . ',' . 'missions:sat' . ',' . 'missions:sun';
elgg_set_plugin_setting('day_string', $day_string, 'missions');

$security_string = ',' . 'missions:reliability' . ',' . 'missions:enhanced_reliability' . ',' . 'missions:secret' . ',' . 'missions:top_secret';
elgg_set_plugin_setting('security_string', $security_string, 'missions');

$timezone_string = ',missions:timezone:three_half,missions:timezone:four,missions:timezone:five,missions:timezone:six,missions:timezone:seven,missions:timezone:eight,missions:timezone:nine';
elgg_set_plugin_setting('timezone_string', $timezone_string, 'missions');

$duration_string = ',1,2,3,4,5,6,7,8';
elgg_set_plugin_setting('duration_string', $duration_string, 'missions');

$time_rate_string = 'missions:total' . ',' . 'missions:per_day' . ',' . 'missions:per_week' . ',' . 'missions:per_month';
elgg_set_plugin_setting('time_rate_string', $time_rate_string, 'missions');

/*$opportunity_type_string = 'missions:micro_mission' . ',' . 'missions:job_swap' . ',' . 'missions:mentoring' . ','
		. 'missions:shadowing' . ',' . 'missions:peer_coaching' . ',' . 'missions:skill_sharing' . ','
				. 'missions:job_sharing';*/
$opportunity_type_string = 'missions:micro_mission' . ',' . 'missions:mentoring' . ',' . 'missions:job_swap' . ',' . 'missions:job_shadowing' .','. 'missions:assignment' .','. 'missions:deployment' .','. 'missions:job_rotation' .','. 'missions:skill_share' .','. 'missions:peer_coaching' .','. 'missions:job_share';
elgg_set_plugin_setting('opportunity_type_string', $opportunity_type_string, 'missions');

$province_string = ',' . 'missions:alberta' . ',' . 'missions:british_columbia' . ',' . 'missions:manitoba' . ','
		. 'missions:new_brunswick' . ',' . 'missions:newfoundland_and_labrador' . ',' . 'missions:northwest_territories' . ','
				. 'missions:nova_scotia' . ',' . 'missions:nunavut' . ',' . 'missions:ontario' . ','
						. 'missions:prince_edward_island' . ',' . 'missions:quebec' . ',' . 'missions:saskatchewan' . ','
								. 'missions:yukon' . ',' . 'missions:national_capital_region';
elgg_set_plugin_setting('province_string', $province_string, 'missions');

$program_area_string = ',' . 'missions:science' . ',' . 'missions:information_technology' . ',' . 'missions:administration' . ','
		. 'missions:human_resources' . ',' . 'missions:finance' . ',' . 'missions:legal_regulatory' . ','
				. 'missions:security_enforcement' . ',' . 'missions:communications' . ',' . 'missions:policy' . ','
						. 'missions:client_service';
elgg_set_plugin_setting('program_area_string', $program_area_string, 'missions');

$decline_reason_string = ',' . 'missions:decline:workload' . ',' . 'missions:decline:interest' . ',' . 'missions:decline:engagement'  . ','
		. 'missions:decline:approval'  . ',' . 'missions:other';
elgg_set_plugin_setting('decline_reason_string', $decline_reason_string, 'missions');

//Nick - adding string for group classification
$gl_group_string = ',' .'AC,AG,AI,AO,AR,AS,AU,BI,CH,CM,CO,CR,CS,CX,DA,DD,DE,DS,EC,ED,EG,EL,EN,EU,EX,FB,FI,FO,FR,FS,GL,GS,GT,HP,HR,HS,IS,LC,LI,LP,LS,MA,MD,MT,ND,NU,OE,OM,OP,PC,PE,PG,PH,PI,PM,PO,PR(NON-S),PR(S),PS,PY,RO,SC,SE,SG,SO,SR(C),SR(E),SR(W),ST,SW,TI,TR,UT,VM,WP,';
elgg_set_plugin_setting('gl_group_string', $gl_group_string, 'missions');
