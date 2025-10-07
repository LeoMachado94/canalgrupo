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
        <form class="form-save" method="POST" action="{{ route('clippings.store') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="card mb-4">
            <!-- Card header -->
            <div class="card-header">
                <h3 class="mb-0">Cadastro de Clipping</h3>
            </div>
            <!-- Card body -->
            <div class="card-body">
                <!-- Form groups used in grid -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="Client">Cliente</label>
                            <select name="client_id" class="form-control" data-toggle="select" id="Client">
                                <option>Selecione o Cliente</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="Subject">Assunto</label>
                            <div class="input-group">
                                <select name="subject_matter_id" class="form-control w-100" id="Subject">
                                    <option>Selecione o Assunto</option>
                                </select>
                                <span class="input-group-append btn-append">
                                    <a href="#" data-toggle="modal" data-target="#createSubjectModal"
                                       class="btn btn-sm btn-dark h-100 btn-add-subject">
                                        <i class="fa fa-plus my-auto"></i>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="Titulo">Título</label>
                            <input name="title" type="text" class="form-control" value="{{ old('title', '') }}"
                                   id="Titulo" placeholder="Qual o Título do Clipping">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="Midle">Meio</label>
                            <select name="middle_id" class="form-control" data-toggle="select" id="Middle">
                                <option>Selecione o Meio</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="Vehicle">Veículo</label>
                            <select name="vehicle_id" class="form-control" data-toggle="select" id="Vehicle">
                                <option>Selecione o Veículo</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="Editorial">Editorial / Programa</label>
                            <select name="editorial_id" class="form-control" data-toggle="select" id="Editorial">
                                <option>Selecione Editorial / Programa</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-control-label" for="Classification">Classificação</label>
                            <select name="classification_id" class="form-control" data-toggle="select" id="Classification">
                                <option>Selecione a Classificação</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-control-label" for="Exhibition">Exibição</label>
                            <select name="exhibition_id" class="form-control" data-toggle="select" id="Exhibition">
                                <option>Selecione a Exibição</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-control-label" for="Source">Fonte</label>
                            <select name="source_id" class="form-control" data-toggle="select" id="Source">
                                <option>Selecione a Fonte</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-control-label" for="exampleDatepicker">Data</label>
                            <input name="date" class="form-control datepicker" value="{{ old('date', '') }}"
                                   placeholder="Selecione a data" type="text">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-control-label" for="Favorite">Favorito</label>
                            <select name="is_favorite" class="form-control" data-toggle="select" id="Favorite">
                                <option value="0">Não</option>
                                <option value="1">Sim</option>
                            </select>
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
                <h3 class="mb-0">Selecione o(s) arquivo(s)</h3>
            </div>
            <!-- Card body -->
            <div class="card-body disabled">
                <!-- Multiple -->
                <div class="alert alert-secondary">Para anexar arquivos é preciso salvar o clipping primeiro.</div>
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
                    <div id="Editor">{!! old('review', '') !!}</div>
                    <input type="hidden" id="InputEditor" name="review" value="{{ old('review', '') }}" class="form-control">
                </div>
            </div>
        </div>
        </form>
        <!-- fim -->


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
    @include('clippings.includes.modalAddSubject')
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/QuillEditor/quill.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/DateTimePicker/css/bootstrap-material-datetimepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('template/assets/css/extras.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('template/assets/vendor/select2/dist/js/select2.min.js') }}"></script>
{{--<script src="{{ asset('template/assets/vendor/nouislider/distribute/nouislider.min.js') }}"></script>--}}
{{--<script src="{{ asset('template/assets/vendor/quill/dist/quill.min.js') }}"></script>--}}
<script src="{{ asset('template/assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('template/assets/vendor/bootstrap-datepicker/dist/locales/bootstrap-datepicker.pt-BR.min.js') }}"></script>
<script src="{{ asset('template/assets/vendor/dropzone/dist/min/dropzone.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
{{--<script src="{{ asset('template/assets/vendor/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>--}}
<script src="{{ asset('assets/plugins/jquery_mask/jquery.mask.min.js') }}"></script>
<script src="{{ asset('assets/plugins/QuillEditor/quill.js') }}"></script>
<script src="{{ asset('assets/plugins/momentjs/moment.js') }}"></script>
<script src="{{ asset('assets/plugins/DateTimePicker/js/bootstrap-material-datetimepicker.js') }}"></script>
<script>
    // Default Format Datepicker
    $.fn.datepicker.defaults.format = "dd/mm/yyyy";
    $.fn.datepicker.defaults.language = "pt-BR";

    $('.date').mask('00/00/0000', {placeholder: '__/__/____'});
    $('.dateMonthYear').mask('00/0000', {placeholder: 'mm/aaaa'});


    $(document).ready(function() {
        // Save
        $('.btn-save').on('click', function (){
            $('.form-save').submit();
        });

        var clientId = '{{ old('client_id') }}' ? '{{ old('client_id') }}' : 0;
        var subjectId = '{{ old('subject_matter_id') }}' ? '{{ old('subject_matter_id') }}' : 0;
        var middleId = '{{ old('middle_id') }}' ? '{{ old('middle_id') }}' : 0;
        var vehicleId = '{{ old('vehicle_id') }}' ? '{{ old('vehicle_id') }}' : 0;
        var editorialId = '{{ old('editorial_id') }}' ? '{{ old('editorial_id') }}' : 0;
        var classificationId = '{{ old('classification_id') }}' ? '{{ old('classification_id') }}' : 0;
        var exhibitionId = '{{ old('exhibition_id') }}' ? '{{ old('exhibition_id') }}' : 0;
        var sourceId = '{{ old('source_id') }}' ? '{{ old('source_id') }}' : 0;
        var favorite = '{{ old('is_favorite') }}' ? '{{ old('is_favorite') }}' : 0;

        // Load Favorite
        function loadFavorite(element = null, setDefault) {
            if (element === null) {
                element = '#Favorite';
            }
            $(element).val(setDefault).trigger('change.select2');
        }

        // Load Clients
        function loadClient(element = null) {
            if (element === null) {
                element = '#Client';
            }
            $.ajax({
                type: 'GET',
                url: '{{ route('ajax.clients.lists') }}',
                success: function (res) {
                    populateSelect(element, res, 'Selecione o cliente', clientId);
                }
            });
        }

        // Load Subjects
        function loadSubject(element = null, setDefault = 0) {
            if (setDefault !== 0) {
                setDefault = setDefault;
            }
            if (element === null) {
                element = '#Subject';
            }

            if ($('#Client').val() !== '0') {
                $('#Subject').select2({
                    ajax: {
                        url: '{{ route('ajax.subjects.lists') }}',
                        data: function (params) {
                            var query = {
                                search: params.term,
                                type: 'public',
                                client_id: $('#Client').val()
                            }

                            // Query parameters will be ?search=[term]&type=public
                            return query;
                        },
                        processResults: function (data) {
                            return {
                                results: $.map(data, function(obj) {
                                    return { id: obj.id, text: obj.title };
                                })
                            };
                        },
                        cache: true
                    }
                });
            }
        }

        // Load Classifications
        function loadClassification() {
            $.ajax({
                type: 'GET',
                url: '{{ route('ajax.classifications.lists') }}',
                success: function (res) {
                    populateSelect('#Classification', res, 'Selecione a classificação', classificationId);
                }
            });
        }

        // Load Exhibitions
        function loadExhibition() {
            $.ajax({
                type: 'GET',
                url: '{{ route('ajax.exhibitions.lists') }}',
                success: function (res) {
                    populateSelect('#Exhibition', res, 'Selecione a exibição', exhibitionId);
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

        function loadMiddle() {
            // Load Middles
            $.ajax({
                type: 'GET',
                url: '{{ route('ajax.middles.lists') }}',
                success: function (res) {
                    async: false,
                        populateSelect('#Middle', res, 'Selecione o Meio', middleId);
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

        function loadEditorial() {
            if (vehicleId) {
                let url = '{{ route('ajax.editorials.lists', ['vehicle' => 'ID']) }}';
                url = url.replace('ID', vehicleId);
                // Load Middles
                $.ajax({
                    type: 'GET',
                    url: url,
                    async: false,
                    success: function (res) {
                        populateSelect('#Editorial', res, 'Selecione o Editorial / Programa', editorialId, 'title')
                    }
                });
            }
        }

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

        loadClient();
        loadClient('#ClientModal');
        loadSubject(null, subjectId);
        loadClassification();
        loadExhibition();
        loadSource();
        loadFavorite(null, favorite);

        loadMiddle();
        loadVehicle();
        loadEditorial();

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

        // On Vehicle Change
        $('#Vehicle').on('change', function () {
            let select = $('#Editorial');
            select.prop('disabled', true);
            select.html('');
            select.append('<option value="0">Carregando...</option>');

            let vehicle_id = $(this).val();
            if (vehicle_id !== 0) {

                let url = '{{ route('ajax.editorials.lists', ['vehicle' => 'ID']) }}';
                url = url.replace('ID', vehicle_id);

                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function (res) {
                        let select = $('#Editorial');
                        select.html('');
                        select.append('<option value="0">Selecione o Editorial / Programa</option>');
                        $(res).each(function (index, value) {
                            select.append('<option value="' + value.id + '">' + value.title + '</option>')
                        });
                        select.prop('disabled', false);
                    }
                });
            }
        });

        let quill = new Quill('#Editor', { theme: 'snow' });
        quill.on('editor-change', function(delta, oldDelta, source) {
            $('#InputEditor').val(quill.root.innerHTML);
        });

        $('body').on('click', '.btn-save-subject', function(e) {
            let data = $('.form-save-subject').serializeArray();
            let url = '{{ route('ajax.subjects.store') }}';

            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                success: function (res) {
                    if (!(res.success)) {
                        $('.error-messages').html(res.message).slideDown();
                    } else {
                        $('#createSubjectModal').modal('hide');
                        $('.error-messages').html(res.message).hide();
                        loadSubject(null, res.subject.id);

                        swal({
                            title: res.title,
                            text: res.message,
                            icon: res.icon,
                            button: "OK!",
                        });
                    }
                },
                error: function (errors) {
                    $('.error-messages').html(errors.responseJSON.errors.title[0]).slideDown();
                }
            });
            // let data = new FormData($('.form-save-subject'));
            // console.log(data);
        });
    });
</script>
@endsection
