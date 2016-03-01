<?PHP
/*
    Contact Form from HTML Form Guide

    This program is free software published under the
    terms of the GNU Lesser General Public License.

This program is distributed in the hope that it will
be useful - WITHOUT ANY WARRANTY; without even the
implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE.

@copyright html-form-guide.com 2010
*/
require_once("class.phpmailer.php");

/*
Interface to Captcha handler
*/
class FG_CaptchaHandler
{
    function Validate() { return false;}
    function GetError(){ return '';}
}
/*
FGContactForm is a general purpose contact form class
It supports Captcha, HTML Emails, sending emails
conditionally, File atachments and more.
*/
class FGContactForm
{
    var $receipients;
    var $errors;
    var $error_message;
    var $name;
    var $email;
    var $message;
    var $from_address;
    var $form_random_key;
    var $conditional_field;
    var $arr_conditional_receipients;
    var $fileupload_fields;
    var $captcha_handler;

    var $mailer;

    function FGContactForm()
    {
        $this->receipients = array();
        $this->errors = array();
        $this->form_random_key = 'HTgsjhartag';
        $this->conditional_field='';
        $this->arr_conditional_receipients=array();
        $this->fileupload_fields=array();

        $this->mailer = new PHPMailer();
        $this->mailer->CharSet = 'utf-8';
    }

    function EnableCaptcha($captcha_handler)
    {
        $this->captcha_handler = $captcha_handler;
        session_start();
    }

    function AddRecipient($email,$name="")
    {
        $this->mailer->AddAddress($email,$name);
    }

    function SetFromAddress($from)
    {
        $this->from_address = $from;
    }
    function SetFormRandomKey($key)
    {
        $this->form_random_key = $key;
    }
    function GetSpamTrapInputName()
    {
        return 'sp'.md5('KHGdnbvsgst'.$this->GetKey());
    }
    function SafeDisplay($value_name)
    {
        if(empty($_POST[$value_name]))
        {
            return'';
        }
        return htmlentities($_POST[$value_name]);
    }
    function GetFormIDInputName()
    {
        $rand = md5('TygshRt'.$this->GetKey());

        $rand = substr($rand,0,20);
        return 'id'.$rand;
    }


    function GetFormIDInputValue()
    {
        return md5('jhgahTsajhg'.$this->GetKey());
    }

    function SetConditionalField($field)
    {
        $this->conditional_field = $field;
    }
    function AddConditionalReceipent($value,$email)
    {
        $this->arr_conditional_receipients[$value] =  $email;
    }

    function AddFileUploadField($file_field_name,$accepted_types,$max_size)
    {

        $this->fileupload_fields[] =
            array("name"=>$file_field_name,
            "file_types"=>$accepted_types,
            "maxsize"=>$max_size);
    }

    function ProcessForm()
    {
        if(!isset($_POST['submitted']))
        {
           return false;
        }
        if(!$this->Validate())
        {
           // $this->error_message = implode('<br/><br/><br/>',$this->errors);
            return false;
        }
        $this->CollectData();

        $ret = $this->SendFormSubmission();

        return $ret;
    }

    function RedirectToURL($url)
    {
        header("Location: $url");
        exit;
    }

    function GetErrorMessage()
    {
        return $this->error_message;
    }
    function GetSelfScript()
    {
        return htmlentities($_SERVER['PHP_SELF']);
    }

    function GetName()
    {
        return $this->name;
    }
    function GetEmail()
    {
        return $this->email;
    }
    function GetMessage()
    {
        return htmlentities($this->message,ENT_QUOTES,"UTF-8");
    }

/*--------  Private (Internal) Functions -------- */


