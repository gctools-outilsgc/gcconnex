<?php

/*
 * filename: sharer.php
 * Author: Nicholas Pietrantonio. Moved, renamed, and modified by Troy T. Lawson
 * Purpose: custom form for saving bookmarks from external sources. Based on original bookmark mod.
 * 			data pased from external script as json encoded object to avoid issues with saml login droping url GET variables
 */

 //load custom css for share form
elgg_load_css('special-api');

$user = elgg_get_logged_in_user_entity(); //get user
//get site data pased as JSON string from external script
$data = json_decode(get_input('data'));

//auto fill details from source
$address = $data->url;
$title = $data->title;
?>



<div class="mrgn-bttm-md share-link-holder">
    <?php 
    	//handle long urls so they dont extend off page
    	if(strlen($address) < 60){
            $share_partial_url = $address;
        }else{
            $share_partial_url = substr($address, 0, 60). '...';
        }
    	echo elgg_view('output/url', array( // format link into a URL
            'title'=>$address,
            'text'=>$share_partial_url,
            'href'=>$address,
            'target'=>'_blank',
        ));
     ?>
</div>
<div>
    <?php echo elgg_view('input/hidden', array('name' => 'address', 'value' => $address, 'id' =>'address')); //Hidden input to pass the link address to the action?>

</div>
<div>
    <label for="title">
        <?php echo elgg_echo('title'); ?>
    </label>
    <br />
    <?php echo elgg_view('input/text', array('name' => 'title', 'value' => $title, 'id' => 'title')); ?>

</div>

<div class="mrgn-bttm-md">
    <label for="description">
        <?php echo elgg_echo('description'); ?>
    </label>
    <?php echo elgg_view('input/plaintext', array('name' => 'description', 'value' => $desc, 'id' => 'description', 'rows'=>'3', 'cols'=>'50',)); ?>
</div>

<div>
    <?php
	//options for radio button selector. indicates intention to save as personal or group bookmark
    $options[0] = elgg_echo('gcconnexshare:add_to_personal');
    $options[1]=elgg_echo('gcconnexshare:add_to_group');
    echo elgg_view('input/radio', array('name'=>'share_destination', 'options'=>$options, 'class'=>'share-destination',));
    ?>
    

    <div class="wet-hidden share-choose-group">
        
        
        <label for="share_group"><?php echo elgg_echo('gcconnexshare:choose_group');?></label>
        <?php
        	//build drop down list of group user is memeber of
        $group_membership = elgg_get_entities_from_relationship(array(
                'relationship'=> 'member',
                'relationship_guid'=> $user->guid,
                'inverse_relationship'=> FALSE,
                'type'=> 'group',
                'limit'=> 0,
            ));
        //First option is null
        $group_options['NA']='--------------------';
        foreach($group_membership as $group){
            //put the groups into an array, with the group guid as the value
            $group_names = $group->name;
            $group_guids = $group->guid;
            $group_options[$group_guids]=$group_names;
        }
       
        echo elgg_view('input/select', array(
                    'name'=>'share_group',
                    'value'=>'share_group',
                    'id'=>'share_group',
                    'options_values'=> $group_options,
                ));


        ?>
        
    </div>

    <div>
        <?php echo elgg_view('input/checkbox', array('name'=>'share_on_wire', 'label'=>elgg_echo('gcconnexshare:share_on_wire'), 'value'=>'share_on_wire',)); //Share checkbox?>

    </div>
</div>

<div class="mrgn-bttm-md" id='accessDiv'>
    <label for="access_id">
        <?php echo elgg_echo('access'); ?>
    </label>
    <br />
    <?php 
    	//build access drop down list. 
    	//This list is removed and re-rendered based on selection in group drop down list
    	echo elgg_view('input/access', array(
			'name' => 'access_id',
			'value' => 2,
        	'id' => 'access_id',
			'entity_type' => 'object',
			'entity_subtype' => 'bookmarks',
		)); 
	?>
</div>

<div>
    <?php
        echo elgg_view('input/submit', array('value' => elgg_echo('bookmarks:add'), 'class'=>'btn btn-primary'));
    ?>

</div>
<script>
	//on page load...
    $(document).ready(function () {
    
        //check the 'Add to personal bookmarks' radio button
        $('.share-destination li:first-child input').attr('checked', 'checked');
        $('.share-destination li input').on('change', function () {
            //Check the add to a group radio button
            $('.share-choose-group').toggle('slow');
        });
        //attaches a on change function to group drop down list which makes a call to ajax 
        //view to re-render access drop down list
        $('#share_group').change(function(){
        	//make ajax call
        	elgg.get('ajax/view/gc_api/ajax_access_view', {
        		data: {
        			//send group guid to ajax call
        			guid: $('#share_group').val(),
        		},
        		success: function (output){
        			//replace access dropdown with output returnded from ajax call
        			$('#accessDiv').find('select').replaceWith(output)
        			
        		}
        	});
        });
    });
</script>