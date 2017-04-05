<?php

/**
 * Group edit form
 *
 * This view contains everything related to group access.
 * eg: how can people join this group, who can see the group, etc
 *
 * @package ElggGroups
 */

$entity = elgg_extract("entity", $vars, false);
$membership = elgg_extract("membership", $vars);
$visibility = elgg_extract("vis", $vars);
$owner_guid = elgg_extract("owner_guid", $vars);
$content_access_mode = elgg_extract("content_access_mode", $vars);

?>
<div>
	<label for="groups-membership"><?php echo elgg_echo("groups:membership"); ?></label><br />
	<?php echo elgg_view("input/select", array(
		"name" => "membership",
		"id" => "groups-membership",
		"value" => $membership,
		"options_values" => array(
			ACCESS_PRIVATE => elgg_echo("groups:access:private"),
			ACCESS_PUBLIC => elgg_echo("groups:access:public"),
		)
	));
	?>
</div>

<?php if (elgg_get_plugin_setting("hidden_groups", "groups") == "yes"): ?>
	<div>
		<label for="groups-vis"><?php echo elgg_echo("groups:visibility"); ?></label><br />
		<?php
		$visibility_options =  array(
			ACCESS_PRIVATE => elgg_echo("groups:access:group"),
			ACCESS_LOGGED_IN => elgg_echo("LOGGED_IN"),
			ACCESS_PUBLIC => elgg_echo("PUBLIC"),
		);
		if (elgg_get_config("walled_garden")) {
			unset($visibility_options[ACCESS_PUBLIC]);
		}
		
		echo elgg_view("input/access", array(
			"name" => "vis",
			"id" => "groups-vis",
			"value" => $visibility,
			"options_values" => $visibility_options,
			'entity' => $entity,
			'entity_type' => 'group',
			'entity_subtype' => '',
		));
		?>
	</div>
<?php endif; ?>

<?php

$access_mode_params = array(
	"name" => "content_access_mode",
	"id" => "groups-content-access-mode",
	"value" => $content_access_mode,
	"options_values" => array(
		ElggGroup::CONTENT_ACCESS_MODE_UNRESTRICTED => elgg_echo("groups:content_access_mode:unrestricted"),
		ElggGroup::CONTENT_ACCESS_MODE_MEMBERS_ONLY => elgg_echo("groups:content_access_mode:membersonly"),
	)
);

if ($entity) {
	// Disable content_access_mode field for hidden groups because the setting
	// will be forced to members_only regardless of the entered value
	if ($entity->access_id === $entity->group_acl) {
		$access_mode_params['disabled'] = 'disabled';
	}
}
?>
<script>
	var handleResponse = function (json) {
		var userOptions = '';
		$(json).each(function(key, user) {
			userOptions += '<li tabIndex="0" data-username="' + user.desc + '">' + user.icon + user.name + "</li>";
		});

		if (!userOptions) {
			$('#mentions-popup > .panel-body').html('<div class="elgg-ajax-loader"></div>');
			$('#mentions-popup').addClass('hidden');
			return;
		}

		$('#mentions-popup > .panel-body').html('<ul class="mentions-autocomplete list-unstyled mrgn-bttm-0">' + userOptions + "</ul>");
		$('.mentions-autocomplete .elgg-avatar a').attr('tabindex', '-1');
		$('#mentions-popup').removeClass('hidden');

		$('.mentions-autocomplete > li').bind('click', function(e) {
			e.preventDefault();

			var username = $(this).data('username');

			// Remove the partial @username string from the first part
			newBeforeMention = beforeMention.substring(0, position - current.length);

			// Add the complete @username string and the rest of the original
			// content after the first part
			var newContent = newBeforeMention + username + afterMention;

			// Set new content for the textarea
			if (mentionsEditor == 'ckeditor') {
				textarea.setData(newContent, function() {
					this.checkDirty(); // true
				});

			} else if (mentionsEditor == 'tinymce') {
				tinyMCE.activeEditor.setContent(newContent);
			} else {
				$(textarea).val(newContent);
			}

			// Hide the autocomplete popup
			$('#mentions-popup').addClass('hidden');
		});


        //ability to tab and press enter on the list item

		$('.mentions-autocomplete > li').bind('keypress', function (e) {

		        e.preventDefault();
		        if (e.keyCode == 13) {
		        var username = $(this).data('username');

		        // Remove the partial @username string from the first part
		        newBeforeMention = beforeMention.substring(0, position - current.length);

		        // Add the complete @username string and the rest of the original
		        // content after the first part
		        var newContent = newBeforeMention + username + afterMention;

		        // Set new content for the textarea
		        if (mentionsEditor == 'ckeditor') {
		            textarea.setData(newContent, function () {
		                this.checkDirty(); // true
		                this.focus();
		            });

		        } else if (mentionsEditor == 'tinymce') {
		            tinyMCE.activeEditor.setContent(newContent).focus();
		        } else {
		            $(textarea).val(newContent).focus();
		        }

		        // Hide the autocomplete popup
		        $('#mentions-popup').addClass('hidden');
		    }
		    });


	};

	var autocomplete = function (content, position) {
		var current = content;

		if (current.length > 1) {
			current = current.replace('@', '');
			//$('#mentions-popup').removeClass('hidden');

			var options = {success: handleResponse};

			elgg.get(elgg.config.wwwroot + 'livesearch?q=' + current + '&match_on=groupmems', options);
		} else {
			$('#mentions-popup > .panel-body').html('<div class="elgg-ajax-loader"></div>');
			$('#mentions-popup').addClass('hidden');
		}
	};

	var init = function() {
		$('owner_guid').bind('keyup', function(e) {

			// Hide on backspace and enter
			if (e.which == 8 || e.which == 13) {
				$('#mentions-popup > .panel-body').html('<div class="elgg-ajax-loader"></div>');
				$('#mentions-popup').addClass('hidden');
			} else {
				textarea = $(this);
				content = $(this).val();
				position = getCursorPosition(this);
				mentionsEditor = 'textarea';

				autocomplete(content, position);
			}
		});
	};

	init();
</script>
<div>
	<label for="groups-content-access-mode"><?php echo elgg_echo("groups:content_access_mode"); ?></label><br />
	<?php
		echo elgg_view("input/select", $access_mode_params);

		if ($entity && $entity->getContentAccessMode() == ElggGroup::CONTENT_ACCESS_MODE_UNRESTRICTED) {
			// Warn the user that changing the content access mode to more
			// restrictive will not affect the existing group content
			$access_mode_warning = elgg_echo("groups:content_access_mode:warning");
			echo "<span class='elgg-text-help'>$access_mode_warning</span>";
		}
	?>
</div>

<?php
if ($entity && ($owner_guid == elgg_get_logged_in_user_guid() || elgg_is_admin_logged_in())) {
	?>

	<div>
		<label for="groups-owner-guid"><?php echo elgg_echo("groups:owner"); ?></label><br />
		<?php
			echo elgg_view("input/text", array(
				"name" => "owner_guid",
				"id" => "groups-owner-guid",
				"value" =>  $owner_guid,
				"class" => "groups-owner-input",
			));
			echo elgg_view_module('popup', '', elgg_view('graphics/ajax_loader', array('hidden' => false)), array('class' => 'mentions-popup hidden','id' => 'mentions-popup'));		// group members popup

			if ($owner_guid == elgg_get_logged_in_user_guid()) {
				echo "<span class='elgg-text-help'>" . elgg_echo("groups:owner:warning") . "</span>";
			}
		?>
	</div>
<?php
}
