<div class="modal fade" id="js-film_crew_form_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content box box-solid">
        <div class="overlay hidden">
            <i class="fa fa-refresh fa-spin"></i>
        </div>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Update Film Crew</h4>
      </div>
      <form id="js-frm_film_crew">
        <div class="modal-body">
            <div class="form-group">
                <div class=""> 
                    <span class="text-red"><span>Use a comma (,) to separate each crew.</span></span>
                </div>
            </div>
            {{ csrf_field() }}
            <input type="hidden" name="film_id" value="{{ $film_id }}">
            <div class="help-block text-center" id="general-error"></div>

            @if ($FilmCrew)
                @foreach($PERSON_ROLES as $key => $val)
                    <div>
                        <p>
                            <?php 
                                $c = $FilmCrew->filter(function ($crew) use($key) {
                                        return $crew->role == $key;
                                    }); 
                                    $names = explode(' ', $val);
                                    $elName = implode('_', $names);
                            ?>
                            <div class="form-group">
                                <label for="">{{ ucwords(strtolower($val)) }}</label>
                                {{-- <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div> --}}
                                        <?php $data = ''; ?>
                                        @if ($c->count() > 0)
                                            @foreach ($c as $crew)
                                                <?php $data .= $crew->person->name . ', '; ?>
                                            @endforeach
                                        @endif
                                        <input type="text" autoComplete="off" name="{{ strtolower($elName) }}" id="{{ strtolower($elName) }}" class="form-control tokenfield-typeahead js-crew_inputs" value="{{$data}}">
                                        
                                    {{-- </div> --}}
                                <div class="help-block text-center" id="{{ strtolower($elName) }}-error"></div>
                            </div>
                        </p>
                    </div>
                @endforeach
            @endif

        </div>
        <div class="modal-footer">
            <div class="pull-left">
                <p class="text-danger"></p>
            </div>
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btn-flat">Save changes</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->