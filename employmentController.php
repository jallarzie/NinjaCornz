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
            $this->mapQuery(); 
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

    function mapQuery() {
        $query = "SELECT * FROM employment  WHERE IndustryID=".$industry." 
                  AND Year = ".$this->startYear;
        $valueCurrentYear = mysql_query($query);
        $query = "SELECT * FROM employment  WHERE IndustryID=".$industry." 
                  AND Year = ".$this->endYear;
        $valueEndYear = mysql_query($query);
        $query = "SELECT SUM(Year) FROM employment  WHERE IndustryID=".$industry." 
                  AND Year >= ".$this->startYear." AND Year <= ".$this->endYear;
        $totalSumYears = mysql_query($query); 
        // Selecting distinct values
        $query = "SELECT DISTINCT(RegionID), (SELECT sum(value) from employment 
                  WHERE RegionID=e.regionid AND year>= startYear AND year<=endYear)
                  AS Value from employment as e"; 

        $mapValues=array(); 
        $i=0; 
        while ($rowCurrentYear = mysql_fetch_assoc($valueCurrentYear) &&
                $rowEndYear = mysql_fetch_assoc($valueEndYear) && 
                $rowTotalYear = mysql_fetch_assoc($totalSumYears)){
            $mapValues[$rowCurrentYear['RegionID']]=($rowEndYear['Value']-$rowStartYear['Value'])/$rowTotalYear['Value']; 

        }
    }


}

?>