@extends('layouts.app')

@section('content')
    <!-- Header -->
    @include('layouts.header', [
        'header_title' => request()->query('perfil') ? 'Meu Perfil' : 'Editar Usuário',
        'header_subtitle' => request()->query('perfil') ? 'Alterar minhas informações' : 'Alterar cadastro de usuário',
        'header_subtitle_icon' => 'fas fa-user',
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
                @if (request()->query('perfil'))
                    <h3 class="mb-0">Meu Perfil</h3>
                @else
                    <h3 class="mb-0">Editar Usuário: {{ $user->name }}</h3>
                @endif
            </div>
            <!-- Card body -->
            <div class="card-body">
                <!-- Form groups used in grid -->
                <form class="form-save" method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-control-label" for="Avatar"><span class="float-left mr-1">Avatar</span><small class="badge badge-primary">Clique p/ editar</small></label>
                                <span class="rounded-circle d-block">
                                <img alt="Avatar" class="img-fluid" id="previewAvatar" src="{{ $user->getAvatar() }}" style="max-width: 60px; max-height: 60px;">
                            </span>
                                <input type="file" name="avatar" class="form-control" id="Avatar" style="display:none;">
                            </div>
                            @error('avatar')
                            <small class="text-danger font-weight-bold">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-10">
                            <label class="form-control-label" for="Name">Nome</label>
                            <input type="text" name="name" class="form-control @error('name')is-invalid @enderror"
                                   value="{{ old('name') ?? $user->name }}" id="Name" placeholder="Qual o Nome do Usuário ?">
                        </div>
                        <div class="col-md-6">
                            <label class="form-control-label" for="Email">Email</label>
                            <input type="email" name="email" class="form-control @error('email')is-invalid @enderror"
                                   value="{{ old('email') ?? $user->email }}" id="Email" placeholder="Qual o Email do Usuário ?" readonly="readonly">
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label" for="Password">Senha</label>
                                <input type="password" name="password" class="form-control @error('password')is-invalid @enderror"
                                       value="{{ old('password') ?? '' }}" id="Password" placeholder="Qual a Senha do Usuário ?" readonly="readonly">
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
@endsection

@section('scripts')
<!-- Optional JS -->
<script>
    function readURL(imageInput) {
        if (imageInput.files && imageInput.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#previewAvatar').attr('src', e.target.result);
            };

            reader.readAsDataURL(imageInput.files[0]);
        }
    }

    $(document).ready(function() {
        // Save
        $('.btn-save').on('click', function (){
            $('.form-save').submit();
        });
        $('input[readonly]').removeAttr('readonly');

        $('#Avatar').change(function() {
            readURL(this);
        });
        $('#previewAvatar').on('click', function() {
            $('#Avatar').click();
        });
    });
</script>
@endsection