    function SendFormSubmission()
    {
        $reason = $_POST['reason'];
                $option = explode("$", $_POST['reason']);
                    $french = $option[0];
                    $english = $option[1]; 
        if(empty($_POST['subject']))
           {
           $subject = "$this->name contact you about ". $english." / $this->name vous a contacter à propos de ".$french;
           }else{
           $subject = $_POST['subject'];
           }
        
        
        $this->CollectConditionalReceipients();

        $this->mailer->CharSet = 'utf-8';
        
        $this->mailer->Subject = $subject;

        $this->mailer->From = $this->GetFromAddress();

        $this->mailer->FromName = $this->name;
        
        //$this->mailer->AddReplyTo($this->email);

        $this->mailer->AddCC($this->email);

        $message = $this->ComposeFormtoEmail();
        
        $this->mailer->ConfirmReadingTo = $this->email;
        
        $textMsg = trim(strip_tags(preg_replace('/<(head|title|style|script)[^>]*>.*?<\/\\1>/s','',$message)));
        $this->mailer->AltBody = @html_entity_decode($textMsg,ENT_QUOTES,"UTF-8");
        $this->mailer->MsgHTML($message);

        $this->AttachFiles();

        if(!$this->mailer->Send())
        {
            $this->add_error("Failed sending email!");
            return false;
        }

        return true;
    }

    function CollectConditionalReceipients()
    {
        if(count($this->arr_conditional_receipients)>0 &&
          !empty($this->conditional_field) &&
          !empty($_POST[$this->conditional_field]))
        {
            foreach($this->arr_conditional_receipients as $condn => $rec)
            {
                if(strcasecmp($condn,$_POST[$this->conditional_field])==0 &&
                !empty($rec))
                {
                    $this->AddRecipient($rec);
                }
            }
        }
    }

    /*
    Internal variables, that you donot want to appear in the email
    Add those variables in this array.
    */
    function IsInternalVariable($varname)
    {
        $arr_interanl_vars = array('scaptcha',
                            'submitted',
                            $this->GetSpamTrapInputName(),
                            $this->GetFormIDInputName()
                            );
        if(in_array($varname,$arr_interanl_vars))
        {
            return true;
        }
        return false;
    }

