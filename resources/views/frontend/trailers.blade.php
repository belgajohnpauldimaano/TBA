@extends('frontend.layouts.main')

@section('page_title')
<title>Film Trailers by TBA</title>
@endsection

@section('styles')
	
	<style>
		@media (min-width: 992px){
			.modal-lg {
			    width: 1200px;
			}
		}
		.film-categ{
    		padding-bottom: 55px;
		}
	</style>
@endsection

@section('container')
	<main class="trailers-page">
		@include('frontend.layouts.film_categ')

		{{-- <pre>{{ json_encode($film_trailer, JSON_PRETTY_PRINT)}}</pre>
		<pre>{{ json_encode($film_trailer[0]->title, JSON_PRETTY_PRINT)}}</pre> --}}

		<section>
            <div class="container">
                @if ($film_trailer->count() > 0)
		            {{-- <div class="header-title">
		                <h2 class="header-title__tag"><span class="text-calibri">{{ date("Y") - 1 }} - {{ date("Y") }}</span> Film Line Up</h2>
		            </div>
	            	<div class="row">
	                    @foreach ($film_trailer->where('release_status', 1) as $trailer)
	                    	@foreach ($trailer->trailers->where('trailer_show', 1) as $show)
	                    		<div class="col-sm-6">
					            	<div class="trailer">
						            	<a href="{{ $show->trailer_url }}" caption="{{ $trailer->title }}" class="trailer__block">
		                                    <img src="{{ asset('content/film/trailers/' . $show->image_preview) }}" class="w-100 t-ease">
		                                    <div class="trailer__block__play">
		                                          <div class="va-block">
		                                              <div class="va-middle">
		                                                  <div class="play-icon"></div>
		                                              </div>
		                                          </div>
		                                    </div>
						            	</a>
					            	</div>
				            	</div>
	                    	@endforeach
	                    @endforeach
	            	</div> --}}
	            	<div class="row">
            			@foreach($film_trailer as $data)
	                    	@if ($data->trailers['trailer_show'] == 2)
            					{{-- <pre>{{ json_encode($data->trailers, JSON_PRETTY_PRINT)}}</pre> --}}
	                    		<div class="col-sm-6">
					            	<div class="trailer">
						            	<a href="{{ $data->trailers->trailer_url }}" caption="{{ $data->title }}" class="trailer__block">
		                                    <img src="{{ asset('content/film/trailers/' . $data->trailers->image_preview) }}" class="w-100 t-ease">
		                                    <div class="trailer__block__play">
		                                          <div class="va-block">
		                                              <div class="va-middle">
		                                                  <div class="play-icon"></div>
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
		</section>
	</main>

	<div class="modal fade" tabindex="-1" role="dialog" id="modalTrailer">
		<div class="modal-dialog modal-lg" role="document">
           <div class="modal-content">
               <div class="modal-header">
                    <button type="button" class="close t-ease" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-times-circle" aria-hidden="true"></i></span>
                    </button>
                    <h4 class="modal-title hidden">This title is dynamic</h4>
               </div>
               <div class="modal-body">
                   <div class="video-wrapper">
                        <iframe id="trailerVideo" width="560" height="315" src="" frameborder="0" allowfullscreen></iframe>
                   </div>
               </div>
           </div>
       </div>
    </div>
@endsection

@section('scripts')
	<script type="text/javascript">
		$(function(){

            var url = '', caption = '';

            $('.trailer').on('click', '.trailer__block', function(e){
                $('#modalTrailer').modal('show');
                url = $(this).attr('href');
                caption = $(this).attr('caption');

                var videoid = url.match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/);
                if (videoid != null) {
                    //console.log("video id = ", videoid[1]);
                    url = "//www.youtube.com/embed/"+videoid[1]+"?rel=0&showinfo=0&autoplay=1"
                } else {
                    console.log("The youtube url is not valid.");
                }

                e.preventDefault();
            });


            $("#modalTrailer").on('hide.bs.modal', function() {
                $("#trailerVideo").attr('src', '');
                $("#modalTrailer h4").html('').fadeOut().addClass('hidden');
            });

            $("#modalTrailer").on('shown.bs.modal', function() {
                $("#trailerVideo").attr('src', url);
                $("#modalTrailer h4").html(caption).fadeIn().removeClass();
            });
        });
	</script>
@endsection