<div class="modal fade" id="js-film_quote_form_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content box box-solid">
        <div class="overlay hidden">
            <i class="fa fa-refresh fa-spin"></i>
        </div>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{{ ($Quote ? 'Update Quote' : 'Add Quote') }}</h4>
      </div>
      <form id="js-frm_quote">
        <div class="modal-body">
            {{ csrf_field() }}
            <input type="hidden" name="quote_id" value="{{ ($Quote ? $Quote->id : '') }}">
            <input type="hidden" name="film_id" value="{{ ($Quote ? $Quote->film_id : $film_id) }}">
            <div class="help-block text-center" id="general-error"></div>

            <div class="form-group">
                <label for="">Quote <span class="text-danger">*</span></label>
                <textarea class="form-control" name="main_quote" id="main_quote" cols="30" rows="10">{{ ($Quote ? $Quote->main_quote : '') }}</textarea>
                <div class="help-block text-center" id="main_quote-error"></div>
            </div>
            <div class="form-group">
                <label for="">Name of person quoting <span class="text-danger">*</span></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-user"></i>
                    </div>
                    <input type="text" name="person" id="person" class="form-control" value="{{ ($Quote ? $Quote->name_of_person : '') }}">
                    </div>
                <div class="help-block text-center" id="person-error"></div>
            </div>
            <div class="form-group">
                <label for="">URL <span class="text-danger"></span></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-link"></i>
                    </div>
                    <input type="text" name="url" id="url" class="form-control" value="{{ ($Quote ? $Quote->url : 'http://') }}">
                    </div>
                <div class="help-block text-center" id="url-error"></div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="pull-left">
                <p class="text-danger">All fields with asterisk(*) are required.</p>
            </div>
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btn-flat">Save changes</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->