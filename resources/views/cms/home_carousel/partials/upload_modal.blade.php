<div class="modal fade" id="js-image_uploader_modal" data-id="js-image_uploader_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Manage Photos</h4>
      </div>
      <div class="modal-body">
            <div class="form-group aa" id="upload-container">
                <input id="file-uploader" name="photo[]" class="" type="file" multiple data-preview-file-type="any">
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-flat btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    @if ($Carousel)
            @foreach($Carousel as $image)

            @endforeach
    @endif

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
        showCaption: false,
        browseClass: "btn btn-primary",
        fileType: "any",
        previewFileIcon: "<i class='glyphicon glyphicon-king'></i>",
        overwriteInitial: false,
        initialPreviewAsData: true,
        initialPreview: [
            @if ($Carousel)
                @foreach($Carousel as $image)
                    "{{ asset('content/carousel/') }}/{{$image->image}}",
                @endforeach
            @endif
        ],
        initialPreviewConfig: [
            @if ($Carousel)
                @foreach($Carousel as $image)
                    {caption: "{{ $image->caption }}", size: 329892, width: "120px", url: "{{ route('image_delete') }}", key: {{ $image->id }}, extra : { _token : "{{ csrf_token() }}" } },
                @endforeach
            @endif
        ],
        uploadExtraData: {_token: "{{ csrf_token() }}"},
        uploadUrl: "{{ route('image_upload_save') }}",
        showUploadedThumbs : false,
        dragIcon : '',
        dragClass : '',
        showClose : '',

    });
</script>