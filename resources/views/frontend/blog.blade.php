@extends('frontend.layouts.main')

@section('page_title')
<title>Announcements - TBA Studios, Tuko Film Productions, Buchi Boy Entertainment, Artikulo Uno, Cinema 76, Cinetropa</title>
@endsection

@section('container')
    <main class="blog-page">

        <div class="container-fluid m-b-6" style="margin-top: -30px">
            <div class="row">
                <div class="col-sm-6 p-x-0">
                    @if($latest_news->count() > 0)
                        <div class="blog-cover blog-cover--blog m-b-0" style="background-image: url({{ asset('content/film/press_release/'.$latest_news->first()->article_image) }});">
                            <a href="{{ route('blog_frontend') }}/{{$latest_news->first()->id}}" class="card__blog__link card__blog__link--black">
                                <div class="va-block">
                                    <div class="va-middle">
                                        <div class="blog-cover__content p-a-3 text-center">
                                            <h3>{{ str_limit($latest_news->first()->title, $limit = 60, $end = '...') }}</h3>
                                            <span>{{ date('F d, Y', strtotime($latest_news->first()->created_at)) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                </div>

                <div class="col-sm-6 p-x-0">
                    @if($company_news->count() > 0)
                        <div class="blog-cover blog-cover--blog m-b-0" style="background-image: url({{ asset('content/film/press_release/'.$company_news->first()->article_image) }});">
                            <a href="{{ route('blog_frontend') }}/{{$company_news->first()->id}}" class="card__blog__link card__blog__link--black">
                                <div class="va-block">
                                    <div class="va-middle">
                                        <div class="blog-cover__content p-a-3 text-center">
                                            <h3>{{ str_limit($company_news->first()->title, $limit = 60, $end = '...') }}</h3>
                                            <span>{{ date('F d, Y', strtotime($company_news->first()->created_at)) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    @if ($latest_news->count() > 1)
                        <div class="header-title">
                            <h2 class="header-title__tag">Latest Articles</h2>
                        </div>

                        <div class="col-latest-news">
                            <div class="row row-gap">
                                @foreach ($latest_news as $data)
                                    @if ($latest_news->first()->id != $data->id)
                                        <div class="col-xs-6 col-md-4 col-lg-4 col-xs-6 col-xss-12 col-gap">
                                            <div class="blog-cover blog-cover--blog-thumb" style="background-image: url({{ asset('content/film/press_release/'.$data->article_image) }});">
                                                <a href="{{ route('blog_frontend') }}/{{$data->id}}" class="card__blog__link">
                                                    <div class="va-block">
                                                        <div class="va-bottom">
                                                            <div class="blog-cover__content p-a-3">
                                                                <h5><strong>{{ str_limit($data->title, $limit = 60, $end = '...') }}</strong></h5>
                                                                <span>{{ date('F d, Y', strtotime($data->created_at)) }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                            @if($load_more->where('film_id', 0)->count() > 4)
                                <a href="http://tba.app/announcement" class="btn btn-default btn-default-black center-block text-uppercase m-t-4">View All</a>
                            @endif
                        </div>
                    @endif
                </div>
                <div class="col-lg-6">
                    @if ($company_news->count() > 1)
                        <div class="header-title">
                            <h2 class="header-title__tag">Company News</h2>
                        </div>

                        <div class="col-company-news">
                            <div class="row row-gap">
                                @foreach ($company_news as $data)
                                    @if ($company_news->first()->id != $data->id)
                                        <div class="col-xs-6 col-md-4 col-lg-4 col-xs-6 col-xss-12 col-gap">
                                            <div class="blog-cover blog-cover--blog-thumb" style="background-image: url({{ asset('content/film/press_release/'.$data->article_image) }});">
                                                <a href="{{ route('blog_frontend') }}/{{$data->id}}" class="card__blog__link">
                                                    <div class="va-block">
                                                        <div class="va-bottom">
                                                            <div class="blog-cover__content p-a-3">
                                                                <h5><strong>{{ str_limit($data->title, $limit = 60, $end = '...') }}</strong></h5>
                                                                <span>{{ date('F d, Y', strtotime($data->created_at)) }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            @if($load_more->where('film_id', -1)->count() > 4)
                                <a href="http://tba.app/announcement" class="btn btn-default btn-default-black center-block text-uppercase m-t-4">View All</a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </main>
    <hr class="m-y-6 invisible">
@endsection