<?php
	$gsa_pagination = elgg_get_plugin_setting('gsa_pagination','gc_fedsearch_gsa');
?>

<style>
.elgg-pagination {

	position: relative;
	right: <?php echo "{$gsa_pagination}%"; ?> !important;

}
</style>
 