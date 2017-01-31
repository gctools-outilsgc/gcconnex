/*
 * Purpose: Provides 'LinkedIn-like endorsements' functionality for use on user profiles and handles ajax for profile edits
 *
 * License: GPL v2.0
 * Full license here: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Author: Bryden Arndt
 * email: bryden@arndt.ca
 */
 /*
 * GC_MODIFICATION
 * Description: Modified guid input of most actions to be elgg.get_page_owner_guid() to allow us as developers to easily work on bugs on profiles
 * Author: Ethan Wallace
 * Date: 2016-12-01
 * Issue Number: 549
 */

/*
 * Purpose: initialize the script
 */

function initFancyProfileBox() {

    var select = function(e, user) {
        $('#manager-id').val(user.guid);
    };

    var manager = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: elgg.get_site_url() + "userfind?query=%QUERY",
            filter: function (response) {
                // Map the remote source JSON array to a JavaScript object array
                return $.map(response, function (user) {
                    return {
                        'value': user.value,
                        'guid': user.guid,
                        'pic': user.pic,
                        'avatar': user.avatar
                    };
                });
            }
        }
    });

    // initialize bloodhound engine for colleague auto-suggest
    manager.initialize();

    $('#manager').typeahead(null, {
        name: 'manager',
        displayKey: function(user) {
            return user.value;
        },
        limit: Infinity,
        source: manager.ttAdapter(),
        /*
        source: function(query, cb) {
            manager.get(query, function(suggestions) {
                cb(filter(suggestions));
            });
        },
        */
        templates: {
            suggestion: function (user) {
                return '<div class="tt-suggest-avatar">' + user.pic + '</div><div class="tt-suggest-username">' + user.value + '</div><br>';
            }
        }
    }).bind('typeahead:selected', select);


}



$(document).ready(function() {
        initFancyProfileBox();
        /*$(".gcconnex-basic-profile-edit").fancybox({
            'autoDimensions': false,
            'width': '800',
            'height': '580',
            'onComplete': initFancyProfileBox
        });

    /*
    var tour = new Tour({
        steps: [
            {
                element: "#profile-details",
                title: "Test",
                content: "This is a test"
            },
            {
                element: ".b_user_menu",
                title: "Another",
                content: "Muahahaha"
            }
        ]
    });

    tour.init();
    tour.start();
    */

    // bootstrap tabs.js functionality..
    $('#myTab a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });

    // bootstrap modal functionality for edit basic profile

    var departments = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        //prefetch: '../data/films/post_1960.json',
        //remote: '../data/films/queries/%QUERY.json'
        remote: {
            url: elgg.get_site_url() + 'mod/b_extended_profile/actions/b_extended_profile/autodept.php?query=%QUERY'
        }
    });

    departments.initialize();

    /* $('.gcconnex-basic-department').typeahead(null, {
        name: 'department',
        displayKey: 'value',
        limit: 10,
        source: departments.ttAdapter()
    });*/

    // show "edit profile picture" overlay on hover
    $('.avatar-profile-edit').hover(
        function() {
            $('.avatar-hover-edit').stop(true,true);
            $('.avatar-hover-edit').fadeIn('slow');
        },
        function() {
            $('.avatar-hover-edit').stop(true,true);
            $('.avatar-hover-edit').fadeOut('slow');
        }
    );


    // initialize edit/save/cancel buttons and hide some of the toggle elements
    $('.save-control').hide();
    $('.cancel-control').hide();

    $('.edit-control').hover(function() {
            $(this).addClass('edit-hover');
        },
        function(){
            $(this).removeClass('edit-hover');
        });

    $('.cancel-control').hover(function() {
            $(this).addClass('cancel-hover');
        },
        function(){
            $(this).removeClass('cancel-hover');
        });

    $('.save-control').hover(function() {
            $(this).addClass('save-hover');
        },
        function(){
            $(this).removeClass('save-hover');
        });

    //link the edit/save/cancel buttons with the appropriate functions on click..
    $('.edit-about-me').on("click", {section: "about-me"}, editProfile);
    $('.save-about-me .save-about-me').on("click", {section: "about-me"}, saveProfile);
    $('.cancel-about-me').on("click", {section: "about-me"}, cancelChanges);

    $('.edit-education').on("click", {section: "education"}, editProfile);
    $('button.save-education').on("click", {section: "education"}, saveProfile);
    $('.cancel-education').on("click", {section: "education"}, cancelChanges);

    $('.edit-work-experience').on("click", {section: "work-experience"}, editProfile);
    $('button.save-work-experience').on("click", {section: "work-experience"}, saveProfile);
    $('.cancel-work-experience').on("click", {section: "work-experience"}, cancelChanges);

    $('.edit-skills').on("click", {section: "skills"}, editProfile);
    $('.save-skills .save-skills').on("click", {section: "skills"}, saveProfile);
    $('.cancel-skills').on("click", {section: "skills"}, cancelChanges);

    $('.edit-languages').on("click", {section: "languages"}, editProfile);
    $('.save-languages .save-languages').on("click", {section: "languages"}, saveProfile);
    $('.cancel-languages').on("click", {section: "languages"}, cancelChanges);

    $('.edit-portfolio').on("click", {section: "portfolio"}, editProfile);
    $('.save-portfolio .save-portfolio').on("click", {section: "portfolio"}, saveProfile);
    $('.cancel-portfolio').on("click", {section: "portfolio"}, cancelChanges);

    /*
     * MODIFIED CODE
     * Adding a section for opt-ins with 3 distinct buttons.
     * Activates the buttons and links them to their respective functions.
     */
    $('.edit-opt-in').on("click", {section: "opt-in"}, editProfile);
    $('.save-opt-in .save-opt-in').on("click", {section: "opt-in"}, saveProfile);
    $('.cancel-opt-in').on("click", {section: "opt-in"}, cancelChanges);
    /*
     * END MODIFIED CODE
     */

    $('.save-profile').on('click', { section: "profile" }, saveProfile);

    $('.gcconnex-education-add-another').on("click", {section: "education"}, addMore);


    //add focus to click events to allow easy tabbing through edit content
    $('.edit-education').on("click", function(){$('.cancel-education').focus()});
    $('.save-education').on("click", function(){$('.edit-education').focus()});
    $('.cancel-education').on("click", function(){$('.edit-education').focus()});

    $('.edit-about-me').on("click", function(){$('.cancel-about-me').focus()});
    $('.save-about-me').on("click", function(){$('.edit-about-me').focus()});
    $('.cancel-about-me').on("click", function(){$('.edit-about-me').focus()});

    $('.edit-work-experience').on("click", function(){$('.cancel-work-experience').focus()});
    $('.save-work-experience').on("click", function(){$('.edit-work-experience').focus()});
    $('.cancel-work-experience').on("click", function(){$('.edit-work-experience').focus()});

    $('.edit-skills').on("click", function () { $('.cancel-skills').focus(); $('.gcconnex-skill-limit').removeClass('hidden');});
    $('.save-skills').on("click", function () { $('.edit-skills').focus(); $('.gcconnex-skill-limit').addClass('hidden'); $('#skillsAccessContainer').remove(); });

    $('.cancel-skills').on("click", function () { $('.edit-skills').focus(); $('.gcconnex-skill-limit').addClass('hidden'); $('#skillsAccessContainer').remove(); });

    $('.edit-languages').on("click", function(){$('.cancel-languages').focus()});
    $('.save-languages').on("click", function(){$('.edit-languages').focus()});
    $('.cancel-languages').on("click", function(){$('.edit-languages').focus()});

    $('.edit-portfolio').on("click", function(){$('.cancel-portfolio').focus()});
    $('.save-portfolio').on("click", function(){$('.edit-portfolio').focus()});
    $('.cancel-portfolio').on("click", function () { $('.edit-portfolio').focus() });

    /*
     * MODIFIED CODE
     * Adds focus for easy tabbing through buttons.
     */
    $('.edit-opt-in').on("click", function(){$('.cancel-portfolio').focus()});
    $('.save-opt-in').on("click", function(){$('.edit-portfolio').focus()});
    $('.cancel-opt-in').on("click", function(){$('.edit-portfolio').focus()});
    /*
     * END MODIFIED CODE
     */

    //allow use of keyboard to endorse skills
    $('.skill-container').bind('keypress', function (e) {

        if (e.keyCode == 13) {

            if ($(this).hasClass('gcconnex-endorsement-add')) {

                addEndorsement($(this))
            } else {
               retractEndorsement($(this))

            }
        }

    });

    // when a user clicks outside of the input text box (the one for entering new skills in the endorsements area), make it disappear elegantly
    $(document).click(function(event) {
        if(!$(event.target).closest('.gcconnex-endorsements-input-wrapper').length) {
            if($('.gcconnex-endorsements-input-skill').is(":visible")) {
                $('.gcconnex-endorsements-input-skill').hide();
                $('.gcconnex-endorsements-add-skill').fadeIn('slowly');
            }
        }
    });
    $(document).on('mouseover', '.gcconnex-avatar-in-list', function() {
        $(this).find('.remove-colleague-from-list').toggle();
    });
    $(document).on('mouseout', '.gcconnex-avatar-in-list', function() {
        $(this).find('.remove-colleague-from-list').toggle();
    });

});

