@extends('layouts.app')

@section('content')
    <!-- Header -->
    @include('layouts.header', [
        'header_title' => 'Clippings',
        'header_subtitle' => 'Veja aqui todos os clippings cadastrados',
        'header_subtitle_icon' => 'fas fa-clipboard-list',
        'btns' => [
            [
            'icon' => 'fas fa-plus',
            'text' => 'Cadastrar novo',
            'link' => route('clippings.create')
            ]
        ]
    ])
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card" id="table" style="padding: 0 1rem;">
                    <!-- Card header -->
                    <div class="card-header pl-0 border-0 row">
                        <div class="col-md-6">
                            <h3 class="mb-0">Lista de clippings</h3>
                        </div>
                        <div class="col-md-6" style="padding: 0; margin: 0;">
                            <button class="btn btn-sm btn-dark float-right mr--2 filter-show">
                                <i class="fa fa-plus"></i> Filtros
                            </button>
                            <a href="#" target="_blank" id="reportGenerate"
                               class="btn btn-sm btn-primary float-right mr-2">
                                <i class="fa fa-file-pdf"></i> Gerar relatório
                            </a>
                        </div>
                    </div>
                    <div class="filters bg-secondary p-3 mb-2">
                        <form name="filters" method="GET" id="FormFilter" action="{{ route('clippings.index') }}">
                        <div class="row">
                            <!-- Cliente -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="Client">Cliente</label>
                                    <select name="client_id" class="form-control" data-toggle="select"
                                            @if(Auth::guard('client')->user()) disabled @endif id="Client">
                                        <option>Selecione o Cliente</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Middle -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="Middle">Meio</label>
                                    <select name="middle_id" class="form-control" data-toggle="select" id="Middle">
                                        <option>Selecione o Meio</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Vehicle -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="Vehicle">Veículo</label>
                                    <select name="vehicle_id" class="form-control" data-toggle="select" id="Vehicle">
                                        <option>Selecione o Veículo</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Exhbition -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="Exhibition">Exibição</label>
                                    <select name="exhibition_id" class="form-control" data-toggle="select" id="Exhibition">
                                        <option>Selecione a Exibição</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Classification -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="Classification">Classificação</label>
                                    <select name="classification_id" class="form-control" data-toggle="select" id="Classification">
                                        <option>Selecione a Classificação</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Source -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="Source">Fonte</label>
                                    <select name="source_id" class="form-control" data-toggle="select" id="Source">
                                        <option>Selecione a Fonte</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Date -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="StartDate">Veiculação entre:</label>
                                    <input type="text" name="start_date" class="form-control date datepicker" id="StartDate"
                                            value="{{ request()->query('start_date') ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="EndDate">até:</label>
                                    <input type="text" name="end_date" class="form-control date datepicker" id="EndDate"
                                           value="{{ request()->query('end_date') ?? '' }}">
                                </div>
                            </div>
                            <!-- Users -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="User">Usuário</label>
                                    <select name="user_id" class="form-control" data-toggle="select" id="User">
                                        <option>Selecione o Usuário</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Buscar -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="Search">Pesquisar por <small>(Assunto ou Título da Notícia)</small></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-search"></i></span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Digite o que está buscando"
                                               aria-label="Username" name="title" aria-describedby="basic-addon1" id="Search">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success float-right"><i class="fa fa-filter"></i> Filtrar</button>
                            </div>
                        </div>
                        </form>
                        <input type="hidden" style="display: none" name="input_chart_clippings" id="input_chart_clippings">
                        <input type="hidden" style="display: none" name="input_chart_classification" id="input_chart_classification">
                        <input type="hidden" style="display: none" name="input_chart_source" id="input_chart_source">
                    </div>
                    <!-- Light table -->
                    <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <tr>
                            <th>Nº</th>
                            <th>Data de Veiculação</th>
                            <th>Assunto</th>
                            <th>Cliente</th>
                            <th>Exibição</th>
                            <th>Meio</th>
                            <th>Classificação</th>
                            <th>Usuário</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody class="list">
                        </tbody>
                    </table>
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

    <div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="modal-delete" aria-hidden="true">
        <div class="modal-dialog modal-danger modal-dialog-centered modal-10" role="document">
            <div class="modal-content bg-gradient-danger">

                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-delete">ATENÇÃO</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="py-3 text-center">
                        <i class="ni ni-bell-55 ni-3x"></i>
                        <h4 class="heading mt-4">Excluir clipping ?</h4>
                        <p>Após a exclusão será impossível recuperar o registro.</p>
                    </div>
                </div>

                <div class="modal-footer">
                    <form id="form-delete" type="POST" action="#">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-white btn-delete">Ok, Excluir!</button>
                    </form>
                    <button type="button" class="btn btn-link text-white ml-auto" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @include('reports.includes.modalGeneratingReport')
    <div id="charts">
        <div id="div_chart_clippings"></div>
        <div id="div_chart_classification"></div>
        <div id="div_chart_source"></div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('template/assets/css/extras.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/1.10.18/css/dataTables.bootstrap4.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/DateTimePicker/css/bootstrap-material-datetimepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('template/assets/css/bootstrap/bootstrap.css') }}">
@endsection

@section('scripts')

<!-- Optional JS -->
<script src="{{ asset('assets/plugins/datatables/1.10.18/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/1.10.18/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('template/assets/vendor/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery_mask/jquery.mask.min.js') }}"></script>
<script src="{{ asset('template/assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('template/assets/vendor/bootstrap-datepicker/dist/locales/bootstrap-datepicker.pt-BR.min.js') }}"></script>
<script src="{{ asset('assets/plugins/momentjs/moment.js') }}"></script>
<script src="{{ asset('assets/plugins/google_chart/loader.js') }}"></script>
<script src="{{ asset('assets/js/clippings/charts/clippings_by_vehicle.js') }}"></script>
<script src="{{ asset('assets/js/clippings/charts/clippings_by_classification.js') }}"></script>
<script src="{{ asset('assets/js/clippings/charts/clippings_by_source.js') }}"></script>

<script>
    // Default Format Datepicker
    $.fn.datepicker.defaults.format = "dd/mm/yyyy";
    $.fn.datepicker.defaults.language = "pt-BR";

    var clientId = '{{ request()->query('client_id') }}' ? '{{ request()->query('client_id') }}' : 0;
    @if(Auth::guard('client')->user())
        clientId = '{{ Auth::guard('client')->user()->id }}';
    @endif

    var exhibitionId = '{{ request()->query('exhibition_id') }}' ? '{{ request()->query('exhibition_id') }}' : 0;
    var middleId = '{{ request()->query('middle_id') }}' ? '{{ request()->query('middle_id') }}' : 0;
    var classificationId = '{{ request()->query('classification_id') }}' ? '{{ request()->query('classification_id') }}' : 0;
    var sourceId = '{{ request()->query('source_id') }}' ? '{{ request()->query('source_id') }}' : 0;
    var userId = '{{ request()->query('user_id') }}' ? '{{ request()->query('user_id') }}' : 0;
    var vehicleId = '{{ request()->query('vehicle_id') }}' ? '{{ request()->query('vehicle_id') }}' : 0;

    let columns = [
        { data: 'id', name: 'id' },
        { data: 'date', name: 'date' },
        { data: 'subject', name: 'subject' },
        { data: 'client', name: 'client'},
        { data: 'exhibition', name: 'exhibition'},
        { data: 'middle', name: 'middle'},
        { data: 'classification', name: 'classification'},
        { data: 'user', name: 'user'},
        { data: 'actions', name: 'actions'}
    ];

    let date = {
        "targets": 1,
        "data": "date",
        "render": function(data, type, row, meta) {
            if(type === 'display') {
                var date = moment(row.date, "YYYY-MM-DD");
                return date.format("DD/MM/YYYY");
            }
            return row.date === null ? '' : row.date;
        }

    }

    let created = {
        "targets": 2,
        "data": "subject",
        "render": function(data, type, row, meta) {
            if (row.subject !== null && row.subject !== undefined) {
                let title = row.subject === null || row.subject === undefined ? '' : row.subject.title;
                let showRoute = '{{ route('clippings.show', 'ID') }}';
                showRoute = showRoute.replace('ID', row.id);
                return '<a href="'+showRoute+'">' + title + '</a>';
            }
        }
    };

    let client = {
        "targets": 3,
        "data": "client",
        "render": function(data, type, row, meta) {
            return row.client === null ? '' : row.client.name;
        }
    };

    let exhibition = {
        "targets": 4,
        "data": "exhibition",
        "render": function(data, type, row, meta) {
            return row.exhibition === null ? '' : row.exhibition.name;
        }
    };

    let middle = {
        "targets": 5,
        "data": "middle",
        "render": function(data, type, row, meta) {
            return row.middle === null ? '' : row.middle.name;
        }
    };

    let classification = {
        "targets": 6,
        "data": "classification",
        "render": function(data, type, row, meta) {
            let status_bg;
            if (row.classification !== null && parseInt(row.classification.id) === 1) {
                status_bg = 'bg-success';
            }
            if (row.classification !== null && parseInt(row.classification.id) === 3) {
                status_bg = 'bg-danger';
            }
            if (row.classification !== null && parseInt(row.classification.id) !== 1 && parseInt(row.classification.id) !== 3) {
                status_bg = 'bg-dark';
            }

            let html;
            if (row.classification === null) {html = '<span class="badge badge-dot mr-4">\n' +
                    '<i class="bg-dark"></i>\n' +
                    '<span class="status">Indefinido</span>\n' +
                    '</span>';
            } else {
                html = '<span class="badge badge-dot mr-4">\n' +
                    '<i class="'+status_bg+'"></i>\n' +
                    '<span class="status">'+row.classification.name+'</span>\n' +
                    '</span>';
            }

            return html;
        }
    };

    let user = {
        "targets": 7,
        "data": "user",
        "render": function(data, type, row, meta) {
            return row.user === null ? '' : row.user.name;
        }
    };

    let actions = {
        "targets": 8,
        "data": "actions",
        "render": function(data, type, row, meta) {
            let id = row.id;
            let showRoute = '{{ route('clippings.show', 'ID') }}';
            let editRoute = '{{ route('clippings.edit', 'ID') }}';
            let deleteRoute = '{{ route('ajax.clippings.destroy', 'ID') }}';
            showRoute = showRoute.replace('ID', id);
            editRoute = editRoute.replace('ID', id);
            deleteRoute = deleteRoute.replace('ID', id);
            @if(!Auth::guard('client')->user())
            let btns = '<a href="'+showRoute+'" class="table-action table-action-visualizar" data-toggle="tooltip" data-original-title="Visualizar">' +
                '<i class="fas fa-eye"></i>' +
                '</a>' +
                '<a href="'+editRoute+'" class="table-action table-action-edit" data-toggle="tooltip" data-original-title="Editar">' +
                '<i class="far fa-edit"></i>' +
                '</a>' +
                '<a href="#" class="table-action table-action-delete btn-delete" data-route="'+deleteRoute+'" data-toggle="modal" data-target="#modal-delete" data-original-title="Deletar">' +
                '<i class="fas fa-trash"></i>' +
                '</a>';
            @else
            let btns = '<a href="'+showRoute+'" class="table-action table-action-visualizar" data-toggle="tooltip" data-original-title="Visualizar">' +
                '<i class="fas fa-eye"></i>' +
                '</a>';
            @endif
            return btns;
        }
    };

    let columnDefs = [
        date,
        created,
        client,
        exhibition,
        middle,
        classification,
        user,
        actions
    ];

    const urlParams = new URLSearchParams(window.location.search);

    // Populate Select function
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

    // Load Clients
    function loadClient(element = null, setDefault = 0) {
        if (element === null) {
            element = '#Client';
        }
        $.ajax({
            type: 'GET',
            url: '{{ route('ajax.clients.lists') }}',
            success: function (res) {
                populateSelect(element, res, 'Selecione o cliente', setDefault);
            }
        });
    }

    // Load Exhibitions
    function loadExhibition(element = null, setDefault = 0) {
        if (element === null) {
            element = '#Exhibition';
        }
        $.ajax({
            type: 'GET',
            url: '{{ route('ajax.exhibitions.lists') }}',
            success: function (res) {
                populateSelect(element, res, 'Selecione a exibição', setDefault);
            }
        });
    }

    // Load Sources
    function loadSource() {
        $.ajax({
            type: 'GET',
            url: '{{ route('ajax.sources.lists') }}',
            success: function (res) {
                populateSelect('#Source', res, 'Selecione a fonte', sourceId);
            }
        });
    }

    // Load Middles
    function loadMiddle(element = null, setDefault = 0) {
        if (element === null) {
            element = '#Middle';
        }
        $.ajax({
            type: 'GET',
            url: '{{ route('ajax.middles.lists') }}',
            success: function (res) {
                populateSelect(element, res, 'Selecione o meio', setDefault);
            }
        });
    }

    // Load classifications
    function loadClassification(element = null, setDefault = 0) {
        if (element === null) {
            element = '#Classification';
        }
        $.ajax({
            type: 'GET',
            url: '{{ route('ajax.classifications.lists') }}',
            success: function (res) {
                populateSelect(element, res, 'Selecione a classificação', setDefault);
            }
        });
    }

    // Load users
    function loadUsers(element = null, setDefault = 0) {
        if (element === null) {
            element = '#User';
        }
        $.ajax({
            type: 'GET',
            url: '{{ route('ajax.users.lists') }}',
            success: function (res) {
                populateSelect(element, res, 'Selecione o usuário', setDefault);
            }
        });
    }

    function loadVehicle() {
        if (middleId) {
            let url = '{{ route('ajax.vehicles.lists', ['middle' => 'ID']) }}';
            url = url.replace('ID', middleId);
            // Load Middles
            $.ajax({
                type: 'GET',
                url: url,
                async: false,
                success: function (res) {
                    populateSelect('#Vehicle', res, 'Selecione o veículo', vehicleId);
                }
            });
        }
    }

    // On Middle Change
    $('#Middle').on('change', function () {
        let select = $('#Vehicle');
        select.prop('disabled', true);
        select.html('');
        select.append('<option value="0">Carregando...</option>');

        let middle_id = $(this).val();
        if (middle_id !== 0) {

            let url = '{{ route('ajax.vehicles.lists', ['middle' => 'ID']) }}';
            url = url.replace('ID', middle_id);

            $.ajax({
                type: 'GET',
                url: url,
                success: function (res) {
                    let select = $('#Vehicle');
                    select.html('');
                    select.append('<option value="0">Selecione o Veículo</option>');
                    $(res).each(function (index, value) {
                        select.append('<option value="' + value.id + '">' + value.name + '</option>')
                    });
                    $('#Vehicle').prop('disabled', false);

                    // Set Empty Editorial
                    $('#Editorial').html('');
                    $('#Editorial').append('<option value="0">Selecione o Editorial / Programa</option>');
                }
            });
        }
    });

    $(document).ready(function() {
        var table = $('.table').DataTable( { //Blfrtip // lftipr
            "dom": '<"row"<"col-md-8"l><"col-md-4">><"table-responsive"t><"row"<"col-md-8"i><"col-md-4"<"buttons-pagination"pr>>>',
            "ajax": {
                "url": "{{ route('ajax.clippings.index') }}" + "?" + urlParams.toString(),
            },
            "processing": true,
            "serverSide": true,
            "pageLength": 10,
            "responsive": true,
            "columns": columns,
            "columnDefs": columnDefs,
            "language": {
                // "processing": '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
                "url": "{{ asset('template/translations/datatable/pt-br.json') }}"
            },
            "order": [ 1, "desc" ]
        });

        $('.date').mask('00/00/0000', {placeholder: '__/__/____'});

        loadClient(null, clientId);
        loadExhibition(null, exhibitionId);
        loadMiddle(null, middleId);
        loadClassification(null, classificationId);
        loadSource(null, sourceId);
        loadVehicle(null, vehicleId);
        loadUsers(null, userId);

        @if(session()->get('success') == true)
        swal({
            title: '{{ session()->get('title') }}',
            text: "{{ session()->get('message') }}",
            icon: "{{ session()->get('icon') }}",
            button: "OK!",
        });
        @endif

        $('body').on('click', '.btn-delete', function(e) {
            let route = $(this).data('route');
            let modal = $(this).data('target');
            $(modal).find('form').attr('action', route);
        });

        $('body').on('submit', '#form-delete', function(e) {
            e.preventDefault();
            let data = $(this).serialize();
            let url = $(this).attr('action');
            $.ajax({
                type: 'DELETE',
                data: data,
                url: url,
                success: function (res) {
                    swal({
                        title: res.title,
                        text: res.message,
                        icon: res.icon,
                        button: "OK!",
                    });
                    $('#modal-delete').modal('hide');
                    table.ajax.reload();
                }
            });
        });

        $('body').on('click', '.filter-show', function() {
           if ($('.filters').is(':visible')) {
               $('.filters').slideUp();
           } else {
               $('.filters').slideDown();
           }
        });
    });
</script>
@if (!empty(request()->query('client_id')) &&
    !empty(request()->query('start_date')) && !empty(request()->query('end_date')))
<script>
    var clippingsByVehicle;
    var clippingsByClassification;
    var clippingsBySource;

    $(document).ready(function() {
        // load charts packages
        google.charts.load("current", {packages:['bar', 'corechart']});

        var formData = {
            'client_id': '{{ request()->query('client_id') }}',
            'middle_id': '{{ request()->query('middle_id') }}',
            'start_date': '{{ request()->query('start_date') }}',
            'end_date': '{{ request()->query('end_date') }}',
            '_token': '{{ csrf_token() }}'
        };

        $.ajax({
            type: 'POST',
            data: formData,
            url: '{{ route('ajax.reports.graphsData') }}',
            success: function (res) {
                console.log(res);
                clippingsByVehicle = res.clippings_by_vehicle;
                google.charts.setOnLoadCallback(drawChartClippings);
                clippingsByClassification = res.clippings_by_classification;
                google.charts.setOnLoadCallback(drawChartClassification);
                clippingsBySource = res.clippings_by_source;
                google.charts.setOnLoadCallback(drawChartSource);
            }
        });
    })
</script>
@endif
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

        if (validateFiltersReportGenerate(data) && validateImageCharts()) {
            var formData = new FormData(document.querySelector('#FormFilter'));

            // Graficos
            var chart_clippings = document.querySelector('#input_chart_clippings').value ?? '';
            var chart_classification = document.querySelector('#input_chart_classification').value ?? '';
            var chart_source = document.querySelector('#input_chart_source').value ?? '';

            formData.append('input_chart_clippings', chart_clippings);
            formData.append('input_chart_classification', chart_classification);
            formData.append('input_chart_source', chart_source);

            $('#modal-loading').modal('show');
            $(this).removeClass('btn-primary');
            $(this).addClass('btn-secondary');
            generatingReporting = true;

            $.ajax({
                type: 'POST',
                data: formData,
                url: '{{ route('ajax.reports.generate') }}',
                processData: false,
                contentType: false,
                success: function (res) {
                    $(this).removeClass('btn-secondary');
                    $(this).addClass('btn-primary');
                    generatingReporting = false;
                    $('#modal-loading').modal('hide');

                    var route = '{{ route('reports.show', 'FILENAME') }}';
                    route = route.replace('FILENAME', res.fileName)+'?client_id='+res.client+'&month='+month;
                    window.location.href = route;
                }
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
        return true;
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
