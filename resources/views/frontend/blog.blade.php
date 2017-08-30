@extends('frontend.layouts.main')

@section('page_title')
<title>TBA Blog</title>
@endsection

@section('container')
    <main>
        <div class="container-fluid m-b-6" style="margin-top: -30px">
            <div class="row">
                @if ($Blog->count() > 0)
                    @foreach ($Blog->slice(0, 2) as $data)
                        <div class="col-sm-6 p-x-0">
                            <div class="blog-cover blog-cover--blog m-b-0" style="background-image: url({{ asset('content/film/press_release/'.$data->article_image) }});">
                                <a href="{{ route('blog_frontend') }}/{{$data->id}}" class="card__blog__link card__blog__link--black">
                                    <div class="va-block">
                                        <div class="va-middle">
                                            <div class="blog-cover__content p-a-3 text-center">
                                                <h3>{{ str_limit($data->title, $limit = 60, $end = '...') }}</h3>
                                                <span>{{ date('F d, Y', strtotime($data->created_at)) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="container">
            <div class="header-title">
                <h2 class="header-title__tag">{{-- <span class="text-calibri">2016 - 2017</span>  --}}Latest Articles</h2>
            </div>

            <div class="row">
                @if ($Blog->count() > 0)
                    @foreach ($Blog as $data)
                        @if (!in_array($data->id, $latest_id))
                            <div class="col-md-4">
                                <div class="blog-cover blog-cover--blog" style="background-image: url({{ asset('content/film/press_release/'.$data->article_image) }});">
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

            {{-- @if ($Blog->count() > 0)
                <div class="row">
                    <div class="col-md-12">
                        @foreach ($Blog as $data)
                            @if (!in_array($data->id, $latest_id))
                                <div class="media">
                                    <div class="media-left p-r-4">
                                        <a href="{{ route('blog_frontend') }}/{{$data->id}}">
                                            <div class="blog-cover blog-cover--blog m-b-0" style="background-image: url({{ asset('content/film/press_release/'.$data->article_image) }}); height: 200px; width: 200px;"></div>
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <h3 class="media-heading m-t-1">{{ str_limit($data->title, $limit = 60, $end = '...') }}</h3>
                                        <p>{{ date('F d, Y', strtotime($data->created_at)) }}</p>
                                        <p>{!! str_limit($data->content, $limit = 350, $end = '...') !!}</p>
                                        <a href="{{ route('blog_frontend') }}/{{$data->id}}" class="btn btn-default p-x-6">Read more</a>
                                    </div>
                                </div>
                                <hr>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif --}}
            
            {{-- <pre>{{ json_encode($Blog, JSON_PRETTY_PRINT)}}</pre> --}}
        </div>
    </main>
    <hr class="m-y-6 invisible">
@endsection