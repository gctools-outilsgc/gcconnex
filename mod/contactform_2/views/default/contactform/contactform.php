<?PHP
/*
    Contact Form from HTML Form Guide
    This program is free software published under the
    terms of the GNU Lesser General Public License.
    See this page for more info:
    http://www.html-form-guide.com/contact-form/creating-a-contact-form.html
*/

if (elgg_is_logged_in()) {
	$user = elgg_get_logged_in_user_entity();
	$sender_name = $user->name;
	$sender_email = $user->email;

}

require_once("./include/fgcontactform.php");
require_once("./include/simple-captcha.php");
$email=elgg_get_plugin_setting('email','contactform');
$list=elgg_get_plugin_setting('list','contactform');
$formproc = new FGContactForm();
$sim_captcha = new FGSimpleCaptcha('scaptcha');

$formproc->EnableCaptcha($sim_captcha);

//1. Add your email address here.
//You can add more than one receipients.
 $formproc->AddRecipient($email); //<<---Put your email address here

//2. For better security. Get a random tring from this link: http://tinyurl.com/randstr
// and put it here
$formproc->SetFormRandomKey('CnRrspl1FyEylUj');


if(isset($_POST['submitted']))
{
   if($formproc->ProcessForm())
   {
	system_messages(elgg_echo('contactform:thankyoumsg'));
	forward(elgg_get_site_url());
   }
}

?>
   
      <script type='text/javascript' src='scripts/gen_validatorv31.js'></script>
</head>

<body>
    <div><?php echo $formproc->GetErrorMessage(); ?></div>
<!-- Form Code Start -->

&nbsp;
<form id='contactus' action='<?php echo $formproc->GetSelfScript(); ?>' method='post' accept-charset='UTF-8'>
<fieldset >
<legend><?php echo elgg_echo('contactform:menu'); ?></legend>

<input type='hidden' name='submitted' id='submitted' value='1'/>
<input type='hidden' name='<?php echo $formproc->GetFormIDInputName(); ?>' value='<?php echo $formproc->GetFormIDInputValue(); ?>'/>
<!--<input type='text'  class='spmhidip' name='<?php //echo $formproc->GetSpamTrapInputName(); ?>' />-->

<div class='short_explanation'><?php echo elgg_echo('contactform:requiredfields'); ?></div>
<div class='form-group'>
    <label for='name' ><?php echo elgg_echo('contactform:fullname'); ?></label><br/>
    <input type='text' name='name' id='name' value='<?php if (elgg_is_logged_in()){ echo $sender_name;}else{echo $formproc->SafeDisplay('name');} ?>' maxlength="50" /><br/>
    <span id='contactus_name_errorloc' class='error'></span>
</div>
<div class='form-group'>
    <label for='email' >*&nbsp;<?php echo elgg_echo('contactform:email'); ?></label><br/>
    <input type='text' name='email' id='email' value='<?php if (elgg_is_logged_in()){ echo $sender_email;}else{echo $formproc->SafeDisplay('name');}  ?>' maxlength="50" /><br/>
    <span id='contactus_email_errorloc' class='error'></span>
</div>
    
<div class='form-group'>
    <label for='text' ><?php echo elgg_echo('SecondMessage'); ?></label><br/>
    <select class="form-control" id='text' name='text' value='<?php echo $formproc->SafeDisplay('text') ?>'>
<option>--</option>
<option>1</option>
<option >2</option>
<option>3</option>
<option>4</option>
<option>5</option>
</select>
   
    <span id='contactus_text_errorloc' class='error'></span>
</div>  
    
    
    
    <div class='form-group'>
        <label for='message'> <?php echo elgg_echo('contactform:message');?></label>
    <?php echo elgg_view('input/longtext', array('name' => 'message', 'id'=>'message', 'value' => $formproc->SafeDisplay('message') ));?>
    </div>
    
<fieldset id='antispam'>
<legend ><?php echo elgg_echo('contactform:antispammsg'); ?></legend>
<span class='short_explanation'><?php echo elgg_echo('contactform:antispamhint'); ?></span>
<div class='container'>
    <label for='scaptcha' ><?php echo $sim_captcha->GetSimpleCaptcha(); ?></label>
    <input type='text' name='scaptcha' id='scaptcha' maxlength="10" /><br/>
    <span id='contactus_scaptcha_errorloc' class='error'></span>
</div>
</fieldset>

<div class='container'>
    <input type='submit' name='Submit' value='Submit' />
</div>

</fieldset>
</form>
<!-- client-side Form Validations:
Uses the excellent form validation script from JavaScript-coder.com-->

<script type='text/javascript'>
// <![CDATA[

    var frmvalidator  = new Validator("contactus");
    frmvalidator.EnableOnPageErrorDisplay();
    frmvalidator.EnableMsgsTogether();
    frmvalidator.addValidation("name","req",<?php echo elgg_echo('contactform:validator:name'); ?>);
    frmvalidator.addValidation("email","req",<?php echo elgg_echo('contactform:validator:email'); ?>);
    frmvalidator.addValidation("email","email",<?php echo elgg_echo('contactform:validator:emailvalid'); ?>);
    frmvalidator.addValidation("message","maxlen=2048",<?php echo elgg_echo('contactform:validator:msgtoolong'); ?>);
    frmvalidator.addValidation("scaptcha","req",<?php echo elgg_echo('contactform:validator:answer'); ?>);

// ]]>
</script>
</body>
</html>
