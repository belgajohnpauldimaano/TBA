@extends('frontend.layouts.main')

@section('page_title')
<title>{{ $film_info->title }}, a film by TBA</title>
@endsection

@section ('styles')
  <link href="{{ asset('frontend/node_modules/photoswipe/dist/photoswipe.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/node_modules/photoswipe/dist/default-skin/default-skin.css') }}" rel="stylesheet">
@endsection

@section('container')
    <main>
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-md-9">
                        @if ($film_info->trailers->count() > 0)
                            <img src="{{ asset('content/film/trailers/' . $film_info->trailers[0]->image_preview) }}" class="w-100">
                        @endif
                        <div class="row">
                           <div class="col-md-4 col-sm-5">
                              <div class="info-img">
                                 <div class="hidden-xs">
                                    @if ($film_info->posters->where('featured', 1)->count() == 1)
                                        @foreach ($film_info->posters->where('featured', 1) as $poster)
                                            <img src="{{ asset('content/film/posters/' . $poster->label) }}" class="w-100">
                                        @endforeach
                                    @else
                                        @foreach ($film_info->posters->where('featured', 0) as $poster)
                                            <img src="{{ asset('content/film/posters/' . $poster->label) }}" class="w-100">
                                        @endforeach
                                    @endif

                                    @if ($film_info->sell_sheet != NULL)
                                        <a href="{{ asset('content/sell_sheets/' . $film_info->sell_sheet) }}" target="_blank" class="btn btn-flat btn-default btn-block btn-default--border">Sell Sheet</a>
                                    @endif
                                    {{-- <button class="btn btn-default btn-default--border btn-block">Sell Sheet</button> --}}
                                 </div>
                                 <div class="btn-group btn-group-justified visible-xs" role="group" aria-label="...">
                                      <div class="btn-group" role="group">
                                          <button type="button" class="btn btn-default">View Poster</button>
                                      </div>
                                      <div class="btn-group" role="group">
                                            @if ($film_info->sell_sheet != NULL)
                                                <a href="{{ asset('content/sell_sheets/' . $film_info->sell_sheet) }}" target="_blank" class="btn btn-flat btn-default btn-md">Sell Sheet</a>
                                            @else
                                                None uploaded
                                            @endif
                                          {{-- <button type="button" class="btn btn-default">Sell Sheet</button> --}}
                                      </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-8 col-sm-7">
                              <div class="info-desc">
                                  <h1 class="h2">{{ $film_info->title }}</h1>
                                  <p class="m-b-6">{!! $film_info->synopsis !!}</p>

                                  <ul class="list-inline m-b-4">
                                      <strong>GENRE:</strong>
                                      <?php
                                          /*$genres = $film_info->genre;
                                          $genre_display = '';
                                          $genre_arr = explode(',', $genres);
                                          */
                                      ?>
                                      {{-- @if ($genre_arr)
                                          @foreach ($genre_arr as $genre)
                                              <li><span class="">{{$genre}}</span></li>
                                          @endforeach
                                      @endif --}}

                                      {{-- USE CODE ABOVE TO SPECIFY STYLE TO EACH GENRE --}}

                                      <li><span class="">{{$film_info->genre}}</span></li>
                                  </ul>

                                  @foreach (App\FilmCrew::ROLE as $key => $role)
                                      @if ($film_info->film_crews->where('role', $key)->count() > 0)
                                          <ul class="list-inline">
                                              <li>
                                                  <strong>{{ $role }}:</strong>
                                              </li>
                                              <li>
                                                  @foreach ($film_info->film_crews->where('role', $key) as $crew)
                                                      <span class=""> {{ $crew->person->name }} </span>
                                                  @endforeach
                                              </li>
                                          </ul>
                                      @endif
                                  @endforeach
                              </div>
                           </div>
                       </div>
                    </div>
                    <div class="col-md-3 hidden-xs hidden-sm">
                        <img src="http://via.placeholder.com/359x700" class="img-responsive">
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
                            @if ($film_info->hash_tags)
                                {{ $film_info->hash_tags }}
                            @endif
                       </h4>
                    </div>
                </div>
            </div>
        </section>

        <section class="film-award">
            <div class="container">
                <div class="header-title">
                    <h2 class="header-title__tag">Awards / Festivals</h2>
                </div>
                <div class="row">
                    @if ($film_info->awards)
                        <div class="col-md-10 col-md-offset-1">
                            <div class="film-award-owl m-b-6 owl-carousel">
                                @foreach ($film_info->awards as $award)
                                    <div class="item">
                                        <img src="{{ asset('content/film/awards/' . $award->award_image) }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
               </div>
            </div>
        </section>

        <section class="films-gallery">
            <div class="header-title">
                <h2 class="header-title__tag">Gallery</h2>
            </div>
            <div class="owl-gallery owl-carousel">
                @if ($film_info->photos)
                    @foreach ($film_info->photos as $key => $photo)
                        <a href="{{ asset('content/film/photos/'.$photo->filename) }}" class="owl-gallery__item" title="{{$photo->title}}" data-no="{{ $key }}">
                            <img src="{{ asset('content/film/photos/'.$photo->thumb_filename) }}" alt="">
                        </a>
                    @endforeach
                @endif
            </div>
        </section>

        <section class="film-quotes">
           <div class="container">
               <div class="row">
                   <div class="col-md-8 col-md-offset-2">
                        <div class="header-title">
                            <h2 class="header-title__tag">Quotes</h2>
                        </div>
                       <div class="text-center h3">
                            @if ($film_info->quote)
                                <p><i>“{{ $film_info->quote->main_quote }}”</i></p>
                                <p class="m-y-6"><strong>-{{ $film_info->quote->name_of_person }}</strong></p>
                                <a href="{{ $film_info->quote->url }}" class="read-more">[READ MORE]</a>
                            @endif
                       </div>
                   </div>
               </div>
           </div>
         </section>
         
         <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2"><hr class="m-b-0"></div>
            </div>
         </div>

         <section class="film-press">
            <div class="container">
               <div class="row">
                   <div class="col-md-8 col-md-offset-2">
                        <div class="header-title">
                            <h2 class="header-title__tag">Press Realease</h2>
                        </div>
                       <div class="text-center">
                            @if ($film_info->press_release)
                                <h3><strong>{{ $film_info->press_release->title }}</strong></h3>
                                <div class="h3">
                                    <p class="m-b-6">
                                        {!! $film_info->press_release->blurb !!}
                                    </p>
                                    <a href="#" class="read-more" id="readMorePR_info">[READ MORE]</a>
                                </div>
                            @endif
                       </div>
                   </div>
               </div>
            </div>
         </section>
    </main>

    @if ($film_info->press_release)
        <div class="modal fade" tabindex="-1" role="dialog" id="modalPressRelease">
           <div class="modal-dialog modal-lg m-t-0" role="document">
               <div class="modal-content">
                   <img src="{{ asset('content/film/press_release/'.$film_info->press_release->article_image) }}" alt="" class="img-responsive center-block">
                   <div class="modal-body">
                      <div class="row">
                         <div class="col-md-10 col-md-offset-1">
                            <h2 class="text-center">{{ $film_info->press_release->title }}</h2>
                            <div>
                                {!! $film_info->press_release->blurb !!}
                            </div>
                         </div>
                      </div>
                   </div>
               </div>
           </div>
        </div>
    @endif

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

      $('.film-award-owl').owlCarousel({
          items: 4,
          //loop: true,
          loop: ($(".film-award-owl .item").length > 4) ? true : false,
          margin: 30,
          nav: false,
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
      
      var owl = $('.owl-gallery');
      options = {
          items: 4,
          //loop: true,
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
      owl.owlCarousel(options);

      $('#readMorePR_info').on('click', function(e) {
          e.preventDefault();
          $('#modalPressRelease').modal('show');
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
              maxSpreadZoom: 1,
              getDoubleTapZoom: function(isMouseClick, item) {
                  return item.initialZoomLevel;
              },

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
      };


      $('.films-gallery').on('click', '.owl-gallery__item', function(e) {
          var id = $(this).attr('data-no');
          openPhotoSwipe(id);
          e.preventDefault();
      });

    </script>
@endsection