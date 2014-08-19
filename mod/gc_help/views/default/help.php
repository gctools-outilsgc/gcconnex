<?php
	/*******************************************************************************************
	 * help.php
	 * This file should hold the main contents of the help section of GCconnex. For the time being
	 * it will just point to GCpedia until content can be generated
	 * @package gc_help
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Troy Lawson
	 * @copyright 
	 */
	$body = elgg_echo("help:body");
	$message = elgg_echo("help:message");
	$url = elgg_echo("help:url");
	$desc =  elgg_echo("help:url-desc");
	$contactmsg = elgg_echo("help:contact")
?>
<div >
	<?php echo $body;?>
	<?php 
		//echo "<a href='$url'> $desc </a></br></br>"; 
		//echo $contactmsg. "<a href='mailto:GCCONNEX@tbs-sct.gc.ca'>GCCONNEX@tbs-sct.gc.ca</a>"
	?>
</div>