/*
 * Purpose: To handle all click events on "edit" controls for the gcconnex profile.
 *
 * Porpoise: Porpoises are small cetaceans of the family Phocoenidae; they are related to whales and dolphins.
 *   They are distinct from dolphins, although the word "porpoise" has been used to refer to any small dolphin,
 *   especially by sailors and fishermen. This paragraph has nothing to do with this function.
 */
function editProfile(event) {

    var $section = event.data.section; // which edit button is the user clicking on?

    // toggle the edit, save, cancel buttons
    $('.edit-' + $section).hide();
    $('.edit-' + $section).addClass('hidden');
    $('.edit-' + $section).addClass('wb-invisible');

    $('#edit-' + $section).append('<div id="" class="load-spinner"></div>');

    switch ($section) {
        case 'about-me':



            // Edit the About Me blurb
            $.get(elgg.normalize_url('ajax/view/b_extended_profile/edit_about-me'),
                {
                    guid: elgg.get_page_owner_guid()
                },
                function(data) {
                    $('.gcconnex-about-me').append('<div class="gcconnex-about-me-edit-wrapper">' + data + '</div>');
                    $('.save-' + $section).show();
                    $('.save-' + $section).removeClass('hidden');
                    $('.save-' + $section).removeClass('wb-invisible');

                    $('.cancel-' + $section).show();
                    $('.cancel-' + $section).removeClass('hidden');
                    $('.cancel-' + $section).removeClass('wb-invisible');

                    $('load-spinner').addClass('hidden');
                    $('.load-spinner').addClass('wb-invisible');
                });
            $('.gcconnex-profile-about-me-display').hide();
            break;
        case 'education':
            // Edit the edumacation
            $.get(elgg.normalize_url('ajax/view/b_extended_profile/edit_education'),
                {
                    guid: elgg.get_page_owner_guid()
                },
                function(data) {
                    // Output in a DIV with id=somewhere
                    $('.gcconnex-education').append('<div class="gcconnex-education-edit-wrapper">' + data + '</div>');
                    $('.save-' + $section).show();
                    $('.save-' + $section).removeClass('hidden');
                    $('.save-' + $section).removeClass('wb-invisible');

                    $('.cancel-' + $section).show();
                    $('.cancel-' + $section).removeClass('hidden');
                    $('.cancel-' + $section).removeClass('wb-invisible');

                    $('load-spinner').addClass('hidden');
                    $('.load-spinner').addClass('wb-invisible');
                });
            $('.gcconnex-profile-education-display').hide();
            break;
        case 'work-experience':
            // Edit the experience for this user
            $.get(elgg.normalize_url('ajax/view/b_extended_profile/edit_work-experience'),
                {
                    guid: elgg.get_page_owner_guid()
                },
                function(data) {
                    // Output in a DIV with id=somewhere
                    $('.gcconnex-work-experience').append('<div class="gcconnex-work-experience-edit-wrapper">' + data + '</div>');
                    //elgg.security.refreshToken();

                    $userFind = [];
                    $colleagueSelected = [];

                    $('.userfind').each(function() {
                        user_search_init(this);
                    });
                    $('.gcconnex-profile-work-experience-display').hide();
                    $('.save-' + $section).show();
                    $('.save-' + $section).removeClass('hidden');
                    $('.save-' + $section).removeClass('wb-invisible');

                    $('.cancel-' + $section).show();
                    $('.cancel-' + $section).removeClass('hidden');
                    $('.cancel-' + $section).removeClass('wb-invisible');

                    $('load-spinner').addClass('hidden');
                    $('.load-spinner').addClass('wb-invisible');
                });
            break;

        case 'skills':
            // inject the html to add ability to add skills
            elgg.get('ajax/view/b_extended_profile/skills-access', {
                    data: {
                        guid: elgg.get_logged_in_user_guid(), // querystring
                    },
                    success: function (output) {
                        //console.log(output);
                        $('.gcconnex-skills').prepend(output);
                        //$('.myplugin-link').html(output);
                    }
                });
            if ( $('.gcconnex-skill-entry:visible').length < 15 ) {
                 /////
                //console.log('skills in if');
                ////
                var christineFix = elgg.echo("gcconnex_profile:gc_skill:add", null, 'en');
                $('.gcconnex-skills').append('<div class="gcconnex-endorsements-input-wrapper">' +
                '<input type="text" class="gcconnex-endorsements-input-skill" onkeyup="checkForEnter(event)"/>' +
                '<button class="btn btn-primary gcconnex-endorsements-add-skill">' + ' + add skill / ajouter des compétences ' + '</button>' +
                '</div>');
            }

            var newSkill = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                //prefetch: '../data/films/post_1960.json',
                //remote: '../data/films/queries/%QUERY.json'
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

            // hide the skill entry text box which is only to be shown when toggled by the link
            $('.gcconnex-endorsements-input-skill').hide();

            // the profile owner would like to type in a new skill
            $('.gcconnex-endorsements-add-skill').on("click", function () {
                $('.gcconnex-endorsements-input-skill').fadeIn('slowly').focus() ;
                $('.gcconnex-endorsements-add-skill').hide();
            });

            // create a "delete this skill" link for each skill
            $('.gcconnex-endorsements-skill').each(function(){
                $(this).after('<button class="delete-skill" onclick="deleteEntry(this)" data-type="skill">' + '<i class="fa fa-trash-o delete-skill-img"></i>Delete / Supprimer' + '</button>'); //goes in here i think..
            });
            $('.save-' + $section).show();
            $('.save-' + $section).removeClass('hidden');
            $('.save-' + $section).removeClass('wb-invisible');
            $('.gcconnex-skill-limit').show();

            $('.cancel-' + $section).show();
            $('.cancel-' + $section).removeClass('hidden');
            $('.cancel-' + $section).removeClass('wb-invisible');

            $('load-spinner').addClass('hidden');
            $('.load-spinner').addClass('wb-invisible');

            //$('.delete-skill').show();

            break;
        case 'languages':
            // Edit the languages for this user

            $.get(elgg.normalize_url('ajax/view/b_extended_profile/edit_languages'),
                {
                    guid: elgg.get_page_owner_guid()
                },
                function(data) {
                    // Output in a DIV with id=somewhere
                    $('.gcconnex-languages').append('<div class="gcconnex-languages-edit-wrapper">' + data + '</div>');
                    $('.gcconnex-profile-languages-display').hide();
                    $('.save-' + $section).show();
                    $('.save-' + $section).removeClass('hidden');
                    $('.save-' + $section).removeClass('wb-invisible');

                    $('.cancel-' + $section).show();
                    $('.cancel-' + $section).removeClass('hidden');
                    $('.cancel-' + $section).removeClass('wb-invisible');

                    $('load-spinner').addClass('hidden');
                    $('.load-spinner').addClass('wb-invisible');

                    //hide creds for chosen language
                    if($('#first_official_language').val() == "ENG"){
                        $('#engCred').hide();
                    } else if($('#first_official_language').val() == "FRA") {
                        $('#fraCred').hide();
                    } else {
                        $('#fraCred').hide();
                        $('#engCred').hide();
                    }

                //$official_langs.find('.gcconnex-languages-english-writtencomp').val(),
                });
            break;
        case 'portfolio':
            $.get(elgg.normalize_url('ajax/view/b_extended_profile/edit_portfolio'),
                {
                    guid: elgg.get_page_owner_guid()
                },
            function(data) {
                // Output the 'edit portfolio' page somewhere
                $('.gcconnex-portfolio').append('<div class="gcconnex-portfolio-edit-wrapper">' + data + '</div>');
                $('.gcconnex-profile-portfolio-display').hide();
                $('.save-' + $section).show();
                $('.save-' + $section).removeClass('hidden');
                $('.save-' + $section).removeClass('wb-invisible');

                $('.cancel-' + $section).show();
                $('.cancel-' + $section).removeClass('hidden');
                $('.cancel-' + $section).removeClass('wb-invisible');

                $('load-spinner').addClass('hidden');
                $('.load-spinner').addClass('wb-invisible');
            });

        /*
         * MODIFIED CODE
         * Hides the opt-in view and shows the edit_opt-in view.
         */
        case 'opt-in':
            $.get(elgg.normalize_url('ajax/view/b_extended_profile/edit_opt-in'),
             	{
                	guid: elgg.get_logged_in_user_guid()
                },
            function(data) {
                // Adds in the opt-in edit view.
                $('.gcconnex-opt-in').append('<div class="gcconnex-opt-in-edit-wrapper">' + data + '</div>');

                // Hides the opt-in display view to make way for the edit view.
                $('.gcconnex-profile-opt-in-display').hide();

                // Displays the save button.
                $('.save-' + $section).show();
                $('.save-' + $section).removeClass('hidden');
                $('.save-' + $section).removeClass('wb-invisible');

                $('.cancel-' + $section).show();
                $('.cancel-' + $section).removeClass('hidden');
                $('.cancel-' + $section).removeClass('wb-invisible');

                $('load-spinner').addClass('hidden');
                $('.load-spinner').addClass('wb-invisible');
            });
            break;
        /*
         * END MODIFIED CODE
         */

        default:
            break;
    }
}

