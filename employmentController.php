<?php

require_once 'DB.php';
require_once 'employmentModel.php';

class EmploymentController {

    private $modelArray;
    private $region;
    private $industry;
    private $startYear;
    private $endYear;

    function __construct($startYear, $endYear, $option) {
        $this->region = $_SESSION['Region'];
        $this->industry = $_SESSION['Industry'];
        $this->startYear = $startYear;
        $this->endYear = $endYear;
        $this->modelArray = array();
        if ($option == 'chart') {
            $this->chartQuery();
        } else {
            // other method to implement
        }
    }

    function chartQuery() {
        $query = "SELECT * FROM employment  WHERE RegionID=".$this->region." AND IndustryID=".$industry." 
                  AND Year >= ".$this->startYear ." AND Year <= ". $this->endYear;
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