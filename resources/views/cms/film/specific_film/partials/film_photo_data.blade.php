                    <div class="overlay hidden">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
                    <div class="js-photo_container row ">
                        @if($Photo)
                            @foreach($Photo as $data)
                                <div class="col-xs-6 col-md-3">
                                    <div  data-id="{{ $data->id }}" class="thumbnail js-film_photo_item">
                                        <img alt="..." data-id="{{ $data->id }}" src="{{ asset('content/film/photos/' . $data->filename) }}" class=" margin">
                                        <span class="caption text-center">
                                        <h4>{{ $data->title }}</h4>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <script>
                        $('.js-photo_container').sortable({ 
                            tolerance: 'pointer',
                            update : function (event, ui) {
                                var photo_order = [];

                                $('.js-photo_container .thumbnail img').each( function () {
                                    var id = $(this).data('id');
                                    photo_order.push(id);
                                });
                                
                                save_order(photo_order, "{{ route('film_photo_order_save') }}");
                            }
                        });
                    </script>