    function FormSubmissionToMail()
    {
        $ret_str='';
     /*   foreach($_POST as $key=>$value)
        {
            if(!$this->IsInternalVariable($key))
            {
                $value = htmlentities($value,ENT_QUOTES,"UTF-8");
                $value = nl2br($value);
                $key = ucfirst($key);
                $ret_str .= "<div class='label'>$key :</div><div class='value'>$value </div>\n";
            }
        }*/
        
                $name = $_POST['name'];
                $email = $_POST['email'];
                $reason = $_POST['reason'];
                $option = explode("$", $_POST['reason']);
                    $french = $option[0];
                    $english = $option[1]; 
                if(empty($_POST['subject']))
                {
                    $subject = "$this->name contact you about ". $english." / $this->name vous a contacter à propos de ".$french;
                }else{
                    $subject = $_POST['subject'];
                }
        
                $message = $_POST['message'];
        
        $name=htmlentities($name, ENT_QUOTES, "UTF-8");
        $email=htmlentities($email, ENT_QUOTES, "UTF-8");
        $reason=htmlentities($reason, ENT_QUOTES, "UTF-8");
        $subject=htmlentities($subject, ENT_QUOTES, "UTF-8");
        $message=htmlentities($message, ENT_QUOTES, "UTF-8");
      
                $value = htmlentities($value,ENT_QUOTES,"UTF-8");
                $value = nl2br($value);
                $key = ucfirst($key);
                $ret_str .= '<table width="100%" bgcolor="#fcfcfc" border="0" cellpadding="0" cellspacing="0">
<tr>
  <td>
    <!--[if (gte mso 9)|(IE)]>
      <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td>
    <![endif]-->     
    <table bgcolor="#ffffff" class="content" align="center" cellpadding="0" cellspacing="0" border="0" style="width: 100%; max-width: 800px;">
      <tr>
        <td bgcolor="#047177" class="header" style="padding: 12px 0 10px 30px;">
          <table width="70" align="left" border="0" cellpadding="0" cellspacing="0">  
            <tr>
                            <td height="50" style="padding: 0 0 0 20px; color: #ffffff; font-family: sans-serif; font-size: 45px; line-height: 38px; font-weight: bold;">
                GC<span style="padding: 0 0 0 3px; font-size: 25px; color: #ffffff; font-family: sans-serif; ">connex</span>
              </td>
            </tr>
          </table>
        </td>
               
      <tr>
        <td class="innerpadding" style="padding: 30px 30px 30px 30px; font-size: 16px; line-height: 22px; border-bottom: 1px solid #f2eeed; font-family: sans-serif;">
          Thank you for contacting the GCconnex Help desk. This email is sent to you to have a copy of your request. You will receive an acknowledgment of receipt by email shortly. Shouldn’t you receive the acknowledgment of receipt, please contact the GCconnex Help Desk at: gcconnex@tbs-sct.gc.ca.<br/>

Thank you<br/><br/> Merci d\'avoir communiquer avec le bureau de soutien de GCconnex. Ce courriel vous est envoyé afin d’avoir une copie de votre demande dans vos dossiers. Vous recevrez un accusé de réception sous peu. Si vous ne recevez pas cet accusé de réception, prière de communiquer avec le bureau de soutien de GCconnex à l’adresse suivante : gcconnex@tbs-sct.gc.ca<br/>

Merci

             
        </td>
      </tr>
      </tr>
      <tr>
        <td class="innerpadding borderbottom" style="padding: 30px 30px 30px 30px; border-bottom: 1px solid #f2eeed;">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td class="h2" style="color: #153643; font-family: sans-serif; padding: 0 0 15px 0; font-size: 24px; line-height: 28px; font-weight: bold;">
                <span style="font-size:15px; font-weight: normal;">(Le fran&ccedil;ais suit)</span><br/>
                  GCconnex Contact Form
              </td>
            </tr>
            <tr>
              <td class="bodycopy" style="color: #153643; font-family: sans-serif; font-size: 16px; line-height: 22px;">
                <b>Name:</b> '.$name.'<br/>
                  <b>Email:</b> '.$email.'<br/>
                  <b>Reason:</b> '.$english.' <br/>
                  <b>Subject:</b> '.$subject.'<br/>
                  <b>message:</b>
                  '.$message .'<br/>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td class="innerpadding borderbottom" style="padding: 30px 30px 30px 30px; border-bottom: 1px solid #f2eeed;">
<!--          <table width="115" align="left" border="0" cellpadding="0" cellspacing="0">  
            <tr>
              <td height="115" style="padding: 0 20px 20px 0;">
                <img class="fix" src="images/article1.png" width="115" height="115" border="0" alt="" />
              </td>
            </tr>
          </table>-->
          <!--[if (gte mso 9)|(IE)]>
            <table width="380" align="left" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td>
          <![endif]-->
          
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
             
               
                  <tr>
                    <td class="bodycopy" style="color: #153643; font-family: sans-serif; padding: 0 0 15px 0; font-size: 24px; line-height: 28px; font-weight: bold;">
                        
                  Formulaire en ligne de demande
                    </td>
                  </tr>
                  <tr>
                    <td style="padding: 20px 0 0 0;font-family: sans-serif; color: #153643; font-size: 16px; line-height: 22px;">
                           <b>Nom:</b> '.$name.'<br/> 
                  <b>Email:</b> '.$email.'<br/>
                  <b>Raison:</b> '.$french.'<br/>
                  <b>Sujet:</b> '.$subject.'<br/>
                  <b>Message:</b>
                  '.$message.'<br/>
                    </td>
                  </tr>
               
              </table>
          
          <!--[if (gte mso 9)|(IE)]>
                </td>
              </tr>
          </table>
          <![endif]-->
        </td>
      </tr>

      <tr>
        <td class="footer" bgcolor="#f5f5f5" style="padding: 20px 30px 15px 30px;">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="center" class="footercopy" style="font-family: sans-serif; font-size: 14px; color: #055959">
                GCconnex contact form / Formulaire de contact GCconnex<br/>
                
                <span class="hide">Thanks contacting us / Merci de nous avoir contacter</span>
              </td>
            </tr>
            <tr>
              <td align="center" style="padding: 20px 0 0 0;">
                <table border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="150" style="text-align: center; padding: 0 10px 0 10px;">
                  Do not reply /<br/> Ne pas r&#233;pondre
                    </td>
                   
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
    <!--[if (gte mso 9)|(IE)]>
          </td>
        </tr>
    </table>
    <![endif]-->
    </td>
  </tr>
</table>';
        foreach($this->fileupload_fields as $upload_field)
        {
            $field_name = $upload_field["name"];
            if(!$this->IsFileUploaded($field_name))
            {
                continue;
            }        
            
            $filename = basename($_FILES[$field_name]['name']);

            $ret_str .= "<div class='label'>File upload '$field_name' :</div><div class='value'>$filename </div>\n";
        }
        return $ret_str;
    }

