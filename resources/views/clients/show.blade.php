@extends('layouts.app')

@section('content')
    <!-- Header -->
    @include('layouts.header', [
        'header_title' => 'Visualizar cliente',
        'header_subtitle' => 'Visualização de clientes da empresa',
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
                <h3 class="mb-0">Visualização de Cliente</h3>
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
                            <div>{{ $client->name ?? '' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="Cnpj">CNPJ</label>
                            <div>{{ $client->cnpj ?? '' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="State">Estado</label>
                            <div>{{ $client->state->title ?? '' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="City">Cidade</label>
                            <div>{{ $client->city->title ?? '' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="Contact">Contato</label>
                            <div>{{ $client->contact ?? '' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="Email">Email</label>
                            <div>{{ $client->email ?? '' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-control-label" for="Logo">Logo</label>
                        <div><img class="img-fluid" src="{{ $client->getLogo() }}" style="max-width: 300px;"></div>
                    </div>
                    <div class="col-md-12">
                        <hr style="border-color: #E33039;">
                    </div>
                    <div class="col-md-6">
                        <h2 class="text-red">Telefones</h2>
                        <table class="table" id="phones">
                            <tbody>
                                @foreach($client->phones as $phone)
                                <tr>
                                    <td>
                                       {!! '<i class="fa fa-phone"></i>' !!} <span class="phone">{{ $phone->phone_number ?? '' }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h2 class="text-red">Emails</h2>
                        <table class="table" id="emails">
                            @foreach($client->emails as $email)
                                <tr>
                                    <td>
                                        {!! '<i class="fa fa-envelope"></i>' !!} <span class="email">{{ $email->email ?? '' }}</span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                </form>
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
<script src="{{ asset('assets/plugins/jquery_mask/jquery.mask.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery_mask/behaviors/phone.js') }}"></script><!-- Behavior Mask Phone -->
<script>
    $(document).ready(function() {
        $('.phone').mask(phoneMaskBehavior, phoneMaskOptions);
    });
</script>
{{--<script src="{{ asset('template/assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>--}}
@endsection
