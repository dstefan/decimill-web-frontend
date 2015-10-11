
<? include_view('case_study_header'); ?>

<div id="content">

    <div class="content-left">
        <? include_view('left_menu'); ?>
    </div>

    <div id="sampleBlock" style="z-index: 9999; display: none; padding: 10px; background-color: #fff; position: absolute; border-radius: 3px; border: solid 1px #f0f1f2; box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);">
        <div class="chartCanvas"></div>
    </div>

    <div class="content-right">

        <div class="content-block">

            <div class="content-block-header">
                <div style="float: right;">
                    <a class="blink-red-small" id="deleteButton" data-studyid="<?= $study->getId() ?>" data-queryid="<?= $query->getId() ?>">delete</a>
                    <a class="blink-blue-small" href="/report/<?= $query->getStudyId() ?>/<?= $query->getId() ?>/edit" style="padding-right: 7px;">edit</a>
                </div>
                <span class="model-title">
                    <i class="fa fa-file-text-o" style="margin: 0 5px 0 0;"></i>
                    <?= $query->getTitle() ?>
                </span>
            </div>

            <div class="markdown" style="padding: 15px 20px;">
                <?= Markdown::defaultTransform($query->getCompiled()) ?>
            </div>

        </div>

    </div>

    <style type="text/css">
        .chart { height: 300px; }
        .chart-title { text-align: center; font-size: 13px; font-weight: bold; margin-bottom: 15px; }
        .sample { border-bottom: dashed 1px #b0b1b2; }
        /* .sample::after { content: '\0000a0 \0025C7'; vertical-align: super; font-size: 8px; } */
        #sampleBlock { width: 300px; height: 190px; }
    </style>

    <script type="text/javascript" src="/application/js/jquery/jquery-tablesorter.js"></script>
    <script type="text/javascript" src="/application/js/bignumber.js"></script>

    <script type="text/javascript">

        function naturalDigits(num) {
            var match = ('' + num).match(/(\d+)(?:\.(\d+))?$/);
            if (!match) {
                return 0;
            }
            return match[1] ? (match[1] === '0' ? 0 : match[1].length) : 0;
        }

        function decimalDigits(num) {
            var match = ('' + num).match(/(?:\.(0*)(\d+))?$/);
            if (!match) {
                return 0;
            }
            return match[1] ? match[1].length : 0;
        }

        function roundToSignificantDigits(value, numberOfDigits) {

            if (value === 0) {
                return 0;
            }

            var d = Math.ceil(Math.log10(value < 0 ? -value : value));
            var power = numberOfDigits - d;
            var magnitude = Math.pow(10, power);
            var shifted = Math.round(value * magnitude);

//            return shifted / magnitude;

            var magnitudeDB = new BigNumber(magnitude);
            var shiftedBD = new BigNumber(shifted);
            return Math.round(shiftedBD.divide(magnitudeDB));
        }

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        google.load('visualization', '1.0', {'packages': ['corechart']});

        function drawHistogram(div, values, bins, small) {

            var data = new google.visualization.DataTable();

            data.addColumn('number', 'values');
            data.addColumn('number', 'percent');
            data.addColumn({type: 'string', role: 'tooltip'});

            var nat = naturalDigits(values[1] - values[0]);
            var dec = decimalDigits(values[1] - values[0]);

            var ticks = [];

            for (var i = 0; i < values.length; i++) {
                ticks.push({
                    v: values[i] + "",
                    f: numberWithCommas(roundToSignificantDigits(values[i], 3).toString())
                });
            }

//            if (nat > 0) {
//                if (nat > 3) {
//                    for (var i = 0; i < values.length; i++) {
//                        ticks.push({
//                            v: values[i],
//                            f: ((Math.round(values[i] * Math.pow(10, -nat + 1)) / Math.pow(10, -nat + 1)) / 1000).toString() + 'k'
//                        });
//                    }
//                } else {
//                for (var i = 0; i < values.length; i++) {
//                    ticks.push({
//                        v: values[i],
//                        f: (Math.round(values[i] * Math.pow(10, -nat + 1)) / Math.pow(10, -nat + 1)).toString()
//                    });
//                }
//                }
//            } else {
//                if (dec > 2) {
//                    for (var i = 0; i < values.length; i++) {
//                        ticks.push({
//                            v: values[i] + "",
//                            f: (Math.round(values[i] * Math.pow(10, dec) * 10) / 10).toString()
//                        });
//                    }
//                } else {
//                    for (var i = 0; i < values.length; i++) {
//                        ticks.push({
//                            v: values[i] + "",
//                            f: (Math.round(values[i] * Math.pow(10, dec + 2)) / Math.pow(10, dec + 2)).toString()
//                        });
//                    }
//                }
//            }

            for (var i = 0; i < values.length; i++) {
                data.addRows([[values[i], bins[i], ' ']]);
            }

            var options = {
                'orientation': 'horizontal',
                'bar': {
                    'groupWidth': '90%'
                },
                hAxis: {
                    ticks: ticks
                },
                vAxis: {
                    ticks: 'none'
                },
                width: '100%',
                height: 300,
                tooltip: {
                    trigger: 'none'
                },
                chartArea: {
                    width: 300,
                    height: '70%'
                },
                legend: 'none'
            };

            if (small !== undefined && small) {
                options.width = '100%';
                options.height = '100%';
                options.chartArea = {
                    width: '70%',
                    height: '70%',
                    top: 10
                };
            }

            var chart = new google.visualization.BarChart(div.get(0));
            chart.draw(data, options);
        }

        function drawStacked(div, values, labels) {

            values.unshift('');
            labels.unshift('');

            var data = google.visualization.arrayToDataTable([
                labels,
                values
            ]);

            var options = {
                orientation: 'horizontal',
                width: '100%',
                height: 300,
                chartArea: {
                    width: '10%',
                    height: '80%',
                    top: 40
                },
                legend: {position: 'right', width: 100},
                bar: {groupWidth: '75%'},
                isStacked: true
            };

            var chart = new google.visualization.ColumnChart(div.get(0));
            chart.draw(data, options);
        }

        function drawCompare(div, allValue, allLabel, values, labels) {

            var header = ["Fragment", allLabel].concat(labels).concat({role: 'annotation'});
            var allData = ["", allValue].concat(Array.apply(null, new Array(labels.length)).map(Number.prototype.valueOf, 0)).concat('');
            var splitData = ["", 0].concat(values).concat('');

            var data = google.visualization.arrayToDataTable([
                header,
                allData,
                splitData
            ]);

            var options = {
                orientation: 'horizontal',
                width: '100%',
                height: 300,
                chartArea: {
                    width: '20%',
                    height: '80%',
                    top: 40
                },
                legend: {position: 'right', width: 100},
                bar: {groupWidth: '75%'},
                isStacked: true
            };

            var chart = new google.visualization.ColumnChart(div.get(0));
            chart.draw(data, options);
        }

        function drawColumn(div, values, labels, legend) {

            var data = new google.visualization.DataTable();
            var num = values.length;

            data.addColumn("string", "");
            data.addColumn("number", legend !== undefined ? legend : "");

            for (var i = 0; i < num; i++) {
                data.addRow([labels[i], values[i]]);
            }

            var options = {
                legend: legend !== undefined ? '' : 'none',
                bar: {
                    'groupWidth': '61%'
                },
                chartArea: {
                    width: num < 10 ? (num * 10) + '%' : '100%'
                }
            };

            var chart = new google.visualization.ColumnChart(div.get(0));
            chart.draw(data, options);
        }

        $(function () {

            $('.chart').each(function () {

                var data = $(this).data('gson');

                switch (data.type) {
                    case 'hist':
                    {
                        var ticks = data.values;
                        var values = data.bins;
                        drawHistogram($(this), ticks, values);
                        break;
                    }

                    case 'stacked':
                    {
                        var values = data.values;
                        var labels = data.labels;
                        drawStacked($(this), values, labels);
                        break;
                    }

                    case 'compare':
                    {
                        var values = data.values;
                        var labels = data.labels;
                        var allValue = data.allValue;
                        var allLabel = data.allLabel;
                        drawCompare($(this), allValue, allLabel, values, labels);
                        break;
                    }

                    case 'column':
                    {
                        var values = data.values;
                        var labels = data.labels;
                        var legend = data.legend;
                        drawColumn($(this), values, labels, legend);
                        break;
                    }
                }
            });

            var timeout = null;

            $('.sample').hover(function (e) {

                var data = $(this).data('gson');
                var bins = data.hist.bins;
                var values = data.hist.values;

                timeout = setTimeout(function () {
                    var windowHeight = $(window).outerHeight();
                    var width = $('#sampleBlock').outerWidth();
                    if (windowHeight > e.clientY + 30 + 190) {
                        $('#sampleBlock').css('top', e.pageY + 30 + 'px');
                    } else {
                        $('#sampleBlock').css('top', e.pageY - 250 + 'px');
                    }
                    $('#sampleBlock').css('left', e.pageX - width / 2 + 'px');
                    $('#sampleBlock').show();
                    drawHistogram($('#sampleBlock .chartCanvas'), values, bins, true);
                }, 500);

            }, function () {
                clearTimeout(timeout);
                $('#sampleBlock').hide();
                //$('#chart').attr('src', '');
            });

            $('#deleteButton').click(function () {

                var studyId = $(this).data('studyid');
                var queryid = $(this).data('queryid');

                if (confirm("Deleting a report cannot be undone. Continue?")) {
                    window.location = '/querymanager/delete_query/' + studyId + '/' + queryid;
                    return true;
                } else {
                    return false;
                }
            });

            $.tablesorter.addParser({
                id: 'sterling',
                is: function (s) {
                    return false;
                },
                format: function (s) {
                    return s.replace('£', '').replace(/,/g, '');
                },
                type: 'numeric'
            });

            $('.markdown table').tablesorter({
                headers: {
                    1: {
                        sorter: 'sterling'
                    }
                }
            });
        });

    </script>