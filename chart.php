<?php
if (!isset($_POST['RegionID']) || !isset($_POST['IndustryID'])) {
  header("Location: index.php");   
}
$regionID = $_POST['RegionID'];
$industryID = $_POST['IndustryID'];

require_once('employmentController.php');

// this should be done thru post or before hand
$_SESSION['Region'] = $regionID;
$_SESSION['Industry'] = $industryID;

$controller = new EmploymentController($_POST['startYear'], $_POST['endYear'], 'map');

$sql = "SELECT * FROM region WHERE RegionID = $regionID";
$result = mysql_query($sql);
$row = mysql_fetch_assoc($result);
$regionName = $row['RegionDesc'];

$sql = "SELECT * FROM industry WHERE IndustryID = $industryID" ;
$result = mysql_query($sql);
$row = mysql_fetch_assoc($result);
$industryName = $row['IndustryDesc'];

while ($row = mysql_fetch_assoc($result)) {
    $industryList .= "<option value = ".$row['IndustryID'].">".$row['IndustryDesc']." </option>";
}
?>
<div data-role="page">

	<div data-role="header" data-position="fixed">
		<a title="Home" data-icon="home"  data-iconpos="notext" href="index.php">Home</a>
		<h1>Chart</h1>
		<div data-role="navbar">
			<ul>
				<li><a href="chart.php" class="ui-btn-active ui-state-persist">Chart</a></li>
				<li><a href="map.php">Map</a></li>
			</ul>
		</div><!-- /navbar -->
	</div><!-- /header -->

	<div role="main" class="ui-content">
		
		<script type="text/javascript">
			var data = google.visualization.arrayToDataTable([
			<?php
			echo $controller->dataToTable();
			?>
			]);

			var options = {
				title: '<?php echo "Employment by Year for $industryName across $regionName (in Thousands)" ?>',
				height: $(window).height() * 0.75,
				width: $(window).width(),
				legend: {position: 'none'}
			};

			var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
			chart.draw(data, options);

        </script>
        <div id="chart_div"></div>

	</div><!-- /content -->

	<div data-role="footer" data-position="fixed">
		<h4> </h4>
	</div><!-- /footer -->

</div><!-- /page -->