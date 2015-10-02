<?php

$subject = elgg_extract("subject", $vars);
$message = elgg_autop(elgg_extract("body", $vars));
$language = elgg_extract("language", $vars, get_current_language());
$recipient = elgg_extract("recipient", $vars);

$site = elgg_get_site_entity();
$site_url = elgg_get_site_url();
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $language; ?>" lang="<?php echo $language; ?>">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<base target="_blank" />
		
		<?php
			if (!empty($subject)) {
				echo "<title>" . $subject . "</title>";
			}
		?>
	</head>
	<body>
		<style type="text/css">
			<?php echo elgg_view("css/html_email_handler/notification"); ?>
		</style>
	
		<div id="notification_container">
			<div id="notification_header">
				<?php
					echo elgg_view("output/url", array("href" => $site_url, "text" => $site->name, "is_trusted" => true));
				?>
			</div>
			<div id="notification_wrapper">
				<?php
					if (!empty($subject)) {
						echo elgg_view_title($subject);
					}
				?>
			
				<div id="notification_content">
					<?php echo $message; ?>
				</div>
			</div>
			
			<div id="notification_footer">
				<a href="http://www.elgg.org/" id="notification_footer_logo">
					<img src="<?php echo $site_url; ?>_graphics/powered_by_elgg_badge_drk_bckgnd.gif" />
				</a>
				
				<?php
					if (!empty($recipient) && ($recipient instanceof ElggUser)) {
						$settings_url = $site_url . "settings/user/" . $recipient->username;
						if (elgg_is_active_plugin("notifications")) {
							$settings_url = $site_url . "notifications/personal/" . $recipient->username;
						}
						echo elgg_echo("html_email_handler:notification:footer:settings", array("<a href='" . $settings_url . "'>", "</a>"));
					}
				?>
				<div class="clearfloat"></div>
			</div>
		</div>
	</body>
</html>
