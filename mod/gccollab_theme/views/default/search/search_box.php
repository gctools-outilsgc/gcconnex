<?php
/**
 * This view displays and renders the Search box on the top of every page on GCconnex
 *
 * @uses $vars['value'] Current search query
 * @uses $vars['class'] Additional class
 */

$placeholder = elgg_echo('wet:searchgctools');
?>

<!-- <input type="text" class="wb-srch-q form-control" name="q" value="" size="21" maxlength="150" placeholder="<?php echo $placeholder ?>" id="wb-srch-q">--> 

<form action="<?php echo elgg_get_site_url(); ?>search" name="cse-search-box">
    <div>
        <label for="wb-srch-q" class="wb-inv"> <?php echo elgg_echo('wet:searchweb'); ?> </label>
        <div class="collapse " id="collapseSearch"> <div class="well" aria-label="Search GCcollab">
            <?php
                echo elgg_view('input/text', array(
                    'id' => 'tagSearch',
                    'name' => 'tag',
                    'class' => 'elgg-input-search mbm',
                    'placeholder' => elgg_echo('wet:searchgctools'),
                    'required' => true
                ));
            ?>
        </div></div>
        <input type="hidden" id="a" name="a"  value="s">
        <input type="hidden" id="s" name="s"  value="3">
        <input type="hidden" id="chk4" name="chk4"  value="on">
    </div>
</form>