<?php
		$area1widgets = $vars['area1'];
		$area2widgets = $vars['area2'];
		$area3widgets = $vars['area3'];
		$layoutmode   = $vars['layoutmode']; //edit, index

/*
    <table cellspacing="10" cellpadding="10" width="100%" class="<?php echo elgg_echo($layoutmode); ?> red">
      <tr>
        <td colspan="2" align="left" valign="top" class="big">
              <div id="leftcolumn_widgets" class="big_<?php echo elgg_echo($layoutmode); ?>_box">
              <?php custom_index_show_widget_area($area1widgets) ?>
              </div>
        </td>
      </tr>
      <tr>
        <td align="left" valign="top" class="medium">
              <div id="middlecolumn_widgets" class="medium_<?php echo elgg_echo($layoutmode); ?>_box">
              <?php custom_index_show_widget_area($area2widgets) ?>
              </div>
        </td>
	  	<td  align="left" valign="top" class="small">
              <div id="rightcolumn_widgets" class="small_<?php echo elgg_echo($layoutmode); ?>_box">
              <?php custom_index_show_widget_area($area3widgets) ?>
              </div>
        </td>
      </tr>
    </table>
*/
?>

<div class="col-md-8" id="wb-cont">
<?php custom_index_show_widget_area($area1widgets) ?>
</div>


<div class="col-md-4">
<?php custom_index_show_widget_area($area2widgets) ?>
</div>


