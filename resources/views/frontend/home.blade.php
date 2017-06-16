@extends('frontend.layouts.main')

@section('container')
    <div class="hero">
        <div class="hero__owl owl-carousel">
            @if($Carousel)
                @foreach ($Carousel as $Carousel)
                    <a href="#" class="hero__owl__slide" style="background-image: url({{ asset('content/carousel/'.$Carousel->image) }});">
                        <img src="{{ asset('content/carousel/'.$Carousel->image) }}" class="w-100">
                    </a>
                @endforeach
            @endif
        </div>
    </div>
@endsection