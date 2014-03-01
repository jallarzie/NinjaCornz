<?php
require_once 'DB.php';

$regionList = "";
$industryList = "";

$sql = 'SELECT * FROM region';
$result = mysql_query($sql);

while ($row = mysql_fetch_assoc($result)) {
    $regionList .= "<option value = ".$row['RegionID'].">".$row['RegionDesc']." </option>";
}

$sql = 'SELECT * FROM industry';
$result = mysql_query($sql);

while ($row = mysql_fetch_assoc($result)) {
    $industryList .= "<option value = ".$row['IndustryID'].">".$row['IndustryDesc']." </option>";
}

?>

<div data-role="page">

	<div data-role="header" data-position="fixed">
		<h1></h1>
	</div><!-- /header -->

	<div role="main" class="ui-content">
		
		<form action="chart.php" method="POST">
			Select Region:
			<select name="RegionID" data-native-menu="false"> 
				<?php echo $regionList ?>
			</select>
			<br> Select Industry:
			<select name="IndustryID" data-native-menu="false"> 
				<?php echo $industryList ?>
			</select>
			<br>
			<input type="submit" value="Submit" />
		</form>

	</div><!-- /content -->

	<div data-role="footer" data-position="fixed">
		<h4>
			
		</h4>
	</div><!-- /footer -->

</div><!-- /page -->