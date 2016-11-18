<?php
/*
* onboard-profile.php
* Page that features steps for user fill out profile
*/
gatekeeper();
elgg_push_context('profile-onboard');

elgg_load_css('bsTable'); //bootstrap table css
//elgg_load_css('onboard-css'); //custom css.
elgg_load_js('bsTablejs'); //bootstraptable
$content = '<div id="wb-cont"><div id="onboard">' . elgg_view('profile-steps/intro') . '</div><style>
        #onboard .btn-primary {
            background-color: #567784;
        }
    </style></div>';
elgg_require_js('jquery.form');
$script = elgg_view('js/onboardMe');

// draw page
echo elgg_view_page(elgg_echo('profilemodule:title'), $content . $script);


?>
