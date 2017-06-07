<div class="modal fade" id="js-poster_image_modal" data-id="js-poster_image_modal" tabindex="-1" role="dialog">
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
                    <input id="file-uploader" name="photo" class="" type="file" multiple data-preview-file-type="any">
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
    @if ($Poster)
            @foreach($Poster as $image)

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
        fileType: "image",
        allowedFileExtensions : ['jpg', 'png'],
        allowedFileTypes : ['image'],
        allowedPreviewTypes : ['image'],
        previewFileIcon: "<i class='glyphicon glyphicon-king'></i>",
        overwriteInitial: false,
        initialPreviewAsData: true,
        initialPreview: [
            @if ($Poster)
                @foreach($Poster as $image)
                    "{{ asset('content/film/posters/') }}/{{$image->label}}",
                @endforeach
            @endif
        ],
        initialPreviewConfig: [
            @if ($Poster)
                @foreach($Poster as $image)
                    {caption: "", size: 0, width: "120px", url: "{{ route('poster_image_delete') }}", key: {{ $image->id }}, extra : { _token : "{{ csrf_token() }}", film_id : {{ $film_id }} } },
                @endforeach
            @endif
        ],
        uploadExtraData: {_token: "{{ csrf_token() }}", film_id : {{ $film_id }}},
        uploadUrl: "{{ route('poster_image_upload') }}",
        showUploadedThumbs : false,
        dragIcon : '',
        dragClass : '',
        showClose : '',

    });
</script>