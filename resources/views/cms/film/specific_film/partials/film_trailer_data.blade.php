                            <div class="overlay hidden">
                                <i class="fa fa-refresh fa-spin"></i>
                            </div>
                            <pre>{{ json_encode($Film->trailers, JSON_PRETTY_PRINT)}}</pre>
                            <table class="table table-bordered">
                                <tr>
                                    {{-- <th>Featured</th> --}}
                                    <th>Preview Image</th>
                                    <th>URL</th>
                                    <th>Action</th>
                                </tr>
                                <tbody aclass="js-sortable_container">
                                    {{-- @if($Film->trailers) --}}
                                        {{-- @foreach($Film->trailers as $trailer) --}}
                                            @if($Film->trailers)
                                                <tr data-id="{{$Film->trailers->id}}">
                                                    {{-- <td>
                                                        <label>
                                                            <input type="checkbox" class="minimal-green js-check_hide_show" {{ ($trailer->trailer_show == 1 ? 'checked' : '') }} > 
                                                        </label>
                                                    </td> --}}
                                                    <td><img class="media-object" width="160" height="90" src="{{ asset('content/film/trailers/' . $Film->trailers->image_preview) }}" alt="..."></td>
                                                    <td> <a href="{{$Film->trailers->trailer_url}}" target="_blank">{{ str_limit($Film->trailers->trailer_url, 60) }}</a> </td>
                                                    <td>
                                                        <!-- Single button -->
                                                        {{-- <div class="btn-group">
                                                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                Action <span class="caret"></span>
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <li><a href="#" class="js-edit_trailer" data-id="{{ $Film->trailers->id }}">Edit</a></li>
                                                                <li><a href="#" class="js-delete_trailer" data-id="{{ $Film->trailers->id }}">Delete</a></li>
                                                                <li role="separator" class="divider"></li>
                                                                <li><a href="#">View</a></li>
                                                            </ul>
                                                        </div>   --}}
                                                        <a class="btn btn-danger js-delete_trailer" data-id="{{ $Film->trailers->id }}">Delete</a>
                                                    </td>
                                                </tr>
                                            @endif
                                        {{-- @endforeach --}}
                                    {{-- @endif --}}
                                </tbody>
                            </table>