<?php 
	$file_count = sanitise_int($vars["entity"]->file_count);
	if(empty($file_count)){
		$file_count = 4;
	}
?>
<div>
	<?php 
		echo elgg_echo("file:num_files"); 
		echo elgg_view("input/dropdown", array("name" => "params[file_count]", "options" => range(1, 10), "value" => $file_count));
	?>
</div>