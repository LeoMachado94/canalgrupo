@extends('layouts.app')

@section('content')
    <!-- Header -->
    @include('layouts.header', [
        'header_title' => 'Clientes',
        'header_subtitle' => 'Veja aqui todos os clientes da empresa',
        'header_subtitle_icon' => 'fas fa-users',
        'btns' => [
            [
            'icon' => 'fas fa-plus',
            'text' => 'Cadastrar novo',
            'link' => route('clients.create')
            ]
        ]
    ])
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card" style="padding: 0 1rem;">
                    <!-- Card header -->
                    <div class="card-header pl-0 border-0">
                        <h3 class="mb-0">Lista de clientes</h3>
                    </div>
                    <!-- Light table -->
{{--                    <div class="table-responsive"><!-- responsive -->--}}
                        <table class="table align-items-center table-flush" style="overflow: none; width: 100%;">
                            <thead class="thead-light">
                            <tr>
                                <th>Nome</th>
                                <th>CNPJ</th>
                                <th>Telefones</th>
                                <th>Contato</th>
                                <th>Situação</th>
                                <th>Ações</th>
                            </tr>
                            </thead>
                            <tbody class="list">
                            </tbody>
                        </table>
{{--                    </div><!-- responsive close -->--}}
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
                        <h4 class="heading mt-4">Excluir usuário ?</h4>
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
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables/1.10.18/css/dataTables.bootstrap4.min.css') }}" type="text/css">
@endsection

@section('scripts')
<script src="{{ asset('assets/plugins/datatables/1.10.18/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/1.10.18/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery_mask/jquery.mask.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery_mask/behaviors/phone.js') }}"></script><!-- Behavior Mask Phone -->
<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>

<script>
    let columns = [
        { data: 'name', name: 'name' },
        { data: 'cnpj', name: 'cnpj' },
        { data: 'phones', name: 'phones' },
        { data: 'contact', name: 'contact' },
        { data: 'active', name: 'active' },
        { data: 'actions', name: 'actions'}
    ];

    let phones = {
        "targets": 2,
        "data": "phones",
        "render": function(data, type, row, meta) {
            if (row.phones.length === 0) return '';

            let phones = [];
            $(row.phones).each(function (index, value) {
                phones.push('<i class="fa fa-phone"></i> <span class="phone">' + value.phone_number + '</span>');
            });

            // return phones.join('<br>');
            return phones[0];
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
            let showRoute = '{{ route('clients.show', 'ID') }}';
            let editRoute = '{{ route('clients.edit', 'ID') }}';
            let deleteRoute = '{{ route('ajax.clients.destroy', 'ID') }}';
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
        phones,
        status,
        actions
    ];

    $(document).ready(function() {
        var table = $('.table').DataTable( { //Blfrtip // lftipr
            "dom": '<"row"<"col-md-8"l><"col-md-4"f>><"table-responsive"t><"row"<"col-md-8"i><"col-md-4"<"buttons-pagination"pr>>>',
            "ajax": {
                "url": "{{ route('ajax.clients.index') }}"
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
            "initComplete": function(settings, json) {
                $('.phone').mask(phoneMaskBehavior, phoneMaskOptions);
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
                    table.ajax.reload( function ( json ) {
                        $('.phone').mask(phoneMaskBehavior, phoneMaskOptions);
                    });
                }
            });
        });
    });
</script>
@endsection
