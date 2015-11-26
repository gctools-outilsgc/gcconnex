<?php
/**
 * Group profile summary
 *
 * Icon and profile fields
 *
 * @uses $vars['group']
 */

$group = elgg_get_page_owner_entity();
$owner = $group->getOwnerEntity();

$buttonTitle = 'Member';

if (!$owner) {
	// not having an owner is very bad so we throw an exception
	$msg = "Sorry, '" . 'group owner' . "' does not exist for guid:" . $group->guid;
	throw new InvalidParameterException($msg);
}

?>
<div class="groups-profile panel panel-custom clearfix elgg-image-block mrgn-bttm-sm">

    <div class="row mrgn-lft-sm mrgn-rght-sm mrgn-tp-sm mrgn-bttm-sm">
        <div class="groups-profile-icon col-xs-2 col-md-1 mrgn-tp-sm">
			<?php
				// we don't force icons to be square so don't set width/height
				echo elgg_view_entity_icon($group, 'small', array(
					'href' => '',
					'width' => '',
					'height' => '',
				)); 
			?>
		</div>
    
        <div class="panel-heading col-xs-10 col-md-11"> 
                
            <h2 class="pull-left mrgn-tp-0 mrgn-bttm-0"><a href="<?php echo $group->getURL(); ?>"><?php echo $group->name; ?></a></h2>
        </div>
    </div>
		
        
    


</div>
