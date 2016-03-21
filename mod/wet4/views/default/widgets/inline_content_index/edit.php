<?php 
	$widget_title = $vars['entity']->widget_title;
	$html_content = $vars['entity']->html_content;
	
	$guest_only = $vars['entity']->guest_only;
	if (!isset($guest_only)) $guest_only = "no";
	
	$box_style = $vars['entity']->box_style;
	if (!isset($box_style)) $box_style = "collapsable";

?>
<script>
    String.prototype.xsplit = function (_regEx) {
        // Most browsers can do this properly, so let them work, they'll do it faster
        if ('a~b'.split(/(~)/).length === 3) { return this.split(_regEx); }

        if (!_regEx.global)
        { _regEx = new RegExp(_regEx.source, 'g' + (_regEx.ignoreCase ? 'i' : '')); }

        // IE (and any other browser that can't capture the delimiter)
        // will, unfortunately, have to be slowed down
        var start = 0, arr = [];
        var result;
        while ((result = _regEx.exec(this)) != null) {
            arr.push(this.slice(start, result.index));
            if (result.length > 1) arr.push(result[1]);
            start = _regEx.lastIndex;
        }
        if (start < this.length) arr.push(this.slice(start));
        if (start == this.length) arr.push(''); //delim at the end
        return arr;
    };
    get_split_blocks = function (text) {
        var split_regex = /(<!--:[a-z]{2}-->|<!--:-->|\[:[a-z]{2}\]|\[:\]|\{:[a-z]{2}\}|\{:\})/gi; // @since 3.3.6 swirly brackets
        //alert(text.xsplit(split_regex));
        return text.xsplit(split_regex);
    }
    get_split_blocks('<?php echo $widget_title; ?>');
</script>

<p>
  <?php echo elgg_echo('custom_index_widgets:widget_title'); ?>:
  <?php
	echo elgg_view('input/text', array(
			'name' => 'params[widget_title]',                        
			'value' => gc_explode_translation($widget_title,'en')
		));
	?>
</p>
<p>
<?php echo elgg_echo('custom_index_widgets:html_content'); ?>	
<?php
	echo elgg_view('input/longtext', array(
			'name' => 'params[html_content]',                        
			'value' => gc_explode_translation($html_content,'en')
		));
	?>
</p>


<p>
      <?php echo elgg_echo('custom_index_widgets:box_style'); ?>
      :
      <?php
      echo elgg_view('input/dropdown', array('name'=>'params[box_style]', 
      										 'options_values'=>array('plain'=>'Plain', 'plain collapsable'=>'Plain and collapsable', 'collapsable'=>'Collapsable', 'standard' => 'No Collapsable'),
       										 'value'=>$box_style));
      ?>
</p>
<p>
      <?php echo elgg_echo('custom_index_widgets:guest_only'); ?>
      :
      <?php
      echo elgg_view('input/dropdown', array('name'=>'params[guest_only]', 
      										 'options_values'=>array('yes'=>'yes', 'no'=>'no'),
       										 'value'=>$guest_only));
      ?>
</p>