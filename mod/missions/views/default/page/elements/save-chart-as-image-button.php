<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Button which saves an analytics graph as an image.
 */
$save_as_image_button = elgg_view('output/url', array(
		'text' => ' ' . elgg_echo('missions:save_as_image'),
		'class' => 'elgg-button btn btn-default',
		'id' => 'missions-save-chart-as-image-button',
		'onclick' => 'save_chart_as_image()'
));
?>

<div>
	<?php echo $save_as_image_button; ?>
</div>

<script type="text/javascript" src="http://canvg.googlecode.com/svn/trunk/rgbcolor.js"></script>
<script type="text/javascript" src="http://canvg.googlecode.com/svn/trunk/canvg.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script>
function save_chart_as_image() {
 	var chartContainer = document.getElementById('my_chart');
 	var chartArea = chartContainer.getElementsByTagName('svg')[0].parentNode;
    var svg = chartArea.innerHTML;
    var doc = chartContainer.ownerDocument;
    var canvas = doc.createElement('canvas');
    canvas.setAttribute('width', chartArea.offsetWidth);
    canvas.setAttribute('height', chartArea.offsetHeight);

    canvas.setAttribute(
        'style',
        'position: absolute; ' +
        'top: ' + (-chartArea.offsetHeight * 2) + 'px; ' +
        'left: ' + (-chartArea.offsetWidth * 2) + 'px;');
    doc.body.appendChild(canvas);
    canvg(canvas, svg);
    var imgData = canvas.toDataURL("image/png");
    canvas.parentNode.removeChild(canvas);

    window.location = imgData.replace("image/png", "image/octet-stream");
}
</script>