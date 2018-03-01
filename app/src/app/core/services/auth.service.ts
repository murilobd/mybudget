import { Injectable } from '@angular/core';
import { Observable } from 'rxjs/Observable';
import { Router } from '@angular/router';

import { AppConfig } from '@app/core/app.config';
import { HandleHttpResponsesService } from '@app/core/services/handle-http-responses.service';
import { HttpClient } from '@angular/common/http';

import '../rxjs-operators';

@Injectable()
export class AuthService {

	public isLoggedIn = false;

	public redirectUrl: string = null;

	public isRefreshingToken = false;

	constructor(private http: HttpClient,
				private handleHttpService: HandleHttpResponsesService,
				private router: Router) {	

		if (localStorage.getItem(AppConfig.tokenName))
			this.isLoggedIn = true;

		if (this.isLoggedIn)
			this.router.navigate(['/user/stocks']);
	}

	public getLoggedStatus(): boolean {
		return this.isLoggedIn;
	}

	/**
	 * Get token from localStorage
	 *
	 * @return: string | null
	 */
	public getToken(): string|null {
		return localStorage.getItem(AppConfig.tokenName);
	}

	/**
	 * Get refresh token from localStorage
	 *
	 * @return: string | null
	 */
	public getRefreshToken(): string|null {
		return localStorage.getItem(AppConfig.refreshTokenName);
	}


	/**
	 * Send a request to server to login user
	 *
	 * @param: email string User's e-mail
	 * @param: password string User's password
	 */
	public login(email: string, password: string): Observable<any> {
		return this.http.post('auth/login', {
							email: email,
							password: password
						})
						// @todo: I don't know why I have to set the isLoggedIn before to work. If I just set on handleLogin(), it will fail on Auth-guard
						.map((res) => {
							this.isLoggedIn = true;
							return res;
						})
						.map(this.handleLogin)
						.catch(this.handleHttpService.handleError);
	}

	/**
	 * Send a request to server to register user
	 *
	 * @param: name string User's name
	 * @param: email string User's e-mail
	 * @param: password string User's password
	 * @param: password_confirmation string User's password
	 */
	public register(name: string, email: string, password: string, password_confirmation: string): Observable<any> {
		return this.http.post('auth/register', {
							name: name,
							email: email,
							password: password,
							password_confirmation: password_confirmation
						})
						// @todo: I don't know why I have to set the isLoggedIn before to work. If I just set on handleLogin(), it will fail on Auth-guard
						.map((res) => {
							this.isLoggedIn = true;
							return res;
						})
						.map(this.handleLogin)
						.catch(this.handleHttpService.handleError);
	}

	/**
	 * Send request to server to refresh user's token
	 *
	 * @return: Observable
	 */
	public refreshToken() {
		this.isRefreshingToken = true;
		return this.http.post('auth/refreshToken', {
							refresh_token: this.getRefreshToken()
						})
						.map(this.handleRefreshToken)
						.catch(this.handleHttpService.handleError);
	}

	private handleLogin(res: any) {
		const msg = res.data.message;

		const access_token = msg.access_token;
		if (access_token) {
			localStorage.setItem(AppConfig.tokenName, access_token);
		}

		this.isLoggedIn = access_token ? true : false;

		const refresh_token = msg.refresh_token;
		if (refresh_token) {
			localStorage.setItem(AppConfig.refreshTokenName, refresh_token);
		}

		const user = msg.user;
		if (user) {
			localStorage.setItem(AppConfig.userTokenName, JSON.stringify(user));
		}

		return msg;
	}

	private handleRefreshToken(res: any): string {
		const access_token = res.access_token;
		if (access_token) {
			localStorage.setItem(AppConfig.tokenName, access_token);
		}

		const refresh_token = res.refresh_token;
		if (refresh_token) {
			localStorage.setItem(AppConfig.refreshTokenName, refresh_token);
		}

		return res;
	}

	private handleFailesRefreshToken(res: any) {
		return Observable.throw(res);
	}
	
	/**
	 * Logout user removing all local storage tokens
	 */
	public logoutUser() {
		localStorage.removeItem(AppConfig.tokenName);
		localStorage.removeItem(AppConfig.refreshTokenName);
		localStorage.removeItem(AppConfig.userTokenName);
		this.isLoggedIn = false;

		this.router.navigate(['/auth/signin']);

		return Observable.throw("User logged out");
	}

	/**
	 * Forgot password
	 *
	 * @param: string email User's email
	 * @return: 
	 */
	public forgotPassword(email: string): Observable<any> {
		return this.http.post('auth/forgot-password', {
							email: email
						})
						.map(this.handleHttpService.handleSuccess)
						.catch(this.handleHttpService.handleError);
	}

	/**
	 * Reset password
	 *
	 * @param: string email User's email
	 * @param: string password New password
	 * @param: string password_confirmation New password confirmation
	 * @param: string token Token to reset password
	 * @return: 
	 */
	public resetPassword(email: string, password: string, password_confirmation: string, token: string): Observable<any> {
		return this.http.post('auth/reset-password', {
							email: email,
							password: password,
							password_confirmation: password_confirmation,
							token: token,
						})
						.map((res) => {
							this.isLoggedIn = true;
							return res;
						})
						.map(this.handleLogin)
						.catch(this.handleHttpService.handleError);
	}

}
