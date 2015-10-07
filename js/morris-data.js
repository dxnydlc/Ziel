$(function() {
    new Morris.Line({
        // ID of the element in which to draw the chart.
        element: 'morris-area-chart',
        // Chart data records -- each entry in this array corresponds to a point on
        // the chart.
        data: _data_grafico,
        // The name of the data record attribute that contains x-values.
        xkey: 'day',
        // A list of names of data record attributes that contain y-values.
        ykeys: ['total'],
        // Labels for the ykeys -- will be displayed when you hover over the
        // chart.
        labels: ['day'],
        /*dateFormat:function (x) { return new Date(x).toString(); },*/
        preUnits: 'S/ ',
        pointSize: 2,
        hideHover: 'auto',
        resize: true
    });

    /*Morris.Area({
        element: 'morris-area-chart',
        data: _data_grafico ,
        xkey: 'period',
        ykeys: ['Fecha', 'Total'],
        labels: ['Fecha', 'Total', 'iPod Touch'],
        pointSize: 2,
        hideHover: 'auto',
        resize: true
    });*/

    Morris.Donut({
        element: 'morris-donut-chart',
        data: _data_dona,
        resize: true
    });

    /*Morris.Bar({
        element: 'morris-bar-chart',
        data: [{
            y: '2006',
            a: 100,
            b: 90
        }, {
            y: '2007',
            a: 75,
            b: 65
        }, {
            y: '2008',
            a: 50,
            b: 40
        }, {
            y: '2009',
            a: 75,
            b: 65
        }, {
            y: '2010',
            a: 50,
            b: 40
        }, {
            y: '2011',
            a: 75,
            b: 65
        }, {
            y: '2012',
            a: 100,
            b: 90
        }],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Series A', 'Series B'],
        hideHover: 'auto',
        resize: true
    });*/

});
