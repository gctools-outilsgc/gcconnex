<?php
	$community_url = get_input("community_url");
	$communities_json = elgg_get_plugin_setting('communities', 'gc_communities');
	$communities = json_decode($communities_json, true);

    $community_tags = "";
    foreach( $communities as $community ){
        if( $community['community_url'] == $community_url ){
            $community_tags = $community['community_tags'];
        }
    }
?>

<style type="text/css">
	select, input	{ font: 100% Arial, Helvetica, sans-serif; border: 1px solid #ccc; color: #666; border-radius: 5px; margin-bottom: 8px; }
	label 			{ display: block; }
</style>

<script>
	$(function() {
		$(".save-tags").click(function(e){
			e.preventDefault();

			var communitiesArray = JSON.parse('<?php echo str_replace("'", "\\'", $communities_json); ?>');
			var community_url = $(this).data('community_url');
			var community_tags = $(".community_tags #tags").val();

			if( community_tags !== "" ){
				$.each(communitiesArray, function(key, value){
					if(value.community_url == community_url){
						value.community_tags = community_tags;
					}
				});

		    	elgg.action('gc_communities/save', {
					data: {
						communities: JSON.stringify(communitiesArray)
					},
					success: function(result) {
						// console.log(result);
					}
				});

				$(".community_tags #tags").removeClass('error');
				$("#cboxClose").click();
				window.location.href = community_url;
			} else {
				$(".community_tags #tags").addClass('error').focus();
			}
		});
	});
</script>

<div class="community_tags">
	<label for="tags" class="required"><?php echo elgg_echo('gc_communities:tags'); ?></label>
	<input id="tags" name="tags" class="form-control" value="<?php echo $community_tags; ?>" />
</div>

<?php
	echo elgg_view('output/url', [
		'text' => elgg_echo('save'),
		'class' => 'elgg-button elgg-button-action btn btn-primary save-tags',
		'data-community_url' => $community_url
	]);
?>