@extends('frontend.layouts.main')

@section('page_title')
<title>TBA - Bringing the filipino audience back to the cinema</title>
@endsection

@section('container')
    <div class="hero">
        <div class="hero__owl owl-carousel">
            @if($Carousel)
                @foreach ($Carousel as $Carousel)
                    <a href="{{ $Carousel->url }}" caption="{{ $Carousel->caption }}" class="hero__owl__slide" style="background-image: url({{ asset('content/carousel/'.$Carousel->image) }});">
                        <img src="{{ asset('content/carousel/'.$Carousel->image) }}" class="w-100">
                    </a>
                @endforeach
            @endif
        </div>
    </div>

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
    <script>

        $(function(){

            var url = '', caption = '';

            $('.hero').on('click', '.hero__owl__slide', function(e){
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