<?php
/*
 * index_2rbms.php
 * 
 * Short description of the file.
 * 
 * @package wet4
 * @author GCTools Team
 */

		$area1widgets = $vars['area1'];
		$area2widgets = $vars['area2'];
		$area3widgets = $vars['area3'];
		$layoutmode   = $vars['layoutmode']; //edit, index


?>
<div class="row">
    <div class="col-md-8 index-main" id="wb-cont">
        <?php custom_index_show_widget_area($area1widgets) ?>
    </div>


    <div class="col-md-4 pull-right">
        <?php custom_index_show_widget_area($area2widgets) ?>
    </div>
</div>

