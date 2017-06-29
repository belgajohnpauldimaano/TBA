<div class="modal fade" id="js-film_dvd_form_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content box box-solid">
        <div class="overlay hidden">
            <i class="fa fa-refresh fa-spin"></i>
        </div>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">DVD Details</h4>
      </div>
      <form id="js-frm_dvd" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="form-group">
                <div>
                    <p class="text-danger">All fields with asterisk(*) are required.</p>
                    <p class="text-danger">DVD Case Cover should be 300 x 500 pixels and PNG File only.</p>
                    <p class="text-danger">DVD Disc should be 300 x 300 pixels and PNG File only.</p>
                </div>
            </div>
            {{ csrf_field() }}
            <input type="hidden" name="dvd_id" value="{{ ($Dvd ? $Dvd->id : '') }}">
            <input type="hidden" name="film_id" value="{{ ($Dvd ? $Dvd->film_id : $film_id) }}">
            <div class="help-block text-center" id="general-error"></div>
            
            <div class="form-group">
                <label for="">DVD Name <span class="text-danger"></span></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-newspaper-o"></i>
                    </div>
                    <input type="text" name="dvd_name" id="dvd_name" class="form-control" value="{{ ($Dvd ? $Dvd->name : '') }}">
                    </div>
                <div class="help-block text-center" id="dvd_name-error"></div>
            </div>
            
            <div class="form-group">
                <label for="">DVD Case Cover <span class="text-danger">*</span></label>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-btn">
                            <input name="dvd_case_cover" id="dvd_case_cover"  type="file" class="file-input hidden">
                            <button type="button" id="js-dvd_button" class="btn btn-default btn-flat btn-block">
                                <i class="fa fa-image"></i>
                                Click to upload image
                                <span id="js-text_dvd_case_cover"> - <i>{{ ($Dvd ? 'Has uploaded file' : 'Not yet set') }}</i></span>
                            </button>
                        </div>
                        {{-- <input type="text" class="form-control" id="js-text_dvd_case_cover" disabled="true"  value="{{ ($Dvd ? $Dvd->dvd_case_cover : '') }}"> --}}
                    </div>
                </div>
                <div class="help-block text-center">
                </div>
                <div class="help-block text-center" id="dvd_case_cover-error"></div>
            </div>
            
            <div class="form-group">
                <label for="">DVD Disc Image <span class="text-danger">*</span></label>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-btn">
                            <input name="dvd_disc_image" id="dvd_disc_image"  type="file" class="file-input hidden">
                            <button type="button" id="js-dvd_button" class="btn btn-default btn-flat btn-block">
                                <i class="fa fa-image"></i>
                                Click to upload image
                                <span id="js-dvd_text"> - <i>{{ ($Dvd ? 'Has uploaded file' : 'Not yet set') }}</i></span>
                            </button>
                        </div>
                        {{-- <input type="text" class="form-control" id="js-dvd_text" disabled="true"  value="{{ ($Dvd ? $Dvd->dvd_disc_image : '') }}"> --}}
                    </div>
                </div>
                <div class="help-block text-center">
                </div>
                <div class="help-block text-center" id="dvd_disc_image-error"></div>
            </div>
            
            <div class="form-group">
                <label for="">Languages <span class="text-danger">*</span></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-language"></i>
                    </div>
                    <input type="text" name="dvd_languages" id="dvd_languages" class="form-control" value="{{ ($Dvd ? $Dvd->languages : '') }}">
                    </div>
                <div class="help-block text-center" id="dvd_languages-error"></div>
            </div>
            
            <div class="form-group">
                <label for="">Subtitles <span class="text-danger">*</span></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-newspaper-o"></i>
                    </div>
                    <input type="text" name="dvd_subtitles" id="dvd_subtitles" class="form-control" value="{{ ($Dvd ? $Dvd->subtitles : '') }}">
                    </div>
                <div class="help-block text-center" id="dvd_subtitles-error"></div>
            </div>
            
            <div class="form-group">
                <label for="">Running Time (Mins.) <span class="text-danger"></span></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-clock-o"></i>
                    </div>
                    <input type="number" min="1" name="dvd_running_time" id="dvd_running_time" class="form-control" value="{{ ($Dvd ? $Dvd->running_time : '') }}">
                    </div>
                <div class="help-block text-center" id="dvd_running_time-error"></div>
            </div>

            <div class="form-group js-wysiwyg_editor_holder">
                <label for="">Description <span class="text-danger"></span></label>
                <textarea class="form-control js-wysiwyg_editor_dvd" name="dvd_description" id="dvd_description" cols="30" rows="10">{{ ($Dvd ? $Dvd->description : '') }}</textarea>
                <div class="help-block text-center" id="dvd_description-error"></div>
            </div>

            <div class="form-group">
                <div class="material-switch ">
                    <strong class="margin">
                        Feature in Website
                    </strong>
                    <input id="film_dvd_featured_switch" name="film_dvd_featured_switch" type="checkbox" value="{{ ($Dvd->dvd_status == 1 ? 'true' : 'false') }}" {{ ($Dvd->dvd_status == 1 ? 'checked' : '') }} />
                    <label for="film_dvd_featured_switch" class="label-danger film_dvd_featured_switch_ui"></label>
                </div>
                <div class="help-block text-center" id="film_dvd_featured_switch-error"></div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btn-flat">Save</button>
            {{-- @if($Dvd)
                <button type="submit" class="btn btn-danger btn-flat js-delete_press_release" data-id="{{ $Dvd->id }}">Delete</button>
            @endif --}}
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
