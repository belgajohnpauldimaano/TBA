@extends('frontend.layouts.main')

@section('page_title')
<title>{{ $film_info->title }}, by TBA Studios</title>
@endsection

@section ('styles')
  <link href="{{ asset('frontend/node_modules/photoswipe/dist/photoswipe.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/node_modules/photoswipe/dist/default-skin/default-skin.css') }}" rel="stylesheet">
@endsection

@section('container')
    <main>
        {{-- <pre>{{ json_encode($film_info->trailers, JSON_PRETTY_PRINT)}}</pre> --}}
        {{-- <pre>{{ json_encode($film_info, JSON_PRETTY_PRINT)}}</pre> --}}
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-md-9">
                    {{-- <pre>{{ json_encode($film_info->trailers, JSON_PRETTY_PRINT)}}</pre> --}}
                        @if ($film_info->trailers)
                          {{-- <div class="film-trailers-owl owl-carousel">
                              @foreach ($film_info->trailers->where('trailer_show', 2) as $show)
                              @endforeach
                          </div> --}}
                            <div class="film-trailers-owl owl-carousel">
                              <a href="{{ $film_info->trailers->trailer_url }}" class="film-trailers-owl__item" caption="{{ $film_info->title }}">
                                  <img src="{{ asset('content/film/trailers/' . $film_info->trailers->image_preview) }}">
                                  <div class="film-trailers-owl__item__play">
                                      <div class="va-block">
                                          <div class="va-middle">
                                              <div class="play-icon"></div>
                                          </div>
                                      </div>
                                  </div>
                              </a>
                            </div>
                        @endif
                        <div class="row">
                           <div class="{{ $film_info->posters->count() < 1 ? 'hidden' : 'col-md-4 col-sm-5' }}">
                              <div class="info-img">
                                 <div class="hidden-xs">
                                    @if ($film_info->posters->where('featured', 1)->count() == 1)
                                        @foreach ($film_info->posters->where('featured', 1) as $key => $poster)
                                          <a href="{{ asset('content/film/posters/' . $poster->label) }}" class="poster-popup" data-no="{{ $key }}">
                                              <img src="{{ asset('content/film/posters/preview-' . $poster->label) }}" class="w-100">
                                          </a>
                                        @endforeach
                                    @else
                                        @foreach ($film_info->posters->where('featured', 0) as $key => $poster)
                                          <a href="{{ asset('content/film/posters/' . $poster->label) }}" class="poster-popup" data-no="{{ $key }}">
                                            <img src="{{ asset('content/film/posters/preview-' . $poster->label) }}" class="w-100">
                                          </a>
                                        @endforeach
                                    @endif
                                    @if ($film_info->sell_sheet != NULL)
                                      <div class="hidden-xs">
                                        <a href="{{ asset('content/sell_sheets/' . $film_info->sell_sheet) }}" target="_blank" class="btn btn-default btn-default--border btn-block">Sell Sheet</a>
                                      </div>
                                    @endif
                                 </div>
                                 <div class="btn-group btn-group-justified visible-xs" role="group" aria-label="...">
                                      <div class="btn-group" role="group">
                                          @if ($film_info->posters->where('featured', 1)->count() == 1)
                                              @foreach ($film_info->posters->where('featured', 1) as $key => $poster)
                                                <button type="button" class="btn btn-default btn-default__black poster-popup" data-no="{{ $key }}">View Poster</button>
                                              @endforeach
                                          @else
                                              @foreach ($film_info->posters->where('featured', 0) as $key => $poster)
                                                <button type="button" class="btn btn-default btn-default__black poster-popup" data-no="{{ $key }}">View Poster</button>
                                              @endforeach
                                          @endif
                                      </div>
                                      @if ($film_info->sell_sheet != NULL)
                                          <div class="btn-group" role="group">
                                            <a href="{{ asset('content/sell_sheets/' . $film_info->sell_sheet) }}" target="_blank" class="btn btn-default">Sell Sheet</a>
                                          </div>
                                      @endif
                                 </div>
                              </div>
                           </div>
                           <div class="{{ $film_info->posters->count() < 1 ? 'col-xs-12 col-md-12' : 'col-md-8 col-sm-7' }}">
                              <div class="info-desc">
                                  <h1 class="h2">{{ $film_info->title }}</h1>
                                  <div class="m-b-5">{!! $film_info->synopsis !!}</div>

                                  <ul class="list-inline m-b-5">
                                      <li><strong class="text-NeutraTextTF">GENRE:</strong></li>
                                      <li><span class="">{{$film_info->genre}}</span></li>
                                  </ul>

                                  @foreach (App\FilmCrew::ROLE as $key => $role)
                                      @if ($film_info->film_crews->where('role', $key)->count() > 0)
                                          @if ($role != 'PRODUCTION')
                                              <ul class="list-inline {{ strtolower(str_replace(' ', '-', $role)) == 'cast' ? 'm-b-5' : '' }}">
                                                  <li>
                                                      <strong class="text-NeutraTextTF">{{ $role }}:</strong>
                                                  </li>
                                                  <li>
                                                    <?php
                                                        $crews = $film_info->film_crews->where('role', $key);
                                                        $ctr = 0;
                                                    ?>
                                                    
                                                      @foreach ($crews as $crew)
                                                          <span class=""> {{ ($ctr > 0 ? ',' : '') }} {{ $crew->person->name }} </span>
                                                          <?php $ctr++; ?>
                                                      @endforeach
                                                  </li>
                                              </ul>
                                          @endif
                                      @endif
                                  @endforeach

                                  @if ($film_info->running_time)
                                      <ul class="list-inline m-t-5">
                                          <li><strong class="text-NeutraTextTF">TOTAL RUNNING TIME:</strong></li>
                                          @if ($film_info->running_time >= 160)
                                            <li><span>{{ date('G \h\o\u\r\s i \m\i\n\u\t\e\s', mktime(0, $film_info->running_time)) }}</span></li>
                                          @else
                                            <li><span>{{ date('G \h\o\u\r i \m\i\n\u\t\e\s', mktime(0, $film_info->running_time)) }}</span></li>
                                          @endif
                                      </ul>
                                  @endif
                                  @if ($film_info->release_date)
                                      <ul class="list-inline">
                                          <li><strong class="text-NeutraTextTF">RELEASE DATE:</strong></li>
                                          <li><span class="">{{ date('F d, Y', strtotime($film_info->release_date)) }}</span></li>
                                      </ul>
                                  @endif

                                  @if($film_info->posters->count() < 1)
                                      @if ($film_info->sell_sheet != NULL)
                                          <div class="hidden-xs">
                                            <hr>
                                            <a href="{{ asset('content/sell_sheets/' . $film_info->sell_sheet) }}" target="_blank" class="btn btn-default btn-default--border p-x-6">Sell Sheet</a>
                                          </div>
                                      @endif
                                  @endif
                              </div>
                           </div>
                       </div>
                    </div>
                    {{-- <div class="col-md-3 hidden-xs hidden-sm js-hashtags"> --}}
                    <div class="col-md-3">
                      @if($film_info->hash_tag_id)
                        <iframe src="http://social.tba.ph/test/index.php?id={{ $film_info->hash_tag_id }}" frameborder="0" height=500"></iframe>
                      @endif
                        <hr class="visible-xs visible-sm">
                        <?php  
                            $for_search = '';
                            $for_display = '';
                        ?>
                        @if ($film_info->hash_tags)
                            <?php
                                $hashtag_arr = explode(',', $film_info->hash_tags);
                                $ctr = 0;
                            ?>
                            @foreach ($hashtag_arr as $hashtag)
                                <?php 
                                    $for_search .= ($ctr > 0 ? ',':'') . trim($hashtag); 
                                    $ctr++;
                                    $for_display .= '<div>#' .trim($hashtag) . '</div>'; 
                                ?>
                            @endforeach
                            
                            {{-- <div>
                                <iframe src="https://www.hashatit.com/hashtags/{{$for_search}}/all/embed" width="100%" height="400"></iframe>
                            </div> --}}
                        @endif
                        <ul class="list-inline social-icon text-center m-y-3">
                            @if ($film_info->links)
                            
                                @if ($film_info->links->facebook_url)
                                
                                    <li class="p-x-2"><a href="{{ $film_info->links->facebook_url }}"><i class="fa fa-facebook"></i></a></li>
                                @endif
                                
                                @if ($film_info->links->twitter_url)
                                
                                    <li class="p-x-2"><a href="{{ $film_info->links->twitter_url }}"><i class="fa fa-twitter"></i></a></li>
                                @endif
                                
                                @if ($film_info->links->instagram_url)
                                
                                    <li class="p-x-2"><a href="{{ $film_info->links->instagram_url }}"><i class="fa fa-instagram"></i></a></li>
                                @endif

                            @endif
                       </ul>
                       <h4 class="text-center">
                            {!! $for_display !!}
                       </h4>
                    </div>
                </div>
            </div>
        </section>

        @if ($film_info->awards->count() > 0)
            <section class="film-award">
                <div class="container">
                    <div class="header-title">
                        <h2 class="header-title__tag">
                              Awards / Festivals
                        </h2>
                    </div>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="film-award-owl m-b-6 owl-carousel">
                                @foreach ($film_info->awards as $award)
                                    <div class="item">
                                        <img src="{{ asset('content/film/awards/' . $award->award_image) }}" title="{{$award->award_name}}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                   </div>
                </div>
            </section>
        @else
            <div class="m-y-5 p-y-1"></div>
        @endif

        @if ($film_info->photos)
            <section class="films-gallery">
                <div class="header-title">
                    <h2 class="header-title__tag">
                          Gallery
                    </h2>
                </div>
                <div class="owl-gallery owl-carousel">
                    @foreach ($film_info->photos as $key => $photo)
                        <a href="{{ asset('content/film/photos/'.$photo->filename) }}" class="owl-gallery__item" title="@if ($photo->title != '') {{ $photo->title }} @else {{ $film_info->title . '(' . date('Y', strtotime($film_info->release_date)) . ')' }} @endif" data-no="{{ $key }}">
                            <img src="{{ asset('content/film/photos/'.$photo->thumb_filename) }}" title="{{$photo->title}}">
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        @if ($film_info->quotes->count() > 0)
            <section class="film-quotes">
               <div class="container">
                   <div class="row">
                       <div class="col-md-8 col-md-offset-2">
                            <div class="header-title">
                                <h2 class="header-title__tag">
                                      Quotes
                                </h2>
                            </div>
                           <div class="text-center h3">
                              <div class="film-quotes-owl m-b-6 owl-carousel">
                                  @foreach($film_info->quotes as $data)
                                    <div class="item">
                                        <p><i>“{{ $data->main_quote }}”</i></p>
                                        <p class="m-y-6"><strong>-{{ $data->name_of_person }}</strong></p>
                                        @php
                                          function addhttp($url) {
                                              if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
                                                  $url = "http://" . $url;
                                              }
                                              return $url;
                                          }
                                        @endphp
                                        @if ($data->url)
                                            <a href="{{ addhttp($data->url) }}" target="_blank" class="read-more">[READ MORE]</a>
                                        @endif
                                    </div>
                                  @endforeach
                              </div>
                           </div>
                       </div>
                   </div>
               </div>
             </section>
        @endif
         
        @if ($film_info->press_release)
          @if ($film_info->quotes->count() > 0)
           <div class="container">
              <div class="row">
                  <div class="col-md-8 col-md-offset-2"><hr class="m-b-0"></div>
              </div>
              {{-- <pre>{{ json_encode($press_release, JSON_PRETTY_PRINT)}}</pre> --}}
           </div>
        @endif

           <section class="film-press">
              <div class="container">
                 <div class="row">
                     <div class="col-md-8 col-md-offset-2">
                          <div class="header-title">
                              <h2 class="header-title__tag">Press Release</h2>
                          </div>
                         <div class="text-center">
                              <h3><strong>{{ $film_info->press_release->title }}</strong></h3>
                              <div class="h3">
                                  <p class="m-b-6">
                                      {!! $film_info->press_release->blurb !!}
                                  </p>
                                  <a href="#" class="read-more center-block m-t-6" id="readMorePR_info">[READ MORE]</a>
                              </div>
                         </div>
                     </div>
                 </div>
              </div>
           </section>
        @endif
    </main>

    @if ($film_info->press_release)
        <div class="modal fade" tabindex="-1" role="dialog" id="modalPressRelease">
           <div class="modal-dialog modal-lg m-t-0" role="document">
               <div class="modal-content">
                   <img src="{{ asset('content/film/press_release/'.$film_info->press_release->article_image) }}" alt="" class="w-100">
                   <div class="modal-body">
                      <div class="row">
                         <div class="col-md-10 col-md-offset-1 text-center">
                            <h2>{{ $film_info->press_release->title }}</h2>
                            <div class="content">
                                {!! $film_info->press_release->content !!}
                                @if($film_info->press_release->pdf)
                                  <a href="{{ asset('content/upload/'.$film_info->press_release->pdf) }}" download class="btn btn-default m-y-3">Download PDF</a>
                                @endif
                            </div>
                         </div>
                      </div>
                   </div>
               </div>
           </div>
        </div>
    @endif

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

    <!-- Root element of PhotoSwipe. Must have class pswp. -->
    <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

        <!-- Background of PhotoSwipe. 
             It's a separate element, as animating opacity is faster than rgba(). -->
        <div class="pswp__bg"></div>

        <!-- Slides wrapper with overflow:hidden. -->
        <div class="pswp__scroll-wrap">

            <!-- Container that holds slides. PhotoSwipe keeps only 3 slides in DOM to save memory. -->
            <!-- don't modify these 3 pswp__item elements, data is added later on. -->
            <div class="pswp__container">
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
            </div>

            <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
            <div class="pswp__ui pswp__ui--hidden">

                <div class="pswp__top-bar">

                    <!--  Controls are self-explanatory. Order can be changed. -->

                    <div class="pswp__counter"></div>

                    <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>

                    <button class="pswp__button pswp__button--share" title="Share"></button>

                    <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>

                    <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

                    <!-- Preloader demo https://codepen.io/dimsemenov/pen/yyBWoR -->
                    <!-- element will get class pswp__preloader--active when preloader is running -->
                    <div class="pswp__preloader">
                        <div class="pswp__preloader__icn">
                          <div class="pswp__preloader__cut">
                            <div class="pswp__preloader__donut"></div>
                          </div>
                        </div>
                    </div>
                </div>

                <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                    <div class="pswp__share-tooltip"></div> 
                </div>

                <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
                </button>

                <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
                </button>

                <div class="pswp__caption">
                    <div class="pswp__caption__center"></div>
                </div>

              </div>

            </div>

    </div>
