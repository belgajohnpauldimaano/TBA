@extends('frontend.layouts.main')

@section('container')
    <main class="dvd-page">
        @include('frontend.layouts.film_categ')

        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="dvd text-center">
                        <a href="#" class="dvd__block">
                            <img src="{{ asset('frontend/assets/img/on-dvd/1.png') }}" class="img-responsive center-block">
                        </a>
                        <div class="dvd__title">
                            <h3 class="text-uppercase">K'na the dreamweaver</h3>
                            <span class="clearfix">&nbsp;</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="dvd text-center">
                        <a href="#" class="dvd__block">
                            <img src="{{ asset('frontend/assets/img/on-dvd/2.png') }}" class="img-responsive center-block">
                        </a>
                        <div class="dvd__title">
                            <h3 class="text-uppercase">Bonifacio, ang unang pangulo</h3>
                            <span class="clearfix">(The First President)</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="dvd text-center">
                        <a href="#" class="dvd__block">
                            <img src="{{ asset('frontend/assets/img/on-dvd/3.png') }}" class="img-responsive center-block">
                        </a>
                        <div class="dvd__title">
                            <h3 class="text-uppercase">Heneral Luna</h3>
                            <span class="clearfix">(General Luna)</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="dvd text-center">
                        <a href="#" class="dvd__block">
                            <img src="{{ asset('frontend/assets/img/on-dvd/4.png') }}" class="img-responsive center-block">
                        </a>
                        <div class="dvd__title">
                            <h3 class="text-uppercase">Heneral Luna Special Edition</h3>
                            <span class="clearfix">(General Luna)</span>
                        </div>
                    </div>
                </div>
            </div>
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
                                <span class="clearfix">(General Luna)</span>

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
                url = $(this).attr('href');
                title = $(this).attr('title');
                e.preventDefault();
            });
        });
    </script>
@endsection