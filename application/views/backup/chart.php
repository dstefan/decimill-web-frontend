<html>
    <head>
        <script type="text/javascript" src="/application/js/jquery/jquery.js"></script>
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript">

            google.load('visualization', '1.0', {'packages': ['corechart']});

            $(function () {

                function drawCompare(div) {

                    var title = "By activity";

                    var allTitle = "Overall";
                    var allValue = 100;
                    
                    var splitTitles = ["Ventilation", "Heating", "Air conditioning"];
                    var splitValues = [25, 15, 20];
                    
                    var header = ["Fragment", allTitle].concat(splitTitles).concat({role: 'annotation'});
                    var allData = ["", allValue].concat(Array.apply(null, new Array(splitTitles.length)).map(Number.prototype.valueOf, 0)).concat('');
                    var splitData = ["", 0].concat(splitValues).concat('');
                    
                    console.log(header);
                    console.log(allData);
                    console.log(splitData);

                    var data = google.visualization.arrayToDataTable([
                        header,
                        allData,
                        splitData
                    ]);

                    var options = {
                        width: 600,
                        height: 400,
                        legend: {position: 'right', width: 100},
                        bar: {groupWidth: '75%'},
                        isStacked: true
                    };

                    var chart = new google.visualization.ColumnChart(div.get(0));
                    chart.draw(data, options);
                }

                drawCompare($('#compare'));

                function drawHistogram(div, ticks, values, width, height) {

                    var data = new google.visualization.DataTable();

                    data.addColumn('number', 'values');
                    data.addColumn('number', 'percent');
                    data.addColumn({type: 'string', role: 'tooltip'});

                    for (var i = 0; i < ticks.length; i++) {
                        data.addRows([[values[i], ticks[i], ' ']]);
                    }

                    // Set chart options
                    var options = {
                        'orientation': 'horizontal',
                        'bar': {
                            'groupWidth': '90%'
                        },
                        hAxis: {
                            'ticks': values
                        },
                        'width': width,
                        'height': height
                    };

                    var chart = new google.visualization.BarChart(div.get(0));
                    chart.draw(data, options);
                }

                $('.reserved').each(function () {

                    console.log($(this));
                    var data = $(this).data('gson').data;

                    switch (data.type) {
                        case 'histogram':
                        {
                            var ticks = data.ticks;
                            var values = data.values;
                            var width = data.width;
                            var height = data.height;
                            drawHistogram($(this), ticks, values, width, height);
                        }
                    }
                });
            });

        </script>
    </head>

    <body>

        Eval <div class="reserved" data-gson='{"data":{"values":[-36.72693664298959,-16.131303568210924,4.46432950656774,25.059962581346404,45.655595656125065,66.25122873090373,86.8468618056824,107.44249488046106,128.03812795523973,148.63376103001838],"height":300.0,"ticks":[16,114,535,1686,2841,2636,1539,528,96,9],"width":500.0,"type":"histogram"}}'></div>.

        <div id="compare"></div>

    </body>
</html>