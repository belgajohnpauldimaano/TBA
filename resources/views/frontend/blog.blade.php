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
                                <a href="blog/{{$data->id}}" class="card__blog__link card__blog__link--black"></a>
                                <div class="va-block p-a-3">
                                    <div class="va-middle text-center">
                                        <div class="blog-cover__content">
                                            <h3 class="m-y-0"><a href="blog/{{$data->id}}" class="p-y-2">{{ str_limit($data->title, $limit = 60, $end = '...') }}</a></h3>
                                            <span class="h4"><a href="blog/{{$data->id}}">{{ date('F d, Y', strtotime($data->created_at)) }}</a></span>
                                        </div>
                                    </div>
                                </div>
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
                                    <a href="blog/{{$data->id}}" class="card__blog__link"></a>
                                    <div class="va-block p-a-3">
                                        <div class="va-bottom">
                                            <div class="blog-cover__content">
                                                <h4 class="m-y-0"><a href="blog/{{$data->id}}" class="p-y-2">{{ str_limit($data->title, $limit = 60, $end = '...') }}</a></h4>
                                                <span><a href="blog/{{$data->id}}">{{ date('F d, Y', strtotime($data->created_at)) }}</a></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>
            {{-- <pre>{{ json_encode($Blog, JSON_PRETTY_PRINT)}}</pre> --}}
        </div>
    </main>
    <hr class="m-y-6 invisible">
@endsection