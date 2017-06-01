                            
                            <div class="overlay hidden">
                                <i class="fa fa-refresh fa-spin"></i>
                            </div>
                            <div class="row sortable-container">
                            
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
                            <script>
                                $('.sortable-container').sortable({ 
                                    tolerance: 'pointer',
                                    update : function (event, ui) {
                                        //console.log(event);

                                        $('.sortable-container div img').each( function () {
                                            var id = $(this).data('id');
                                            order.push(id);
                                        });
                                        //console.log(order);
                                        //console.log(ui);
                                    }
                                });
                            </script>