<div class="modal fade" id="js-profile_form_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content box box-solid">
        <div class="overlay hidden">
            <i class="fa fa-refresh fa-spin"></i>
        </div>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"> Profile </h4>
      </div>
      <form id="profile_form" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ encrypt(Auth::user()->id) }}">
        <div class="modal-body">
                        <div class="pull-left"> 
                            {{-- <span class="text-red">All fields with an asterisk (*) are required.</span> --}}
                        </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="help-block text-center" id="general-error">
                    </div>


                    <!-- Custom Tabs -->
          <div class="nav-tabs-custom" style="box-shadow:none;margin-bottom:0">
            <div class="tab-content">
              <div class="tab-pane active" id="tab_x1">
                <div class="box box-solid" style="box-shadow:none;margin-bottom:0">
                    <div class="box-header">
                        <div class="box-tools">
                            <a href="#tab_x2" data-toggle="tab" class="btn btn-flat btn-xs btn-default js-update_profile"><i class="fa fa-pencil" title="Edit"></i></a>
                        </div>
                    </div>
                    <div class="box-body">
                        <table class="table">
                            <tr>
                                <th>Username/Email</th>
                                <td>{{ Auth::user()->email }}</td>
                            </tr>
                            <tr>
                                <th>Password</th>
                                <td>******</td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td>{{ ucwords(Auth::user()->first_name) }} {{ ucwords(Auth::user()->last_name) }}</td>
                            </tr>
                            <tr>
                                <th>Photo</th>
                                <td>
                                    
                                    @if (Auth::user()->photo)
                                        <img src="{{ asset('cms/users' . '/' . Auth::user()->photo) }}?v={{ date('Ymdhis') }}" style="border:3px solid grey" class="img-circle" width="200" height="200" alt="">
                                    @else
                                        <span class="profile_view_photo">
                                        <img src="{{ asset('content/film/photos/thumbnail.jpg') }}" style="border:3px solid grey" class="img-circle" width="200" height="200" alt="">
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="tab_x2">
                <form action="" id="frm_profile">
                    <div class="box box-solid" style="box-shadow:none;margin-bottom:0">
                        <div class="box-header">
                            <div class="box-tools">
                                {{-- <a href="#tab_x1" data-toggle="tab" class="btn btn-flat btn-xs btn-default"><i class="fa fa-save"></i></a> --}}
                            </div>
                        </div>
                        <div class="box-body">
                            
                            <table class="table">
                                <tr>
                                    <th>Username/Email</th>
                                    <td>{{ Auth::user()->email }}</td>
                                </tr>
                                <tr class="js-change_pw">
                                    <th>Old Password</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="password" class="form-control"  disabled name="old_password" id="old_password" value="">
                                            <div class="help-block text-center" id="old_password-error"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="js-change_pw">
                                    <th>New Password</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="password" class="form-control" disabled name="password" id="password" value="">
                                            <div class="help-block text-center" id="password-error"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="js-change_pw">
                                    <th>Confirm</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="password" class="form-control"  disabled name="password_confirmation" id="password_confirmation" value="">
                                            <div class="help-block text-center" id="password_confirmation-error"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><button type="button" class="btn btn-flat btn-danger btn-xs js-toggle_change_pw"><i class="fa fa-pencil" aria-hidden="true"></i> Change password</button></td>
                                </tr>
                                <tr>
                                    <th>First name</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="first_name" id="first_name" value="{{ Auth::user()->first_name }}">
                                            <div class="help-block text-center" id="first_name-error"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Last name</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="last_name" id="last_name" value="{{ Auth::user()->last_name }}">
                                            <div class="help-block text-center" id="last_name-error"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Photo</th>
                                    <td>
                                        
                                        <div id="my-awesome-dropzone"  class="dropzone">  
                                            <div class="dropzone-previews"></div>
                                            <div class="fallback"> 
                                                <input name="file" type="file" />
                                            </div>
                                        </div>
                                        

                                        {{-- @if (Auth::user()->photo)
                                            <img src="{{ asset('user/' .  Auth::user()->photo) }}" style="border:3px solid grey" class="img-circle" width="200" height="200" alt="">
                                        @else
                                            <span class="profile_view_photo">
                                            <img src="{{ asset('content/film/photos/thumbnail.jpg') }}" style="border:3px solid grey" class="img-circle" width="200" height="200" alt="">
                                            </span>
                                        @endif --}}
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="box-footer">
                            <div class="pull-right">
                                <a  href="#tab_x1" class="btn btn-flat btn-default btn-sm" data-toggle="tab" >Cancel</a>
                                <button type="submit" class="btn btn-flat btn-primary btn-sm">Save changes</button>
                            </div>
                        </div>
                    </div>
                </form>




                
              </div>
              <!-- /.tab-pane -->


            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->

                </div>
            </div>

        </div>
        {{-- <div class="modal-footer">
            <button type="button" class="btn btn-flat btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-flat btn-primary">Save changes</button>
        </div> --}}
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

