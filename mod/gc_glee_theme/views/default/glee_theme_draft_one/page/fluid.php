<?php
/**
 * Elgg pageshell
 * The standard HTML page shell that everything else fits into
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['title']       The page title
 * @uses $vars['body']        The main content of the page
 * @uses $vars['sysmessages'] A 2d array of various message registers, passed from system_messages()
 */

// backward compatability support for plugins that are not using the new approach
// of routing through admin. See reportedcontent plugin for a simple example.
if (elgg_get_context() == 'admin') {
    elgg_deprecated_notice("admin plugins should route through 'admin'.", 1.8);
    elgg_admin_add_plugin_settings_menu();
    elgg_unregister_css('elgg');
    echo elgg_view('page/admin', $vars);
    return true;
}

// render content before head so that JavaScript and CSS can be loaded. See #4032
$topbar = elgg_view('page/elements/topbar', $vars);
$messages = elgg_view('page/elements/messages', array('object' => $vars['sysmessages']));
$header = elgg_view('page/elements/header', $vars);
$body = elgg_view('page/elements/body', $vars);
$footer = elgg_view('page/elements/footer', $vars);

// Set the content type
header("Content-type: text/html; charset=UTF-8");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<?php echo elgg_view('page/elements/head', $vars); ?>

<style type="text/css">
  body {
    padding-bottom: 40px;
  }
</style>
    
</head>
<body>
	<div class="elgg-page-messages">
	    <?php echo $messages; ?>
	</div>
	
	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container-fluid">
			    <?php echo $topbar; ?>
			</div>
		</div>
	</div>

	<div class="container-fluid elgg-page elgg-page-default">
		<div class="row-fluid">
			<div class="span3">
				<div class="glee-draft-one-logo">
    				<?php 
                        echo elgg_view('glee_theme_draft_one/output/site_logo');
                    ?>
				</div>
				<div class="well sidebar-nav">
    				<?php 
    				    // insert site-wide navigation
                        echo elgg_view_menu('site',  array('sort_by' => 'priority'));
                    ?>
				</div>
			</div>
			<div class="span9">
			    <div class="page-header elgg-page-header">
			    	<div class="elgg-inner">
                        <?php echo $header; ?>
					</div>
                </div>		
				
				<div class="row-fluid">
					<div class="elgg-page-body">
						<div class="elgg-inner">
					        <?php echo $body; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="elgg-page-footer">
			<div class="elgg-inner">
			    <?php echo $footer; ?>
			</div>
		</div>	
	</div>
	
	<div class="hidden" id='gleeModalContainer'></div>
	
<?php echo elgg_view('page/elements/foot'); ?>

<link type="text/css" href="/cometchat/cometchatcss.php" rel="stylesheet" charset="utf-8">
<script type="text/javascript" src="/cometchat/cometchatjs.php" charset="utf-8"></script>
<script type="text/javascript" src="/angelfish.js"></script>
<script type="text/javascript">
    agf.pageview();
</script>
</body>
</html>
