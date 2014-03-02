<div data-role="page">

    <div data-role="header" data-position="fixed">
        <a title="Home" data-icon="home"  data-iconpos="notext" href="index.php">Home</a>
        <h1>Map</h1>
        <div data-role="navbar">
            <ul>
                <li><a href="index.php?page=chart">Chart</a></li>
                <li><a href="map.php?page=map" class="ui-btn-active ui-state-persist">Map</a></li>
            </ul>
        </div><!-- /navbar -->
    </div><!-- /header -->

    <div role="main" class="ui-content">
        <script type='text/javascript' src='https://www.google.com/jsapi'></script>
        <script type='text/javascript'>
            drawRegionsMap();

            function drawRegionsMap() {
			  var data = google.visualization.arrayToDataTable([
				['Province', 'Employment Growth'],
				['Quebec', 0.5],
				['Ontario', 0.2],
				['Alberta', 0.5],
				['Saskatchewan', 0.3],
				['Manitoba', 0.2],
				['New Brunswick', -0.1],
				['Nova Scotia', 1.3],
				['Prince Edward Island', -0.5],
				['British Columbia', -0.1],
				['Newfoundland and Labrador', 0.2]  ]);

			  var geochart = new google.visualization.GeoChart(
				  document.getElementById('map_div'));
			  geochart.draw(data, {width: $(window).width(), height: $(window).height() * 0.75, 
								   region: 'CA', resolution: 'provinces',  
								   colorAxis: {minValue: -1, maxValue: 1, values: [-1, 1],  colors: ['#FF0000', '#0000FF']}, 
								   datalessRegionColor: '#AAAAAA'});
			}
        </script>
        <div id="map_div"></div>

    </div><!-- /content -->

    <div data-role="footer" data-position="fixed">
        <h4> </h4>
    </div><!-- /footer -->

</div><!-- /page -->