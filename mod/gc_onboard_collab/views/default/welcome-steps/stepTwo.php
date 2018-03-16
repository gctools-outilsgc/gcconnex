<?php
/*
 * stepOne.php - Welcome
 *
 * First step asks for user's basic information or gives them an option to sync with GCdirectory
 */
?>


<div class="panel-heading clearfix">
    <h2 class="pull-left">
        <?php echo elgg_echo('onboard:welcome:one:title'); ?>
    </h2>
    <div class="pull-right">
        <?php echo elgg_view('page/elements/step_counter', array('current_step'=>3, 'total_steps'=>7));?>

    </div>
</div>


<div class="panel-body">
    <p class="mrgn-lft-sm mrgn-bttm-sm">
        <?php echo elgg_echo('onboard:welcome:one:description'); ?>
    </p>

    <?php if(elgg_is_active_plugin('geds_sync') && elgg_view_exists('welcome-steps/geds/sync')){ ?>
    <section class="alert-gc clearfix">
        <div class="clearfix">
            <div class="pull-left mrgn-lft-0">
                <i class="fa fa-info-circle fa-3x alert-gc-icon" aria-hidden="true"></i>
            </div>
            <div style="width:80%;" class="pull-left alert-gc-msg">
                <h3>
                    <?php echo elgg_echo("onboard:geds:title"); ?></h3>
                <p>
                    <?php echo elgg_echo("onboard:geds:body"); ?>
                </p>
            </div>
        </div>

        <?php echo elgg_view('welcome-steps/geds/sync');
        //echo elgg_view('welcome-steps/geds_sync_button');
        ?>

    </section>
<div id="test"></div>
    <?php } ?>
<div class="clearfix" id="onboard-table">

        <div class="">
            <?php
            /*
            Nick - Commenting out for when we get some kind of sync thing
            if(elgg_is_active_plugin('geds_sync') && elgg_view_exists('welcome-steps/geds/sync')){
                echo elgg_echo('onboard:welcome:one:noGeds');


            }*/?>

        </div>
        <div class="clearfix col-sm-12 brdr-bttm mrgn-bttm-md">
    <?php
    $user = elgg_get_logged_in_user_entity();



    echo '<div class="clearfix mrgn-bttm-md">'.elgg_view('onboard/input/welcome_edu').'</div>';
    ?>
  </div>

  <div class="gcconnex-endorsements-input-wrapper mrgn-tp-sm mrgn-bttm-md">
      <label stye="display:block;" for="skill-search">
          <?php echo elgg_echo('onboard:profile:addskills');?>
      </label>
      <div class=timeStamp><?php echo elgg_echo('onboard:welcome:skills');?></div>
      <input name="skill-search" id="skill-search" style="width:300px;" type="text" class="gcconnex-endorsements-input-skill" onkeyup="checkForEnter(event)" />
      <a href="#" class="btn btn-primary mrgn-tp-md mrgn-lft-sm" style="display:inline-block;" title="<?php echo elgg_echo('onboard:profile:addskills');?>" onclick="addButtonSubmit(event)">
          <?php echo elgg_echo('onboard:profile:add');?>
      </a>
  </div>
    <div class="col-sm-12 clearfix">
        <div style="min-height:100px;" class="panel">
            <p class="mrgn-tp-sm mrgn-bttm-0 panel-heading">
                <strong>
                    <?php echo elgg_echo('onboard:profile:yourskills');?>
                    <span class="skill-count"></span>/15</strong></p>
            <p class="timeStamp mrgn-tp-0">
                <?php echo elgg_view('onboard:profile:recommendation'); ?>
            </p>
        <div class="gcconnex-skills-skills-list-wrapper panel-body">
            <?php
            $user = elgg_get_logged_in_user_entity();

            $skill_guids = $user->gc_skills;

            if ($user->canEdit() && ($skill_guids == NULL || empty($skill_guids))) {

            } else {
                echo '<div class="gcconnex-skill-limit hidden">' . elgg_echo('gcconnex_profile:gc_skill:limit') . '</div>';
                if (!(is_array($skill_guids))) {
                    $skill_guids = array($skill_guids);
                }

                for ($i=0; $i<20; $i++) {
                    $skill_guid = $skill_guids[$i];
                    if ($skill = get_entity($skill_guid)) {
                        $skill_class = str_replace(' ', '-', strtolower($skill->title));

                        $endorsements = $skill->endorsements;
                        if (!(is_array($endorsements))) {
                            $endorsements = array($endorsements);
                        }

                        echo '<div tabindex="0" title="Click to remove '.$skill->title.' skill" class="gcconnex-skill-entry clearfix picked-skill" data-type="skill" onclick="deleteEntry(this)" data-guid="' . $skill_guid . '"><div class="skill-container clearfix" style="display:inline-block">';
                        echo '<div class="gcconnex-endorsements-skill" data-type="skill">' . $skill->title . ' <i class="fa fa-times fa-lg close-x" aria-hidden="true"><span class="wb-inv">' . elgg_echo('delete:this') . '</span></i></div></div></div>';
                    }
                }
            }

            ?>
            </div>
        </div>
    </div>


