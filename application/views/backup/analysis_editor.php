
<? include_view('header') ?>

<div class="header">
    <a href="/" style="float: left;">
        <img src="/application/images/logo.png" style="margin: 9px 0 0 15px;" />
    </a>
    <div style="float: right; margin: 8px 16px 0 0;">
        <a id="runButton" href="javascript:void(0);" class="saveButton active" style="float: left; margin-right: 10px;">Run</a>
    </div>
</div>

<style>
    .lineError { background-color: #fcc; }
</style>

<div class="main">

    <? include_view('leftColumn') ?>

    <div class="rightColumn">

        <script type="text/javascript">

            $(function() {

                var isError = false;
                var errorLine = 0;
                var errorChar = 0;

                var editor = CodeMirror.fromTextArea($('#editor').get(0), {
                    //mode: "javascript",
                    lineNumbers: true
                });

                editor.on('change', function() {
                    if (isError) {
                        editor.removeLineClass(errorLine, 'background', 'lineError');
                        isError = false;
                    }
                });

                $('#deleteForm').submit(function() {
                    if (confirm('Deleting a model cannot be undone. Do you wish to continue?')) {
                        return true;
                    }
                    return false;
                });

                $('#cancelButton').click(function() {
                    document.location = '/workbench';
                });

                $('#runButton').click(function() {

                    var text = editor.getValue();

                    ContextManager.run_query({
                        post: {
                            text: text
                        },
                        success: function(res) {
                            if (res !== null && res.isError) {
                                errorLine = res.body.line - 1;
                                errorChar = res.body.charPos;
                                editor.addLineClass(errorLine, 'background', 'lineError');
                                editor.focus();
                                editor.setCursor({line: errorLine, ch: errorChar});
                                isError = true;
                            } else {
                                var arrays = res.body.arrays;
                                var values = res.body.values;
                                showResults(arrays, values);
                            }
                        }
                    });
                });

                function showResults(arrays, V) {

                    var rowNames = [];
                    var colNames = [];

                    // Extract col and row names.
                    for (var rowName in arrays) {
                        rowNames.push(rowName);
                        for (var colName in arrays[rowName]) {
                            if (colNames.indexOf(colName) === -1) {
                                colNames.push(colName);
                            }
                        }
                    }

                    // Build table html
                    var html = '<table class="resultsTable">';
                    html += '<tr class="resultsHeader"><td></td>';

                    // Table heading
                    for (var i = 0; i < colNames.length; i++) {
                        html += '<td>' + colNames[i] + '</td>';
                    }

                    html += '</tr><tr>';

                    for (var i = 0; i < rowNames.length; i++) {
                        var rowName = rowNames[i];
                        html += '<tr class="resultsRow">';
                        var values = '';
                        for (var j = 0; j < colNames.length; j++) {
                            var colName = colNames[j];
                            var o = arrays[rowName][colName];
                            if (o !== undefined) {
                                var vo = getFormattedValue(o);
                                var value = vo.value;
//                                var unit = vo.unit;
//                                var inc = vo.inc;
                                values += '<td class="resultsValue">' + value + '</td>';
                            } else {
                                values += '<td></td>';
                            }
                        }
                        var label = '<td class="resultsRowLabel">' + rowNames[i] + '</td>';
                        html += label + values + '</tr>';
                    }

                    html += '</table>';
                    
                    var valHtml = '<table class="singleValuesTable">';
                    
                    for (var id in V) {
                        var o = V[id];
                        var value = null;
                        if (o.value !== undefined) {
                            value = o.value;
                        } else if (o.mean !== undefined) {
                            value = o.mean;
                        }
                        valHtml += '<tr><td class="label">' + id + '</td><td class="value">' + $.number(value) + '</td></tr>';
                    }
                    
                    valHtml += '</table>';

                    $('#resultsBody').html('');
                    $('#resultsBody').html(html);
                    $('#resultsBody').append(valHtml);
                    $('#resultsBox').show();

                    var windowWidth = $(window).width();
                    var resultsWidth = $('#resultsBox').outerWidth();
                    var leftOffset = (windowWidth - resultsWidth) / 2 - 230;
                    
                    // Offset results table
                    $('#resultsBox').css('left', leftOffset + 'px');
                }

                function getFormattedValue(o) {

                    var res = {
                        value: null,
                        unit: '',
                        inc: false
                    };
                    var value = null;
                    var unit = '';

                    // Extract value from object
                    if (o.value !== undefined) {
                        value = o.value;
                    } else if (o.mean !== undefined) {
                        value = o.mean;
                    }

                    // Format using unit if defined
                    if (value !== null && o.unit !== undefined) {
                        unit = o.unit;
                        switch (o.unit) {
                            case '%':
                                {
                                    value *= 100;
                                    value = $.number(value) + unit;
                                    res.value = $.number(value) + unit;
                                    res.unit = unit;
                                    res.inc = true;
                                    break;
                                }
                            case '£':
                            case '$':
                                {
                                    value = unit + $.number(value);
                                    res.value = value;
                                    res.unit = unit;
                                    res.inc = true;
                                    break;
                                }
                            default:
                                {
                                    value = $.number(value);
                                    res.value = value;
                                    res.unit = unit;
                                }
                        }
                    } else if (value !== null) {
                        value = $.number(value);
                        res.value = value;
                    }

                    return res;
                }
            });

        </script>

        <div id="resultsBox" style="display: none; z-index: 100; position: absolute; top: 100px; left: 200px; padding: 20px; background-color: #fff; border: solid 1px #e0e1e2; border-radius: 2px; box-shadow: 0 2px 2px rgba(0, 0, 0, 0.2);">
            <div style="text-align: center; margin-bottom: 30px; font-family: 'Roboto Condensed'; font-size: 20px;">
                Analysis Results
            </div>
            <div id="resultsBody">
            </div>
        </div>

        <div class="editorWrapper">
            <textarea id="editor"><?= $query->getText() ?></textarea>
        </div>

    </div>

</div>

<? include_view('footer') ?>