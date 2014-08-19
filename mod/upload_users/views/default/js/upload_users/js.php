<?php if (FALSE) : ?><script type="text/javascript"><?php endif ?>
<?php
/**
 * Upload users javascript
 *
 * @package upload_users
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jaakko Naakka / Mediamaisteri Group
 * @author Ismayil Khayredinov / Arck Interactive
 * @copyright Mediamaisteri Group 2009
 * @copyright ArckInteractive 2013
 * @link http://www.mediamaisteri.com/
 * @link http://arckinteractive.com/
 */
?>
	elgg.provide('elgg.upload_users');

	elgg.upload_users.init = function() {

		$('#upload-users-map-form select[name^=header]').live('change', function() {

			if ($(this).val() == 'custom') {
				$(this).next('input').show();
			} else {
				$(this).next('input').hide();
			}

//			$('#upload-users-map-form select[name^=header] option').attr('disabled', false);
//
//			// loop each select and set the selected value to disabled in all other selects
//			$('#upload-users-map-form select[name^=header]').each(function() {
//				var $this = $(this);
//				$('#upload-users-map-form select[name^=header]').not($this).find('option').each(function() {
//					if ($(this).attr('value') == $this.val() && $(this).val() != 'custom')
//						$(this).attr('disabled', true);
//				});
//			});

		}).trigger('change');

		$('.upload-users-warning').live('click', function(e) {
			var confirmText = $(this).attr('rel') || elgg.echo('question:areyousure');
			if (!confirm(confirmText)) {
				e.preventDefault();
			}
		})
	};

	elgg.register_hook_handler('init', 'system', elgg.upload_users.init);
<?php if (FALSE) : ?></script><?php



 endif ?>