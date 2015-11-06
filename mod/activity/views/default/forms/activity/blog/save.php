<?php
/**
 * Form for adding a new blog
 *
 * @package Activity
 */

$save_button = elgg_view('input/submit', array(
    'value' => elgg_echo('save'),
    'name' => 'save',
));

$title_label = elgg_echo('title');
$title_input = elgg_view('input/text', array(
    'name' => 'title',
    'id' => 'blog_title',
    'value' => $vars['title']
));

$body_label = elgg_echo('blog:body');
$body_input = elgg_view('input/plaintext', array(
    'name' => 'description',
    'id' => 'blog_description',
    'value' => $vars['description']
));

$tags_label = elgg_echo('tags');
$tags_input = elgg_view('input/tags', array(
    'name' => 'tags',
    'id' => 'blog_tags',
    'value' => $vars['tags']
));

// hidden inputs
$container_guid_input = elgg_view('input/hidden', array('name' => 'container_guid', 'value' => elgg_get_logged_in_user_guid()));

echo <<<___HTML
    <div>
        <label for="blog_title">$title_label</label>
        $title_input
    </div>
    
    <label for="blog_description">$body_label</label>
    $body_input
    <br />
    
    <div>
        <label for="blog_tags">$tags_label</label>
        $tags_input
    </div>
    
    <div class="elgg-foot">
        $container_guid_input
        $save_button
    </div>
___HTML;
