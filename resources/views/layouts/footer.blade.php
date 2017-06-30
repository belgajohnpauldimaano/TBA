
  
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1
    </div>
    <strong>Copyright &copy; 2017 <a href="#">TBA</a>.</strong> 
                        
  </footer>

  

</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="{{ asset('cms/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>

<script src="{{ asset('cms/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>

<!-- Bootstrap 3.3.6 -->
<script src="{{ asset('cms/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('cms/plugins/fastclick/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('cms/dist/js/app.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('cms/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
<!-- jvectormap -->
<script src="{{ asset('cms/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('cms/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<!-- SlimScroll 1.3.0 -->
<script src="{{ asset('cms/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<!-- ChartJS 1.0.1 -->
<script src="{{ asset('cms/plugins/chartjs/Chart.min.js') }}"></script>

<script src="{{ asset('cms/plugins/bootbox/bootbox.min.js') }}"></script>
<script src="{{ asset('cms/plugins/dropzone/min/dropzone.min.js') }}"></script>

<script src="{{ asset('cms/plugins/alertifyjs/alertify.min.js') }}"></script>

@yield('scripts')

<script>
        

        //Dropzone.options.profileForm = {
        //    maxFiles : 1,
        //    acceptedFiles : 'image/png'
            /*params : {
                _token : '{{ csrf_token() }}'
            }*/
        //};
        /* Func Name : image_list ()
         * Desc : Reload Image List function from ajax response
         * Params : nothing
         * Return : HTML elements
         */
        function image_list (dataParams) 
        {
            var params = dataParams || { fetching_route : "{{ route('image_list') }}", targetElement : 'js-image_container', extra : '' };
            $('.'+ params.targetElement +' .overlay').removeClass('hidden');
            var data = {_token : '{{ csrf_token() }}'};
            if (params.extra != '')
            {
                data = {_token : '{{ csrf_token() }}', film_id : params.extra};
            }

            $.ajax({
                url :  params.fetching_route, //"{{-- route('image_list') --}}",
                type : 'POST',
                data : data,
                success : function (data) {
                    //'.js-image_container'
                    $('.' + params.targetElement).html(data);
                },
                error : function (xhr, ajaxOptions, thrownError)
                {
                    if (thrownError == 'Unauthorized')
                    {
                        window.location.reload();
                    }
                },
                statusCode: {
                    500: function(xhr) {
                        window.location.reload();
                    }
                } 
            });
        }

        /* Func Name : show_message ( msg )
         * Desc      : scroll on top and will show message
         * Params    : msg - string - display message, type - string - type of error class * (success, info, warning, danger), target - string - element of which the message will appear
         * Return    : HTML elements
         */
        function show_message (msg, type, target) 
        {
            /*var targetElem = 'js-messages_holder';
            if (target != undefined)
            {
                if (target != '')
                {
                    targetElem = target;
                }
            }*/
            
            if (type == 'danger')
            {
                alertify.error('' + msg + '');
            }
            
            if (type == 'success')
            {
                alertify.success('' + msg + '');
            }
            /**
             * CODE BELOW WILL SCROLL TO TOP AND SHOW MESSAGE
             */

            /*$("html, body").animate({ scrollTop: 0 }, "slow"); 
            var elem = '<div class="callout callout-'+ type +' ">'+
                        '      <p>'+
                                    msg
                        '     </p>'+
                        '</div>';
            $('.' + targetElem).html(elem).slideDown('slow', function (){
                setTimeout(function () {
                    $('.js-messages_holder').slideUp('slow');
                }, 3000);
            });*/
        }

        $('body').on('change', '.form-group input', function () {
            $(this).parents('.form-group').children('.help-block').empty();
            $(this).parents('.form-group').removeClass('has-error');
        });

        // Clear modal on hidden
        $('body').on('hidden.bs.modal', '.modal', function (e) {
            $('#js-modal_holder').empty();
            //if ($(this).data('id') !== undefined) // allow refresh of image list only if the modal upload was shown
            //{
            //}
        })
        // disable click thumbnail with href = #
        $('body').on('click', ' .js-edit_film', function (e){
            e.preventDefault();
        });

        function save_data (form, route, fetch_route, elem, extra)
        {
            form.parents('.modal').removeClass('animated');
            form.parents('.modal').removeClass('shake');
            var extraData = { targetMessageElem : "" };
            if(extra != undefined)
            {
                extraData.targetMessageElem = extra['targetMessageElem'];
            }
            form.parents('.box').children('.overlay').removeClass('hidden');
            var formData = new FormData(form[0]);
            $.ajax({
                url : route,
                type : 'POST',
                data : formData,
                processData : false,
                contentType : false,
                success     : function (data) {
                    $('.help-block').empty();
                    $('.form-group').removeClass('has-error');
                    
                    form.parents('.box').children('.overlay').addClass('hidden');
                    if (data.errCode == 1)
                    {
                        form.parents('.modal').addClass('animated shake');
                        for(var err in data.messages)
                        {
                            if($('#'+err+'-error').length) // Checks if the element is exisiting
                            {
                                $('#'+err+'-error').html('<code>'+ data['messages'][err] +'</code>');
                                $('#'+err+'-error').parents('.form-group').addClass('has-error');
                            }
                            else
                            {
                                $('#general-error').append('<code>'+ data['messages'][err] +'</code>');
                            }
                        }
                    }
                    else if (data.errCode == 2)
                    {
                        form.parents('.modal').addClass('animated shake');
                        $('#general-error').html('<code>'+ data.messages +'</code>');
                    }
                    else
                    {
                        show_message (data.messages, 'success');
                        form.parents('.modal').modal('hide');
                        fetch_record(fetch_route, elem, 1, '')
                    }
                    
                }
                ,error : function (xhr, ajaxOptions, thrownError)
                {
                    if (thrownError == 'Unauthorized')
                    {
                        window.location.reload();
                    }
                },
                statusCode: {
                    500: function(xhr) {
                        window.location.reload();
                    }
                }
            });
        }
        

        function fetch_record (route, elem, page, form)
        {
            var formData;
            if (form == '')
            {
                formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('page', page);
            }
            else
            {
                formData = new FormData($('#'+form)[0]);
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('page', page);
            }
            elem.children('.overlay').removeClass('hidden');;
            $.ajax({
                url : route,
                type : 'POST',
                data : formData,
                processData : false,
                contentType : false,
                success     : function (data) {
                    elem.html(data);
                    $('ul.pagination a').css('cursor','pointer');
                }
                ,error : function (xhr, ajaxOptions, thrownError)
                {
                    if (thrownError == 'Unauthorized')
                    {
                        window.location.reload();
                    }
                },
                statusCode: {
                    500: function(xhr) {
                        window.location.reload();
                    }
                } 
            });
        }
        function delete_record (delete_route, fetch_route, elem, id)
        {
            $.ajax({
                url : delete_route,
                type : 'POST',
                data : {_token : '{{ csrf_token() }}', id : id},
                success     : function (data) {
                    if (data.errCode == 1)
                    {
                        show_message (data.messages, 'danger');
                    }
                    else if (data.errCode == 2)
                    {
                        $('#general-error').append('<code>'+ data['messages'] +'</code>');
                    }
                    else
                    {
                        //show_message (data.messages, 'success');
                        fetch_record(fetch_route, elem, 1, '')
                    }
                },
                error : function (xhr, ajaxOptions, thrownError)
                {
                    if (thrownError == 'Unauthorized')
                    {
                        window.location.reload();
                    }
                },
                statusCode: {
                    500: function(xhr) {
                        window.location.reload();
                    }
                } 
            });
        }

        $(function () {
            $('ul.pagination a').css('cursor','pointer');
        });

        $('body').on('click', '.js-view_profile', function (e) {
            e.preventDefault();
            $.ajax({
                url : "{{ route('profile_form_modal') }}",
                type : 'POST',
                data : { _token : '{{ csrf_token() }}', id : '{{ encrypt(Auth::user()->id) }}' },
                success : function (data) {
                    $('#js-modal_holder').html(data);
                    $('#js-profile_form_modal').modal({backdrop:'static'});
                    $('.js-change_pw').css('display', 'none');
                }
                ,error : function (xhr, ajaxOptions, thrownError)
                {
                    if (thrownError == 'Unauthorized')
                    {
                        window.location.reload();
                    }
                },
                statusCode: {
                    500: function(xhr) {
                        window.location.reload();
                    }
                }
            });
            //
        });

        // toggle change password 
        $('body').on('click', '.js-toggle_change_pw', function (e) {
            e.preventDefault();
            $('.js-change_pw').fadeToggle();
            var attr = $('.js-change_pw .form-group .form-control').attr('disabled');
            if (typeof attr !== typeof undefined && attr == 'disabled') {
                $('.js-change_pw .form-group .form-control').removeAttr('disabled');
            }
            else
            {
                $('.js-change_pw .form-group .form-control').attr('disabled',true)
            }
        });
        var dropzone;
        $('body').on('shown.bs.modal', '#js-profile_form_modal', function (e) {
        //$('body').on('click', '.js-update_profile', function (e) {
           
            dropzone = new Dropzone("div#my-awesome-dropzone", { 
                acceptedFiles: "image/*",
                url: "{{ route('upload_photo') }}", 
                maxFiles: 1,
                autoProcessQueue: false,
                uploadMultiple: false,
                parallelUploads: 1,
                maxFiles: 1,
                addRemoveLinks: true,
                paramName : 'profile_photo',
                // The setting up of the dropzone
                maxfilesexceeded: function(file) {
                    this.removeAllFiles();
                    this.addFile(file);
                },
                params : {_token : '{{ csrf_token() }}', user_id : {{ Auth::user()->id }}},
                init: function() {
                    var myDropzone = this;
                    /*var mockFile = { name: 'Name Image', size: 12345, type: 'image/jpeg', id : 123456789 };
                    myDropzone.options.addedfile.call(myDropzone, mockFile);
                    myDropzone.options.success.call(myDropzone, mockFile);
                    myDropzone.options.thumbnail.call(myDropzone, mockFile, "{{ asset('content/film/photos/thumbnail.jpg') }}");
                    myDropzone.options.complete.call(myDropzone, mockFile);*/
                    
                    myDropzone.on('removedfile', function (file) {
                        console.log(file.id);
                    });
                    
                    myDropzone.on("success", function(file, responseText) {
                        //myDropzone.removeAllFiles();
                        if (responseText.errCode == 1)
                        {
                            $('#general-error').html('<code>'+ responseText.messages +'</code>');
                            var node, _i, _len, _ref, _results;
                            var message = responseText.messages;
                            file.previewElement.classList.add("dz-error");
                            _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
                            _results = [];
                            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                            node = _ref[_i];
                            _results.push(node.textContent = message);
                            }
                            alertify.error('' + message + '');
                            return _results;
                        }
                        else
                        {
                            alertify.success('' + responseText.messages + '');
                            return file.previewElement.classList.add("dz-success"); // from source
                        }
                    });

                    
                }
            });
        });
        

        $("body").on('submit', '#profile_form', function (e) {
            e.preventDefault();
            e.stopPropagation();
            dropzone.processQueue();

            var formData = new FormData($(this)[0]);

            $.ajax({
                url : "{{ route('profile_save') }}",
                type : 'POST',
                data : formData,
                processData : false,
                contentType : false,
                success     : function (data) {
                    console.log(data);
                    
                    $('#general-error').empty();
                    if (data.errCode == 1)
                    {
                        for(var err in data.messages)
                        {
                            if($('#'+err+'-error').length) // Checks if the element is exisiting
                            {
                                $('#'+err+'-error').html('<code>'+ data['messages'][err] +'</code>');
                                $('#'+err+'-error').parents('.form-group').addClass('has-error');
                            }
                        }
                    }
                    else if (data.errCode == 2)
                    {
                        $('#general-error').append('<code>'+ data.messages +'</code>');
                    }
                    else
                    {
                        $('#js-profile_form_modal').modal('hide');
                        alertify.success('' + data.messages + '');
                        //user-menu
                        $.ajax({
                            url : "{{ route('profile_display_data') }}",
                            type : 'POST',
                            data : {_token : '{{ csrf_token() }}', id: "{{ encrypt(Auth::user()->id) }}" },
                            success: function (data) {
                                $('.user-menu').html(data);
                            }
                        });
                    }
                }
                ,error : function (xhr, ajaxOptions, thrownError)
                {
                    if (thrownError == 'Unauthorized')
                    {
                        window.location.reload();

                    }
                },
                statusCode: {
                    500: function(xhr) {
                        window.location.reload();
                    }
                } 
            });
        }); 
</script>
</body>
</html>