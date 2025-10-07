function drawChartSource(
    divID = 'div_chart_source',
    inputID = 'input_chart_source'
) {

    var columnValues = [];
    columnValues.push(['Fonte', 'Qtde']);

    // graphsData.clippings_by_source
    $.each(clippingsBySource, function (index, value) {
        columnValues.push([value.name + ' (' + value.qtde + ')', value.qtde]);
    });


    var data = google.visualization.arrayToDataTable(columnValues);
    var count  = data.getNumberOfRows();

    var options = {
        title: 'Por Fonte',
        titleFontSize: 18,
        pieHole: 0.4,
        width: 600,
        height: 600,
        fontSize: 18,
        legend: {
            position: 'bottom', orientation: 'horizontal',
            textStyle: {fontSize: 16},
        },
        chartArea:{left:50,top:50,bottom:50, width: "100%"},
    };

    var chart = new google.visualization.PieChart(document.getElementById(divID));
    // Wait for the chart to finish drawing before calling the getImageURI() method.
    google.visualization.events.addListener(chart, 'ready', function () {
        document.getElementById(inputID).value = chart.getImageURI();
        document.getElementById(divID).style.display = "none";
    });

    chart.draw(data, options);
}
