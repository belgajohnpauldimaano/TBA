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