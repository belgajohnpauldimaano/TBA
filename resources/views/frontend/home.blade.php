@extends('frontend.layouts.main')

@section('styles')
    <link  href="http://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">
    <style>
        .fotorama__img{
            top: 0 !important;
        }
        @media (min-width: 768px){
            .fotorama__video-play{
                margin-top: -108px;
            }
            .fotorama__wrap{
                top: 70px;
                -moz-transition: all 200ms ease-in-out;
                -o-transition: all 200ms ease-in-out;
                -webkit-transition: all 200ms ease-in-out;
                transition: all 200ms ease-in-out; 
            }
            .fotorama__wrap--video{
                top: 0 !important;
            }
            .fotorama__nav-wrap{
                position: relative;
                top: -70px;
            }
        } 
        .fotorama__html div,
        .fotorama__html a {
            display: block;
            height: 100%;
            /* Transparent links are not clickable in IE,
               but non-existent background fixes this.
              (Put an empty 1×1 image here to avoid
               errors in console.) */
            background: url(_.gif);
        }
    </style>
@endsection

@section('page_title')
    <title>TBA Studios - Bringing the Filipino audience back to the cinema - Tuko Film Productions, Buchi Boy Entertainment, Artikulo Uno, Cinema 76, Cinetropa</title>
@endsection

@section('container')
    <div class="fotorama fotorama--homepage"
        data-loop="true"
        data-fit="cover"
        data-width="100%"
        data-ratio="16/9"
        data-max-width="100%"
        data-max-height="100%" 
        data-arrows="always"
        data-nav="dots">

        @if($Carousel)
            @foreach ($Carousel as $item)
                @if($item->new_window === NULL)
                    <a href="{{ $item->url }}">
                        <img src="{{ asset('content/carousel/'.$item->image) }}">
                    </a>
                @else
                    <div data-img="{{ asset('content/carousel/'.$item->image) }}">
                        <a href="{{ $item->url }}" {{ $item->new_window == NULL ? 'target="_blank"' : '' }}></a>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
    {{-- <pre>{{ json_encode($Carousel, JSON_PRETTY_PRINT)}}</pre> --}}

@endsection

@section('scripts')
    <script src="http://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script>

    <script>
        $('.fotorama').fotorama({
            swipe: false
        });
    </script>
@endsection