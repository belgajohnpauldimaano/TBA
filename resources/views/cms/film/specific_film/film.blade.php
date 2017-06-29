@extends('layouts.main')

@section ('styles')
    <link rel="stylesheet" href="{{ asset('cms/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
    <link rel="stylesheet" href="{{ asset('cms/plugins/tokenfield-bootstrap/css/bootstrap-tokenfield.css') }}">
    <link rel="stylesheet" href="{{ asset('cms/plugins/tokenfield-bootstrap/css/tokenfield-typeahead.css') }}">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset('cms/plugins/iCheck/all.css') }}">
    <link rel="stylesheet" href="{{ asset('cms/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.css') }}">
    <link href="{{ asset('cms/plugins/kartik-v-bootstrap-fileinput/css/fileinput.css') }}" media="all" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('cms/plugins/cropper/cropper.css') }}">
    <link rel="stylesheet" href="{{ asset('cms/plugins/datepicker/datepicker3.css') }}">
    <link href="{{ asset('cms/plugins/alertifyjs/css/alertify.min.css') }}" rel="stylesheet">
    <link href="{{ asset('cms/plugins/alertifyjs/css/themes/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('cms/plugins/bootstrap-switch/css/bootstrap3/bootstrap-switch.min.css') }}">
    <link rel="stylesheet" href="{{ asset('cms/style.css') }}">

@endsection
    {{-- <div class="thumbnail">
            <img id="film_photo" src="http://127.0.0.1/TBA/public/content/film/photos/uo2GnCOnpGfEOt9hNqWPONMQthV5F4lfNTKYdwLZHnN5N7GrrHpOvNiv8cVZL5GBlaS6eIUPyLu2hNSmZq1SMzYrGFAxo4ofAwop.jpg" alt="">
        
    </div> --}}

@section ('page_title')
    {{$Film->title}} - a film by TBA
@endsection

@section ('title')
    Film Details
@endsection

