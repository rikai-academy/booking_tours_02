$(document).ready(function () {
    $.ajax({
        url: '/admin/chart',
        method: 'GET',
        success: function (result) {
            chartData(result.date, result.data)
        }
    })
})
$('#btn_sort').on('click', function () {
    var dateTo = $('#dateTo').val();
    var dateFrom = $('#dateFrom').val();
    var token = $('input[name="_token"]').val()
    $.ajax({
        url: '/admin/filterDate',
        method: 'POST',
        data: {
            dateFrom: dateFrom,
            dateTo: dateTo,
            _token: token
        },
        success: function (result) {
            removeCanvas();
            chartData(result.date, result.data);
            $('#add_btn_export').append('<a href="/admin/export-excel/date" id="btn_export" class="btn btn-success mt-2">Export Excel</a>');
        }
    });
})

function chartData(dates, datas) {
    var salesChartCanvas = document.getElementById('revenue-chart-canvas').getContext('2d');
    var salesChartOptions = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
            display: false
        },
        scales: {
            xAxes: [{
                gridLines: {
                    display: false
                }
            }],
            yAxes: [{
                gridLines: {
                    display: false
                }
            }]
        }
    }
    var lable = [];
    var data = [];
    for (var i = 0; i < dates.length; i++) {
        lable.push(dates[i]);
        data.push(datas[i]);
    }
    var salesChartData = {
        labels: lable,
        datasets: [
            {
                label: 'Doanh thu',
                backgroundColor: 'rgba(60,141,188,0.9)',
                borderColor: 'rgba(60,141,188,0.8)',
                pointRadius: false,
                pointColor: '#3b8bba',
                pointStrokeColor: 'rgba(60,141,188,1)',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data: data
            }
        ]
    }
    var salesChart = new Chart(salesChartCanvas, { // lgtm[js/unused-local-variable]
        type: 'line',
        data: salesChartData,
        options: salesChartOptions
    })
}

function removeCanvas() {
    $('#btn_export').remove();
    $('#revenue-chart-canvas').remove();
    $('#revenue-chart').append('<canvas id="revenue-chart-canvas" height="300" style="height: 500px;"></canvas>');
}

$('#selectSort').on('change', function () {
    var filter = $(this).val();
    var token = $('input[name="_token"]').val()
    $.ajax({
        url: '/admin/filterBy',
        method: 'POST',
        data: {
            filter: filter,
            _token: token
        },
        success: function (result) {
            removeCanvas();
            chartData(result.date, result.data);
            $('#add_btn_export').append('<a href="/admin/export-excel/' + result.export_by + '" id="btn_export" class="btn btn-success mt-2">Export Excel</a>')
        }
    });
})
$('.dateformat').datepicker({
    uiLibrary: 'bootstrap4',
    "dateFormat": "dd/mm/yy"
});
$('input').attr('autocomplete', 'off')

