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
//require_once("./include/simple-captcha.php");
$email=elgg_get_plugin_setting('email','contactform');
//$list1=elgg_get_plugin_setting('list1','contactform');
$formproc = new FGContactForm();
//$sim_captcha = new FGSimpleCaptcha('scaptcha');
//$formproc->EnableCaptcha($sim_captcha);

//1. Add your email address here.
//You can add more than one receipients.
 $formproc->AddRecipient($email); //<<---Put your email address here

//2. For better security. Get a random tring from this link: http://tinyurl.com/randstr
// and put it here
$formproc->SetFormRandomKey('CnRrspl1FyEylUj');

$formproc->AddFileUploadField('photo','jpg,jpeg,gif,png,pdf,doc,docx,rar.zip,',5120);

if(isset($_POST['submitted']))
{
   if($formproc->ProcessForm())
   {
	system_messages(elgg_echo('contactform:thankyoumsg'));
	forward("mod/contactform/index.php");
   // forward(elgg_get_site_url());
   }
}

?>
<script type='text/javascript' src='scripts/gen_validatorv31.js'></script>
</head>
<body>
    <div><?php echo $formproc->GetErrorMessage(); ?></div>
<!-- Form Code Start -->
<!-- FAQ PART-->
<?php //echo elgg_echo("contactform:body"); ?>
<!-- END FAQ PART-->

<form id='contactus' action='<?php echo $formproc->GetSelfScript(); ?>' enctype="multipart/form-data" method='post' accept-charset='UTF-8'>
<fieldset >
<!--<legend><?php //echo elgg_echo('contactform:menu'); ?></legend>-->
<input type='hidden' name='submitted' id='submitted' value='1'/>
<input type='hidden' name='<?php echo $formproc->GetFormIDInputName(); ?>' value='<?php echo $formproc->GetFormIDInputValue(); ?>'/>
<!--<input type='text'  class='spmhidip' name='<?php //echo $formproc->GetSpamTrapInputName(); ?>' />-->

<!--<div class='short_explanation'><?php //echo elgg_echo('contactform:requiredfields'); ?></div>-->
    <div class='col-md-6'>
<div class='form-group'>
    <label for='name' class="required"><span class="field-name"><?php echo elgg_echo('contactform:fullname'); ?></span><strong class="required"> (required)</strong></label><br/>
    <input type='text' name='name' id='name' class="form-control"  value='<?php if (elgg_is_logged_in()){ echo $sender_name;}else{echo $formproc->SafeDisplay('name');} ?>' /><br/>
    <span id='contactus_name_errorloc' class='error'></span>
</div>
        </div>
    <div class='col-md-6'>
<div class='form-group'>
    <label for='email' class="required"><span class="field-name"><?php echo elgg_echo('contactform:email'); ?></span><strong class="required"> (required)</strong></label><br/>
    
    <input type='text' name='email' class="form-control"  id='email' value='<?php if (elgg_is_logged_in()){ echo $sender_email;}else{echo $formproc->SafeDisplay('email');}  ?>'/><br/>
    <span id='contactus_email_errorloc' class='error'></span>
</div>
    </div>
    
    <div class='form-group'>
    <label for='subject' class="required"><span class="field-name"><?php echo elgg_echo('contactform:subject'); ?></span><strong class="required"> (required)</strong></label><br/>
    
    <input type='text' name='subject' class="form-control"  id='subject' value='<?php echo $formproc->SafeDisplay('subject');  ?>'/><br/>
    <span id='contactus_subject_errorloc' class='error'></span>
</div>
    
<div class='form-group'>
    <label for='reason' class="required"><span class="field-name"><?php echo elgg_echo('contactform:select'); ?></span><strong class="required"> (required)</strong></label><br/>   
  <?php  
	global $SESSION;
$dbname = $CONFIG->dbname;
$host = $CONFIG->dbhost;

$query="SELECT contact_list FROM {$CONFIG->dbprefix}upgrade ";
$result=mysql_query($query);

$db = new PDO("mysql:host=$host;dbname=$dbname", $CONFIG->dbuser, $CONFIG->dbpass);

$r = $db->query('SELECT * FROM contact_list');
?>
<select class="form-control"  id="reason" name="reason" value='<?php echo $formproc->SafeDisplay('reason'); ?>'>
    <option><?php echo elgg_echo('contactform:reason'); ?></option>
<?php  

foreach ($r as $row) {
    if ($SESSION['language'] == 'fr'){
       echo '<option>'.$row['francais'].'</option>';
}else{
    echo '<option>'.$row['english'].'</option>';
    }
}
echo '</select>';
?>

    
   
    <span id='contactus_text_errorloc' class='error'></span>
</div>
    
    <div class='container'>
    <label for='photo' >Upload your photo:</label><br/>
    <input type="file" name='photo' id='photo' /><br/>
    <span id='contactus_photo_errorloc' class='error'></span>
</div>
    
    <div class='form-group'>
        <label for='message' class="required"><span class="field-name"><?php echo elgg_echo('contactform:message');?></span><strong class="required"> (required)</strong></label>
    <?php echo elgg_view('input/plaintext', array('name' => 'message', 'class' => 'form-control', 'id'=>'message', 'value' => $formproc->SafeDisplay('message') ));?>
    </div>
    

<!--
    
<fieldset id='antispam'>
<legend ><?php //echo elgg_echo('contactform:antispammsg'); ?></legend>
<span class='short_explanation'><?php //echo elgg_echo('contactform:antispamhint'); ?></span>
<div class='container'>
    <label for='scaptcha' ><?php //echo $sim_captcha->GetSimpleCaptcha(); ?></label>
    <input type='text' name='scaptcha' id='scaptcha' maxlength="10" /><br/>
    <span id='contactus_scaptcha_errorloc' class='error'></span>
</div>
</fieldset>
-->

<div class='container pull-right'>
    <input type='submit' class="btn btn-default pull-right" name='Submit' value='Send' />
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
      frmvalidator.addValidation("photo","file_extn=jpg;jpeg;gif;png;bmp","Upload images only. Supported file types are: jpg,gif,png,bmp");

// ]]>
</script>
</body>
</html>
