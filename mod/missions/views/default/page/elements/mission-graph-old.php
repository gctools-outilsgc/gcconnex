<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

$department_set = $vars['mission_graph_result_array'];
$department_count = count($department_set);
$date_set = $vars['mission_graph_date_array'];
$date_count = count($date_set) - 1;

$graph_height = 200;
$bar_width = 5;
$bar_gap = 2;
$interval_gap = 40;

$interval_width = ($bar_width * $department_count) + ($bar_gap * ($department_count - 1));
$graph_width = ($interval_width + $interval_gap) * $date_count + $interval_gap + $bar_gap;
$x_axis_height = 75;

$department_set_max = array();
$department_colors = array();
foreach($department_set as $department_name => $department_data) {
	$department_set_max[$department_name] = max($department_data);
	$department_colors[$department_name] = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
}
$absolute_max = max($department_set_max);
$ratio = $graph_height / $absolute_max;
?>

<div style="border:solid 1px #e1e1e1; background-color:#fafafa; height:<?php echo $graph_height ?>px; width:<?php echo $graph_width ?>px;">
	<div style="height:<?php echo $graph_height ?>px; width:<?php echo $interval_gap ?>px; float:left;"></div>
	<?php
	$width_track = $interval_gap;
	for($i=0;$i<$date_count;$i++) {
		$count = 1;
		foreach($department_set as $department_name => $department_data) {
			$bar_height = intval($department_data[$i] * $ratio);
			$bar_top_margin = $graph_height - $bar_height;
			$bar_color = $department_colors[$department_name];
			
			echo '<div style="height:' . $bar_height . 'px; margin-top:' . $bar_top_margin . 'px; width:' . $bar_width . 'px; background-color:' . $bar_color . '; float:left;"></div>';
			if($count != $department_count) {
				echo '<div style="height:' . $graph_height . 'px; width:' . $bar_gap . 'px; float:left;"></div>';
			}
			$count++;
		}
		
		echo '<div style="height:' . $graph_height . 'px; width:' . $interval_gap . 'px; float:left;"></div>';
	}
	?>
	<div style="clear:both;"></div>
</div>

<div style="height:<?php echo $x_axis_height ?>px; background-color:#8c8c8c; width:<?php echo $graph_width ?>px; color:#FFF; border:solid 1px #666;">
	<div style="height:<?php echo $x_axis_height ?>px; width:<?php echo $interval_gap ?>px; float:left;"></div>
	<?php
	for($i=0;$i<$date_count;$i++) {
		echo '<div style="height:' . $x_axis_height . 'px; width:' . $interval_width . 'px; text-align:center; float:left; font-size:10px;">' . $date_set[$i] . '<br>---<br>' . $date_set[$i+1] . '</div>';
		echo '<div style="height:' . $x_axis_height . 'px; width:' . $interval_gap . 'px; float:left;"></div>';
	}
	?>
</div>
<br>
<?php
foreach($department_set as $department_name => $department_data) {
	$department_color = $department_colors[$department_name];
	$text_color = (hexdec($department_color) > 0xffffff/2) ? 'black':'white';
	echo '<div style="padding: 4px; margin-right:10px; background-color:' . $department_color . '; color:' . $text_color . '; float:left;">' . $department_name . '</div>';
}
?>

<div id="my_chart"></div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
   google.charts.load('current', {'packages':['bar']});
   google.charts.setOnLoadCallback(drawChart);
   function drawChart() {
	    var data = new google.visualization.DataTable();
	    data.addColumn('string', 'Topping');
	    data.addColumn('number', 'Nescafe Instant');
	    data.addColumn('number', 'Folgers Instant');
	    data.addColumn('number', 'Nescafe Beans');
	    data.addColumn('number', 'Folgers Beans');
	    data.addColumn('number', 'Test 1');
	    data.addColumn('number', 'Test 2');
	    data.addRows([
	        ['2001', 321, 621, 816, 319, 500, 500],
	        ['2002', 163, 231, 539, 594, 500, 500],
	        ['2003', 125, 819, 123, 578, 500, 500],
	        ['2005', 197, 536, 613, 298, 500, 500],
	        ['2006', 197, 536, 613, 298, 500, 500],
	        ['2007', 197, 536, 613, 298, 500, 500],
	        ['2008', 197, 536, 613, 298, 500, 500],
	        ['2009', 197, 536, 613, 298, 500, 500],
	        ['2010', 197, 536, 613, 298, 500, 500],
	        ['2011', 197, 536, 613, 298, 500, 500],
	        ['2012', 197, 536, 613, 298, 500, 500],
	        ['2013', 197, 536, 613, 298, 500, 500]
	    ]);

		var test_object = {
	    		2: {
	                targetAxisIndex: 1
	            },
	            3: {
	                targetAxisIndex: 1
	            },
	            4: {
	                targetAxisIndex: 2
	            },
	            5: {
	                targetAxisIndex: 2
	            }
	    };

	    // Set chart options
	    var options = {
	        isStacked: true,
	        width: 800,
	        height: 600,
	        chart: {
	            title: 'Year-by-year coffee consumption',
	            subtitle: 'This data is not real'
	        },
	        vAxis: {
	            viewWindow: {
	                min: 0,
	                max: 1000
	            }
	        },
	        series: test_object
	    };

	    // Instantiate and draw our chart, passing in some options.
	    var chart = new google.charts.Bar(document.getElementById('my_chart'));
	    chart.draw(data, google.charts.Bar.convertOptions(options));
  }
</script> 