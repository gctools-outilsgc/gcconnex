<?php
/*
* Creates a table of eixisting official groups for admins to manage
*
* @version 1.0
* @author Nick
*/

//Grab the groups with the official group = true metadata
$group_entity_list = elgg_get_entities_from_metadata(array(
    'type'=>'group',
    'limit'=>0,
    'metadata_name_value_pairs'=> array(
        'name'=>'official_group',
        'value'=>true,
    ),
));
echo '<h3>Current Official Groups</h3>';
echo '<table class="off-group-table">';
echo '<tr><th>Group</th><th>Owner</th><th>Manage</th></tr>';

foreach($group_entity_list as $group){
    //Get the info for the group
    $user = $group->getOwnerEntity();
    
    $group_link = elgg_view('output/url', array(
        'text'=>$group->name,
        'href'=>$group->getUrl(),
        'target'=>'_blank',
    ));
    //Get the owner's email incase we need to contact them
    $mail_link = elgg_view('output/url', array(
        'text'=>$user->email,
        'href'=>'mailto:'.$user->email,
    ));
    //Link to remove official status
    $remove_link = elgg_view('output/url', array(
        'text'=>'Remove Status',
        'href'=>'action/remove_off_group?guid='.$group->guid,
        'is_action'=>true,
    ));
    echo '<tr>';
    $test = $group->name .' - ' .$group->guid . ' - ' .$user->name;
    echo '<td>'.$group_link.'</td>';
    echo '<td>'.$user->name.' - '.$mail_link.'</td>';
    echo '<td>'.$remove_link.'</td>';
    echo '</tr>';
}

echo '</table>';
?>

<style>
    .off-group-table{
        width:100%;
        border: 1px solid #ddd;
        margin-bottom:5px;
        margin-top: 15px;
        padding: 3px;
    }
    .off-group-table th{
        font-weight: bold;
        font-size: 16px;
        border-bottom: 3px solid #ddd;
        padding:6px;
    }
    .off-group-table td{
        border: 1px solid #ddd;
        padding:6px;
    }
</style>