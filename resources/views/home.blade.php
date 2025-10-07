<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
    <meta name="author" content="#">
    <title>Canal Service - Dashboard</title>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('template/favicon.png') }}" type="image/png">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/nucleo/css/nucleo.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}" type="text/css">
    <!-- Page plugins -->
    <!-- Argon CSS -->
    <link rel="stylesheet" href="{{ asset('template/assets/css/argon.css?v=1.1.0') }}" type="text/css">

    <!-- CSS -->
    <link href="https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.1.1/css/buttons.dataTables.min.css" rel="stylesheet">
</head>

<body>
<!-- Sidenav -->
@include('layouts.navbar')
<!-- Main content -->
<div class="main-content" id="panel">
    <!-- Topnav -->
    @include('layouts.topnav')
    <!-- Header -->
    <!-- Header -->
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">
                            Dashboard
                            @if(Auth::guard('client')->user())
                                <span class="badge badge-secondary">{{ 'Cliente' }}</span>
                            @endif
                        </h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="#">Resumo das atividades no sistema</a></li>
                            </ol>
                        </nav>
                    </div>
                    <!-- <div class="col-lg-6 col-5 text-right">
                      <a href="#" class="btn btn-sm btn-neutral">New</a>
                      <a href="#" class="btn btn-sm btn-neutral">Filters</a>
                    </div> -->
                </div>
                <!-- Card stats -->
                <div class="row">
                    @foreach($middles as $middle)
                    <div class="col-xl-20 col-md-6">
                        <div class="card card-stats">
                            <!-- Card body -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Clippings {{ $middle->get('name') }}</h5>
                                        <span class="h2 font-weight-bold mb-0">{{ $middle->get('count_clippings') }}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape {{ $middle->get('background_class') }} text-white rounded-circle shadow">
                                            <i class="{{ $middle->get('icon') }}"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-sm">
                                    @php($arrow = 'fa-times')
                                    @php($arrow = $middle->get('direction') === 'desc' ? 'fa-arrow-down' : $arrow)
                                    @php($arrow = $middle->get('direction') === 'asc' ? 'fa-arrow-up' : $arrow)
                                    @php($color = 'text-silver')
                                    @php($color = $middle->get('direction') === 'desc' ? 'text-danger' : $color)
                                    @php($color = $middle->get('direction') === 'asc' ? 'text-success' : $color)
                                    <span class="{{ $color }} mr-2"><i class="fa {{ $arrow }}"></i> {{ $middle->get('percentage') }}%</span>
                                    <span class="text-nowrap">Desde o mês passado</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col-xl-8">
                <div class="card bg-default-1">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="text-light text-uppercase ls-1 mb-1">Últimos 6 meses</h6>
                                <h5 class="h3 text-white mb-0">Total de Cippings</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Chart -->
                        <div class="chart">
                            <!-- Chart wrapper -->
                            <canvas id="chart-sales-dark-home" class="chart-canvas"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header">
                        <!-- Surtitle -->
                        <h6 class="surtitle">Últimos 6 meses</h6>
                        <!-- Title -->
                        <h5 class="h3 mb-0">Classificação de Clippings (%)</h5>
                    </div>
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="chart">
                            <!-- Chart wrapper -->
                            <canvas id="chart-pie-home" class="chart-canvas"></canvas>
                        </div>
                        <div class="pl-1 mt--4">
                            <div class="row">
                                <div class="col-md-6">
                                    <span class="square bg-success p-2 mt-1 mr-2" style="width: 2px; height: 5px; display: block; float:left;"></span>
                                    <h5>Positivo: {{ $percentage['positive'] }}%</h5>
                                </div>
                                <div class="col-md-6">
                                    <span class="square bg-danger p-2 mt-1 mr-2" style="width: 2px; height: 5px; display: block; float:left;"></span>
                                    <h5>Negativo: {{ $percentage['negative'] }}%</h5>
                                </div>
                                <div class="col-md-6"><span class="square bg-info p-2 mt-1 mr-2" style="width: 2px; height: 5px; display: block; float:left;"></span>
                                    <h5>Neutro: {{ $percentage['neuter'] }}%</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <footer class="footer pt-0">
            <div class="row align-items-center justify-content-lg-between">
                <div class="col-lg-12">
                    <div class="copyright text-center text-muted">
                        &copy; 2020 <a href="#" class="font-weight-1 ml-1" target="_blank">Canal Grupo - Todos os direitos reservados.</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<!-- Argon Scripts -->
<!-- Core -->
<script src="{{ asset('template/assets/vendor/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('template/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('template/assets/vendor/js-cookie/js.cookie.js') }}"></script>
<script src="{{ asset('template/assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
<script src="{{ asset('template/assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>
<!-- Optional JS -->
<script src="{{ asset('template/assets/vendor/chart.js/dist/Chart.min.js') }}"></script>
<script src="{{ asset('template/assets/vendor/chart.js/dist/Chart.extension.js') }}"></script>
<!-- Argon JS -->
<script src="{{ asset('template/assets/js/argon.js?v=1.1.0') }}"></script>
<!-- Demo JS - remove this in your project -->
<script src="{{ asset('template/assets/js/demo.min.js') }}"></script>
<script>
    var labels = [];
    var data = [];
    @foreach($clippings_per_month as $clip)
        labels.push(['{{ $clip['monthName'].'/'.$clip['year'] }}']);
        data.push('{{ $clip['total'] }}');
    @endforeach

    var SalesChart = (function() {

        // Variables

        var $chart = $('#chart-sales-dark-home');


        // Methods

        function init($this) {
            var salesChart = new Chart($this, {
                type: 'line',
                options: {
                    scales: {
                        yAxes: [{
                            gridLines: {
                                color: Charts.colors.gray[700],
                                zeroLineColor: Charts.colors.gray[700]
                            },
                            ticks: {
                                suggestedMin: 0,
                                suggestedMax: '{{ $maxTickClippings }}'
                            }
                        }]
                    }
                },
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total de clippings / mês',
                        data: data
                    }]
                }
            });
            // Save to jQuery object
            $this.data('chart', salesChart);
        };


        // Events

        if ($chart.length) {
            init($chart);
        }

    })();

    // Percentage By Classification
    var PieChart = (function() {

        // Variables

        var $chart = $('#chart-pie-home');


        // Methods

        function init($this) {
            var randomScalingFactor = function() {
                return Math.round(Math.random() * 100);
            };

            var pieChart = new Chart($this, {
                type: 'pie',
                data: {
                    labels: [
                        'Positivo',
                        'Negativo',
                        'Neutro'
                    ],
                    datasets: [{
                        data: [
                            '{{ $percentage['positive'] }}',
                            '{{ $percentage['negative'] }}',
                            '{{ $percentage['neuter'] }}'
                        ],
                        backgroundColor: [
                            Charts.colors.theme['success'],
                            Charts.colors.theme['danger'],
                            Charts.colors.theme['info']
                        ],
                        label: 'Dataset 1'
                    }],
                },
                options: {
                    responsive: true,
                    legend: {
                        position: 'top',
                    },
                    animation: {
                        animateScale: true,
                        animateRotate: true
                    }
                }
            });

            // Save to jQuery object

            $this.data('chart', pieChart);

        };


        // Events

        if ($chart.length) {
            init($chart);
        }

    })();
</script>
</body>

</html>
