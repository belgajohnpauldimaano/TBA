@extends('layouts.main')

@section ('styles')
    <link rel="stylesheet" href="{{ asset('cms/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.css') }}">
    <link rel="stylesheet" href="{{ asset('cms/plugins/datepicker/datepicker3.css') }}">
@endsection

@section ('page_title')
    Announcement
@endsection

@section ('content')
    
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Announcements</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-flat btn-sm btn-primary" id="btn-add-blog">
                            <i class="fa fa-plus"></i> Add Announcement
                        </button>
                    </div>
                </div>

                <div class="box-body">
                    <div class="row">
                        <form id="frm_search_blog">
                            <div class="col-sm-4">
                                    <label for="">Search</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" autofocus name="search" id="js-search_film" placeholder="search">
                                        <span class="input-group-btn">
                                            <button class="btn btn-flat btn-primary">Search</button>
                                        </span>
                                    </div>
                            </div>
                            <div class="form-group col-sm-3 pull-right">
                                
                                <label for="">Number per page</label>
                                <select name="per_page" class="form-control" id="per_page">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="30">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div> 
                        </form>
                    </div>

                    <div class="table_blog_holder">
                        <table class="table table-striped">
                            <tbody>
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Blurb</th>
                                        <th>Date Created</th>
                                        <th>Date Updated</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($Blog->count() > 0)
                                        @foreach($Blog as $data)
                                            <tr>
                                                <td>{{ $data->title }}</td>
                                                <td>{!! $data->blurb !!}</td>
                                                <td>{!! $data->created_at !!}</td>
                                                <td>{!! $data->updated_at !!}</td>
                                                <td>
                                                    <!-- Single button -->
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Action <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-right dropdown-menu__action">
                                                            <li><a href="#" class="btn-edit-blog" data-id="{{ $data->id }}">Update Details</a></li>
                                                            <li role="separator" class="divider"></li>
                                                            <li><a href="#" class="js-delete_film" data-id="{{ $data->id }}">Delete</a></li>
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
                            </tbody>
                        </table>

                        <div class="clearfix">
                            <div class="pull-right">
                                {{ $Blog->links() }}
                            </div>
                        </div>
                        {{-- <pre>{{ json_encode($Blog, JSON_PRETTY_PRINT)}}</pre> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="js-modal_holder"></div>
@endsection

@section ('scripts')
    <script src="{{ asset('cms/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.js') }}"></script>
    <script src="{{ asset('cms/plugins/datepicker/bootstrap-datepicker.js') }}"></script>

    <script>
        $('body').on('click', '#btn-add-blog', function () {
            load_form_modal_data();
        });
        
        $('body').on('click', '.btn-edit-blog', function () {
            var id = $(this).data('id');
            //console.log(id);
            load_form_modal_data(id);
        });

        function load_form_modal_data (id)
        {
            var data = {_token : '{{ csrf_token() }}'};
            if (id)
            {
                data = {_token : '{{ csrf_token() }}', id : id};
            }
            $.ajax({
                url : '{{ route('show_modal_form_data') }}',
                type : 'POST',
                data : data,
                success : function (data) {
                    $('#js-modal_holder').html(data);
                    $('#modal_add_data').modal({keyboard : false, backdrop : 'static'});

                    $("#press_release_blurb, #press_release_content").wysihtml5({
                        toolbar: {
                            "font-styles": true, // Font styling, e.g. h1, h2, etc.
                            "emphasis": true, // Italics, bold, etc.
                            "lists": true, // (Un)ordered lists, e.g. Bullets, Numbers.
                            "html": false, // Button which allows you to edit the generated HTML.
                            "link": false, // Button to insert a link.
                            "image": false, // Button to insert an image.
                            "color": false, // Button to change color of font
                            "blockquote": true, // Blockquote
                            "size":'sm' // options are xs, sm, lg
                        }
                    });

                }
                // ,error : function (xhr, ajaxOptions, thrownError)
                // {
                //     if (thrownError == 'Unauthorized')
                //     {
                //         window.location.reload();
                //     }
                // },
                // statusCode: {
                //     500: function(xhr) {
                //         window.location.reload();
                //     }
                // }
            });
        }

        $('body').on('submit', '#js_frm_blog', function (e) {
            e.preventDefault();
            save_data($(this), "{{ route('save_blog') }}", "{{ route('fetch') }}", $('.table_blog_holder'));
        });
        
        $('body').on('click', '#js-press_release_article_image', function (e) {
            e.preventDefault();
            $('#press_release_article_image').click();
        });

        $('body').on('change', '#press_release_article_image', function () {
            $('#js-text_press_release_article_image').html('<i>' + $('#press_release_article_image').val().replace(/.*(\/|\\)/, '') + '</i>');
        });

        function fetch_record_page_specific (page)
        {
            var fetch_route = "{{ route('fetch') }}";
            var elem = $('.table_blog_holder');
            //$('.js-content_holder .overlay').removeClass('hidden');
            fetch_record(fetch_route, elem, page, 'frm_search_blog');
        }

        $('body').on('click', '.js-delete_film', function (e) {
            e.preventDefault();

            var id = $(this).data('id');
            bootbox.confirm({
                message: "Are you sure you want to delete press release details?",
                buttons: {
                    confirm: {
                        label: 'Yes',
                        className: 'btn-danger btn-flat'
                    },
                    cancel: {
                        label: 'No',
                        className: 'btn-default btn-flat'
                    }
                },
                callback: function (result) {
                    if(result)
                    {
                        $.ajax({
                            url : "{{ route('delete_blog') }}",
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
                                    $('#modal_add_data').modal('hide');
                                    fetch_record("{{ route('fetch', 0) }}", $('.table_blog_holder'), 1, '');
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
                    setTimeout(function(){
                        var modal_count = $('.modal-dialog').length;
                        if(modal_count > 0)
                        {
                            $('body').addClass('modal-open');
                        }
                    }, 500);  
                }
            });
        }); 

        $('body').on('change', '#press_release_id_select', function() {
            if ($(this).val() === '' || $(this).val() === '0') {
                $('#collapse_press_release_source').collapse('hide');
            } else {
                $('#collapse_press_release_source').collapse('show');
            }
        });

        // $('body').on('change', '#press_release_film_select', function() {
        //     if ($(this).val() == "") {
        //         $('.press_release__film__related').val(2);
        //     } else {
        //         $('.press_release__film__related').val($(this).val());
        //     }
        // });
    </script>
@endsection