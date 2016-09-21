<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Called from AJAX and decides which set of inputs to return.
 */
$graph_type = $vars['graph_type'];

switch($graph_type) {
	case 'missions:stacked_graph':
		echo elgg_view('page/elements/stacked-graph-inputs');
		break;
	case 'missions:histogram':
		echo elgg_view('page/elements/histogram-inputs');
		break;
	case 'missions:top_skills':
		$top_skills = getTopSkills(10);
		$top_skills_string = '<table class="wb-charts wb-charts-bar table">';
		$top_skills_string .= "<tr><td>" .elgg_echo('missions:skill'). "</td> <td> # </td> </tr>";
		foreach ($top_skills as $key => $value) {
			$top_skills_string .= "<tr> <th> $key </th> <td> $value </td> </tr>";
		}
		$top_skills_string .= '</table>';
		echo $top_skills_string;
		break;
	default:
		echo '';
}