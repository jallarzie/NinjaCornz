<div data-role="page">

	<div data-role="header" data-position="fixed">
		<a title="Home" data-icon="home"  data-iconpos="notext" href="index.php">Home</a>
		<h1>Chart</h1>
		<div data-role="navbar">
			<ul>
				<li><a href="chart.php" class="ui-btn-active ui-state-persist">Chart</a></li>
				<li><a href="map.php">Map</a></li>
			</ul>
		</div><!-- /navbar -->
	</div><!-- /header -->

	<div role="main" class="ui-content">
		
		<?php 
			require_once('employmentController.php'); 
			$_SESSION['Region'] = 1;
			$_SESSION['Industry'] = 1;
		?>
    <!--Load the AJAX API-->
    <script type="text/javascript">

      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
        //var data = new google.visualization.DataTable();
		var data = google.visualization.arrayToDataTable(<?php new employmentController(2000, 2014, 'chart').getRecordResults(); ?>);
		

        // Set chart options
        var options = {'title':'Test Line Chart',
                       'width':400,
                       'height':300};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
	
    <!--Div that will hold the pie chart-->
    <div id="chart_div"></div>

	</div><!-- /content -->

	<div data-role="footer" data-position="fixed">
		<h4> </h4>
	</div><!-- /footer -->

</div><!-- /page -->