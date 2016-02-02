<?php
/**
 * Elgg friends collections
 * Lists a user's friends collections
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['collections'] The array of friends collections
 */

$friendspicker = $vars['friendspicker'];

$collectionid = $vars['collection']->id;
$ownerid = $vars['owner']->getGUID();

?>

<ul class="nav nav-tabs">
	<li class="active">
		<a href="#" class="collectionmembers<?php echo $friendspicker; ?>">
			<?php echo elgg_echo('friends:collections:members'); ?>
		</a>
	</li>
	<li>
		<a href="#" class="editmembers<?php echo $friendspicker; ?>">
			<?php echo elgg_echo('friends:collections:edit'); ?>
		</a>
	</li>
</ul>

<?php //@todo JS 1.8: no ?>
<script type="text/javascript">
$(function () {

	$('a.collectionmembers<?php echo $friendspicker; ?>').click(function () {
		// load collection members pane
	    $('#friends-picker_placeholder<?php echo $friendspicker; ?>').load('<?php echo elgg_get_site_url(); ?>mod/wet4/pages/friends/collections/pickercallback.php?username=<?php echo elgg_get_logged_in_user_entity()->username; ?>&type=list&collection=<?php echo $collectionid; ?>&friendspicker=<?php echo $friendspicker; ?>');

		// remove selected state from previous tab
		$(this).parent().parent().find("li.active").removeClass("active");
		// add selected class to current tab
		$(this).parent().addClass("active");


		return false;
	});

	$('a.editmembers<?php echo $friendspicker; ?>').click(function () {
		// load friends picker pane
		$('#friends-picker_placeholder<?php echo $friendspicker; ?>').load('<?php echo elgg_get_site_url(); ?>mod/wet4/pages/friends/collections/pickercallback.php?username=<?php echo elgg_get_logged_in_user_entity()->username; ?>&type=picker&collection=<?php echo $collectionid; ?>&friendspicker=<?php echo $friendspicker; ?>');

		// remove selected state from previous tab
	    $(this).parent().parent().find("li.active").removeClass("active");
		// add selected class to current tab
	    $(this).parent().addClass("active");

	    return false;
	});


});
</script>
