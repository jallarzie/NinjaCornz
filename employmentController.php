<?php

require_once 'DB.php';
require_once 'employmentModel.php';

class EmploymentController {

    private $modelArray;

    function __construct() {
        $this->modelArray = array();
        $this->runQuery(1, 1);
    }

    function runQuery($region, $industry) {
        $query = "SELECT * 
				  FROM employment
				  WHERE RegionID=$region AND IndustryID=$industry ";
        $result = mysql_query($query);
        $i = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $modelTemp = new EmploymentModel($row['IndustryID'], $row['Year'], $row['RegionID'], $row['Value']);
            $this->modelArray[$i++] = $modelTemp;
        }
    }

    public function getRecordResults() {
        
    }

}

?>