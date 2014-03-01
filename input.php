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

<form action="index.php" method="POST">
    Select Country: 
    <select>
        <option> Canada </option>
    </select>
    <br> Select Region:
    <select> 
        <?php echo $regionList ?>
    </select>
    <br> Select Industry:
    <select> 
        <?php echo $industryList ?>
    </select>

</form>