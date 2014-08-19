<?php
/**
 * Provide a way of setting your language prefs
 *
 * @package Elgg
 * @subpackage Core
 */

if ($user = elgg_get_page_owner_entity()) {
	translation_editor_unregister_translations();
	
	$translations = get_installed_translations();
	
	$value = $CONFIG->language;
	if (!empty($user->language)) {
		$value = $user->language;
	}
	
	if(count($translations ) > 1){
	?>
	<div class="elgg-module elgg-module-info">
		<div class="elgg-head">
			<h3><?php echo elgg_echo('user:set:language'); ?></h3>
		</div>
		<div class="elgg-body">
			<p>
				<?php echo elgg_echo('user:language:label'); ?>:
				<?php
				echo elgg_view("input/dropdown", array(
					'name' => 'language',
					'value' => $value,
					'options_values' => $translations 
				));
				?>
			</p>
		</div>
	</div>
	<?php
	} else {
		echo elgg_view("input/hidden", array("name" => "language", "value" => $value));
	}
}