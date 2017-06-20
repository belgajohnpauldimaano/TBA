                        <div class="overlay hidden">
                            <i class="fa fa-refresh fa-spin"></i>
                        </div>
                        <div class="js-dvd_container list-group">
                            @if($Dvd->count() > 0) 
                                 @foreach($Dvd as $data)
                                    <div class="col-xs-6 col-md-3">
                                        <div  data-id="{{ $data->id }}" class="thumbnail js-dvd_data">
                                            <img style="cursor:pointer" data-id="{{ $data->id }}" src="{{ asset('content/film/dvds/' . $data->dvd_case_cover) }}" class=" margin">
                                            <div class="caption">
                                                <h4>
                                                    @if ($data->name)
                                                        {{ $data->name }}
                                                    @else
                                                        No Title Yet
                                                    @endif
                                                </h4>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-xs-6">
                                                <button class="btn btn-flat btn-success btn-xs js-dvd_update btn-block" data-id="{{ $data->id }}">Edit</button>
                                                    </div>
                                                    <div class="col-xs-6">
                                                <button class="btn btn-flat btn-danger btn-xs js-dvd_delete btn-block" data-id="{{ $data->id }}">Delete</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-sm-12">
                                    <h5>No photo yet</h5>
                                </div>
                            @endif
                        </div>