<style>


.content {
    width: 960px;
    margin: 0 auto;
    overflow: hidden;
    z-index:1000;
}

.active-links {
  /*  position: absolute; */
    right: 8px;
    top: 0;
    margin-bottom: 20px;
}

#container {
   /* width: 780px;*/
    margin: 0 auto;
    position: relative;
    z-index:499;
   /* margin-bottom:40px; */
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

$('#signin-link').live('keydown', function(e) {
    if (keyCode == 13) {
        setTimeout(function(){$('#username').focus();},0);
    }
});

    $('#signin-link').click(function(){
        setTimeout(function(){$('#username').focus();},0);
    });
});
</script>
<?php
/**
 * Elgg login form
 *
 * @package Elgg
 * @subpackage Core
*/

$site_url = elgg_get_site_url();

?>

<div id="container">
  <div id="topnav">
    <div class="active-links">
        <div id="session">
          <?php if (get_context() != 'login'){ ?>
          <a id="signin-link" href="#" style='text-decoration:none;'><strong><span id="login_focus"><?php echo elgg_echo('login'); ?></span>  |</strong></a>
          <strong><a  href=" <?php echo $site_url; ?>register">  <?php echo elgg_echo('register'); ?></a></li></strong>
          <?php } ?>
        </div>

        <div id="signin-dropdown" class='login-menu'>

          <form method="post" role="form" action="<?php echo elgg_add_action_tokens_to_url($site_url.'action/login'); ?>">
            <div class="form-group">
          	   <label for='username'><?php echo elgg_echo('loginusername'); ?></label>
          	<?php echo elgg_view('input/text', array(
          		        'name' => 'username',
                      'placeholder' => elgg_echo('loginusername'),
                      'id' => 'username',
                      'class' => 'form-control',
          		      ));
          	?>
          </div>
          <div class="form-group">
          	<label for='password'><?php echo elgg_echo('password'); ?></label>
          	<?php echo elgg_view('input/password', array('name' => 'password', 'id' => 'password', 'placeholder' => elgg_echo('password'), 'class' => 'form-control')); ?>
          </div>

          <?php echo elgg_view('login/extend', $vars); ?>

          <div class="checkbox">
          	<label class="mtm">
          		<input type="checkbox" name="persistent" value="false" />
          		<?php echo elgg_echo('user:persistent'); ?>
          	</label>
          </div>
          	<?php
            echo elgg_view('input/submit', array('value' => elgg_echo('login'), 'class' => 'btn-primary'));
          	echo elgg_view('input/hidden', array('name' => 'returntoreferer', 'value' => 'true'));
            echo '<a href="' . $site_url . 'forgotpassword" class="col-xs-12 mrgn-tp-md">'.elgg_echo('user:forgot').'</a>';
            ?>
          </form>

        </div>
      </div>
    </div>
  </div>
