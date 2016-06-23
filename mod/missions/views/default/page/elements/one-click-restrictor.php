<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
 
/*
 * Script which prevents the given element from being reclicked and sets the cursor to a spinner.
 */
?>

<script>
	document.getElementById('<?php echo $vars['restricted_element_id'];?>').onclick = function() {
		document.body.style.cursor = 'wait';
		this.disabled = true;
		this.form.submit();
	}
</script> 