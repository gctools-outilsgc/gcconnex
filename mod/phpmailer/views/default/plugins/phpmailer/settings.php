<?php
/**
 * PHPMailer plugin settings
 */

// override Elgg mail handler
echo '<div>';
$checked = $vars['entity']->phpmailer_override != 'disabled' ? 'checked' : false;
echo elgg_view('input/checkbox', array(
	'name' => 'params[phpmailer_override]',
	'value' => 'enabled',
	'checked' => $checked,
	'default' => 'disabled',
));
echo ' ' . elgg_echo('phpmailer:override') . '</div>';

// SMTP Settings
echo '<fieldset class="elgg-border-plain mbm pas">';
echo '<div>';

echo elgg_echo('phpmailer:fromname') . ':';
echo elgg_view('input/text', array(
	'name' => 'params[phpmailer_from_name]',
	'value' => $vars['entity']->phpmailer_from_name,
	'class' => 'phpmailer-smtp phpmailer-ssl elgg-input-natural',
));
echo '<br/>' . elgg_echo('phpmailer:fromemail') . ':';
echo elgg_view('input/text', array(
	'name' => 'params[phpmailer_from_email]',
	'value' => $vars['entity']->phpmailer_from_email,
	'class' => 'phpmailer-smtp phpmailer-ssl elgg-input-natural',
));
echo '<br/><br/>';

$checked = $vars['entity']->phpmailer_smtp ? 'checked' : false;
echo elgg_view('input/checkbox', array(
	'name' => 'params[phpmailer_smtp]',
	'value' => 1,
	'checked' => $checked,
	'default' => 0,
	'id' => 'phpmailer-smtp',
));
echo ' ' . elgg_echo('phpmailer:smtp') . '<br/>';

echo elgg_echo('phpmailer:host') . ': ';
echo elgg_view('input/text', array(
	'name' => 'params[phpmailer_host]',
	'value' => $vars['entity']->phpmailer_host,
	'class' => 'phpmailer-smtp elgg-input-natural',
));

echo '<br /><br />';
$checked = $vars['entity']->phpmailer_smtp_auth ? 'checked' : false;
echo elgg_view('input/checkbox', array(
	'name' => 'params[phpmailer_smtp_auth]',
	'value' => 1,
	'checked' => $checked,
	'default' => 0,
	'class' => 'phpmailer-smtp',
	'id' => 'phpmailer-smtp-auth',
));
echo ' ' . elgg_echo('phpmailer:smtp_auth') . '<br/>';

echo elgg_echo('phpmailer:username') . ': ';
echo elgg_view('input/text', array(
	'name' => 'params[phpmailer_username]',
	'value' => $vars['entity']->phpmailer_username,
	'class' => 'phpmailer-smtp phpmailer-smtp-auth elgg-input-natural',
));

echo '<br />';
echo elgg_echo('phpmailer:password') . ':';
echo elgg_view('input/password', array(
	'name' => 'params[phpmailer_password]',
	'value' => $vars['entity']->phpmailer_password,
	'class' => 'phpmailer-smtp phpmailer-smtp-auth elgg-input-natural mts',
));
echo '</div>';

 // ssl connection for smtp (with port info)
echo '<div>';
$checked = $vars['entity']->ep_phpmailer_ssl ? 'checked' : false;
echo elgg_view('input/checkbox', array(
	'name' => 'params[ep_phpmailer_ssl]',
	'value' => 1,
	'checked' => $checked,
	'default' => 0,
	'class' => 'phpmailer-smtp',
	'id' => 'phpmailer-ssl',
));
echo ' ' . elgg_echo('phpmailer:ssl') . '<br/>';

echo elgg_echo('phpmailer:protocol') . ':';
echo elgg_view('input/radio', array(
	'name' => 'params[ep_phpmailer_protocol]',
	'value' => $vars['entity']->ep_phpmailer_protocol,
	'options' => array(
		'SSL' => 'ssl',
		'TLS' => 'tls'
    )
));

echo elgg_echo('phpmailer:port') . ':';
echo elgg_view('input/text', array(
	'name' => 'params[ep_phpmailer_port]',
	'value' => $vars['entity']->ep_phpmailer_port,
	'class' => 'phpmailer-smtp phpmailer-ssl elgg-input-natural',
));

echo '</div>';
echo '</fieldset>';

// Non-standard MTA setting
echo '<div>';
$checked = $vars['entity']->nonstd_mta ? 'checked' : false;
echo elgg_view('input/checkbox', array(
	'name' => 'params[nonstd_mta]',
	'value' => 1,
	'checked' => $checked,
	'default' => 0,
));
echo ' ' . elgg_echo('phpmailer:nonstd_mta');
echo '</div>';

echo '<hr style="margin: 25px 0;" />';

// add bcc: field to all emails
echo '<div>';
$checked = $vars['entity']->phpmailer_bcc == 'enabled' ? 'checked' : false;
echo elgg_view('input/checkbox', array(
	'name' => 'params[phpmailer_bcc]',
	'value' => 'enabled',
	'checked' => $checked,
	'default' => 'disabled',
));
echo ' ' . elgg_echo('phpmailer:bcc') . '</div>';

echo '<fieldset class="elgg-border-plain mbm pas">';
echo '<div>';

echo elgg_echo('phpmailer:bcc_emails') . ':';
echo elgg_view('input/text', array(
	'name' => 'params[phpmailer_bcc_emails]',
	'value' => $vars['entity']->phpmailer_bcc_emails,
	'class' => 'phpmailer-smtp phpmailer-ssl elgg-input-natural',
));
echo '</div>';
echo '</fieldset>';

echo '<hr style="margin: 25px 0;" />';

// override to: field for testing
echo '<div>';
$checked = $vars['entity']->phpmailer_testing == 'enabled' ? 'checked' : false;
echo elgg_view('input/checkbox', array(
	'name' => 'params[phpmailer_testing]',
	'value' => 'enabled',
	'checked' => $checked,
	'default' => 'disabled',
));
echo ' ' . elgg_echo('phpmailer:testing') . '</div>';

echo '<fieldset class="elgg-border-plain mbm pas">';
echo '<div>';

echo elgg_echo('phpmailer:testing_email') . ':';
echo elgg_view('input/text', array(
	'name' => 'params[phpmailer_testing_email]',
	'value' => $vars['entity']->phpmailer_testing_email,
	'class' => 'phpmailer-smtp phpmailer-ssl elgg-input-natural',
));
echo '</div>';
echo '</fieldset>';

?>

<script type="text/javascript">
	$(document).ready(function() {
		phpmailer_form_update();

		$('#phpmailer-smtp').change(phpmailer_form_update);
		$('#phpmailer-smtp-auth').change(phpmailer_form_update);
		$('#phpmailer-ssl').change(phpmailer_form_update);
	});

	function phpmailer_form_update() {
		if ($('#phpmailer-ssl').attr('checked')) {
			$('.phpmailer-ssl').removeAttr('disabled');
		}
		if ($('#phpmailer-smtp-auth').attr('checked')) {
			$('.phpmailer-smtp-auth').removeAttr('disabled');
		}

		if (!$('#phpmailer-smtp').attr('checked')) {
			$('.phpmailer-smtp').attr('disabled', 'disabled');
		} else {
			$('.phpmailer-smtp').removeAttr('disabled');
		}

		if (!$('#phpmailer-smtp-auth').attr('checked')) {
			$('.phpmailer-smtp-auth').attr('disabled', 'disabled');
		}
		if (!$('#phpmailer-ssl').attr('checked')) {
			$('.phpmailer-ssl').attr('disabled', 'disabled');
		}
	}
</script>
