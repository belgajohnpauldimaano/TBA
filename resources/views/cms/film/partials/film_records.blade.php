                            <table class="table table-bordered">
                            <tr>
                                <th>Title</th>
                                <th>Genre</th>
                                <th>Running Time</th>
                                <th>Release Status</th>
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
                                            <td>{{ ($data->genre ? $data->genre->genre : 'No Genre') }}</td>
                                            <td>{{ $data->running_time }}</td>
                                            <td>{{ $data::RELEASE_STATUS[1] }}</td>
                                            <td>{{ Date('l, jS \of F Y', strtotime($data->release_date)) }}</td>
                                            <td>{{ $data->rating }}</td>
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
                                                    {{-- <li role="separator" class="divider"></li>
                                                    <li><a href="#">View</a></li> --}}
                                                </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7">No item found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>