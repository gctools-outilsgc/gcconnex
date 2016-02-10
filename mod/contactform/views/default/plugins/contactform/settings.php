<?php 
$email = $vars['entity']->email;
$loginreq = $vars['entity']->loginreq;
if (!$loginreq) { $loginreq = 'yes'; }		
?>

<p>
<?php
echo elgg_echo('contactform:enteremail');
echo elgg_view('input/text', array(
    'name'  => 'params[email]',
    'value' => $email,
));
echo "<div>";
	echo elgg_echo('contactform:loginreqmsg') . ' ';
	echo elgg_view('input/dropdown', array(
		'name' => 'params[loginreq]',
		'options_values' => array(
			'no' => elgg_echo('contactform:no'),
			'yes' => elgg_echo('contactform:yes'),
		),
		'value' => $loginreq,
	));
echo "</div>";
?>
