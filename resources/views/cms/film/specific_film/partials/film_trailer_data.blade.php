                                <div class="overlay hidden">
                                    <i class="fa fa-refresh fa-spin"></i>
                                </div>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Featured</th>
                                        <th>Preview Image</th>
                                        <th>URL</th>
                                        <th>Actions</th>
                                    </tr>
                                    <tbody class="js-sortable_container">
                                        @if($Trailer)
                                            @foreach($Trailer as $trailer)
                                                @if($trailer->trailer_show != 0)
                                                    <tr data-id="{{$trailer->id}}">
                                                        <td>
                                                            <label>
                                                                <input type="checkbox" class="minimal-green js-check_hide_show" {{ ($trailer->trailer_show == 1 ? 'checked' : '') }} > 
                                                            </label>
                                                        </td>
                                                        <td><img class="media-object" width="160" height="90" src="{{ asset('content/film/trailers/' . $trailer->image_preview) }}" alt="..."></td>
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
                                <script>
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
                                </script>