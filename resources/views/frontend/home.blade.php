@extends('frontend.layouts.main')

@section('styles')
    <link  href="http://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">
@endsection

@section('page_title')
<title>TBA - Bringing the filipino audience back to the cinema</title>
@endsection

@section('container')

    <div class="fotorama fotorama--homepage"
        data-fit="cover"
        data-width="100%"
        data-ratio="16/9"
        data-max-width="100%"
        data-max-height="100%" 
        data-arrows="always"
        data-nav="dots">
        @if($Carousel)
            @foreach ($Carousel as $Carousel)
                @if($Carousel)
                    <a href="{{ $Carousel->url }}">
                        <img src="{{ asset('content/carousel/'.$Carousel->image) }}">
                    </a>
                @endif
            @endforeach
        @endif
    </div>
@endsection

@section('scripts')
    <script src="http://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script>
@endsection