<?php
    /*
        Load list of user avatars who have endorsed skills
    */

$guids = (string) get_input('guids');

$avatars = explode(',', $guids);

$title = 'Endorsements';

$content = list_avatars(array(
                        'guids' => $avatars,
                        'size' => 'small',
                        'limit' => 0
                    ));


$body = elgg_view_layout('one_column', array(
	'filter' => false,
	'content' => $content,
	'title' => $title,
));

echo $body;

    ?>