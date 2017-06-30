                    <div class="overlay hidden">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
                    <div class="box-body">
                        @if ($Quotes)
                            @foreach($Quotes as $data)
                                <blockquote>
                                    <p>{{ $data->main_quote}}</p>
                                    <small>{{ $data->name_of_person }} <cite title="{{ $data->url }}"><a href="{{ $data->url }}" target="_blank">source</a></cite> | <button class="btn btn-xs btn-flat bg-olive js-edit_quote" data-id="{{ $data->id }}">Edit</button> <button class="btn btn-xs btn-flat bg-maroon js-delete_quote" data-id="{{ $data->id }}">Delete</button></small>
                                </blockquote>
                            @endforeach
                        @else
                            <h5>Not yet set</h5>
                        @endif
                    </div>