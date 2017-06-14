            
                <div class="box-header with-border">
                    <h3 class="box-title">Film Crew</h3>
                    <div class="box-tools"><button class="btn btn-flat btn-primary btn-sm js-btn_manage_people"><i class="fa fa-pencil"></i> Manage</button></div>
                </div>
                <div class="overlay hidden"><i class="fa fa-refresh fa-spin"></i></div>
                <div class="box-body">
                    <div class="row">
                            <div class="col-sm-12">
                                @if ($FilmCrew)
                                    @foreach($PERSON_ROLES as $key => $val)
                                        <div>
                                            <strong>{{ $val }}</strong>
                                            {{-- {{ json_encode($Person) }} --}}
                                            <p>
                                                <?php 
                                                    $c = $FilmCrew->filter(function ($crew) use($key) {
                                                                return $crew->role == $key;
                                                    }); 
                                                ?>
                                                @if ($c->count() > 0)
                                                    @foreach ($c as $crew)
                                                        {{ $crew->person->name }},
                                                    @endforeach
                                                @else
                                                    <p>No crew for this role</p>
                                                @endif
                                            </p>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        
                    </div>
                </div>