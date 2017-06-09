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