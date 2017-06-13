@extends('frontend.layouts.main')

@section('container')
    <div class="hero">
        <div class="hero__owl owl-carousel">
            <a href="film-info.html" class="hero__owl__slide" style="background-image: url({{ asset('frontend/assets/img/hero/1.jpg') }});">
                <img src="{{ asset('frontend/assets/img/hero/1.jpg') }}" class="w-100">
            </a>
            <a href="film-info.html" class="hero__owl__slide" style="background-image: url({{ asset('frontend/assets/img/hero/2.jpg') }});">
                <img src="{{ asset('frontend/assets/img/hero/2.jpg') }}" class="w-100">
            </a>
            <a href="film-info.html" class="hero__owl__slide" style="background-image: url({{ asset('frontend/assets/img/hero/3.jpg') }});">
                <img src="{{ asset('frontend/assets/img/hero/3.jpg') }}" class="w-100">
            </a>
            <a href="film-info.html" class="hero__owl__slide" style="background-image: url({{ asset('frontend/assets/img/hero/4.jpg') }});">
                <img src="{{ asset('frontend/assets/img/hero/4.jpg') }}" class="w-100">
            </a>
            <a href="film-info.html" class="hero__owl__slide" style="background-image: url({{ asset('frontend/assets/img/hero/5.jpg') }});">
                <img src="{{ asset('frontend/assets/img/hero/5.jpg') }}" class="w-100">
            </a>
        </div>
    </div>
@endsection