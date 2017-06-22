                        
                        
                        <div class="overlay hidden">
                            <i class="fa fa-refresh fa-spin"></i>
                        </div>
                        <table class="table table-bordered">
                        <tr>
                            <th>Title</th>
                            <th>Genre/s</th>
                            <th>Running Time</th>
                            <th>Release Status</th>
                            <th>Release Date</th>
                            <th>Rating</th>
                            {{-- <th>Synopsis</th> --}}
                            <th>Actions</th>
                        </tr>
                        <tbody>
                            @if($Film->count() > 0)
                                @foreach($Film as $data)
                                    <tr>
                                        <td>
                                            @if($request['search'])
                                                @if(substr_count(strtolower($data->title ),strtolower($request['search'])) == 0)
                                                    {{ $data->title }}
                                                @else
                                                    {!! str_ireplace($request['search'], "<span class='label bg-maroon'><strong>".($request['search'])."</strong></span>", $data->title) !!}
                                                @endif
                                            @else
                                                {{ $data->title }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($request['search'])
                                                @if(substr_count(strtolower($data->genre ),strtolower($request['search'])) == 0)
                                                    {{ $data->genre }}
                                                @else
                                                    {!! str_ireplace($request['search'], "<span class='label bg-maroon'><strong>".($request['search'])."</strong></span>", $data->genre) !!}
                                                @endif
                                            @else
                                                {{ $data->genre }}
                                            @endif
                                        </td>
                                        <td>{{ ($data->running_time ? $data->running_time . ' mins.' : 'Not yet set')  }}</td>
                                        <td>
                                            @if ($data->release_status)
                                                    <label class="label {{ App\Film::RELEASE_STATUS_STYLE[$data->release_status] }}">
                                                    {{ $data::RELEASE_STATUS[$data->release_status] }}
                                                </label>
                                            @else
                                                <label for="" class="label label-default">Not yet set</label>
                                            @endif
                                        </td>
                                        <td>{{ ($data->release_date ? Date('m-d-Y', strtotime($data->release_date)) : 'Not yet set') }}</td>
                                        <td>
                                            @if ($data->rating)
                                                <label class="label {{ App\Film::RATING_STYLE[$data->rating] }}">
                                                    {{ $RATINGS[$data->rating] }}
                                                </label>
                                            @else
                                                <label for="" class="label label-default">Not yet set</label>
                                            @endif
                                        </td>
                                        {{-- <td>{{ str_limit($data->synopsis, $limit=20, $end = '...') }}</td> --}}
                                        <td>
                                            <!-- Single button -->
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default dropdown-toggle btn-flat" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right dropdown-menu__action">
                                                    <li><a href="#" class="js-edit_film" data-id="{{ $data->id }}">Update Basic Info</a></li>
                                                    <li><a href="{{ route('specific_film_index', $data->id) }}" class="js-view_film" data-id="{{ $data->id }}">View & Update Details</a></li>
                                                    <li role="separator" class="divider"></li>
                                                    <li><a href="#" class="js-delete_film" data-id="{{ $data->id }}">Delete</a></li>
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