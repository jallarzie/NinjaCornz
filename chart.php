<?php
session_start();
if (isset($_POST['RegionID']) && isset($_POST['IndustryID'])) {
    $regionID = $_POST['RegionID'];
    $industryID = $_POST['IndustryID'];
    $startYear = $_POST['startYear'];
    $endYear = $_POST['endYear'];
    $_SESSION['Region'] = $regionID;
    $_SESSION['Industry'] = $industryID;
    $_SESSION['StartYear'] = $startYear;
    $_SESSION['EndYear'] = $endYear;
}else if(isset($_SESSION['Region']) && isset($_SESSION['Industry'])) {
    $regionID = $_SESSION['Region'];
    $industryID = $_SESSION['Industry'];
    $startYear = $_SESSION['StartYear'];
    $endYear = $_SESSION['EndYear'];
} else{
    header("Location: input.php");
}

require_once('employmentController.php');

//$industryID = array(3, 4, 5);

var_dump($industryID);

// this should be done thru post or before hand


$controller = new EmploymentController($startYear, $endYear, 'chart');


$sql = "SELECT * FROM region WHERE RegionID = $regionID";
$result = mysql_query($sql);
$row = mysql_fetch_assoc($result);
$regionName = $row['RegionDesc'];
echo "here";
//$sql = "SELECT * FROM industry WHERE IndustryID = $industryID" ;
//$result = mysql_query($sql);
//$row = mysql_fetch_assoc($result);
//$industryName = $row['IndustryDesc'];
//while ($row = mysql_fetch_assoc($result)) {
//    $industryList .= "<option value = ".$row['IndustryID'].">".$row['IndustryDesc']." </option>";
//}
//`echo $controller->dataToTable();
?>
<div data-role="page">

    <div data-role="header" data-position="fixed">
        <a title="Home" data-icon="home"  data-iconpos="notext" href="index.php">Home</a>
        <h1>Chart</h1>
        <div data-role="navbar">
            <ul>
                <li><a href="index.php?page=chart" class="ui-btn-active ui-state-persist">Chart</a></li>
                <li><a href="index.php?page=map">Map</a></li>
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
                title: '<?php echo "Employment by Year across $regionName (in Thousands)" ?>',
                height: $(window).height() * 0.75,
                width: $(window).width() * 0.91,
                legend: {position: 'right'}
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