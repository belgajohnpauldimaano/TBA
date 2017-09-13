@extends('frontend.layouts.main')

@section('page_title')
<title>{{Request::segment(2) == 'latest_articles' ? 'Latest Articles' : 'Company News'}}</title>
@endsection

@section('container')
    <main class="blog-page">

        <div class="container">
            @if ($blog_all->count() > 1)
                <div class="header-title">
                    <h2 class="header-title__tag">{{Request::segment(2) == 'latest_articles' ? 'Latest Articles' : 'Company News'}}</h2>
                </div>

                <div class="row row-gap">
                    @foreach ($blog_all as $data)
                        @if ($blog_all->first()->id != $data->id)
                            <div class="col-xs-6 col-md-3 col-gap">
                                <div class="blog-cover blog-cover--blog-thumb lazy" data-original="{{ asset('content/film/press_release/'.$data->article_image) }}">
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
            @endif
        </div>
    </main>
    <hr class="m-y-6 invisible">
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.min.js"></script>

    <script>
        $("img.lazy").lazyload();
        $("div.lazy").lazyload();
    </script>
@endsection