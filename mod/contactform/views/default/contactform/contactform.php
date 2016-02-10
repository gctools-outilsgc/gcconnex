<?PHP
/*
    Contact Form from HTML Form Guide
    This program is free software published under the
    terms of the GNU Lesser General Public License.
    See this page for more info:
    http://www.html-form-guide.com/contact-form/creating-a-contact-form.html
*/

require_once("./include/fgcontactform.php");
require_once("./include/simple-captcha.php");
$email=elgg_get_plugin_setting('email','contactform');
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
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">


<head>
      <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
      <title>Contact us</title>
      <link rel="STYLESHEET" type="text/css" href="contactform.css" />
      <script type='text/javascript' src='scripts/gen_validatorv31.js'></script>
</head>
<body>
<!-- Form Code Start -->

&nbsp;
<form id='contactus' action='<?php echo $formproc->GetSelfScript(); ?>' method='post' accept-charset='UTF-8'>
<fieldset >
<legend><?php echo elgg_echo('contactform:menu'); ?></legend>

<input type='hidden' name='submitted' id='submitted' value='1'/>
<input type='hidden' name='<?php echo $formproc->GetFormIDInputName(); ?>' value='<?php echo $formproc->GetFormIDInputValue(); ?>'/>
<input type='text'  class='spmhidip' name='<?php echo $formproc->GetSpamTrapInputName(); ?>' />

<div class='short_explanation'><?php echo elgg_echo('contactform:requiredfields'); ?></div>

<div><span class='error'><?php echo $formproc->GetErrorMessage(); ?></span></div>
<div class='container'>
    <label for='name' ><?php echo elgg_echo('contactform:fullname'); ?></label><br/>
    <input type='text' name='name' id='name' value='<?php echo $formproc->SafeDisplay('name') ?>' maxlength="50" /><br/>
    <span id='contactus_name_errorloc' class='error'></span>
</div>
<div class='container'>
    <label for='email' >*&nbsp;<?php echo elgg_echo('contactform:email'); ?></label><br/>
    <input type='text' name='email' id='email' value='<?php echo $formproc->SafeDisplay('email') ?>' maxlength="50" /><br/>
    <span id='contactus_email_errorloc' class='error'></span>
</div>
<div class='container'>
    <label for='phone' ><?php echo elgg_echo('contactform:phone'); ?></label><br/>
    <input type='text' name='phone' id='phone' value='<?php echo $formproc->SafeDisplay('phone') ?>' maxlength="15" /><br/>
    <span id='contactus_phone_errorloc' class='error'></span>
</div>
<div class='container'>
    <label for='message' ><?php echo elgg_echo('contactform:message'); ?></label><br/>
    <span id='contactus_message_errorloc' class='error'></span>
    <textarea rows="10" cols="50" name='message' id='message'><?php echo $formproc->SafeDisplay('message') ?></textarea>
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
