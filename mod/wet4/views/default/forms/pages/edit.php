<?php
/**
 * Page edit form body
 *
 * @package ElggPages
 */
 /*
 * GC_MODIFICATION
 * Description: Added accessible labels + content translation support
 * Author: GCTools Team
 */
$variables = elgg_get_config('pages');
$user = elgg_get_logged_in_user_entity();
$entity = elgg_extract('entity', $vars);
$can_change_access = true;
if ($user && $entity) {
	$can_change_access = ($user->isAdmin() || $user->getGUID() == $entity->owner_guid);
}

$title = elgg_extract('title', $vars, '');
$title2 = elgg_extract('title2', $vars, '');
$desc = elgg_extract('description', $vars, '');
$desc2 = elgg_extract('description2', $vars, '');

// decode json into English / French parts
$json_title = json_decode($title);
$json_desc = json_decode($desc);

if ( $json_title ){
  $vars['title2'] = $json_title->fr;
  $vars['title'] = $json_title->en;
}

if ( $json_desc ){
    $vars['description2'] = $json_desc->fr;
  $vars['description'] = $json_desc->en;
}


$btn_language =  '<ul class="nav nav-tabs nav-tabs-language">
  <li id="btnen"><a href="#" id="btnClicken">'.elgg_echo('lang:english').'</a></li>
  <li id="btnfr"><a href="#" id="btnClickfr">'.elgg_echo('lang:french').'</a></li>
</ul>';

echo $btn_language;

echo '<div class="tab-content tab-content-border">';
foreach ($variables as $name => $type) {
	// don't show read / write access inputs for non-owners or admin when editing
	if (($type == 'access' || $type == 'write_access') && !$can_change_access) {
		continue;
	}

	// don't show parent picker input for top or new pages.
	if ($name == 'parent_guid' && (!$vars['parent_guid'] || !$vars['guid'])) {
		continue;
	}

	if ($type == 'parent') {
		$input_view = "pages/input/$type";
	} else {
		$input_view = "input/$type";
	}
if (($name == 'title2') || ($name == 'description2')){

		echo '<div class="form-group fr">';
		}elseif (($name == 'title') || ($name == 'description')){

			echo '<div class="form-group en">';
		}else{
			echo '<div class="form-group ">';
		}
?>


	<label for="<?php echo $name; ?>"><?php echo elgg_echo("pages:$name") ?></label>
	<?php
		if ($type != 'longtext') {
			echo '<br />';
		}


		$view_vars = array(
			'name' => $name,
			'value' => $vars[$name],
            'id' => $name,
			'entity' => ($name == 'parent_guid') ? $vars['entity'] : null,
		);


		if ($input_view === 'input/access' || $input_view === 'input/write_access') {
			$view_vars['entity'] = $entity;
			$view_vars['entity_type'] = 'object';
			$view_vars['entity_subtype'] = $vars['parent_guid'] ? 'page': 'page_top';

			if ($name === 'write_access_id') {
				$view_vars['purpose'] = 'write';
				if ($entity) {
					$view_vars['value'] = $entity->write_access_id;

					// no access change warning for write access input
					$view_vars['entity_allows_comments'] = false;
				}
			}
		}

		echo elgg_view($input_view, $view_vars);
	?>
</div>
<?php
}

$cats = elgg_view('input/categories', $vars);
if (!empty($cats)) {
	echo $cats;
}

if (elgg_is_active_plugin('cp_notifications') && !$vars['new_entity']) {
	// cyu - implement "minor edit" as per business requirements document
	// this view is used by both creating new page and edit new page

	echo "<h2>".elgg_echo('cp_notify:minor_edit_header')."</h2>";
    echo '<div class="checkbox">';
    echo elgg_view('input/checkboxes', array(
			'name' => 'chk_page_minor_edit',
            'label'=>elgg_echo('page:minor_edit_label'),
			'id' => 'chk_page_minor_edit',
			'value' => 0,
			'options' => array(
					elgg_echo('cp_notify:minor_edit') => 1),
		));

	/* cyu - see note:
	 * upon new entity creation, it invokes two functions (event and hook) in the start.php of this plugin
	 * we need to make sure that we invoke sending notifcations only once, mark the second function as
	 * minor edit by default
	 */
	if ($vars['new_entity'])
		$entity->entity_minor_edit = true;

	echo '</div>';
}

echo '<div class="elgg-foot">';
if ($vars['guid']) {
	echo elgg_view('input/hidden', array(
		'name' => 'page_guid',
		'value' => $vars['guid'],
	));
}
echo elgg_view('input/hidden', array(
	'name' => 'container_guid',
	'value' => $vars['container_guid'],
));
if (!$vars['guid']) {
	echo elgg_view('input/hidden', array(
		'name' => 'parent_guid',
		'value' => $vars['parent_guid'],
	));
}




if($vars['guid']){
    echo elgg_view('input/submit', array('value' => elgg_echo('save'), 'class' => 'btn btn-primary'));
} else {
    echo elgg_view('input/submit', array('value' => elgg_echo('page:create'), 'class' => 'btn btn-primary'));
}


echo'</div></div>';

if(get_current_language() == 'fr'){
?>
	<script>
		jQuery('.fr').show();
	    jQuery('.en').hide();
	    jQuery('#btnfr').addClass('active');

	</script>
<?php
}else{
?>
	<script>
		jQuery('.en').show();
    	jQuery('.fr').hide();
    	jQuery('#btnen').addClass('active');
	</script>
<?php
}
?>
<script>
jQuery(function(){

	var selector = '.nav li';

	$(selector).on('click', function(){
    $(selector).removeClass('active');
    $(this).addClass('active');
});

		jQuery('#btnClickfr').click(function(){
               jQuery('.fr').show();
               jQuery('.en').hide();
        });

          jQuery('#btnClicken').click(function(){
               jQuery('.en').show();
               jQuery('.fr').hide();
        });
});
</script>
