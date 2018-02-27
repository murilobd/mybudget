import { Injectable, Injector } from '@angular/core';
import { HttpRequest, HttpHandler, HttpEvent, HttpInterceptor, HttpResponse, HttpErrorResponse } from '@angular/common/http';
import { Observable } from 'rxjs/Observable';
import { catchError, mergeMap } from 'rxjs/operators';
import { BehaviorSubject } from 'rxjs/BehaviorSubject';

import { AuthService } from '@app/core/services/auth.service';
import { AppConfig } from '@app/core/app.config';

@Injectable()
export class RequestInterceptorService implements HttpInterceptor {

	private isRefreshingToken: boolean = false;
	private tokenSubject: BehaviorSubject<string> = new BehaviorSubject<string>(null);

	constructor (private injector: Injector) {
	}

	/**
	 * Add Bearer token to header request
	 *
	 * @param: HttpRequest req
	 * @return: HttpRequest
	 */
	addToken (req: HttpRequest<any>): HttpRequest<any> {
		let auth = this.injector.get(AuthService);

		req = req.clone({ 
			setHeaders: { 
				Authorization: `Bearer ${auth.getToken()}`
			},
			url: AppConfig.apiEndpoint + req.url
		});

		return req;
	}

	/**
	 * Intercept Http Request to add token to it and check it's result
	 *
	 * @param: HttpRequest request
	 * @param: HttpHandler next
	 * @return: Observable
	 */
	intercept (request: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
		// If is refreshing auth token and receive a different request, store it to call it later
		if (this.isRefreshingToken && request.url !== 'auth/refreshToken') {
			return this.tokenSubject
				.filter(token => token != null)
				.take(1)
				.switchMap(token => {
					return next.handle(this.addToken(request));
				});
		}

		return next.handle(this.addToken(request))
			.map((event: HttpEvent<any>) => {
				if (event instanceof HttpResponse) {
					return event;
				}
			})
			.catch(error => {
				if (error instanceof HttpErrorResponse) {
					switch ((<HttpErrorResponse>error).status) {
						case 401:
							console.warn('Erro 401');
							return this.handle401error(request, next, error);

					}
				}

				return Observable.throw(error);
			});
	}

	/**
	 * Handle 401 request response error. Try to refresh user's token and call last http requests with new token
	 *
	 * @param: HttpRequest request
	 * @param: HttpHandler next
	 * @return: Observable<any> 
	 */
	handle401error (request: HttpRequest<any>, next: HttpHandler, error: any): Observable<any> {
		this.isRefreshingToken = true;
		this.tokenSubject.next(null);
		let auth = this.injector.get(AuthService);

		if (auth.isRefreshingToken) {
			auth.logoutUser();
			this.isRefreshingToken = false;
			this.tokenSubject.next(null);
			return Observable.throw(error);
		}


		return auth.refreshToken()
				.flatMap(newToken => {
					console.log('newToken', newToken);
					this.isRefreshingToken = false;
					this.tokenSubject.next(newToken);
					auth.isRefreshingToken = false;
					return next.handle(this.addToken(request));
				})
				.catch(error => {
					console.log('err refreshToken');
					return Observable.throw(error);
				});
	}
}