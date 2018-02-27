<?php

namespace App\Http\Controllers\Auth\traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

trait AuthenticateUser
{
	/**
	 * Authenticate user with oauth
	 *
	 * @param: Illuminate\Http\Request $request
	 * @param: App\User $user
	 * @return: {token_type: string, expires_in: number, 'access_token': string, 'refresh_token': string}
	 */
	protected function authenticateUser(Request $request, $user)
	{
		// add necessary fields to request to get oauth token
		$request->request->add([
			'username' => $user->email,
			'password' => $request->password,
			'grant_type' => 'password',
			'client_id' => env('OAUTH_CLIENT_ID'),
			'client_secret' => env('OAUTH_CLIENT_SECRET'),
			'scope' => '*'
		]);

		$proxy = Request::create(
			'oauth/token',
			'POST'
		);

		return json_decode(Route::dispatch($proxy)->getContent());
	}

	/**
	 * Get LoggedUserInfos
	 *
	 * @return: array
	 */
	public function getLoggedUserInfos()
	{
		$user = Auth::user();

		return [
			'user' => [
				'id' => $user->uuid,
				'name' => $user->name,
				'email' => $user->email
			]
		];
	}
}