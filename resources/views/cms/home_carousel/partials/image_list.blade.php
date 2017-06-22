                            
                            <div class="overlay hidden">
                                <i class="fa fa-refresh fa-spin"></i>
                            </div>
                            <div class="row sortable-container">
                            
                                @if($Carousel)
                                    @foreach($Carousel as $image)
                                        <div class="col-xs-6 col-md-3">
                                            <div data-id="{{ $image->id }}" class="thumbnail js-image_item" style="cursor:pointer">
                                                <img data-id="{{ $image->id }}" src="{{ asset('content/carousel/') }}/{{$image->image}}" class="js-image_item margin">
                                                <span class="caption text-center">
                                                    @if($image->caption)
                                                        <h4>{{ $image->caption }}</h4>
                                                    @else
                                                        <h4>No caption added</h4>
                                                    @endif

                                                    <p>
                                                        @if($image->url)
                                                            <a href="{{ $image->url }}" target="_blank">Watch video</a>
                                                        @else
                                                            <p>No link added</p>
                                                        @endif
                                                    </p>
                                                </span>
                                            </div>
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