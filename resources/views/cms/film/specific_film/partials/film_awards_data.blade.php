                    <div class="overlay hidden">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td>Image Title</td>
                                <td>Image Preview</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody class="js-awards_sortable_container">
                            @if($Award->count())
                                @foreach($Award as $data)
                                    <tr data-id="{{ $data->id }}">
                                        <td>{{ $data->award_name }}</td>
                                        <td> <img class="media-object" width="64" height="64" src="{{ asset('content/film/awards/' . $data->award_image) }}" alt="..."></td>
                                        <td>
                                            <!-- Single button -->
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a href="#" class="js-edit_award" data-id="{{ $data->id }}">Edit</a></li>
                                                    <li><a href="#" class="js-delete_award" data-id="{{ $data->id }}">Delete</a></li>
                                                    {{-- <li role="separator" class="divider"></li>
                                                    <li><a href="#">View</a></li> --}}
                                                </ul>
                                            </div>  
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @else
                            <tr>
                                <td colspan="3">No data found.</td>
                            </tr>
                        @endif
                    </table>
                    <script>
                        $('.js-awards_sortable_container').sortable({ 
                            tolerance: 'pointer',
                            update : function (event, ui) {
                                var award_order = [];

                                $('.js-awards_sortable_container tr').each( function () {
                                    var id = $(this).data('id');
                                    award_order.push(id);
                                });
                                
                                save_order(award_order, "{{ route('film_award_order_save') }}");
                            }
                        });
                    </script>