@section ('content')
    <div class="row row-film">
        <div class="col-sm-12">

            {{-- FILM BASIC INFO --}}
            <div class="box box-primary">

                <div class="box-header with-border"  style="padding-left:15px">
                    <h3 class="box-title">Film Basic Information</h3>
                    <div class="box-tools">
                        <button class="btn btn-primary btn-sm btn-flat js-edit_film" data-id="{{ $Film->id }}"><i class="fa fa-edit"></i> Update</button>
                    </div>
                </div>
                <div class="overlay hidden"><i class="fa fa-refresh fa-spin"></i></div>
                <div class="box-body">
                    <div class="box box-solid js-film_info_content_holder">
                        
                        <div class="overlay hidden"><i class="fa fa-refresh fa-spin"></i></div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr class="info">
                                    <th width="369px">Title</th>
                                    <td>{{ $Film->title }}</td>
                                </tr>
                                <tr class="">
                                    <th width="369px">English Title</th>
                                    <td>{{ $Film->english_title }}</td>
                                </tr>
                                <tr>
                                    <th width="369px">Genre/s</th>
                                    <td>{{ ($Film != NULL ? $Film->genre : 'Not yet set') }}</td>
                                </tr>
                                <tr>
                                    <th width="369px">Running Time</th>
                                    <td>{{ ($Film->running_time != NULL ? $Film->running_time.' minutes' : 'Not yet set') }}</td>
                                </tr>
                                <tr>
                                    <th width="369px">Release Status</th>
                                    <td>{{ ($Film->release_status != NULL ? $RELEASE_STATUS[$Film->release_status] : 'Not yet set') }}</td>
                                </tr>
                                <tr>
                                    <th width="369px">Release Date</th>
                                    <td>
                                        {{ ($Film->release_date != NULL ? Date('d F Y', strtotime($Film->release_date)) : 'Not yet set') }}
                                        {{-- ($Film->release_date != NULL ? Date('l, jS \of F Y', strtotime($Film->release_date)) : 'Not yet set') --}}
                                    </td>
                                </tr>
                                <tr>
                                    <th width="369px">Ratings</th>
                                    <td>{{ ( $Film->rating ? $RATINGS[$Film->rating] : 'Not yet set' ) }}</td>
                                </tr>
                                <tr>
                                    <th width="369px">Sell Sheet</th>
                                    <td>
                                        @if ($Film->sell_sheet != NULL)
                                            <div class="btn-group" role="group" aria-label="...">
                                            <a href="{{ asset('content/sell_sheets/' . $Film->sell_sheet) }}" target="_blank" class="btn btn-flat btn-md bg-olive"> View sell sheet</a>
                                            <a href="#" class="btn btn-flat btn-danger js-remove_sellsheet"><i class="fa fa-trash"></i> remove</a>
                                            </div>
                                        @else
                                            None uploaded
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th width="369px">Hash Tags</th>
                                    <td>
                                        @if($Film->hash_tags != NULL)
                                        <?php
                                                //$hash_tags_arr = explode(',', $Film->hash_tags);
                                            ?>
                                                <span class="text-light-blue">{{ $Film->hash_tags }}</span>
                                            {{-- @foreach($hash_tags_arr as $val)
                                                <span class="text-light-blue">{{ $val }}</span>
                                            @endforeach --}}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th width="369px">Social media links</th>
                                    <td>
                                        @if($Film->links != NULL)
                                            @if ($Film->links->facebook_url != '')
                                                <a href="{{ $Film->links->facebook_url }}" target="_blank" class="btn btn-social-icon btn-facebook"><i class="fa fa-facebook"></i></a>
                                            @endif
                                            
                                            @if ($Film->links->twitter_url != '')
                                                <a href="{{ $Film->links->twitter_url }}" target="_blank" class="btn btn-social-icon btn-twitter"><i class="fa fa-twitter"></i></a>
                                            @endif
                                            
                                            @if ($Film->links->instagram_url != '')
                                                <a href="{{ $Film->links->instagram_url }}" target="_blank" class="btn btn-social-icon btn-instagram"><i class="fa fa-instagram"></i></a>
                                            @endif
                                        @else
                                            <p>Not yet set</p>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th width="369px">Synopsis</th>
                                    <td>
                                        <blockquote class="js-film_synopsis_content_holder">
                                            <p>
                                                {!! ($Film->synopsis != NULL ? $Film->synopsis : 'Not yet populated') !!}
                                            </p>
                                        </blockquote>
                                        <div class="js-synopsis_editor" style="display:none">
                                            <textarea placeholder="Write synopsis" style="width: 100%; height: 300px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="js-synopsis_textarea" id="js-synopsis_textarea" cols="30" rows="10" class="js-wysiwyg_editor">{{ ($Film->synopsis != NULL ? $Film->synopsis : '') }}</textarea>
                                        </div>
                                        <button class="btn btn-flat btn-primary btn-sm js-update_sysnopsis" data-edit="false"><i class="fa fa-pencil"></i> Update Synopsis</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            {{-- FILM BASIC INFO --}}
            
            {{-- FILM CREWS --}}
            <div class="box box-warning js-film_crew_holder">
                <div class="box-header with-border">
                    <a href="#" class="box-header__toggle"><i class="fa fa-caret-square-o-down" aria-hidden="true"></i></a>
                    <h3 class="box-title">Film Crew</h3>
                    <div class="box-tools"><button class="btn btn-flat btn-primary btn-sm js-btn_manage_people"><i class="fa fa-edit"></i> Update</button></div>
                </div>
                <div class="overlay hidden"><i class="fa fa-refresh fa-spin"></i></div>
                <div class="collapse">
                    <div class="box-body ">
                        <table class="table table-bordered table-striped">
                            @if ($FilmCrew)
                                    @foreach($PERSON_ROLES as $key => $val)
                                        <?php 
                                            $c = $FilmCrew->filter(function ($crew) use($key) {
                                                        return $crew->role == $key;
                                            }); 
                                        ?>
                                        @if($c->count() > 0)
                                            <tr>
                                                <th width="369px">{{ $val }}</th>
                                                <td>
                                                    {{-- @if ($c->count() > 0) --}}
                                                        @foreach ($c as $crew)
                                                            <span class="label label-primary">{{ $crew->person->name }}</span>
                                                        @endforeach
                                                    {{-- @else --}}
                                                        {{-- <p style="margin-bottom: 0">n/a</p> --}}
                                                    {{-- @endif --}}
                                                </td>
                                            </tr>
                                        {{-- @else
                                            <tr>
                                                <td colspan="2"><strong>No crew yet</strong></td>
                                            </tr> --}}
                                        @endif
                                        
                                    @endforeach
                                @endif
                            {{-- </div> --}}
                        </table>
                    </div>
                </div>
            </div>
            {{-- FILM CREWS --}}

            {{-- TRAILER --}}
            <div class="box box-success">
                <div class="box-header with-border">
                    <a href="#" class="box-header__toggle"><i class="fa fa-caret-square-o-down" aria-hidden="true"></i></a>
                    <h3 class="box-title">Trailers</h3>
                    <div class="box-tools">
                        <button class="btn btn-sm btn-flat btn-primary js-trailer_add_form"><i class="fa fa-edit"></i> Update</button>
                    </div>
                </div>
                <div class="collapse">
                    <div class="box-body">
                        <div class="js-content_holder_trailer box box-solid">
                            <div class="overlay hidden">
                                <i class="fa fa-refresh fa-spin"></i>
                            </div>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Featured</th>
                                    <th>Preview Image</th>
                                    <th>URL</th>
                                    <th>Actions</th>
                                </tr>
                                <tbody class="js-sortable_container">
                                    @if($Film->trailers)
                                        @foreach($Film->trailers as $trailer)
                                            @if($trailer->trailer_show != 0)
                                                <tr data-id="{{$trailer->id}}">
                                                    <td>
                                                        <label>
                                                            <input type="checkbox" class="minimal-green js-check_hide_show" {{ ($trailer->trailer_show == 1 ? 'checked' : '') }} > 
                                                        </label>
                                                    </td>
                                                    <td><img class="media-object" width="160" height="90" src="{{ asset('content/film/trailers/' . $trailer->image_preview) }}" alt="..."></td>
                                                    <td> <a href="{{$trailer->trailer_url}}" target="_blank">{{ str_limit($trailer->trailer_url, 60) }}</a> </td>
                                                    <td>
                                                        <!-- Single button -->
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                Action <span class="caret"></span>
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <li><a href="#" class="js-edit_trailer" data-id="{{ $trailer->id }}">Edit</a></li>
                                                                <li><a href="#" class="js-delete_trailer" data-id="{{ $trailer->id }}">Delete</a></li>
                                                                {{-- <li role="separator" class="divider"></li>
                                                                <li><a href="#">View</a></li> --}}
                                                            </ul>
                                                        </div>  
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="box-footer">
                            <div class="callout callout-success">
                                <h5>Instructions : </h5>
                                <ol>
                                    <li>Tick/untick the checkbox to show/hide the trailer in the Trailers Page of the website, respectively.</li>
                                    <li>Drag the row to arrange the order of the trailers of how it will appear in the website.</li>
                                    <li>Accepted File Types: JPG / JPEG / PNG</li>
                                    <li>Maximum File Size: 1 MB</li>
                                    <li>Required Dimensions: 1600 x 900 pixels (width x height)</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- TRAILER --}}


            {{-- POSTER PREVIEW --}}
            <div class="box box-danger">
                <div class="box-header with-border">
                    <a href="#" class="box-header__toggle"><i class="fa fa-caret-square-o-down" aria-hidden="true"></i></a>
                    <h3 class="box-title">Poster</h3>
                    <div class="box-tools">
                        <button class="btn btn-sm btn-flat btn-primary js-manage_poster_images"><i class="fa fa-edit"></i> Update</button>
                    </div>
                </div>
                <div class="collapse">
                    <div class="box-body js-poster_content_holder box box-solid">
                        <div class="overlay hidden">
                            <i class="fa fa-refresh fa-spin"></i>
                        </div>
                        <div class="js-poster_container row ">
                            @if($Poster)
                                @foreach($Poster as $data)
                                    <div class="col-xs-6 col-md-3">
                                        <div href="#" data-id="{{ $data->id }}" class="thumbnail">
                                            <img alt="..." data-id="{{ $data->id }}" src="{{ asset('content/film/posters/' . $data->label) }}" style="cursor:pointer" class="js-image_item margin">
                                            @if($data->featured == 1)
                                                <span class="badge bg-red">Featured</span>
                                            @else
                                                <span class="">&nbsp;</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="callout callout-success">
                            <h5>Instructions : </h5>
                            <ol>
                                <li>Double-click on a poster to use it as the Main Poster for the film.</li>
                                <li>Drag & drop posters to re-order as to how it would appear when viewing as a gallery.Click MANAGE POSTERS to add or remove image/s.</li>
                                <li>Click the TRASH ICON in the MANAGE POSTERS MODAL to remove the image/s.</li>
                                <li>Accepted File Types: JPG / JPEG / PNG</li>
                                <li>Maximum File Size: 2 MB</li>
                                <li>Minimum required width: 600 pixels</li>
                                <li>Maximum allowed width: 1200 pixels</li>
                                <li>No height restriction</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            {{-- POSTER PREVIEW --}}

            {{-- AWARDS --}}
            <div class="box box-danger">
                <div class="box-header with-border">
                    <a href="#" class="box-header__toggle"><i class="fa fa-caret-square-o-down" aria-hidden="true"></i></a>
                    <h3 class="box-title">Awards & Festivals</h3>
                    <div class="box-tools">
                        <button class="btn btn-sm btn-flat btn-primary js-add_award"><i class="fa fa-edit"></i> Update</button>
                    </div>
                </div>
                <div class="collapse">
                    <div class="box-body js-award_content_holder box box-solid">
                        <div class="overlay hidden">
                            <i class="fa fa-refresh fa-spin"></i>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <td>Image Title</td>
                                    <td>Image Preview</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody class="js-awards_sortable_container">
                                @if($Award->count())
                                    @foreach($Award as $data)
                                        <tr data-id="{{ $data->id }}">
                                            <td>{{ $data->award_name }}</td>
                                            <td> <img class="media-object" width="64" height="64" src="{{ asset('content/film/awards/' . $data->award_image) }}" alt="..."></td>
                                            <td>
                                                <!-- Single button -->
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Action <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="#" class="js-edit_award" data-id="{{ $data->id }}">Edit</a></li>
                                                        <li><a href="#" class="js-delete_award" data-id="{{ $data->id }}">Delete</a></li>
                                                        {{-- <li role="separator" class="divider"></li>
                                                        <li><a href="#">View</a></li> --}}
                                                    </ul>
                                                </div>  
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            @else
                                <tr>
                                    <td colspan="3">No data found.</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                    <div class="box-footer">
                        <div class="callout callout-success">
                            <p>Intructions : </p>
                            <ol>
                                <li>Drag & drop thumbnails to re-order awards in the FILM PAGE.</li>
                                <li>Accepted File Types: JPG / JPEG / PNG</li>
                                <li>Required Dimensions: 200 x 200 pixels (width x height)</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            {{-- AWARDS --}}

            {{-- PHOTOS --}}
            <div class="box box-danger">
                <div class="box-header with-border">
                    <a href="#" class="box-header__toggle"><i class="fa fa-caret-square-o-down" aria-hidden="true"></i></a>
                    <h3 class="box-title">Gallery</h3>
                    <div class="box-tools">
                        <button class="btn btn-sm btn-flat btn-primary js-manage_photo_multi"><i class="fa fa-edit"></i> Update</button>
                        {{-- <button class="btn btn-sm btn-flat btn-primary js-manage_photo_single"><i class="fa fa-edit"></i> Update</button> --}}
                        {{-- <button class="btn btn-sm btn-flat btn-primary js-manage_photo_multi">Manage Multiple Photo</button> --}}
                    </div>
                </div>
                <div class="collapse">
                    <div class="box-body js-film_photo_content_holder box box-solid">
                        <div class="overlay hidden">
                            <i class="fa fa-refresh fa-spin"></i>
                        </div>
                        <div class="js-photo_container row ">
                            @if($Photo->count() > 0)
                                @foreach($Photo as $data)
                                    <div class="col-xs-6 col-md-4 col-lg-3">
                                        <div  data-id="{{ $data->id }}" class="thumbnail js-film_photo_item">
                                        @if ($data->thumb_filename)
                                            <img style="cursor:pointer" data-id="{{ $data->id }}" src="{{ asset('content/film/photos/' . $data->thumb_filename) }}" class=" margin">
                                        @else
                                            <img style="cursor:pointer" data-id="{{ $data->id }}" src="{{ asset('content/film/photos/' . $data->filename) }}" class=" margin">
                                        @endif
                                            <div class="caption">
                                                <h4>
                                                    @if ($data->title)
                                                        {{ $data->title }}
                                                    @else
                                                        {{ $Film->title . '(' . date('Y', strtotime($Film->release_date)) . ')' }}
                                                    @endif
                                                </h4>
                                                <input type="radio" name="gallery_featured" {{ ($data->featured == 1 ? 'checked' : '') }} data-size="mini" data-on-color="danger" data-label-text="" data-on-text="featured" data-off-text="set featured" data-id="{{ $data->id }}" data-film-id="{{ $data->film_id }}" class="bs-switch-radio">
                                                <hr>
                                                <div class="row">
                                                    <div class="col-xs-6">
                                                        <button class="btn btn-flat btn-sm btn-block btn-primary js-film_photo_update_info" data-id="{{ $data->id }}">Update Info</button>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <button class="btn btn-flat btn-sm btn-block bg-olive js-film_photo_crop" data-id="{{ $data->id }}">Crop</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-sm-12">
                                    <h5>No photo yet</h5>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="callout callout-success">
                            <p>Instructions : </p>
                            <ol>
                                <li>Drag & drop images to re-order photos in the FILM PAGE gallery section. Click SAVE ORDER when done.</li>
                                <li>Click MANAGE GALLERY to add or remove image/s.</li>
                                <li>Click the TRASH ICON in the MANAGE GALLERY MODAL to remove the image/s.</li>
                                <li>Click SET THUMBNAIL to crop the photo uploaded and set as preview thumbnail for the photo. Photos without a set thumbnail will not appear in the gallery.</li>
                                <li>Double-click an image to add a caption.</li>
                                <li>Place the photo in the first place to set it as the FEATURED IMAGE. Featured Images will be automatically used by the Film as its preview image in the Film Line-Up.</li>
                                <li>Accepted File Types: JPG / JPEG / PNG</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            {{-- PHOTOS --}}

            {{-- QUOTE --}}
            <div class="box box-danger">
                <div class="box-header with-border">
                    <a href="#" class="box-header__toggle"><i class="fa fa-caret-square-o-down" aria-hidden="true"></i></a>
                    <h3 class="box-title">Quotes</h3>
                    <div class="box-tools">
                        <button class="btn btn-sm btn-flat btn-primary js-managa_quote"><i class="fa fa-edit"></i> Update</button>
                        {{-- <button class="btn btn-sm btn-flat btn-primary js-manage_photo_multi">Manage Multiple Photo</button> --}}
                    </div>
                </div>
                <div class="collapse">
                    <div class="box-body js-film_quote_content_holder box box-solid">
                        <div class="overlay hidden">
                            <i class="fa fa-refresh fa-spin"></i>
                        </div>
                        <div class="box-body">
                            @if ($Quote)
                                <blockquote>
                                    <p>{{ ($Quote ? $Quote->main_quote : 'Not yet set') }}</p>
                                    <small>{{ $Quote->name_of_person }} <cite title="{{ $Quote->url }}"><a href="{{ $Quote->url }}" target="_blank">source</a></cite></small>
                                </blockquote>
                            @else
                                <h5>Not yet set</h5>
                            @endif
                        </div>
                    </div>
                    {{-- <div class="box-footer">
                        <p>Note : </p>
                        <p class="text-primary">Double click the poster to edit data.</p>
                        <p class="text-primary">Drag the image posters to arrange the order.</p>
                    </div> --}}
                </div>
            </div>
            {{-- QUOTE --}}

            {{-- PRESS RELEASE --}}
            <div class="box box-danger">
                <div class="box-header with-border">
                    <a href="#" class="box-header__toggle"><i class="fa fa-caret-square-o-down" aria-hidden="true"></i></a>
                    <h3 class="box-title">Press Release</h3>
                    <div class="box-tools">
                        <button class="btn btn-sm btn-flat btn-primary js-manage_press_release"><i class="fa fa-edit"></i> Update</button>
                        {{-- <button class="btn btn-sm btn-flat btn-primary js-manage_photo_multi">Manage Multiple Photo</button> --}}
                    </div>
                </div>
                <div class="collapse">
                    <div class="box-body js-film_press_release_content_holder box box-solid">
                        <div class="overlay hidden">
                            <i class="fa fa-refresh fa-spin"></i>
                        </div>
                        <div class="box-body">
                            
                            @if ($PressRelease)
                                <ul class="media-list">
                                    <li class="media">
                                        <div class="media-left">
                                        <a>
                                            <img class="media-object" style="max-width:220px;" src="{{ asset('content/film/press_release' . '/' . $PressRelease->article_image) }}" alt="...">
                                        </a>
                                        </div>
                                        <div class="media-body">
                                        <h4 class="media-heading">Article</h4>
                                            <div>
                                                <label for="">Blurb</label>
                                                <div class="margin">
                                                    {!! str_limit($PressRelease->blurb, 200) !!}
                                                </div>
                                            </div>

                                        </div>
                                    </li>
                                </ul>
                                <div>
                                    <label for="">Main Content</label>
                                    <div class="margin">
                                        {!! str_limit($PressRelease->content, 500, '<a href="#" class="link">Read more...</a>') !!}
                                    </div>
                                </div>
                            @else
                                <h5>Not yet set</h5>
                            @endif
                        </div>
                    </div>
                    {{-- <div class="box-footer">
                        <p>Note : </p>
                        <p class="text-primary">Double click the poster to edit data.</p>
                        <p class="text-primary">Drag the image posters to arrange the order.</p>
                    </div> --}}
                </div>
            </div>
            {{-- PRESS RELEASE --}}
            
            {{-- DVD --}}
            <div class="box box-danger">
                <div class="box-header with-border">
                    <a href="#" class="box-header__toggle"><i class="fa fa-caret-square-o-down" aria-hidden="true"></i></a>
                    <h3 class="box-title">On DVD</h3>
                    <div class="box-tools">
                        <button class="btn btn-sm btn-flat btn-primary js-manage_dvd"><i class="fa fa-edit"></i> Update</button>
                        {{-- <button class="btn btn-sm btn-flat btn-primary js-manage_photo_multi">Manage Multiple Photo</button> --}}
                    </div>
                </div>
                <div class="collapse">
                    <div class="box-body js-film_dvd_content_holder  box box-solid">
                        <div class="overlay hidden">
                            <i class="fa fa-refresh fa-spin"></i>
                        </div>
                        <div class="js-dvd_container list-group">
                            @if($Dvd->count() > 0) 
                                 @foreach($Dvd as $data)
                                    <div class="col-xs-6 col-md-3 js-individual_dvd_holder" data-id="{{ $data->id }}">
                                        <div  data-id="{{ $data->id }}" class="thumbnail js-dvd_data">
                                            <img style="cursor:pointer" data-id="{{ $data->id }}" src="{{ asset('content/film/dvds/' . $data->dvd_case_cover) }}" class=" margin">
                                            <div class="caption">
                                                <h4>
                                                    @if ($data->name)
                                                        {{ $data->name }}
                                                    @else
                                                        No Title Yet
                                                    @endif
                                                </h4>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-xs-6">
                                                <button class="btn btn-flat btn-success btn-xs js-dvd_update btn-block" data-id="{{ $data->id }}">Edit</button>
                                                    </div>
                                                    <div class="col-xs-6">
                                                <button class="btn btn-flat btn-danger btn-xs js-dvd_delete btn-block" data-id="{{ $data->id }}">Delete</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-sm-12">
                                    <h5>No data yet</h5>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="callout callout-success">
                            <p>Instructions : </p>
                            <ol>
                                <li>Click UPDATE to add/modify a DVD entry</li>
                                <li>DVD Set Name can be left blank; if so, name in website will appear as “Film Title DVD”. Otherwise, it will appear as “Film Title DVD Set Name”.</li>
                                <li>Drag & drop each row to re-order the DVDs as to how it will appear in the website.</li>
                                <li>Untick the checkbox to hide the product from the website.</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            {{-- DVD --}}

        </div>
    </div>
    <div id="js-modal_holder"></div>
