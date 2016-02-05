<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
 
/*
 * Page which allows a mission applicant to create a foreword for their application.
 * The rest of their application is automatically generated according to their profile.
 */
gatekeeper();

$current_uri = $_SERVER['REQUEST_URI'];
$blast_radius = explode('/', $current_uri);
$entity = get_entity(array_pop($blast_radius));

$title = elgg_echo('missions:apply_for_mission', array($entity->job_title));

elgg_push_breadcrumb(elgg_echo('missions:micromissions'), elgg_get_site_url() . 'missions/main');
elgg_push_breadcrumb($entity->job_title, $entity->getURL());
elgg_push_breadcrumb($title);

$content = elgg_view_title($title);
$content .= elgg_echo('missions:application_paragraph');
$content .= '<div class="col-sm-offset-1">' . elgg_view_form('missions/application-form', array(
    'class' => 'form-horizontal'
)) . '</div>';

$body = elgg_view_layout('one_sidebar', array(
    'content' => $content
));

echo elgg_view_page($title, $content);