<?php
/**
 * This view displays and renders the Search box on the top of every page on GCconnex
 *
 * @uses $vars['value'] Current search query
 * @uses $vars['class'] Additional class
 */

$placeholder = elgg_echo('wet:searchgctools');
?>

<!-- Basically just moved the search to this file to output the section -->
<section id="wb-srch" class="text-right visible-md visible-lg">
    <h2> <?php echo elgg_echo('wet:searchHead'); ?> </h2>
    <form action="<?php echo elgg_get_site_url(); ?>search" name="cse-search-box" class="form-inline">
        <div class='form-group'>
            <label for="wb-srch-q" class="wb-inv"> <?php echo elgg_echo('wet:searchweb'); ?> </label>
            <input type="text" class="wb-srch-q form-control" name="q" value="" size="21" maxlength="150" placeholder="<?php echo $placeholder ?>" id="wb-srch-q">
            
            <input type="hidden" id="a" name="a"  value="s">
            <input type="hidden" id="s" name="s"  value="3">
            <input type="hidden" id="chk4" name="chk4"  value="on">
        </div>
        <div class="form-group submit">
            <!-- search button -->
            <button type="submit" class="btn btn-primary btn-small" name="wb-srch-sub">
                <span class="glyphicon-search glyphicon"></span>
                <span class="wb-inv"> <?php echo elgg_echo('wet:searchHead'); ?> </span>
            </button>
        </div>
    </form>
</section>