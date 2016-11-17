/*
Nick Pietrantonio 2016-08-10
Bootstrap Tour for touring groups.
Uses the bootstrap tour API  - http://bootstraptour.com/api/

All bootstrap tour funtions must be done through requirejs or there are conflicts 

elgg.echo js is not working so language variables are created in this document

*/
var tourPath = elgg.normalize_url() + '/mod/gc_onboard/js/bootstrap-tour.min';

//Need to put bootstrap tour through the require config
require.config({
    paths: {
        "bootstrap_tour": tourPath
    }
});
//Nick - Get current lang so we can translate (elgg.echo does not seem to work)
var current_lang = elgg.get_language();
//Get site root to go back to newsfeed with a query to show the last step
var site_root = elgg.normalize_url('/newsfeed?last_step=true');

requirejs(["bootstrap_tour"], function () {
    //Nick - Set some lang strings
    if (current_lang == 'en') {
        //English
        var lang_start_tour = 'Start the tour';
        var lang_confirm = 'Got It!';
        var group_titles = {};
        group_titles['0'] = "Welcome to GCconnex Groups";
        group_titles['1'] = "Navigating the group";
        group_titles['2'] = "Group discussion";
        group_titles['3'] = "Settings and notifications";
        group_titles['4'] = "Before you go!";
        var group_contents = {};
        group_contents['0'] = "Groups 101: <br><ul><li> Groups can be <span style='color:green;'> Open </span> or <span style='color:orange;'> Closed </span></li><li> If a group is <span style='color:green;'> Open </span> feel free to join! </li><li> If a group is <span style='color:orange;'> Closed </span> you'll have to request membership and the group owner will have to approve it </li></ul>";

        group_contents['1'] = "Use the tabs in this menu to navigate the group's content. <br><div> Click on the <span style='font-weight:bold;'> Discussion </span> tab to continue. </div>";

        group_contents['2'] = "Interact with other group members through discussions. Ask questions or share information and see what others have to say! Don't be afraid to reply to, and comment on existing discussions, you'll be adding value!";

        group_contents['3'] = "Here, you can join or request membership to a group. Want out? Just leave the group... no hard feelings. <br> Want to let others know about this awesome group? Share the group on The Wire, GCconnex's own microblog! After joining a group, you will automatically start receiving notifications about new group activities. You can change your subscription preferences in your account settings or by activating/deactivating the &ldquo; bell &rdquo; icon.";

        group_contents['4'] = "Take full advantage of GCconnex by joining groups of interest. Groups allow communities, teams, committees, organizations (big or small) to share valuable information and knowledge. Start collaborating! <br><div class='mrgn-tp-sm'> Thanks for taking the tour! </div>";
        var group_last_step = "Continue";
    } else {
        //French
        var lang_start_tour = 'Commencer la visite guidée';
        var lang_confirm = "C'est bon!";
        var group_titles = {};
        group_titles['0'] = "Bienvenue aux groupes GCconnex";
        group_titles['1'] = "Explorer le groupe";
        group_titles['2'] = "Discussion de groupe";
        group_titles['3'] = "Paramètres et notifications";
        group_titles['4'] = "Avant de quitter!";
        var group_contents = {};
        group_contents['0'] = "Groupes 101 : <br><ul><li> Les groupes peuvent être <span style='color:green;'> Ouverts </span> or <span style='color:orange;'> Fermés </span></li><li> Si un groupe est <span style='color:green;'> Ouvert </span> n'hésitez pas à le joindre! </li><li> Si un groupe est <span style='color:orange;'> Fermé </span> vous devrez faire une demande pour devenir membre qui devra être approuvée par le propriétaire du groupe </li></ul>";

        group_contents['1'] = "Utilisez les onglets de ce menu pour explorer le contenu du groupe. <br><div> Cliquez sur l'onglet <span style='font-weight:bold;'> Discussion </span> pour continuer. </div>";

        group_contents['2'] = "Interagissez avec d'autres membres du groupe en discutant avec eux. Posez des questions ou échanger de l'information et voyez ce que les autres ont à dire. N'ayez pas peur de répondre à des discussions existantes ou de les commenter : votre opinion leur ajoute de la valeur!";

        group_contents['3'] = "Cet endroit vous permet de joindre un groupe ou de faire une demande pour devenir membre d'un groupe. Vous voulez quitter? Vous n'avez qu'à quitter le groupe... nous ne le prendrons pas mal. <br> Vous voulez faire connaître un groupe incroyable à d'autres personnes? Partagez-le sur le fil, le microblogue de GCconnex! Après vous être joins à un groupe, vous recevrez automatiquement des notifications au sujet des nouvelles activités du groupe. Vous pouvez changer vos préférence d’abonnement dans vos  paramètres de compte, ou en activant/désactivant l'icône de &ldquo;cloche&rdquo;.";

        group_contents['4'] = "Profitez pleinement de GCconnex en vous joignant aux groupes qui vous intéressent. Les groupes permettent à des collectivités, à des équipes, à des comités et à des organisations (petites et grandes) d'échanger des informations et des connaissances précieuses. Commencez à collaborer! <br><div class='mrgn-tp-sm'> Merci d'avoir suivi cette visite guidée! </div>";

        var group_last_step = "Continuer";
    }
    

    //Nick - this will parse the url to see if "first_tour" Query is true
    function getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }
    //get the value of 'first_tour' (ex: sitename/groups/profile/111?first_tour=true)
    var group_tour = getParameterByName('first_tour');

    //check if tour was launched from help / contact us
    var help_launch = getParameterByName('help_launch');
    if (help_launch == "true") {
        //return to help page
        site_root = elgg.normalize_url('/mod/contactform');
    }

    if (group_tour == 'true') {
        var tour = new Tour({
            steps: [
                {
                    orphan: true,
                    title: group_titles['0'],
                    content: group_contents['0'],
                    placement: "top",
                    backdrop: true,
                    backdropContainer: 'body',
                    template: "<div class='popover tour final-tour-step onboard-popover'><div class='arrow'></div><h3 class='popover-title'></h3><div class='popover-content'></div><div class='popover-navigation'><button class='btn btn-primary pull-right' data-role='next'>" + lang_start_tour + "</button></div></div>",
                },
            {//Step 1 Show Tab Content
                element: ".wet-group-tabs",
                title: group_titles['1'],
                content: group_contents['1'],
                placement: "top",
                backdrop: true,
                //reflex:true,
                backdropContainer: 'body',
                backdropPadding: 10,
                template: "<div class='popover tour onboard-popover'><div class='arrow'></div><h3 class='popover-title'></h3><div class='popover-content'></div><div class='popover-navigation'></div></div>",
            },
            {//Step 2 Show Discussion Pane
                element: "#groups-tools",
                title: group_titles['2'],
                content: group_contents['2'],
                placement: "top",
                template: "<div class='popover tour onboard-popover'><div class='arrow'></div><h3 class='popover-title'></h3><div class='popover-content'></div><div class='popover-navigation'><button class='btn btn-primary pull-right' data-role='next'>" + lang_confirm + "</button></div></div>",
            },
            {//Step 3 Show Settings, Notification Bell
                element: ".group-summary-holder .btn-group",
                title: group_titles['3'],
                backdrop: true,
                backdropContainer: 'body',
                backdropPadding: 10,
                content: group_contents['3'],
                placement: "left",
                template: "<div class='popover tour onboard-popover'><div class='arrow'></div><h3 class='popover-title'></h3><div class='popover-content'></div><div class='popover-navigation'><button class='btn btn-primary pull-right' data-role='next'>" + lang_confirm + "</button></div></div>",
                onShown: function () {
                    //for positioning the background in the proper place, we have to do some math
                    var width = $(".group-summary-holder").width();
                    //container header - background width + 10 for good measure
                    width = width - $(".tour-step-background").width() + 10;
                    //move tour elements to have same parent
                    $(".tour-step-background").prependTo(".group-summary-holder");
                    $(".tour-step-background").css({'left':width+'px',"top": "0px", 'background': 'rgb(248, 248, 248)'});
                    $(".tour-backdrop").prependTo(".group-summary-holder");
                    //move things under backdrop
                    $('footer').css('z-index', '0');
                    $('.user-z-index').css('z-index', '0');
                }
            },
               {//Step 4 Show final modal popup and complete tour
                   orphan:true,
                   title: group_titles['4'],
                   content: group_contents['4'],
                   placement: "top",
                   backdrop: true,
                   backdropContainer: 'body',
                   template: "<div class='popover tour final-tour-step onboard-popover'><div class='arrow'></div><h3 class='popover-title'></h3><div class='popover-content'></div><div class='popover-navigation'><button class='btn btn-primary pull-right' data-role='next'>" + group_last_step + "</button></div></div>",
               },
               {//Step 5 redirect, this will redirect and end tour
                   path: site_root,
                   orphan:true,
                   redirect:true,
                   onShown: function (tour) {
                       //alert('This is when i happen');
                       //I can show the final step here
                       tour.end();
                   }

               },
               
            ],
            storage:false,
        });

        // Initialize the tour
        tour.init();

        // Start the tour
        tour.start(true);
        
        //when tab menu is highlighted, only advance when Discussion tab is pressed
        $('.elgg-menu-item-discussion').on('click', function(){
            var currentStep = tour.getCurrentStep();
            if(currentStep == 1){
                tour.next();
            }
        });

    }

    
});


