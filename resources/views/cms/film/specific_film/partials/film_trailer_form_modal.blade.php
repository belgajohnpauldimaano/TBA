<div class="modal fade" id="trailer_form_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{{ ($Trailer ? 'Update Trailer' : 'Add Trailer') }}</h4>
      </div>
      <form id="js-frm_trailer">
        <div class="modal-body">
            {{ csrf_field() }}
            <input type="hidden" name="trailer_id" value="{{ ($Trailer ? $Trailer->id : '') }}">
            <div class="help-block text-center" id="general-error"></div>

            <div class="form-group">
                <label for="">URL</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-link"></i>
                    </div>
                    <input type="text" name="url" id="url" class="form-control" value="{{ ($Trailer ? $Trailer->trailer_url : '') }}">
                </div>
                <div class="help-block text-center" id="url-error"></div>
            </div>

            <div class="form-group">
                <label for="">Image Preview</label>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-btn">
                            <input name="image_preview" id="image_preview"  type="file" class="file-input hidden">
                            <button type="button" id="js-sellsheet" class="btn btn-default btn-flat">
                                <i class="fa fa-image"></i>
                            </button>
                        </div>
                        <input type="text" class="form-control" id="js-image_preview_text" disabled="true"  value="{{ ($Trailer ? $Trailer->image_preview : '') }}">
                    </div>
                </div>
                <div class="help-block text-center" id="image_preview-error"></div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btn-flat">Save changes</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->