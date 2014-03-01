<?php
/**
 * Simple example of a PHP script used to query an API.
 *
 * NOTE: This is a simple example without any error handling.
 *
 * @license http://data.gc.ca/eng/open-government-licence-canada
 */

// Request URL
/*$url = 'http://www.earthquakescanada.nrcan.gc.ca/api/earthquakes/latest/7d.json';

// Request HTTP headers
$headers = array(
    'Accept: application/json',
    'Accept-Language: en'
);

// Initialize the cURL object
$cu = curl_init($url);

// Set the cURL options
curl_setopt($cu, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($cu, CURLOPT_HTTPHEADER, $headers);

// Run the cURL request
$response = curl_exec($cu);

// Properly close the cURL object
curl_close($cu);

if ($response) {
	$json = json_decode($response);
    echo "{$json->metadata->request->name->en}</br>";
	echo "<table border=\"1\"><tr><th>Location</th><th>Time</th><th>Magnitude</th></tr>";
    foreach($json as $key=>$value) {
		if (isset($value->solution_id))
			echo "<tr><td>{$value->location->en}</td><td>{$value->origin_time}</td><td>{$value->magnitude}</td></tr>";
    }
	echo "</table>";
}*/
	file_put_contents("dataset.zip", fopen("http://www20.statcan.gc.ca/tables-tableaux/cansim/csv/02820042-eng.zip", 'r'));
	
	$zip = new ZipArchive;
	$res = $zip->open('dataset.zip');
	if ($res === TRUE) {
		$zip->extractTo('dataset');
		$zip->close();
	} else {
		echo 'failed, code:' . $res;
	}

	
	$regions = array();
	$industries = array();
	
	if (($handle = fopen("dataset/02820042-eng.csv", "r")) !== FALSE) {
		$data = fgetcsv($handle, 1000, ",");
		$mysqli = new mysqli("ec2-54-186-2-83.us-west-2.compute.amazonaws.com", "root", "ninjacornz", "codenc");
		
		$sql = "TRUNCATE employment";
		
		if ($mysqli->connect_errno) {
			exit();
		}
		
		if($mysqli->query($sql) === FALSE)
			echo $mysqli->error;
		
		$sql = "INSERT INTO employment (Year, RegionID, IndustryID, Value) VALUES ";
		$firstRow = true;
		$rows = 0;
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			$num = count($data);
			if ($num == 8) {
				$classifiers = explode(".", $data[6]);
				if ($classifiers[1] == "1" && $classifiers[3] == "1") {
					if(!array_key_exists($classifiers[0], $regions)) {
						$regions[$classifiers[0]] = $data[1];
					}
					if(!array_key_exists($classifiers[2], $industries)) {
						$industries[$classifiers[2]] = $data[3];
					}
					
					if (!$firstRow) {
						$sql .= ", ";
					} 
					else {
						$firstRow = false;
					}
					
					if ($data[7] == "x")
						$data[7] = "-1";
					
					$sql .= "({$data[0]}, {$classifiers[0]}, {$classifiers[2]}, {$data[7]})";
					$rows += 1;
				}
			}
		}
		echo $rows;
		fclose($handle);
		
		if($mysqli->query($sql) === FALSE)
			echo $mysqli->error;
		
		$sql = "TRUNCATE region";
		
		if($mysqli->query($sql) === FALSE)
			echo $mysqli->error;
		
		$sql = "INSERT INTO region (RegionID, RegionDesc) VALUES ";
		
		foreach($regions as $key => $value){
			if ($key != "1")
				$sql .= ", ";
			$sql .= "($key, '$value')";
		}
		
		if($mysqli->query($sql) === FALSE)
			echo $mysqli->error;
		
		$sql = "TRUNCATE industry";
		
		if($mysqli->query($sql) === FALSE)
			echo $mysqli->error;
		
		$sql = "INSERT INTO industry (IndustryID, IndustryDesc) VALUES ";
		
		foreach($industries as $key => $value){
			if ($key != "1")
				$sql .= ", ";
			$sql .= "($key, '$value')";
		}
		
		if($mysqli->query($sql) === FALSE)
			echo $mysqli->error;
		
		$mysqli->close();
	}
?>