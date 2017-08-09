elgg.provide("elgg.group_tools");

elgg.group_tools.mail_form_submit = function() {
	var result = false;
	var error_msg = "";
	var error_count = 0;

	if ($('#group_tools_mail_member_selection input[name="user_guids[]"]:checked').length === 0) {
		error_msg += elgg.echo("group_tools:mail:form:js:members") + '\n';
		error_count++;
	}

	if ($(this).find('input[name="description"]').val() === "") {
		error_msg += elgg.echo("group_tools:mail:form:js:description") + '\n';
		error_count++;
	}

	if (error_count > 0) {
		alert(error_msg);
	} else {
		result = true;
	}

	return result;
};

elgg.group_tools.mail_clear_members = function() {
	$('#group_tools_mail_member_selection input[name="user_guids[]"]:checked').each(function() {
		$(this).prop('checked', false);
	});

	elgg.group_tools.mail_update_recipients();
};

elgg.group_tools.mail_all_members = function() {
	$('#group_tools_mail_member_selection input[name="user_guids[]"]').each(function() {
		$(this).prop('checked', true);
	});

	elgg.group_tools.mail_update_recipients();
};

elgg.group_tools.mail_update_recipients = function() {
	var count = $('#group_tools_mail_member_selection input[name="user_guids[]"]:checked').length;

	$('#group_tools_mail_recipients_count').html(count);
};

elgg.group_tools.init_mail = function() {
	// group mail members
	$(document).on("change", '#group_tools_mail_member_selection input[type=checkbox]', elgg.group_tools.mail_update_recipients);
	$('#group_tools_mail_form').submit(elgg.group_tools.mail_form_submit);
};

//register init hook
elgg.register_hook_handler("init", "system", elgg.group_tools.init_mail);
