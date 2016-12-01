<?php
/**
 * Elgg friends collections
 * Lists a user's friends collections
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['collections'] The array of friends collections
 *
 * GC_MODIFICATION
 * Description: Added wet styling and classes 
 * Author: GCTools Team
 */

if (is_array($vars['collections']) && sizeof($vars['collections'])) {
	echo "<ul id=\"friends_collections_accordian\" class=\"list-unstyled\">";

	$friendspicker = 0;
	foreach ($vars['collections'] as $collection) {
		$friendspicker++;
		echo elgg_view('core/friends/collection', array(
			'collection' => $collection,
			'friendspicker' => $friendspicker,
		));
	}

	echo "</ul>";

} else {
	echo elgg_echo("friends:nocollections");
}

?>
<?php //@todo JS 1.8: no ?>
<script>
$(function(){
    $('#friends_collections_accordian h2').click(function () {

		$(this.parentNode).children("[class=friends-picker-main-wrapper]").slideToggle("fast");
		//return false;
	});

	$('#friends_collections_accordian h2').bind('keyup', function (e) {

	    if (e.keyCode === 13) { // 13 is enter key

	        $(this.parentNode).children("[class=friends-picker-main-wrapper]").slideToggle("fast");

	    }

	});
});
</script>
