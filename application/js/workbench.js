
$(function() {

    $(document).on('click', '.scenarioLink', function() {

        var link = $(this);
        var scenarioId = $(this).attr('data-scnrid');

        ContextManager.get_scenario_text(scenarioId, {
            success: function(res) {
                showScenarioEditor();
                //$('#scenarioEditor').find('.editor').val(res.body);
                scenarioEditor.setValue(res.body);
                $('#modelId').val(scenarioId);
                clearSelectedLinks();
                link.addClass('selected');
            }
        });
    });

    $('#saveModelButton').click(function() {
        ContextManager.set_text({
            post: {
                'id': $('#modelId').val(),
                'type': 'model',
                'text': modelEditor.getValue()
            }
        });
    });

    $('#saveScenarioButton').click(function() {
        ContextManager.set_text({
            post: {
                'id': $('#modelId').val(),
                'type': 'scenario',
                'text': scenarioEditor.getValue()
            }
        });
    });

    $('#editQueryButton').click(function() {

        ContextManager.get_query({
            success: function(res) {
                showQueryEditor();
                //$('#queryEditor').find('.editor').val(res.body);
                queryEditor.setValue(res.body);
            }
        });
    });

    $('#runQueryButton').click(function() {

        var text = queryEditor.getValue();

        ContextManager.run_query({
            post: {
                'text': text
            },
            success: function(res) {

                if (res.isError) {
                    alert(res.body.message);
                }

                var arrays = res.body.arrays;
                var table = {};
                var stack = [];

                for (var name in arrays) {

                    var fields = arrays[name];

                    for (var field in fields) {
                        var ref = fields[field];
                        if (table[field] === undefined) {
                            table[field] = {};
                            for (var i = 0; i < stack.length; i++) {
                                var temp = stack[i];
                                table[field][temp] = null;
                            }
                        }
                        table[field][name] = ref;
                    }
                    stack.push(name);
                }

                var elem = $(buildTable(table));
                $('#resultsBox').append(elem);
                $('#resultsBox').show();
            }
        });
    });

    function buildTable(table) {

        var colNames = [];
        var rowNames = [];
        var data = [];

        var row = 0;
        var col = 0;

        for (var colName in table) {
            colNames.push(colName);
            rowNames = [];
            data[col] = [];
            for (var rowName in table[colName]) {
                rowNames.push(rowName);
                data[col][row++] = table[colName][rowName];
            }
            row = 0;
            col++;
        }

        var rows = data[0].length;
        var cols = data.length;

        var html = '<table>';
        html += '<tr><td></td>';

        for (var col = 0; col < cols; col++) {
            html += '<td class="colLabel">' + colNames[col] + '</td>';
        }

        html += '</tr>';

        for (var row = 0; row < rows; row++) {
            html += '<tr>';
            html += '<td class="rowLabel">' + rowNames[row] + '</td>';
            for (var col = 0; col < cols; col++) {
                html += '<td>';
                var elem = data[col][row];
                if (elem !== null) {
                    if (elem.value !== undefined) {
                        if (elem.unit !== undefined && elem.unit === '%') {
                            html += $.number(elem.value * 100) + '%';
                        } else {
                            html += $.number(elem.value);
                        }
                    } else {
                        html += $.number(elem.mean);
                    }
                }
                html += '</td>';
            }
            html += '</tr>';
        }

        html += '</table>';
        return html;
    }
});