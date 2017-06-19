<div class="modal fade" id="js-film_photo_multi_upload_form_modal" data-id="js-film_photo_multi_upload_form_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Photo Details</h4>
      </div>
        <form id="carousel_image_details">
            {{ csrf_field() }}
        {{-- <input type="hidden" id="image_id" name="image_id" value="{{ $Carousel->id }}"> --}}
            <div class="modal-body">
            
                <div class="row">
                    <div class="col-sm-12">
                        <div class="help-block text-center" id="general-error">
                        </div>
                    </div>
                </div>

                <div class="form-group aa" id="upload-container">
                    <input id="file-uploader" name="image_filename" class="" type="file" multiple data-preview-file-type="any">
                </div>
            </div>    
            <div class="modal-footer">
                <button type="button" class="btn btn-flat btn-default" data-dismiss="modal">Close</button>
            </div>
        </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script>

    $('#file-uploader').on('filezoomhidden', function(event, params) {
        console.log('File zoom show ', params.sourceEvent, params.previewId, params.modal);
        if(!$('body').hasClass('modal-open'))
        {
            $('body').addClass('modal-open');
        }
    });


    $('#file-uploader').on('fileimagesloaded', function(event, previewId) {
        console.log("fileimageloaded");
        $('.file-drag-handle').remove();
    });
    $("#file-uploader").fileinput({
        //showUpload: false,
        //maxImageWidth: 1200,
        //minImageWidth: 600,
        showCaption: false,
        browseClass: "btn btn-primary",
        fileType: "image",
        allowedFileExtensions : ['jpg', 'png'],
        allowedFileTypes : ['image'],
        allowedPreviewTypes : ['image'],
        previewFileIcon: "<i class='glyphicon glyphicon-file'></i>",
        overwriteInitial: false,
        initialPreviewAsData: true,
        initialPreview: [
            @if ($Photo)
                @foreach($Photo as $image)
                    "{{ asset('content/film/photos/') }}/{{$image->filename}}",
                @endforeach
            @endif
        ],
        initialPreviewConfig: [
            @if ($Photo)
                @foreach($Photo as $image)
                    {caption: "", size: 0, width: "120px", url: "{{ route('photo_single_delete') }}", key: {{ $image->id }}, extra : { _token : "{{ csrf_token() }}", id : {{ $image->id }}, film_id : {{ $image->film_id }} } },
                @endforeach
            @endif
        ],
        uploadExtraData: {_token: "{{ csrf_token() }}", film_id : {{ $film_id }}, upload_type : 1},
        uploadUrl: "{{ route('film_photo_single_save', $film_id) }}",
        showUploadedThumbs : false,
        dragIcon : '',
        dragClass : '',
        showClose : '',
        maxFileCount: 10,
        browseOnZoneClick: true,
        maxFileSize : 2048,
        msgSizeTooLarge : 'File should not exceeds 2MB in size.'
    });
</script>