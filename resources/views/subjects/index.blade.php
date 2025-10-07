@extends('layouts.app')

@section('content')
    <!-- Header -->
    @include('layouts.header', [
        'header_title' => 'Assuntos',
        'header_subtitle' => 'Veja aqui os assuntos cadastrados',
        'header_subtitle_icon' => 'fas fa-comments',
        'btns' => [
            [
            'icon' => 'fas fa-plus',
            'text' => 'Cadastrar novo',
            'link' => route('subjects.create')
            ]
        ]
    ])
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card" style="padding: 0 1rem;">
                    <!-- Card header -->
                    <div class="card-header pl-0 border-0 row">
                        <div class="col-md-6">
                            <h3 class="mb-0">Lista de assuntos</h3>
                        </div>
                        <div class="col-md-6" style="padding: 0; margin: 0;">
                            <button class="btn btn-sm btn-dark float-right mr--2 filter-show">
                                <i class="fa fa-plus"></i> Filtros
                            </button>
                        </div>
                    </div>
                    <div class="filters bg-secondary p-3 mb-2">
                        <form name="filters" method="GET" id="FormFilter" action="{{ route('subjects.index') }}">
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
                                <!-- Assunto -->
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="form-control-label" for="Search">Pesquisar por <small>(Assunto)</small></label>
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
                    </div>

                    <!-- Light table -->
                    <table class="table align-items-center table-flush" style="overflow: none; width: 100%;">
                        <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Título</th>
                            <th>Usuário</th>
                            <th>Situação</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody class="list">
                        </tbody>
                    </table>
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
                        <h4 class="heading mt-4">Excluir assunto ?</h4>
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
@endsection

@section('styles')
<!-- Page plugins -->
<link rel="stylesheet" href="{{ asset('template/assets/css/extras.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables/1.10.18/css/dataTables.bootstrap4.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('template/assets/vendor/select2/dist/css/select2.min.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('assets/plugins/datatables/1.10.18/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/1.10.18/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('template/assets/vendor/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>

<script>
    var clientId = '{{ request()->query('client_id') }}' ? '{{ request()->query('client_id') }}' : 0;
    @if(Auth::guard('client')->user())
        clientId = '{{ Auth::guard('client')->user()->id }}';
    @endif

    let columns = [
        { data: 'id', name: 'id' },
        { data: 'client', name: 'client' },
        { data: 'title', name: 'title' },
        { data: 'user', name: 'user' },
        { data: 'active', name: 'active' },
        { data: 'actions', name: 'actions'}
    ];

    let client = {
        "targets": 1,
        "data": "client",
        "render": function(data, type, row, meta) {
            return row.client === null ? '' : row.client.name;
        }
    };

    let user = {
        "targets": 3,
        "data": "user",
        "render": function(data, type, row, meta) {
            return row.user === null ? '' : row.user.name;
        }
    };

    let status = {
        "targets": 4,
        "data": "active",
        "render": function(data, type, row, meta) {
            if (parseInt(row.active) === 1) {
                return 'Ativo';
            }
            return 'Inativo';
        }
    };

    let actions = {
        "targets": 5,
        "data": "actions",
        "render": function(data, type, row, meta) {
            let id = row.id;
            let showRoute = '{{ route('subjects.show', 'ID') }}';
            let editRoute = '{{ route('subjects.edit', 'ID') }}';
            let deleteRoute = '{{ route('ajax.subjects.destroy', 'ID') }}';
            showRoute = showRoute.replace('ID', id);
            editRoute = editRoute.replace('ID', id);
            deleteRoute = deleteRoute.replace('ID', id);
            let btns = '<a href="'+showRoute+'" class="table-action table-action-visualizar" data-toggle="tooltip" data-original-title="Visualizar">' +
            '<i class="fas fa-eye"></i>' +
            '</a>' +
            '<a href="'+editRoute+'" class="table-action table-action-edit" data-toggle="tooltip" data-original-title="Editar">' +
            '<i class="far fa-edit"></i>' +
            '</a>' +
            '<a href="#" class="table-action table-action-delete btn-delete" data-route="'+deleteRoute+'" data-toggle="modal" data-target="#modal-delete" data-original-title="Deletar">' +
            '<i class="fas fa-trash"></i>' +
            '</a>';
            return btns;
        }
    };

    let columnDefs = [
        client,
        user,
        status,
        actions
    ];

    const urlParams = new URLSearchParams(window.location.search);

    $(document).ready(function() {
        var table = $('.table').DataTable( { //Blfrtip // lftipr
            "dom": '<"row"<"col-md-8"l><"col-md-4">><"table-responsive"t><"row"<"col-md-8"i><"col-md-4"<"buttons-pagination"pr>>>',
            "ajax": {
                "url": "{{ route('ajax.clippings.index') }}" + "?" + urlParams.toString(),
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
            "order": [ 0, "desc" ]
        });

        $('body').on('click', '.filter-show', function() {
            if ($('.filters').is(':visible')) {
                $('.filters').slideUp();
            } else {
                $('.filters').slideDown();
            }
        });

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

        loadClient(null, clientId);

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
    })
</script>
@endsection
