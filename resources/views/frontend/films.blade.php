@extends('frontend.layouts.main')

@section('container')
        
    <main class="m-b-6">
        @include('frontend.layouts.film_categ')
        <section>
            <div class="header-title">
                <h2 class="header-title__tag"><span class="text-calibri">2016 - 2017</span> Film Line Up</h2>
            </div>
            <div class="container">
            
                <div class="row">
                    @if($Film)
                        @foreach ($Film as $film)
                                 <div class="col-md-3 col-xs-6">
                                    <div class="film">
                                        <a href="#" class="film__link">
                                          <img src="{{ asset('frontend/assets/img/films/line-up/f1.jpg') }}" alt="" class="w-100">
                                        </a>
                                        <h3 class="film__title text-center">
                                            <span>{{ $film->title }}</span>
                                        </h3>
                                    </div>
                                </div>
                        @endforeach
                    @endif
                </div>

                <div class="row">
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
                    <div class="col-md-3 col-xs-6">
                        <div class="film">
                            <a href="#" class="film__link">
                              <img src="{{ asset('frontend/assets/img/films/line-up/f9.jpg') }}" alt="" class="w-100">
                            </a>
                            <div class="film__title text-center">
                                <span>1-2-3</span>
                                <p>(Lorem ipsum dolor)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <section>
            <div class="header-title">
                <h2 class="header-title__tag">Coming Soon</h2>
            </div>
            <div class="container">
                <div class="row">
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
                </div>
            </div>
        </section>

        <section>
            <div class="header-title">
                <h2 class="header-title__tag">Film Catalogue</h2>
            </div>
            <div class="container">
                <div class="row">
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
                </div>
            </div>
        </section>
    </main>
@endsection