@endsection

@section('scripts')
    <script src="{{ asset('cms/plugins/Bootstrap-3-Typeahead/bootstrap3-typeahead.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="{{ asset('cms/plugins/tokenfield-bootstrap/bootstrap-tokenfield.js') }}"></script>
    <script src="{{ asset('cms/plugins/tokenfield-bootstrap/typeahead.bundle.js') }}"></script>
    <script src="{{ asset('cms/plugins/kartik-v-bootstrap-fileinput/js/fileinput.js') }}"></script>
    <script src="{{ asset('cms/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.js') }}"></script>
    <script src="{{ asset('cms/plugins/cropper/cropper.js') }}"></script>
    <script src="{{ asset('cms/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('cms/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
    <script src="{{ asset('cms/plugins/alertifyjs/alertify.min.js') }}"></script>

    <!-- iCheck 1.0.1 -->
    <script src="{{ asset('cms/plugins/iCheck/icheck.min.js') }}"></script>
    <script>
        
        $('.bs-switch-radio').bootstrapSwitch();
        
        $('body').on('switchChange.bootstrapSwitch', '.bs-switch-radio', function(event, state) {
            console.log($(this).data('id')); // DOM element
            console.log(state); // true | false
            var id = $(this).data('id');
            $.ajax({
                url         : "{{ route('film_photo_set_featured') }}",
                type        : 'POST',
                data        : {_token: '{{ csrf_token() }}', id : id, film_id : '{{ $Film->id }}'},
                dataType    : 'JSON',
                success     : function (data) {
                    if (data.errCode == 1)
                    {
                        alertify.error('' + data.messages + '');
                    }
                    else
                    {
                        alertify.success('' + data.messages + '');
                    }
                },
                error : function (xhr, ajaxOptions, thrownError)
                {
                    if (thrownError == 'Unauthorized')
                    {
                        window.location.reload();
                    }
                },
                statusCode: {
                    500: function(xhr) {
                        window.location.reload();
                    }
                }
            });
        });
        $('body').on('click' , '.js-remove_sellsheet', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            bootbox.confirm({
                title: "Confirm",
                message: "Are you sure you want to delete?",
                buttons: {
                    cancel: {
                        label: '<i class="fa fa-times"></i> Cancel'
                    },
                    confirm: {
                        label: '<i class="fa fa-check"></i> Confirm'
                    }
                },
                callback: function (result) {
                    if (result)
                    {
                        delete_record("{{ route('delete_sellsheet', $Film->id) }}", "{{ route('film_basic_info_fetch', $Film->id) }}", $('.js-film_info_content_holder'), id);
                    }
                }
            });
        });

        // modal edit film info show
        $('body').on('click', '.js-edit_film', function (e) {
            e.preventDefault();

            var id = $(this).data('id');

            $.ajax({
                url : "{{ route('show_film_form') }}",
                type : 'POST',
                data : {_token : '{{ csrf_token() }}', id : id},
                success : function (data) {
                    $('#js-modal_holder').html(data);
                    $('#js-film_form_modal').modal({keyboard : false, backdrop : 'static'});
                }
                ,error : function (xhr, ajaxOptions, thrownError)
                {
                    if (thrownError == 'Unauthorized')
                    {
                        window.location.reload();
                    }
                },
                statusCode: {
                    500: function(xhr) {
                        window.location.reload();
                    }
                }
            });
        });
        // form film edit save
        $('body').on('submit', '#js-film_form', function (e) {
            e.preventDefault();

            save_data($(this), "{{ route('save_film') }}", "{{ route('film_basic_info_fetch', $Film->id) }}", $('.js-film_info_content_holder'));
            
        });
        
        $('body').on('click', '#js-sellsheet', function () {
            $('#sellsheet').click();
        });
        $('body').on('change', '#sellsheet', function () {
            $('#js-sellsheet_text').val($('#sellsheet').val().replace(/.*(\/|\\)/, ''));
        });
        
        var order = [];
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-green, input[type="radio"].minimal-green').iCheck({
            checkboxClass: 'icheckbox_minimal-green',
            radioClass: 'iradio_minimal-red'
        });
        $('.js-sortable_container').sortable({ 
            tolerance: 'pointer',
            update : function (event, ui) {
                order = [];

                $('.js-sortable_container tr').each( function () {
                    var id = $(this).data('id');
                    order.push(id);
                });
                
                save_order(order, "{{ route('trailer_order_save') }}");
            }
        });

        $('body').on('ifChecked', '.js-check_hide_show', function (e) {

            var id = $(this).parents('tr').data('id');
            show_hide_toggle(1, id, "{{ route('show_hide_toggle') }}")
            
        })
        $('body').on('ifUnchecked', '.js-check_hide_show', function (e) {

            var id = $(this).parents('tr').data('id');
            show_hide_toggle(2, id, "{{ route('show_hide_toggle') }}")
        })
        
        
        $('body').on('click', '.js-trailer_add_form', function () {
            show_trailer_form_modal();
        });

        $('body').on('click', '.js-edit_trailer', function (e) {
            e.preventDefault();
            var id = $(this).data(id);
            show_trailer_form_modal(id);
        });

        function show_trailer_form_modal (id)
        {
            var data='';
            if (id == '')
            {
                data = {_token:"{{ csrf_token() }}" };
            }
            else
            {
                data = {_token:"{{ csrf_token() }}", trailer_id:id};
            }

            $.ajax({
                url : "{{ route('film_trailer_form_modal') }}",
                type : 'POST',
                data : data,
                success : function (data){
                    $('#js-modal_holder').html(data);
                    $('#trailer_form_modal').modal({keyboard : false, backdrop : 'static'});
                }
                ,error : function (xhr, ajaxOptions, thrownError)
                {
                    if (thrownError == 'Unauthorized')
                    {
                        window.location.reload();
                    }
                },
                statusCode: {
                    500: function(xhr) {
                        window.location.reload();
                    }
                }
            });
        }

        $('body').on('click', '.js-delete_trailer', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            bootbox.confirm({
                title: "Confirm",
                message: "Are you sure you want to delete?",
                buttons: {
                    cancel: {
                        label: '<i class="fa fa-times"></i> Cancel'
                    },
                    confirm: {
                        label: '<i class="fa fa-check"></i> Confirm'
                    }
                },
                callback: function (result) {
                    if (result)
                    {
                        delete_record("{{ route('delete_trailer') }}", "{{ route('film_trailer_fetch_record', $Film->id) }}", $('.js-content_holder_trailer'), id);
                    }
                }
            });
        });

        $('body').on('submit', '#js-frm_trailer', function (e) {
            e.preventDefault();
            save_data($(this), "{{ route('save_trailer', $Film->id) }}", "{{ route('film_trailer_fetch_record', $Film->id) }}", $('.js-content_holder_trailer'));
        });

        $('body').on('click', '#js-sellsheet', function () {
            $('#image_preview').click();
        });
        
        $('body').on('change', '#image_preview', function () {
            $('#js-image_preview_text').html(' - <i>' + $('#image_preview').val().replace(/.*(\/|\\)/, '') + '</i>');
        });

        function show_hide_toggle(is_show, id, show_hide_route)
        {
            
            $.ajax({
                url : show_hide_route,
                type : 'POST',
                dataType : 'JSON',
                data : {_token:'{{ csrf_token() }}', id:id, is_show:is_show},
                success : function (data) {
                    if (data.errCode == 1)
                    {
                        //var msg = data.message;
                        //show_message (msg, 'danger') 
                    }
                    else
                    {
                        //var msg = data.message;
                        //show_message (msg, 'success') 
                    }
                }
                ,error : function (xhr, ajaxOptions, thrownError)
                {
                    if (thrownError == 'Unauthorized')
                    {
                        window.location.reload();
                    }
                },
                statusCode: {
                    500: function(xhr) {
                        window.location.reload();
                    }
                }
            });
        }

        function save_order (order, order_route, targetElem)
        {
            if (order.length < 1)
            {
                var msg = 'No order has been change yet.';
                show_message (msg, 'warning', targetElem) 
                return;
            }

            $.ajax({
                url : order_route,
                type : 'POST',
                dataType : 'JSON',
                data : {_token:'{{ csrf_token() }}', order:order},
                success : function (data) {
                    //var msg = 'Trailers successfully ordered.';
                    //show_message (msg, 'success') 
                }
                ,error : function (xhr, ajaxOptions, thrownError)
                {
                    if (thrownError == 'Unauthorized')
                    {
                        window.location.reload();
                    }
                },
                statusCode: {
                    500: function(xhr) {
                        window.location.reload();
                    }
                }
            });
        }


        /*
         *  POSTER JS
         */
         
         $('.js-poster_container').sortable({ 
            tolerance: 'pointer',
            update : function (event, ui) {
                var poster_order = [];

                $('.js-poster_container .thumbnail img').each( function () {
                    var id = $(this).data('id');
                    poster_order.push(id);
                });
                
                save_order(poster_order, "{{ route('posters_order_save') }}");
            }
        });

         $('body').on('dblclick', '.js-image_item', function (e) {
             e.preventDefault();
             var id = $(this).data('id');
             $('.thumbnail').children('span').removeClass('badge bg-red').html('&nbsp;');
             $(this).parents('.thumbnail').children('span').addClass('badge bg-red').text('Featured');

             $.ajax({
                 url : "{{ route('set_featured_image') }}",
                 type : 'POST',
                 data : { _token : "{{ csrf_token() }}", id : id, film_id : {{ $Film->id }} },
                 success : function (data) {
                 }
                 ,error : function (xhr, ajaxOptions, thrownError)
                {
                    if (thrownError == 'Unauthorized')
                    {
                        window.location.reload();
                    }
                },
                statusCode: {
                    500: function(xhr) {
                        window.location.reload();
                    }
                }
             });
         });

         $('body').on('click', '.js-manage_poster_images', function () {
            
            $.ajax({
                url : "{{ route('poster_image_modal') }}",
                type : 'POST',
                data : { _token : '{{ csrf_token() }}', film_id : {{ $Film->id }} } ,
                success : function (data) {
                    $('#js-modal_holder').html(data);
                    $('#js-poster_image_modal').modal({keyboard : false, backdrop : 'static'});
                }
                ,error : function (xhr, ajaxOptions, thrownError)
                {
                    if (thrownError == 'Unauthorized')
                    {
                        window.location.reload();
                    }
                },
                statusCode: {
                    500: function(xhr) {
                        window.location.reload();
                    }
                }
            });
         });
         
        // Clear modal on hidden
        $('body').on('hidden.bs.modal', '#js-poster_image_modal', function (e) {
            $('#js-modal_holder').empty();
            if ($(this).data('id') !== undefined) // allow refresh of image list only if the modal upload was shown
            {
                var dataParams = { fetching_route : "{{ route('poster_image_fetch') }}", targetElement : 'js-poster_content_holder', extra : {{ $Film->id }} };
                image_list(dataParams);
            }
        })

        /*
         * AWARDS JS SCRIPT
         */
        $('.js-awards_sortable_container').sortable({ 
            tolerance: 'pointer',
            update : function (event, ui) {
                var award_order = [];

                $('.js-awards_sortable_container tr').each( function () {
                    var id = $(this).data('id');
                    award_order.push(id);
                });
                
                save_order(award_order, "{{ route('film_award_order_save') }}");
            }
        });

        $('body').on('click', '.js-add_award, .js-edit_award', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            show_award_form_modal(id);
        });
       
        $('body').on('click', '#js-btn_award_image', function () {
            $('#award_image').click();
        });
        
        $('body').on('change', '#award_image', function () {
            $('#js-text_award_image').html(' - <i>'+ $('#award_image').val().replace(/.*(\/|\\)/, '') +'</>');
        });

        $('body').on('submit', '#js-frm_award', function (e) {
            e.preventDefault();
            save_data($(this), "{{ route('film_award_save', $Film->id) }}", "{{ route('film_awards_fetch', $Film->id) }}", $('.js-award_content_holder'));
        });

        function show_award_form_modal (id)
        {
            var data='';
            if (id == '')
            {
                data = {_token:"{{ csrf_token() }}" };
            }
            else
            {
                data = {_token:"{{ csrf_token() }}", award_id:id};
            }
            
            $.ajax({
                url : "{{ route('film_award_form') }}",
                type : 'POST',
                data : data,
                success : function (data) {
                    $('#js-modal_holder').html(data);
                    $('#js-award_form_modal').modal({keyboard : false, backdrop : 'static'});
                }
                ,error : function (xhr, ajaxOptions, thrownError)
                {
                    if (thrownError == 'Unauthorized')
                    {
                        window.location.reload();
                    }
                },
                statusCode: {
                    500: function(xhr) {
                        window.location.reload();
                    }
                }
            })
        }
        $('body').on('click', '.js-delete_award', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            bootbox.confirm({
                message: "Are you sure you want to delete photo?",
                buttons: {
                    confirm: {
                        label: 'Yes',
                        className: 'btn-danger btn-flat'
                    },
                    cancel: {
                        label: 'No',
                        className: 'btn-default btn-flat'
                    }
                },
                callback: function (result) {
                    if (result)
                    {
                        delete_record ("{{ route('film_award_delete') }}", "{{ route('film_awards_fetch', $Film->id) }}", $('.js-award_content_holder'), id)
                    }
                }
            });
        });

        /*
         * FILM PHOTO
         */
         
        $('.js-photo_container').sortable({ 
            tolerance: 'pointer',
            update : function (event, ui) {
                var photo_order = [];

                $('.js-photo_container .thumbnail img').each( function () {
                    var id = $(this).data('id');
                    photo_order.push(id);
                });
                
                save_order(photo_order, "{{ route('film_photo_order_save') }}");
            }
        });

        $('body').on('click', '.js-manage_photo_single', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            show_photo_single_form_modal(id);
        });

        function show_photo_single_form_modal (id)
        {
            var data='';
            if (id == '')
            {
                data = {_token:"{{ csrf_token() }}" };
            }
            else
            {
                data = {_token:"{{ csrf_token() }}", photo_id:id};
            }

            $.ajax({
                url : "{{ route('film_photo_single_upload_form_modal') }}",
                type : 'POST',
                data : data,
                success : function (data){
                    $('#js-modal_holder').html(data);
                    $('#js-film_photo_single_form_modal').modal({keyboard : false, backdrop : 'static'});
                }
                ,error : function (xhr, ajaxOptions, thrownError)
                {
                    if (thrownError == 'Unauthorized')
                    {
                        window.location.reload();
                    }
                },
                statusCode: {
                    500: function(xhr) {
                        window.location.reload();
                    }
                }
            });
        }

        $('body').on('click', '#js-btn_image_filename', function () {
            $('#image_filename').click();
        });
        
        $('body').on('change', '#image_filename', function () {
            $('#js-text_image_filename').html(' - <i>' + $('#image_filename').val().replace(/.*(\/|\\)/, '') + '</i>');
        });

        $('body').on('submit', '#js-frm_film_photo', function (e) {
            e.preventDefault();
            save_data($(this), "{{ route('film_photo_single_save', $Film->id) }}", "{{ route('film_photo_fetch', $Film->id) }}", $('.js-film_photo_content_holder'));
        });

        $('body').on('dblclick', '.js-film_photo_item', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            show_photo_single_form_modal(id);
        });

        $('body').on('click', '.js-film_photo_update_info', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            show_photo_single_form_modal(id);
        });

        // Film Photo Material switch
        $('body').on('click', '.film_photo_featured_switch_ui', function () {
            var checkbox_switch = $(this).parents('.material-switch').children('#film_photo_featured_switch');
            
            if (checkbox_switch.val() == 'true')
            {
                checkbox_switch.val('false');
            }
            else
            {
                checkbox_switch.val('true');
            }

            //!checkbox_switch.val()
            //alert(checkbox_switch.val());
        });

        // Film DVD Material switch
        $('body').on('click', '.film_dvd_featured_switch_ui', function () {
            var checkbox_switch = $(this).parents('.material-switch').children('#film_dvd_featured_switch');
            
            if (checkbox_switch.val() == 'true')
            {
                checkbox_switch.val('false');
            }
            else
            {
                checkbox_switch.val('true');
            }

            //!checkbox_switch.val()
            //alert(checkbox_switch.val());
        });

        $('body').on('ifChecked', '#film_photo_featured', function(event){
            $('#film_photo_featured').val('true');
        });

        $('body').on('ifUnchecked', '#film_photo_featured', function(event){
            $('#film_photo_featured').val('false');
        });

        // photo multiple upload
        $('body').on('click', '.js-manage_photo_multi', function (e) {
            e.preventDefault();

            data = {_token:"{{ csrf_token() }}", film_id:{{ $Film->id }} };

            $.ajax({
                url : "{{ route('film_photo_multi_upload_form_modal') }}",
                type : 'POST',
                data : data,
                success : function (data){
                    $('#js-modal_holder').html(data);
                    $('#js-film_photo_multi_upload_form_modal').modal({keyboard : false, backdrop : 'static'});
                }
                ,error : function (xhr, ajaxOptions, thrownError)
                {
                    if (thrownError == 'Unauthorized')
                    {
                        window.location.reload();
                    }
                },
                statusCode: {
                    500: function(xhr) {
                        window.location.reload();
                    }
                }
            });

        });
        //"{{ route('film_photo_fetch', $Film->id) }}", $('.js-film_photo_content_holder')
        // Update the list of film photos
        $('body').on('hidden.bs.modal', '#js-film_photo_multi_upload_form_modal', function () {
            fetch_record("{{ route('film_photo_fetch', $Film->id) }}", $('.js-film_photo_content_holder'), 1, '');
        });


        // show modal for crop
        $('body').on('click', '.js-film_photo_crop',  function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            //js-film_photo_crop_modal
            data = {_token:"{{ csrf_token() }}", photo_id:id, film_id : {{$Film->id}} };

            $.ajax({
                url : "{{ route('film_photo_crop_modal') }}",
                type : 'POST',
                data : data,
                success : function (data){
                    $('#js-modal_holder').html(data);
                    $('#js-film_photo_crop_modal').modal({keyboard : false, backdrop : 'static'});
                    
                    var $image = $('#film_photo');
                    var cropBoxData;
                    var canvasData;
                    $('#js-film_photo_crop_modal').on('shown.bs.modal', function () {
                        $image.cropper({
                        autoCropArea: 0.5,
                        aspectRatio: 1 / 1,
                        cropBoxResizable: true,
                        responsive : true,
                        movable  : true,
                        zoomable : true,
                        zoomOnTouch : false,
                        minCropBoxWidth : 300,
                        minCropBoxHeight : 300,
                        dragMode : 'move',
                        //crop: function(e) {
                            // Output the result data for cropping image.
                            /*console.log(e.x);
                            console.log(e.y);
                            console.log(e.width);
                            console.log(e.height);
                            console.log(e.rotate);
                            console.log(e.scaleX);
                            console.log(e.scaleY);*/
                        //},
                        ready: function () {
                                $image.cropper('setCanvasData', canvasData);
                                $image.cropper('setCropBoxData', cropBoxData);
                            }
                        });
                    }).on('hidden.bs.modal', function () {
                            cropBoxData = $image.cropper('getCropBoxData');
                            canvasData = $image.cropper('getCanvasData');
                            $image.cropper('destroy');
                    });
                    
                }
                ,error : function (xhr, ajaxOptions, thrownError)
                {
                    if (thrownError == 'Unauthorized')
                    {
                        window.location.reload();
                    }
                },
                statusCode: {
                    500: function(xhr) {
                        window.location.reload();
                    }
                }
            });
        });

        $('body').on('submit', '#js-frm_film_photo_crop', function (e) {
            e.preventDefault();
            var cropData = $('#film_photo').cropper('getData');
            var formData = new FormData( $(this)[0] );
            formData.append('left', Math.round(cropData.x));
            formData.append('top', Math.round(cropData.y));
            formData.append('width', Math.round(cropData.width));
            formData.append('height', Math.round(cropData.height));
            

            $.ajax({
                url : "{{ route('film_photo_crop_save') }}",
                type : 'POST',
                data : formData,
                dataType : 'JSON',
                processData : false,
                contentType : false,
                success : function (data){
                    if(data.errCode == 0)
                    {
                        fetch_record("{{ route('film_photo_fetch', $Film->id) }}", $('.js-film_photo_content_holder'), 1, '');
                        $('#js-film_photo_crop_modal').modal('hide');
                        bootbox.alert(data.messages);
                        
                    }
                }
                ,error : function (xhr, ajaxOptions, thrownError)
                {
                    if (thrownError == 'Unauthorized')
                    {
                        window.location.reload();
                    }
                },
                statusCode: {
                    500: function(xhr) {
                        window.location.reload();
                    }
                }
            });
        });



        $('.bootbox').on('hidden.bs.modal', function (e) {
            if($('.modal.in')){
                $('body').addClass('modal-open');
            }
        });

        $('body').on('click', '.js-photo_delete', function (e) {
            e.preventDefault();

            var id = $(this).data('id');
            bootbox.confirm({
                message: "Are you sure you want to delete photo?",
                buttons: {
                    confirm: {
                        label: 'Yes',
                        className: 'btn-danger btn-flat'
                    },
                    cancel: {
                        label: 'No',
                        className: 'btn-default btn-flat'
                    }
                },
                callback: function (result) {
                    console.log('This was logged in the callback: ' + result);
                    if(result)
                    {
                        $.ajax({
                            url : "{{ route('photo_single_delete') }}",
                            type : 'POST',
                            data : {_token : '{{ csrf_token() }}', id : id},
                            success     : function (data) {
                                if (data.errCode == 1)
                                {
                                    show_message (data.messages, 'danger');
                                }
                                else if (data.errCode == 2)
                                {
                                    $('#general-error').append('<code>'+ data['messages'] +'</code>');
                                }
                                else
                                {
                                    $('#js-film_photo_single_form_modal').modal('hide');
                                    fetch_record("{{ route('film_photo_fetch', $Film->id) }}", $('.js-film_photo_content_holder'), 1, '');
                                }
                            }
                            ,error : function (xhr, ajaxOptions, thrownError)
                            {
                                if (thrownError == 'Unauthorized')
                                {
                                    window.location.reload();
                                }
                            },
                            statusCode: {
                                500: function(xhr) {
                                    window.location.reload();
                                }
                            }
                        });
                    }
                    setTimeout(function(){
                        var modal_count = $('.modal-dialog').length;
                        if(modal_count > 0)
                        {
                            $('body').addClass('modal-open');
                        }
                    }, 500);  
                }
            });

        });

        $('.film').addClass('active');

        /*
         * QUOTE
         */
        $('body').on('click', '.js-managa_quote', function (e) {
            e.preventDefault();
            
            $.ajax({
                url : "{{ route('film_quote_form_modal') }}",
                type : 'POST',
                data : { _token:'{{ csrf_token() }}', film_id : {{ $Film->id }} },
                success : function (data) {
                    $('#js-modal_holder').html(data);
                    $('#js-film_quote_form_modal').modal({keyboard : false, backdrop : 'static'});
                }
                ,error : function (xhr, ajaxOptions, thrownError)
                {
                    if (thrownError == 'Unauthorized')
                    {
                        window.location.reload();
                    }
                },
                statusCode: {
                    500: function(xhr) {
                        window.location.reload();
                    }
                }
            });
        });
        
        $('body').on('submit', '#js-frm_quote', function (e) {
            e.preventDefault();
            save_data($(this), "{{ route('film_quote_save') }}", "{{ route('film_quote_fetch', $Film->id) }}", $('.js-film_quote_content_holder'));
        });
        
        /*
         * UPDATE SYNOPSIS
         */
        $('body').on('click', '.js-update_sysnopsis', function (e) {
            e.preventDefault();

            if ($(this).data('edit') == true)
            {
                var synopsis = $(".js-wysiwyg_editor").val();
                $('.js-film_synopsis_holder').children('.overlay').removeClass('hidden');
                $.ajax({
                    url : "{{ route('film_synopsis_save') }}",
                    type : 'POST',
                    dataType : 'JSON',
                    data : {_token:'{{ csrf_token() }}', synopsis:synopsis, id:{{ $Film->id }} },
                    success : function (data) {
                        $('.js-film_synopsis_holder').children('.overlay').addClass('hidden');

                        $('.js-film_synopsis_content_holder').html(synopsis);

                        $('.js-film_synopsis_content_holder').slideToggle();
                        $('.js-synopsis_editor').slideToggle();
                    }
                    ,error : function (xhr, ajaxOptions, thrownError)
                    {
                        if (thrownError == 'Unauthorized')
                        {
                            window.location.reload();
                        }
                    },
                    statusCode: {
                        500: function(xhr) {
                            window.location.reload();
                        }
                    }
                });
            }
            else
            {
                $('.js-film_synopsis_content_holder').slideToggle();
                $('.js-synopsis_editor').slideToggle();
            }
            
                $(this).data('edit', !$(this).data('edit'));
                $(this).html( ($(this).data('edit') == true ? '<i class="fa fa-save"></i> Save Synopsis' : '<i class="fa fa-pencil"></i> Update Synopsis') );
        });

        //bootstrap WYSIHTML5 - text editor
        $(".js-wysiwyg_editor").wysihtml5({
            toolbar: {
                "font-styles": true, // Font styling, e.g. h1, h2, etc.
                "emphasis": true, // Italics, bold, etc.
                "lists": true, // (Un)ordered lists, e.g. Bullets, Numbers.
                "html": false, // Button which allows you to edit the generated HTML.
                "link": false, // Button to insert a link.
                "image": false, // Button to insert an image.
                "color": false, // Button to change color of font
                "blockquote": true, // Blockquote
                "size":'sm' // options are xs, sm, lg
            }
        });
        /*
         * PRESS RELEASE
         */
        $('body').on('click', '.js-manage_press_release', function () {

            $.ajax({
                url : "{{ route('film_press_release_form_modal', $Film->id) }}",
                type : 'POST',
                data : { _token : "{{ csrf_token() }}", id : {{ $Film->id }} },
                success : function (data) {
                    $('#js-modal_holder').html(data);
                    $('#js-film_press_release_form_modal').modal({keyboard : false, backdrop : 'static'});
                    
                    
                    $("#press_release_blurb, #press_release_content").wysihtml5({
                        toolbar: {
                            "font-styles": true, // Font styling, e.g. h1, h2, etc.
                            "emphasis": true, // Italics, bold, etc.
                            "lists": true, // (Un)ordered lists, e.g. Bullets, Numbers.
                            "html": false, // Button which allows you to edit the generated HTML.
                            "link": false, // Button to insert a link.
                            "image": false, // Button to insert an image.
                            "color": false, // Button to change color of font
                            "blockquote": true, // Blockquote
                            "size":'sm' // options are xs, sm, lg
                        }
                    });

                }
                ,error : function (xhr, ajaxOptions, thrownError)
                {
                    if (thrownError == 'Unauthorized')
                    {
                        window.location.reload();
                    }
                },
                statusCode: {
                    500: function(xhr) {
                        window.location.reload();
                    }
                }
            });
        });
        
        $('body').on('click', '#js-press_release_article_image', function (e) {
            e.preventDefault();
            $('#press_release_article_image').click();
        });

        $('body').on('change', '#press_release_article_image', function () {
            $('#js-text_press_release_article_image').html('<i>' + $('#press_release_article_image').val().replace(/.*(\/|\\)/, '') + '</i>');
        });

        $('body').on('submit', '#js-frm_press_release', function (e) {
            e.preventDefault();
            save_data($(this), "{{ route('film_press_release_save') }}", "{{ route('film_press_release_fetch', $Film->id) }}", $('.js-film_press_release_content_holder'));
        });

        $('body').on('click', '.js-delete_press_release', function (e) {
            e.preventDefault();

            var id = $(this).data('id');
            bootbox.confirm({
                message: "Are you sure you want to delete press release details?",
                buttons: {
                    confirm: {
                        label: 'Yes',
                        className: 'btn-danger btn-flat'
                    },
                    cancel: {
                        label: 'No',
                        className: 'btn-default btn-flat'
                    }
                },
                callback: function (result) {
                    if(result)
                    {
                        $.ajax({
                            url : "{{ route('film_press_release_delete') }}",
                            type : 'POST',
                            data : {_token : '{{ csrf_token() }}', id : id, film_id : "{{ $Film->id }}"},
                            success     : function (data) {
                                if (data.errCode == 1)
                                {
                                    show_message (data.messages, 'danger');
                                }
                                else if (data.errCode == 2)
                                {
                                    $('#general-error').append('<code>'+ data['messages'] +'</code>');
                                }
                                else
                                {
                                    $('#js-film_press_release_form_modal').modal('hide');
                                    fetch_record("{{ route('film_press_release_fetch', $Film->id) }}", $('.js-film_press_release_content_holder'), 1, '');
                                }
                            }
                            ,error : function (xhr, ajaxOptions, thrownError)
                            {
                                if (thrownError == 'Unauthorized')
                                {
                                    window.location.reload();
                                }
                            },
                            statusCode: {
                                500: function(xhr) {
                                    window.location.reload();
                                }
                            }
                        });
                    }
                    setTimeout(function(){
                        var modal_count = $('.modal-dialog').length;
                        if(modal_count > 0)
                        {
                            $('body').addClass('modal-open');
                        }
                    }, 500);  
                }
            });
        }); 


        /*
         * FILM CREW
         */
        
        // Show Film Crew Form Modal
        $('body').on('click', '.js-btn_manage_people', function (e) {
            e.preventDefault();
           
            $.ajax({
                url : "{{ route('film_crew_form_modal') }}",
                type : 'POST',
                data : { _token:'{{ csrf_token() }}', film_id : {{ $Film->id }} },
                success : function (data) {
                    $('#js-modal_holder').html(data);
                    $('#js-film_crew_form_modal').modal({keyboard : false, backdrop : 'static'});
                    
                    //$('.tokenfield-typeahead').tokenfield();

                    
                    var engine = new Bloodhound({
                        local: [
                            @if($Person)
                                @foreach ($Person as $data)
                                    {value: '{{ $data->name }}'},
                                @endforeach
                            @endif 
                        ],
                        datumTokenizer: function(d) {
                            return Bloodhound.tokenizers.whitespace(d.value);
                        },
                        queryTokenizer: Bloodhound.tokenizers.whitespace
                    });

                    engine.initialize();
                    $('.js-crew_inputs').tokenfield({
                        typeahead: [null, { source: engine.ttAdapter() }]
                    });
                }
                ,error : function (xhr, ajaxOptions, thrownError)
                {
                    if (thrownError == 'Unauthorized')
                    {
                        window.location.reload();
                    }
                },
                statusCode: {
                    500: function(xhr) {
                        window.location.reload();
                    }
                }
            });
        })

        $('body').on('submit', '#js-frm_film_crew', function (e) {
            e.preventDefault();
            save_data($(this), "{{ route('film_crew_save') }}", "{{ route('film_crew_data_fetch', $Film->id) }}", $('.js-film_crew_holder'));
             
        });
        /*$('#film_photo').cropper({
            aspectRatio: 16 / 9,
            crop: function(e) {
                // Output the result data for cropping image.
                console.log(e.x);
                console.log(e.y);
                console.log(e.width);
                console.log(e.height);
                console.log(e.rotate);
                console.log(e.scaleX);
                console.log(e.scaleY);
            }
        });*/

        $('.box').on('click', '.box-header__toggle', function(e){
            e.preventDefault();
            $(this).parent().parent().find('.collapse').collapse('toggle');
            $(this).find('.fa-caret-square-o-down').toggleClass('fa-rotate-180');
        });

        /**
         * FILM DVD
         */

        $('body').on('click', '#list',function(event){
            event.preventDefault();
            $('.js-dvd_container .item').addClass('list-group-item');
        });

        $('body').on('click', '#grid',function(event){
            event.preventDefault();
            $('.js-dvd_container .item').removeClass('list-group-item');
            $('.js-dvd_container .item').addClass('grid-group-item');
        });
        
        $('body').on('click', '.js-manage_dvd', function (e) {
            e.preventDefault();
            show_film_dvd_form_modal('');

        });

        $('body').on('click', '.js-dvd_update', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            show_film_dvd_form_modal(id);
        });

        $('body').on('click', '.js-dvd_delete', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            bootbox.confirm({
                title: "Confirm",
                message: "Are you sure you want to delete?",
                buttons: {
                    cancel: {
                        label: '<i class="fa fa-times"></i> Cancel'
                    },
                    confirm: {
                        label: '<i class="fa fa-check"></i> Confirm'
                    }
                },
                callback: function (result) {
                    if (result)
                    {
                        delete_record("{{ route('film_dvd_delete') }}", "{{ route('film_dvd_data_fetch', $Film->id) }}", $('.js-film_dvd_content_holder'), id);
                    }
                }
            });
        });

        function show_film_dvd_form_modal (id)
        {
            var data = {
                _token  :'{{ csrf_token() }}', 
                film_id : {{ $Film->id }}
            }; 
            if (id != '')
            {
                data = {
                    _token  :'{{ csrf_token() }}', 
                    film_id : {{ $Film->id }},
                    dvd_id  : id
                }; 
            }

            $.ajax({
                url     : "{{ route('film_dvd_form_modal') }}",
                type    : 'POST',
                data    : data,
                success : function (data) {
                    $('#js-modal_holder').html(data);
                    $('#js-film_dvd_form_modal').modal({keyboard : false, backdrop : 'static'});
                    $(".js-wysiwyg_editor_dvd").wysihtml5({
                        toolbar: {
                            "font-styles": true, // Font styling, e.g. h1, h2, etc.
                            "emphasis": true, // Italics, bold, etc.
                            "lists": true, // (Un)ordered lists, e.g. Bullets, Numbers.
                            "html": false, // Button which allows you to edit the generated HTML.
                            "link": false, // Button to insert a link.
                            "image": false, // Button to insert an image.
                            "color": false, // Button to change color of font
                            "blockquote": true, // Blockquote
                            "size":'sm' // options are xs, sm, lg
                        }
                    });
                    
                    $('#dvd_languages').tokenfield();
                    $('#dvd_subtitles').tokenfield();
                    //$(".form-group .wysihtml5-toolbar").addClass('hidden');
                }
                ,error : function (xhr, ajaxOptions, thrownError)
                {
                    if (thrownError == 'Unauthorized')
                    {
                        window.location.reload();
                    }
                },
                statusCode: {
                    500: function(xhr) {
                        window.location.reload();
                    }
                }
            });
        }
        // FILM DVD Sorter
        $('.js-dvd_container').sortable({ 
            tolerance: 'pointer',
            update : function (event, ui) {
                var order = [];

                $('.js-dvd_container .js-individual_dvd_holder').each( function () {
                    var id = $(this).data('id');
                    order.push(id);
                });
                console.log(order);
                save_order(order, "{{ route('film_dvd_sorter') }}");
            }
        });

        $('body').on('submit', '#js-frm_dvd', function (e) {
            e.preventDefault();

            save_data($(this), "{{ route('film_dvd_save') }}", "{{ route('film_dvd_data_fetch', $Film->id) }}", $('.js-film_dvd_content_holder'));

        });

        $('body').on('click', '#js-dvd_button', function (e) {
            e.preventDefault();
            $(this).parents('.input-group-btn').children('input:file').click();
        })
        
        $('body').on('change', '#dvd_disc_image', function () {
            $('#js-dvd_text').html('- <i>' + $(this).val().replace(/.*(\/|\\)/, '') + '</i>');
        });
        $('body').on('change', '#dvd_case_cover', function () {
            $('#js-text_dvd_case_cover').html('- <i>' + $(this).val().replace(/.*(\/|\\)/, '') + '</i>');
        });
        $('body').on('dblclick', '.js-dvd_data', function (e) {
            e.preventDefault();
        });
    </script>
@endsection

