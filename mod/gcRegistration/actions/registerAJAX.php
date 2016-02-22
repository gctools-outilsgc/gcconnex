<?php
/**
 * Username generator for GCCONNEX register.php
 *
 * - users email is used to generate the username, so it is assumed that all emails are in standard GC format: givenname.familyname@institution.gc.ca
 * - duplicate usernames are incremented by (int)1 until they are available
 *
 * @param  $emailInput <string> users email address
 * @return always returns "" because we use the response text directly
 * 
 */

/***********************************************************************
 * MODIFICATION LOG
 * +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
 *
 * USER 		DATE 			DESCRIPTION
 * TLaw/ISal 	n/a 			created registerAJAX.php
 * CYu 			March 5 2014 	ajaxify the email verification & code clean up
 * CYu 			March 13 2014	restricts the email extension
 * CYu 			Sept 19 2014 	modifies so that checks are not case sensitive
 ***********************************************************************/

global $CONFIG;

$emailInput = trim(get_input('args'));


require_once(dirname(dirname(dirname(dirname(__FILE__)))).'/engine/settings.php');

// Establish MySQL connection link
$connection = mysqli_connect($CONFIG->dbhost, $CONFIG->dbuser, $CONFIG->dbpass, $CONFIG->dbname);
if (mysqli_connect_errno($connection)) 
{
	echo elgg_echo('gcRegister:failedMySQLconnection');
	exit;
}

$email = $emailInput;

if (strlen( $email ) > 0) 
{
	$domainPos = strpos($email, '@') + 1;
	$domain = substr($email, $domainPos);
	
	// count number of emails
	$query2 = "SELECT count(*) AS num FROM `elggusers_entity` WHERE email = '". $email ."'";

	$result2 = mysqli_query($connection, $query2);
	$result2 = mysqli_fetch_array($result2);
	$emailrow = $result2['num'];
		
	// check if email in use
	// NOTE: the '>' character is used to make the username invalid.
	if ( $emailrow[0] > 0 ) {
		echo '> ' . elgg_echo('gcRegister:email_in_use');

	// make sure selected domain is not the example domain (this is already checked for in the JS, but do it anyway)
	} else if( checkInvalidDomain($domain) ) {
		echo '> ' . elgg_echo('gcRegister:invalid_email2');
	
	} else {

		$usrname = str_replace( "'", "", usernameize( $email ) );

		// Troy - fix for usernames generated with "-" in them; better solution may present itself.
		while (strpos($usrname,'-')!==false ){
			$usrname = substr_replace($usrname, ".", strpos($usrname,'-'),1);
		}

		if(rtrim($usrname, "0..9") != "") {
			$usrname = rtrim($usrname, "0..9");
		}

		// select matching usernames
		$query1 = "SELECT count(*) AS 'num' FROM `elggusers_entity` WHERE username = '". $usrname ."'";

		$result1 = mysqli_query($connection, $query1);
		$result1 = mysqli_fetch_array($result1);

		// check if username exists and increment it
		if ( $result1['num'][0] > 0 ){
			
			$unamePostfix = 0;
			$usrnameQuery = $usrname;
			
			do {
				$unamePostfix++;
				
				$tmpUsrnameQuery = $usrnameQuery . $unamePostfix;
				
				$query = "SELECT count(*) AS 'num' FROM `elggusers_entity` WHERE username = '". $tmpUsrnameQuery ."'";
				$tmpResult = mysqli_query($connection, $query);
				$tmpResult = mysqli_fetch_array($tmpResult);
				
				$uname = $tmpUsrnameQuery;
				
			} while ( $tmpResult['num'][0] > 0);
			
		}else{
			// username is available
			$uname = $usrname;
		}
		// username output
		echo $uname;
	}							
}
else echo '> '.elgg_echo("gcRegister:please_enter_email");



/* +++ DEFINED FUNCTION +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */


// GCChange[1] - better username generation function found from a user note on the ucfirst() php.net manual page
function usernameize($str,$a_char = array("'","-",".")) 
{
	$string = replaceAccents(mb_strtolower(strtok( $str, '@' )));
	foreach ($a_char as $temp){
		$pos = strpos($string,$temp);
		if ($pos){
			$mend = '';
			$a_split = explode($temp,$string);
			foreach ($a_split as $temp2){
				$mend .= ucfirst($temp2).$temp;
			}
			$string = substr($mend,0,-1);
		}
	}
	return ucfirst($string);
}

/**
 * 
 * Checks for invalid / external domains
 * 
 * @param  $domain <string> domain part of the user's email address
 * @return true if domain is invalid, false otherwise
 * 
 **/
function checkInvalidDomain($dom) 
{
	//elgg_log('cyu - checkInvalidDomain invoked | domain:'.$dom, 'NOTICE');
	elgg_load_library('c_ext_lib');
	$isNotValid = true;

	error_log('cyu - domain:'.$dom);
	$result = getExtension();
	if (count($result) > 0)
	{
		while ($row = mysqli_fetch_array($result))
		{
			if (strtolower($row['ext']) === strtolower($dom))
			{
				//elgg_log('cyu - domain found in database!', 'NOTICE');
				$isNotValid = false;
				break;
			}
		}
	}

	if ($isNotValid)
	{
		$domain_addr = explode('.', $dom);
		$domain_len = count($domain_addr) - 1;

		if ($domain_addr[$domain_len - 1].'.'.$domain_addr[$domain_len] === 'gc.ca')
		{
			//elgg_log('cyu - domain:'.$dom. ' this is a valid domain', 'NOTICE');
			$isNotValid = false;
		} else {
			//elgg_log('cyu - domain:'.$dom. ' this is an invalid domain', 'NOTICE');
			$isNotValid = true;
		}
	}

	return $isNotValid;
}


/**
 * Email character filter
 *
 * Filters out the french characters in an email and replaces them with the english equivelant
 * Array key is the character to remove and the associated item is what will replace it.
 *
 * @param  $emailInput <string> users email address
 * @return always returns "" because we use the response text directly
 * @author Matthew April <Matthew.April@tbs-sct.gc.ca>
 */

function characterFilter( $email ) 
{
	$filter = array(
	
		'â' => 'a',
		'à' => 'a',
		'á' => 'a',
		'ç' => 'c',
		'ê' => 'e',
		'é' => 'e',
		'è' => 'e',
		'ô' => 'o',
		'Â' => 'A',
		'À' => 'A',
		'Á' => 'A',
		'Ç' => 'C',
		'Ê' => 'E',
		'É' => 'E',
		'È' => 'E',
		'Ô' => 'O',
	);
	
	foreach( $filter as $remove => $replace ) {
		if( strpos( $email, $remove) ) {
			$email = str_replace($remove, $replace, $email);
		}
	}
	echo $email;
	return "";
}


// gcchange - added function found online for removing accents not only for emails
function replaceAccents($str)
{
	$a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ');
	$b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o');
	return str_replace($a, $b, $str);
}

?>