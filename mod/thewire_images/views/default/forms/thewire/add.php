<?php
/**
 * Wire add form body
 *
 * @uses $vars["post"]
 */

$previewContainer = ".preview-zone";

if( elgg_is_xhr() ){
	$site = elgg_get_site_entity();
	echo '<script type="text/javascript" src="'.$site->getURL().'mod/thewire_images/js/dropzone.js"></script>';

	echo '<link rel="stylesheet" type="text/css" href="/mod/thewire_images/css/dropzone.css">';

	$previewContainer = "#previewZone";
	$previewID = 'previewZone';
}

elgg_load_js("elgg.thewire");
elgg_load_js("dropzone");
elgg_load_css("dropzone");

$post = elgg_extract("post", $vars);
$char_limit = thewire_tools_get_wire_length();
$reshare = elgg_extract("reshare", $vars); // for reshare functionality
$lang = get_current_language();

$text = elgg_echo("post");
if ($post) {
	$text = elgg_echo("reply");
}
$chars_left = elgg_echo("thewire:charleft");

$parent_input = "";
if ($post) {
	$parent_input = elgg_view("input/hidden", array(
		"name" => "parent_guid",
		"value" => $post->guid,
	));
}

$reshare_input = "";
$post_value = "";
if (!empty($reshare)) {
	$reshare_input = elgg_view("input/hidden", array(
		"name" => "reshare_guid",
		"value" => $reshare->getGUID()
	));

    //display warning to user if resharing content that is not public on the wire
	$reshare_input .= elgg_view("thewire_tools/reshare_source", array("entity" => $reshare));

    //see if entity is within a group
    $owner = $reshare->getContainerEntity();

        //check access mode of group
        if(elgg_instanceof($owner, "group") && $owner->getContentAccessMode() == 'members_only'){

            echo '<div class="alert alert-warning">
            <p>' . elgg_echo('thewire:contentwarning') . '</p>
            <p>' . elgg_echo('thewire:groupwarning') . '<b><i>' . $owner->name . '</i></b></p>
            </div>';

        } else if($reshare->access_id != 2){

            $access = elgg_view('output/access', array(
                'name' => 'access',
                'entity' => $reshare,
                ));

            echo '<div class="alert alert-warning">
            <p>' . elgg_echo('thewire:contentwarning') . '</p>
            <p>' . elgg_echo('thewire:userwarning') . '<b><i>' . $access . '</i></b></p>
            </div>';
        }

if(!empty($reshare->title))
	$post_value = gc_explode_translation($reshare->title,$lang);
elseif (!empty($reshare->name))
	$post_value = gc_explode_translation($reshare->name,$lang);
elseif (!empty($reshare->description))
	$post_value = gc_explode_translation(elgg_get_excerpt($reshare->description, 140),$lang);
}

$count_down = "<p><span>$char_limit</span> $chars_left</p>";
$num_lines = 2;
if ($char_limit == 0) {
	$num_lines = 3;
	$count_down = "";
} else if ($char_limit > 140) {
	$num_lines = 3;
}

$post_input = elgg_view("input/plaintext", array(
	"name" => "body",
    "id" => "wire-body",
	"class" => "mts thewire-textarea form-control",
	"rows" => $num_lines,
	"value" => htmlspecialchars_decode($post_value, ENT_QUOTES),
	"data-max-length" => $char_limit,
	"aria-describedby" => 'charCount',
	"required" => "required",
	"placeholder" => elgg_echo('thewire_image:form:dragdrop')
));

$submit_button = elgg_view("input/submit", array(
	"value" => $text,
	"class" => "btn btn-primary mls thewire-submit-button only-one-click",
));

