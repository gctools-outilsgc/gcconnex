<?php 
$lang = get_input('lang');
$product_id = $vars['product_id'];
$source = $vars['source'];

// Format reasons
$reasons = array();
$reasons[''] = elgg_echo('freshdesk:paths:reason:select', array(), $lang);
$reasons["I need assistance with my account / login | J'ai besoin d'aide concernant mon compte ou l'ouverture d'une session"] = elgg_echo('freshdesk:paths:reason:account', array(), $lang);
$reasons["I need assistance using GCconnex | J'ai besoin d'aide avec GCconnex"] = elgg_echo('freshdesk:paths:reason:gcconnex', array(), $lang);
$reasons["I need assistance using GCpedia | J'ai besoin d'aide avec GCPedia"] = elgg_echo('freshdesk:paths:reason:gcpedia', array(), $lang);
$reasons["I would like to request statistics on my page | Je souhaite obtenir les statistiques de ma page"] = elgg_echo('freshdesk:paths:reason:stats', array(), $lang);
$reasons["Other (please specify) | Autre (veuillez préciser)"] = elgg_echo('freshdesk:paths:reason:other', array(), $lang);

// Format account issues
$accountIssues = array();
$accountIssues[''] = '--';
$accountIssues["I need help setting up a new account | J'ai besoin d'aide pour me créer un nouveau compte"] = elgg_echo('freshdesk:paths:account:new', array(), $lang);
$accountIssues["I need to update the email on my account | Je dois mettre à jour l'adresse de courriel de mon compte"] = elgg_echo('freshdesk:paths:account:email', array(), $lang);
$accountIssues["I need to reset my password | Je dois réinitialiser mon mot de passe"] = elgg_echo('freshdesk:paths:account:password', array(), $lang);
$accountIssues["Other (please specify) | Autre (veuillez préciser)"] = elgg_echo('freshdesk:paths:reason:other', array(), $lang);

// Format assistance options
$assistance = array();
$assistance[''] = '--';
$assistance['Groups | Groupes'] = elgg_echo('freshdesk:paths:assistance:groups', array(), $lang);
$assistance['Career Marketplace | Carrefour de carrière'] = elgg_echo('freshdesk:paths:assistance:career', array(), $lang);
$assistance['Files | Fichiers'] = elgg_echo('freshdesk:paths:assistance:files', array(), $lang);
$assistance['Profile | Profil'] = elgg_echo('freshdesk:paths:assistance:profile', array(), $lang);
$assistance['Other (please specify) | Autre (veuillez préciser)'] = elgg_echo('freshdesk:paths:reason:other', array(), $lang);

// If product is GCpedia
if($product_id == 2100000298){
    unset($reasons["I need assistance using GCconnex | J'ai besoin d'aide avec GCconnex"]);
} else {
    unset($reasons["I need assistance using GCpedia | J'ai besoin d'aide avec GCPedia"]);
}

echo '<label for="reason">'.elgg_echo('freshdesk:paths:reason:label', array(), $lang).'</label>';
echo elgg_view('input/select', array(
    'name' => 'reason',
    'id' => 'reason',
    'required' => 'required',
    'options_values' => $reasons,
  ));

echo "<div id='account-fields' class='hidden'>";
    echo '<label for="accountIssue">'.elgg_echo('freshdesk:paths:account:label', array(), $lang).'</label>';
    echo elgg_view('input/select', array(
        'name' => 'accountIssue',
        'id' => 'accountIssue',
        'required' => 'required',
        'options_values' => $accountIssues,
    ));
echo '</div>';

//only show on gcconnex
if($product_id != 2100000298){

    echo "<div id='assistance-fields' class='hidden'>";
        // Section assistance
        echo '<label for="assistance">'.elgg_echo('freshdesk:paths:assistance:label', array(), $lang).'</label>';
        echo elgg_view('input/select', array(
            'name' => 'assistance',
            'id' => 'assistance',
            'options_values' => $assistance,
        ));
    echo '</div>';
}

echo "</fieldset>";

echo '<fieldset id="ticketInfo" class="user-info hidden">';
echo '<legend>'.elgg_echo('freshdesk:ticket:legend:ticketinfo', array(), $lang).'</legend>';
echo "<div id='url-field' class='hidden'>";
    // Page URL
    echo '<label for="pageurl">'.elgg_echo('freshdesk:paths:pageurl:label', array(), $lang).'</label>';
    echo elgg_view('input/text', array(
        'name' => 'pageurl',
        'id' => 'pageurl',
        'class' => 'mrgn-bttm-sm',
    ));
echo '</div>';

