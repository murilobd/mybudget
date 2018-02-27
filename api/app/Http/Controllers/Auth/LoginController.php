<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\traits\AuthenticateUser;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
	use AuthenticatesUsers, AuthenticateUser;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest')->except('logout');
	}

	/**
	 * Get a validator for an incoming login request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data)
	{
		return Validator::make($data, [
			$this->username() => 'required|string',
			'password' => 'required|string',
		]);
	}

	/**
	 * Handle a login request to the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
	 */
	public function login(Request $request)
	{
		$validator = $this->validator($request->all());
		if ($validator->fails())
			return $this->respondValidationFailed($validator->errors());

		// If the class is using the ThrottlesLogins trait, we can automatically throttle
		// the login attempts for this application. We'll key this by the username and
		// the IP address of the client making these requests into this application.
		if ($this->hasTooManyLoginAttempts($request)) {
			$this->fireLockoutEvent($request);

			return $this->sendLockoutResponse($request);
		}

		if ($this->attemptLogin($request)) {
			return $this->sendLoginResponse($request);
		}

		// If the login attempt was unsuccessful we will increment the number of attempts
		// to login and redirect the user back to the login form. Of course, when this
		// user surpasses their maximum number of attempts they will get locked out.
		$this->incrementLoginAttempts($request);

		return $this->sendFailedLoginResponse($request);
	}

	/**
	 * The user has been authenticated.
	 * Generate user JWT Token and Refresh Token from oauth an return it
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  mixed  $user
	 * @return mixed
	 */
	protected function authenticated(Request $request, $user)
	{
		$auth_token = $this->authenticateUser($request, $user);
		$userInfos = $this->getLoggedUserInfos();

		return $this->respondSuccess(array_merge((array)$auth_token, $userInfos));
	}

	/**
	 * Send the response after the user was authenticated.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	protected function sendLoginResponse(Request $request)
	{
		$this->clearLoginAttempts($request);

		return $this->authenticated($request, $this->guard()->user());
	}

	/**
	 * Get the failed login response instance.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 *
	 * @throws ValidationException
	 */
	protected function sendFailedLoginResponse(Request $request)
	{
		return $this->respondFailed(trans('auth.failed'));
	}

	/**
	 * Refresh user's oauth token
	 *
	 * @param Request $request
	 * @return mixed
	 */
	public function refreshToken(Request $request)
	{
		$request->request->add([
			'grant_type' => 'refresh_token',
			'refresh_token' => $request->refresh_token,
			'client_id' => env('OAUTH_CLIENT_ID'),
			'client_secret' => env('OAUTH_CLIENT_SECRET'),
		]);

		$proxy = Request::create(
			'/oauth/token',
			'POST'
		);

		return Route::dispatch($proxy);
	}
}