@endsection


@section ('scripts')
    <script src="{{ asset('frontend/node_modules/photoswipe/dist/photoswipe.min.js') }}"></script>
    <script src="{{ asset('frontend/node_modules/photoswipe/dist/photoswipe-ui-default.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/app.js') }}"></script>

    <script type="text/javascript">
      var owlTrailer = $('.film-trailers-owl');
      owlTrailer.owlCarousel({
          items: 1,
          loop: ($(".film-trailers-owl .item").length > 1) ? true : false,
          nav: false,
          autoplay: true,
          autoplaySpeed: 1000,
          autoplayTimeout: 5000
      });

      var owlFilmAward = $('.film-award-owl');
      owlFilmAward.owlCarousel({
          items: 4,
          //loop: true,
          loop: ($(".film-award-owl .item").length > 4) ? true : false,
          margin: 30,
          nav: true,
          navText: ['<span class="va-block"><span class="va-middle"><i class="fa fa-angle-left"></i></span></span>', '<span class="va-block"><span class="va-middle"><i class="fa fa-angle-right"></i></span></span>'],
          loop: ($(".owl-gallery .item").length > 4) ? true : false,
          autoplay: true,
          autoplaySpeed: 1000,
          autoplayTimeout: 5000,
          responsive: {
              0: {
                  items: 3
              },
              768: {
                  items: 4
              }
          }
      });
      
      var owlGallery = $('.owl-gallery');
      options = {
          items: 4,
          //loop: true,
          nav: true,
          navText: ['<span class="va-block"><span class="va-middle"><i class="fa fa-angle-left"></i></span></span>', '<span class="va-block"><span class="va-middle"><i class="fa fa-angle-right"></i></span></span>'],
          loop: ($(".owl-gallery .item").length > 4) ? true : false,
          margin: 1,
          autoplay: true,
          autoplaySpeed: 1000,
          autoplayTimeout: 3000,
          responsive: {
              0: {
                  items: 3
              },
              768: {
                  items: 4
              }
          }
      };
      owlGallery.owlCarousel(options);

      var owlFilmQuotes = $('.film-quotes-owl');
      owlFilmQuotes.owlCarousel({
          items: 1,
          nav: true,
          navText: ['<span class="va-block"><span class="va-middle"><i class="fa fa-angle-left"></i></span></span>', '<span class="va-block"><span class="va-middle"><i class="fa fa-angle-right"></i></span></span>'],
          margin: 30,
          autoplay: true,
          autoplaySpeed: 1000,
          autoplayTimeout: 5000
      });

      $('#readMorePR_info').on('click', function(e) {
          e.preventDefault();
          $('#modalPressRelease').modal('show');
      });

      $('#modalPressRelease').on('hidden.bs.modal', function(e) {
          owlPressRelease.trigger('play.owl.autoplay');
      });

      var gallery = {};
      var openPhotoSwipe = function(goTo) {
          var pswpElement = document.querySelectorAll('.pswp')[0];
          // build items array
          var items = [
                @if ($film_info->photos)
                    @foreach ($film_info->photos as $photo)
                        {
                            src: '{{ asset('content/film/photos/'.$photo->filename) }}',
                            w: {{ Image::make(asset('content/film/photos/'.$photo->filename))->width() }},
                            h: {{ Image::make(asset('content/film/photos/'.$photo->filename))->height() }},
                        },
                    @endforeach
                @endif
          ];

          // define options (if needed)
          var options = {
              history: false,
              focus: false,
              index: parseInt(goTo),

              showAnimationDuration: 0,
              hideAnimationDuration: 0, 

              bgOpacity: 0.9,
              fullscreenEl: false,
              zoomEl: false,
              shareEl: false,

              closeOnScroll: false
          };

          gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
          gallery.init();

          gallery.listen('close', function() {
            gallery.close();
          });
      };



      $('.films-gallery').on('click', '.owl-gallery__item', function(e) {
          var id = $(this).attr('data-no');
          openPhotoSwipe(id);
          e.preventDefault();
      });

      var posters = {};
      var openPhotoSwipePoster = function(goTo) {
          var pswpElement = document.querySelectorAll('.pswp')[0];
          // build items array
          var items = [
                @if ($film_info->posters)
                    @foreach ($film_info->posters as $photo)
                        {
                            src: '{{ asset('content/film/posters/' . $photo->label) }}',
                            w: {{ Image::make(asset('content/film/posters/' . $photo->label))->width() }},
                            h: {{ Image::make(asset('content/film/posters/' . $photo->label))->height() }},
                        },
                    @endforeach
                @endif
          ];

          // define options (if needed)
          var options = {
              history: false,
              focus: false,
              index: parseInt(goTo),

              showAnimationDuration: 0,
              hideAnimationDuration: 0, 

              bgOpacity: 0.9,
              fullscreenEl: false,
              zoomEl: false,
              shareEl: false,

              closeOnScroll: false
          };

          posters = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
          posters.init();

          posters.listen('close', function() {
            posters.close();
          });
      };


      $('.info-img').on('click', '.poster-popup', function(e) {
          var id = $(this).attr('data-no');
          openPhotoSwipePoster(id);
          e.preventDefault();
      });



      $(function(){

          var url = '', caption = '';

          $('.film-trailers-owl').on('click', '.film-trailers-owl__item', function(e) {
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