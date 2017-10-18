<?php
/*
 * move.php
 *
 * Lists folders that files/folders can be moved to after pressing move button.
 *
 * @package wet4
 * @author GCTools Team
 */
//get guids passed here
$fileGUIDs = (string) get_input("guids");
$lang = get_current_language();

if(!empty($fileGUIDs)){
    //put string values into array
    $file = explode(',', $fileGUIDs);
    array_pop($file);

    //get container enitity
    $page_owner = get_entity($file[0])->getContainerEntity();

    //get all folders
    $folders = file_tools_get_folders($page_owner->getGUID());

    $folderEnt = array();

    //loop thru array
    foreach($file as $f){

        //list all other folder excluding itself and it's children
        $ent = file_tools_get_child($folders, 1, $f, '-1');

        //if a folder
        if(!elgg_instanceof($ent, 'file')){
            array_push($folderEnt, $ent);
        }
    }

    foreach($folderEnt as $e){

        //make a original array to base folders off of
        if(!isset($originArray)){
            $originArray = $e;
            $resultArray = $originArray;
        } else {

            //compare each index of array
            $resultArray = array_intersect($resultArray, $e);
        }



    }
    $form = '';
    $form .= '<div style="width:300px">';

    $form .= '<p>'.elgg_echo('fil:which:folder').'</p>';

            $form .= elgg_view('output/url', array(
                'text' => elgg_echo('file_tools:input:folder_select:main'),
                'href' => 'action/file/move_folder?file_guid=' . $fileGUIDs . '&folder_guid=root',
                'is_action' => true,
            ));
            $form .='<br>';

            foreach($resultArray as $key => $value){
               
                           $form .= elgg_view('output/url', array(
                'text' => '-'.gc_explode_translation(get_entity($key)->title,$lang),
                'href' => 'action/file/move_folder?file_guid=' . $fileGUIDs . '&folder_guid=' . $key,
                'is_action' => true,
            ));



                $form .= '<br>';
            }
    $form .= '</div>';
    $body = elgg_view_layout('one_column', array(
        'filter' => false,
        'content' => $form,
        'title' => elgg_echo('file:move:selected'),
    ));
    echo $body;
} else {

    //display alert saying you need to select file
    echo '<div class="alert alert-info"><h3>'.elgg_echo('file:no:selected').'</h3>
	<p>'.elgg_echo('file:chose').'</p></div>';
}
