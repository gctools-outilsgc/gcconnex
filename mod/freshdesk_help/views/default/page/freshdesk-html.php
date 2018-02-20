<?php
/**
 * html.php
 *
 * Page shell for all HTML pages
 *
 * @package wet4
 * @author GCTools Team
 *
 *
 * @uses $vars['head']        Parameters for the <head> element
 * @uses $vars['body_attrs']  Attributes of the <body> tag
 * @uses $vars['body']        The main content of the page
 *
 * GC_MODIFICATION
 * Description: Added WET specific html elements to the page
 */


// Set the content type
header("Content-type: text/html; charset=UTF-8");

$lang = get_input('lang');
if(!$lang){ $lang = get_current_language(); }

$attrs = " vocab='https://schema.org/' typeof='WebPage'";
if (isset($vars['body_attrs'])) {
	$attrs = elgg_format_attributes($vars['body_attrs']);
	if ($attrs) {
		$attrs = " $attrs";
	}
}
?>
<!DOCTYPE html><!--[if lt IE 9]><html class="no-js lt-ie9" lang="<?php echo $lang; ?>" dir="ltr"><![endif]--><!--[if gt IE 8]><!-->
<html class="no-js" lang="<?php echo $lang; ?>" dir="ltr">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<!--<![endif]-->
<head>
    <link type="text/css" href="/cometchat/cometchatcss.php" rel="stylesheet" charset="utf-8">
    <script type="text/javascript" src="/cometchat/cometchatjs.php" charset="utf-8"></script>
    <?php echo $vars["head"]; ?>
</head>
<body<?php echo $attrs ?>>
    <?php echo $vars["body"]; ?>
    </body>
</html>
