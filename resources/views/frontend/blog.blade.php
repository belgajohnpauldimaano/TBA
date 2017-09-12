@extends('frontend.layouts.main')

@section('page_title')
<title>Announcements - TBA Studios, Tuko Film Productions, Buchi Boy Entertainment, Artikulo Uno, Cinema 76, Cinetropa</title>
@endsection

@section('container')
    <main>

        {{-- @foreach($Blog->where('film_id', '==', -1)->slice(0, 1) as $item)
            <pre>{{ json_encode($item, JSON_PRETTY_PRINT)}}</pre>
        @endforeach --}}

        {{-- @foreach($latest_news as $item)
            <pre>{{ json_encode($item, JSON_PRETTY_PRINT)}}</pre>
        @endforeach --}}

        {{-- <pre>{{ json_encode($latest_news->first(), JSON_PRETTY_PRINT)}}</pre> --}}
        {{-- <pre>{{ json_encode($company_news->first(), JSON_PRETTY_PRINT)}}</pre> --}}

        <div class="container-fluid m-b-6" style="margin-top: -30px">
            <div class="row">
                <div class="col-sm-6 p-x-0">
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
                </div>

                <div class="col-sm-6 p-x-0">
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
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="header-title">
                        <h2 class="header-title__tag">Latest Articles</h2>
                    </div>

                    <div class="row">
                        @if ($latest_news->count() > 0)
                            @foreach ($latest_news as $data)
                                @if (!in_array($data->id, $latest_id))
                                    <div class="col-md-4">
                                        <div class="blog-cover blog-cover--blog-thumb" style="background-image: url({{ asset('content/film/press_release/'.$data->article_image) }});">
                                            <a href="{{ route('blog_frontend') }}/{{$data->id}}" class="card__blog__link">
                                                <div class="va-block">
                                                    <div class="va-bottom">
                                                        <div class="blog-cover__content p-a-3">
                                                            <h4>{{ str_limit($data->title, $limit = 60, $end = '...') }}</h4>
                                                            <span>{{ date('F d, Y', strtotime($data->created_at)) }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="header-title">
                        <h2 class="header-title__tag">Company News</h2>
                    </div>

                    <div class="row">
                        @if ($latest_news->count() > 0)
                            @foreach ($company_news as $data)
                                @if (!in_array($data->id, $latest_id))
                                    <div class="col-md-4">
                                        <div class="blog-cover blog-cover--blog-thumb" style="background-image: url({{ asset('content/film/press_release/'.$data->article_image) }});">
                                            <a href="{{ route('blog_frontend') }}/{{$data->id}}" class="card__blog__link">
                                                <div class="va-block">
                                                    <div class="va-bottom">
                                                        <div class="blog-cover__content p-a-3">
                                                            <h4>{{ str_limit($data->title, $limit = 60, $end = '...') }}</h4>
                                                            <span>{{ date('F d, Y', strtotime($data->created_at)) }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </main>
    <hr class="m-y-6 invisible">
@endsection