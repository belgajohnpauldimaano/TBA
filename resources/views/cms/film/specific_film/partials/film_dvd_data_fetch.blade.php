<div class="overlay hidden">
                            <i class="fa fa-refresh fa-spin"></i>
                        </div>
                        <div class="btn-group">
                            <a href="#" id="list" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-th-list">
                            </span>List</a> <a href="#" id="grid" class="btn btn-default btn-sm"><span
                                class="glyphicon glyphicon-th"></span>Grid</a>
                        </div>
                        <div class="js-dvd_container list-group">
                            @if($Dvd->count() > 0) 
                                 @foreach($Dvd as $data)
                                 
                                    <div class="col-xs-6 col-md-4 item">
                                        <div class="thumbnail js-dvd_data" data-id="{{ $data->id }}">
                                            <img style="max-width:150px" class="group list-group-image" src="{{ asset('content/film/dvds/' . $data->dvd_case_cover) }}" alt="" />
                                            <div class="caption">
                                                <h4 class="group inner list-group-item-heading">
                                                    {{ $data->name }} <label for="" class="label label-warning pull-right"><i class="fa fa-clock-o"></i> {{ $data->running_time }} mins</label>
                                                </h4>
                                                <p class="group inner list-group-item-text">
                                                    {!! $data->description !!}   
                                                </p>
                                                <button class="btn btn-flat btn-success btn-xs js-dvd_update" data-id="{{ $data->id }}">Update</button>
                                                <button class="btn btn-flat btn-danger btn-xs js-dvd_delete" data-id="{{ $data->id }}">Delete</button>
                                                <div class="row">
                                                    <div class="col-xs-12 col-md-12">
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