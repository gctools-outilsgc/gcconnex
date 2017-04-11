<?php
/**
 * Elgg API Admin
 * Form for adding an API key
 * 
 * @package ElggAPIAdmin
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * 
 * @author Curverider Ltd
 * @copyright Curverider Ltd 2011
 * @link http://www.elgg.org
*/

$ref_label = elgg_echo('apiadmin:yourref');
$ref_control = elgg_view('input/text', array('name' => 'ref'));
$gen_control = elgg_view('input/submit', array('value' => elgg_echo('apiadmin:generate')));

echo <<<END
	<div class="contentWrapper">
		<p>$ref_label: $ref_control $gen_control</p>
	</div>
END;
