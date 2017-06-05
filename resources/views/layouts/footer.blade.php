
  
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


@yield('scripts')

<script>
        /* Func Name : image_list ()
         * Desc : Reload Image List function from ajax response
         * Params : nothing
         * Return : HTML elements
         */
        function image_list () 
        {
            $('.js-image_container .overlay').removeClass('hidden');
            $.ajax({
                url : "{{ route('image_list') }}",
                type : 'POST',
                data : {_token : '{{ csrf_token() }}'},
                success : function (data) {
                    $('.js-image_container').html(data);
                }
            });
        }

        /* Func Name : show_message ( msg )
         * Desc      : scroll on top and will show message
         * Params    : msg - string - display message, type - string - type of error class * (success, info, warning, danger)
         * Return    : HTML elements
         */
        function show_message (msg, type) 
        {
            $("html, body").animate({ scrollTop: 0 }, "slow"); 
            var elem = '<div class="callout callout-'+ type +' ">'+
                        '      <p>'+
                                    msg
                        '     </p>'+
                        '</div>';
            $('.js-messages_holder').html(elem).slideDown('slow', function (){
                setTimeout(function () {
                    $('.js-messages_holder').slideUp('slow');
                }, 3000);
            });
        }

        $('body').on('change', '.form-group input', function () {
            $(this).parents('.form-group').children('.help-block').empty();
            $(this).parents('.form-group').removeClass('has-error');
        });

        // Clear modal on hidden
        $('body').on('hidden.bs.modal', '.modal', function (e) {
            $('#js-modal_holder').empty();
            if ($(this).data('id') !== undefined) // allow refresh of image list only if the modal upload was shown
            {
                image_list();
            }
        })
        // disable click thumbnail with href = #
        $('body').on('click', '.thumbnail, .dropdown-menu a, .js-edit_film', function (e){
            e.preventDefault();
        });

        function save_data (form, route, fetch_route, elem)
        {
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
                    if (data.errCode == 1)
                    {
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
                        $('#general-error').html('<code>'+ data.messages +'</code>');
                    }
                    else
                    {
                        show_message (data.messages, 'success');
                        form.parents('.modal').modal('hide');
                        fetch_record(fetch_route, elem, 1, '')
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
                    else
                    {
                        show_message (data.messages, 'success');
                        fetch_record(fetch_route, elem, 1, '')
                    }
                }
            });
        }

        $(function () {
            $('ul.pagination a').css('cursor','pointer');
        });
</script>
</body>
</html>