@extends('layouts.main')

@section ('styles')
    <link rel="stylesheet" href="{{ asset('cms/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.css') }}">
@endsection

@section ('page_title')
    Blog
@endsection

@section ('content')
    
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Blogs</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-flat btn-sm btn-primary" id="btn-add-blog">
                            <i class="fa fa-plus"></i> Add Blog
                        </button>
                    </div>
                </div>

                <div class="box-body">
                    <table class="table table-striped">
                        <tbody>
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Blurb</th>
                                    <th>Full Content</th>
                                    <th colspan="2">Action</th>
                                </tr>
                            </thead>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="js-modal_holder"></div>
@endsection

@section ('scripts')
    <script src="{{ asset('cms/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.js') }}"></script>

    <script>
        $('body').on('click', '#btn-add-blog', function () {
            load_form_modal_data();
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
    </script>
@endsection