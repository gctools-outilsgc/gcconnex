<?php
/*
 * stepFour.php - Profile
 *
 * Fourth step of profile module. Asks for user's skills and also has most popular skills listed.
 */
?>

<h1>
    <?php echo elgg_echo('onboard:profile:four:title'); ?>
</h1>

<div class="mrgn-bttm-md onboarding-cta-holder">
    <?php echo elgg_echo('onboard:profile:skill:why');?>

</div>
<div class="panel panel-custom mrgn-lft-xl mrgn-rght-xl">
    <div style="min-height:100px;" class="panel-body">
        <p class="mrgn-tp-sm mrgn-bttm-0">
            <strong>
                <?php echo elgg_echo('onboard:profile:yourskills');?>
                <span class="skill-count"></span>/15</strong></p>
        <p class="timeStamp mrgn-tp-0">
            <?php echo elgg_view('onboard:profile:recommendation'); ?>
        </p>
    <div class="gcconnex-skills-skills-list-wrapper">
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
<div class="gcconnex-endorsements-input-wrapper mrgn-tp-sm mrgn-bttm-md">
    <label stye="display:block;" for="skill-search">
        <?php echo elgg_echo('onboard:profile:addskills');?>
    </label>
    <input name="skill-search" id="skill-search" style="width:300px;" type="text" class="gcconnex-endorsements-input-skill" onkeyup="checkForEnter(event)" />
    <a href="#" class="btn btn-primary mrgn-tp-md mrgn-lft-sm" style="display:inline-block;" title="<?php echo elgg_echo('onboard:profile:addskills');?>" onclick="addButtonSubmit(event)">
        <?php echo elgg_echo('onboard:profile:add');?>
    </a>
</div>
<section id="toomany" class="alert alert-info">
    <h3>
        <?php echo elgg_echo('onboard:skills:headsup');?>
    </h3>
    <p>
        <?php echo elgg_echo('onboard:skills:headsuplimit');?>
    </p>
</section>

<div id="popSkills" class="">

    <p class="mrgn-bttm-md">
        <strong>
            <?php echo elgg_echo('onboard:profile:orskills');?>
        </strong>
    </p>
   <div>

       <?php
           //array of popular skills
       $skillList = array(
            'onboard:skill:pop:projectmanagement',
            'onboard:skill:pop:microsoftexcel',
            'onboard:skill:pop:microsoftword',
            'onboard:skill:pop:microsoftpowerpoint',
            'onboard:skill:pop:microsoftoutlook',
            'onboard:skill:pop:publicspeaking',
            'onboard:skill:pop:projectcoordination',
            'onboard:skill:pop:teamwork',
            'onboard:skill:pop:leadership',
            'onboard:skill:pop:socialmedia',
            'onboard:skill:pop:informationmanagement'
            );

       //shuffle it for fun
       shuffle($skillList);

       foreach($skillList as $s){

           $popSkill = elgg_echo($s);

           //add skill pills
           echo '<div tabindex="0" title="'.elgg_echo('onboard:profile:addSkill', array(elgg_echo("$s"))).'" class="clearfix pop-skill" data-type="skill" onclick="addPopSkill(this)" data-guid="'.elgg_echo("$s").'">
                    <div class="skill-container clearfix" style="display:inline-block">
                        <div class="gcconnex-endorsements-skill" data-type="skill">'.elgg_echo("$s").'</div>
                    </div>
                 </div>';


       }
           ?>

    </div>

</div>
    <?php
    ?>

    <div class="mrgn-bttm-md mrgn-tp-md pull-right">
    <a id="skip" class="mrgn-lft-sm btn btn-default" href="#">
        <?php echo elgg_echo('onboard:skip'); ?>
    </a>
        <?php
    echo elgg_view('output/url', array(
            'href'=>'#',
            'class'=>'btn btn-primary',
            'text' => elgg_echo('onboard:welcome:next'),
            'id' => 'onboard-skills',
        ));
        ?>

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

        //pop skills
        $('#popSkills').on('keypress', '.gcconnex-skill-entry', function (e) {
            e.preventDefault();
            if (e.keyCode == 13) {
                $(this).trigger('click');
            }
        });

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



        ////////////////////////////////////////////////////// ELGG ACTIONS

        //add skills
        $('#onboard-skills').on('click', function () {

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

            //add skills action
            elgg.action('onboard/update-profile', {
                data: {
                    section: 'skills',
                    skillsadded: $skills_added,
                    skillsremoved: $delete_guid,
                },
                success: function (wrapper) {
                    changeStepProgress(6);
                    //grab next step
                    elgg.get('ajax/view/profile-steps/stepFive', {
                        success: function (output) {

                            $('#step').html(output);

                        }
                    });

                    //update profile strength percent
                    elgg.get('ajax/view/profileStrength/info', {
                        success: function (output) {

                            $('#profileInfo').html(output);

                        }
                    });
                }
            });
        });

        //skip to next step
        $('#skip').on('click', function () {
            elgg.get('ajax/view/profile-steps/stepFive', {
                success: function (output) {
                    changeStepProgress(6);
                    $('#step').html(output);

                    elgg.get('ajax/view/profileStrength/info', {
                        success: function (output) {

                            $('#profileInfo').html(output);
                        }
                    });
                }
            });
        });

    </script>

<style>
    .tt-dropdown-menu {
        width: 310px;
        padding: 8px 0;
        background-color: #fff;
        border: 1px solid #ccc;
        border: 1px solid rgba(0, 0, 0, 0.2);
        border-radius: 8px;
        box-shadow: 0 5px 10px rgba(0,0,0,.2);
    }
        .tt-suggest-username-wrapper {
        padding-top: 3px;
    }

    .tt-suggestion {
        padding: 3px 20px;
        font-size: 18px;
        line-height: 24px;
    }

    .tt-suggestion.tt-is-under-cursor,
    .tt-suggestion.tt-cursor { /* UPDATE: newer versions use .tt-suggestion.tt-cursor */
        color: #fff;
        background-color: #055959;
    }

    .picked-skill {
           display:inline-block;


        height: 30px;
        overflow-x: hidden;
        -ms-overflow-x: hidden;
        overflow-y: hidden;
        -ms-overflow-y: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-family: arial, sans-serif;
        background-color: #f0f0f0;
        border-bottom: 1px solid lightgrey;
        border-right: 1px solid lightgrey;
        color: #335075;
       /* color: white;
        background: #055959;*/
        padding: 3px 10px 3px 10px;
        border-radius: 5px;
        /* box-shadow: 5px 3px 5px #888888; */
        margin-left: 0px;
        margin-right: 5px;
    }

    .pop-skill {
           display:inline-block;
        height: 30px;
        overflow-x: hidden;
        -ms-overflow-x: hidden;
        overflow-y: hidden;
        -ms-overflow-y: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;


        border: 1px solid #055959;
        color: #055959;
       /* color: white;
        background: #055959;*/
        padding: 3px 10px 3px 10px;
        border-radius: 10px;
        /* box-shadow: 5px 3px 5px #888888; */
        margin-left: 0px;
        margin-right: 5px;
    }

    .pop-skill:hover {

        cursor: pointer;
        background: #047177;
        color: white;
    }

    label {
        display: block;
    }

    .picked-skill:hover{

        box-shadow: rgba(0,0,0,0.25) 0 0 6px;
        cursor: pointer;
    }

    .yourSkills {

        border: 1px solid #ccc;
        padding: 10px;
        margin: 5px;
    }

    .close-x {
        color:rgba(180,0,0,0.5);
    }

    .close-x:hover {
        color:rgba(180,0,0,0.9);
    }
</style>
