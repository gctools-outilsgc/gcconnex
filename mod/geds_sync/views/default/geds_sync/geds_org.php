<?php 
  /*
  * This extended view appends the organization tab to the profile tabs
  * the actual content of the tab is built in an ajax call to org-panel.php  
  */

  //get the entity object of the owner of the page (ElggUser)
  $owner = elgg_get_page_owner_entity();

  //if the user does not have any organization metadata do nothing.
  if (!$owner->orgStruct){
    return;
  }

  //because english and french metadata is saved seperatly a check must be made to determin the language the page is being viewed in. 
  //The appropriate org data to show is then choosen
  if(get_current_language()=='fr'){
    $orgString = $owner->orgStructFr; //French
  }else{
    $orgString = $owner->orgStruct; //English
  }

  //if current user can edit the page. Used later to prepend the edit button for setting access.
  $canEdit = $owner->canEdit();
  //the actual edit button to be added
  $button = elgg_view('output/url', array('text' => elgg_echo('geds:org:edit'), 'href' => 'geds_sync/edit', 'id'=>'deleteOrg', 'class' => 'elgg-button elgg-button-action'));
?>

<script type="text/javascript">
  //on page load
  $(document).ready(function () {
    //adds the organization tab to profile page
    //$('#tabs-list').append('<li role="presentation"><a href="#org" aria-controls="org" role="tab" data-toggle="tab"><?php echo elgg_echo("geds:org:orgTab"); ?></a></li>');
    //adds the content pane that will show when org tab is selected
    $('.tab-content').append('<div role="tabpanel" class="tab-pane" id="org">');
    //$('#org').append('<div class="panel panel-custom" id="org-panel">');

    //elgg ajax call. uses get instead of post to pass variables in the header
    elgg.get('ajax/view/geds_sync/org-panel', {
      data: {
        orgData: JSON.stringify(<?php echo $orgString; ?>) //data to be sent via get. in this case the JSON string containing organization structure of the user.
      },
      success: function (output) { //on success
        //displays the output of the ajax call to org-panel. shows in <div id='org' />
        $('#org').html(output);
        
        //if user is able to edit the page then add the edit button. This leads to edit page for access rights
        if("<?php echo $canEdit; ?>"){
          $('#org').prepend('<?php echo $button; ?>');
        }
      },
      error: function(xhr, status, error) { }//do nothing. Debug code could be added here.
    });
  });
  
</script>

