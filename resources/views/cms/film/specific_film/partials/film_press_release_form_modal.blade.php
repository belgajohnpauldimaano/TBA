<div class="modal fade" id="js-film_press_release_form_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content box box-solid">
        <div class="overlay hidden">
            <i class="fa fa-refresh fa-spin"></i>
        </div>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Press Release</h4>
      </div>
      <form id="js-frm_press_release">
        <div class="modal-body">
            {{ csrf_field() }}
            <input type="hidden" name="press_release_id" value="{{ ($PressRelease ? $PressRelease->id : '') }}">
            <input type="hidden" name="film_id" value="{{ ($PressRelease ? $PressRelease->film_id : $film_id) }}">
            <div class="help-block text-center" id="general-error"></div>
            
            <div class="form-group">
                <label for="">Title <span class="text-danger">*</span></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-newspaper-o"></i>
                    </div>
                    <input type="text" name="press_release_title" id="press_release_title" class="form-control" value="{{ ($PressRelease ? $PressRelease->title : '') }}">
                    </div>
                <div class="help-block text-center" id="press_release_title-error"></div>
            </div>
            
            <div class="form-group">
                <label for="">Article Image Header</label>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-btn">
                            <input name="press_release_article_image" id="press_release_article_image"  type="file" class="file-input hidden">
                            <button type="button" id="js-press_release_article_image" class="btn btn-default btn-flat">
                                <i class="fa fa-image"></i>
                            </button>
                        </div>
                        <input type="text" class="form-control" id="js-text_press_release_article_image" disabled="true"  value="{{ ($PressRelease ? $PressRelease->article_image : '') }}">
                    </div>
                </div>
                <div class="help-block text-center" id="press_release_article_image-error"></div>
            </div>

            <div class="form-group">
                <label for="">Blurb <span class="text-danger">*</span></label>
                <textarea class="form-control" name="press_release_blurb" id="press_release_blurb" cols="30" rows="10">{{ ($PressRelease ? $PressRelease->blurb : '') }}</textarea>
                <div class="help-block text-center" id="press_release_blurb-error"></div>
            </div>
            
            <div class="form-group">
                <label for="">Full Content <span class="text-danger">*</span></label>
                <textarea class="form-control" name="press_release_content" id="press_release_content" cols="30" rows="15">{{ ($PressRelease ? $PressRelease->content : '') }}</textarea>
                <div class="help-block text-center" id="press_release_content-error"></div>
            </div>

        </div>
        <div class="modal-footer">
            <div class="pull-left">
                <p class="text-danger">All fields with asterisk(*) are required.</p>
            </div>
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btn-flat">Save</button>
            @if($PressRelease)
                <button type="submit" class="btn btn-danger btn-flat js-delete_press_release" data-id="{{ $PressRelease->id }}">Delete</button>
            @endif
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
