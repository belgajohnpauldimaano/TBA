@extends('layouts.main')

@section ('styles')
    <link rel="stylesheet" href="{{ asset('cms/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
    <link rel="stylesheet" href="{{ asset('cms/plugins/datepicker/datepicker3.css') }}">
@endsection

@section ('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Film</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-flat btn-sm btn-primary" id="js-btn_add">
                            <i class="fa fa-plus"></i> Add Film
                        </button>
                    </div>
                </div>

                <div class="box-body">
                    <div class="js-content_holder box" style="border-top:0">
                        <div class="overlay hidden">
                            <i class="fa fa-refresh fa-spin"></i>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-4">
                                <form id="frm_search_film">
                                    <label for="">Search</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="search" id="js-search_film" placeholder="search">
                                        <span class="input-group-btn">
                                            <button class="btn btn-flat btn-primary">Search</button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-8">
                                
                                <div class="pull-right">
                                    {{ $Film->links() }}
                                </div>
                            </div>
                        </div>
                        <br>
                        <table class="table table-bordered">
                            <tr>
                                <th>Title</th>
                                <th>Genre</th>
                                <th>Running Time</th>
                                <th>Release Status</th>
                                <th>Release Date</th>
                                <th>Rating</th>
                                <th>Synopsis</th>
                                <th>Actions</th>
                            </tr>
                            <tbody>
                                @if($Film->count() > 0)
                                    {{-- {{ json_encode($Film) }} --}}
                                    @foreach($Film as $data)
                                        <tr>
                                            <td>{{ $data->title }}</td>
                                            <td>{{ ($data->genre ? $data->genre->genre : 'No Genre') }}</td>
                                            <td>{{ $data->running_time }}</td>
                                            <td>{{ $data::RELEASE_STATUS[1] }}</td>
                                            <td>{{ Date('l, jS \of F Y', strtotime($data->release_date)) }}</td>
                                            <td>{{ $data->rating }}</td>
                                            <td>{{ str_limit($data->synopsis, $limit=20, $end = '...') }}</td>
                                            <td>
                                                <!-- Single button -->
                                                <div class="btn-group">
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a href="#" class="js-edit_film" data-id="{{ $data->id }}">Edit</a></li>
                                                    <li><a href="#" class="js-delete_film" data-id="{{ $data->id }}">Delete</a></li>
                                                    <li><a href="{{ route('specific_film_index', $data->id) }}" class="js-view_film" data-id="{{ $data->id }}">View</a></li>
                                                    {{-- <li role="separator" class="divider"></li>
                                                    <li><a href="#">View</a></li> --}}
                                                </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7">No item found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="pull-right">
                            {{ $Film->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="js-modal_holder"></div>
@endsection

@section ('scripts')
    <script src="{{ asset('cms/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('cms/plugins/Bootstrap-3-Typeahead/bootstrap3-typeahead.js') }}"></script>
    <script>

        $('body').on('click', '#js-btn_add', function () {
            load_film_form_modal();
        });
        
        $('body').on('click', '.js-edit_film', function () {
            var id = $(this).data('id');
            load_film_form_modal(id);
        });
        
        $('body').on('click', '#js-sellsheet', function () {
            $('#sellsheet').click();
        });
        $('body').on('change', '#sellsheet', function () {
            $('#js-sellsheet_text').val($('#sellsheet').val().replace(/.*(\/|\\)/, ''));
        });
        
        $('body').on('submit', '#js-film_form', function (e) {
            e.preventDefault();
            save_data($(this), "{{ route('save_film') }}", "{{ route('film_fetch_record') }}", $('.js-content_holder'));
        });
        
        $('body').on('click', '.js-delete_film', function (e) {
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
                        delete_record("{{ route('delete_film') }}", "{{ route('film_fetch_record') }}", $('.js-content_holder'), id);
                    }
                }
            });
        });
        
        $('body').on('change', '#js-search_film', function () {
            fetch_record_page_specific(1);
        });
        
        $('body').on('submit', '#frm_search_film', function (e) {
            e.preventDefault();
            //js-film_form_modal
            fetch_record_page_specific(1);
        });
        
        function fetch_record_page_specific (page)
        {
            var fetch_route = "{{ route('film_fetch_record') }}";
            var elem = $('.js-content_holder');
            $('.js-content_holder .overlay').removeClass('hidden');
            fetch_record(fetch_route, elem, page, 'frm_search_film');
        }

        /* Func Name : load_film_form_modal
         * Desc      : Load modal from ajax request
         * Params    : id - int
         * Return    : HTML element
         */
        function load_film_form_modal (id)
        {
            var data = {_token : '{{ csrf_token() }}'};
            if (id)
            {
                data = {_token : '{{ csrf_token() }}', id : id};
            }
            $.ajax({
                url : "{{ route('show_film_form') }}",
                type : 'POST',
                data : data,
                success : function (data) {
                    $('#js-modal_holder').html(data);
                    $('#js-film_form_modal').modal({keyboard : false, backdrop : 'static'});
                }
            });
        }

        /*function save_data (form, route, fetch_route, elem)
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
        });*/
    </script>
@endsection