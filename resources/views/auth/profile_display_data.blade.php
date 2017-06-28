            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              {{-- <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image"> --}}
              <span class="hidden-xs">{{ ucwords(Auth::user()->first_name) }} {{ ucwords(Auth::user()->last_name) }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                @if (Auth::user()->photo)
                  <img src="{{ asset('cms/users' . '/' . Auth::user()->photo) }}?v={{ date('Ymdhis') }}" class="img-circle" alt="User Image">
                @else
                  <img src="{{ asset('content/film/photos/thumbnail.jpg') }}" class="img-circle" alt="User Image">
                @endif

                <p>
                  {{ App\User::USER_ROLES[Auth::user()->role - 1] }}
                  <small></small>
                </p>
              </li>
              <!-- Menu Body -->
              {{-- <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>
                <!-- /.row -->
              </li> --}}
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat js-view_profile">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">Sign out</a>
                  <form id="logout-form" method="post" action="{{ route('logout') }}" style="display:none">{{ csrf_field() }}</form>
                </div>
              </li>
            </ul>