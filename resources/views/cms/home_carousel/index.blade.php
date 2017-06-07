@extends('layouts.main')


@section ('styles')
    
    <link href="{{ asset('cms/plugins/kartik-v-bootstrap-fileinput/css/fileinput.css') }}" media="all" rel="stylesheet" type="text/css"/>
@endsection

@section ('content')
    <div class="row">
        <div class="col-sm-12">
            <ul class="timeline">
                <li>
                    <div class="timeline-item">
                        <span class="time">
                            
                        </span>
                        <h3 class="timeline-header">Home Page Carousel</h3>
                        <div class="timeline-body js-image_container box" style="border-top:0">
                            <div class="overlay hidden">
                                <i class="fa fa-refresh fa-spin"></i>
                            </div>
                            <div class="row sortable-container ">
                                @if($Carousel)
                                    @foreach($Carousel as $image)
                                        <div class="col-xs-6 col-md-3">
                                            <a href="#" class="thumbnail">
                                                <img data-id="{{ $image->id }}" src="{{ asset('content/carousel/') }}/{{$image->image}}" class="js-image_item margin">
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                        </div>

                        <div class="timeline-footer">
                            <button class="btn btn-flat btn-primary" id="js-show_modal_uploader">Manage Uploads</button>
                            <button class="btn btn-flat btn-primary js-reorder_toggle" data-type="1" id="js-save_reorder_image">Save Reorder</button>
                        </div>
                    </div>
                </li>
            </ul>

            <div class="row">
                <div class="col-sm-12 conatiner">

                    <div class="callout callout-success">
                        <h4>Note</h4>
                        <p>Double click image to manage details.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

    <div id="js-modal_holder"></div>
@endsection

@section ('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <script src="{{ asset('cms/plugins/kartik-v-bootstrap-fileinput/js/fileinput.js') }}" type="text/javascript"></script>
    <script>
        var order = [];
        $('.sortable-container').sortable({ 
            tolerance: 'pointer',
            update : function (event, ui) {
                $('.sortable-container div img').each( function () {
                    var id = $(this).data('id');
                    order.push(id);
                });
            }
        });
        $('body').on('click', '#js-save_reorder_image', function () {
            if(order.length < 1)
            {
                var msg = 'No order has been change yet.';
                show_message (msg, 'warning') 
                return;
            }
            $.ajax({
                url : "{{ route('image_ordering') }}",
                type : 'POST',
                data : {_token : '{{ csrf_token() }}', order : order},
                success : function (data) {
                    console.log(data);
                }
            });

            show_message ('Order successfully arranged.', 'success') 
        })
        $('body').on('dblclick', '.js-image_item', function () {
            var id = $(this).data('id');
            $('.js-image_container .overlay').removeClass('hidden');
            $.ajax({
                url : "{{ route('image_detail_modal') }}",
                type : 'POST',
                data : {_token : '{{ csrf_token() }}', id : id},
                success : function (data) {
                    $('#js-modal_holder').append(data);
                    $('#js-image_details').modal({ keyboard : false, backdrop : 'static' });
                    $('.js-image_container .overlay').addClass('hidden');
                }
            });
        });

        $('body').on('click', '#js-show_modal_uploader', function () {
            $.ajax({
                url : "{{ route('image_uploader_modal') }}",
                type : 'POST',
                data : {  _token : '{{ csrf_token() }}'},
                success : function (data) {
                    $('#js-modal_holder').append(data);
                    $('#js-image_uploader_modal').modal({ keyboard : false, backdrop : 'static' });
                }
            });
        });

        $('body').on('submit', '#carousel_image_details', function (e) {
            e.preventDefault();

            var formData = new FormData( $(this)[0] );
            
            $('#carousel_image_details').parents('.box').children('.overlay').removeClass('hidden');
            $.ajax({
                url : "{{ route('save_image_details') }}",
                type : 'POST',
                dataType : 'JSON',
                data        : formData,
                processData : false,
                contentType : false,
                success : function (data) {
                    
                    $('.help-block').empty();
                    $('.form-group').removeClass('has-error');

                    $('#carousel_image_details').parents('.box').children('.overlay').addClass('hidden');
                    if(data.errCode == 1)
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
                    else
                    {
                        show_message (data.messages, 'success');
                        $('#js-image_details').modal('hide');
                    }
                }
            });
        });

        

        $('body').on('hidden.bs.modal', '#js-image_uploader_modal', function (e) {
            image_list();
        })
        
    </script>
@endsection