<style>


.content {
    width: 960px;
    margin: 0 auto;
    overflow: hidden;
    z-index:1000;
}

.active-links {
    position: absolute;
    right: 8px;
    top: 0;
}

#container {
   /* width: 780px;*/
    margin: 0 auto;
    position: relative;
    z-index:499;
    margin-bottom:40px;
}

#topnav {
    text-align: right;
}

#session {
    cursor: pointer;
    display: inline-block;
    height: 20px;
    padding: 10px 12px;
    vertical-align: top;
    white-space: nowrap;
}

#session.active, #session:hover {
    background: rgba(255,255,255,0.1);
    color: fff;
}



a#signin-link em {
    font-size: 10px;
    font-style: normal;
    margin-right: 4px;
    
}
    
a#signin-link strong {
text-decoration:none;
}


#signin-dropdown {
    background-color: #fff;
    box-shadow: 0 1px 2px #666666;
    -webkit-box-shadow: 0 1px 2px #666666;
    min-height: 200px;
    min-width: 360px;
    position: absolute;
    right: 0;
    display: none;
    z-index:1000;
    margin-top: 15px;
    padding:20px;
}
    
#signin-dropdown:first-child:after  {
 left: -8px;
  top: 12px;
  width: 0;
  height: 0;
  border-left: 0;
  border-bottom: 5px solid transparent;
  border-top: 5px solid transparent;
  border-right: 8px solid #444;
     content: '';
}

#signin-dropdown form {
    cursor: pointer;
    text-align: left;
}

#signin-dropdown .textbox span {
    color: #BABABA;
}

#signin-dropdown .textbox input {
    width: 200px;
}

fieldset {
    border: none;
}

form.signin .textbox label {
    display: block;
    padding-bottom: 7px;
}

form.signin .textbox span {
    display: block;
}

form.signin p, form.signin span {
    color: #999;
    font-size: 11px;
    line-height: 18px;
}

form.signin .textbox input {
    border-bottom: 1px solid #333;
    border-left: 1px solid #000;
    border-right: 1px solid #333;
    border-top: 1px solid #000;
    color: #fff;
    -moz-border-radius: 3px;
    -webkit-border-radius: 3px;
    font: 13px Arial, Helvetica, sans-serif;
    padding: 6px 6px 4px;
}

form.signin .remb {
    padding: 9px 0;
    position: relative;
    text-align: right;
}

form.signin .remb .remember {
    text-align: left;
    position: absolute;
    left: 0;
}

