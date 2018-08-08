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

$lang = get_current_language();

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
<script>
var userid = '<?php echo elgg_get_logged_in_user_guid(); ?>';
document.cookie = "cc_data="+userid;
</script>
<head>
    <link type="text/css" href="https://comet.gccollab.ca/cometchatcss.php" rel="stylesheet" charset="utf-8">
    <script type="text/javascript" src="https://comet.gccollab.ca/cometchatjs.php" charset="utf-8"></script>
    <?php
        echo str_replace("_graphics/favicon", "_graphics/favicon-collab", $vars["head"]);
    ?>
</head>
<body<?php echo $attrs ?>>
    <?php echo $vars["body"]; ?>
    </body>
</html>
