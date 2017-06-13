                        <div class="col-sm-6">

                            <div class="form-group">
                                <label for="">Title</label>
                                <h3 class="margin">
                                    <span>{{ $Film->title }}</span>
                                </h3>
                            </div>
                            
                            <div>
                                <label for="">Genre</label>
                                <h5 class="margin">
                                    {{ ($Film != NULL ? $Film->genre : 'Not yet set') }}
                                </h5>
                            </div>

                            <div>
                                <label for="">Running Time</label>
                                <h5 class="margin">
                                    {{ ($Film->running_time != NULL ? $Film->running_time : 'Not yet set') }}
                                </h5>
                            </div>
                            
                            <div>
                                <label for="">Release Status</label>
                                <h5 class="margin">
                                    {{ ($Film->release_status != NULL ? $RELEASE_STATUS[$Film->release_status] : 'Not yet set') }}
                                </h5>
                            </div>

                        </div>

                        <div class="col-sm-6">
                        
                            
                            <div>
                                <label for="">Release Date</label>
                                <h5 class="margin">
                                    {{ ($Film->release_date != NULL ? Date('d F Y', strtotime($Film->release_date)) : 'Not yet set') }}
                                    {{-- ($Film->release_date != NULL ? Date('l, jS \of F Y', strtotime($Film->release_date)) : 'Not yet set') --}}
                                </h5>
                            </div>
                            
                            <div>
                                <label for="">Ratings</label>
                                <h5 class="margin">
                                    {{ ( $Film->rating ? $RATINGS[$Film->rating] : 'Not yet set' ) }}
                                </h5>
                            </div>

                            
                            <div>
                                <label for="">Sell Sheet</label>
                                <h5 class="margin">
                                    {{ ($Film->sell_sheet != NULL ? $Film->sell_sheet : 'None uploaded') }}
                                </h5>
                            </div>

                            <div>
                                <label for="">Hash Tags</label>
                                <h5 class="margin">
                                    @if($Film->hash_tags != NULL)
                                       <?php
                                            //$hash_tags_arr = explode(',', $Film->hash_tags);
                                        ?>
                                            <span class="text-light-blue">{{ $Film->hash_tags }}</span>
                                        {{-- @foreach($hash_tags_arr as $val)
                                            <span class="text-light-blue">{{ $val }}</span>
                                        @endforeach --}}
                                    @endif
                                </h5>
                            </div>

                        </div>
                        <div class="col-sm-12">
                            <div class="box box-solid js-film_synopsis_holder">
                                <div class="overlay hidden"><i class="fa fa-refresh fa-spin"></i></div>
                                <div class="box-body">
                                    <div class="">
                                        <label for="">Synopsis</label> <button class="btn btn-flat btn-primary btn-sm pull-right js-update_sysnopsis" data-edit="false"><i class="fa fa-pencil"></i> Update Synopsis</button>
                                    </div>
                                    <br>
                                    <blockquote class="js-film_synopsis_content_holder">
                                        <p>
                                            {!! ($Film->synopsis != NULL ? $Film->synopsis : 'Not yet populated') !!}
                                        </p>
                                    </blockquote>
                                    <div class="js-synopsis_editor" style="display:none">
                                        <textarea placeholder="Write synopsis" style="width: 100%; height: 300px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="js-synopsis_textarea" id="js-synopsis_textarea" cols="30" rows="10" class="js-wysiwyg_editor">{{ ($Film->synopsis != NULL ? $Film->synopsis : '') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script>
                            $(".js-wysiwyg_editor").wysihtml5();
                        </script>