@extends('layouts.main')

@section ('styles')
    <link rel="stylesheet" href="{{ asset('cms/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
    <link rel="stylesheet" href="{{ asset('cms/plugins/datepicker/datepicker3.css') }}">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset('cms/plugins/iCheck/all.css') }}">
@endsection

@section ('content')
    <div class="row">
        <div class="col-sm-12">

            <div class="box box-primary">

                <div class="box-header with-border">
                    <h3 class="box-title">Film</h3>
                </div>

                <div class="box-body">

                    <div class="row" id="js-film_primary_info">

                        <div class="col-sm-6">

                            <div class="form-group">
                                <label for="">Title</label>
                                <h3 class="margin">
                                    <span>{{ $Film->title }}</span>
                                </h3>
                            </div>
                            
                            <div class="">
                                <label for="">Synopsis</label>
                                <h5 class="margin">
                                    {{ ($Film->synopsis != NULL ? $Film->synopsis : 'None') }}
                                    The quick brown fox jumps over the lazy dog
                                </h5>
                            </div>
                            
                            <div>
                                <label for="">Genre</label>
                                <h5 class="margin">
                                    {{ ($Film->genre != NULL ? $Film->genre->genre : 'None') }}
                                </h5>
                            </div>
                            
                            <div>
                                <label for="">Running Time</label>
                                <h5 class="margin">
                                    {{ ($Film->running_time != NULL ? $Film->running_time : 'None') }}
                                </h5>
                            </div>
                            

                        </div>

                        <div class="col-sm-6">
                        
                            <div>
                                <label for="">Release Status</label>
                                <h5 class="margin">
                                    {{ ($Film->release_status != NULL ? $Film->release_status : 'None') }}
                                </h5>
                            </div>
                            
                            <div>
                                <label for="">Release Date</label>
                                <h5 class="margin">
                                    {{ ($Film->release_date != NULL ? Date('l, jS \of F Y', strtotime($Film->release_date)) : 'None') }}
                                </h5>
                            </div>

                            <div>
                                <label for="">Hash Tags</label>
                                <h5 class="margin">
                                    @if($Film->hash_tags != NULL)
                                        <?php
                                            $hash_tags_arr = explode(',', $Film->hash_tags);
                                        ?>
                                        @foreach($hash_tags_arr as $val)
                                            <p class="text-light-blue">{{ $val }}</p>
                                        @endforeach
                                    @endif
                                </h5>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Trailers</h3>
                    <div class="box-tools">
                        <button class="btn btn-sm btn-flat btn-primary js-trailer_add_form"><i class="fa fa-plus"></i> Add</button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="js-content_holder_trailer">
                        <table class="table table-bordered">
                            <tr>
                                <th>Show in Trailers Page</th>
                                <th>Image</th>
                                <th>URL</th>
                                <th>Actions</th>
                            </tr>
                            <tbody class="js-sortable_container">
                                @if($Film->trailers)
                                    @foreach($Film->trailers as $trailer)
                                        @if($trailer->trailer_show != 0)
                                            <tr data-id="{{$trailer->id}}">
                                                <td>
                                                    <label>
                                                        <input type="checkbox" class="minimal-green js-check_hide_show" {{ ($trailer->trailer_show == 1 ? 'checked' : '') }} > Show/Hide
                                                    </label>
                                                </td>
                                                <td><img class="media-object" width="64" height="64" src="{{ asset('content/film/trailers/' . $trailer->image_preview) }}" alt="..."></td>
                                                <td> <a href="{{$trailer->trailer_url}}" target="_blank">{{ str_limit($trailer->trailer_url, 60) }}</a></td>
                                                <td>
                                                    <!-- Single button -->
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Action <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a href="#" class="js-edit_trailer" data-id="{{ $trailer->id }}">Edit</a></li>
                                                            <li><a href="#" class="js-delete_trailer" data-id="{{ $trailer->id }}">Delete</a></li>
                                                            {{-- <li role="separator" class="divider"></li>
                                                            <li><a href="#">View</a></li> --}}
                                                        </ul>
                                                    </div>  
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div id="js-modal_holder"></div>
@endsection

