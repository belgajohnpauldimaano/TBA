<div class="modal fade" id="js-film_photo_single_form_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content box box-solid">
        <div class="overlay hidden">
            <i class="fa fa-refresh fa-spin"></i>
        </div>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{{ ($Photo ? 'Update Photo' : 'Add Photo') }}</h4>
      </div>
      <form id="js-frm_film_photo">
        <div class="modal-body">
            {{ csrf_field() }}
            <input type="hidden" name="photo_id" value="{{ ($Photo ? $Photo->id : '') }}">
            <div class="help-block text-center" id="general-error"></div>

            <div class="form-group">
                <label for="">Photo Title</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-link"></i>
                    </div>
                    <input type="text" name="title" id="title" class="form-control" value="{{ ($Photo ? $Photo->title : '') }}">
                </div>
                <div class="help-block text-center" id="title-error"></div>
            </div>

            <div class="form-group">
                <label for="">Image Preview</label>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-btn">
                            <input name="image_filename" id="image_filename"  type="file" class="file-input hidden">
                            <button type="button" id="js-btn_image_filename" class="btn btn-default btn-flat">
                                <i class="fa fa-image"></i>
                            </button>
                        </div>
                        <input type="text" class="form-control" id="js-text_image_filename" disabled="true"  value="{{ ($Photo ? $Photo->filename : '') }}">
                    </div>
                </div>
                <div class="help-block text-center" id="image_filename-error"></div>
            </div>
            <div class="form-group">
                <label>
                  <input type="checkbox" name="film_photo_featured" id="film_photo_featured" class="minimal-red" value="{{ ($Photo->featured == 1 ? 'true' : '') }}" {{ ($Photo->featured == 1 ? 'checked' : '') }}> Set as Featured Film Photo
                </label>
                <div class="help-block text-center" id="title-error"></div>
            </div>

        </div>
        <div class="modal-footer">
            {{-- <div class="pull-left">
                <p class="text-danger">*Image preview should atleast 1600x900 dimension.</p>
            </div> --}}
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btn-flat">Save</button>
            @if($Photo)
                <button type="submit" class="btn btn-danger btn-flat js-photo_delete" data-id="{{$Photo->id}}">Delete</button>
            @endif
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass: 'iradio_minimal-red'
    });
</script>