echo "<div id='prevemail-field' class='hidden'>";
    // Previous Email
    echo '<label for="previousemail">'.elgg_echo('freshdesk:paths:previousemail:label', array(), $lang).'</label>';
    echo elgg_view('input/text', array(
        'name' => 'previousemail',
        'id' => 'previousemail',
        'class' => 'mrgn-bttm-sm',
    ));
echo '</div>';

echo "<div id='pwdreset-cbox' class='hidden mrgn-bttm-md'>";
    // Password reset cbox
    echo elgg_view('input/checkbox', array(
        'name'=>'pwd_reset',
        'id'=>'pwd_reset',
        'label'=> elgg_echo('freshdesk:paths:pwdreset:label', array(), $lang),
        'value'=>'pwd_reset'
    ));
echo '</div>';

echo "<div id='optedin-cbox' class='hidden mrgn-bttm-md'>";
    // Opted in cbox
    echo elgg_view('input/checkbox', array(
        'name'=>'opted_in',
        'id'=>'opted_in',
        'label'=> elgg_echo('freshdesk:paths:opted:label', array(), $lang),
        'value'=>'opted_in'
    ));
echo '</div>';

echo "<div id='data-fields' class='hidden'>";

    echo '<div class="mrgn-bttm-md">';
        // Date: from
        echo '<div class="date-section"><label for="date_from">'.elgg_echo('freshdesk:paths:data_date_from:label', array(), $lang).'</label>';
        echo '<div id="date-helper-1" class="text-muted date-helper">'.elgg_echo('freshdesk:paths:data_date_format:label', array(), $lang).'</div>';
        echo elgg_view("event_calendar/input/date_local", array(
            "name" => "date_from",
            "id" => "date_from",
            'autocomplete' => 'off',
            'class' => 'event-calendar-compressed-date clearfix mrgn-bttm-sm',
            'aria-labelledby' => "date-helper-2"
        ));
        echo '</div>';

        // Date: to
        echo '<div class="date-section"><label for="date_to">'.elgg_echo('freshdesk:paths:data_date_to:label', array(), $lang).'</label>';
        echo '<div id="date-helper-2" class="text-muted date-helper">Format: yyyy-mm-dd</div>';
        echo elgg_view("event_calendar/input/date_local", array(
            "name" => "date_to",
            "id" => "date_to",
            'autocomplete' => 'off',
            'class' => 'event-calendar-compressed-date clearfix mrgn-bttm-sm',
            'aria-labelledby' => "date-helper-2"
        ));
        echo '</div>';
    echo '</div>';

    // Send Report to
    echo '<div><label for="report_to">'.elgg_echo('freshdesk:paths:data_report_to:label', array(), $lang).'</label>';
    echo elgg_view('input/text', array(
        'name' => 'report_to',
        'id' => 'report_to',
        'class' => 'mrgn-bttm-sm',
    ));
    echo '</div>';

    // Ongoing cbox
    echo '<div class="mrgn-bttm-md">';
    echo elgg_view('input/checkbox', array(
        'name'=>'ongoing',
        'id'=>'ongoing',
        'label'=> elgg_echo('freshdesk:paths:data_ongoing:label', array(), $lang),
        'value'=>'ongoing'
    ));
    echo '</div>';

echo "</div>";

// Other alert
echo '<div id="otherAlert" class="onboarding-cta-holder hidden mrgn-bttm-md" style="padding: 12px;"><strong>'.elgg_echo('freshdesk:paths:other:alert', array(), $lang).'</strong></div>';
// GCpedia alert
echo '<div id="gcpediaAlert" class="onboarding-cta-holder hidden mrgn-bttm-md" style="padding: 12px;"><strong>'.elgg_echo('freshdesk:paths:gcpedia:alert', array(), $lang).'</strong></div>';

?>