function hideLanguage() {
    //hide creds for chosen language
    if($('#first_official_language').val() == "ENG"){
        $('#fraCred').show();
        $('#engCred').hide();
    } else if($('#first_official_language').val() == "FRA") {
        $('#engCred').show();
        $('#fraCred').hide();
    } else {
        $('#engCred').hide();
        $('#fraCred').hide();
    }
}

function user_search_init(target) {

    var tid = $(target).data("tid");
    tidName = tid;
    $userSuggest = $('.' + tid);
    $colleagueSelected[tid] = [];

    $(target).closest('.gcconnex-work-experience-entry').find('.gcconnex-avatar-in-list').each(function() {
        $colleagueSelected[tid].push($(this).data('guid'));
    });

    var select = function(e, user, dataset) {
        $colleagueSelected[dataset].push(user.guid);
        $("#selected").text(JSON.stringify($colleagueSelected[dataset]));
        $("input.typeahead").typeahead("val", "");
    };
    //$colleagueSelected[tid] = [];
    //$colleagueSelected[tid].push(selected);

    var filter = function(suggestions, tidName) {
        return $.grep(suggestions, function(suggestion, tid) {
            return $.inArray(suggestion.guid, $colleagueSelected[suggestion.tid]) === -1;
        });
    };

    var userName = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: elgg.get_site_url() + "userfind?query=%QUERY",
            filter: function (response) {
                // Map the remote source JSON array to a JavaScript object array
                return $.map(response, function (user) {
                    return {
                        'value': user.value,
                        'guid': user.guid,
                        'pic': user.pic,
                        'avatar': user.avatar,
                        'tid': tid
                    };
                });
            }
        }
    });

    // initialize bloodhound engine for colleague auto-suggest
    userName.initialize();

    var userSearchField = $userSuggest.typeahead(null, {
        name: tid,
        displayKey: function(user) {
            return user.value;
        },
        limit: 0,
        //source: userName.ttAdapter(),
        source: function(query, cb) {
            userName.get(query, function(suggestions) {
                cb(filter(suggestions, tidName));
            });
        },
        templates: {
            suggestion: function (user) {
                return '<div class="tt-suggest-username-wrapper"><div class="tt-suggest-avatar">' + user.pic + '</div><div class="tt-suggest-username">' + user.value + '</div></div>';
            }
        }
    }).bind('typeahead:selected', select);

    $userSuggest.on('typeahead:selected', addColleague);
    $userSuggest.on('typeahead:autocompleted', addColleague);

    $userFind.push(userSearchField);
}

