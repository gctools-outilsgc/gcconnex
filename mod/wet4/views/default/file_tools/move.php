<?php

$file = (int) get_input("guid");

$parent_folder = elgg_get_entities_from_relationship(array(
			'relationship' => 'folder_of',
			'relationship_guid' => $file,
			'inverse_relationship' => true,
		));

$entity = get_entity($file);

$page_owner = $entity->getContainerEntity();

$options = array(
        'type' => 'object',
        'subtype' => 'folder',
        'container_guid' => $page_owner->getGUID(),
        'full_view' => false,
        'pagination' => false,
        'distinct' => false,
        'order_by' => 'time_created asc',
    );

$contents = elgg_get_entities_from_relationship($options); 

$form = '';

$form .= '<div style="width:300px">';
$form .= '<h2>Move File</h2>';
$form .= '<p>Move <i><b>' . $entity->getDisplayName() . '</b></i> into which folder?</p>';


if(!empty($parent_folder)){
    $form .= elgg_view('output/url', array(
                'text' => elgg_echo('file_tools:input:folder_select:main'),
                'href' => 'action/file/move_folder?file_guid=' . $file . '&folder_guid=root',
                'is_action' => true,
            ));
            $form .='<br>';
}

foreach($contents as $content){
    
    if(!empty($parent_folder)){
        if($parent_folder[0]->getGUID() == $content->getGUID()){
            //dont show current folder
        } else {
            $form .= elgg_view('output/url', array(
                'text' => $content->getDisplayName(),
                'href' => 'action/file/move_folder?file_guid=' . $file . '&folder_guid=' . $content->getGUID(),
                'is_action' => true,
            ));
            $form .='<br>';
            
            
        }
    } else {
        $form .= elgg_view('output/url', array(
                'text' => $content->getDisplayName(),
                'href' => 'action/file/move_folder?file_guid=' . $file . '&folder_guid=' . $content->getGUID(),
                'is_action' => true,
            ));
        $form .='<br>';
    }
    
}
$form .= '</div>';
$body = elgg_view_layout('one_column', array(
	'filter' => false,
	'content' => $form,
));

echo $body;
