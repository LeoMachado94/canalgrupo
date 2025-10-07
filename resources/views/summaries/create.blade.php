@extends('layouts.app')

@section('content')
    <!-- Header -->
    @include('layouts.header', [
        'header_title' => 'Novo Resumo',
        'header_subtitle' => 'Cadastro de resumos',
        'header_subtitle_icon' => 'fas fa-file-alt',
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
                <h3 class="mb-0">Cadastro de Resumos</h3>
            </div>
            <!-- Card body -->
            <div class="card-body">
                <!-- Form groups used in grid -->
                <form class="form-save" method="POST" action="{{ route('summaries.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-control-label" for="Client">Cliente</label>
                        <select class="form-control @error('client_id')is-invalid @enderror" name="client_id"
                                id="Client" data-toggle="select">
                            <option>Selecione o Cliente</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="Title">Título</label>
                            <input type="text" name="title" class="form-control @error('title')is-invalid @enderror"
                                   value="{{ old('title') ?? '' }}" id="Title" placeholder="Qual o Título do Resumo ?">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="File">Arquivo</label>
                            <input type="file" name="file" class="form-control @error('file')is-invalid @enderror"
                                   value="{{ old('file') ?? '' }}" id="File">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-control-label" for="Date">Data</label>
                            <input type="text" name="date" class="form-control datepicker date @error('date')is-invalid @enderror"
                                   value="{{ old('date') ?? '' }}" id="Date" placeholder="Qual a data ?">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-control-label" for="Active">Situação</label>
                            <select class="form-control @error('active')is-invalid @enderror" name="active"
                                    id="Active" data-toggle="select">
                                <option value="1">Ativo</option>
                                <option value="0">Inativo</option>
                            </select>
                        </div>
                    </div>
                    @if($errors->any())
                    <div class="col-md-12">
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    </div>
                    @endif
                </div>
                </form>
            </div>
        </div>

        <div class="card-body text-center">
            <button type="button" class="btn btn-cancelar btn-lg">Cancelar</button>
            <button type="button" class="btn btn-salvar btn-lg btn-save">SALVAR</button>
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
<!-- Page plugins -->
<link rel="stylesheet" href="{{ asset('template/assets/vendor/select2/dist/css/select2.min.css') }}">
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
<script src="{{ asset('template/assets/vendor/bootstrap-datepicker/dist/locales/bootstrap-datepicker.pt-BR.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery_mask/jquery.mask.min.js') }}"></script>

<script type="text/javascript">
    // Default Format Datepicker
    $.fn.datepicker.defaults.format = "dd/mm/yyyy";
    $.fn.datepicker.defaults.language = "pt-BR";

    $('.date').mask('00/00/0000', {placeholder: '__/__/____'});

    function setActive(active)
    {
        $("#Active").val(active).trigger('change');
    }

    function setClient(clientId)
    {
        if ($("#Client option").length > 1) {
            $("#Client").val(clientId).trigger('change');
        }
    }

    $(document).ready(function() {
        $('.btn-save').on('click', function (){
            $('.form-save').submit();
        });

        $.ajax({
            type: 'GET',
            url: '{{ route('ajax.clients.index') }}',
            success: function (res) {
                let select = $('#Client');
                select.html('');
                select.append('<option value="0">Selecione o Cliente</option>');

                $(res.data).each(function (index, value) {
                   select.append('<option value="'+value.id+'">'+value.name+'</option>')
                });
            }
        });

        @if($errors->any())
            @if(old('client_id'))
            let timerClient = setTimeout(() => setClient('{{ old('client_id') }}'), 1000);
            @endif
            @if(old('active'))
            let activeTimer = setTimeout(() => setActive('{{ old('active') }}'), 500);
            @endif
        @endif
    });
</script>
@endsection
