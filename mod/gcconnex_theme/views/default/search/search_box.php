<?php

/**
 * This view displays and renders the Search box on the top of every page on GCconnex
 *
 * @uses $vars['value'] Current search query
 * @uses $vars['class'] Additional class
 */

$value = "";
if (array_key_exists('value', $vars)) {
	$value = $vars['value'];
} elseif ($value = get_input('q', get_input('tag', null))) {
	$value = $value;
}

$class = "elgg-search";
if (isset($vars['class'])) {
	$class = "$class {$vars['class']}";
}

$placeholder = elgg_echo('wet:searchgctools');
$gc_language = $_COOKIE['lang'];
$selected_language = ($gc_language === '' || $gc_language === 'en' || !$gc_language) ? 'eng' : 'fra';

?>


<script>
	/// using javascript function to send the query and params to the intranet (gsa) to resolve the encoding issue
	function submit_search_query(selected_language) {

		var url = "http://intranet.canada.ca/search-recherche/query-recherche-" + selected_language + ".aspx";
		var encode_url = url + "?" + "q=" + escape(document.getElementById('wb-srch-q').value) + "&a=" + document.getElementById('a').value + "&s=" + document.getElementById('s').value + "&chk4=" + document.getElementById('chk4').value;
		document.location.href = encode_url;
	}

	/// this will handle the enter key pressed when user does a search
	function handleKeyPress(e) {
		var key = e.keyCode || e.which;
		if (key == 13) {
			submit_search_query('<?php echo $selected_language; ?>');
		}
	}
</script>

<!-- Basically just moved the search to this file to output the section -->

<section id="wb-srch" class="col-sm-4 col-lg-3 text-right visible-md visible-lg">
	<h2> <?php echo elgg_echo('wet:searchHead'); ?> </h2>
	<div name="cse-search-box" class='form-inline'>
		<div class='form-group'>
			<label for="wb-srch-q" class="wb-inv"> <?php echo elgg_echo('wet:searchweb'); ?> </label>
			<input class="wb-srch-q form-control" name="q" onkeypress="handleKeyPress(event)" value="" size="21" maxlength="150" placeholder="<?php echo $placeholder ?>" id="wb-srch-q">
			<input type="hidden" id="a" name="a" value="s">
			<input type="hidden" id="s" name="s" value="1">
			<input type="hidden" id="chk4" name="chk4" value="on">
		</div>
		<div class="form-group submit">
			<!-- search button -->
			<button type="button" class="btn-small" onclick="submit_search_query('<?php echo $selected_language; ?>')" name="wb-srch-sub">
					<span class="glyphicon-search glyphicon"></span>
					<span class="wb-inv"> <?php echo elgg_echo('wet:searchHead'); ?> </span>
				</button>
		</div>
	</div>
</section>