/*
 * Purpose: Save any changes made to the profile
 */
function saveProfile(event) {

    var $section = event.data.section;

    var $valid_form = true;

    //since elgg.echo isnt working, doing it the ugly way
    if(elgg.get_language() == 'en'){
      var errorMsg = "Please fill in the highlighted fields above";
    } else {
      var errorMsg = "S'il vous plaît, remplir les champs en surbrillances ci-dessus.";
    }

    switch ($section) {
        case "profile":

            var profile = {};

            profile.name = $(".gcconnex-basic-name").val();
            profile.job = $(".gcconnex-basic-job").val();
            profile.department = $('.gcconnex-basic-department').val();
            profile.location = $(".gcconnex-basic-location").val();
            profile.phone = $(".gcconnex-basic-phone").val();
            profile.mobile = $(".gcconnex-basic-mobile").val();
            profile.email = $(".gcconnex-basic-email").val();
            profile.website = $(".gcconnex-basic-website").val();

            var social_media = {};

            social_media.facebook = $(".gcconnex-basic-facebook").val();
            social_media.google = $(".gcconnex-basic-google").val();
            social_media.github = $(".gcconnex-basic-github").val();
            social_media.twitter = $(".gcconnex-basic-twitter").val();
            social_media.linkedin = $(".gcconnex-basic-linkedin").val();
            social_media.pinterest = $(".gcconnex-basic-pinterest").val();
            social_media.tumblr = $(".gcconnex-basic-tumblr").val();
            social_media.instagram = $(".gcconnex-basic-instagram").val();
            social_media.flickr = $(".gcconnex-basic-flickr").val();
            social_media.youtube = $(".gcconnex-basic-youtube").val();


            elgg.action('b_extended_profile/edit_profile', {
                data: {
                    'guid': elgg.get_page_owner_guid(),
                    'section': "profile",
                    'profile': profile,
                    'social_media': social_media
                },
                success: function() {
                    //if (response.system_messages["success"] != "") {
                        // close the modal
                        window.location.replace(window.location.href);
                    //}
                }
            });

            //$('#editProfile').modal('hide');

            break;
        case "about-me":
            var area = $('#aboutme').val();
            var $about_me = $.trim(area);
            var access = $('.gcconnex-about-me-access').val();
            // save the information the user just edited
            elgg.action('b_extended_profile/edit_profile', {
                data: {
                    'guid': elgg.get_page_owner_guid(),
                    'section': 'about-me',
                    'description': $about_me,
                    'access': access
                },
                success: function() {            // fetch and display the information we just saved
                    $.get(elgg.normalize_url('ajax/view/b_extended_profile/about-me'),
                        {
                            'guid': elgg.get_page_owner_guid()
                        },
                        function(data) {
                            // Output in a DIV with id=somewhere
                            $('.gcconnex-profile-about-me-display').remove();
                            $('.gcconnex-about-me').append('<div class="gcconnex-profile-about-me-display">' + data + '</div>');
                        });
                }
            });

            $('.gcconnex-about-me-edit-wrapper').remove();

            break;

        case "education":

            var $education_guid = [];
            var $delete_guid = [];

            $('.gcconnex-education-entry').each(function() {
                if ( $(this).is(":hidden") ) {
                    if ($(this).data('guid') != "new") {
                        $delete_guid.push($(this).data('guid'));
                    }
                }
                else {
                    $education_guid.push($(this).data('guid'));
                }
            });

            //School field
            var $school = [];
            $('.gcconnex-education-school').not(":hidden").each(function() {
              //check if field is empty
              if($.trim($(this).val()) == ''){
                  //report error
                  $valid_form = false;
                  //add error style to field
                  $(this).addClass('input-error').attr('aria-invalid', "true");
              } else {
                //remove error classes if field has them
                $(this).removeClass('input-error').removeAttr('aria-invalid', "true");
                //push the field info into array
                $school.push($(this).val());
              }
            });

            //ongoing check box
            var $ongoing = [];
            $('.gcconnex-education-ongoing').not(":hidden").each(function() {
                $ongoing.push($(this).prop('checked'));
            });

            //start month dropdown
            var $startdate = [];
            $('.gcconnex-education-startdate').not(":hidden").each(function() {
                $startdate.push($(this).val());
            });

            //start year field
            var $startyear = [];
            $('.gcconnex-education-start-year').not(":hidden").each(function() {
              //check if field is empty
              if($.trim($(this).val()) == ''){
                  //report error
                  $valid_form = false;
                  //add error style to field
                  $(this).addClass('input-error').attr('aria-invalid', "true");
              } else {
                //remove error style if active
                $(this).removeClass('input-error').removeAttr('aria-invalid', "true");
                //push value into array
                $startyear.push($(this).val());
              }
            });

            //end month dropdown
            var $enddate = [];
            $('.gcconnex-education-enddate').not(":hidden").each(function() {
                $enddate.push($(this).val());
            });

            //end year field
            var $endyear = [];
            //count which entity we are on to compare start/end date
            var $entry_count = 0;
            $('.gcconnex-education-end-year').not(":hidden").each(function() {
              //if ongoing is checked, dont validate
              if($ongoing[$entry_count] == true){
                //remove error classes if field has them
                $(this).removeClass('input-error').removeAttr('aria-invalid', "true");
                //push the field info into array
                $endyear.push($(this).val());
              } else if($ongoing[$entry_count] == false) {

                //check if empty or that end date is not a date before start date
                if($.trim($(this).val()) == '' || $(this).val() < $startyear[$entry_count]){
                    //report error
                    $valid_form = false;
                    //add error style
                    $(this).addClass('input-error').attr('aria-invalid', "true");
                } else {
                  //remove error classes if field has them
                  $(this).removeClass('input-error').removeAttr('aria-invalid', "true");
                  //push the field info into array
                  $endyear.push($(this).val());
                }

              }

                //increase count
                $entry_count++;
            });

            //degree field
            var $degree = [];
            $('.gcconnex-education-degree').not(":hidden").each(function() {
              //check if field is empty
              if($.trim($(this).val()) == ''){
                  //report error
                  $valid_form = false;
                  //add error style to field
                  $(this).addClass('input-error').attr('aria-invalid', "true");
              } else {
                //remove error style if active
                $(this).removeClass('input-error').removeAttr('aria-invalid', "true");
                //push value to array
                $degree.push($(this).val());
              }
            });

            //field of study field
            var $field = [];
            $('.gcconnex-education-field').not(":hidden").each(function() {
              //check if field is empty
              if($.trim($(this).val()) == ''){
                //report error
                  $valid_form = false;
                  //add error style
                  $(this).addClass('input-error').attr('aria-invalid', "true");
              } else {
                //remove error style if active
                $(this).removeClass('input-error').removeAttr('aria-invalid', "true");
                //push value to array
                $field.push($(this).val());
              }
            });
            var $access = $('.gcconnex-education-access').val();

            // save the information the user just edited
            if($valid_form){
            elgg.action('b_extended_profile/edit_profile', {
                data: {
                    'guid': elgg.get_page_owner_guid(),
                    'delete': $delete_guid,
                    'eguid': $education_guid,
                    'section': 'education',
                    'school': $school,
                    'startdate': $startdate,
                    'startyear': $startyear,
                    'enddate': $enddate,
                    'endyear': $endyear,
                    'ongoing': $ongoing,
                    //'program': $program,
                    'degree': $degree,
                    'field': $field,
                    'access': $access
                },
                success: function() {            // fetch and display the information we just saved
                    $.get(elgg.normalize_url('ajax/view/b_extended_profile/education'),
                        {
                            'guid': elgg.get_page_owner_guid()
                        },
                        function(data) {
                            // Output in a DIV with id=somewhere
                            $('.gcconnex-education-display').remove();
                            $('.gcconnex-education').append('<div class="gcconnex-education-display">' + data + '</div>');
                        });
                }
                });

                $('.gcconnex-education-edit-wrapper').remove();
                $('#edu-error').remove();

              } else if($('#edu-error').size() < 1) {
                $('div.save-education').prepend('<section id="edu-error" class="alert alert-danger">'+errorMsg+'</section>');
              }

            break;
        case "work-experience":

            var work_experience = {};
            var experience = [];

            work_experience.edit = experience;
            work_experience.delete_guids = [];
            var access = $('.gcconnex-work-experience-access').val();

            $('.gcconnex-work-experience-entry').each(function() {
                if ( $(this).is(":hidden") ) {
                    //if ($(this).data('guid') != "new") {
                        work_experience.delete_guids.push($(this).data('guid'));
                        //$delete_guid.push($(this).data('guid'));
                   // }
                }
                else {
                    experience = {
                        'eguid': $(this).data('guid'),
                        'organization': $(this).find('.gcconnex-work-experience-organization').val(),
                        'title': $(this).find('.gcconnex-work-experience-title').val(),
                        'startdate': $(this).find('.gcconnex-work-experience-startdate').val(),
                        'startyear': $(this).find('.gcconnex-work-experience-start-year').val(),
                        'enddate': $(this).find('.gcconnex-work-experience-enddate').val(),
                        'endyear': $(this).find('.gcconnex-work-experience-end-year').val(),
                        'ongoing': $(this).find('.gcconnex-work-experience-ongoing').prop('checked'),
                        'responsibilities': $(this).find('.gcconnex-work-experience-responsibilities').val()
                    };
                    experience.colleagues = [];
                    $(this).find('.gcconnex-avatar-in-list').each(function() {
                        if ($(this).is(':visible')) {
                            experience.colleagues.push($(this).data('guid'));
                        }
                    });

                    //title field
                    if($.trim(experience['title']) == ''){
                      $(this).find('.gcconnex-work-experience-title').addClass('input-error').attr('aria-invalid', "true");
                      $valid_form = false;
                    } else {
                      $(this).find('.gcconnex-work-experience-title').removeClass('input-error').removeAttr('aria-invalid', "true");
                    }

                    //organization field
                    if($.trim(experience['organization']) == ''){
                      $(this).find('.gcconnex-work-experience-organization').addClass('input-error').attr('aria-invalid', "true");
                      $valid_form = false;
                    } else {
                      $(this).find('.gcconnex-work-experience-organization').removeClass('input-error').removeAttr('aria-invalid', "true");
                    }

                    //start year field
                    if($.trim(experience['startyear']) == ''){
                      $(this).find('.gcconnex-work-experience-start-year').addClass('input-error').attr('aria-invalid', "true");
                      $valid_form = false;
                    } else {
                      $(this).find('.gcconnex-work-experience-start-year').removeClass('input-error').removeAttr('aria-invalid', "true");
                    }

                    //end year field
                    if(experience['ongoing'] == true){
                      $(this).find('.gcconnex-work-experience-end-year').removeClass('input-error').removeAttr('aria-invalid', "true");
                      //dont do any validation on endyear since it doesnt matter while ongoing is active
                    } else if($.trim(experience['endyear']) == '' || experience['endyear'] < experience['startyear']){
                      $(this).find('.gcconnex-work-experience-end-year').addClass('input-error').attr('aria-invalid', "true");
                      $valid_form = false;
                    } else {
                      $(this).find('.gcconnex-work-experience-end-year').removeClass('input-error').removeAttr('aria-invalid', "true");
                    }

                    work_experience.edit.push(experience);
                }
            });

            //only call action if is verything passes validation
            if($valid_form){
            // save the information the user just edited
            elgg.action('b_extended_profile/edit_profile', {
                data: {
                    'guid': elgg.get_page_owner_guid(),
                    'work': work_experience,
                    'section': 'work-experience',
                    'access': access
                },
                success: function() {
                    $.get(elgg.normalize_url('ajax/view/b_extended_profile/work-experience'),
                        {
                            'guid': elgg.get_page_owner_guid()
                        },
                        function(data) {
                            // Output in a DIV with id=somewhere
                            $('.gcconnex-profile-work-experience-display').remove();
                            $('.gcconnex-work-experience').append('<div class="gcconnex-profile-work-experience-display"><div class="gcconnex-work-experience-display">' + data + '</div></div>');
                        });
                }
            });
            $('.gcconnex-work-experience-edit-wrapper').remove();
            $('#work-error').remove();
          } else if($('#work-error').size() < 1) {
            $('div.save-work-experience').prepend('<section id="work-error" class="alert alert-danger">'+errorMsg+'</section>');
          }

            break;

        case "skills":
            var $skills_added = [];
            var $delete_guid = [];

            if ($('.gcconnex-endorsements-input-skill').is(":visible")) {
                skillSubmit();
            }

            $('.gcconnex-skill-entry').each(function () {
                if ($(this).is(":hidden")) {
                    $delete_guid.push($(this).data('guid'));
                }
                if ($(this).hasClass("temporarily-added")) {
                    $skills_added.push($(this).data('skill'));
                }
            });

            // save the information the user just edited

            elgg.action('b_extended_profile/edit_profile', {
                'guid': elgg.get_page_owner_guid(),
                'section': 'skills',
                'access': $('#skillsAccess').val(),
                'skillsadded': $skills_added,
                'skillsremoved': $delete_guid
            });

            $('.delete-skill-img').remove();
            $('.delete-skill').remove();
            $('.gcconnex-endorsements-input-wrapper').remove();
            $('.gcconnex-skill-entry').removeClass('temporarily-added');
            $('.gcconnex-skill-limit').hide();

            break;

        case 'languages':

            var english = [];
            var french = [];
            var firstlang = $('.gcconnex-languages-edit-wrapper').find('.gcconnex-first-official-language').val();

            $official_langs = $('.gcconnex-profile-language-official-languages');

			var access = $('.gcconnex-languages-access').val();

			english = {
                'writtencomp': $official_langs.find('.gcconnex-languages-english-writtencomp').val(),
                'writtenexp': $official_langs.find('.gcconnex-languages-english-writtenexp').val(),
                'oral': $official_langs.find('.gcconnex-languages-english-oral').val(),
                'expiry_writtencomp': $official_langs.find('#english_expiry_writtencomp').val(),
                'expiry_writtenexp': $official_langs.find('#english_expiry_writtenexp').val(),
                'expiry_oral': $official_langs.find('#english_expiry_oral').val()
            };

            french = {
                'writtencomp': $official_langs.find('.gcconnex-languages-french-writtencomp').val(),
                'writtenexp': $official_langs.find('.gcconnex-languages-french-writtenexp').val(),
                'oral': $official_langs.find('.gcconnex-languages-french-oral').val(),
                'expiry_writtencomp': $official_langs.find('#french_expiry_writtencomp').val(),
                'expiry_writtenexp': $official_langs.find('#french_expiry_writtenexp').val(),
                'expiry_oral': $official_langs.find('#french_expiry_oral').val()
            };

            // save the information the user just edited
            elgg.action('b_extended_profile/edit_profile', {
                data: {
                    'guid': elgg.get_page_owner_guid(),
                    'section': 'languages',
                    'access_id': access,
                    'english': english,
                    'french': french,
                    'firstlang': firstlang
                },
                success: function() {
                    $.get(elgg.normalize_url('ajax/view/b_extended_profile/languages'),
                        {
                            guid: elgg.get_page_owner_guid()
                        },
                        function(data) {
                            // Output in a DIV with id=somewhere
                            $('.gcconnex-profile-languages-display').remove();
                            $('.gcconnex-languages').append('<div class="gcconnex-profile-languages-display">' + data + '</div>');
                        });
                }
            });
            $('.gcconnex-languages-edit-wrapper').remove();
            break;
        case 'portfolio':
            // Save the portfolio
            var portfolio = {};
            var entry = [];
            var access = $('.gcconnex-portfolio-access').val();

            portfolio.edit = entry;
            portfolio.delete_guids = [];

            $('.gcconnex-portfolio-entry').each(function() {
                if ( $(this).is(":hidden") ) {
                    portfolio.delete_guids.push($(this).data('guid'));
                }
                else {
                    entry = {
                        'eguid': $(this).data('guid'),
                        'title': $(this).find('.gcconnex-portfolio-title').val(),
                        'link': $(this).find('.gcconnex-portfolio-link').val(),
                        'pubdate': $(this).find('#pubdate').val(),
                        'datestamped': $(this).find('.gcconnex-portfolio-datestamped').val(),
                        'description': $(this).find('.gcconnex-portfolio-description').val()
                    };
                    portfolio.edit.push(entry);
                }
            });

            elgg.action('b_extended_profile/edit_profile', {
                data: {
                    'guid': elgg.get_page_owner_guid(),
                    'section': 'portfolio',
                    'portfolio': portfolio,
                    'access': access
                },
                success: function() {
                    $.get(elgg.normalize_url('ajax/view/b_extended_profile/portfolio'),
                        {
                            'guid': elgg.get_page_owner_guid()
                        },
                        function (data) {
                            // Output portfolio here
                            $('.gcconnex-profile-portfolio-display').remove();
                            $('.gcconnex-portfolio').append('<div class="gcconnex-profile-portfolio-display">' + data + '</div>');
                        });
                }
            });
            $('.gcconnex-portfolio-edit-wrapper').remove();
            break;

        /*
         * MODIFIED CODE
         * Takes all the values from the input fields and puts them into an array.
         * Then uses an AJAX call to run the ELGG action.
         * On success, it removes the edit_opt-in view and shows the opt-in view.
         */
        case 'opt-in':
            var opt_in_set = [];
            var access = $('.gcconnex-opt-in-access').val();

            // Gets all the input values from the opt-in edit view.
            $options = $('.gcconnex-profile-opt-in-options-table');
            opt_in_set[0] = $options.find('#gcconnex-opt-in-mission-check').is(':checked');
            opt_in_set[1] = $options.find('#gcconnex-opt-in-swap-check').is(':checked');
            opt_in_set[2] = $options.find('#gcconnex-opt-in-mentored-check').is(':checked');
            opt_in_set[3] = $options.find('#gcconnex-opt-in-mentoring-check').is(':checked');
            opt_in_set[4] = $options.find('#gcconnex-opt-in-shadowed-check').is(':checked');
            opt_in_set[5] = $options.find('#gcconnex-opt-in-shadowing-check').is(':checked');
            opt_in_set[6] = $options.find('#gcconnex-opt-in-jobshare-check').is(':checked');
            opt_in_set[7] = $options.find('#gcconnex-opt-in-coachseek-check').is(':checked');
            opt_in_set[8] = $options.find('#gcconnex-opt-in-coachcreate-check').is(':checked');
            opt_in_set[9] = $options.find('#gcconnex-opt-in-skillseeker-check').is(':checked');
            opt_in_set[10] = $options.find('#gcconnex-opt-in-skillcreator-check').is(':checked');
            opt_in_set[11] = $options.find('#gcconnex-opt-in-rotation-check').is(':checked');
            opt_in_set[12] = $options.find('#gcconnex-opt-in-assignseek-check').is(':checked');
            opt_in_set[13] = $options.find('#gcconnex-opt-in-assigncreate-check').is(':checked');
            opt_in_set[14] = $options.find('#gcconnex-opt-in-deploymentseek-check').is(':checked');
            opt_in_set[15] = $options.find('#gcconnex-opt-in-deploymentcreate-check').is(':checked');
            opt_in_set[16] = $options.find('#gcconnex-opt-in-missioncreator-check').is(':checked');
            /*opt_in_set[6] = $options.find('#gcconnex-opt-in-peer-coached-check').is(':checked');
            opt_in_set[7] = $options.find('#gcconnex-opt-in-peer-coaching-check').is(':checked');
            opt_in_set[8] = $options.find('#gcconnex-opt-in-skill-sharing-check').is(':checked');
            opt_in_set[9] = $options.find('#gcconnex-opt-in-job-sharing-check').is(':checked');*/

            for(i=0;i<opt_in_set.length;i++) {
                if(opt_in_set[i]) {
                    opt_in_set[i] = 'gcconnex_profile:opt:yes';
                }
                else {
                    opt_in_set[i] = 'gcconnex_profile:opt:no';
                }
            }

            // Saving the data using the edit_profile action.
            elgg.action('b_extended_profile/edit_profile', {
                data: {
                    'guid': elgg.get_logged_in_user_guid(),
                    'section': 'opt-in',
                    'opt_in_set': opt_in_set,
                    'access': access
                },
                success: function() {
                    $.get(elgg.normalize_url('ajax/view/b_extended_profile/opt-in'),
                        {
                            guid: elgg.get_logged_in_user_guid()
                        },
                        function(data) {
                            // Refreshes the opt-in display and shows it.
                            $('.gcconnex-profile-opt-in-display').remove();
                            $('.gcconnex-opt-in').append('<div class="gcconnex-profile-opt-in-display">' + data + '</div>');
                        });
                }
            });

            // Removes the edit view so the display view can be seen.
            $('.gcconnex-opt-in-edit-wrapper').remove();
            break;
        /*
         * END MODIFIED CODE
         */

        default:
            break;
    }

    // toggle the edit, save, cancel buttons
    if ($section != "profile" && $valid_form != false) {
        $('.edit-' + $section).show();
        $('.edit-' + $section).removeClass('hidden');
        $('.edit-' + $section).removeClass('wb-invisible');

        $('.save-' + $section).hide();
        $('.save-' + $section).addClass('hidden');
        $('.save-' + $section).addClass('wb-invisible');
        $('.cancel-' + $section).hide();
        $('.cancel-' + $section).addClass('hidden');
        $('.cancel-' + $section).addClass('wb-invisible');
    }
}

