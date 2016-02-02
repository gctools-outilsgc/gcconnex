<?php
/**
 * Search box
 *
 * @uses $vars['value'] Current search query
 * @uses $vars['class'] Additional class
 */

$value = "";
if (array_key_exists('value', $vars)) {
	$value = $vars['value'];
} elseif ($value = get_input('q', get_input('tag', NULL))) {
	$value = $value;
}

$class = "elgg-search";
if (isset($vars['class'])) {
	$class = "$class {$vars['class']}";
}

// @todo - create function for sanitization of strings for display in 1.8
// encode <,>,&, quotes and characters above 127
if (function_exists('mb_convert_encoding')) {
	$display_query = mb_convert_encoding($value, 'HTML-ENTITIES', 'UTF-8');
} else {
	// if no mbstring extension, we just strip characters
	$display_query = preg_replace("/[^\x01-\x7F]/", "", $value);
}

// render placeholder separately so it will double-encode if needed
$placeholder = htmlspecialchars(elgg_echo('search'), ENT_QUOTES, 'UTF-8');

$search_attrs = elgg_format_attributes(array(
	'type' => 'text',
	'class' => 'search-input',
	'size' => '21',
	'name' => 'q',
	'autocapitalize' => 'off',
	'autocorrect' => 'off',
	'required' => true,
	'value' => $display_query,
));
?>
<!-- Basically just moved the search to this file to output the section -->
            <section id="wb-srch" class="col-xs-6 text-right visible-md visible-lg">
                <h2><?php echo elgg_echo('wet:searchHead');?></h2>
                <form action="<?php echo elgg_get_site_url(); ?>search" method="get" name="cse-search-box" role="search" class="form-inline mrgn-bttm-sm">
                    <div class="form-group">
            <label for="wb-srch-q" class="wb-inv">
                <?php echo elgg_echo('wet:searchweb');?>
            </label>
            <input id="wb-srch-q" list="wb-srch-q-ac" class="wb-srch-q form-control" name="q" type="search" value="" size="27" maxlength="150" placeholder="<?php echo elgg_echo('wet:searchgctools');?>">
                        <datalist id="wb-srch-q-ac">
                            <!--[if lte IE 9]><select><![endif]-->
                            <!--[if lte IE 9]></select><![endif]-->
                        </datalist>
                    </div>
                    <div class="form-group submit">
            <button type="submit" id="wb-srch-sub" class="btn btn-primary btn-small" name="wb-srch-sub">
                <span class="glyphicon-search glyphicon"></span>
                <span class="wb-inv">
                    <?php echo elgg_echo('wet:searchHead');?>
                </span>
            </button>
                    </div>
                </form>
            </section>
