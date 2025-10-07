@extends('layouts.app')

@section('content')
    <!-- Header -->
    @include('layouts.header', [
        'header_title' => 'Relatórios',
        'header_subtitle' => 'Veja aqui todos os relatórios sobre seus clientes',
        'header_subtitle_icon' => 'ni ni-chart-pie-35'
    ])
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card" style="padding: 0 1rem;">
                    <!-- Card header -->
                    <div class="card-header pl-0 border-0">
                        <h3 class="mb-0">Visualizar Relatório</h3>
                    </div>
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-10 col-md-10 col-sm-12">
                                <object data="{{ Storage::disk('spaces')->url($filepath) }}" type="application/pdf" width="750px" height="750px">
                                    <embed src="{{ Storage::disk('spaces')->url($filepath) }}" type="application/pdf">
                                    <p>This browser does not support PDFs. Please download the PDF to view it: <a href="http://yoursite.com/the.pdf">Download PDF</a>.</p>
                                    </embed>
                                </object>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-12">
                                <a href="{{ Storage::disk('spaces')->url($filepath) }}" target="_blank" class="btn btn-success w-100"><i class="fa fa-download"></i> Download</a>
                                @if(!empty(request()->query('client_id')))
                                    <a href="#" data-toggle="modal" data-target="#sendMailModal" class="btn btn-dark w-100 mt-2"><i class="fa fa-envelope"></i> Enviar por email</a>
                                @endif
                                <a href="{{ route('clippings.index') }}" class="btn btn-danger w-100 mt-2"><i class="fa fa-arrow-left"></i> Voltar</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-danger error-messages"></div>
                            </div>
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
    @include('reports.includes.modalSendMail')
    @include('reports.includes.modalSendingMail')
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('template/assets/css/extras.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
    <script>
        $('body').on('click', '.btn-send-email', function(e) {
            $('#sendMailModal').modal('hide');
            $('#sendingMailModal').modal('show');

            let data = {
                "report": '{{ $fileName }}',
                "month": '{{ request()->query('month') }}'
            };
            // ID = client_id
            let url = '{{ route('ajax.reports.sendMail', 'CLIENT') }}';
            url = url.replace('CLIENT', '{{ request()->query('client_id') }}');

            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                success: function (res) {
                    setTimeout(function() {
                        $('#sendingMailModal').modal('hide');
                        $('.error-messages').html(res.message).hide();

                        swal({
                            title: res.title,
                            text: res.message,
                            icon: res.icon,
                            button: "OK!",
                        });
                    }, 3000);
                }
            });
        });
    </script>
@endsection
