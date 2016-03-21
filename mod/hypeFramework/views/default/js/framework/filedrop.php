<?php if (FALSE) : ?>
	<script type="text/javascript">
<?php endif; ?>

	elgg.provide('framework');
	elgg.provide('framework.filedrop');

	framework.filedrop.init = function() {

		$('.filedrop-fallback-clone')
		.live('click', function(e) {
			e.preventDefault();
			$clone = $(this).closest('.filedrop-fallback').find('.filedrop-fallback-template:first').clone();
			$(this).before($clone.removeClass('filedrop-fallback-template').removeClass('hidden'));
			$clone.trigger('click');
		});
		
		$('[data-toggle="filedrop"]')
		.each(function() {

			var $container = $(this);

			var $filedrop = $('.filedrop', $container),
			$filedropfallback = $('.filedrop-fallback', $container),
			$message = $('.filedrop-message', $filedrop);

			$filedrop.filedrop({

				url: elgg.security.addToken(elgg.normalize_url('action/framework/file/temp')),              // upload handler, handles each file separately, can also be a function returning a url
				paramname: 'file_temp',          // POST parameter name used on serverside to reference file
				headers: {          // Send additional request headers
					'X-Requested-With': 'XMLHttpRequest'
				},

				//allowedfiletypes: ['image/jpg', 'image/jpeg','image/png','image/gif'],   // filetypes allowed by Content-Type.  Empty array means no restrictions
				allowedfiletypes : $filedrop.data('allowedfiletypes'),
				queuefiles: 1,

				uploadFinished:function(i, file, response){

					$.data(file).addClass('elgg-state-complete');

					var hookParams = new Object();
					hookParams.response = response;
					hookParams.element = $filedrop;

					$.each(response.output, function(name, guid) {
						$filedrop.append($('<input>', {type:'hidden', name : 'uploads[]', value : guid}));
					});

					if ($filedrop.data('callback')) {
						var hook = $filedrop.data('callback').split('::');
						elgg.trigger_hook(hook[0], hook[1], hookParams);
					}
					
				},

				error: function(err, file) {
					switch(err) {
						case 'BrowserNotSupported':
							elgg.register_error(elgg.echo('hj:framework:filedrop:browsernotsupported'));
							$filedrop.hide();
							//$filedropfallback.show();
							break;

						case 'FileTypeNotAllowed':
							elgg.register_error(elgg.echo('hj:framework:filedrop:filetypenotallowed'));
							break;

						default:
							break;
					}
				},

				// Called before each upload is started
				beforeEach: function(file){
				},

				uploadStarted:function(i, file, len){
					if(file.type.match(/^image\//)){
						framework.filedrop.createImage(file, $container);
					} else {
						framework.filedrop.createPlaceholder(file, $container);
					}
				},

				progressUpdated: function(i, file, progress) {
					$.data(file).find('.filedrop-progress').width(progress);
				}

			});
		})

	}

	framework.filedrop.template = '<div class="filedrop-preview">'+
		'<span class="filedrop-imageholder">'+
		'<img />'+
		'<span class="elgg-state-uploaded"></span>'+
		'</span>'+
		'<div class="filedrop-progressholder">'+
		'<div class="filedrop-progress"></div>'+
		'</div>'+
		'</div>';


	framework.filedrop.createImage = function(file, $container){

		var preview = $(framework.filedrop.template),
		image = $('img', preview);

		var reader = new FileReader();

		image.width = 100;
		image.height = 100;

		reader.onload = function(e){

			// e.target.result holds the DataURL which
			// can be used as a source of the image:

			image.attr('src',e.target.result);
		};

		// Reading the file as a DataURL. When finished,
		// this will trigger the onload function above:
		reader.readAsDataURL(file);

		$('.filedrop-message', $container).hide();
		preview.appendTo($('.filedrop', $container));

		// Associating a preview container
		// with the file, using jQuery's $.data():

		$.data(file,preview);
	}

	framework.filedrop.createPlaceholder = function(file, $container){

		var preview = $(framework.filedrop.template),
		image = $('img', preview);

		var reader = new FileReader();

		image.width = 100;
		image.height = 100;
			
		image.attr('src', elgg.get_site_url() + 'mod/hypeFramework/graphics/filedrop/background_tile_1.jpg');

		reader.readAsDataURL(file);

		$('.filedrop-message', $container).hide();
		preview.appendTo($('.filedrop', $container));

		$.data(file, preview);
	}

	elgg.register_hook_handler('init', 'system', framework.filedrop.init);

<?php if (FALSE) : ?></script><?php
endif;
?>