<script>
$(document).ready(function(){
    // Show fields when options change
    $('#reason').on('change', function(){
        switch(this.value){
            case "I need assistance with my account / login | J'ai besoin d'aide concernant mon compte ou l'ouverture d'une session":
                wipeTheBoard('all');
                $('#account-fields').removeClass('hidden').find('select').attr('required', true);
            break;
            case "I need assistance using GCconnex | J'ai besoin d'aide avec GCconnex":
                wipeTheBoard('all');
                $('#assistance-fields').removeClass('hidden');
            break;
            case "I need assistance using GCpedia | J'ai besoin d'aide avec GCPedia":
                wipeTheBoard('all');
                $('#url-field').removeClass('hidden');
                $('#desc-file-fields').removeClass('hidden');
                $('#gcpediaAlert').removeClass('hidden');
                $('#ticketInfo').removeClass('hidden');
            break;
            case "I would like to request statistics on my page | Je souhaite obtenir les statistiques de ma page":
                wipeTheBoard('all');
                $('#url-field').removeClass('hidden');
                $('#data-fields').removeClass('hidden');
                $('#ticketInfo').removeClass('hidden');
                $('#desc-file-fields').removeClass('hidden');
            break;
            case "Other (please specify) | Autre (veuillez préciser)":
                wipeTheBoard('all');
                $('#desc-file-fields').removeClass('hidden');
                $('#otherAlert').removeClass('hidden');
                $('#ticketInfo').removeClass('hidden');
            break;
            case '':
            default:
                wipeTheBoard('all');
            break;
        }
    });

    $('#accountIssue').on('change', function(){
        switch(this.value){
            case "I need to update the email on my account | Je dois mettre à jour l'adresse de courriel de mon compte":
                wipeTheBoard('account');
                $('#prevemail-field').removeClass('hidden');
                $('#desc-file-fields').removeClass('hidden');
                $('#ticketInfo').removeClass('hidden');
            break;
            case "I need to reset my password | Je dois réinitialiser mon mot de passe":
                wipeTheBoard('account');
                $('#pwdreset-cbox').removeClass('hidden');
                $('#desc-file-fields').removeClass('hidden');
                $('#ticketInfo').removeClass('hidden');
            break;
            case "Other (please specify) | Autre (veuillez préciser)":
                wipeTheBoard('account');
                $('#otherAlert').removeClass('hidden');
                $('#desc-file-fields').removeClass('hidden');
                $('#ticketInfo').removeClass('hidden');
            break;
            case "I need help setting up a new account | J'ai besoin d'aide pour me créer un nouveau compte":
                wipeTheBoard('account');
                $('#desc-file-fields').removeClass('hidden');
                $('#ticketInfo').removeClass('hidden');
            break;
            case '':
                wipeTheBoard('account');
            break;
            default:
            break;
        }
    });

    $('#assistance').on('change', function(){
        switch(this.value){
            case 'Career Marketplace | Carrefour de carrière':
                wipeTheBoard('assistance');
                $('#optedin-cbox').removeClass('hidden');
                $('#url-field').removeClass('hidden');
                $('#desc-file-fields').removeClass('hidden');
                $('#ticketInfo').removeClass('hidden');
            break;
            case "Other (please specify) | Autre (veuillez préciser)":
                wipeTheBoard('assistance');
                $('#otherAlert').removeClass('hidden');
                $('#url-field').removeClass('hidden');
                $('#desc-file-fields').removeClass('hidden');
                $('#ticketInfo').removeClass('hidden');
            break;
            case 'Groups | Groupes':
            case 'Files | Fichiers':
            case 'Profile | Profil':
                wipeTheBoard('assistance');
                $('#url-field').removeClass('hidden');
                $('#desc-file-fields').removeClass('hidden');
                $('#ticketInfo').removeClass('hidden');
            break;
            case '':
                wipeTheBoard('assistance');
            break;
            default:
            break;
        }
    });
});

// hide and unset values when options change
function wipeTheBoard(section) {
    switch(section){
        case 'account':
            $('#pwdreset-cbox').addClass('hidden').find('input').prop('checked', false);
            $('#prevemail-field').addClass('hidden').find('input').val('');
            $('#otherAlert').addClass('hidden');
            $('#desc-file-fields').addClass('hidden');
            $('#ticketInfo').addClass('hidden');
        break;
        case 'assistance':
            $('#url-field').addClass('hidden').find('input').val('');
            $('#optedin-cbox').addClass('hidden').find('input').prop('checked', false);
            $('#otherAlert').addClass('hidden');
            $('#desc-file-fields').addClass('hidden');
            $('#ticketInfo').addClass('hidden');
        break;
        case 'all':
            $('#account-fields').addClass('hidden').find('select').val('');
            $('#assistance-fields').addClass('hidden').find('select').val('');

            $('#data-fields').addClass('hidden');
            $('#data-fields input[type=text]').val('');
            $('#data-fields input[type=checkbox]').prop('checked', false);
            $('#desc-file-fields').addClass('hidden');

            $('#url-field').addClass('hidden').find('input').val('');
            $('#prevemail-field').addClass('hidden').find('input').val('');
            
            $('#gcpediaAlert').addClass('hidden');
            $('#otherAlert').addClass('hidden');

            $('#ticketInfo').addClass('hidden');

            $('#optedin-cbox').addClass('hidden').find('input').prop('checked', false);
            $('#pwdreset-cbox').addClass('hidden').find('input').prop('checked', false);
        break;
        default:
        break;
    }

    // clean up error labels
    $('label.error').remove();
    $('div.error').remove();
    $('input.error').removeClass('error');
    $('textarea.error').removeClass('error');
}
</script>