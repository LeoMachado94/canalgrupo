<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Lista Canal Service - Visualizar Clipping</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('template/favicon.png') }}" type="image/png">

    <link rel="stylesheet" href="{{ asset('template/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}" type="text/css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/assets/css/formatacao.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/lightbox/lightbox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/jAudio.js-master/resources/css/main.min.css') }}">
    <style type="text/css">
        .jAudio {
            width: 100% !important;
            min-width: 800px;
        }
    </style>
</head>
<body class="bg-white">
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 navtop bg-gray">
            <div class="row">
                <div class="col-md-2 logo">
                    <a title="Voltar" href="#">
                        <img src="{{ asset('template/assets/img/brand/logo-service.png') }}" style="padding: 0 4px;" class="logo" width="100" height="50" alt="" />
                    </a>
                </div>
                <div class="col-md-3 text text-white">SISTEMA DE GERENCIAMENTO DE CLIPPINGS</div>

                <div class="col-md-3 offset-1 client">
                    <img src="{{ $clipping->client->getLogo() }}" width="50" height="50">
                    <p><a title="alterar senha" href="#">{{ $clipping->client->name }}</a>
                        <br>Última visualização: {{ $clipping_data['last_read'] }}</p>
                </div>

                <div class="col-md-3 links">
                    <a title="home" href="{{ route('home') }}"><i class="fas fa-home"></i></a>
                    <a title="sair" href="{{ route('home') }}"><i class="fas fa-sign-out-alt"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="topo-faixa">
                    <div class="topo-titulo-clipping">
                        <h1>{{ $clipping->title }}</h1>
                        <h2>{{ $clipping->subject_matter }}</h2>
                    </div>
                    <div class="topo_detalhe_clipping">
                        <span><strong>Publicação</strong>: {{ $clipping->date }}<br /></span>
                        <span><strong>Meio:</strong> {{ $clipping->middle->name ?? '' }}<br /></span>
                        <span><strong>Veículo</strong>: {{ $clipping->vehicle->name ?? '' }}<br /></span>
                        <span><strong>Editorial / Programa</strong>: {{ $clipping->editorial->title ?? '' }}<br /></span>
                        <span><strong>Classificação</strong>: {{ $clipping->classification->name ?? '' }}<br /></span>
                        <span><strong>Exibição</strong>: {{ $clipping->exhibition->name ?? '' }}<br /></span>
                        <span><strong>Fonte</strong>: {{ $clipping->source->name ?? '' }}<br /></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 bg-white pb-3 pt-3">
            <div class="row">
                <ul class="nav nav-tabs detalhe-texto-imagem mb-3">
                    @if (isset($clipping_data['images']) && count($clipping_data['images']))
                    <li><a class="detalhe-texto-imagem-imagem" href="#images" data-toggle="tab"><b><i class="far fa-image"></i></b>Imagens</a></li>
                    @endif
                    @if(isset($clipping_data['videos']) && count($clipping_data['videos']))
                    <li><a class="detalhe-texto-imagem-imagem" href="#videos" data-toggle="tab"><b><i class="fas fa-video"></i></b>Vídeos</a></li>
                    @endif
                    @if (isset($clipping_data['audios']) && count($clipping_data['audios']))
                    <li><a class="detalhe-texto-imagem-imagem" href="#audios" data-toggle="tab"><b><i class="fas fa-file-audio"></i></b>Áudios</a></li>
                    @endif
                    @if (isset($clipping_data['docs']) && count($clipping_data['docs']))
                        <li><a class="detalhe-texto-imagem-imagem" href="#docs" data-toggle="tab"><b><i class="fas fa-file-pdf"></i></b>Documentos</a></li>
                    @endif
                    @if(!empty($clipping->review))
                    <li><a class="detalhe-texto-imagem-texto active" href="#review" data-toggle="tab"><b><i class="far fa-file-alt"></i></b>Resenha</a></li>
                    @endif
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="review">
                        <div class="row">
                            <div class="col-md-12">{!! $clipping->review ?? '' !!}</div>
                        </div>
                    </div>
                    <div class="tab-pane" id="images">
                        <div class="row justify-content-center">
                            @foreach($clipping_data['images'] as $image)
                            <div class="col-md-3">
                                <a href="{{ Storage::disk('spaces')->url($image->path) }}" data-toggle="lightbox" data-gallery="gallery">
                                    <img src="{{ Storage::disk('spaces')->url($image->path) }}" class="img-fluid">
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-pane" id="videos">
                        <div class="row">
                            @foreach($clipping_data['videos'] as $video)
                            <div class="col-md-4">
                                <video controls style="width: 100%;">
                                    <source src="{{ Storage::disk('spaces')->url($video->path) }}" type="video/{{ $video->extension }}">
                                </video>
                                {{ $video->name }}
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-pane" id="audios">
                        <div class="row">
                            @foreach($clipping_data['audios'] as $audio)
                            <div class="col-md-4">
                                <audio src="{{ Storage::disk('spaces')->url($audio->path) }}" controls></audio><br>
                                {{ $audio->name }}
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-pane" id="docs">
                        <div class="row">
                            @foreach($clipping_data['docs'] as $doc)
                                <div class="col-md-12">
                                    <i class="fa fa-2x fa-file-alt"></i>  -  {{ $doc->name }} - <a class="btn btn-success btn-sm" href="{{ Storage::disk('spaces')->url($doc->path) }}">Download</a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 rodape">
            <div class="row">
                <div class="col-md-6 logo">
                    <img src="{{ asset('template/assets/img/brand/logo-service.png') }}" width="85" height="40" alt="" />
                </div>
                <div class="col-md-6 text-right">
                    <p>Tel:(99)3523.2612
                        <br> <a href="mailto:clipping@canalgrupo.com.br">clipping@canalgrupo.com.br</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('template/assets/vendor/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('template/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/plugins/lightbox/lightbox.min.js') }}"></script>

<script src="{{ asset('assets/plugins/jAudio.js-master/resources/js/jaudio.min.js') }}"></script>
{{--<script src="{{ asset('assets/plugins/jAudio.js-master/resources/js/main.js') }}"></script>--}}
<script>
    $(document).ready(function(){
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });
    });
</script>
</body>
</html>
