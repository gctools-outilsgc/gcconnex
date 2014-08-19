<?php
/**
 * Search by email domain
 */
?>
<div id="search-box">
	<form action="<?php echo current_page_url() ?>" method="get">
	<b>Search by email domain</b>
	<?php

		echo elgg_view('input/text', array('name' => 'domain'));

	?>
	<input type="submit" value="Search by domain" />
	</form>
</div>