/*
 * Purpose: Handle click event on the cancel button for all profile changes
 */
function cancelChanges(event) {

    var $section = event.data.section;

    $('.edit-' + $section).show();
    $('.edit-' + $section).removeClass('hidden');
    $('.edit-' + $section).removeClass('wb-invisible');

    $('.save-' + $section).hide();
    $('.save-' + $section).addClass('hidden');
    $('.save-' + $section).addClass('wb-invisible');
    $('.cancel-' + $section).hide();
    $('.cancel-' + $section).addClass('hidden');
    $('.cancel-' + $section).addClass('wb-invisible');

    switch ($section) {
        case "about-me":
            // show the about me
            $('.gcconnex-about-me-edit-wrapper').remove();
            $('.gcconnex-profile-about-me-display').show();
            break;
        case "education":
            //$('.gcconnex-profile-education-display').show();
            $('.gcconnex-education-edit-wrapper').remove();
            $('#edu-error').remove();
            $('.gcconnex-profile-education-display').show();
            break;
        case "work-experience":
            $('.gcconnex-work-experience-edit-wrapper').remove();
            $('#work-error').remove();
            $('.gcconnex-profile-work-experience-display').show();
            break;
        case "skills":
            $('.gcconnex-endorsements-input-wrapper').remove();
            $('.gcconnex-skill-limit').hide();
            $('.delete-skill').remove();
            $('.delete-skill-img').remove();
            $('.gcconnex-skills-skill-wrapper').removeClass('endorsements-markedForDelete');

            $('.gcconnex-skills-skill-wrapper').show();
            $('.temporarily-added').remove();
            break;
        case 'languages':
            $('.gcconnex-languages-edit-wrapper').remove();
            $('.gcconnex-profile-languages-display').show();
            break;
        case 'portfolio':
            $('.gcconnex-portfolio-edit-wrapper').remove();
            $('.gcconnex-profile-portfolio-display').show();
            break;

        /*
         * MODIFIED CODE
         * Removes edit_opt-in view and then shows opt-in view.
         */
        case 'opt-in':
            $('.gcconnex-opt-in-edit-wrapper').remove();
            $('.gcconnex-profile-opt-in-display').show();
            break;
        /*
         * END MODIFIED CODE
         */

        default:
            break;
    }
}

