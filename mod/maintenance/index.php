<?php 
	global $CONFIG;
	$text = get_plugin_setting("maintenance_text","maintenance");
	
	$form_body = "<table><tr><td>";
	$form_body .= elgg_echo('username') . "</td><td>" . elgg_view('input/text', array('internalname' => 'username', 'class' => 'login-textarea')) . "</td><td>";
	$form_body .= "</td></tr><tr><td>";
	$form_body .= elgg_echo('password') . "</td><td>" . elgg_view('input/password', array('internalname' => 'password', 'class' => 'login-textarea')) . "</td><td>";
	
	$form_body .= elgg_view('input/submit', array('value' => elgg_echo('login')));
	$form_body .= "</td></tr></table>";
	
	$login_url = $vars['url'];
	if ((isset($CONFIG->https_login)) && ($CONFIG->https_login))
		$login_url = str_replace("http", "https", $vars['url']);
	
?>
<html>
	<head>
		<!--- modified to use elgg 1.8.0.1 included javascript file -->
		<script type="text/javascript" src="<?php echo $CONFIG->wwwroot;?>vendors/jquery/jquery-1.6.4.min.js"></script>
		
		<script type="text/javascript">
			function showAdmin(){
				$("#admin_login").toggle("slow");
			}
		</script>
		
		<style type="text/css">
			body {
				text-align:center;
				font: 80%/1.4  "Lucida Grande", Verdana, sans-serif;
			}
			
			#maintenance_box {
				margin: 15% auto;
				
				position:relative;
				width: 972px;
				border: 1px solid #DEDEDE;
			}
			
			#image_container {
				vertical-align:top;
			}
			
			#admin_login{
				display: none;
			}
			
			img {
				margin-right:40px;
				
			}
		</style>
		
	</head>
	<body>
		<div id="maintenance_box">
			
			<table>
			<tr>
				<td id="image_container">
					<img src="<?php echo $CONFIG->wwwroot;?>mod/maintenance/_graphics/maintenance.png">
				</td>
				<td>
					<h1>	
					<?php echo elgg_echo("maintenance:info");?>
					</h1>
					<p>
						<?php echo $text;?>
					</p>
					<p>
						<?php echo sprintf(elgg_echo("maintenance:adminlogin"), "<a href='javascript:showAdmin()'>" , "</a>");?>
					</p>
					<div id="admin_login">
						<?php echo elgg_view('input/form', array('body' => $form_body, 'action' => "{$login_url}action/login"));?>		
	
					</div>		
				</td>
			</tr>
			</table>
			
		</div>
	</body>
</html>
<?php exit();?>