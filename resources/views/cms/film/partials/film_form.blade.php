<div class="modal fade" id="js-film_form_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"> {{ ($Film ? 'Update Film' : 'Add Film') }} </h4>
      </div>
      <form id="js-film_form">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ ($Film ? $Film->id : '') }}">
        <div class="modal-body">

            <div class="row">
                <div class="col-sm-12">

                    <div class="help-block text-center" id="general-error">
                        
                    </div>

                    <div class="form-group">
                        <label for="">Title <span class="text-red">*</span></label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Film Title" value="{{ ($Film ? $Film->title : '') }}">
                        <div class="help-block text-center" id="title-error"></div>
                    </div>
                    
                    <div class="form-group">
                        <label for="">Genre <span class="text-red">*</span></label>
                        <input type="text" data-provide="typeahead" name="genre" id="genre" class="form-control typeahead" placeholder="Genre" value="{{ ($Film ? $Film->genre->genre : '') }}">
                        <div class="help-block text-center" id="genre-error"></div>
                    </div>
                    
                    <div class="form-group">
                        <label for="">Running Time</label>
                        <input type="text" name="running_time" id="running_time" class="form-control" placeholder="Running Time" value="{{ ($Film ? $Film->running_time : '') }}">
                        <div class="help-block text-center" id="running_time-error"></div>
                    </div>

                    <div class="form-group">
                        <label for="">Synopsis</label>
                        <textarea name="synopsis" id="synopsis" cols="30" rows="7" class="form-control" placeholder="Film Synopsis">{{ ($Film ? $Film->synopsis : '') }}</textarea>
                        <div class="help-block text-center" id="synopsis-error"></div>
                    </div>
                    
                    <div class="form-group">
                        <label for="">Release Status</label>
                        <select name="release_status" id="release_status" class="form-control">
                            <option disabled>Select Release Status</option>
                            @foreach ($film_status as $key => $value)
                                <option value="{{ $key + 1 }}">{{ $value }}</option>
                            @endforeach
                        </select>
                        <div class="help-block text-center" id="release_status-error"></div>
                    </div>
                    
                    <div class="form-group">
                        <label for="">Release Date</label>
                        <input type="text" name="release_date" id="release_date" class="form-control date-picker" placeholder="mm/dd/yyyy" value="{{ ($Film ? Date('m/d/Y', strtotime($Film->release_date)) : '') }}">
                        <div class="help-block text-center" id="release_date-error"></div>
                    </div>

                    <div class="form-group">
                        <label for="">Rating</label>
                        <input type="text" name="rating" id="rating" class="form-control" placeholder="Rating" value="{{ ($Film ? $Film->rating : '') }}">
                        <div class="help-block text-center" id="rating-error"></div>
                    </div>

                    <div class="form-group">
                        <label for="">Sell Sheet </label> <span class="text-red">(pdf file only)</span>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-btn">
                                    <input name="sellsheet" id="sellsheet"  type="file" class="file-input hidden">
                                    <button type="button" id="js-sellsheet" class="btn btn-default btn-flat btn-sm">
                                        <i class="fa fa-file"></i>
                                    </button>
                                </div>
                                <input type="text" class="form-control input-sm" id="js-sellsheet_text" disabled="true"  value="{{ ($Film ? $Film->sell_sheet : '') }}">
                                <input type="hidden" name="hidCV" value="">
                            </div>
                        </div>
                        <div class="help-block text-center" id="sellsheet-error"></div>
                    </div>

                </div>
            </div>

        </div>
        <div class="modal-footer">
            <div class="pull-left"> <span class="text-red">fields with asterisk(*) are required.</span></div>
            <button type="button" class="btn btn-flat btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-flat btn-primary">Save changes</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    $('.date-picker').datepicker({ autoClose:true });
    var dd = [
        @if($Genre)
            @foreach ($Genre as $data)
                '{{ $data->genre }}',
            @endforeach
        @endif 
    ];

    $('.typeahead').typeahead({ source:dd });
</script>