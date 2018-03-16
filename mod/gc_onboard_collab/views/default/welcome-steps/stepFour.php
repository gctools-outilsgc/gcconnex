<?php
/*
 * stepThree.php - Welcome
 *
 * Third step of welcome module. Gives user option to tour welcome to GCcollab group.
 */

//Nick - Change guid based on the group (1171 is my test group).
//Production Welcome Group = 19980634
//Pre Prod Welcome Group = 17265559
$welcomeGroup_guid = elgg_get_plugin_setting("tour_group", "gc_onboard_collab");

if(!$welcomeGroup_guid){
    $welcomeGroup_guid = 19980634;
}

$group_entity = get_entity($welcomeGroup_guid);
?>
<div class="panel-heading clearfix">
    <h2 class="pull-left">
        <?php echo elgg_echo('onboard:welcome:three:title'); ?>
    </h2>
    <div class="pull-right">
        <?php echo elgg_view('page/elements/step_counter', array('current_step'=>5, 'total_steps'=>7));?>

    </div>
</div>
<div class="panel-body">
  <div class="col-sm-12 clearfix">
    <?php
      echo elgg_echo('onboard:groupfeature2');
    ?>
  </div>
      <div class="col-sm-12 row wb-eqht">

        <?php
        elgg_push_context('groups-onboard');
        echo elgg_view('page/elements/featured_groups', array(
          'limit'=>4,
        ));
        elgg_pop_context();
        ?>
      </div>
    <div class="mrgn-bttm-md mrgn-tp-md pull-right">
        <a id="skip" class="mrgn-lft-sm btn btn-primary" href="#">
            <?php echo elgg_echo('onboard:welcome:one:submit'); ?>
        </a>
        <?php
/*
        echo elgg_view('output/url',array(
            'text'=>elgg_echo('onboard:welcome:three:tour'),
            'href'=>elgg_get_site_url().'groups/profile/'.$welcomeGroup_guid .'?first_tour=true',
            'class'=>'btn btn-primary',
        ));*/

        ?>

    </div>

    <script>
    $(document).ready(function(){
      //When this page loads we will add 'target=_blank' to the group links
      $('.summary-title a').attr('target','_blank');
    });


    //skip to next step
    $('#skip').on('click', function () {
      $(this).html('<i class="fa fa-spinner fa-pulse fa-lg fa-fw"></i><span class="sr-only">Loading...</span>');
        elgg.get('ajax/view/welcome-steps/stepFive', {
            success: function (output) {

                $('#welcome-step').html(output);
                $('#welcome-step').focus();
            }
        });
    });

    //join group and perform animation
    $('.join-group').on('click', function (e) {
        e.preventDefault();

        var type = "featured";
        var guid = $(this).data('guid');

        //grab content of button
        var oldHTML = $('#' + type + '-' + guid).html();

        //add spinner - chane button colour
        $('#' + type + '-' + guid).html('<i class="fa fa-spinner fa-spin fa-lg fa-fw"></i><span class="sr-only">Loading...</span>').removeClass('btn-primary').addClass('btn-default');

        //perform join action
        elgg.action('onboard/join', {
            data: {
                group_guid: guid
            },
            success: function (wrapper) {
                if (wrapper.output.result == 'joined') { //joined group
                    $('#' + type + '-' + guid).html("<?php echo elgg_echo('groups:joined'); ?>").attr('disabled', true);
                    updateTracker();
                } else if(wrapper.output.result == 'requestsent') { //join request sent
                    $('#' + type + '-' + guid).html("<?php echo elgg_echo('groups:joinrequestmade'); ?>").attr('disabled', true);
                    updateTracker();
                } else if (wrapper.output.result == 'failed') { //failed
                    $('#' + type + '-' + guid).html(oldHTML).removeClass('btn-default').addClass('btn-primary');
                }
            }
        });
    });

    </script>


</div>
