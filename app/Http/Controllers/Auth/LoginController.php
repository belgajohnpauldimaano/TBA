<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Validator;
use Illuminate\Http\Request;
use Crypt;
use Illuminate\Support\Facades\Hash;

use App\User;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    // use AuthenticatesUsers;
    use AuthenticatesUsers {
        logout as performLogout;
    }
    public function logout(Request $request)
    {
        $this->performLogout($request);
        return redirect()->route('login');
    }
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/cms';
    protected $logoutRedirectPath  = '/login';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except(['logout', 'profile_form_modal', 'upload_photo', 'profile_save', 'profile_display_data']);
    }

    public function profile_form_modal () 
    {
        return view('auth.profile')->render();
    }

    public function upload_photo (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profile_photo' => 'mimes:png,jpeg'
        ]); 

        if ($validator->fails()) {
            return response()->json(['errCode' => 1, 'messages' => 'Invalid photo upload.']);
        }

        if ($request->hasFile('profile_photo'))
        {
            $User = User::where('id', $request->user_id)->first();
            if (!$User)
            {
                return response()->json(['errCode' => 1, 'messages' => 'Invalid user.']);
            }

            $file_name = '';
            if ($User->photo == '' || $User->photo == NULL)
            {
                $file_name = str_random(30) . '.' . $request->profile_photo->getClientOriginalExtension();
                $User->photo = $file_name;
                $User->save();
            }
            else
            {
                $file_name = $User->photo;
            }

            $request->profile_photo->move(public_path('cms/users'), $file_name);
            return response()->json(['errCode' => 0, 'messages' => 'Photo successfully saved.']);
        }
    }

    public function profile_display_data (Request $request) 
    {
        $User = User::where('id', decrypt($request->id))->first();

        if ($User)
        {
            return view('auth.profile_display_data', ['User' => $User])->render();
        }
    }
    public function profile_save (Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'old_password'                  => 'nullable|min:6',
            'password'                      => 'nullable|min:6|confirmed',
            'password_confirmation'         => 'nullable|min:6',
            'first_name'                    => 'required',
            'last_name'                     => 'required'
        ]); 

        if ($validator->fails()) 
        {
            return response()->json(['errCode' => 1, 'messages' => $validator->getMessageBag()]);
        }

        $User = User::where('id', decrypt($request->id))->first();

        if (!$User)  // user does not exists
        {
            return response()->json(['errCode' => 2, 'messages' => 'Invalid user.']);
        }
        if ($request->old_password != NULL)
        {
            $verified = password_verify($request->old_password, $User->password);
            if (!$verified) // check for old password if invalid
            {
                return response()->json(['errCode' => 2, 'messages' => 'Invalid old password.']);
            }

            if ($request->password == NULL)
            {
                return response()->json(['errCode' => 2, 'messages' => 'Password should not be empty.']);
            }

            $User->password     = bcrypt($request->password);
        }

        $User->first_name   = $request->first_name;
        $User->last_name    = $request->last_name;
        $User->save();

        return response()->json(['errCode' => 0, 'messages' => 'Profile successfully updated']);
    }
}
