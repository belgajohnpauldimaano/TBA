                        
                        <div class="row">
                            <div class="col-sm-4">
                                <form id="frm_search_film">
                                    <label for="">Search</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="search" id="js-search_film" placeholder="search" value="{{ $request_data->search }}">
                                        <span class="input-group-btn">
                                            <button class="btn btn-flat btn-primary">Search</button>
                                        </span>
                                    </div>
                                </form>
                                <br>
                            </div>
                            <div class="col-sm-8">
                                
                                <div class="pull-right">
                                    {{ $Film->links() }}
                                </div>
                            </div>
                        </div>
                        <div class="overlay hidden">
                            <i class="fa fa-refresh fa-spin"></i>
                        </div>
                        <table class="table table-bordered">
                        <tr>
                            <th>Title</th>
                            <th>Genre/s</th>
                            <th>Running Time</th>
                            <th>Film Status</th>
                            <th>Release Date</th>
                            <th>Rating</th>
                            <th>Synopsis</th>
                            <th>Actions</th>
                        </tr>
                        <tbody>
                            @if($Film->count() > 0)
                                {{-- {{ json_encode($Film) }} --}}
                                @foreach($Film as $data)
                                    <tr>
                                        <td>{{ $data->title }}</td>
                                        <td>{{ $data->genre }}</td>
                                        <td>{{ ($data->running_time ? $data->running_time . ' mins.' : 'Not yet set')  }}</td>
                                        <td>{{ ($data->release_status ? $data::RELEASE_STATUS[$data->release_status] : 'Not yet set') }}</td>
                                        <td>{{ Date('l, jS \of F Y', strtotime($data->release_date)) }}</td>
                                        <td>{{ ( $data->rating ? $RATINGS[$data->rating] : 'Not yet set' ) }}</td>
                                        <td>{{ str_limit($data->synopsis, $limit=20, $end = '...') }}</td>
                                        <td>
                                            <!-- Single button -->
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a href="#" class="js-edit_film" data-id="{{ $data->id }}">Edit</a></li>
                                                    <li><a href="#" class="js-delete_film" data-id="{{ $data->id }}">Delete</a></li>
                                                    <li><a href="{{ route('specific_film_index', $data->id) }}" class="js-view_film" data-id="{{ $data->id }}">View</a></li>
                                                    <li><a href="#" class="js-quote_film" data-id="{{ $data->id }}">View Quote</a></li>
                                                    {{-- <li role="separator" class="divider"></li>
                                                    <li><a href="#">View</a></li> --}}
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8">No item found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="pull-right">
                        {{ $Film->links() }}
                    </div>