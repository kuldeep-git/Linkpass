<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use Auth;

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

    use AuthenticatesUsers;
    protected $username = 'email';

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/account';

    /**
     * Where to redirect users to profile page on first login.
     *
     * @var string
     */
    protected $redirectToProfile = '/profile_settings';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        /*$this->middleware('guest:admin')->except('logout');
        $this->middleware('guest:franchise')->except('logout');*/
    }

    protected function credentials(Request $request)
    {
        return array_merge($request->only($this->username(), 'password'), ['status' => '1']);
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function creatorLogin()
    {
        return view('auth.login', array('isCreator' => 1));
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function postLogin(Request $request)
    {
        $errors = $this->validateLogin($request);

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponseAjax($request);
        }

        return $this->sendFailedLoginResponseAjax($request);
    }

    protected function sendFailedLoginResponseAjax(Request $request)
    {
        return response()->json(['success' => false, 'message' => trans('auth.failed')]);
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendLoginResponseAjax(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }

        // Validate Creator
        if($request->get('auser_type') == '1' && in_array($this->guard()->user()->user_type, ['0', '2']))
        {
            $request->session()->invalidate();

            $request->session()->regenerateToken();

            $this->incrementLoginAttempts($request);

            return $this->sendFailedLoginResponseAjax($request);
        }

        // Validate User
        if($request->get('auser_type') == '0' && in_array($this->guard()->user()->user_type, ['1']))
        {
            $request->session()->invalidate();

            $request->session()->regenerateToken();

            $this->incrementLoginAttempts($request);

            return $this->sendFailedLoginResponseAjax($request);
        }

        if(empty($this->guard()->user()->last_login_at))
        {
            $redirectUrl = $this->redirectToProfile;
        }
        else
        {
            $redirectUrl = $this->redirectPath();
        }

        User::where('id', $this->guard()->user()->id)->update(array('last_login_at' => Carbon::now()));

        return response()->json(['success' => true, 'redirectUrl' => url($redirectUrl)]);
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }

        // Validate Creator
        if($request->get('user_type') == '1' && in_array($this->guard()->user()->user_type, ['0', '2']))
        {
            $request->session()->invalidate();

            $request->session()->regenerateToken();

            $this->incrementLoginAttempts($request);

            return $this->sendFailedLoginResponse($request);
        }

        // Validate User
        if($request->get('user_type') == '0' && in_array($this->guard()->user()->user_type, ['1']))
        {
            $request->session()->invalidate();

            $request->session()->regenerateToken();

            $this->incrementLoginAttempts($request);

            return $this->sendFailedLoginResponse($request);
        }

        if(empty($this->guard()->user()->last_login_at))
        {
            $redirectUrl = $this->redirectToProfile;
        }
        else
        {
            $redirectUrl = $this->redirectPath();
        }

        User::where('id', $this->guard()->user()->id)->update(array('last_login_at' => Carbon::now()));

        return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect()->intended($redirectUrl);
    }
}
