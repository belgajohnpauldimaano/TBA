                    <div class="overlay hidden">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
                    <div class="js-poster_container row ">
                        @if($Poster)
                            @foreach($Poster as $data)
                                <div class="col-xs-6 col-md-3">
                                    <div href="#" data-id="{{ $data->id }}" class="thumbnail">
                                        <img alt="..." data-id="{{ $data->id }}" src="{{ asset('content/film/posters/' . $data->label) }}" style="cursor:pointer" class="js-image_item margin">
                                        @if($data->featured == 1)
                                            <span class="badge bg-red">Featured</span>
                                        @else
                                            <span class="">&nbsp;</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <script>
                        $('.js-poster_container').sortable({ 
                            tolerance: 'pointer',
                            update : function (event, ui) {
                                var poster_order = [];

                                $('.js-poster_container .thumbnail img').each( function () {
                                    var id = $(this).data('id');
                                    poster_order.push(id);
                                });
                                
                                save_order(poster_order, "{{ route('posters_order_save') }}");
                            }
                        });
                    </script>