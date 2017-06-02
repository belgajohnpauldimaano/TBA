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
                    <div class="js-content_holder">
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
            save_data($(this), "{{ route('save_film') }}", "{{ route('fetch_record') }}", $('#js-content_holder'));
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
                        delete_record("{{ route('delete_film') }}", "{{ route('fetch_record') }}", $('#js-content_holder'), id);
                    }
                }
            });
        });

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
                        fetch_record(fetch_route, elem, 1)
                    }
                }
            });
        }
        function fetch_record (route, elem, page)
        {
            $.ajax({
                url : route,
                type : 'POST',
                data : {_token : '{{ csrf_token() }}'},
                success     : function (data) {
                    $('.js-content_holder').html(data);
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
                        fetch_record(fetch_route, elem, 1)
                    }
                }
            });
        }
    </script>
@endsection