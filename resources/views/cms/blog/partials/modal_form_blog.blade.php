
<div class="modal fade" id="modal_add_data" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content box box-solid">
        <div class="overlay hidden">
            <i class="fa fa-refresh fa-spin"></i>
        </div>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Announcement</h4>
      </div>
      <form id="js_frm_blog">
        <div class="modal-body">
            {{ csrf_field() }}
            <input type="hidden" name="press_release_id" value="{{ ($Blog ? $Blog->id : '') }}">
            <input type="hidden" name="film_id" value="{{ ($Blog ? $Blog->film_id : 0) }}">
            <div class="help-block text-center" id="general-error"></div>
            
            {{-- <select class="form-control">
                <option value="0">Select Article Catergory</option>
                <option value="0">General Article</option>
                <option value="1">Film-Related Article</option>
            </select>
            
            <hr> --}}

            <div class="form-group">
                <label for="">Title <span class="text-danger">*</span></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-newspaper-o"></i>
                    </div>
                    <input type="text" name="press_release_title" id="press_release_title" class="form-control" value="{{ ($Blog ? $Blog->title : '') }}">
                    </div>
                <div class="help-block text-center" id="press_release_title-error"></div>
            </div>
            
            <div class="form-group">
                <label for="">Article Image Header</label>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-btn">
                            <input name="press_release_article_image" id="press_release_article_image"  type="file" class="file-input hidden">
                            <button type="button" id="js-press_release_article_image" class="btn btn-default btn-flat btn-block">
                                <i class="fa fa-image"></i>
                                Click to upload image
                                <span id="js-text_press_release_article_image"> - <i>{{ ($Blog ? 'Has uploaded file' : 'Not yet set') }}</i></span>
                            </button>
                        </div>
                        {{-- <input type="text" class="form-control" id="js-text_press_release_article_image" disabled="true"  value="{{ ($Blog ? $Blog->article_image : '') }}"> --}}
                    </div>
                </div>
                <div class="help-block text-center" id="press_release_article_image-error"></div>
            </div>

            <div class="form-group">
                <label for="">Blurb <span class="text-danger">*</span></label>
                <textarea class="form-control" name="press_release_blurb" id="press_release_blurb" cols="30" rows="10">{{ ($Blog ? $Blog->blurb : '') }}</textarea>
                <div class="help-block text-center" id="press_release_blurb-error"></div>
            </div>
            
            <div class="form-group">
                <label for="">Full Content <span class="text-danger">*</span></label>
                <textarea class="form-control" name="press_release_content" id="press_release_content" cols="30" rows="15">{{ ($Blog ? $Blog->content : '') }}</textarea>
                <div class="help-block text-center" id="press_release_content-error"></div>
            </div>

        </div>
        <div class="modal-footer">
            <div class="pull-left">
                <p class="text-danger">All fields with asterisk(*) are required.</p>
            </div>
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btn-flat">Save</button>
            @if($Blog)
                <button type="submit" class="btn btn-danger btn-flat js-delete_press_release" data-id="{{ $Blog->id }}">Delete</button>
            @endif
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->