</div>

<div id="stepOneButtons" class="mrgn-bttm-md mrgn-tp-md pull-right">

        <a id="skip" class="mrgn-lft-sm btn btn-default" href="#">
            <?php echo elgg_echo('onboard:welcome:one:skip'); ?>
        </a>
        <?php
    echo elgg_view('input/submit', array(
            'value' => elgg_echo('onboard:welcome:one:submit'),
            'id' => 'onboard-info',

        ));
        ?>

</div>
    </div>


<script src="<?php echo elgg_get_site_url() . 'mod/b_extended_profile/vendors/typeahead/dist/typeahead.bundle.min.js'; ?>"></script>
<script>
    //get the initial skill count to display to the user
    $('.skill-count').html($('.gcconnex-skill-entry:visible').length);
    checkLimit();

    var newSkill = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,

        remote: {
            url: elgg.get_site_url() + 'mod/b_extended_profile/actions/b_extended_profile/autoskill.php?query=%QUERY'
        }
    });

    newSkill.initialize();
/*=======
                        $('#welcome-step').html(output);
                        $('#welcome-step').focus();
>>>>>>> connex/gcconnex*/

    $('.gcconnex-endorsements-input-skill').typeahead(null, {
        name: 'newSkill',
        displayKey: 'value',
        limit: 10,
        source: newSkill.ttAdapter()
    });

    $('.gcconnex-endorsements-input-skill').on('typeahead:selected', skillSubmit);
    $('.gcconnex-endorsements-input-skill').on('typeahead:autocompleted', skillSubmit);

    function checkForEnter(event) {
        if (event.keyCode == 13) { // 13 = 'Enter' key

            // The new skill being added, as entered by user
            //var newSkill = $('.gcconnex-endorsements-input-skill').val().trim();
            var newSkill = $('.gcconnex-endorsements-input-skill').typeahead('val');
            // @todo: do data validation to ensure css class-friendly naming (ie: no symbols)
            // @todo: add a max length to newSkill

            //dont allow user to sumit nothing as skill
            if (newSkill.trim().length > 0) {
                addNewSkill(newSkill);
                checkLimit();
            }
        }
    }

    function addButtonSubmit(event) {
        var newSkill = $('.gcconnex-endorsements-input-skill').typeahead('val');
        // @todo: do data validation to ensure css class-friendly naming (ie: no symbols)
        // @todo: add a max length to newSkill

        //dont allow user to sumit nothing as skill
        if (newSkill.trim().length > 0) {
            addNewSkill(newSkill);
            checkLimit();
        }

    }

    function skillSubmit() {
        var myVal = $('.gcconnex-endorsements-input-skill').typeahead('val');
        checkLimit();
        addNewSkill(myVal);
    }

    //your skills
    $('.gcconnex-skills-skills-list-wrapper').on('keypress', '.gcconnex-skill-entry', function (e) {
        e.preventDefault();
        if (e.keyCode == 13) {
            $(this).trigger('click');
        }
    });

