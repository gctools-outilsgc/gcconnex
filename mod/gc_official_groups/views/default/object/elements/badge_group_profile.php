<?php

if(elgg_in_context('group_profile') || elgg_instanceof(elgg_get_page_owner_entity(), 'group')){
//Wrap this view in the context of group profile


$group = get_entity(elgg_get_page_owner_guid());
    if($group->official_group){
        
?>

<script>
    $(document).ready(function(){
        //alert('good to go bb');
        var badge_link = elgg.normalize_url() +'mod/gc_official_groups/graphics/official_check.svg';
        $('.group-title').prepend('<img src="'+badge_link+'" style="max-width: 26px;" title="official group">');
    })
</script>


<?php 
 }
}

?>

