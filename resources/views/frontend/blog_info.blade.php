@extends('frontend.layouts.main')

@section('page_title')
<title>{{ $Blog_info->title }}</title>
@endsection

@section('styles')
    <style>
        h1{
            text-transform: none !important;
        }
    </style>
@endsection

@section('container')
    <main class="main__blog">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <img src="{{ asset('content/film/press_release/'.$Blog_info->article_image) }}" class="w-100">
                    <h1 class="m-t-5">{{ $Blog_info->title }}</h1>
                    <p class="text-muted"><small>{{ date('F d, Y', strtotime($Blog_info->created_at)) }}</small></p>
                    <hr class="thin-line">
                    <p>{!! $Blog_info->content !!}</p>

                    @if($Blog_info->article_source || $Blog_info->article_source != NULL)
                        <hr>
                        <p class="m-b-0">Source:</p>
                        <p><a href="{{ $Blog_info->article_source }}" target="_blank" style="font-size: 16px;"><u>{{ $Blog_info->article_source }}</u></a></p>
                    @endif
                </div>
                <div class="col-md-4">
                    <div class="main__blog__sidebar">
                        @if ($Blog->count() > 0)
                            @foreach ($Blog as $data)
                                <hr class="{{ $loop->first ? 'hidden' : '' }}">
                                <h4 class="m-y-0"><a href="{{$data->id}}" class="p-y-2">{{ str_limit($data->title, $limit = 60, $end = '...') }}</a></h4>
                                <span class="text-muted center-block m-y-1">{{ date('F d, Y', strtotime($data->created_at)) }}</span>
                                <p class="m-b-1"><small>{!! str_limit(html_entity_decode(strip_tags($Blog_info->content)), 80) !!}</small></p>
                                <a href="{{$data->id}}"><u>Read More</u></a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
    <hr class="m-y-6 invisible">
@endsection