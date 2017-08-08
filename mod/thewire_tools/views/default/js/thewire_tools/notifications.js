define(['jquery'], function($) {
	var cs_content = $('#thewire-tools-notification-settings tr:first').html();

	$('#notificationstable tr:last').after('<tr>' + cs_content + '</tr>');
	$('#thewire-tools-notification-settings').remove();
});