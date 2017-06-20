    <footer>
        <div class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <h4>About</h4>
                        <p>TBA Studios is an independent film production company dedicated to making high quality films and promoting Filipino filmmakers worldwide.</p>
                    </div>
                    <div class="col-md-5 col-sm-6">
                        <div class="footer__mid center-block">
                            <ul class="list-inline footer__social clearfix">
                                <li class="footer__social__item"><a class="footer__social__item__link" target="_blank" href="https://www.facebook.com/tukobuchiboyartikulo/"><i class="fa fa-facebook"></i></a></li>
                                <li class="footer__social__item"><a class="footer__social__item__link" target="_blank" href=""><i class="fa fa-twitter"></i></a></li>
                                <li class="footer__social__item"><a class="footer__social__item__link" target="_blank" href=""><i class="fa fa-instagram"></i></a></li>
                                <li class="footer__social__item"><a class="footer__social__item__link" target="_blank" href="https://www.youtube.com/channel/UChh0rmwGvToBd3owvN2vRMg"><i class="fa fa-youtube"></i></a></li>
                            </ul>
                            <form method="POST" id="form_subsciption" action="{{ route('add_mailing_list') }}">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <input name="email" type="text" class="form-control" placeholder="Email Address" aria-describedby="basic-addon1">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-sm-12 visible-sm"><hr></div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-sm-6 col-md-push-6">
                                <h4>Contact</h4>
                                <p>
                                    160 Luna Mencias St., <br>
                                    Brgy. Addition Hills, <br>
                                    San Juan City 1500, <br>
                                    Metro Manila, Philippines <br>
                                    Info@tba.ph
                                </p>
                            </div>
                            <div class="col-sm-6 col-md-pull-6">
                                <div id="map"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>


    <script src="{{ asset('frontend/node_modules/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/node_modules/owl.carousel/dist/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('frontend/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('cms/plugins/alertifyjs/alertify.min.js') }}"></script>
    <script src="{{ asset('cms/plugins/sweetalert/sweetalert.min.js') }}"></script>

    @yield('scripts')

    <script>
      $(document).ready(function() {
          $('.nav-owl__menu').owlCarousel({
              autoWidth: true,
              slideBy: 3,
              nav: true,
              navText: ['<img src="{{ asset("frontend/assets/img/left-arrow.png") }}" class="t-ease">', '<img src="{{ asset("frontend/assets/img/right-arrow.png") }}" class="t-ease">']
          });

          $('.hero__owl').owlCarousel({
              autoplay: true,
              loop: true,
              items: 1,
              animateOut: 'fadeOut',
              animateIn: 'fadeIn'
          });
      });


      function initMap() {
          var latLong = {
              lat: 14.592483,
              lng: 121.037864
          };

          function mapIdSelected(mapId){
              var map = new google.maps.Map(document.getElementById(mapId), {
                  zoom: 18,
                  center: latLong,
                  scrollwheel: false
              });
              var marker = new google.maps.Marker({
                  position: latLong,
                  map: map
              });
          }

          mapIdSelected('map');

          @if(Request::is('contact'))
            mapIdSelected('mapContact');
          @endif
      }

      var $document = $(document),
          $element = $('.navbar__scrolled');

      $document.scroll(function() {
          if ($document.scrollTop() >= 70) {
              $element.fadeIn();
          } else {
              $element.fadeOut();
          }
      });

      $('.gotoTop').on('click', function(e) {
          e.preventDefault();
          $('html,body').animate({
              scrollTop: 0
          }, 700);
      });

      $('#form_subsciption').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        $.ajax({
            url : "{{ route('add_mailing_list') }}",
            type : 'POST',
            data : formData,
            contentType : false,
            processData : false,
            success     : function (data) {
                console.log(data);
                if (data.errCode == 1)
                {
                    var errMessages = '';
                    for(var err in data.messages)
                    {
                        alertify.error('' + data.messages[err] + '');
                        errMessages = data.messages[err];
                    }
                    sweetAlert("Invalid", errMessages, "error");
                }
                else
                {
                        alertify.success('' + data.messages + '');
                        swal("Success", data.messages, "success")
                }
            }
        });
      });
    </script>

    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCgb8Z_NPgIMcneQguaKW1SYv4I_ZfEKxw&callback=initMap">
    </script>

  </body>
</html>