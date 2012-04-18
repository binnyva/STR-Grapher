<?php
require('./common.php');
?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<!--meta http-equiv="X-UA-Compatible" content="chrome=1"-->
<!--meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /-->
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title>MAD : Spark the Rise - Hourly</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="ico/json2.js"></script>
<script type="text/javascript" src="ico/es5.js"></script>
<script src="ico/raphael-2.1.0-min.js" type="text/javascript" charset="utf-8"></script>
<script src="ico/ico.js" type="text/javascript" charset="utf-8"></script>
</head>

<body>
<center>
<h1>Spark the Rise</h1>
<h2>MAD vs SAM</h2>

<?php
$data_type = i($QUERY, 'type', 'change');
$date = i($QUERY, 'time', date('Y-m-d H', time() + $time_zone_offset));
$timestamp = strtotime($date . ":00:00");
?>

<div id="graph"></div>
<div id="pager">
<div id="prev"><a href="<?php echo getLink('hourly.php', array('time' => date('Y-m-d H', $timestamp - 60 * 60)), true); ?>">Last Hour</a></div>
<div id="today"><?php echo date('dS M, Y, h A', $timestamp); ?></div>
<div id="next"><a href="<?php echo getLink('hourly.php', array('time' => date('Y-m-d H', $timestamp + 60 * 60)), true); ?>">Next Hour</a></div>
</div><br />

<span style="color:red;font-weight:bold;">SAM</span>
<span style="color:black;font-weight:bold;">MAD</span>
</center>

<?php
$handle = fopen('minute.txt','r') or die("Can't open file 'minute.txt'");
$mad_data = array();
$sam_data = array();
$time_data = array();
$rows = 0;
$mad_last = 0;
$sam_last = 0;

while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
	$row_date = date('Y-m-d H', $data[0] + $time_zone_offset);
	
	if($row_date == $date) {
		//echo date('Y-m-d H:i:s', $data[0] + $time_zone_offset).'<br />';
	
		if($data_type == 'absolute') {
			$mad_data[] = $data[1];
			$sam_data[] = $data[2];
			$time_data[] = date('i', $data[0] + $time_zone_offset);
			
		} else {
			if($mad_last > 0) {
				$mad_data[] = $data[1] - $mad_last;
				$sam_data[] = $data[2] - $sam_last;
				$time_data[] = date('i', $data[0] + $time_zone_offset);
			}
		}
		
		$rows++;
	}
	
	$mad_last = $data[1];
	$sam_last = $data[2];
}

?>
<script type="text/javascript">
new Ico.LineGraph(
"graph",    			                           	// DOM element where the graph will be rendered
[                                                	// The 2 series
	[<?php echo implode(',', $mad_data); ?>], 	// Drawn first
	[<?php echo implode(',', $sam_data); ?>]  	// Drawn last, on top of previous series
],
{                                                	// Graph components' options
	colors: ['black', 'red' ],               	// Series' colors
	labels: { values: <?php echo json_encode($time_data); ?>, angle: 30 },
	mouseover_attributes: { stroke: 'green' },     	// When hovering over values
	font_size: 16,                                 	// for both labels and value labels and other elements
	background: { color: '#ccf', corners: 5 },     	// Set entire div background color and corner size
	status_bar : true
}
);
</script>
</body>
</html>
