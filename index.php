<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Single page template</title>
	<link rel="stylesheet" href="./css/jquery.mobile-1.4.2.min.css">
	<script src="https://www.google.com/jsapi"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="./js/jquery.mobile-1.4.2.min.js"></script>
	<script>
		google.load("visualization", "1", {packages: ["corechart", 'geochart']});
	</script>
</head>

<body>

	<?php 
		if(!isset($_GET['page']) || $_GET['page'] == "input")
			include('input.php');
		else if($_GET['page'] == "chart")
			include('chart.php');
		else if($_GET['page'] == "map")
			include('map.php');
		else
			include('input.php');
	?>

</body>
</html>
