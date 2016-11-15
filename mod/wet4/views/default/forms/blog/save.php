<?php
/**
 * Edit blog form
 *
 * @package Blog
 */

$blog = get_entity($vars['guid']);
$vars['entity'] = $blog;

$draft_warning = $vars['draft_warning'];
if ($draft_warning) {
	$draft_warning = '<span class="mbm elgg-text-help">' . $draft_warning . '</span>';
}

$action_buttons = '';
$delete_link = '';
$preview_button = '';

if ($vars['guid']) {
	// add a delete button if editing
	$delete_url = "action/blog/delete?guid={$vars['guid']}";
	$delete_link = elgg_view('output/url', array(
		'href' => $delete_url,
		'text' => elgg_echo('delete'),
		'class' => 'elgg-button elgg-button-delete float-alt',
		'confirm' => true,
	));
}

// published blogs do not get the preview button
if (!$vars['guid'] || ($blog && $blog->status != 'published')) {
	$preview_button = elgg_view('input/submit', array(
		'value' => elgg_echo('preview'),
		'name' => 'preview',
		'class' => 'elgg-button-submit mls',
	));
}

$save_button = elgg_view('input/submit', array(
	'value' => elgg_echo('publish'),
	'name' => 'save',
    'class' => 'btn btn-primary',
));
$action_buttons = $save_button . $preview_button . $delete_link;


$btn_language =  '<ul class="nav nav-tabs nav-tabs-language">
  <li id="btnen"><a href="#" id="btnClicken">'.elgg_echo('lang:english').'</a></li>
  <li id="btnfr"><a href="#" id="btnClickfr">'.elgg_echo('lang:french').'</a></li>
</ul>';

$label = elgg_echo('title:en');
$input = elgg_view('input/text', array(
	'name' => 'title',
	'id' => 'blog_title',
	'value' => $vars['title']
));

$label2 = elgg_echo('title:fr');
$input2 = elgg_view('input/text', array(
	'name' => 'title2',
	'id' => 'blog_title2',
	'value' => $vars['title2']
));

$excerpt_label = elgg_echo('blog:excerpt:en');
$excerpt_input = elgg_view('input/text', array(
	'name' => 'excerpt',
	'id' => 'blog_excerpt',
	'value' => _elgg_html_decode($vars['excerpt'])
));

$excerpt_label2 = elgg_echo('blog:excerpt:fr');
$excerpt_input2 = elgg_view('input/text', array(
	'name' => 'excerpt2',
	'id' => 'blog_excerpt2',
	'value' => _elgg_html_decode($vars['excerpt2'])
));

$excerpt_label3 = elgg_echo('blog:excerpt:fr');
$excerpt_input3 = elgg_view('input/text', array(
	'name' => 'excerpt3',
	'id' => 'blog_excerpt3',
	'value' => _elgg_html_decode($vars['excerpt2'])
));

$body_label = elgg_echo('blog:body:en');
$body_input = elgg_view('input/longtext', array(
	'name' => 'description',
	'id' => 'blog_description',
	'value' => $vars['description']
));

$body_label2 = elgg_echo('blog:body:fr');
$body_input2 = elgg_view('input/longtext', array(
	'name' => 'description2',
	'id' => 'blog_description2',
	'value' => $vars['description2']
));

$save_status = elgg_echo('blog:save_status');
if ($vars['guid']) {
	$entity = get_entity($vars['guid']);
	$saved = date('F j, Y @ H:i', $entity->time_created);
} else {
	$saved = elgg_echo('never');
}

$status_label = elgg_echo('status');
$status_input = elgg_view('input/select', array(
	'name' => 'status',
	'id' => 'blog_status',
	'value' => $vars['status'],
	'options_values' => array(
		'draft' => elgg_echo('status:draft'),
		'published' => elgg_echo('status:published')
	)
));

$comments_label = elgg_echo('comments');
$comments_input = elgg_view('input/select', array(
	'name' => 'comments_on',
	'id' => 'blog_comments_on',
	'value' => $vars['comments_on'],
	'options_values' => array('On' => elgg_echo('on'), 'Off' => elgg_echo('off'))
));

$tags_label = elgg_echo('tags');
$tags_input = elgg_view('input/tags', array(
	'name' => 'tags',
	'id' => 'blog_tags',
	'value' => $vars['tags']
));

$access_label = elgg_echo('access');
$access_input = elgg_view('input/access', array(
	'name' => 'access_id',
	'id' => 'blog_access_id',
	'value' => $vars['access_id'],
	'entity' => $vars['entity'],
	'entity_type' => 'object',
	'entity_subtype' => 'blog',
));

$categories_input = elgg_view('input/categories', $vars);

// hidden inputs
$container_guid_input = elgg_view('input/hidden', array('name' => 'container_guid', 'value' => elgg_get_page_owner_guid()));
$guid_input = elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars['guid']));


echo <<<___HTML

$draft_warning<br>
<div>
$btn_language
</div>

<div class="tab-content tab-content-border">
<div id=blog_title class='en'>
	<label for="blog_title">$label</label>
	$input
</div>

<div id=blog_title2 class='fr'>
	<label for="blog_title">$label2</label>
	$input2
</div>

<div class='en'>
	<label for="blog_excerpt">$excerpt_label</label>
	$excerpt_input
</div>

<div class='fr'>
	<label for="blog_excerpt">$excerpt_label2</label>
	$excerpt_input2
</div>

<div class='en'>
	<label for="blog_description">$body_label</label>
	$body_input
</div>

<div class='fr'>
	<label for="blog_description">$body_label2</label>
	$body_input2
</div>

<div>
	<label for="blog_tags">$tags_label</label>
	$tags_input
</div>

$categories_input

<div>
	<label for="blog_comments_on">$comments_label</label>
	$comments_input
</div>

<div>
	<label for="blog_access_id">$access_label</label>
	$access_input
</div>

<div>
	<label for="blog_status">$status_label</label>
	$status_input
</div>

<div class="elgg-foot">
	<div class="elgg-subtext mbm">
	$save_status <span class="blog-save-status-time">$saved</span>
	</div>

	$guid_input
	$container_guid_input

	$action_buttons
</div>
</div>

___HTML;

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