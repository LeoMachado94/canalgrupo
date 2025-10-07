@extends('layouts.app')

@section('content')
    <!-- Header -->
    @include('layouts.header', [
        'header_title' => 'Relatórios',
        'header_subtitle' => 'Veja aqui todos os relatórios sobre seus clientes',
        'header_subtitle_icon' => 'ni ni-chart-pie-35'
    ])
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card" style="padding: 0 1rem;">
                    <!-- Card header -->
                    <div class="card-header pl-0 border-0">
                        <h3 class="mb-0">Relatórios</h3>
                    </div>
                    <!-- Card body -->
                    <div class="card-body">
                        <!-- Form groups used in grid -->
                        <form class="form-generate" method="GET" action="" onsubmit="return false;" enctype="multipart/form-data" id="FormReport">
                            {{ csrf_field() }}
                            <input type="hidden" style="display: none" name="input_chart_clippings" id="input_chart_clippings">
                            <input type="hidden" style="display: none" name="input_chart_classification" id="input_chart_classification">
                            <input type="hidden" style="display: none" name="input_chart_source" id="input_chart_source">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="Client">Cliente</label>
                                        <select class="form-control @error('client_id')is-invalid @enderror" name="client_id"
                                                id="Client" data-toggle="select">
                                            <option>Selecione o cliente</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="Middle">Meio</label>
                                        <select class="form-control @error('middle_id')is-invalid @enderror" name="middle_id"
                                                id="Middle" data-toggle="select">
                                            <option>Selecione o meio</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="StartDate">Data inicial</label>
                                        <input name="start_date" class="form-control datepicker" value="{{ old('start_date', '') }}"
                                               placeholder="Selecione a data" type="text" id="StartDate">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="EndDate">Data final</label>
                                        <input name="end_date" class="form-control datepicker" value="{{ old('end_date', '') }}"
                                               placeholder="Selecione a data" type="text" id="EndDate">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group text-right">
                                        <button type="button" class="btn btn-success" id="reportGenerate">Gerar relatório</button>
                                    </div>
                                </div>
                            </div>
                        </form>
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
    @include('reports.includes.modalGeneratingReport')
    <div id="charts">
        <div id="div_chart_clippings"></div>
        <div id="div_chart_classification"></div>
        <div id="div_chart_source"></div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/DateTimePicker/css/bootstrap-material-datetimepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('template/assets/css/bootstrap/bootstrap.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/plugins/jquery_mask/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('template/assets/vendor/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('template/assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('template/assets/vendor/bootstrap-datepicker/dist/locales/bootstrap-datepicker.pt-BR.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/momentjs/moment.js') }}"></script>
    <script src="{{ asset('assets/plugins/axios/axios.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/google_chart/loader.js') }}"></script>
    <script src="{{ asset('assets/js/clippings/charts/clippings_by_vehicle.js') }}"></script>
    <script src="{{ asset('assets/js/clippings/charts/clippings_by_classification.js') }}"></script>
    <script src="{{ asset('assets/js/clippings/charts/clippings_by_source.js') }}"></script>
    <script>
        // Default Format Datepicker
        $.fn.datepicker.defaults.format = "dd/mm/yyyy";
        $.fn.datepicker.defaults.language = "pt-BR";

        $('.date').mask('00/00/0000', {placeholder: '__/__/____'});

        // Load Clients
        function loadClient() {
            $.ajax({
                type: 'GET',
                url: '{{ route('ajax.clients.lists') }}',
                success: function (res) {
                    populateSelect('#Client', res, 'Selecione o cliente', null);
                }
            });
        }

        // Load Clients
        function loadMiddle() {
            $.ajax({
                type: 'GET',
                url: '{{ route('ajax.middles.lists') }}',
                success: function (res) {
                    populateSelect('#Middle', res, 'Selecione o meio', null);
                }
            });
        }

        function populateSelect(element, data, defaultText, setDefault=0, textAttribute='name')
        {
            $(element).html('');
            $(element).append('<option value="0">'+defaultText+'</option>');

            $(data).each(function (index, value) {
                let text;
                if (textAttribute === 'title') {
                    text = value.title;
                } else {
                    text = value.name
                }
                $(element).append('<option value="'+value.id+'">'+text+'</option>')
            });

            if (setDefault) {
                $(element).val(setDefault).trigger('change.select2');
            }
        }

        $(document).ready(function () {
            loadClient();
            loadMiddle();

            var clippingsByVehicle;
            var clippingsByClassification;
            var clippingsBySource;

            // load charts packages
            google.charts.load("current", {packages:['bar', 'corechart']});
        });
    </script>
    <script>
        var generatingReporting = false;

        $('body').on('click', '#reportGenerate', function(e) {
            e.preventDefault();

            if (generatingReporting) {
                swal({
                    title: 'Já estamos gerando um relatório.',
                    text: 'Já estamos gerando um relatório...Aguarde a conclusão para gerar outro.',
                    icon: 'warning',
                    button: "OK!",
                });
            }

            var data = [];
            data['client'] = document.querySelector('#Client').value;
            data['middle'] = document.querySelector('#Middle').value;
            data['start_date'] = document.querySelector('#StartDate').value;
            data['end_date'] = document.querySelector('#EndDate').value;

            var month = data['start_date'];
            month = parseInt(moment(month, "DD/MM/YYYY").format("MM"));
            month = getMonthByInt(month);

            if (validateFiltersReportGenerate(data)) {
                $('#modal-loading').modal('show');
                $(this).removeClass('btn-success');
                $(this).addClass('btn-secondary');
                generatingReporting = true;

                var formData = {
                    'client_id': $('#Client').val(),
                    'middle_id': $('#Middle').val(),
                    'start_date': $('#StartDate').val(),
                    'end_date': $('#EndDate').val(),
                    '_token': '{{ csrf_token() }}'
                };

                axios.post('{{ route('ajax.reports.graphsData') }}', formData).then((response) => {
                    clippingsByVehicle = response.data.clippings_by_vehicle;
                    google.charts.setOnLoadCallback(drawChartClippings);
                    clippingsByClassification = response.data.clippings_by_classification;
                    google.charts.setOnLoadCallback(drawChartClassification);
                    clippingsBySource = response.data.clippings_by_source;
                    google.charts.setOnLoadCallback(drawChartSource);

                    setTimeout(function() {
                        if (validateImageCharts()) {
                            generateReport();
                        }
                    }, 3000);
                }, (error) => {
                    $(this).removeClass('btn-secondary');
                    $(this).addClass('btn-success');
                    generatingReporting = false;
                    $('#modal-loading').modal('hide');
                });
            }
        });

        function validateFiltersReportGenerate(data)
        {
            if (data['client'] === '0') {
                swal({
                    title: 'Verifique os filtros.',
                    text: 'Você precisa selecionar um cliente...',
                    icon: 'warning',
                    button: "OK!",
                });
                return false;
            } else if (data['start_date'] === '' || data['end_date'] === '') {
                swal({
                    title: 'Verifique os filtros.',
                    text: 'Você precisa selecionar as datas de início e fim...',
                    icon: 'warning',
                    button: "OK!",
                });
                return false;
            }

            return true;
        }

        function validateImageCharts()
        {
            var chart_clippings = document.querySelector('#input_chart_clippings').value ?? '';
            var chart_classification = document.querySelector('#input_chart_classification').value ?? '';
            var chart_source = document.querySelector('#input_chart_source').value ?? '';

            // if (chart_clippings === '' || chart_classification === '' || chart_source === '') {
            //     swal({
            //         title: 'Ocorreu um erro!',
            //         text: 'Alguns gráficos não puderam ser gerados, por favor, verifique os filtros e atualize a página.',
            //         icon: 'error',
            //         button: "OK!",
            //     });
            //     return false;
            // }
            return true;
        }

        function generateReport()
        {
            var formData = new FormData(document.querySelector('#FormReport'))

            var month = document.querySelector('#StartDate').value;
            month = parseInt(moment(month, "DD/MM/YYYY").format("MM"));
            month = getMonthByInt(month);

            $.ajax({
                type: 'POST',
                data: formData,
                url: '{{ route('ajax.reports.generate') }}',
                processData: false,
                contentType: false,
                success: function (res) {
                    $(this).removeClass('btn-secondary');
                    $(this).addClass('btn-success');
                    generatingReporting = false;
                    $('#modal-loading').modal('hide');

                    var route = '{{ route('reports.show', 'FILENAME') }}';
                    route = route.replace('FILENAME', res.fileName) + '?client_id=' + res.client+'&month='+month;
                    window.location.href = route;
                }
            });
        }

        function getMonthByInt(month)
        {
            var monthText = '';
            switch (month) {
                case 1:
                    monthText = 'Janeiro';
                    break;
                case 2:
                    monthText = 'Fevereiro';
                    break;
                case 3:
                    monthText = 'Março';
                    break;
                case 4:
                    monthText = 'Abril';
                    break;
                case 5:
                    monthText = 'Maio';
                    break;
                case 6:
                    monthText = 'Junho';
                    break;
                case 7:
                    monthText = 'Julho';
                    break;
                case 8:
                    monthText = 'Agosto';
                    break;
                case 9:
                    monthText = 'Setembro';
                    break;
                case 10:
                    monthText = 'Outubro';
                    break;
                case 11:
                    monthText = 'Novembro';
                    break;
                case 12:
                    monthText = 'Dezembro';
                    break;
            }
            return monthText;
        }
    </script>
@endsection
