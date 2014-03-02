<div data-role="page">

    <div data-role="header" data-position="fixed">
        <a title="Home" data-icon="home"  data-iconpos="notext" href="index.php">Home</a>
        <h1>Map</h1>
        <div data-role="navbar">
            <ul>
                <li><a href="chart.php">Chart</a></li>
                <li><a href="map.php" class="ui-btn-active ui-state-persist">Map</a></li>
            </ul>
        </div><!-- /navbar -->
    </div><!-- /header -->

    <div role="main" class="ui-content">
        <script type='text/javascript' src='https://www.google.com/jsapi'></script>
        <script type='text/javascript'>
            google.load('visualization', '1', {'packages': ['geochart']});
            google.setOnLoadCallback(drawRegionsMap);

            function drawRegionsMap() {
                var data = google.visualization.arrayToDataTable([
                    ['Country', 'Popularity'],
                    ['Germany', 200],
                    ['United States', 300],
                    ['Brazil', 400],
                    ['Canada', 500],
                    ['France', 600],
                    ['RU', 700]
                ]);

                var options = {
                    region: 'CA'
                };

                var chart = new google.visualization.GeoChart(document.getElementById('chart_div'));
                chart.draw(data, options);
            }
            ;
        </script>
        <div id="chart_div"></div>

    </div><!-- /content -->

    <div data-role="footer" data-position="fixed">
        <h4> </h4>
    </div><!-- /footer -->

</div><!-- /page -->