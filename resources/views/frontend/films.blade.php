@extends('frontend.layouts.main')

@section('page_title')
<title>Film Line-Up by TBA</title>
@endsection

@section('container')
        
    <main class="m-b-6">
        @include('frontend.layouts.film_categ')
        <section>
            <div class="header-title">
                <h2 class="header-title__tag"><span class="text-calibri">{{ date("Y") - 1 }} - {{ date("Y") }}</span> Film Line Up</h2>
            </div>
            <div class="container">
            
                <div class="row">
                    @if($Film)
                        @foreach ($Film->where('release_status', 1) as $film)
                                @if($film->photos->count() > 0)
                                    <div class="col-md-3 col-xs-6">
                                        <div class="film">
                                            <a href="film/{{ $film->id }}" class="film__link">
                                                <img src="{{ asset('content/film/photos/' . $film->photos[0]->thumb_filename) }}" alt="{{ $film->title }}" class="w-100">
                                            </a>
                                            <h3 class="film__title text-center">
                                                <span>{{ $film->title }}</span>
                                            </h3>
                                        </div>
                                    </div>
                                @endif
                        @endforeach
                        @foreach ($Film->where('release_status', 1) as $film)
                                @if($film->photos->count() == 0)
                                    <div class="col-md-3 col-xs-6">
                                        <div class="film">
                                            <a href="film/{{ $film->id }}" class="film__link">
                                                <img src="{{ asset('content/film/photos/thumbnail.jpg') }}" alt="{{ $film->title }}" class="w-100">
                                                <div class="film__no__thumb">
                                                    <div class="va-block">
                                                        <div class="va-middle">
                                                            <div class="film__title film__title--height text-center">
                                                                <span>{{ $film->title }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="film__title"></div>
                                        </div>
                                    </div>
                                @endif
                        @endforeach
                    @endif
                </div>

            </div>
        </section>
        
        <section>
            <div class="header-title">
                <h2 class="header-title__tag">Coming Soon</h2>
            </div>
            <div class="container">
                <div class="row">
                    @if($Film)
                        @foreach ($Film->where('release_status', 2) as $film)
                                @if($film->photos->count() > 0)
                                    <div class="col-md-3 col-xs-6">
                                        <div class="film">
                                            <a href="film/{{ $film->id }}" class="film__link">
                                                <img src="{{ asset('content/film/photos/' . $film->photos[0]->thumb_filename) }}" alt="{{ $film->title }}" class="w-100">
                                            </a>
                                            <h3 class="film__title text-center">
                                                <span>{{ $film->title }}</span>
                                            </h3>
                                        </div>
                                    </div>
                                @endif
                        @endforeach
                        @foreach ($Film->where('release_status', 2) as $film)
                                @if($film->photos->count() == 0)
                                    <div class="col-md-3 col-xs-6">
                                        <div class="film">
                                            <a href="film/{{ $film->id }}" class="film__link">
                                                <img src="{{ asset('content/film/photos/thumbnail.jpg') }}" alt="{{ $film->title }}" class="w-100">
                                                <div class="film__no__thumb">
                                                    <div class="va-block">
                                                        <div class="va-middle">
                                                            <div class="film__title film__title--height text-center">
                                                                <span>{{ $film->title }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="film__title"></div>
                                        </div>
                                    </div>
                                @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </section>

        <section>
            <div class="header-title">
                <h2 class="header-title__tag">Film Catalogue</h2>
            </div>
            <div class="container">
                <div class="row">
                    @if($Film)
                        @foreach ($Film->where('release_status', 3) as $film)
                                @if($film->photos->count() > 0)
                                    <div class="col-md-3 col-xs-6">
                                        <div class="film">
                                            <a href="film/{{ $film->id }}" class="film__link">
                                                <img src="{{ asset('content/film/photos/' . $film->photos[0]->thumb_filename) }}" alt="{{ $film->title }}" class="w-100">
                                            </a>
                                            <h3 class="film__title text-center">
                                                <span>{{ $film->title }}</span>
                                            </h3>
                                        </div>
                                    </div>
                                @endif
                        @endforeach
                        @foreach ($Film->where('release_status', 3) as $film)
                                @if($film->photos->count() == 0)
                                    <div class="col-md-3 col-xs-6">
                                        <div class="film">
                                            <a href="film/{{ $film->id }}" class="film__link">
                                                <img src="{{ asset('content/film/photos/thumbnail.jpg') }}" alt="{{ $film->title }}" class="w-100">
                                                <div class="film__no__thumb">
                                                    <div class="va-block">
                                                        <div class="va-middle">
                                                            <div class="film__title film__title--height text-center">
                                                                <span>{{ $film->title }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="film__title"></div>
                                        </div>
                                    </div>
                                @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </section>
    </main>
@endsection