@extends('layouts.app')

@section('content')
    <!-- Header -->
    @include('layouts.header', [
        'header_title' => 'Visualizar veículo',
        'header_subtitle' => 'Visualização de veículos',
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
                <h3 class="mb-0">Visualização de Veículo</h3>
            </div>
            <!-- Card body -->
            <div class="card-body">
                <!-- Form groups used in grid -->
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="Name">Nome</label>
                            <div>{{ $vehicle->name }}</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-control-label" for="Middle">Meio</label>
                        <div>{{ $vehicle->middle->name }}</div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-control-label" for="Active">Situação</label>
                            <div>{{ $vehicle->active ? 'Ativo' : 'Inativo' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="State">Estado</label>
                            <div>{{ $vehicle->state->title }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="City">Cidade</label>
                            <div>{{ $vehicle->city->title }}</div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-control-label" for="Description">Descrição</label>
                            <div>{!! $vehicle->description ?? '' !!}</div>
                        </div>
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
@endsection

@section('scripts')
<script src="{{ asset('template/assets/vendor/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('template/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('template/assets/vendor/js-cookie/js.cookie.js') }}"></script>
<script src="{{ asset('template/assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
<script src="{{ asset('template/assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>
{{--<script src="{{ asset('template/assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>--}}
@endsection
