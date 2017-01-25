define(function(require) {
	var elgg = require("elgg");
	var $ = require("jquery");

	function init() {
		active = false;
		$('[rel=photo-tagging]').click(function(event) {
			start(event);
		});

		$('#tidypics-tagging-quit').click(function(event) {
			stop(event);
		});

		tagPosition();

		tag_hover = false;
		toggleTagHover();
	}

	function start(event) {
		if (active) {
			stop(event);
			return;
		}

		makeUnClickable();

		$('.tidypics-photo').imgAreaSelect( {
			disable      : false,
			hide         : false,
			classPrefix  : 'tidypics-tagging',
			onSelectEnd  : function(img, selection) {
				startSelect(img, selection);
			},
			onSelectStart: function() {
				$('#tidypics-tagging-select').hide();
			}
		});

		toggleTagHover();

		$('.tidypics-photo').css({"cursor" : "crosshair"});

		$('#tidypics-tagging-help').toggle();

		active = true;

		event.preventDefault();
	}

	function stop(event) {
		$('#tidypics-tagging-help').toggle();
		$('#tidypics-tagging-select').hide();

		$('.tidypics-photo').imgAreaSelect({hide: true, disable: true});
		$('.tidypics-photo').css({"cursor" : "pointer"});

		active = false;
		toggleTagHover();

		makeClickable();

		event.preventDefault();
	}

	function startSelect(img, selection) {
		if(selection.width < 2 && selection.height < 2) {
			return;
		}

		var coords  = '"x1":"' + selection.x1 + '",';
		coords += '"y1":"' + selection.y1 + '",';
		coords += '"width":"' + selection.width + '",';
		coords += '"height":"' + selection.height + '"';
		$("input[name=coordinates]").val(coords);

		$('#tidypics-tagging-select').show().css({
			'top' : selection.y2 + 10,
			'left' : selection.x2
		}).find('input[type=text]').focus();
	}

	function tagPosition() {
		$('.tidypics-tag').each(function() {
			var tag_left = parseInt($(this).data('x1'));
			var tag_top = parseInt($(this).data('y1'));
			var tag_width = parseInt($(this).data('width'));
			var tag_height = parseInt($(this).data('height'));

			// add image offset
			var image_pos = $('.tidypics-photo').position();
			tag_left += image_pos.left;
			tag_top += image_pos.top;

			$(this).parent().css({
				left: tag_left + 'px',
				top: tag_top + 'px' /*
				width: tag_width + 'px',
				height: tag_height + 'px' */
			});

			$(this).css({
				width: tag_width + 'px',
				height: tag_height + 'px'
			});
		});
	}

	function toggleTagHover() {
		if (tag_hover == false) {
			$('.tidypics-photo').hover(function() {
				$('.tidypics-tag-wrapper').show();
				}, function(event) {
					// this check handles the tags appearing over the image
					var mouseX = event.pageX;
					var mouseY = event.pageY;
					var offset = $('.tidypics-photo').offset();
					var width = $('.tidypics-photo').outerWidth() - 1;
					var height = $('.tidypics-photo').outerHeight() - 1;

					mouseX -= offset.left;
					mouseY -= offset.top;

					if (mouseX < 0 || mouseX > width || mouseY < 0 || mouseY > height) {
						$('.tidypics-tag-wrapper').hide();
					}
				}
			);
		} else {
			$('.tidypics-photo').hover(
				function() {
					$('.tidypics-tag-wrapper').hide();
				}, function() {
					$('.tidypics-tag-wrapper').hide();
				}
			);
		}
		tag_hover = !tag_hover;
	}
	
	function makeUnClickable() {
		$('.tidypics-lightbox').each(function () {
			$(this).data('href', $(this).attr('href'));
			$(this).removeAttr('href');
		});
		$(".tidypics-lightbox").colorbox.remove();
	}
	
	function makeClickable() {
		$('.tidypics-lightbox').each(function () {
			$(this).attr('href', $(this).data('href'));
		});
		if ($(".tidypics-lightbox").length) {
			$(".tidypics-lightbox").colorbox({photo:true, maxWidth:'95%', maxHeight:'95%'});
		}
	}

	init();
});
