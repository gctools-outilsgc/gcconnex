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
class FGSimpleCaptcha extends FG_CaptchaHandler
{
    var $error_str;
    var $captcha_varname;
    var $uniquekey;

    function FGSimpleCaptcha($captcha_var_name)
    {
        $this->captcha_varname=$captcha_var_name;
        $this->uniquekey='KHJhsjsy65HGbsmnd';
    }

    /*Add more simple questions here.*/
    function GetSimpleCaptcha()
    {
        $arrQuestions = array(
	elgg_echo('contactform:validator:question1') => elgg_echo('contactform:validator:answer1'),
	elgg_echo('contactform:validator:question2') => elgg_echo('contactform:validator:answer2'),
	elgg_echo('contactform:validator:question3') => elgg_echo('contactform:validator:answer3'),
	elgg_echo('contactform:validator:question4') => elgg_echo('contactform:validator:answer4'),
	elgg_echo('contactform:validator:question5') => elgg_echo('contactform:validator:answer5'),
	);

        $question = array_rand($arrQuestions);
        $answer = $arrQuestions[$question];

        $_SESSION['FGCF_Captcha_Answer'] = $this->Md5CaptchaAnswer($answer);

        return $question;
    }

    function SetFormKey($key)
    {
        $this->uniquekey = $key;
    }
    function GetKey()
    {
        return $this->uniquekey;
    }
    function Validate()
    {
        $ret=false;
        if(empty($_POST[$this->captcha_varname]))
        {
            $this->error_str = register_error(elgg_echo('Please answer the Anti-SPAM question'));
            $ret = false;
        }
        else
        {

            $scaptcha = trim($_POST[$this->captcha_varname]);

            $scaptcha = strtolower($scaptcha);

            $user_answer = $this->Md5CaptchaAnswer($scaptcha);

            if($user_answer != $_SESSION['FGCF_Captcha_Answer'])
            {
                $this->error_str = register_error (elgg_echo('contactform:validator:failed'));
                $ret = false;
            }
            else
            {
                $ret = true;
            }
        }//else
        return $ret;
    }
    function Md5CaptchaAnswer($answer)
    {
        return md5($this->GetKey().$answer);
    }
    function GetError()
    {
        return $this->error_str;
    }
}
?>
