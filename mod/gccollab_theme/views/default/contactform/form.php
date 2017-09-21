<?php

/*
 * Contact forum that's been overwritten from .../mod/contactform/...
 * Modified by Christine - The current module does not use Elgg's function to send email out
 */

$current_user = elgg_get_logged_in_user_entity();

$user_fullname = $current_user->name;
$user_email = $current_user->email;
$user_department = $current_user->department;

$email = elgg_get_plugin_setting('email','contactform');

?>


<section class="panel panel-default">
    <!-- title/header of the form -->
    <header class="panel-heading">
        <h3 class="panel-title"><?php echo elgg_echo('contactform:title:form'); ?></h3>
    </header>
    

<?php 
    $disable_feedback = elgg_get_plugin_setting('disable_feedback','contactform');
    $english_notice = elgg_get_plugin_setting('disable_feedback_message_en','contactform');
    $french_notice = elgg_get_plugin_setting('disable_feedback_message_fr','contactform');
    if (strcmp($disable_feedback,'yes') == 0) {

        if (strcmp($_COOKIE['connex_lang'], 'fr') == 0 )
            echo "<div align='center' style='padding:5px 5px 5px 5px;'> {$french_notice} </div>";
        else
            echo "<div align='center' style='padding:5px 5px 5px 5px;'> {$english_notice} </div>";
    
    } else {
?>
    <div class="panel-body mrgn-lft-md">
        <?php echo elgg_echo('contactform:content:form'); ?>
        
        <?php 
            $site = elgg_get_site_entity();
            // security, all forms need tokens when action is called
            $__elgg_ts = time();
            $__elgg_token = generate_action_token($__elgg_ts);
        ?>
        <form action="<?php echo "{$site->url}action/contactform/send_feedback"; ?>">        
            <input type="hidden" name="__elgg_ts" value="<?php echo $__elgg_ts; ?>" />
            <input type="hidden" name="__elgg_token" value="<?php echo $__elgg_token; ?>" />
            
            <!-- the following are the inputs for information -->
            <!-- full name -->
            <div class='form-group'>
                <label for='name' class="required"><span class="field-name"><?php echo elgg_echo('contactform:fullname'); ?></span></label>
            <?php
                echo elgg_view('input/text', array(
                    'name' => 'name',
                    'id' => 'name',
                    'value' => $user_fullname,
                    'required' => true 
                ));
            ?>
             </div>

            <!-- email address -->
            <div class='form-group'>
                <label for='email' class="required"><span class="field-name"><?php echo elgg_echo('contactform:email'); ?></span></label>
            <?php
                echo elgg_view('input/text', array(
                    'name' => 'email',
                    'id' => 'email',
                    'value' => $user_email,
                    'required' => true
                ));
            ?>
            </div>

            <!-- category -->
            <div class='form-group'>
                <label for='reason' class="required"><span class="field-name"><?php echo elgg_echo('contactform:select'); ?></span></label>
            <?php

                // get the selected language
                if (strcmp($SESSION['language'], 'fr') == 0 )
                    $language_selected = 'francais';
                else
                    $language_selected = 'english';

                // run a query to get all the categories for the feedback type
                $query = "SELECT id, {$language_selected} FROM contact_list";
                $feedback_types = get_data($query);

                // create the options
                $options['na'] = elgg_echo('contactform:reason');
                foreach ($feedback_types as $feedback_type)
                    $options[$feedback_type->$language_selected] = $feedback_type->$language_selected;
   
                echo elgg_view('input/select', array(
                    'name' => 'reason',
                    'id' => 'reason',
                    'options' => $options,
                    'required' => true
                ));
            ?>
            </div>

            <!-- message -->
            <div class='form-group'>
                <label for='message' class="required"><span class="field-name"><?php echo elgg_echo('contactform:message');?></span></label>
           <?php
                echo elgg_view('input/longtext', array(
                    'name' => 'message',
                    'id' => 'message',
                    'required' => true
                ));
            ?>
            </div>

            <div class='container pull-right'>
                <input type='submit' class="btn btn-primary pull-right" name='Submit' value='<?php echo elgg_echo('send');?>' />
            </div>
        </form>
    </div>
    <?php } ?>
</section>