/*
 * Purpose: Listen for the enter key in the "add new skill" text box
 */
function checkForEnter(event) {
    if (event.keyCode == 13) { // 13 = 'Enter' key

        // The new skill being added, as entered by user
        //var newSkill = $('.gcconnex-endorsements-input-skill').val().trim();
        var newSkill = $('.gcconnex-endorsements-input-skill').typeahead('val');
        // @todo: do data validation to ensure css class-friendly naming (ie: no symbols)
        // @todo: add a max length to newSkill

        //dont allow user to sumit nothing as skill
        if(newSkill.trim().length > 0){
            addNewSkill(newSkill);
        }
    }
}

/*
 * Purpose: Only allow numbers to be entered for the year inputs
 */
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

/*
 * Purpose: disable the end date inputs when a user selects "I'm currently still working here"
 */
function toggleEndDate(section, evt) {

    $(evt).closest('.gcconnex-' + section + '-entry').find('.gcconnex-' + section + '-end-year').attr('disabled', evt.checked);
    $(evt).closest('.gcconnex-' + section + '-entry').find('.gcconnex-' + section + '-enddate').attr('disabled', evt.checked);
}

/*
 * Purpose: add colleague to work-experience entry
 */
function addColleague(obj, datum, name) {
    //var colleague = datum.avatar;

    if ($(this).closest('.gcconnex-work-experience-entry').find("[data-guid=" + datum.guid + "]") && $(this).closest('.gcconnex-work-experience-entry').find("[data-guid=" + datum.guid + "]").is(":hidden")) {
        $(this).closest('.gcconnex-work-experience-entry').find("[data-guid=" + datum.guid + "]").show();
    }
    else {
        $(this).closest('.gcconnex-work-experience-entry').find('.list-avatars').append(
            '<div class="gcconnex-avatar-in-list temporarily-added" data-guid="' + datum.guid + '" onclick="removeColleague(this)">' +
            '<div class="remove-colleague-from-list">X</div>' + datum.avatar + '</div>'
        );
    }
    $('.userfind').typeahead('val', '');        // clear the typeahead box
    // remove colleague from suggestible usernames list
}

