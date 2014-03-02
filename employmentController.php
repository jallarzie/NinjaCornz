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
        $query = "SELECT * FROM employment  WHERE RegionID=" . $this->region . " AND IndustryID=" . $this->industry . " 
                  AND Year >= " . $this->startYear . " AND Year <= " . $this->endYear;
        $result = mysql_query($query);
        $i = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $modelTemp = new EmploymentModel($row['IndustryID'], $row['Year'], $row['RegionID'], $row['Value']);
            //$this->modelArray[$i++] = $modelTemp;
            $this->modelArray[$row['Year']] = $row['Value'];
            var_dump($this->modelArray);
        }
    }

    function mapQuery() {
        $query = "SELECT RegionID, ((SELECT Value FROM employment AS e2 WHERE e1.RegionID = e2.RegionID AND e2.Year = $this->endYear AND e2.IndustryID = $this->industry) - 
                (SELECT Value FROM employment AS e2 WHERE e1.RegionID = e2.RegionID AND e2.Year = $this->startYear AND e2.IndustryID = $this->industry)) / 
                (SELECT Value FROM employment AS e2 WHERE e1.RegionID = e2.RegionID AND e2.Year = $this->startYear  AND e2.IndustryID = $this->industry) AS Value
                FROM employment AS e1
                GROUP BY RegionID";
        $result = mysql_query($query);

        while ($row = mysql_fetch_assoc($result)) {
            $this->modelArray[$row['RegionID']] = $row['Value'];
        }
//        var_dump($this->modelArray);
    }

    function dataToJson() {
        $toReturn = "";

        $toReturn .= '{ ';
        $toReturn .= '"cols": [';
        $toReturn .= '{"id":"","label":"Year","pattern":"","type":"string"}, ';
        $toReturn .= '{"id":"","label":"Value","pattern":"","type":"float"} ';
        $toReturn .= '],';

        $toReturn .= '"rows": [';
        foreach ($this->modelArray as $key => $value) {
            $toReturn .= '{"c":[{"v":"' . $key . '","f":null},{"v":"' . $value . '","f":null}]}';
        }
        $toReturn .= ']';
        $toReturn .= '}';
        //  var_dump($toReturn);
        return $toReturn;
    }

    function dataToTable() {
        $toReturn = "['Year', 'Value'],";
        foreach ($this->modelArray as $key => $value) {
            $toReturn .= "['$key', $value],";
        }
        $toReturn = substr($toReturn, 0, -1);
        return $toReturn;
    }

}

?>