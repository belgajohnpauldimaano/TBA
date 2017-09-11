<div class="modal fade" id="js-image_details" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content box box-solid">
        <div class="overlay hidden">
            <i class="fa fa-refresh fa-spin"></i>
        </div>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Photo Details</h4>
      </div>
                        <form id="carousel_image_details">
                            {{ csrf_field() }}
                            <input type="hidden" id="image_id" name="image_id" value="{{ $Carousel->id }}">
      <div class="modal-body">
            
            <div class="row">
                <div class="col-sm-12">
                    <div class="help-block text-center" id="general-error">
                    </div>
                    @if($Carousel)
                            <div class="form-group">
                                <label for="">
                                    Caption
                                </label>
                                <input type="text" name="caption" id="caption" class="form-control" value="{{ $Carousel->caption }}">
                                <div class="help-block text-center" id="caption-error"></div>
                            </div>
                            
                            <div class="form-group">
                                <label for="">
                                    Add URL
                                </label>

                                <div style="margin-bottom: 5px;">
                                    <label class="radio-inline">
                                        <input type="radio" name="inlineUrlOptions" id="youtubeUrl" value="youTube"> YouTube URL
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="inlineUrlOptions" id="websiteUrl" value="website"> Website URL
                                    </label>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="hidden" id="collpaseTarget">

                                    <div style="margin: 15px 0;">
                                        <label class="radio-inline">
                                            <input type="radio" name="openUrlOptions" id="openUrlNew" value="0" {{ $Carousel->new_window === 0 ? 'checked="checked"' : '' }}> Open URL in NEW Window
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="openUrlOptions" id="openUrlSame" value="1" {{ $Carousel->new_window === 1 ? 'checked="checked"' : '' }}> Open URL is SAME Window
                                        </label>
                                    </div>
                                </div>

                                <input type="text" name="url" id="url" class="form-control" value="{{ $Carousel->url }}" {{ $Carousel->url ? '' : 'disabled="disabled"'}}>
                                <span class="hidden data__url" data-url="{{ $Carousel->url }}"></span>
                                <div class="help-block text-center" id="url-error"></div>
                            </div>
                    @else
                        <div class="form-group has-error text-center">
                            <span class="help-block">Invalid Selection of Image.</span>
                        </div>
                    @endif
                </div>
            </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-flat btn-default" data-dismiss="modal">Close</button>
        @if($Carousel)
            <button type="submit" class="btn btn-flat btn-primary">Save changes</button>
        @endif
      </div>
                        </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->