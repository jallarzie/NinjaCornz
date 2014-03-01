<?php
require_once('employmentController.php');

// this should be done thru post or before hand
$_SESSION['Region'] = 1;
$_SESSION['Industry'] = 2;

$controller = new EmploymentController(2005, 2010, 'chart');
?>
<html>
    <head>
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript">
            google.load("visualization", "1", {packages: ["corechart"]});
            google.setOnLoadCallback(drawChart);
            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                <?php
                echo $controller->dataToTable();
                ?>
                ]);

                var options = {
                    title: 'Company Performance'
                };

                var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
                chart.draw(data, options);
            }
        </script>
    </head>
    <body>
        <div id="chart_div" style="width: 900px; height: 500px;"></div>
    </body>
</html>