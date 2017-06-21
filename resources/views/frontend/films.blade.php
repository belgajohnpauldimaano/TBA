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
                                 <div class="col-md-3 col-xs-6">
                                    <div class="film">
                                        <a href="film/{{ $film->id }}" class="film__link">
                                            @if($film->photos->count() > 0)
                                                <img src="{{ asset('content/film/photos/' . $film->photos[0]->thumb_filename) }}" alt="" class="w-100">
                                            @else
                                                <img src="{{ asset('content/film/photos/thumbnail.jpg') }}" alt="" class="w-100">
                                                <div class="film__no__thumb">
                                                    <div class="va-block">
                                                        <div class="va-middle">
                                                            <div class="film__title film__title--height text-center">
                                                                <span>{{ $film->title }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </a>
                                        @if($film->photos->count() > 0)
                                            <h3 class="film__title text-center">
                                                <span>{{ $film->title }}</span>
                                            </h3>
                                        @else
                                            <div class="film__title"></div>
                                        @endif
                                    </div>
                                </div>
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
                                 <div class="col-md-3 col-xs-6">
                                    <div class="film">
                                        <a href="film/{{ $film->id }}" class="film__link">
                                            @if($film->photos->count() > 0)
                                                <img src="{{ asset('content/film/photos/' . $film->photos[0]->thumb_filename) }}" alt="" class="w-100">
                                            @else
                                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT48j3XJHxZa9S_Fp9BUg3k2krK8u16W6nlNQFgrirWWMEw26lUaA" alt="" class="w-100">
                                            @endif
                                        </a>
                                        <h3 class="film__title text-center">
                                            <span>{{ $film->title }}</span>
                                        </h3>
                                    </div>
                                </div>
                        @endforeach
                    @endif
                </div>
                {{-- <div class="row">
                    <div class="col-md-3 col-xs-6">
                        <div class="film">
                            <a href="#" class="film__link">
                              <img src="{{ asset('frontend/assets/img/films/line-up/f1.jpg') }}" alt="" class="w-100">
                            </a>
                            <div class="film__title text-center">
                                <span>1-2-3</span>
                                <p>(Lorem ipsum dolor)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="film">
                            <a href="#" class="film__link">
                              <img src="{{ asset('frontend/assets/img/films/line-up/f2.jpg') }}" alt="" class="w-100">
                            </a>
                            <div class="film__title text-center">
                                <span>1-2-3</span>
                                <p>(Lorem ipsum dolor)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="film">
                            <a href="#" class="film__link">
                              <img src="{{ asset('frontend/assets/img/films/line-up/f3.jpg') }}" alt="" class="w-100">
                            </a>
                            <div class="film__title text-center">
                                <span>1-2-3</span>
                                <p>(Lorem ipsum dolor)</p>
                            </div>
                        </div>
                    </div>
                </div> --}}
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
                                 <div class="col-md-3 col-xs-6">
                                    <div class="film">
                                        <a href="film/{{ $film->id }}" class="film__link">
                                            @if($film->photos->count() > 0)
                                                <img src="{{ asset('content/film/photos/' . $film->photos[0]->thumb_filename) }}" alt="" class="w-100">
                                            @else
                                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT48j3XJHxZa9S_Fp9BUg3k2krK8u16W6nlNQFgrirWWMEw26lUaA" alt="" class="w-100">
                                            @endif
                                        </a>
                                        <h3 class="film__title text-center">
                                            <span>{{ $film->title }}</span>
                                        </h3>
                                    </div>
                                </div>
                        @endforeach
                    @endif
                </div>
                
                {{-- <div class="row">
                    <div class="col-md-3 col-xs-6">
                        <div class="film">
                            <a href="#" class="film__link">
                              <img src="{{ asset('frontend/assets/img/films/line-up/f1.jpg') }}" alt="" class="w-100">
                            </a>
                            <div class="film__title text-center">
                                <span>1-2-3</span>
                                <p>(Lorem ipsum dolor)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="film">
                            <a href="#" class="film__link">
                              <img src="{{ asset('frontend/assets/img/films/line-up/f2.jpg') }}" alt="" class="w-100">
                            </a>
                            <div class="film__title text-center">
                                <span>1-2-3</span>
                                <p>(Lorem ipsum dolor)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="film">
                            <a href="#" class="film__link">
                              <img src="{{ asset('frontend/assets/img/films/line-up/f3.jpg') }}" alt="" class="w-100">
                            </a>
                            <div class="film__title text-center">
                                <span>1-2-3</span>
                                <p>(Lorem ipsum dolor)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="film">
                            <a href="#" class="film__link">
                              <img src="{{ asset('frontend/assets/img/films/line-up/f4.jpg') }}" alt="" class="w-100">
                            </a>
                            <div class="film__title text-center">
                                <span>1-2-3</span>
                                <p>(Lorem ipsum dolor)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="film">
                            <a href="#" class="film__link">
                              <img src="{{ asset('frontend/assets/img/films/line-up/f5.jpg') }}" alt="" class="w-100">
                            </a>
                            <div class="film__title text-center">
                                <span>1-2-3</span>
                                <p>(Lorem ipsum dolor)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="film">
                            <a href="#" class="film__link">
                              <img src="{{ asset('frontend/assets/img/films/line-up/f6.jpg') }}" alt="" class="w-100">
                            </a>
                            <div class="film__title text-center">
                                <span>1-2-3</span>
                                <p>(Lorem ipsum dolor)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="film">
                            <a href="#" class="film__link">
                              <img src="{{ asset('frontend/assets/img/films/line-up/f7.jpg') }}" alt="" class="w-100">
                            </a>
                            <div class="film__title text-center">
                                <span>1-2-3</span>
                                <p>(Lorem ipsum dolor)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="film">
                            <a href="#" class="film__link">
                              <img src="{{ asset('frontend/assets/img/films/line-up/f8.jpg') }}" alt="" class="w-100">
                            </a>
                            <div class="film__title text-center">
                                <span>1-2-3</span>
                                <p>(Lorem ipsum dolor)</p>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </section>
    </main>
@endsection