<?php
require_once('employmentController.php');

// this should be done thru post or before hand
$_SESSION['Region'] = 1;
$_SESSION['Industry'] = 2;

$controller = new EmploymentController(2005, 2010, 'chart');
?>
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
		
		<script type="text/javascript">
			var data = google.visualization.arrayToDataTable([
			<?php
			echo $controller->dataToTable();
			?>
			]);

			var options = {
				title: 'Employment by Year',
				height: $(window).height(),
				width: $(window).width()
			};

			var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
			chart.draw(data, options);

        </script>
        <div id="chart_div"></div>

	</div><!-- /content -->

	<div data-role="footer" data-position="fixed">
		<h4> </h4>
	</div><!-- /footer -->

</div><!-- /page -->