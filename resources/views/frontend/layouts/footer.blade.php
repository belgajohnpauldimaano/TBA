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
                                <li class="footer__social__item"><a class="footer__social__item__link" target="_blank" href="https://twitter.com/TBAStudiosPH"><i class="fa fa-twitter"></i></a></li>
                                <li class="footer__social__item"><a class="footer__social__item__link" target="_blank" href="https://www.instagram.com/tbastudiosph"><i class="fa fa-instagram"></i></a></li>
                                <li class="footer__social__item"><a class="footer__social__item__link" target="_blank" href="https://www.youtube.com/channel/UChh0rmwGvToBd3owvN2vRMg"><i class="fa fa-youtube"></i></a></li>
                            </ul>
                            <button class="btn btn__footer__mailing btn-block"><i class=" fa fa-envelope m-r-2"></i>JOIN MAILING LIST</button>
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

    <div class="modal fade" id="modal__mailing">
        <div class="modal-dialog center-block" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </button>
                    <h4 class="modal-title">Join Mailing List</h4>
                </div>
                <form method="POST" id="form_subsciption" action="{{ route('add_mailing_list') }}">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <input name="email" type="email" class="form-control" placeholder="Email Address" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="footer__mailing_captcha" id="footer__mailing_captcha" pattern="1" style="visibility: hidden; height: 1px; border-width: 0;">
                            <div name="recaptcha2" id="recaptcha2"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="text-center">
                            <button type="button" class="btn btn-default p-x-6" data-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary p-x-6">Send</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="{{ asset('frontend/node_modules/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/node_modules/owl.carousel/dist/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('frontend/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('cms/plugins/alertifyjs/alertify.min.js') }}"></script>
    <script src="{{ asset('cms/plugins/sweetalert/sweetalert.min.js') }}"></script>

    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
        async defer>
    </script>

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

      $('.btn__footer__mailing').click(function(){
          $('#modal__mailing').modal('show');
      });

        var widget1; //contact page
        var widget2; //footer mailing list
        var onloadCallback = function() {
                var sitekey = '6Ld6kC4UAAAAAKTXcEyXbVrr_e4UfS7dTvJqP8oh';
                
                if ( $('#recaptcha1').length ) {
                    widget1 = grecaptcha.render('recaptcha1', {
                        'sitekey': sitekey
                    });
                }
                
                if ( $('#recaptcha2').length ) {
                    widget2 = grecaptcha.render('recaptcha2', {
                        'sitekey': sitekey,
                        'callback': verifyCallbackCaptcha2
                    });
                }
        };

        var verifyCallbackCaptcha2 = function(response) {
            $('#footer__mailing_captcha').val(1);
            console.log('response', response);
        };

      $('#form_subsciption').on('submit', function (e) {
        e.preventDefault();

        //console.log('asdasd', grecaptcha.getResponse(widget2));

        var formData = new FormData($(this)[0]);
        if(grecaptcha.getResponse(widget2).length === 0){
            sweetAlert("Please verify that you are not a robot.");
        }else{
            $.ajax({
                url : "{{ route('add_mailing_list') }}",
                type : 'POST',
                data : formData,
                contentType : false,
                processData : false,
                success     : function (data) {
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
                        $('#modal__mailing').modal('hide');
                        grecaptcha.reset(widget1); 
                        alertify.success('' + data.messages + '');
                        swal("Success", data.messages, "success")
                    }
                }
            });
        }
      });
    </script>

    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCgb8Z_NPgIMcneQguaKW1SYv4I_ZfEKxw&callback=initMap">
    </script>

  </body>
</html>