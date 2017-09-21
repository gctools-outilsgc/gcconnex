<?php
admin_gatekeeper();

$time = $vars['time'];

$filename = elgg_get_config("dataroot") . "elgg_solr/{$time}.txt";

$line = elgg_solr_get_log_line($filename);

if (!$line) {
	return;
}

if (elgg_is_xhr()) {
	// all we need to supply is the line
	header('Content-Type: application/json');
	echo $line;
	return;
}

/*
 * 'percent' => '',
		'count' => 0, // report prior to indexing this entity
		'typecount' => 0,
		'fullcount' => 0,
		'type' => '',
		'querytime' => 0,
		'message' => 'Reindex complete'
 */

echo '<br><br>';
echo '<div id="solr-progress-results">';
echo '<div>Currently indexing type: <span class="type"></span></div>';
echo '<div>Estimated type total: <span class="typetotal"></span></div>';
echo '<div>Indexed total: <span class="indexedtotal"></span></div>';
echo '<div>Batch Complete: <span class="percent"></span></div>';
echo '<div>Batch Query Time: <span class="querytime"></span></div>';
echo '<div>Last Log Update: <span class="logdate"></span></div>';
echo '<div>Message: <span class="message"></span></div>';
echo '<div><span class="restart"></span></div>';
echo '</div>';
?>


<script>
	function refresh_log() {
			elgg.get('ajax/view/elgg_solr/ajax/progress', {
				data: {
					time: <?php echo $time; ?>
				},
				success: function(result) {
					$('#solr-progress-results span.type').text(result.type);
					$('#solr-progress-results span.typetotal').text(result.typecount);
					$('#solr-progress-results span.indexedtotal').text(result.count);
					$('#solr-progress-results span.percent').text(result.percent + '%');
					$('#solr-progress-results span.querytime').text(result.querytime);
					$('#solr-progress-results span.message').text(result.message);
					$('#solr-progress-results span.logdate').text(result.date);
					
					if (result.logtime && result.cacheoptions) {
						var url = elgg.get_site_url() + 'action/elgg_solr/restart_reindex?logtime='+result.logtime;
						var link = '<a class="elgg-button elgg-button-action elgg-requires-confirmation mhs" href="' + elgg.security.addToken(url) + '">Restart</a>';
						
						var stop_url = elgg.get_site_url() + 'action/elgg_solr/stop_reindex?logtime='+result.logtime;
						var stop_link = '<a class="elgg-button elgg-button-action elgg-requires-confirmation mhs" href="' + elgg.security.addToken(stop_url) + '">Stop</a>';
						
						var html = elgg.echo('elgg_solr:reindex:restart', [link+stop_link]);
						$('#solr-progress-results span.restart').html(html);
					}
					else {
						$('#solr-progress-results span.restart').html('');
					}
					
					window.setTimeout(function() { refresh_log(); }, 3000);
				}
			});
	}

	$(document).ready(function() {
		refresh_log();
	});
</script>