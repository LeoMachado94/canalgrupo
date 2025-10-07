function drawChartClippings(
    divID = 'div_chart_clippings',
    inputID = 'input_chart_clippings'
) {
    var columns = []; columns.push('Quantidade');
    var columnValues = []; columnValues.push('Veiculos');

    // graphsData.clippings_by_vehicle
    $.each(clippingsByVehicle, function(index, value) {
        columns.push('('+value.qtde+') '+value.name);
    });

    $.each(clippingsByVehicle, function(index, value) {
        columnValues.push(value.qtde);
    });

    var data = google.visualization.arrayToDataTable([
        columns,
        columnValues
    ]);

    var options = {
        width: 600,
        height: 400,
        title: 'Clippings por Veículo',
        titleFontSize: 18,
        fontSize: 18,
        legend: {
            textStyle: {fontSize: 16},
        },
        chartArea:{left:50,top:50,bottom: 50}
    };

    var chart_div = document.getElementById(divID);
    var chart = new google.visualization.ColumnChart(chart_div);

    // Wait for the chart to finish drawing before calling the getImageURI() method.
    google.visualization.events.addListener(chart, 'ready', function () {
        document.getElementById(inputID).value = chart.getImageURI();
        document.getElementById(divID).style.display = "none";
    });

    chart.draw(data, options);
}