/*=======
    //skip to next step
    $('#skip').on('click', function () {
        elgg.get('ajax/view/welcome-steps/stepTwo', {
            success: function (output) {
                $('#welcome-step').html(output);
                $('#welcome-step').focus();
            }
        });
    });
>>>>>>> connex/gcconnex*/

    function addNewSkill(newSkill) {
        $('.skill-count').html(($('.gcconnex-skill-entry:visible').length)+1);
        newSkill = escapeHtml(newSkill);
        // inject HTML for newly added skill
        $('.gcconnex-skills-skills-list-wrapper').append('<div tabindex="0" title="Click to remove ' + newSkill + ' skill" class="gcconnex-skill-entry picked-skill temporarily-added" data-type="skill" onclick="deleteEntry(this)" data-skill="' + newSkill + '">' +

        '<div data-skill="' + newSkill + '" class="gcconnex-endorsements-skill">' + newSkill + ' <i class="fa fa-times fa-lg close-x" aria-hidden="true"><span class="wb-inv">' + '<?php elgg_echo('delete:this') ?>' + '</span></i></div>' +
        '</div>');
        $('.skillMessage').remove();
        checkLimit();
        $('.gcconnex-endorsements-input-skill').val('');                                 // clear the text box
        $('.gcconnex-endorsements-input-skill').typeahead('val', '');                    // clear the typeahead box

        if ($('.gcconnex-skill-entry:visible').length < 15) {
            $('.gcconnex-endorsements-add-skill').show();                                // show the 'add a new skill' link
        }


    }

    //use this to be able to add french skills that contain '
    function addPopSkill(skill) {

        var skillGUID = $(skill).data('guid');

        newSkill = skillGUID;

        //dont add when skill limit is reached
        if ($('.gcconnex-skill-entry:visible').length < 15) {
            $('.gcconnex-skills-skills-list-wrapper').append('<div tabindex="0" title="Click to remove ' + newSkill + ' skill" class="gcconnex-skill-entry picked-skill temporarily-added" data-type="skill" onclick="deleteEntry(this)" data-skill="' + newSkill + '">' +

            '<div data-skill="' + newSkill + '" class="gcconnex-endorsements-skill">' + newSkill + ' <i class="fa fa-times fa-lg close-x" aria-hidden="true"><span class="wb-inv">' + '<?php elgg_echo('delete:this') ?>' + '</span></i></div>' +
            '</div>');
        }
        $('.skillMessage').remove();
        checkLimit();
        //change the current skill counter
        $('.skill-count').html(($('.gcconnex-skill-entry:visible').length));
    }

    function escapeHtml(string) {
        return String(string).replace(/[<>"\/]/g, function (s) {
            return entityMap[s];
        });
    }

    function deleteEntry(identifier) {
        // get the entry-type name
        var entryType = $(identifier).data('type');

        if ($(identifier).closest('.gcconnex-' + entryType + '-entry').hasClass('temporarily-added')) {
            $(identifier).closest('.gcconnex-' + entryType + '-entry').remove();
        }
        else {
            // mark the entry for deletion and hide it from view
            $(identifier).closest('.gcconnex-' + entryType + '-entry').hide();
        }
        console.log(entryType);

        //for tabbing users
        //add additional 's' to skill to grab right class
        if (entryType == 'skill') {
            $('.cancel-' + entryType + 's').focus();
        } else {
            $('.cancel-' + entryType).focus();
        }
        checkLimit();
        //change the current skill counter
        $('.skill-count').html(($('.gcconnex-skill-entry:visible').length));
    }

    function checkLimit() {

        if ($('.gcconnex-skill-entry:visible').length >= 15) {
            $('.gcconnex-endorsements-input-wrapper').hide();
            $('#toomany').show();
        } else {
            $('.gcconnex-endorsements-input-wrapper').show();
            $('#toomany').hide();
        }

    }



        //submit entered fields
        $('#onboard-info').on('click', function () {
          $(this).prop('disabled', true);
          var $skills_added = [];
          var $delete_guid = [];



          $('.gcconnex-skill-entry').each(function () {
              if ($(this).is(":hidden")) {
                  $delete_guid.push($(this).data('guid'));
              }
              if ($(this).hasClass("temporarily-added")) {
                  $skills_added.push($(this).data('skill'));
              }
          });

          var obj = {
                    section: 'welcome',
                    eguid: 'new',
                    school: $('.gcconnex-education-school').val(),
                    field: $('.gcconnex-education-field').val(),
                    degree: $('.gcconnex-education-degree').val(),
                    skillsadded:$skills_added,
                    skillsremoved: $delete_guid,
                    organization:$('.gcconnex-work-org').val(),
                    title: $('.gcconnex-job-title').val(),
                    access: $('.gcconnex-access').val()
                };
            console.log(obj);

            elgg.action('onboard/update-profile', {
                data: {
                    section: 'welcome',
                    eguid: 'new',
                    school: $('.gcconnex-education-school').val(),
                    field: $('.gcconnex-education-field').val(),
                    degree: $('.gcconnex-education-degree').val(),
                    skillsadded:$skills_added,
                    skillsremoved: $delete_guid,
                    organization:$('.gcconnex-work-org').val(),
                    title: $('.gcconnex-job-title').val(),
                    access: $('.gcconnex-access').val()
                },
                success: function (wrapper) {
                    console.log(wrapper);
                    if (wrapper.output) {
                        //alert(wrapper.output.sum);
                    } else {
                        // the system prevented the action from running
                    }

                    //grab next step
                    elgg.get('ajax/view/welcome-steps/stepThree', {
                        success: function (output) {

                            $('#welcome-step').html(output);
                            console.log('Screen 2 Done');
                        }
                    });

                }
            });
        });

        //skip to next step
        $('#skip').on('click', function () {
          $(this).html('<i class="fa fa-spinner fa-pulse fa-lg fa-fw"></i><span class="sr-only">Loading...</span>');
            elgg.get('ajax/view/welcome-steps/stepThree', {
                success: function (output) {
                    $('#welcome-step').html(output);
                }
            });
        });



</script>
