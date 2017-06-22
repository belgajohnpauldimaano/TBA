                    
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
                                <th width="369px">Rating</th>
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
                    
                    <script>
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
                    </script>