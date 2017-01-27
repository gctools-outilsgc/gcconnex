<?php
/*
* If we are on a group profile page, add the badge graphic with javascript
*
* @version 1.0
* @author Nick
*/

if(elgg_in_context('group_profile') || elgg_instanceof(elgg_get_page_owner_entity(), 'group')){
//Wrap this view in the context of group profile


$group = get_entity(elgg_get_page_owner_guid());
    if($group->official_group == true){
        
?>

<script>
    $(document).ready(function(){
        //alert('good to go bb');
        var badge_link = elgg.normalize_url() +'mod/gc_official_groups/graphics/official_check.svg';
        $('.group-title').prepend('<img src="'+badge_link+'" style="max-width: 26px; max-height: 26px;" title="<?php echo elgg_echo('gc_off_group:badge_text'); ?>">');
    })
</script>


<?php 
 }
}

?>

