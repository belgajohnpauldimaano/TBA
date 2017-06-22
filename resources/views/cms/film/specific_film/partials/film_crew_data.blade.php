            
                <div class="box-header with-border">
                    <a href="#" class="box-header__toggle"><i class="fa fa-caret-square-o-down" aria-hidden="true"></i></a>
                    <h3 class="box-title">Film Crew</h3>
                    <div class="box-tools"><button class="btn btn-flat btn-primary btn-sm js-btn_manage_people"><i class="fa fa-pencil"></i> Manage</button></div>
                </div>
                <div class="overlay hidden"><i class="fa fa-refresh fa-spin"></i></div>
                <div class="collapse">
                    <div class="box-body">
                        <table class="table table-bordered table-striped">
                            @if ($FilmCrew)
                                    @foreach($PERSON_ROLES as $key => $val)
                                        <tr>
                                            <th width="369px">{{ $val }}</th>
                                            <td>
                                                <?php 
                                                    $c = $FilmCrew->filter(function ($crew) use($key) {
                                                                return $crew->role == $key;
                                                    }); 
                                                ?>
                                                @if ($c->count() > 0)
                                                    @foreach ($c as $crew)
                                                        <span class="label label-primary">{{ $crew->person->name }}</span>
                                                    @endforeach
                                                @else
                                                    <p style="margin-bottom: 0">n/a</p>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </div>
                        </table>
                    </div>
                </div>