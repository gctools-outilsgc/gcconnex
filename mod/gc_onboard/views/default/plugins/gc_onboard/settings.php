<?php
/*
* settings.php
*
* Plugin settings to set group GUID and wait time after hitting not now. Mainly for testing purposes
*/
elgg_get_plugin_setting("tour_group", "gc_onboard");

echo '<div style="margin-top:15px">';

echo '<label for="tour-group">Tour group guid:(welcome group)</label>';
echo '<p>Production: 19980634     Pre-Production: 17265559</p>';
    $params = array(
            'name' => 'params[tour_group]',
            'id' => 'tour-group',
            'class' => 'mrgn-bttm-sm',
            'value' => $vars['entity']->tour_group,
        );

        echo '<div class="basic-profile-field">';
            echo elgg_view("input/text", $params);
        echo '</div>';

echo '</div>';

echo '<div style="margin-top:15px">';

echo '<label for="wait-time">Reminder Time:</label>';
echo '<p>1 week = 1458259200</p>';
$params2 = array(
        'name' => 'params[wait_time]',
        'id' => 'wait-time',
        'class' => 'mrgn-bttm-sm',
        'value' => $vars['entity']->wait_time,
    );

echo '<div class="basic-profile-field">';
echo elgg_view("input/text", $params2);
echo '</div>';

echo '</div>';
    ?>
