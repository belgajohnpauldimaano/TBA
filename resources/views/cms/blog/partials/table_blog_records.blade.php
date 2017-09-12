
                        <table class="table table-striped">
                            <tbody>
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Blurb</th>
                                        <th>Category</th>
                                        <th>Date Created</th>
                                        <th>Date Updated</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($Blog->count() > 0)
                                        @foreach($Blog->where('film_id', '<=', 0) as $data)
                                            <tr>
                                                <td>{{ $data->title }}</td>
                                                <td>{!! $data->blurb !!}</td>
                                                <td width="150">
                                                    {!! $data->film_id === 0 ? '<label class="label bg-purple">Latest News</label>' : '<label class="label bg-primary">Company News</label>' !!}
                                                </td>
                                                <td>{!! $data->created_at !!}</td>
                                                <td>{!! $data->updated_at !!}</td>
                                                <td>
                                                    <!-- Single button -->
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Action <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-right dropdown-menu__action">
                                                            <li><a href="#" class="btn-edit-blog" data-id="{{ $data->id }}">Update Details</a></li>
                                                            <li role="separator" class="divider"></li>
                                                            <li><a href="#" class="js-delete_film" data-id="{{ $data->id }}">Delete</a></li>
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
                            </tbody>
                        </table>

                        <div class="clearfix">
                            <div class="pull-right">
                                {{ $Blog->links() }}
                            </div>
                        </div>
                        {{-- <pre>{{ json_encode($Blog, JSON_PRETTY_PRINT)}}</pre> --}}