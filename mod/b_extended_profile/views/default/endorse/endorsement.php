<?php
    /*
        Load list of user avatars who have endorsed skills
    */

$guid = (int) get_input('guid');

$skill = get_entity($guid);

$title = 'Endorsements';

$content = list_avatars(array(
                        'guids' => $skill->endorsements,
                        'size' => 'small',
                        'limit' => 0
                    ));


$body = elgg_view_layout('one_column', array(
	'filter' => false,
	'content' => $content,
	'title' => '<h2>' . $title . '</h2>',
));

echo $body;

    ?>