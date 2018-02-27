import { Injectable } from '@angular/core';
import { CanActivate, Router, ActivatedRouteSnapshot, RouterStateSnapshot } from '@angular/router';
import * as jwt_decode from 'jwt-decode';
import { AuthService } from '@app/core/services/auth.service';
import { AppConfig } from '@app/core/app.config';

@Injectable()
export class AuthGuardService implements CanActivate {

	constructor(private authService: AuthService, private router: Router) {}

	/**
	 * Protect routes
	 */
	canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): boolean {
		let url: string = state.url;
		
		return this.checkLogin(url);
	}

	/**
	 * Verify if user is logged in to continue or redirect to login page
	 *
	 * @param: url string URL user is trying to access
	 * @return: bool
	 */
	checkLogin(url: string): boolean {
		const token = localStorage.getItem(AppConfig.tokenName);

		if (this.authService.isLoggedIn && this.validateJWTtoken(token))
			return true;

		// as user isn't logged in, remove any stored token
		this.authService.logoutUser();

		// Store the attempted URL for redirecting
		this.authService.redirectUrl = url;

		return false;
	}

	/**
	 * Validate JWT Token. If token is still valid, 
	 *
	 * @param: string token
	 * @return: boolean
	 */
	validateJWTtoken(token) {
		if(!token)
			return false;

		try {
			const decode = jwt_decode(token);
			return true;
		} catch (Exception) {

			this.authService.logoutUser();
			return false;
		}
	}

}
