@extends('frontend.layouts.main')

@section('page_title')
<title>TBA Blog</title>
@endsection

@section('container')
    <main class="main__blog">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <img src="{{ asset('content/film/press_release/'.$Blog_info->article_image) }}" class="w-100">
                    <h1>{{ $Blog_info->title }}</h1>
                    <p class="text-muted">{{ date('F d, Y', strtotime($Blog_info->created_at)) }}</p>
                    <p>{!! $Blog_info->content !!}</p>

                    @if($Blog_info->article_source || $Blog_info->article_source != NULL)
                        <hr>
                        <p class="m-b-0">Source:</p>
                        <p><a href="{{ $Blog_info->article_source }}" target="_blank" style="font-size: 16px;"><u>{{ $Blog_info->article_source }}</u></a></p>
                    @endif
                </div>
                <div class="col-md-4">
                    @if ($Blog->count() > 0)
                        @foreach ($Blog as $data)
                            <h4><a href="{{$data->id}}" class="p-y-2 text-muted">{{ str_limit($data->title, $limit = 60, $end = '...') }}</a></h4>
                            <span class="text-muted">{{ date('F d, Y', strtotime($data->created_at)) }}</span>
                            <hr>
                        @endforeach
                    @endif
                </div>
            </div>
            {{-- <pre>{{ json_encode($Blog_info, JSON_PRETTY_PRINT)}}</pre> --}}
        </div>
    </main>
    <hr class="m-y-6 invisible">

    {{-- <div class="main__blog__foter">
        <div class="container-fluid">
            <div class="row">
                @if ($Blog->count() > 0)
                    @foreach ($Blog->slice(0, 2) as $data)
                        <div class="col-sm-6 p-x-0">
                            <div class="blog-cover blog-cover--blog m-b-0" style="background-image: url({{ asset('content/film/press_release/'.$data->article_image) }});">
                                <a href="{{$data->id}}" class="card__blog__link card__blog__link--black">
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
    </div> --}}
@endsection