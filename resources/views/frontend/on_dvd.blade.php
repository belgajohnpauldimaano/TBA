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
                                    <pre>{{ json_encode($data->name, JSON_PRETTY_PRINT)}}</pre>
                                    <div class="dvd text-center">
                                        <a href="{{ asset('content/film/dvds/' . $data->dvd_case_cover) }}" 
                                            circle="{{ asset('content/film/dvds/' . $data->dvd_disc_image) }}" 
                                            title="{{ $data->name }}"
                                            list="{{ $data->languages }}" class="dvd__block">
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
                        <div class="col-md-7">
                            <div class="dvd__cd__container clearfix">
                                <div class="dvd__cd pull-right">
                                    <div class="va-block">
                                        <div class="va-bottom">
                                            <img src="{{ asset('frontend/assets/img/on-dvd/pop_up_circle.png') }}" class="dvd__cd__img dvd__cd__img--circle">
                                        </div>
                                    </div>
                                </div>
                                <div class="dvd__cd pull-right">
                                    <img src="{{ asset('frontend/assets/img/on-dvd/pop_up.png') }}" class="dvd__cd__img dvd__cd__img--normal">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="dvd_content">
                                <h3>Heneral Luna DVD</h3>
                                {{-- <span class="clearfix">(General Luna)</span> --}}

                                <ul class="list-inline m-t-6">
                                    <li><strong class="text-uppercase">Languages:</strong></li>
                                    <li class="p-r-0">Tagalog</li>
                                    <li class="p-r-0">English</li>
                                    <li class="p-r-0">Spanish</li>
                                </ul>
                                <ul class="list-inline">
                                    <li class="p-r-0"><strong class="text-uppercase">Subtitles:</strong></li>
                                    <li class="p-r-0">Tagalog</li>
                                    <li class="p-r-0">English</li>
                                    <li class="p-r-0">Spanish</li>
                                </ul>
                                <ul class="list-inline">
                                    <li class="p-r-0"><strong class="text-uppercase">TRT:</strong></li>
                                    <li class="p-r-0">118 minutes</li>
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

                $('.dvd__cd__img--normal').attr('src', img);
                $('.dvd__cd__img--circle').attr('src', imgCircle);
                $('#modalDvd h3').text(title);

                e.preventDefault();
            });
        });
    </script>
@endsection