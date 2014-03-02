<?php

require_once 'DB.php';
require_once 'employmentModel.php';

class EmploymentController {

    private $modelArray;
    private $region;
    private $industry;
    private $startYear;
    private $endYear;
    private $industryNames;
    private $regionNames;

    function __construct($startYear, $endYear, $option) {
        $this->region = $_SESSION['Region'];
        $this->industry = $_SESSION['Industry'];
        $this->startYear = $startYear;
        $this->endYear = $endYear;
        $this->modelArray = array();
        $this->industryNames = array();
        $this->regionNames = array();
        $this->initializeNames();
        if ($option == 'chart') {
            $this->chartQuery();
        } else {
            $this->mapQuery();
        }
    }

    function initializeNames() {
        $sql = "SELECT * FROM industry";
        $result = mysql_query($sql);
        while ($row = mysql_fetch_assoc($result)) {
            $this->industryNames[$row['IndustryID']] = $row['IndustryDesc'];
        }

        $sql = "SELECT * FROM region";
        $result = mysql_query($sql);
        while ($row = mysql_fetch_assoc($result)) {
            $this->regionNames[$row['RegionID']] = $row['RegionDesc'];
        }
    }

    function chartQuery() {
        $query = "SELECT Year, IndustryID, Value FROM employment  WHERE RegionID=" . $this->region . " AND Year >= " . $this->startYear . " AND Year <= " . $this->endYear . "";
        $query .= " AND  ";
        if (!is_array($this->industry)) {
            $query .= "IndustryID=" . $this->industry . " ";
        } else {
            $query .= "(";
            for ($i = 0; $i < count($this->industry); $i++) {
                $query .= "IndustryID=" . $this->industry[$i];
                if ($i != count($this->industry) - 1) {
                    $query .= " OR ";
                }
            }
            $query .= " )";
        }
        $query .= " ORDER BY Year, IndustryID";
        //var_dump($query);
        $result = mysql_query($query);
        $i = 0;
        while ($row = mysql_fetch_assoc($result)) {
            //$modelTemp = new EmploymentModel($row['IndustryID'], $row['Year'], $row['RegionID'], $row['Value']);
            //$this->modelArray[$i++] = $modelTemp;
            if (!isset($this->modelArray[$row['Year']])) {
                $this->modelArray[$row['Year']] = array();
            }
            $this->modelArray[$row['Year']][$row['IndustryID']] = $row['Value'];
        }
        // var_dump($this->modelArray);
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

        $title = "['Year'";
        $toReturn = "";
        $saveKey = "";
         for ($i = 0; $i < count($this->industry); $i++) {
                $title .= ", '".$this->industryNames[$this->industry[$i]]."'";
            }

        foreach ($this->modelArray as $key => $value) {
//            if ($saveKey != "" && $saveKey != $key) {
//                $saveKey = "";
//                $toReturn .= "],";
//            }
//            if ($saveKey == "") {
//               // $title .= ", " . $value[0] . "";
//                $toReturn .= "['$key', $value[1]";
//                $saveKey = $key;
//               // var_dump($this->industryNames);
//               // var_dump($value);
//            } else if ($saveKey == $key) {
//                $toReturn .= ", $value[1]";
//            }
             $toReturn .= "['$key'";
            for ($i = 0; $i < count($this->industry); $i++) {
                $toReturn .= ",". $value[$this->industry[$i]]."";
            }
            $toReturn .= "],";
        }
        $title .= "],";
        $toReturn = substr($toReturn, 0, -1);
        $final = $title . $toReturn;
       // echo $final;
        //echo $title;
        return $final;
    }

}

?>