    function ExtraInfoToMail()
    {
        $ret_str='';

        $ip = $_SERVER['REMOTE_ADDR'];
        $ret_str = "<div class='label'>IP address of the submitter:</div><div class='value'>$ip</div>\n";

        return $ret_str;
    }

   /* function GetMailStyle()
    {
        $retstr = "\n<style>".
        "body,.label,.value { font-family:Arial,Verdana; } ".
        ".label {font-weight:bold; margin-top:5px; font-size:1em; color:#333;} ".
        ".value {margin-bottom:15px;font-size:0.8em;padding-left:5px;} ".
        "</style>\n";

        return $retstr;
    }*/
    function GetHTMLHeaderPart()
    {
         $retstr = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">'."\n".
                   '<html><head><title></title><style type="text/css">
  body {margin: 0; padding: 0; min-width: 100%!important;}
  img {height: auto;}
  .content {width: 100%; max-width: 600px;}
  .header {padding: 40px 30px 20px 30px;}
  .innerpadding {padding: 30px 30px 30px 30px;}
  .borderbottom {border-bottom: 1px solid #f2eeed;}
  .subhead {font-size: 15px; color: #ffffff; font-family: sans-serif; }
  .h1, .h2, .bodycopy {color: #153643; font-family: sans-serif;}
  .h1 {font-size: 33px; line-height: 38px; font-weight: bold;}
  .h2 {padding: 0 0 15px 0; font-size: 24px; line-height: 28px; font-weight: bold;}
  .bodycopy {font-size: 16px; line-height: 22px;}
  .button {text-align: center; font-size: 18px; font-family: sans-serif; font-weight: bold; padding: 0 30px 0 30px;}
  .button a {color: #ffffff; text-decoration: none;}
  .footer {padding: 20px 30px 15px 30px;}
  .footercopy {font-family: sans-serif; font-size: 14px; color: #ffffff;}
  .footercopy a {color: #ffffff; text-decoration: underline;}
  @media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
  body[yahoo] .hide {display: none!important;}
  body[yahoo] .buttonwrapper {background-color: transparent!important;}
  body[yahoo] .button {padding: 0px!important;}
  body[yahoo] .button a {background-color: #e05443; padding: 15px 15px 13px!important;}
  body[yahoo] .unsubscribe {display: block; margin-top: 20px; padding: 10px 50px; background: #2f3942; border-radius: 5px; text-decoration: none!important; font-weight: bold;}
  }
  /*@media only screen and (min-device-width: 601px) {
    .content {width: 600px !important;}
    .col425 {width: 425px!important;}
    .col380 {width: 380px!important;}
    }*/
  </style>'.
                   '<meta http-equiv=Content-Type content="text/html; charset=utf-8">';
       
        //$retstr .= $this->GetMailStyle();
         $retstr .= '</head><body yahoo bgcolor="#fcfcfc" style="margin: 0; padding: 0; min-width: 100%!important;">';
         return $retstr;
    }
    function GetHTMLFooterPart()
    {
        $retstr ='</body></html>';
        return $retstr ;
    }
    function ComposeFormtoEmail()
    {
        $header = $this->GetHTMLHeaderPart();
        $formsubmission = $this->FormSubmissionToMail();
       // $extra_info = $this->ExtraInfoToMail();
        $footer = $this->GetHTMLFooterPart();
     $message = $header."<p>$formsubmission</p><hr/>$extra_info".$footer;

        return $message;
    }

    function AttachFiles()
    {
        foreach($this->fileupload_fields as $upld_field)
        {
            $field_name = $upld_field["name"];
            if(!$this->IsFileUploaded($field_name))
            {
                continue;
            }
            
            $filename =basename($_FILES[$field_name]['name']);

            $this->mailer->AddAttachment($_FILES[$field_name]["tmp_name"],$filename);
        }
    }

    function GetFromAddress()
    {
        if(!empty($this->from_address))
        {
            return $this->from_address;
        }

        $host = $_SERVER['SERVER_NAME'];

        $from ="nobody@$host";
        return $from;
    }

    function Validate()
    {
        $ret = true;
        $numErr=0;
        //security validations
        if(empty($_POST[$this->GetFormIDInputName()]) ||
          $_POST[$this->GetFormIDInputName()] != $this->GetFormIDInputValue() )
        {
            $numErr=$numErr+1;
            //The proper error is not given intentionally
            $this->add_error();
            register_error("Automated submission prevention: case 1 failed");
            $ret = false;
        }

        //This is a hidden input field. Humans won't fill this field.
        if(!empty($_POST[$this->GetSpamTrapInputName()]) )
        {
            $numErr=$numErr+1;
            //The proper error is not given intentionally
            $this->add_error();
            register_error("Automated submission prevention: case 2 failed");
            $ret = false;
        }

        //select validations
        if((($_POST['reason']) =='Select...') || (($_POST['reason']) == "Choisir..."))
        {
            $numErr=$numErr+1;
            $this->add_error();
            register_error(str_replace('[#]',$numErr,elgg_echo('contactform:Errreason')));
            $ret = false;
        }

        if ($_POST['reason'] == 'Autres$Other')
        {
            if (empty($_POST['subject']))
            {
                $numErr=$numErr+1;
                $this->add_error();
                register_error(str_replace('[#]',$numErr,elgg_echo('contactform:Errsubject')));
                $ret = false;
            }
        }

        //name validations
        if(empty($_POST['name']))
        {
            $numErr=$numErr+1;
            $this->add_error();
            //'contactform:Errname'
            register_error(str_replace('[#]',$numErr,elgg_echo('contactform:Errname')));
            $ret = false;
        }
        else
            if(strlen($_POST['name'])>75)
            {
                $numErr=$numErr+1;
                $this->add_error();
                //'contactform:Errnamebig'
                register_error(str_replace('[#]',$numErr,elgg_echo('contactform:Errnamebig')));
                $ret = false;
            }

        //email validations
        if(empty($_POST['email']))
        {
            $numErr=$numErr+1;
            $this->add_error();
            register_error(str_replace('[#]',$numErr,elgg_echo('contactform:Erremail')));
            $ret = false;
        }
        else
            if(strlen($_POST['email'])>100)
            {
                $numErr=$numErr+1;
                $this->add_error();
                register_error(str_replace('[#]',$numErr,elgg_echo('contactform:Erremailbig')));
                $ret = false;
            }
            else
                if(!$this->validate_email($_POST['email']))
                {
                    $numErr=$numErr+1;
                    $this->add_error();
                    //'contactform:Erremailvalid'
                    register_error(str_replace('[#]',$numErr,elgg_echo('contactform:Erremailvalid')));
                    $ret = false;
                }

        //department validaions
        if(empty($_POST['depart']))
        {
            $numErr=$numErr+1;
            $this->add_error();
            register_error(str_replace('[#]',$numErr,elgg_echo('contactform:Errdepart')));
            $ret = false;
        }
        else
            if(strlen($_POST['depart'])>255)
            {
                $numErr=$numErr+1;
                $this->add_error();
                register_error(str_replace('[#]',$numErr,elgg_echo('contactform:Errdepartbig')));
                $ret = false;
            }

        //message validaions
        if(empty($_POST['message']))
        {
            $numErr=$numErr+1;
            $this->add_error();
            register_error(str_replace('[#]',$numErr,elgg_echo('contactform:Errmess')));
            $ret = false;
        }
        else
            if(strlen($_POST['message'])>2048)
            {
                $numErr=$numErr+1;
                $this->add_error();
                register_error(str_replace('[#]',$numErr,elgg_echo('contactform:Errmessbig')));
                $ret = false;
            }

        //captcha validaions
        /* if(isset($this->captcha_handler))
        {
        if(!$this->captcha_handler->Validate())
        {
        $this->add_error($this->captcha_handler->GetError());
        $ret = false;
        }
        }*/
        //file upload validations
        if(!empty($this->fileupload_fields))
        {
            $numErr=$numErr+1;
            if(!$this->ValidateFileUploads($numErr))
            {
                $ret = false;
            }
        }
        return $ret;
    }

    function ValidateFileType($field_name,$valid_filetypes)
    {
        $ret=true;
        $info = pathinfo($_FILES[$field_name]['name']);
        $extn = $info['extension'];
        $extn = strtolower($extn);

        $arr_valid_filetypes= explode(',',$valid_filetypes);
        if(!in_array($extn,$arr_valid_filetypes))
        {
            $this->add_error();
            register_error("Valid file types are: $valid_filetypes");
            $ret=false;
        }
        return $ret;
    }

    function ValidateFileSize($field_name,$max_size)
    {
        $size_of_uploaded_file =
                $_FILES[$field_name]["size"]/1024;//size in KBs
        if($size_of_uploaded_file > $max_size)
        {
            $this->add_error();
            register_error("The file is too big. File size should be less than $max_size KB");
            return false;
        }
        return true;
    }

    function IsFileUploaded($field_name)
    {
        if(empty($_FILES[$field_name]['name']))
        {
            return false;
        }
        if(!is_uploaded_file($_FILES[$field_name]['tmp_name']))
        {
            return false;
        }
        return true;
    }
    function ValidateFileUploads()
    {
        $ret=true;
        foreach($this->fileupload_fields as $upld_field)
        {
            $field_name = $upld_field["name"];

            $valid_filetypes = $upld_field["file_types"];
            
            if(!$this->IsFileUploaded($field_name))
            {
                continue;
            }

            if($_FILES[$field_name]["error"] != 0)
            {
                $this->add_error("Error in file upload; Error code:".$_FILES[$field_name]["error"]);
                $ret=false;
            }

            if(!empty($valid_filetypes) &&
             !$this->ValidateFileType($field_name,$valid_filetypes))
            {
                $ret=false;
            }

            if(!empty($upld_field["maxsize"]) &&
            $upld_field["maxsize"]>0)
            {
                if(!$this->ValidateFileSize($field_name,$upld_field["maxsize"]))
                {
                    $ret=false;
                }
            }

        }
        return $ret;
    }

    function StripSlashes($str)
    {
        if(get_magic_quotes_gpc())
        {
            $str = stripslashes($str);
        }
        return $str;
    }
    /*
    Sanitize() function removes any potential threat from the
    data submitted. Prevents email injections or any other hacker attempts.
    if $remove_nl is true, newline chracters are removed from the input.
    */
    function Sanitize($str,$remove_nl=true)
    {
        $str = $this->StripSlashes($str);

        if($remove_nl)
        {
            $injections = array('/(\n+)/i',
                '/(\r+)/i',
                '/(\t+)/i',
                '/(%0A+)/i',
                '/(%0D+)/i',
                '/(%08+)/i',
                '/(%09+)/i'
                );
            $str = preg_replace($injections,'',$str);
        }

        return $str;
    }

    /*Collects clean data from the $_POST array and keeps in internal variables.*/
    function CollectData()
    {
        $this->name = $this->Sanitize($_POST['name']);
        $this->email = $this->Sanitize($_POST['email']);

        /*newline is OK in the message.*/
        $this->message = $this->StripSlashes($_POST['message']);
    }

    function add_error($error)
    {
        array_push($this->errors,$error);
    }
    function validate_email($email)
    {
        return eregi("^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$", $email);
    }

    function GetKey()
    {
        return $this->form_random_key.$_SERVER['SERVER_NAME'].$_SERVER['REMOTE_ADDR'];
    }

}

?>