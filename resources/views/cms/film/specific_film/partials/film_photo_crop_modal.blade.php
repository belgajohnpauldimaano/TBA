<div class="modal fade" id="js-film_photo_crop_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content box box-solid">
        <div class="overlay hidden">
            <i class="fa fa-refresh fa-spin"></i>
        </div>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Crop Film Photo</h4>
      </div>
      <form id="js-frm_film_photo_crop">
        <div class="modal-body">
            <input type="hidden" name="film_id" value="{{ $Photo->film_id }}">
            <input type="hidden" name="photo_id" value="{{ $Photo->id }}">
            {{ csrf_field() }}
            {{-- <div class="thumbnail">
                  <img id="film_photo" src="http://127.0.0.1/TBA/public/content/film/photos/uo2GnCOnpGfEOt9hNqWPONMQthV5F4lfNTKYdwLZHnN5N7GrrHpOvNiv8cVZL5GBlaS6eIUPyLu2hNSmZq1SMzYrGFAxo4ofAwop.jpg" alt="">
              
            </div> --}}
            <div class="thumbnail">
              <img id="film_photo" src="{{ asset('content/film/photos/' . $Photo->filename) }}">
            </div>
            <div class="preview">
              <div src="" alt="" class="img-preview"></div>
            </div>
        </div>
        <div class="modal-footer">
            {{-- <div class="pull-left">
                <p class="text-danger">*Image preview should atleast 1600x900 dimension.</p>
            </div> --}}
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btn-flat">Save</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