$mentions = "";
$access_input = "";
if (thewire_tools_groups_enabled()) {

	if ($post) {
		$access_input = elgg_view("input/hidden", array("name" => "access_id", "value" => $post->access_id));
	} else {
		$page_owner_entity = elgg_get_page_owner_entity();

		if ($page_owner_entity instanceof ElggGroup) {
			// in a group only allow sharing in the current group
			$access_input = elgg_view("input/hidden", array("name" => "access_id", "value" => $page_owner_entity->group_acl));
			$mentions = "<div class='elgg-subtext mbn'>" . elgg_echo("thewire_tools:groups:mentions") . "</div>";
		} else {
			$params = array(
				"name" => "access_id"
			);

			if (elgg_in_context("widgets")) {
				$params["class"] = "thewire-tools-widget-access";
			}

			elgg_push_context("thewire_add");
			$access_input = elgg_view("input/access", $params);
			elgg_pop_context();
		}
	}
}
$createWire = elgg_echo('thewire:post');

echo <<<HTML
	$reshare_input
    <label for="wire-body">$createWire</label>
	$post_input
	$mentions
<div class="elgg-foot mts">
	<div id="charCount" class="pull-right thewire-characters-remaining">
		$count_down
	</div>
	<div class="add-image pull-left"></div>

	<div id="$previewID" class="preview-zone col-xs-12 mrgn-tp-sm dropzone-previews"></div>
	<div class="text-right col-xs-12">
		$submit_button
	</div>
	$parent_input
	$access_input
</div>
HTML;

$site = strtolower(elgg_get_site_entity()->name);
?>

<script type="text/javascript">
$(document).ready(function() {
	Dropzone.autoDiscover = false;
	var instance = $(".elgg-form-thewire-add:not(.dropzone)").addClass('dropzone <?php echo $site; ?>').get(0);

	var defaultMessage = "<?php echo elgg_echo('thewire_image:form:default'); ?>";
	var removeFile = "<?php echo elgg_echo('thewire_image:form:removefile'); ?>";
	var maxFilesExceeded = "<?php echo elgg_echo('thewire_image:form:maxfilesexceeded'); ?>";
	var invalidFileType = "<?php echo elgg_echo('thewire_image:form:invalidfile'); ?>";
	var fileTooBig = "<?php echo elgg_echo('thewire_image:form:filetoobig'); ?>";
	var maxFileSize = 2; // Set in MB
	var previewContainer = "<?php echo $previewContainer; ?>";

	var myDropzone = new Dropzone(instance, {
		acceptedFiles: "image/jpeg,image/png,image/gif",
		addRemoveLinks: true,
		autoProcessQueue: false,
        clickable: true,
		dictDefaultMessage: defaultMessage,
		dictFileTooBig: fileTooBig,
		dictInvalidFileType: invalidFileType,
		dictRemoveFile: removeFile,
		dictMaxFilesExceeded: maxFilesExceeded,
		maxFiles: 1,
		maxFilesize: maxFileSize,
		paramName: "thewire_image_file",
		previewsContainer: previewContainer,
		uploadMultiple: false,
	    init: function () {
	        this.on("addedfile", function(file) {
				$(instance).find(".dz-progress").toggle();
    			$(instance).find(".dz-message").show();
	        });
	        this.on("removedfile", function(file) {
    			$(instance).find(".dz-progress").toggle();
    			$(instance).find(".dz-message").show();
	        });
	        this.on("success", function(file, xhr) {
    			if( xhr.system_messages.success[0] || file.accepted ){
					file.previewTemplate = $(this.options.previewTemplate);
	    			$(instance).find(".dz-preview").html(file.previewTemplate);

	    			elgg.system_message(elgg.echo('thewire:posted'));
	    			setTimeout(function() { window.location.reload(); }, 2000);
    			} else if( xhr.system_messages.error[0] ){
	    			elgg.register_error(xhr.system_messages.error[0]);
    			}
	        });
	        this.on("maxfilesexceeded", function(file) {
			    this.removeFile(file);
			});
	    }
	});

	$('.elgg-form-thewire-add button[type=submit]').on("click", function(e) {
    	e.preventDefault();
    	if(myDropzone.files.length > 0){
	    	myDropzone.processQueue();
	    } else {
	    	$('.elgg-form-thewire-add').submit();
	    }
    });
});
</script>
