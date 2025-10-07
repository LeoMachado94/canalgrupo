@extends('layouts.app')

@section('content')
    <!-- Header -->
    @include('layouts.header', [
        'header_title' => 'Visualizar Resumo',
        'header_subtitle' => 'Visualização de resumos',
        'header_subtitle_icon' => 'far fa-file-alt',
        'btns' => [
            [
            'icon' => 'fas fa-arrow-left',
            'text' => 'Voltar',
            'link' => url()->previous()
            ]
        ]
    ])
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <div class="card mb-4">
            <!-- Card header -->
            <div class="card-header">
{{--                <h3 class="mb-0">Visualização de Assuntos</h3>--}}
                <h3 class="mb-0">Resumo: {{ $summary->title }}</h3>
            </div>
            <!-- Card body -->
            <div class="card-body">
                <!-- Form groups used in grid -->
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-control-label" for="Client">Cliente</label>
                        <div>{{ $summary->client->name ?? '' }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="Title">Título</label>
                            <div>{{ $summary->title ?? '' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="File">Arquivo</label>
                            @if(!empty($summary->file))
                                <div>
                                    <a href="{{ asset($summary->file) ?? '' }}" target="_blank" class="btn btn-sm btn-dark" style="width: 30%;">Visualizar</a>
                                </div>
                            @else
                                <div>-</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-control-label" for="Date">Data</label>
                            <div>{{ $summary->date ?? '' }}</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-control-label" for="Active">Situação</label>
                            <div>{{ $summary->active ? 'Ativo' : 'Inativo' }}</div>
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
@endsection

@section('styles')
@endsection

@section('scripts')
<script src="{{ asset('template/assets/vendor/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('template/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('template/assets/vendor/js-cookie/js.cookie.js') }}"></script>
<script src="{{ asset('template/assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
<script src="{{ asset('template/assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>
{{--<script src="{{ asset('template/assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>--}}
@endsection