/*
 * Purpose: When user clicks on the "X" to remove a user from the list of colleagues, animate the removal
 */
function removeColleague(identifier) {
    $(identifier).fadeOut('slow', function() {
        if ($(identifier).hasClass('temporarily-added')) {
            $(identifier).remove();
            tid = $('.gcconnex-work-experience-colleagues').data("tid");
            guid = $(identifier).data('guid');
            $colleagueSelected[tid].splice($.inArray(guid, $colleagueSelected[tid]), 1);
        }
        else {
            $(identifier).hide();
            tid = $('.gcconnex-work-experience-colleagues').data("tid");
            guid = $(identifier).data('guid');
            $colleagueSelected[tid].splice($.inArray(guid, $colleagueSelected[tid]), 1);
        }
    });
    //add colleague back to suggestible usernames list
}

/*
 * Purpose: to trigger the submission of a skill that was selected or auto-completed from the typeahead suggestion list
 */
function skillSubmit() {
    var myVal = $('.gcconnex-endorsements-input-skill').typeahead('val');
    addNewSkill(myVal);
}

/*
 * Purpose: append a new skill to the bottom of the list
 */
function addNewSkill(newSkill) {

    //var newSkillDashed = newSkill.replace(/\s+/g, '-').toLowerCase(); // replace spaces with '-' for css classes

    newSkill = escapeHtml(newSkill);
    // inject HTML for newly added skill
    $('.gcconnex-skills-skills-list-wrapper').append('<div class="gcconnex-skill-entry temporarily-added" data-skill="' + newSkill + '">' +
    '<div title="Number of endorsements" class="gcconnex-endorsements-count" data-skill="' + newSkill + '">0</div>' +
    '<div data-skill="' + newSkill + '" class="gcconnex-endorsements-skill">' + newSkill + '</div>' +
    '<button class="delete-skill" data-type="skill" onclick="deleteEntry(this)">' + '<i class="fa fa-trash-o delete-skill-img"></i>Delete / Supprimer' + '</button></div>');
    $('.gcconnex-endorsements-input-skill').val('');                                 // clear the text box
    $('.gcconnex-endorsements-input-skill').typeahead('val', '');                                           // clear the typeahead box
    $('.gcconnex-endorsements-input-skill').hide();                                  // hide the text box
    if ( $('.gcconnex-skill-entry:visible').length < 15 ) {
        $('.gcconnex-endorsements-add-skill').show();                                    // show the 'add a new skill' link
    }
    $('.add-endorsements-' + newSkill).on('click', addEndorsement);            // bind the addEndoresement function to the '+'
    $('.retract-endorsements-' + newSkill).on('click', retractEndorsement);    // bind the retractEndorsement function to the '-'
    $('.delete-' + newSkill).on('click', deleteSkill);                        // bind the deleteSkill function to the 'Delete this skill' link
}

