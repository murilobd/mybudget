import { Injectable } from '@angular/core';
import { Response } from '@angular/http';
import { Observable } from 'rxjs/Observable';

@Injectable()
export class HandleHttpResponsesService {

	constructor() {
	}

	/**
	 * Handle success returns from server
	 */
	public handleSuccess(body: any) {
		if (body.data) 
			return body.data.message || body.data;

		return body || { };
	}

	/**
	* Handle Error from server
	*/
	public handleError(res: Response | any) {
		let errMsg;

		if (res instanceof Response) {
			const body = res.json() || '';
			const err = body.error || JSON.stringify(body);
			
			errMsg = err.error || err;
		} else {
			if (res.error) {
				errMsg = res.error.message || res.error.error.message || 'Problema' ;
			} else {
				errMsg = "Falhou";
			}
		}

		return Observable.throw(errMsg);
	}
}
