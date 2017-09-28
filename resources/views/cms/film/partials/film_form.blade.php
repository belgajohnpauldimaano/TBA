<div class="modal fade" id="js-film_form_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content box box-solid">
        <div class="overlay hidden">
            <i class="fa fa-refresh fa-spin"></i>
        </div>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"> {{ ($Film ? 'Update Film' : 'Add Film') }} </h4>
      </div>
      <form id="js-film_form" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ ($Film ? $Film->id : '') }}">
        <div class="modal-body">
                        <div class="pull-left"> 
                            <span class="text-red">All fields with an asterisk (*) are required.</span>
                        </div>
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
                        <label for="">English Title <span class="text-red"></span></label>
                        <input type="text" name="english_title" id="english_title" class="form-control" placeholder="Film English Title" value="{{ ($Film ? $Film->english_title : '') }}">
                        <div class="help-block text-center" id="english_title-error"></div>
                    </div>
                    
                    <div class="form-group">
                        <label for="">Genre/s <span class="text-red">*</span></label>
                        <span>Use a comma (,) to separate each genre.</span>
                        {{-- <input type="text" data-provide="typeahead" autoComplete="off" name="genre" id="genre" class="form-control typeahead" placeholder="Genre" value="{{ ($Film ? $Film->genre->genre : '') }}"> --}}
                        <input type="text" autoComplete="off" name="genre" id="genre" class="form-control tokenfield-typeahead" placeholder="" value="{{ ($Film ? $Film->genre : '') }}">
                        
                        <div class="help-block text-center" id="genre-error"></div>
                    </div>
                    
                    <div class="form-group">
                        <label for="">Running Time (in mins.)</label>
                        <input type="number" min="1" name="running_time" id="running_time" class="form-control" placeholder="Running Time" value="{{ ($Film ? $Film->running_time : '') }}">
                        <div class="help-block text-center" id="running_time-error"></div>
                    </div>

                    {{-- <div class="form-group">
                        <label for="">Synopsis</label>
                        <textarea name="synopsis" id="synopsis" cols="30" rows="7" class="form-control" placeholder="Film Synopsis">{{ ($Film ? $Film->synopsis : '') }}</textarea>
                        <div class="help-block text-center" id="synopsis-error"></div>
                    </div> --}}
                    
                    <div class="form-group">
                        <label for="">Release Status</label>
                        <select name="release_status" id="release_status" class="form-control">
                            <option value="">Choose applicable</option>
                            <?php array_shift($film_status); ?>
                            @foreach ($film_status as $key => $value)
                                @if($value != 'Current Line-up')
                                    <option value="{{ $key + 1 }}" {{ ($Film  ? ( $Film->release_status ==  ($key + 1) ? 'selected' : '') : '') }}>{{ $value }}</option>
                                @endif
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
                        <select name="rating" id="rating" class="form-control">
                            <option value="">Choose applicable</option>
                            @foreach($RATINGS as $key => $val)
                                @if($Film)
                                    <option value="{{$key}}" {{ ($Film->rating == $key ? 'selected' : '') }}>{{$val}}</option>
                                @else
                                    <option value="{{$key}}">{{$val}}</option>
                                @endif
                            @endforeach
                        </select>

                        <div class="help-block text-center" id="rating-error"></div>
                    </div>
                    <div class="form-group">
                        <label for="">Sell Sheet </label> <span class="text-red">(pdf file only)</span>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-btn">
                                    <input name="sellsheet" id="sellsheet"  type="file" class="file-input hidden">
                                    
                                    @if($Film)
                                        @if($Film->sell_sheet)
                                        <div class="js-button_sellsheet_container col-sm-10">
                                            <button type="button" id="js-sellsheet" class="btn btn-default btn-flat btn-sm btn-block">
                                                <i class="fa fa-file"></i>
                                                Click to upload sell sheet <span id="js-uploaded_file"> - <i>{{ ($Film ? ($Film->sell_sheet ? 'Has uploaded pdf file' : 'Not yet set') : 'Not yet set') }}</i></span>
                                            </button>
                                        </div>
                                        @else
                                            <button type="button" id="js-sellsheet" class="btn btn-default btn-flat btn-sm btn-block">
                                                <i class="fa fa-file"></i>
                                                Click to upload sell sheet <span id="js-uploaded_file"> - <i>{{ ($Film ? ($Film->sell_sheet ? 'Has uploaded pdf file' : 'Not yet set') : 'Not yet set') }}</i></span>
                                            </button>
                                        @endif
                                    @endif

                                    @if($Film)
                                        @if($Film->sell_sheet)
                                            <div class="col-sm-2">
                                                <a href="#"  data-delete-link="{{ route('delete_sellsheet', $Film->id) }}" data-id="{{ $Film->id }}" class="btn btn-flat btn-danger btn-sm js-remove_sellsheet"><i class="fa fa-trash"></i> remove</a>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="help-block text-center" id="sellsheet-error"></div>
                    </div>
                    
                    <div class="form-group">
                        <label for="">Hashtags</label>
                        <span>Use a comma (,) to separate each hashtag.</span>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-hashtag"></i>
                            </div>
                            <input type="text" name="hashtags" class="form-control input-sm typeahead  input-sm" id="hashtags" value="{{ ($Film ? $Film->hash_tags : '') }}" data-role="tagsinput" />
                            <div class="help-block text-center" id="hashtags-error"></div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="">Hashtag ID</label>
                        <input type="number" class="form-control" id="hash_id" name="hash_id" value="{{ ($Film ? $Film->hash_tag_id : '') }}">
                    </div>

                    
                    <div class="form-group">
                        <label for="">Facebook</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-facebook"></i>
                            </div>
                            <input type="text" name="facebook_link" id="facebook_link" class="form-control input-sm" placeholder="https://www.facebook.com/" value="{{ ($Film ? ( $Film->links != NULL ? $Film->links->facebook_url : '')  : '') }}">
                        </div>
                        <div class="help-block text-center" id="facebook_link-error"></div>
                    </div>
                    
                    <div class="form-group">
                        <label for="">Twitter</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-twitter"></i>
                            </div>
                            <input type="text" name="twitter_link" id="twitter_link" class="form-control input-sm" placeholder="https://twitter.com/" value="{{ ($Film ? ($Film->links ? $Film->links->twitter_url : '') : '') }}">
                        </div>
                        <div class="help-block text-center" id="twitter_link-error"></div>
                    </div>
                    
                    <div class="form-group">
                        <label for="">Instagram</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-instagram"></i>
                            </div>
                            <input type="text" name="instagram_link" id="instagram_link" class="form-control input-sm" placeholder="https://www.instagram.com/" value="{{ ($Film ? ( $Film->links ? $Film->links->instagram_url : '') : '') }}">
                        </div>
                        <div class="help-block text-center" id="instagram_link-error"></div>
                    </div>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-flat btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-flat btn-primary">Save changes</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    /*$("input[data-role=tagsinput]").tagsinput({
        tagClass: function(item) {
            return 'text-light-blue';
        
        }
    });*/

    $('.date-picker').datepicker({ autoClose:true });

    /*var dd = [
        {{--@if($Genre)
            @foreach ($Genre as $data)
                {value: '{{ $data->genre }}'},
            @endforeach
        @endif --}}
    ];*/
    
    var engine = new Bloodhound({
        local: [
            @if($Genre)
                @foreach ($Genre as $data)
                    {value: '{{ $data->genre }}'},
                @endforeach
            @endif 
        ],
        datumTokenizer: function(d) {
            return Bloodhound.tokenizers.whitespace(d.value);
        },
        queryTokenizer: Bloodhound.tokenizers.whitespace
    });

    engine.initialize();
    $('#genre').tokenfield({
        typeahead: [null, { source: engine.ttAdapter() }]
    });

    $('#hashtags').tokenfield();

    /*var dd = [
        @if($Genre)
            @foreach ($Genre as $data)
                '{{-- $data->genre --}}',
                {value: '{{ $data->genre }}'}
            @endforeach
        @endif 
    ];*/

    //$('.typeahead').typeahead({ source:dd });
    
</script>