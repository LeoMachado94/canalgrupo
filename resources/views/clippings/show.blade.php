@extends('layouts.app')

@section('content')
    <!-- Header -->
    @include('layouts.header', [
        'btns' => [
            [
            'icon' => 'fas fa-arrow-left',
            'text' => 'Voltar',
            'link' => route('clippings.index')
            ]
        ]
    ])
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <div class="card mb-4">
            <!-- Card header -->
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="mb-0">Visualizar Clipping</h3>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('external.clippings.show', $clipping->slug) }}"
                           class="btn btn-sm btn-dark float-right" target="_blank">
                            <i class="fa fa-link"></i> Link público
                        </a>
                    </div>
                </div>
            </div>
            <!-- Card body -->
            <div class="card-body">
                <!-- Form groups used in grid -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="Client">Cliente</label>
                            <div>{{ $clipping->client->name ?? '' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="QualoAssunto">Assunto</label>
                            <div>{{ $clipping->subject_matter ?? '' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="Titulo">Título</label>
                            <div>{{ $clipping->title ?? '' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="Midle">Meio</label>
                            <div>{{ $clipping->middle->name ?? '' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="Vehicle">Veículo</label>
                            <div>{{ $clipping->vehicle->name ?? '' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="Editorial">Editorial / Programa</label>
                            <div>{{ $clipping->editorial->title ?? '' }}</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-control-label" for="Classification">Classificação</label>
                            <div>{{ $clipping->classification->name ?? '' }}</div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-control-label" for="Exhibition">Exibição</label>
                            <div>{{ $clipping->exhibition->name ?? '' }}</div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-control-label" for="Source">Fonte</label>
                            <div>{{ $clipping->source->name ?? '' }}</div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-control-label">Data</label>
                            <div>{{ $clipping->date ?? '' }}</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-control-label" for="User">Usuário</label>
                            <div>{{ $clipping->user->name ?? '' }}</div>
                        </div>
                    </div>
                </div>
                @if($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif
            </div>
        </div>

            <!-- Dropzone -->
            <div class="card">
                <!-- Card header -->
                <div class="card-header">
                    <h3 class="mb-0">Arquivos</h3>
                </div>
                <!-- Card body -->
                <div class="card-body">
                    <!-- Multiple -->
                    <div class="dropzone dropzone-multiple" data-toggle="dropzone">
                        <ul class="dz-preview dz-preview-multiple list-group list-group-lg list-group-flush">
                            @foreach($clipping->files as $file)
                            <li class="list-group-item px-0">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="avatar">
                                            <img class="icon-img rounded" src="{{ asset('assets/images/file_icon.jpg') }}" alt="" data-dz-thumbnail>
                                        </div>
                                    </div>
                                    <div class="col ml--3">
                                        <h4 class="mb-1" data-dz-name>{{ $file->name }}</h4>
                                        <p class="small text-muted mb-0" data-dz-size>...</p>
                                    </div>
                                    <div class="col-3 ml--2">
                                        <span class="mb-1 badge {{ $file->badge_color }} fileType">{{ $file->type }}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fe fe-more-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="{{ Storage::disk('spaces')->url($file->path) }}" target="_blank" class="dropdown-item removeFile">
                                                    Download
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

        <!-- resenha -->
        <div class="card">
            <!-- Card header -->
            <div class="card-header">
                <h3 class="mb-0">Resenha</h3>
            </div>
            <!-- Card body -->
            <div class="card-body">
                <div class="form-group">
                    <label class="form-control-label" for="Description">Descrição</label>
                    <div id="Editor">{!! $clipping->review ?? '' !!}</div>
                </div>
            </div>
        </div>
        <!-- fim -->

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
    <div id="overlay"></div>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/QuillEditor/quill.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/DateTimePicker/css/bootstrap-material-datetimepicker.css') }}">
    <style type="text/css">
        #overlay {
            background-color: rgba(0, 0, 0, 0.8);
            z-index: 9999;
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            display: none;
        }
    </style>
@endsection

@section('scripts')
<script src="{{ asset('template/assets/vendor/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('template/assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('template/assets/vendor/bootstrap-datepicker/dist/locales/bootstrap-datepicker.pt-BR.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery_mask/jquery.mask.min.js') }}"></script>
<script src="{{ asset('assets/plugins/QuillEditor/quill.js') }}"></script>
<script src="{{ asset('assets/plugins/momentjs/moment.js') }}"></script>
<script src="{{ asset('assets/plugins/DateTimePicker/js/bootstrap-material-datetimepicker.js') }}"></script>
<script src="{{ asset('template/assets/vendor/dropzone/dist/min/dropzone.min.js') }}"></script>
<script>
</script>
@endsection
