<?php
/**
 * View a friends collection
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['collection'] The individual friends collection
 */

$coll = $vars['collection'];

if (is_array($vars['collection']->members)) {
	$count = sizeof($vars['collection']->members);
} else {
	$count = 0;
}

echo "<li><h2 title='Colleague circle' tabIndex='0'>";

//as collections are private, check that the logged in user is the owner
if ($coll->owner_guid == elgg_get_logged_in_user_guid()) {
	echo "<div class=\"friends_collections_controls\">";

    echo elgg_view('output/url', array(
        'href' => 'collections/edit/' . elgg_get_logged_in_user_entity()->guid . '?collection=' . $coll->id,
        'text' => '<i class="fa fa-edit fa-2x icon-unsel"><span class="wb-inv">' . elgg_echo('edit:this') . '</span></i>',
        'title' => elgg_echo('friends:collections:edit') . ': ' . $coll->name,
        'class' => 'mrgn-rght-sm mrgn-tp-sm'
        ));

    echo elgg_view('output/url', array(
			'href' => 'action/friends/collections/delete?collection=' . $coll->id,
			'class' => 'delete_collection mrgn-rght-sm mrgn-tp-sm',
			'text' => '<span class="wb-invisible">' . elgg_echo("delete") . '</span><i class="fa fa-trash-o fa-2x icon-unsel"></i>',
            'title' => elgg_echo('delete') . ' ' . $coll->name,
			'encode_text' => false,
			'confirm' => true,
		));
    
    echo elgg_view('output/url', array(
			'href' => elgg_get_site_url() . 'messages/compose?collection=' . $coll->id,
			'class' => 'delete_collection',
			'text' => '<span class="wb-invisible">' . elgg_echo("send") . '</span><i class="fa fa-envelope-o fa-2x icon-unsel"></i>',
            'title' => elgg_echo('collections_circle_send') . ' ' . $coll->name,
			'encode_text' => false,
			'confirm' => true,
		));
	echo "</div>";
}
echo $coll->name;
echo " (<span id=\"friends_membership_count{$vars['friendspicker']}\">{$count}</span>) </h2>";

// individual collection panels
$friends = $vars['collection']->entities;
if ($friends) {
    /*
	$content = elgg_view('core/friends/collectiontabs', array(
		'owner' => elgg_get_logged_in_user_entity(),
		'collection' => $vars['collection'],
		'friendspicker' => $vars['friendspicker'],
	));
    */

	echo elgg_view('input/friendspicker', array(
		'entities' => $friends,
		'value' => $vars['collection']->members,
		'content' => $content,
		'replacement' => '',
		'friendspicker' => $vars['friendspicker'],
	));
?>
<?php //@todo JS 1.8: no ?>
	<script type="text/javascript">
	$(function () {

			$('#friends-picker_placeholder<?php echo $vars['friendspicker']; ?>').load(elgg.config.wwwroot + 'mod/wet4/pages/friends/collections/pickercallback.php?username=<?php echo elgg_get_logged_in_user_entity()->username; ?>&type=list&collection=<?php echo $vars['collection']->id; ?>');

	});
	</script>
	<?php
}

// close friends-picker div and the accordian list item
echo "</li>";

