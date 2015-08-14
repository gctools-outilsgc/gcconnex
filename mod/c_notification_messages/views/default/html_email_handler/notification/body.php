<?php 
	$title = $vars["title"];
	$message = nl2br($vars["message"]);
	$language = get_current_language();
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $language; ?>" lang="<?php echo $language; ?>">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<base target="_blank" />
		
		<?php 
			if(!empty($title)){ 
				echo "<title>" . $title . "</title>\n";
			}
		?>
	</head>
	<body>
		<style type="text/css">
			body {
				font: "Arial", Calibri, sans-serif;
				color: #333333;				
			}
			
			a {
				color: #4690d6;
			}
			
			#notification_container {
				width: 70%;
				margin: auto;
				display: block;
				word-wrap: break-word;
			}
		
			#notification_header {
				text-align: left;
				padding: 0 0 10px;
			}
			
			#notification_header a {
				text-decoration: none;
				font-weight: bold;
				color: #0054A7;
				font-size: 1.5em;
			} 
		
			#notification_wrapper {
				width: 100%;
				background: #DEDEDE;
				padding: 10px;
			}
			
			#notification_wrapper h2 {
				margin: 5px 0 5px 10px;
				color: #0054A7;
				font-size: 1.35em;
				line-height: 1.2em;
			}
			
			#notification_content {
				background: #FFFFFF;
				padding-left: 20px;
				padding-right: 20px;
			}
			
			#notification_footer {
				background: #B6B6B6;
			}
			
			.clearfloat {
				clear:both;
				height:0;
				font-size: 1px;
				line-height: 0px;
			}
			
		</style>
	
		<div id="notification_container">		
			<div id="notification_header">
				<?php 
					$site_url = elgg_view("output/url", array("href" => $vars["config"]->site->url, "text" => $vars["config"]->site->name));
					echo $site_url;
				?>
				<br/>
			</div>
						
			<div id="notification_wrapper">
			
				<center>
					<i>This is a system-generated message from GCconnex. Please do <strong>not</strong> reply to this message.</i>
					<br/>
					<i>Ce message est généré automatiquement par GCconnex. SVP <strong>ne pas</strong> y répondre.</i>
				</center>
			
				<div id="notification_content">
	
					<?php						
						$remove_p = str_ireplace('<p>', '', $message);
						$remove_p = str_ireplace('</p>', '', $remove_p);
						$remove_xtra_breaks = preg_replace("#(<br\s*/?>\s*){3,}#","<br/><br/>",$remove_p);
						echo $remove_xtra_breaks; 
					?>
				
				</div>
			</div>
			
			<div id="notification_footer">				
			
			</div>
		</div>
	</body>
</html>