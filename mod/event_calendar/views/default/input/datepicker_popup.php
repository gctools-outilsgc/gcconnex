<?php

/**
 * JQuery data picker
 * 
 * @package event_calendar
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Kevin Jardine <kevin@radagast.biz>
 * @copyright Radagast Solutions 2008
 * @link http://radagast.biz/
 * 
 */

if ($vars['dateformat']) {
	$date_format = $vars['dateformat'];
} else {
	$date_format = "yy/mm/dd";
}
?>

<script language="javascript">
$(document).ready(function(){
$("#<?php echo $vars['internalname']; ?>").datepicker({ 
    dateFormat: "<?php echo $date_format; ?>", 
    showOn: "both", 
    buttonImage: "<?php echo $vars['url']; ?>mod/event_calendar/images/calendar.gif", 
    buttonImageOnly: true 
})
});
</script>
<input type="text" size="30" value="<?php echo $vars['value']; ?>" name="<?php echo $vars['internalname']; ?>" id="<?php echo $vars['internalname']; ?>"/>