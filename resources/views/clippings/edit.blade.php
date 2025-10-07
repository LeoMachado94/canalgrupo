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
        <form class="form-save" method="POST" action="{{ route('clippings.update', $clipping->id) }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        @method('PUT')
		@if(request()->query('action'))
			<input name="action" type="hidden" value="{{ request()->query('action') }}">
		@endif
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
                                <select name="subject_matter_id" class="form-control w-100" data-toggle="select" id="Subject">
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
                            <input name="title" type="text" class="form-control" value="{{ old('title', $clipping->title) }}"
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
                            <input name="date" class="form-control datepicker" value="{{ old('date', $clipping->date) }}"
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
                    <h3 class="mb-0">Selecione o arquivo</h3>
                </div>
                <!-- Card body -->
                <div class="card-body">
                    <!-- Multiple -->
                    <div class="dropzone dropzone-multiple" data-toggle="dropzone" data-dropzone-multiple data-dropzone-url="{{ route('ajax.clippings.uploads.store') }}">
                        <div class="fallback">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFileUploadMultiple" multiple>
                                <label class="custom-file-label" for="customFileUploadMultiple">Choose file</label>
                            </div>
                        </div>
                        <div class="progress mt-2 mb-1" style="height: 30px;">
                            <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%; height: 30px;" data-dz-uploadprogress></div>
                        </div>
                        <ul class="dz-preview dz-preview-multiple list-group list-group-lg list-group-flush">
                            <li class="list-group-item px-0">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="avatar">
                                            <img class="icon-img rounded" src="{{ asset('assets/images/file_icon.jpg') }}" alt="" data-dz-thumbnail>
                                        </div>
                                    </div>
                                    <div class="col ml--3">
                                        <h4 class="mb-1" data-dz-name>...</h4>
                                        <p class="small text-muted mb-0" data-dz-size>...</p>
                                    </div>
                                    <div class="col-3 ml--2">
                                        <span class="mb-1 badge fileType"></span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fe fe-more-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="#" class="dropdown-item removeFile">
                                                    Deletar
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="message text-danger"></div>
                            </li>
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
                    <div id="Editor">{!! old('review', $clipping->review) !!}</div>
                    <input type="hidden" id="InputEditor" name="review" value="{{ old('review', $clipping->review) }}" class="form-control">
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
    <div id="overlay"></div>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/QuillEditor/quill.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/DateTimePicker/css/bootstrap-material-datetimepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('template/assets/css/extras.css') }}">
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
<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script>
    // Default Format Datepicker
    $.fn.datepicker.defaults.format = "dd/mm/yyyy";
    $.fn.datepicker.defaults.language = "pt-BR";

    $('.date').mask('00/00/0000', {placeholder: '__/__/____'});

    Dropzone.autoDiscover = false;
    Dropzone.timeout = 6000;

    $(document).ready(function() {
        // Save
        $('.btn-save').on('click', function (){
            $('.form-save').submit();
        });

        var clientId = '{{ old('client_id') }}' ? '{{ old('client_id') }}' : '{{ $clipping->client_id }}';
        var subjectId = '{{ old('subject_matter_id') }}' ? '{{ old('subject_matter_id') }}' : '{{ $clipping->subject_matter_id }}';
        var subjectTitle = '{{ old('subject_matter_title') }}' ? '{{ old('subject_matter_title') }}' : '{{ $clipping->subject->title }}';
        var middleId = '{{ old('middle_id') }}' ? '{{ old('middle_id') }}' : '{{ $clipping->middle_id }}';
        var vehicleId = '{{ old('vehicle_id') }}' ? '{{ old('vehicle_id') }}' : '{{ $clipping->vehicle_id }}';
        var editorialId = '{{ old('editorial_id') }}' ? '{{ old('editorial_id') }}' : '{{ $clipping->editorial_id }}';
        var classificationId = '{{ old('classification_id') }}' ? '{{ old('classification_id') }}' : '{{ $clipping->classification_id }}';
        var exhibitionId = '{{ old('exhibition_id') }}' ? '{{ old('exhibition_id') }}' : '{{ $clipping->exhibition_id }}';
        var sourceId = '{{ old('source_id') }}' ? '{{ old('source_id') }}' : '{{ $clipping->source_id }}';
        var favorite = '{{ old('is_favorite') }}' ? '{{ old('is_favorite') }}' : '{{ $clipping->is_favorite }}';

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

        // Load Clients
        function loadSubjectFirst(element = null) {
            if (element === null) {
                element = '#Subject';
            }
            $.ajax({
                type: 'GET',
                url: '{{ route('ajax.subjects.lists', ['client_id' => (old('client_id') ?? $clipping->client_id)]) }}',
                success: function (res) {
                    populateSelect(element, res, 'Selecione o assunto', subjectId, 'title');
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

            if ($('#Client').val() != '0') {
                $('#Subject').select2({
                    ajax: {
                        url: '{{ route('ajax.subjects.lists') }}',
                        data: function (params) {
                            var query = {
                                search: params.term,
                                type: 'public',
                                client_id: clientId
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

                if (setDefault) {
                    $(element).val(setDefault).trigger('change.select2');
                }
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
        loadSubject(null, subjectId); // Load on click (query string search)
        loadSubjectFirst(null);
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

        Dropzone.autoDiscover = false;
        // Dropzone
        'use strict';
        var Dropzones = (function() {

            //
            // Variables
            //
            var $dropzone = $('[data-toggle="dropzone"]');
            var $dropzonePreview = $('.dz-preview');

            function init($this) {
                var multiple = ($this.data('dropzone-multiple') !== undefined) ? true : false;
                var preview = $this.find($dropzonePreview);
                var currentFile = undefined;

                // Init options
                var options = {
                    url: $this.data('dropzone-url'),
                    headers: {
                        'x-csrf-token': document.querySelectorAll('meta[name=csrf-token]')[0].getAttributeNode('content').value,
                    },
                    thumbnailWidth: null,
                    thumbnailHeight: null,
                    previewsContainer: preview.get(0),
                    previewTemplate: preview.html(),
                    maxFiles: (!multiple) ? 1 : null,
                    acceptedFiles: (!multiple) ? 'image/*' : null,
                    parallelUploads: 1,
                    init: function() {
                        this.on("sending", function(file, xhr, formData){
                            formData.append("clipping_id", '{{ $clipping->id }}')
                        });
                        this.on("addedfile", function(file) {
                            $(file.previewTemplate).find('.removeFile').attr('data-id', file.id);
                            if (file.badge_color === 'bg-dark') {
                                $(file.previewTemplate).find('.fileType').addClass('text-white');
                            }
                            $(file.previewTemplate).find('.fileType').addClass(file.badge_color).html(file.type);
                            if (!multiple && currentFile) {
                                this.removeFile(currentFile);
                            }
                        });
                        this.on('complete', function (file) {
                            if (file && file.xhr) {
                                let xhrResponse = $.parseJSON(file.xhr.response);

                                if (xhrResponse.errors !== undefined && xhrResponse.errors.file !== undefined) {
                                    let errorMessage = xhrResponse.errors.file[0];
                                    $(file.previewTemplate).addClass('border-danger').find('.message').html(errorMessage);
                                }
                            }
                        });
                        this.on('success', function (file, response) {
                            $(file.previewTemplate).find('.removeFile').attr('data-id', response.file.id);
                            if (response.file.badge_color === 'bg-dark') {
                                $(file.previewTemplate).find('.fileType').addClass('text-white');
                            }

                            $(file.previewTemplate).find('.fileType').addClass(response.file.badge_color).html(response.file.type);
                        });
                        this.on('uploadprogress', (file, progress, bytesSent) => {
                            console.log(file);
                            console.log(file.upload.progress);
                            console.log(file.upload.bytesSent);

                            $(".progress-bar").css('width', file.upload.progress+'%').html(file.upload.progress.toFixed(2)+' %');
                        });
                        this.on("queuecomplete", function (progress) {
                            $(".progress-bar").css('width', '0%').html('');
                        });

                        @foreach($clipping->files->sortBy('type') as $file)
                            var mockFile = {
                                id: '{{ $file->id }}',
                                name: '{{ $file->name }}',
                                size: 12345,
                                type: '{{ $file->type }}',
                                badge_color: '{{ $file->badge_color }}'
                            };
                            this.files.push(mockFile);
                            this.emit('addedfile', mockFile);
                            this.emit('complete', mockFile);
                        @endforeach
                    }
                };

                // Clear preview html
                preview.html('');
                // Init dropzone
                $this.dropzone(options)
            }

            function globalOptions() {
                Dropzone.autoDiscover = false;
                Dropzone.timeout = 6000;
            }

            // Events
            if ($dropzone.length) {
                // Set global options
                globalOptions();
                // Init dropzones
                $dropzone.each(function() {
                    init($(this));
                });
            }
        })();

        $('body').on('click', '.removeFile', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            let divTemplate = $(this).closest('.list-group-item');

            let urlDelete = ('{{ route('ajax.clippings.uploads.destroy', 'ID') }}').replace('ID', id);
            $.ajax({
                type: 'DELETE',
                url: urlDelete,
                success: function (res) {
                    if (res.success) {
                        divTemplate.slideUp();
                    }
                }
            });
        });

        // Add Subject
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
                }
            });
            // let data = new FormData($('.form-save-subject'));
            // console.log(data);
        });
    });


</script>
@endsection
