<?php
session_start();
if (isset($_SESSION['Region']) && isset($_SESSION['Industry'])) {
    $regionID = $_SESSION['Region'];
    $industryID = $_SESSION['Industry'];
    $startYear = $_SESSION['StartYear'];
    $endYear = $_SESSION['EndYear'];
} else {
    header("Location: index.php");
}

if (isset($_POST['mapIndustryID'])) {
	$_SESSION['mapIndustryID'] = $_POST['mapIndustryID'];
}
else if (!isset($_SESSION['mapIndustryID'])) {
	$_SESSION['mapIndustryID'] = $industryID[0];
}

require_once('employmentController.php');

$controller = new EmploymentController($startYear, $endYear, 'map');

$sql = 'SELECT * FROM industry WHERE IndustryID IN (';

foreach ($industryID as $value){
	$sql .= "$value,";
}

$sql = substr($sql, 0, -1);
$sql .= ')';
echo $sql;
$result = mysql_query($sql);

while ($row = mysql_fetch_assoc($result)) {
    $industryList .= "<option value = ".$row['IndustryID'] ;
	if($row['IndustryID'] == $_SESSION['mapIndustryID']) {
		$industryList .= ' selected="selected" ';
	}
	$industryList .= ">".$row['IndustryDesc']." </option>";
}

$sql = "SELECT * FROM region WHERE RegionID = $regionID";
$result = mysql_query($sql);
$row = mysql_fetch_assoc($result);
$regionName = $row['RegionDesc'];
?>

<div data-role="page">

    <div data-role="header" data-position="fixed">
        <a title="Home" data-icon="home"  data-iconpos="notext" href="index.php">Home</a>
        <h1>Map</h1>
        <div data-role="navbar">
            <ul>
                <li><a href="index.php?page=chart">Chart</a></li>
                <li><a href="map.php?page=map" class="ui-btn-active ui-state-persist">Map</a></li>
            </ul>
        </div><!-- /navbar -->
    </div><!-- /header -->

    <div role="main" class="ui-content">
        <script type='text/javascript' src='https://www.google.com/jsapi'></script>
        <script type='text/javascript'>
                 data = google.visualization.arrayToDataTable([
				<?php
				echo $controller->getDataToMap();
				?>
                ]);

                geochart = new google.visualization.GeoChart(
                        document.getElementById('map_div'));
                geochart.draw(data, {width: $(window).width(), height: $(window).height() * 0.65,
                    region: 'CA', resolution: 'provinces',
                    colorAxis: {minValue: -100, maxValue: 100, values: [-100, 100], colors: ['#FF0000', '#0000FF']},
                    datalessRegionColor: '#AAAAAA'});
        </script>
		<form method="post" action="index.php?page=map">
			<select id="mapIndustryID" name="mapIndustryID">
				<?php echo $industryList ?>
			</select>
		</form>
        <div id="map_div"></div>

    </div><!-- /content -->

    <div data-role="footer" data-position="fixed">
        <h4> </h4>
    </div><!-- /footer -->
</div><!-- /page -->