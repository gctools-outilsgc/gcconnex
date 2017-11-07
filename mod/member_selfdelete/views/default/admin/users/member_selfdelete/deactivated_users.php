<?php
/*
Displays a list of users who have deactivated their accounts at some point - Admin only view
*/

$params = array(
    'metadata_names' => 'gcdeactivate',
    'type'=>'user',
    'limit'=>0,
);

$users = elgg_get_entities_from_metadata($params);
echo '<table class="elgg-table">';
echo '<tr><th>Username</th><th>Email</th><th>Reason</th><th>State</th><th>Date Deactivated</th><th>Toggle</th></tr>';
foreach ($users as $user){
    echo '<tr>';
    echo '<td>' .$user->username . '</td>';
    echo '<td>' .$user->email . '</td>';
    if($user->gcdeactivatereason){
        echo '<td>' .elgg_echo('member_selfdelete:gc:reason:' . $user->gcdeactivatereason). '</td>';
    }else{
        echo '<td>No reason given</td>';
    }
    echo '<td>' .elgg_echo('member_selfdelete:gc:admin:state:'.$user->gcdeactivate) . '</td>';
    echo '<td>' . elgg_get_friendly_time($user->gcdeactivatetime).'</td>';
    echo '<td>'.elgg_view('output/url',array('text'=>'Toggle State','href'=>'action/selfdelete/reactivate_toggle?guid='.$user->guid,'is_action'=>true,)).'</td>';
    echo '</tr>';
}
echo '</table>';