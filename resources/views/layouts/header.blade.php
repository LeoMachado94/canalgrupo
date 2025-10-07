<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-7 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">{{ $header_title ?? '' }}</h6>
                    @if(isset($header_subtitle) && isset($header_subtitle_icon))
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="#"><i class="{{ $header_subtitle_icon ?? '' }}"></i></a></li>
                            <li class="breadcrumb-item"><a href="#">{{ $header_subtitle ?? '' }}</a></li>
                        </ol>
                    </nav>
                    @endif
                </div>
                <div class="col-lg-5 col-5 text-right">
                    @if(isset($btns))
                    @foreach($btns as $btn)
                        <a href="{{ $btn['link'] ?? 'link' }}" class="btn {{ $btn['class'] ?? 'btn-secondary' }} btn-icon">
                            <span class="btn-inner--icon"><i class="{{ $btn['icon'] ?? 'icon' }}"></i></span>
                            <span class="btn-inner--text">{{ $btn['text'] ?? 'text' }}</span>
                        </a>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
