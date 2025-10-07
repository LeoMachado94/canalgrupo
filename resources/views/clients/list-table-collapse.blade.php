@extends('layouts.app')

@section('content')
    <!-- Header -->
    @include('layouts.header', [
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
                <div class="card" id="table">
                    <!-- Card header -->
                    <div class="card-header border-0">
                        <h3 class="mb-0">Lista de clippings</h3>
                    </div>
                    <!-- Light table -->
                    <table class="table display nowrap align-items-center table-flush" style="width: 100%;">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col" class="sort" data-sort="name">Nome</th>
                            <th scope="col" class="sort" data-sort="cnpj">CNPJ</th>
                            <th scope="col">Telefones</th>
                            <th scope="col" class="sort" data-sort="client">Contato</th>
                            <th scope="col" class="sort" data-sort="active">Situação</th>
                            <th scope="col">Opções</th>
                        </tr>
                        </thead>
                        <tbody class="list">
                        <!-- inicio list -->
                        <tr>
                            <td>Name</td>
                            <td>09.123.442/0001-23</td>
                            <td>
                                <span>(55) 99738 1278</span><br>
                                <span>(55) 99999 1234</span>
                            </td>
                            <td>Contato</td>
                            <td>
                              <span class="badge badge-dot mr-4">
                                <i class="bg-success"></i>
                                <span class="status">Ativo</span>
                              </span>
                            </td>
                            <td class="table-actions">
                                <a href="#!" class="table-action table-action-visualizar" data-toggle="tooltip" data-original-title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="#!" class="table-action table-action-edit" data-toggle="tooltip" data-original-title="Editar">
                                    <i class="far fa-edit"></i>
                                </a>
                                <a href="#!" class="table-action table-action-delete" data-toggle="tooltip" data-original-title="Deletar">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <!-- fim list -->
                        <tr>
                            <td>Name</td>
                            <td>09.123.442/0001-23</td>
                            <td>
                                <span>(55) 99738 1278</span><br>
                                <span>(55) 99999 1234</span>
                            </td>
                            <td>Contato</td>
                            <td>
                              <span class="badge badge-dot mr-4">
                                <i class="bg-success"></i>
                                <span class="status">Ativo</span>
                              </span>
                            </td>
                            <td class="table-actions">
                                <a href="#!" class="table-action table-action-visualizar" data-toggle="tooltip" data-original-title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="#!" class="table-action table-action-edit" data-toggle="tooltip" data-original-title="Editar">
                                    <i class="far fa-edit"></i>
                                </a>
                                <a href="#!" class="table-action table-action-delete" data-toggle="tooltip" data-original-title="Deletar">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td>09.123.442/0001-23</td>
                            <td>
                                <span>(55) 99738 1278</span><br>
                                <span>(55) 99999 1234</span>
                            </td>
                            <td>Contato</td>
                            <td>
                              <span class="badge badge-dot mr-4">
                                <i class="bg-success"></i>
                                <span class="status">Ativo</span>
                              </span>
                            </td>
                            <td class="table-actions">
                                <a href="#!" class="table-action table-action-visualizar" data-toggle="tooltip" data-original-title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="#!" class="table-action table-action-edit" data-toggle="tooltip" data-original-title="Editar">
                                    <i class="far fa-edit"></i>
                                </a>
                                <a href="#!" class="table-action table-action-delete" data-toggle="tooltip" data-original-title="Deletar">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td>09.123.442/0001-23</td>
                            <td>
                                <span>(55) 99738 1278</span><br>
                                <span>(55) 99999 1234</span>
                            </td>
                            <td>Contato</td>
                            <td>
                              <span class="badge badge-dot mr-4">
                                <i class="bg-success"></i>
                                <span class="status">Ativo</span>
                              </span>
                            </td>
                            <td class="table-actions">
                                <a href="#!" class="table-action table-action-visualizar" data-toggle="tooltip" data-original-title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="#!" class="table-action table-action-edit" data-toggle="tooltip" data-original-title="Editar">
                                    <i class="far fa-edit"></i>
                                </a>
                                <a href="#!" class="table-action table-action-delete" data-toggle="tooltip" data-original-title="Deletar">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td>09.123.442/0001-23</td>
                            <td>
                                <span>(55) 99738 1278</span><br>
                                <span>(55) 99999 1234</span>
                            </td>
                            <td>Contato</td>
                            <td>
                              <span class="badge badge-dot mr-4">
                                <i class="bg-success"></i>
                                <span class="status">Ativo</span>
                              </span>
                            </td>
                            <td class="table-actions">
                                <a href="#!" class="table-action table-action-visualizar" data-toggle="tooltip" data-original-title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="#!" class="table-action table-action-edit" data-toggle="tooltip" data-original-title="Editar">
                                    <i class="far fa-edit"></i>
                                </a>
                                <a href="#!" class="table-action table-action-delete" data-toggle="tooltip" data-original-title="Deletar">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td>09.123.442/0001-23</td>
                            <td>
                                <span>(55) 99738 1278</span><br>
                                <span>(55) 99999 1234</span>
                            </td>
                            <td>Contato</td>
                            <td>
                              <span class="badge badge-dot mr-4">
                                <i class="bg-success"></i>
                                <span class="status">Ativo</span>
                              </span>
                            </td>
                            <td class="table-actions">
                                <a href="#!" class="table-action table-action-visualizar" data-toggle="tooltip" data-original-title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="#!" class="table-action table-action-edit" data-toggle="tooltip" data-original-title="Editar">
                                    <i class="far fa-edit"></i>
                                </a>
                                <a href="#!" class="table-action table-action-delete" data-toggle="tooltip" data-original-title="Deletar">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td>09.123.442/0001-23</td>
                            <td>
                                <span>(55) 99738 1278</span><br>
                                <span>(55) 99999 1234</span>
                            </td>
                            <td>Contato</td>
                            <td>
                              <span class="badge badge-dot mr-4">
                                <i class="bg-success"></i>
                                <span class="status">Ativo</span>
                              </span>
                            </td>
                            <td class="table-actions">
                                <a href="#!" class="table-action table-action-visualizar" data-toggle="tooltip" data-original-title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="#!" class="table-action table-action-edit" data-toggle="tooltip" data-original-title="Editar">
                                    <i class="far fa-edit"></i>
                                </a>
                                <a href="#!" class="table-action table-action-delete" data-toggle="tooltip" data-original-title="Deletar">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td>09.123.442/0001-23</td>
                            <td>
                                <span>(55) 99738 1278</span><br>
                                <span>(55) 99999 1234</span>
                            </td>
                            <td>Contato</td>
                            <td>
                              <span class="badge badge-dot mr-4">
                                <i class="bg-success"></i>
                                <span class="status">Ativo</span>
                              </span>
                            </td>
                            <td class="table-actions">
                                <a href="#!" class="table-action table-action-visualizar" data-toggle="tooltip" data-original-title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="#!" class="table-action table-action-edit" data-toggle="tooltip" data-original-title="Editar">
                                    <i class="far fa-edit"></i>
                                </a>
                                <a href="#!" class="table-action table-action-delete" data-toggle="tooltip" data-original-title="Deletar">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td>09.123.442/0001-23</td>
                            <td>
                                <span>(55) 99738 1278</span><br>
                                <span>(55) 99999 1234</span>
                            </td>
                            <td>Contato</td>
                            <td>
                              <span class="badge badge-dot mr-4">
                                <i class="bg-success"></i>
                                <span class="status">Ativo</span>
                              </span>
                            </td>
                            <td class="table-actions">
                                <a href="#!" class="table-action table-action-visualizar" data-toggle="tooltip" data-original-title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="#!" class="table-action table-action-edit" data-toggle="tooltip" data-original-title="Editar">
                                    <i class="far fa-edit"></i>
                                </a>
                                <a href="#!" class="table-action table-action-delete" data-toggle="tooltip" data-original-title="Deletar">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td>09.123.442/0001-23</td>
                            <td>
                                <span>(55) 99738 1278</span><br>
                                <span>(55) 99999 1234</span>
                            </td>
                            <td>Contato</td>
                            <td>
                              <span class="badge badge-dot mr-4">
                                <i class="bg-success"></i>
                                <span class="status">Ativo</span>
                              </span>
                            </td>
                            <td class="table-actions">
                                <a href="#!" class="table-action table-action-visualizar" data-toggle="tooltip" data-original-title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="#!" class="table-action table-action-edit" data-toggle="tooltip" data-original-title="Editar">
                                    <i class="far fa-edit"></i>
                                </a>
                                <a href="#!" class="table-action table-action-delete" data-toggle="tooltip" data-original-title="Deletar">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td>09.123.442/0001-23</td>
                            <td>
                                <span>(55) 99738 1278</span><br>
                                <span>(55) 99999 1234</span>
                            </td>
                            <td>Contato</td>
                            <td>
                              <span class="badge badge-dot mr-4">
                                <i class="bg-success"></i>
                                <span class="status">Ativo</span>
                              </span>
                            </td>
                            <td class="table-actions">
                                <a href="#!" class="table-action table-action-visualizar" data-toggle="tooltip" data-original-title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="#!" class="table-action table-action-edit" data-toggle="tooltip" data-original-title="Editar">
                                    <i class="far fa-edit"></i>
                                </a>
                                <a href="#!" class="table-action table-action-delete" data-toggle="tooltip" data-original-title="Deletar">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td>09.123.442/0001-23</td>
                            <td>
                                <span>(55) 99738 1278</span><br>
                                <span>(55) 99999 1234</span>
                            </td>
                            <td>Contato</td>
                            <td>
                              <span class="badge badge-dot mr-4">
                                <i class="bg-success"></i>
                                <span class="status">Ativo</span>
                              </span>
                            </td>
                            <td class="table-actions">
                                <a href="#!" class="table-action table-action-visualizar" data-toggle="tooltip" data-original-title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="#!" class="table-action table-action-edit" data-toggle="tooltip" data-original-title="Editar">
                                    <i class="far fa-edit"></i>
                                </a>
                                <a href="#!" class="table-action table-action-delete" data-toggle="tooltip" data-original-title="Deletar">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <!-- Card footer -->
{{--                    <div class="card-footer pagination py-4">--}}
{{--                        <nav aria-label="...">--}}
{{--                            <ul class="pagination justify-content-end mb-0">--}}
{{--                                <li class="page-item disabled">--}}
{{--                                    <a class="page-link" href="#" tabindex="-1">--}}
{{--                                        <i class="fas fa-angle-left"></i>--}}
{{--                                        <span class="sr-only">Previous</span>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                                <li class="page-item active">--}}
{{--                                    <a class="page-link" href="#">1</a>--}}
{{--                                </li>--}}
{{--                                <li class="page-item">--}}
{{--                                    <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>--}}
{{--                                </li>--}}
{{--                                <li class="page-item"><a class="page-link" href="#">3</a></li>--}}
{{--                                <li class="page-item">--}}
{{--                                    <a class="page-link" href="#">--}}
{{--                                        <i class="fas fa-angle-right"></i>--}}
{{--                                        <span class="sr-only">Next</span>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                            </ul>--}}
{{--                        </nav>--}}
{{--                    </div>--}}
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
@endsection

@section('styles')
<link rel="icon" href="{{ asset('template/assets/img/brand/favicon.png') }}" type="image/png">
<!-- Fonts -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
<!-- Icons -->
<link rel="stylesheet" href="{{ asset('template/assets/vendor/nucleo/css/nucleo.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('template/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}" type="text/css">
<!-- Page plugins -->
<link rel="stylesheet" href="{{ asset('template/assets/vendor/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('template/assets/vendor/quill/dist/quill.core.css') }}">
<!-- Argon CSS -->
<link rel="stylesheet" href="{{ asset('template/assets/css/argon.css?v=1.1.0') }}" type="text/css">
{{--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" type="text/css">--}}
<link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.6/css/rowReorder.dataTables.min.css" type="text/css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" type="text/css">
<style type="text/css">
    .buttons-pagination {
        float: right !important;
    }
    .dataTables_paginate {
        padding-right: 1rem !important;
    }
    .custom-select, .custom-select-sm {
        max-width: 60px;
    }
    .dataTables_filter input {
        background-image: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+PHN2ZyAgIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIgICB4bWxuczpjYz0iaHR0cDovL2NyZWF0aXZlY29tbW9ucy5vcmcvbnMjIiAgIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyIgICB4bWxuczpzdmc9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiAgIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgICB2ZXJzaW9uPSIxLjEiICAgaWQ9InN2ZzQ0ODUiICAgdmlld0JveD0iMCAwIDIxLjk5OTk5OSAyMS45OTk5OTkiICAgaGVpZ2h0PSIyMiIgICB3aWR0aD0iMjIiPiAgPGRlZnMgICAgIGlkPSJkZWZzNDQ4NyIgLz4gIDxtZXRhZGF0YSAgICAgaWQ9Im1ldGFkYXRhNDQ5MCI+ICAgIDxyZGY6UkRGPiAgICAgIDxjYzpXb3JrICAgICAgICAgcmRmOmFib3V0PSIiPiAgICAgICAgPGRjOmZvcm1hdD5pbWFnZS9zdmcreG1sPC9kYzpmb3JtYXQ+ICAgICAgICA8ZGM6dHlwZSAgICAgICAgICAgcmRmOnJlc291cmNlPSJodHRwOi8vcHVybC5vcmcvZGMvZGNtaXR5cGUvU3RpbGxJbWFnZSIgLz4gICAgICAgIDxkYzp0aXRsZT48L2RjOnRpdGxlPiAgICAgIDwvY2M6V29yaz4gICAgPC9yZGY6UkRGPiAgPC9tZXRhZGF0YT4gIDxnICAgICB0cmFuc2Zvcm09InRyYW5zbGF0ZSgwLC0xMDMwLjM2MjIpIiAgICAgaWQ9ImxheWVyMSI+ICAgIDxnICAgICAgIHN0eWxlPSJvcGFjaXR5OjAuNSIgICAgICAgaWQ9ImcxNyIgICAgICAgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoNjAuNCw4NjYuMjQxMzQpIj4gICAgICA8cGF0aCAgICAgICAgIGlkPSJwYXRoMTkiICAgICAgICAgZD0ibSAtNTAuNSwxNzkuMSBjIC0yLjcsMCAtNC45LC0yLjIgLTQuOSwtNC45IDAsLTIuNyAyLjIsLTQuOSA0LjksLTQuOSAyLjcsMCA0LjksMi4yIDQuOSw0LjkgMCwyLjcgLTIuMiw0LjkgLTQuOSw0LjkgeiBtIDAsLTguOCBjIC0yLjIsMCAtMy45LDEuNyAtMy45LDMuOSAwLDIuMiAxLjcsMy45IDMuOSwzLjkgMi4yLDAgMy45LC0xLjcgMy45LC0zLjkgMCwtMi4yIC0xLjcsLTMuOSAtMy45LC0zLjkgeiIgICAgICAgICBjbGFzcz0ic3Q0IiAvPiAgICAgIDxyZWN0ICAgICAgICAgaWQ9InJlY3QyMSIgICAgICAgICBoZWlnaHQ9IjUiICAgICAgICAgd2lkdGg9IjAuODk5OTk5OTgiICAgICAgICAgY2xhc3M9InN0NCIgICAgICAgICB0cmFuc2Zvcm09Im1hdHJpeCgwLjY5NjQsLTAuNzE3NiwwLjcxNzYsMC42OTY0LC0xNDIuMzkzOCwyMS41MDE1KSIgICAgICAgICB5PSIxNzYuNjAwMDEiICAgICAgICAgeD0iLTQ2LjIwMDAwMSIgLz4gICAgPC9nPiAgPC9nPjwvc3ZnPg==);
        background-repeat: no-repeat;
        background-color: #fff !important;
        background-position: 0px 3px !important;
        padding:  3px 3px 3px 20px;
    }
    .sorting_1:before {
        margin: 15px 2px 2px 2px;
    }
</style>
@endsection

@section('scripts')
<script src="{{ asset('template/assets/vendor/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('template/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('template/assets/vendor/js-cookie/js.cookie.js') }}"></script>
<script src="{{ asset('template/assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
<script src="{{ asset('template/assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>

<!-- Optional JS -->
<script src="{{ asset('template/assets/vendor/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('template/assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
{{--<script src="{{ asset('template/assets/vendor/nouislider/distribute/nouisliderfloat-right.min.js') }}"></script>--}}
<script src="{{ asset('template/assets/vendor/quill/dist/quill.min.js') }}"></script>
<script src="{{ asset('template/assets/vendor/dropzone/dist/min/dropzone.min.js') }}"></script>
<script src="{{ asset('template/assets/vendor/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>

<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/rowreorder/1.2.6/js/dataTables.rowReorder.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>

<script>
    $('.table').DataTable( {
        "dom": '<"row"<"col-md-8"l><"col-md-4"f>>t<"row"<"col-md-8"i><"col-md-4"<"buttons-pagination"p>>>',
        "pageLength": 10,
        "language": {
            "url": "{{ asset('template/translations/datatable/pt-br.json') }}",
        },
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: true
    });

    // $(document).ready(function() {
    //
    // });
    $(document).ready(function() {

        // $('.datatable_find').append(input);
    })
</script>

<!-- Argon JS -->
{{--<script src="{{ asset('template/assets/js/argon.js?v=1.1.0') }}"></script>--}}
<!-- Demo JS - remove this in your project -->
{{--<script src="{{ asset('template/assets/js/demo.min.js') }}"></script>--}}
@endsection
