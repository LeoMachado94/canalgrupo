@extends('layouts.app')

@section('content')
    <!-- Header -->
    @include('layouts.header', [
        'header_title' => 'Favoritos',
        'header_subtitle' => 'Veja aqui todos os favoritos (clippings)',
        'header_subtitle_icon' => 'fas fa-star'
    ])
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card" id="table" style="padding: 0 1rem;">
                    <!-- Card header -->
                    <div class="card-header pl-0 border-0 row">
                        <div class="col-md-6">
                            <h3 class="mb-0">Favoritos</h3>
                        </div>
                        <div class="col-md-6" style="padding: 0; margin: 0;">
                            <button class="btn btn-sm btn-dark float-right mr--2 filter-show">
                                <i class="fa fa-plus"></i> Filtros
                            </button>
                            <a href="#" target="_blank" id="sendMail"
                               class="btn btn-sm btn-primary float-right mr-2">
                                <i class="fa fa-envelope"></i> Enviar por email
                            </a>
                        </div>
                    </div>
                    <div class="filters bg-secondary p-3 mb-2">
                        <form name="filters" method="GET" id="FormFilter" action="{{ route('favorites.index') }}">
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
                            <!-- Exhbition -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="Exhibition">Exibição</label>
                                    <select name="exhibition_id" class="form-control" data-toggle="select" id="Exhibition">
                                        <option>Selecione a Exibição</option>
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
                            <!-- Classification -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="Classification">Classificação</label>
                                    <select name="classification_id" class="form-control" data-toggle="select" id="Classification">
                                        <option>Selecione a Classificação</option>
                                    </select>
                                </div>
                            </div>
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
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success float-right"><i class="fa fa-filter"></i> Filtrar</button>
                            </div>
                        </div>
                        </form>
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
    @include('reports.includes.modalSendingMail')
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

    let columns = [
        { data: 'id', name: 'id' },
        { data: 'date', name: 'date' },
        { data: 'subject', name: 'subject' },
        { data: 'client', name: 'client'},
        { data: 'exhibition', name: 'exhibition'},
        { data: 'middle', name: 'middle'},
        { data: 'classification', name: 'classification'},
        { data: 'actions', name: 'actions'}
    ];

    let id = {
        "targets": 0,
        "data": "date",
        "render": function(data, type, row, meta) {
            if(type === 'display') {
                var checkbox = "<input type='checkbox' name='clippings[]' value='"+row.id+"'> ";
                return checkbox+row.id;
            }
            return row.id === null ? '' : row.id;
        }
    }

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
            return row.subject === null || row.subject === undefined ? '' : row.subject.title;
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

    let actions = {
        "targets": 7,
        "data": "actions",
        "render": function(data, type, row, meta) {
            let id = row.id;
            let showRoute = '{{ route('clippings.show', 'ID') }}';
            let editRoute = '{{ route('clippings.edit', 'ID') }}';
            showRoute = showRoute.replace('ID', id);
            editRoute = editRoute.replace('ID', id);
            @if(!Auth::guard('client')->user())
            let btns = '<a href="'+showRoute+'" class="table-action table-action-visualizar" data-toggle="tooltip" data-original-title="Visualizar">' +
                '<i class="fas fa-eye"></i>' +
                '</a>' +
                '<a href="'+editRoute+'" class="table-action table-action-edit" data-toggle="tooltip" data-original-title="Editar">' +
                '<i class="far fa-edit"></i>' +
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
        id,
        date,
        created,
        client,
        exhibition,
        middle,
        classification,
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

    $(document).ready(function() {
        var table = $('.table').DataTable( { //Blfrtip // lftipr
            "dom": '<"row"<"col-md-8"l><"col-md-4"f>><"table-responsive"t><"row"<"col-md-8"i><"col-md-4"<"buttons-pagination"pr>>>',
            "ajax": {
                "url": "{{ route('ajax.favorites.index') }}" + "?" + urlParams.toString(),
            },
            "processing": true,
            "serverSide": true,
            "pageLength": 150,
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

        let clientId = '{{ request()->query('client_id') }}' ? '{{ request()->query('client_id') }}' : 0;
        @if(Auth::guard('client')->user())
            clientId = '{{ Auth::guard('client')->user()->id }}';
        @endif
        let exhibitionId = '{{ request()->query('exhibition_id') }}' ? '{{ request()->query('exhibition_id') }}' : 0;
        let middleId = '{{ request()->query('middle_id') }}' ? '{{ request()->query('middle_id') }}' : 0;
        let classificationId = '{{ request()->query('classification_id') }}' ? '{{ request()->query('classification_id') }}' : 0;

        loadClient(null, clientId);
        loadExhibition(null, exhibitionId);
        loadMiddle(null, middleId);
        loadClassification(null, classificationId);

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
<script>
    var sendingMail = false;

    $('body').on('click', '#sendMail', function(e) {
        e.preventDefault();

        if (sendingMail) {
            swal({
                title: 'Já estamos enviando um email.',
                text: 'Já estamos enviando um email...Aguarde a conclusão para enviar outro.',
                icon: 'warning',
                button: "OK!",
            });
        }

        var data = [];
        data['client'] = document.querySelector('#Client').value;
        data['middle'] = document.querySelector('#Middle').value;
        data['start_date'] = document.querySelector('#StartDate').value;
        data['end_date'] = document.querySelector('#EndDate').value;

        var favorites = [];
        var checkboxes = document.querySelectorAll('input[type=checkbox]:checked')

        for (var i = 0; i < checkboxes.length; i++) {
            favorites[i] = checkboxes[i].value;
        }

        if (validateFiltersFavorites(data)) {
            var formData = new FormData(document.querySelector('#FormFilter'));

            formData.append('clippings', favorites);

            $('#sendingMailModal').modal('show');
            $('#sendMail').removeClass('btn-primary');
            $('#sendMail').addClass('btn-secondary');
            sendingMail = true;

            $.ajax({
                type: 'POST',
                data: formData,
                url: '{{ route('ajax.favorites.send') }}',
                processData: false,
                contentType: false,
                success: function (res) {
                    $('#sendMail').removeClass('btn-secondary');
                    $('#sendMail').addClass('btn-primary');
                    sendingMail = false;
                    $('#sendingMailModal').modal('hide');
                    swal({
                        title: 'Emails enviados com sucesso.',
                        text: 'Os clippings selecionados foram enviados para o cliente...',
                        icon: 'success',
                        button: "OK!",
                    });
                }
            });
        }
    });

    function validateFiltersFavorites(data)
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
</script>
@endsection
