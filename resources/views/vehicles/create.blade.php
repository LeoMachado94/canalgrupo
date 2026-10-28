@extends('layouts.app')

@section('content')
    <!-- Header -->
    @include('layouts.header', [
        'header_title' => 'Novo veículo',
        'header_subtitle' => 'Cadastro de veículos',
        'header_subtitle_icon' => 'fas fa-bullhorn',
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
                <h3 class="mb-0">Cadastro de Veículos</h3>
            </div>
            <!-- Card body -->
            <div class="card-body">
                <!-- Form groups used in grid -->
                <form class="form-save" method="POST" action="{{ route('vehicles.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="Name">Nome</label>
                            <input type="text" name="name" class="form-control @error('name')is-invalid @enderror"
                                   value="{{ old('name') ?? '' }}" id="Name" placeholder="Qual o Nome do Veículo ?">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-control-label" for="Middle">Meio</label>
                        <select class="form-control @error('middle_id')is-invalid @enderror" name="middle_id"
                                id="Middle" data-toggle="select">
                            <option>Selecione o Meio</option>
                        </select>
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
                            <label class="form-control-label" for="State">Estado</label>
                            <select class="form-control @error('state_id')is-invalid @enderror" name="state_id"
                                    id="State" data-toggle="select">
                                <option>Selecione o Estado</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="City">Cidade</label>
                            <select class="form-control @error('city_id')is-invalid @enderror" name="city_id"
                                    id="City" data-toggle="select">
                                <option>Selecione a Cidade</option>
                            </select>
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
<script src="{{ asset('template/assets/vendor/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/QuillEditor/quill.js') }}"></script>
<script src="{{ asset('assets/plugins/momentjs/moment.js') }}"></script>
<script src="{{ asset('assets/plugins/DateTimePicker/js/bootstrap-material-datetimepicker.js') }}"></script>
<script type="text/javascript">
    function setState(stateId)
    {
        if ($("#State option").length > 1) {
            $("#State").val(stateId).trigger('change');
        }
    }

    function setCity(cityId)
    {
        if ($("#City option").length > 1) {
            $("#City").val(cityId).trigger('change');
        }
    }

    function setActive(active)
    {
        $("#Active").val(active).trigger('change');
    }

    function setMiddle(middle_id)
    {
        $("#Middle").val(middle_id).trigger('change');
    }

    $(document).ready(function() {
        $('.btn-save').on('click', function (){
            $('.form-save').submit();
        });

        $.ajax({
            type: 'GET',
            url: '{{ route('ajax.states.lists') }}',
            success: function (res) {
                let select = $('#State');
                select.html('');
                select.append('<option value="0">Selecione o Estado</option>');

                $(res).each(function (index, value) {
                   select.append('<option value="'+value.id+'">'+value.title+'</option>')
                });
            }
        });

        $.ajax({
            type: 'GET',
            url: '{{ route('ajax.middles.lists') }}',
            success: function (res) {
                let select = $('#Middle');
                select.html('');
                select.append('<option value="0">Selecione o Meio</option>');

                $(res).each(function (index, value) {
                    select.append('<option value="'+value.id+'">'+value.name+'</option>')
                });
            }
        });

        $('#State').on('change', function() {
            let select = $('#City');
            select.prop('disabled', true);
            select.html('');
            select.append('<option value="0">Carregando...</option>');

            let state_id = $(this).val();
            if (state_id !== 0) {

               let url = '{{ route('ajax.cities.lists', 'ID') }}';
               url = url.replace('ID', state_id);

                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function (res) {
                        let select = $('#City');
                        select.html('');
                        select.append('<option value="0">Selecione a Cidade</option>');
                        $(res).each(function (index, value) {
                           select.append('<option value="'+value.id+'">'+value.title+'</option>')
                        });
                        $('#City').prop('disabled', false);
                    }
                });
            }
        });

        @if($errors->any())
            @if(old('state_id'))
            let timer1 = setTimeout(() => setState('{{ old('state_id') }}'), 1000);
            @endif

            @if(old('city_id'))
            let timer2 = setTimeout(() => setCity('{{ old('city_id') }}'), 2000);
            @endif

            @if(old('middle_id'))
            let timer3 = setTimeout(() => setMiddle('{{ old('middle_id') }}'), 1000);
            @endif

            @if(old('active'))
            let timer4 = setTimeout(() => setActive('{{ old('active') }}'), 500);
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