/*
 * Purpose: Increase the endorsement count by one, for a specific skill for a specific user
 */
function addEndorsement(identifier) {
    // A user is endorsing a skill! Do some things about it..
    var skill_guid = $(identifier).data('guid');

    elgg.action('b_extended_profile/add_endorsement', {
        guid: elgg.get_logged_in_user_guid(),
        skill: skill_guid
    });

    var targetSkill = $(identifier).data('skill');
    var targetSkillDashed = targetSkill.replace(/\s+/g, '-').toLowerCase(); // replace spaces with '-' for css classes


    var endorse_count = $('.gcconnex-skill-entry[data-guid="' + skill_guid + '"]').find('.gcconnex-endorsements-count').text();
    endorse_count++;
    $('.gcconnex-skill-entry[data-guid="' + skill_guid + '"]').find('.gcconnex-endorsements-count').text(endorse_count);

    $('.gcconnex-skill-entry[data-guid="' + skill_guid + '"]').find('.skill-container').removeClass('gcconnex-endorsement-add').addClass('gcconnex-endorsement-retract');
    $('.gcconnex-skill-entry[data-guid="' + skill_guid + '"]').find('.skill-container').attr('onclick', 'retractEndorsement(this)');
    $('.gcconnex-skill-entry[data-guid="' + skill_guid + '"]').find('.skill-container').attr('title', 'Retract');

   // $('.gcconnex-skill-entry[data-guid="' + skill_guid + '"]').append('<button class="gcconnex-endorsement-retract btn-endorse" onclick="retractEndorsement(this)" data-guid="' + skill_guid + '" data-skill="' + targetSkill + '">Retract</button>')
    //$('.gcconnex-skill-entry[data-guid="' + skill_guid + '"]').find('.gcconnex-endorsement-add').remove();
    //$('.add-endorsement-' + targetSkillDashed).remove();
}

/*
 * Purpose: Retract a previous endorsement for a specific skill for a specific user
 */
function retractEndorsement(identifier) {
    // A user is retracting their endorsement for a skill! Do stuff about it..
    var skill_guid = $(identifier).data('guid');

    elgg.action('b_extended_profile/retract_endorsement', {
        'guid': elgg.get_logged_in_user_guid(),
        'skill': skill_guid
    });


    var targetSkill = $(identifier).data('skill');
    var targetSkillDashed = targetSkill.replace(/\s+/g, '-').toLowerCase(); // replace spaces with '-' for css classes


    var endorse_count = $('.gcconnex-skill-entry[data-guid="' + skill_guid + '"]').find('.gcconnex-endorsements-count').text();
    endorse_count--;
    $('.gcconnex-skill-entry[data-guid="' + skill_guid + '"]').find('.gcconnex-endorsements-count').text(endorse_count);

    $('.gcconnex-skill-entry[data-guid="' + skill_guid + '"]').find('.skill-container').removeClass('gcconnex-endorsement-retract').addClass('gcconnex-endorsement-add');
    $('.gcconnex-skill-entry[data-guid="' + skill_guid + '"]').find('.skill-container').attr('onclick', 'addEndorsement(this)');
    $('.gcconnex-skill-entry[data-guid="' + skill_guid + '"]').find('.skill-container').attr('title', 'Endorse / Valider');

    //$('.gcconnex-skill-entry[data-guid="' + skill_guid + '"]').append('<button class="gcconnex-endorsement-add btn-endorse" onclick="addEndorsement(this)" data-guid="' + skill_guid + '" data-skill="' + targetSkill + '">Endorse</button>')

    //$(identifier).after('<span class="gcconnex-endorsement-add add-endorsement-' + targetSkillDashed + '" onclick="addEndorsement(this)" data-guid="' + skill_guid + '" data-skill="' + targetSkill + '">+</span>');
    //$('.gcconnex-skill-entry[data-guid="' + skill_guid + '"]').find('.gcconnex-endorsement-retract').remove();
}

/*
 * Purpose: Delete a skill from the list of endorsements
 */
function deleteSkill() {
    // We don't _actually_ delete anything yet, since the user still has the ability to click 'Cancel' and bring the skill back,
    // instead, we just hide the skill until the user clicks on 'Save'. See the 'saveChanges' function for
    // the actual code where skills are permanently deleted.
    $(this).parent('.gcconnex-endorsements-skill-wrapper').addClass('endorsements-markedForDelete').hide();
}

/*
 * Purpose: add more inputs for the input type
 */
function addMore(identifier) {
    another = $(identifier).data('type');
    $.when( $.get(elgg.normalize_url('ajax/view/input/' + another), '',
        function(data) {
            $('.gcconnex-' + another + '-all').append(data);
        })).done(function() {
        if (another == "work-experience") {
            $temp = $('.gcconnex-work-experience-entry.new').find('.userfind');
            $temp.each(function() {
                user_search_init(this);
            });
        }
    });
}

/*
 * Purpose: Delete an entry based on the value of the data-type attribute in the delete link
 */
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
    //console.log(entryType);

    //for tabbing users
    //add additional 's' to skill to grab right class
    if(entryType == 'skill'){
        $('.cancel-' + entryType + 's').focus();
    } else {
        $('.cancel-' + entryType).focus();
    }

}

/*
 * Purpose: Remove the message box that informs users they need to re-enter their skills into the new system
 */
function removeOldSkills() {
    elgg.action('b_extended_profile/edit_profile', {
        data: {
            'guid': elgg.get_page_owner_guid(),
            'section': 'old-skills'
        },
        success: function() {
            $('.gcconnex-old-skills').remove();
        }
    });

}

var entityMap = {
    "<": "<",
    ">": ">",
    '"': '&quot;',
    "'": '\'',
    "/": '\/'
};

function escapeHtml(string) {
    return String(string).replace(/[<>"'\/]/g, function (s) {
        return entityMap[s];
    });
}
