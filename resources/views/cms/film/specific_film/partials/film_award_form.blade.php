<div class="modal fade" id="js-award_form_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content box box-solid">
        <div class="overlay hidden">
            <i class="fa fa-refresh fa-spin"></i>
        </div>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{{ ($Award ? 'Update Award' : 'Add Award') }}</h4>
      </div>
      <form id="js-frm_award">
        <div class="modal-body">
            {{ csrf_field() }}
            <input type="hidden" name="award_id" value="{{ ($Award ? $Award->id : '') }}">
            <div class="help-block text-center" id="general-error"></div>

            <div class="form-group">
                <label for="">Award Title</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-link"></i>
                    </div>
                    <input type="text" name="award_title" id="award_title" class="form-control" value="{{ ($Award ? $Award->award_name : '') }}" placeholder="Award Title">
                </div>
                <div class="help-block text-center" id="award_title-error"></div>
            </div>

            <div class="form-group">
                <label for="">Award Photo</label>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-btn">
                            <input name="award_image" id="award_image"  type="file" class="file-input hidden">
                            <button type="button" id="js-btn_award_image" class="btn btn-default btn-flat btn-block">
                                <i class="fa fa-image"></i>
                                Click to upload image 
                                <span id="js-text_award_image"> - <i>{{ ($Award ? 'Has uploaded file' : 'Not yet set') }}</i></span>
                            </button>
                        </div>
                        {{-- <input type="text" class="form-control" id="js-text_award_image" disabled="true"  value="{{ ($Award ? $Award->award_image : '') }}"> --}}
                    </div>
                </div>
                <div class="help-block text-center" id="award_image-error"></div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="pull-left">
                <p class="text-danger">*Image preview should atleast 200x200 dimension.</p>
            </div>
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btn-flat">Save changes</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->