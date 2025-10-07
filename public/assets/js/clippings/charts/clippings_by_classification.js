function drawChartClassification(
    divID = 'div_chart_classification',
    inputID = 'input_chart_classification'
) {
    var columnValues = []; columnValues.push(['Por Classificação', 'Qtde']);
    var slicesColor = [];

    // graphsData.clippings_by_classification
    $.each(clippingsByClassification, function(index, value) {
        columnValues.push([value.name+' ('+value.qtde+')', value.qtde]);
        slicesColor.push({color: value.color});
    });

    var data = google.visualization.arrayToDataTable(columnValues);

    var options = {
        title: 'Por Classificação',
        width: 600,
        height: 600,
        titleFontSize: 18,
        fontSize: 18,
        legend: {
            position: 'bottom', orientation: 'horizontal',
            textStyle: {fontSize: 16},
        },
        chartArea:{left:50,top:50,bottom:50, width: "100%"},
        slices: slicesColor
    };

    var chart = new google.visualization.PieChart(document.getElementById(divID));
    // Wait for the chart to finish drawing before calling the getImageURI() method.
    google.visualization.events.addListener(chart, 'ready', function () {
        document.getElementById(inputID).value = chart.getImageURI();
        document.getElementById(divID).style.display = "none";
    });

    chart.draw(data, options);
}
