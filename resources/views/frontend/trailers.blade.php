@extends('frontend.layouts.main')

@section('container')
	<main class="trailers-page">
		@include('frontend.layouts.film_categ')
		<section>
            <div class="header-title">
                <h2 class="header-title__tag"><span class="text-calibri">2016 - 2017</span> Film Line Up</h2>
            </div>
            <div class="container">
            	<div class="row">
	            	<div class="col-sm-6">
		            	<div class="trailer">
			            	<a href="//www.youtube.com/embed/WIc1VuKhjAI?rel=0" title="Title 1" class="trailer__block">
			            		<img src="{{ asset('frontend/assets/img/hero/1.jpg') }}" class="w-100 t-ease">
			            	</a>
		            	</div>
	            	</div>
	            	<div class="col-sm-6">
		            	<div class="trailer">
			            	<a href="//www.youtube.com/embed/wS52h2vTQAY?rel=0" title="Title 2" class="trailer__block">
			            		<img src="{{ asset('frontend/assets/img/hero/2.jpg') }}" class="w-100 t-ease">
			            	</a>
		            	</div>
	            	</div>
	            	<div class="col-sm-6">
		            	<div class="trailer">
			            	<a href="//www.youtube.com/embed/yz0qqvuJVrs?rel=0" title="Title 3" class="trailer__block">
			            		<img src="{{ asset('frontend/assets/img/hero/3.jpg') }}" class="w-100 t-ease">
			            	</a>
		            	</div>
	            	</div>
	            	<div class="col-sm-6">
		            	<div class="trailer">
			            	<a href="//www.youtube.com/embed/WIc1VuKhjAI?rel=0" title="Title 4" class="trailer__block">
			            		<img src="{{ asset('frontend/assets/img/hero/4.jpg') }}" class="w-100 t-ease">
			            	</a>
		            	</div>
	            	</div>
            	</div>
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

			var url = '', title = '';

			$('.trailer').on('click', '.trailer__block', function(e){
				$('#modalTrailer').modal('show');
				url = $(this).attr('href');
				title = $(this).attr('title');
				e.preventDefault();
			});


		    $("#modalTrailer").on('hide.bs.modal', function() {
		        $("#trailerVideo").attr('src', '');
		        $("#modalTrailer h4").html('').fadeOut().addClass('hidden');
		    });

		    $("#modalTrailer").on('shown.bs.modal', function() {
		        $("#trailerVideo").attr('src', url+'&showinfo=0&autoplay=1');
		        $("#modalTrailer h4").html(title).fadeIn().removeClass();
		    });
		});

		// Find all YouTube videos
		var $allVideos = $("iframe[src^='//www.youtube.com']"),

		    // The element that is fluid width
		    $fluidEl = $("body");

		// Figure out and save aspect ratio for each video
		$allVideos.each(function() {

		    $(this)
		        .data('aspectRatio', this.height / this.width)

		    // and remove the hard coded width/height
		    .removeAttr('height')
		        .removeAttr('width');

		});

		// When the window is resized
		$(window).resize(function() {

		    var newWidth = $fluidEl.width();

		    // Resize all videos according to their own aspect ratio
		    $allVideos.each(function() {

		        var $el = $(this);
		        $el
		            .width(newWidth)
		            .height(newWidth * $el.data('aspectRatio'));

		    });

		    // Kick off one resize to fix all videos on page load
		}).resize();
	</script>
@endsection