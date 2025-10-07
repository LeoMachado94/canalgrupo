@extends('layouts.app')

@section('content')
    <!-- Header -->
    @include('layouts.header', [
        'header_title' => 'Novo cliente',
        'header_subtitle' => 'Cadastro de clientes da empresa',
        'header_subtitle_icon' => 'fas fa-users',
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
                <h3 class="mb-0">Cadastro de Clientes</h3>
            </div>
            <!-- Card body -->
            <div class="card-body">
                <!-- Form groups used in grid -->
                <form class="form-save" method="POST" action="{{ route('clients.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="text-red">Informações Gerais</h2>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="Name">Nome</label>
                            <input type="text" name="name" class="form-control @error('name')is-invalid @enderror"
                                   value="{{ old('name') ?? '' }}" id="Name" placeholder="Qual o Nome da Empresa ?">
                            @error('name')
                            <small class="text-danger font-weight-bold">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="Cnpj">CNPJ</label>
                            <input type="text" name="cnpj" class="form-control cnpj @error('cnpj')is-invalid @enderror"
                                   value="{{ old('cnpj') ?? '' }}" id="Cnpj" placeholder="Qual o CNPJ da Empresa ?">
                            @error('cnpj')
                            <small class="text-danger font-weight-bold">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="State">Estado</label>
                            <select class="form-control @error('state_id')is-invalid @enderror" name="state_id"
                                    id="State" data-toggle="select">
                                <option value="0">Selecione o Estado</option>
                            </select>
                            @error('state_id')
                            <small class="text-danger font-weight-bold">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="City">Cidade</label>
                            <select class="form-control @error('city_id')is-invalid @enderror" name="city_id"
                                    id="City" data-toggle="select">
                                <option value="0">Selecione a Cidade</option>
                            </select>
                            @error('city_id')
                            <small class="text-danger font-weight-bold">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="Email">Email</label>
                            <input type="text" name="email" class="form-control @error('email')is-invalid @enderror" id="Email" placeholder="Qual o Email ?">
                            @error('email')
                            <small class="text-danger font-weight-bold">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="Password">Senha</label>
                            <input type="password" name="password" class="form-control @error('password')is-invalid @enderror" id="Email" placeholder="Qual a senha ?">
                            @error('password')
                            <small class="text-danger font-weight-bold">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="Contact">Contato</label>
                            <input type="text" name="contact" class="form-control @error('contact')is-invalid @enderror"
                                   value="{{ old('contact') ?? '' }}" id="Contact" placeholder="Qual o Contato Responsável ?">
                            @error('contact')
                            <small class="text-danger font-weight-bold">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>
                    <div class="col-md-6">
                        <label class="form-control-label" for="Logo">Logo</label>
                        <input type="file" name="logo" class="form-control" id="Logo">
                        @error('logo')
                        <small class="text-danger font-weight-bold">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-6">
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
                        <img id="previewLogo" class="img-fluid" src="{{ asset('assets/images/no_image.png') }}" style="max-width: 300px;">
                    </div>
                    <div class="col-md-12">
                        <hr style="border-color: #E33039;">
                    </div>
                    <div class="col-md-6">
                        <h2 class="text-red">Telefones</h2>
                        <table class="table" id="phones">
                            <thead>
                                <tr>
                                    <th>Número</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                            </div>
                                            <input type="text" name="phones[]" class="form-control phone">
                                        </div>
                                    </td>
                                    <td class="actions">
                                        <a href="#" class="table-action table-action-add add-phone" data-toggle="tooltip" data-original-title="Novo">
                                            <i class="fas fa-plus"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h2 class="text-red">Emails</h2>
                        <table class="table" id="emails">
                            <thead>
                            <tr>
                                <th>Email</th>
                                <th>Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                        </div>
                                        <input type="text" name="emails[]" class="form-control email">
                                    </div>
                                </td>
                                <td class="actions">
                                    <a href="#" class="table-action table-action-add add-email" data-toggle="tooltip" data-original-title="Novo">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
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
<style type="text/css">
.actions {
    display: table-cell;
    vertical-align: middle !important;
}
.table-action i {
    font-size: 20px;
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
<script src="{{ asset('assets/plugins/jquery_mask/jquery.mask.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery_mask/behaviors/phone.js') }}"></script><!-- Behavior Mask Phone -->
<script type="text/javascript">
    // Mask
    $('.cnpj').mask('00.000.000/0000-00', {placeholder: '00.000.000/0000-00'});
    $('.phone').mask(phoneMaskBehavior, phoneMaskOptions);

    function readURL(imageInput) {
        if (imageInput.files && imageInput.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#previewLogo').attr('src', e.target.result);
            }

            reader.readAsDataURL(imageInput.files[0]);
        }
    }

    function setActive(active)
    {
        $("#Active").val(active).trigger('change');
    }

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

    $(document).ready(function() {
        $('.btn-save').on('click', function (){
            $('.form-save').submit();
        });

        $('#Logo').change(function() {
            readURL(this);
        });

        // EMAILS
        $('body').on('click', '.add-email', function(e) {
            e.preventDefault();
            let buttonDelete =
                '<a href="#" class="table-action table-action-delete delete-email" data-toggle="tooltip" data-original-title="Deletar">\n' +
                '<i class="fas fa-trash"></i>\n' +
                '</a>';
            let row = $('#emails tbody tr:last').clone().find("input:text").val("").end().appendTo('#emails tbody');
            if (!row.find('.delete-email').length) {
                row.find('.actions').prepend(buttonDelete);
            }
        });

        $('body').on('click', '.delete-email', function(e) {
            e.preventDefault();
            $(this).closest('tr').remove();
        });

        // PHONES
        $('body').on('click', '.add-phone', function(e) {
            e.preventDefault();
            let buttonDelete =
                '<a href="#" class="table-action table-action-delete delete-phone" data-toggle="tooltip" data-original-title="Deletar">\n' +
                '<i class="fas fa-trash"></i>\n' +
                '</a>';
            let row = $('#phones tbody tr:last').clone().find("input:text").val("").end().appendTo('#phones tbody');
            if (!row.find('.delete-phone').length) {
                row.find('.actions').prepend(buttonDelete);
            }
            $('.phone').mask(phoneMaskBehavior, phoneMaskOptions);
        });

        $('body').on('click', '.delete-phone', function(e) {
            e.preventDefault();
            $(this).closest('tr').remove();
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

            @if(old('active'))
            let timer3 = setTimeout(() => setActive('{{ old('active') }}'), 1000);
            @endif
        @endif
    });
</script>
@endsection
