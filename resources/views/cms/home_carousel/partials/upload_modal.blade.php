<div class="modal fade" id="js-image_uploader_modal" data-id="js-image_uploader_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Manage Photos</h4>
      </div>
      <div class="modal-body">
            <div class="callout callout-success">
                <h4>Instructions</h4>
                <li>Click the TRASH Icon to delete a Carousel Image</li>
                <li>To add a new Carousel Image, click the ADD CAROUSEL IMAGE Button below</li>
            </div>  
            <div class="form-group aa" id="upload-container">
                <input id="file-uploader" name="photo" class="" type="file" data-allowedFileExtensions='["jpg", "png"]' multiple >
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
        minImageWidth: 1600,
        minImageHeight: 900,
        showCaption: false,
        browseClass: "btn btn-primary",
        fileType: "image",
        allowedFileExtensions : ["jpg", "png"],
        allowedFileTypes : ['image'],
        allowedPreviewTypes : ['image'],
        previewFileIcon: "<i class='glyphicon glyphicon-file'></i>",
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
        browseLabel : 'Add Carousel Image',
        msgImageWidthSmall: 'Image must be 1600 x 900 pixels (width x height)',
        msgImageHeightSmall: false,
        showRemove: false,
        showUpload: false,
        dragIcon : '',
        dragClass : '',
        showClose : '',
        maxFileCount: 10,
        browseOnZoneClick: true,
        maxFileSize : 1024,
        msgSizeTooLarge : 'File should not exceeds 1MB in size.'
    });
</script>