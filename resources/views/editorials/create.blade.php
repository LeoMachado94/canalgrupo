@extends('layouts.app')

@section('content')
    <!-- Header -->
    @include('layouts.header', [
        'header_title' => 'Novo editorial/programa',
        'header_subtitle' => 'Cadastro de editoriais/programas',
        'header_subtitle_icon' => 'fas fa-newspaper',
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
                <h3 class="mb-0">Cadastro de Editoriais/Programas</h3>
            </div>
            <!-- Card body -->
            <div class="card-body">
                <!-- Form groups used in grid -->
                <form class="form-save" method="POST" action="{{ route('editorials.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-control-label" for="Vehicle">Veículo</label>
                        <select class="form-control @error('vehicle')is-invalid @enderror" name="vehicle_id"
                                id="Vehicle" data-toggle="select">
                            <option>Selecione o Veículo</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="Title">Título</label>
                            <input type="text" name="title" class="form-control @error('title')is-invalid @enderror"
                                   value="{{ old('title') ?? '' }}" id="Title" placeholder="Qual o Título do Editorial/Programa ?">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-control-label" for="Hour">Horário</label>
                            <input type="text" name="hour" class="form-control time @error('hour')is-invalid @enderror"
                                   value="{{ old('hour') ?? '' }}" id="Hour" placeholder="Qual o Horário do Editorial/Programa ?">
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="Responsible">Responsável</label>
                            <input type="text" name="responsible" class="form-control @error('responsible')is-invalid @enderror"
                                   value="{{ old('responsible') ?? '' }}" id="Responsible" placeholder="Responsável do Editorial/Programa">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-control-label" for="Description">Descrição</label>
                            <div id="Editor"></div>
                            <input type="hidden" id="InputEditor" name="description" class="form-control" />
                        </div>
                    </div>
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
<link rel="stylesheet" href="{{ asset('assets/plugins/QuillEditor/quill.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/DateTimePicker/css/bootstrap-material-datetimepicker.css') }}">
@endsection

@section('scripts')
<!-- Optional JS -->
<script src="{{ asset('template/assets/vendor/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/QuillEditor/quill.js') }}"></script>
<script src="{{ asset('assets/plugins/momentjs/moment.js') }}"></script>
<script src="{{ asset('assets/plugins/DateTimePicker/js/bootstrap-material-datetimepicker.js') }}"></script>
<script type="text/javascript">
    function setActive(active)
    {
        $("#Active").val(active).trigger('change');
    }

    function setVehicle(vehicleId)
    {
        if ($("#Vehicle option").length > 1) {
            $("#Vehicle").val(vehicleId).trigger('change');
        }
    }

    $(document).ready(function() {
        $('.btn-save').on('click', function (){
            $('.form-save').submit();
        });

        $.ajax({
            type: 'GET',
            url: '{{ route('ajax.vehicles.lists') }}',
            success: function (res) {
                let select = $('#Vehicle');
                select.html('');
                select.append('<option value="0">Selecione o Veículo</option>');

                $(res).each(function (index, value) {
                   select.append('<option value="'+value.id+'">'+value.name+'</option>')
                });
            }
        });

        @if($errors->any())
            @if(old('vehicle_id'))
                let timerVehicle = setTimeout(() => setVehicle('{{ old('vehicle_id') }}'), 1000);
            @endif

            @if(old('active'))
                let activeTimer = setTimeout(() => setActive('{{ old('active') }}'), 500);
            @endif
        @endif

        let quill = new Quill('#Editor', { theme: 'snow' });
        quill.on('editor-change', function(delta, oldDelta, source) {
            $('#InputEditor').val(quill.root.innerHTML);
        });
        $('.time').bootstrapMaterialDatePicker({
            date: false,
            shortTime: false,
            format: 'HH:mm',
            clearButton: false
        });
    });
</script>
@endsection
