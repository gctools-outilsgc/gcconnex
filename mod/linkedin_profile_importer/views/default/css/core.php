<?php if (FALSE) : ?><style type="text/css"><?php endif; ?>

	.hybridauth-diagnostics-pass {
		color:green;
		font-weight:bold;
	}
	.hybridauth-diagnostics-fail {
		color:red;
		font-weight:bold;
	}
	.hybridauth-diagnostics-success {
		margin-top:10px;
		margin-bottom:10px;
	}

	<?php
	$path16 = elgg_get_site_url() . 'mod/linkedin_profile_importer/graphics/16x16/';
	$path32 = elgg_get_site_url() . 'mod/linkedin_profile_importer/graphics/32x32/';
	$providers = unserialize(elgg_get_plugin_setting('providers', 'linkedin_profile_importer'));
	foreach ($providers as $provider => $settings) {
		$provider = strtolower($provider);
		echo ".elgg-icon.elgg-icon-auth-{$provider} {\r\n";
		echo "	background:transparent url({$path16}{$provider}.png) 50% 50% no-repeat;\r\n";
		echo "	width:16px;\r\nheight:16px;\r\ndisplay:inline-block;\r\nvertical-align:inherit;\r\n";
		echo "}\r\n";

		echo ".elgg-icon.elgg-icon-auth-{$provider}-large {\r\n";
		echo "	background:transparent url({$path32}{$provider}.png) 50% 50% no-repeat;\r\n";
		echo "	width:32px;\r\nheight:32px;\r\ndisplay:inline-block;\r\nvertical-align:inherit;\r\n";
		echo "}\r\n";
	}
	?>

	.hybridauth-provider-settings {
	    padding: 10px;
		margin-left: 0;
	}
	.hybridauth-provider-settings > .elgg-body {
		padding: 10px;
		box-sizing:border-box;
	}
	.hybridauth-provider-settings.elgg-module-widget > .elgg-head {
		height: auto;
	}
	.hybridauth-provider-settings.elgg-module-widget > .elgg-head h3 {
		padding: 10px 5px;
	}
	.hybridauth-provider-settings label {
		margin: 10px 0 5px;
		display: block;
	}
	.hybridauth-form-icons > li {
		display: inline-block;
		padding: 3px;
	}
	.hybridauth-autogen-instructions,
	.hybridauth-login-instructions
	{
		padding: 20px;
		border: 2px solid #e8e8e8;
		font-weight: bold;
	}

	<?php if (FALSE) : ?></style><?php endif; ?>