@section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <!-- iCheck 1.0.1 -->
    <script src="{{ asset('cms/plugins/iCheck/icheck.min.js') }}"></script>
    <script>
        var order = [];
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-green, input[type="radio"].minimal-green').iCheck({
            checkboxClass: 'icheckbox_minimal-green',
            radioClass: 'iradio_minimal-red'
        });
        $('.js-sortable_container').sortable({ 
            tolerance: 'pointer',
            update : function (event, ui) {
                order = [];

                $('.js-sortable_container tr').each( function () {
                    var id = $(this).data('id');
                    order.push(id);
                });
                
                save_order(order, "{{ route('trailer_order_save') }}");
            }
        });

        $('body').on('ifChecked', '.js-check_hide_show', function (e) {

            var id = $(this).parents('tr').data('id');
            show_hide_toggle(1, id, "{{ route('show_hide_toggle') }}")
            
        })
        $('body').on('ifUnchecked', '.js-check_hide_show', function (e) {

            var id = $(this).parents('tr').data('id');
            show_hide_toggle(2, id, "{{ route('show_hide_toggle') }}")
        })
        
        
        $('body').on('click', '.js-trailer_add_form', function () {
            show_trailer_form_modal();
        });

        $('body').on('click', '.js-edit_trailer', function () {
            var id = $(this).data(id);
            show_trailer_form_modal(id);
        });

        function show_trailer_form_modal (id)
        {
            var data='';
            if (id == '')
            {
                data = {_token:"{{ csrf_token() }}" };
            }
            else
            {
                data = {_token:"{{ csrf_token() }}", trailer_id:id};
            }

            $.ajax({
                url : "{{ route('film_trailer_form_modal') }}",
                type : 'POST',
                data : data,
                success : function (data){
                    $('#js-modal_holder').html(data);
                    $('#trailer_form_modal').modal({keyboard : false, backdrop : 'static'});
                }
            });
        }

        $('body').on('click', '.js-delete_trailer', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            bootbox.confirm({
                title: "Confirm",
                message: "Are you sure you want to delete?",
                buttons: {
                    cancel: {
                        label: '<i class="fa fa-times"></i> Cancel'
                    },
                    confirm: {
                        label: '<i class="fa fa-check"></i> Confirm'
                    }
                },
                callback: function (result) {
                    if (result)
                    {
                        delete_record("{{ route('delete_trailer') }}", "{{ route('film_trailer_fetch_record', $Film->id) }}", $('.js-content_holder_trailer'), id);
                    }
                }
            });
        });

        $('body').on('submit', '#js-frm_trailer', function (e) {
            e.preventDefault();
            save_data($(this), "{{ route('save_trailer', $Film->id) }}", "{{ route('film_trailer_fetch_record', $Film->id) }}", $('.js-content_holder_trailer'));
        });

        $('body').on('click', '#js-sellsheet', function () {
            $('#image_preview').click();
        });
        
        $('body').on('change', '#image_preview', function () {
            $('#js-image_preview_text').val($('#image_preview').val().replace(/.*(\/|\\)/, ''));
        });

        function show_hide_toggle(is_show, id, show_hide_route)
        {
            
            $.ajax({
                url : show_hide_route,
                type : 'POST',
                dataType : 'JSON',
                data : {_token:'{{ csrf_token() }}', id:id, is_show:is_show},
                success : function (data) {
                    if (data.errCode == 1)
                    {
                        //var msg = data.message;
                        //show_message (msg, 'danger') 
                    }
                    else
                    {
                        //var msg = data.message;
                        //show_message (msg, 'success') 
                    }
                }
            });
        }

        function save_order (order, order_route)
        {
            if (order.length < 1)
            {
                var msg = 'No order has been change yet.';
                show_message (msg, 'warning') 
                return;
            }

            $.ajax({
                url : order_route,
                type : 'POST',
                dataType : 'JSON',
                data : {_token:'{{ csrf_token() }}', order:order},
                success : function (data) {
                    //var msg = 'Trailers successfully ordered.';
                    //show_message (msg, 'success') 
                }
            });
        }
    </script>
@endsection