.button {
    background: -moz-linear-gradient(center top, #f3f3f3, #dddddd);
    background: -webkit-gradient(linear, left top, left bottom, from(#f3f3f3), to(#dddddd));
    background: -o-linear-gradient(top, #f3f3f3, #dddddd);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorStr='#f3f3f3', EndColorStr='#dddddd');
    border-color: #000;
    border-width: 1px;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    color: #333;
    cursor: pointer;
    display: inline-block;
    padding: 4px 7px;
    margin: 0;
    font: 12px;
}

.button:hover {
    background: #ddd;
}
    
    .login-menu{
    top:35px;   
}

.login-menu:before{
       content: '';
    display: block;
    position: absolute;
    left: 67%;
    top: -12px;
    width: 0;
    height: 0;
	border-left: 12px solid transparent;
	border-right: 12px solid transparent;
	
	border-bottom: 12px solid #666666;
    clear: both;    
}
.login-menu:after{
    content: '';
    display: block;
    position: absolute;
    left: 67%;
    top: -12px;
    width: 0;
    height: 0;
	border-left: 12px solid transparent;
	border-right: 12px solid transparent;
	
	border-bottom: 12px solid #fff ;
    clear: both;     
}
</style>


<script>
$(document).ready(function () {
$('#signin-link').click(function () {
    $('#signin-dropdown').toggle();
    $('#session').toggleClass('active');
    return false;
});
$('#signin-dropdown').click(function(e) {
    e.stopPropagation();
});
$(document).click(function() {
    $('#signin-dropdown').hide();
    $('#session').removeClass('active');
});
});   
</script>
<?php
/**
 * User Menu
@@ -10,17 +220,172 @@ echo elgg_view_menu('topbar', array('sort_by' => 'priority', array('elgg-menu-hz
// elgg tools menu
// need to echo this empty view for backward compatibility.
echo elgg_view_deprecated("navigation/topbar_tools", array(), "Extend the topbar menus or the page/elements/topbar view directly", 1.8);

 * Elgg login form
 *
 * @package Elgg
 * @subpackage Core
*/

$site_url = elgg_get_site_url();
    if (empty($_GET['username'])){
    
  
?>

<div id="container">
<div id="topnav">
<div class="active-links">
    <div id="session">
    <a id="signin-link" href="#" style='text-decoration:none;'>
    <strong><?php echo elgg_echo('login'); ?> |</strong>
    </a>
    <strong><a  href=" <?php echo $site_url; ?>register">  <?php echo elgg_echo('register'); ?></a></li></strong>
    
    </div>
        <div id="signin-dropdown" class='login-menu'>
    
     <form method="get" role="form" action="#">
<div class="form-group">
	<label for='username'><?php echo elgg_echo('loginusername'); ?></label>
	<?php echo elgg_view('input/text', array(
		'name' => 'username',
		'autofocus' => true,
        'placeholder' => 'Username or Email',
        'id' => 'username',
        'class' => 'form-control',
		));
	?>
</div>
<div class="form-group">
	<label for='password'><?php echo elgg_echo('password'); ?></label>
	<?php echo elgg_view('input/password', array('name' => 'password', 'id' => 'password', 'placeholder' => 'Password', 'class' => 'form-control')); ?>
</div>

<?php echo elgg_view('login/extend', $vars); ?>

<div class="checkbox">
	<label class="mtm">
		<input type="checkbox" name="persistent" value="true" />
		<?php echo elgg_echo('user:persistent'); ?>
	</label>
         </div>
	<?php echo elgg_view('input/submit', array('value' => elgg_echo('login'), 'class' => 'btn-custom-cta',)); ?>
	
	<?php 
	if (isset($vars['returntoreferer'])) {
		echo elgg_view('input/hidden', array('name' => 'returntoreferer', 'value' => 'true'));
	}
	?>

	<?php
    /*
	echo elgg_view_menu('login', array(
		'sort_by' => 'priority',
		'class' => 'elgg-menu-general elgg-menu-hz mtm',
	));
    */

    echo '<a href="' . $site_url . 'forgotpassword" class="col-xs-12 mrgn-tp-md">Forgot your password?</a>';
?>
</div>
    </div>
        </div>
     </div>
</form>
<?php
     }else{
$session = elgg_get_session();

// set forward url
if ($session->has('last_forward_from')) {
	$forward_url = $session->get('last_forward_from');
	$forward_source = 'last_forward_from';
} elseif (get_input('returntoreferer')) {
	$forward_url = REFERER;
	$forward_source = 'return_to_referer';
} else {
	// forward to main index page
	$forward_url = '';
	$forward_source = null;
}

$username = get_input('username');
$password = get_input('password', null, false);
$persistent = (bool) get_input("persistent");
$result = false;

if (empty($username) || (empty($password))) {
	register_error(elgg_echo('login:empty'));
	forward();
}

// check if logging in with email address
if (strpos($username, '@') !== false && ($users = get_user_by_email($username))) {
	$username = $users[0]->username;
}

$result = elgg_authenticate($username, $password);
if ($result !== true) {
	register_error($result);
	forward(REFERER);
}

$user = get_user_by_username($username);
if (!$user) {
	register_error(elgg_echo('login:baduser'));
	forward(REFERER);
}

try {
	login($user, $persistent);
	// re-register at least the core language file for users with language other than site default
	register_translations(dirname(dirname(__FILE__)) . "/languages/");
} catch (LoginException $e) {
	register_error($e->getMessage());
	forward(REFERER);
}

// elgg_echo() caches the language and does not provide a way to change the language.
// @todo we need to use the config object to store this so that the current language
// can be changed. Refs #4171
if ($user->language) {
	$message = elgg_echo('loginok', array(), $user->language);
} else {
	$message = elgg_echo('loginok');
}

// clear after login in case login fails
$session->remove('last_forward_from');

$params = array('user' => $user, 'source' => $forward_source);
$forward_url = elgg_trigger_plugin_hook('login:forward', 'user', $params, $forward_url);

system_message($message);
forward($forward_url);
  
    }
/*    
elgg_register_menu_item('login_menu2', array(
    'name' => 'Log in',
    
    'text' => elgg_view('page/elements/login_card'),
    'title' => 'Log in',
    ));

$dropdown = elgg_view_menu('login_menu2',  array('class' => 'dropdown-menu user-menu pull-right subMenu'));
$caret = elgg_echo('<b class="caret"></b>');
//create tabs menu
elgg_register_menu_item('login_menu', array(
    'name' => 'Profile',
    'text' =>  elgg_echo('login').$caret. $dropdown ,
    'title' => elgg_echo('groups:personal'),
    'item_class' => 'dropdown',
    'data-toggle' => 'dropdown',
    'class' => 'dropdown-toggle',
    'priority' => '10',
    ));

echo elgg_view_menu('login_menu', array('sort_by' => 'priority', 'id' => 'userMenu', 'class' => 'list-inline visited-link'));*/
?>
