@extends('frontend.layouts.main')

@section('page_title')
<title>Films by TBA, DVD Release</title>
@endsection

@section('container')
    <main class="dvd-page">
        @include('frontend.layouts.film_categ')

        {{-- <pre>{{ json_encode($dvds, JSON_PRETTY_PRINT)}}</pre> --}}

        <div class="container">
            @if ($dvds->count() > 0)
                <div class="row">
                    @foreach ($dvds as $dvd)
                        {{-- <pre>{{ json_encode($dvd->dvds, JSON_PRETTY_PRINT)}}</pre> --}}
                         @foreach ($dvd->dvds as $data)
                                <div class="col-sm-6">
                                    {{-- <pre>{{ json_encode($data, JSON_PRETTY_PRINT)}}</pre> --}}
                                    <div class="dvd text-center">
                                        <a href="{{ asset('content/film/dvds/' . $data->dvd_case_cover) }}" 
                                            circle="{{ asset('content/film/dvds/' . $data->dvd_disc_image) }}" 
                                            title="{{ $data->name }}"
                                            en-title="{{ $data->english_title }}"
                                            languages="{{ $data->languages }}"
                                            subtitles="{{ $data->subtitles }}"
                                            trt="{{ $data->running_time }}"
                                            class="dvd__block">
                                            <img src="{{ asset('content/film/dvds/' . $data->dvd_case_cover) }}" class="img-responsive center-block">
                                        </a>
                                        <div class="dvd__title">
                                            <h3 class="text-uppercase">{{ $data->name }}</h3>
                                            <span class="clearfix">&nbsp;</span>
                                        </div>
                                    </div>
                                </div>
                        @endforeach
                    @endforeach
                </div>
            @endif
        </div>
    </main>

    <div class="modal fade" tabindex="-1" role="dialog" id="modalDvd">
       <div class="modal-dialog modal-lg" role="document">
           <div class="modal-content">
               <div class="modal-header">
                    <button type="button" class="close t-ease" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-times-circle" aria-hidden="true"></i></span>
                    </button>
                    <h4 class="modal-title hidden">This title is dynamic</h4>
               </div>
               <div class="modal-body">
                    <div class="row">
                        <div class="col-md-7 p-x-6">
                            <div class="row">
                                <div class="col-xs-6 p-r-1">
                                    <img src="{{ asset('frontend/assets/img/on-dvd/pop_up.png') }}" class="dvd__cover w-100">
                                </div>
                                <div class="col-xs-6 p-l-1">
                                    <img src="{{ asset('frontend/assets/img/on-dvd/pop_up_circle.png') }}" class="dvd__cd w-100">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="dvd__content">
                                <h3 class="dvd__cover__title"></h3>
                                <span class="dvd__en__title clearfix"></span>

                                <ul class="list-inline m-t-6">
                                    <li><strong class="text-uppercase">Languages:</strong></li>
                                    <li>
                                        <span class="dvd__languages"></span>
                                    </li>
                                </ul>
                                <ul class="list-inline">
                                    <li class="p-r-0"><strong class="text-uppercase">Subtitles:</strong></li>
                                    <li>
                                        <span class="dvd__subtitles"></span>
                                    </li>
                                </ul>
                                <ul class="list-inline">
                                    <li class="p-r-0"><strong class="text-uppercase">TRT:</strong></li>
                                    <li>
                                        <div class="dvd__trt"></div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
               </div>
           </div>
       </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(function(){
            $('.dvd').on('click', '.dvd__block', function(e){

                $('#modalDvd').modal('show');
                img = $(this).attr('href');
                imgCircle = $(this).attr('circle');
                title = $(this).attr('title');
                en_title = $(this).attr('en-title');
                languages = $(this).attr('languages');
                subtitles = $(this).attr('subtitles');
                trt = $(this).attr('trt');

                $('.dvd__cover').attr('src', img);
                $('.dvd__cd').attr('src', imgCircle);
                $('.dvd__cover__title').text(title);
                $('.dvd__en__title').text(en_title);
                $('.dvd__languages').text(languages);
                $('.dvd__subtitles').text(subtitles);
                $('.dvd__trt').text(trt + ' minutes');

                e.preventDefault();
            });
        });
    </script>
@endsection