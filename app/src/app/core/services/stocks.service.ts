import { Injectable } from '@angular/core';
import { Observable } from 'rxjs/Observable';
import { Stock } from '@app/views/user-stocks/dialog-add-stock/models/stock.interface';

import { HandleHttpResponsesService } from '@app/core/services/handle-http-responses.service';
import { HttpClient } from '@angular/common/http';

import '../rxjs-operators';

@Injectable()
export class StocksService {

	constructor(private http: HttpClient,
				private handleHttpService: HandleHttpResponsesService) { }

	/**
	 * Get all logged user stocks
	 *
	 * @return: Observable<any>
	 */
	public getUserStocks(): Observable<any> {
		return this.http.get(`user/stocks`)
			.map(this.handleHttpService.handleSuccess)
			.catch(this.handleHttpService.handleError);
	}

	/**
	 * Add stock to user
	 *
	 * @return: Observable<any>
	 */
	public addStockToUser(infos): Observable<any> {
		return this.http.post(`user/stocks`, infos)
			.map(this.handleHttpService.handleSuccess)
			.catch(this.handleHttpService.handleError);
	}

	/**
	 * Add stock to user
	 *
	 * @return: Observable<any>
	 */
	public removeBySymbolAllStocksFromUser(symbol: string): Observable<any> {
		return this.http.delete(`user/stocks/all/${symbol}`)
			.map(this.handleHttpService.handleSuccess)
			.catch(this.handleHttpService.handleError);
	}

	/**
	 * Search for all stocks that has `term`
	 *
	 * @param: string term Term to search in stocks
	 *
	 * @return: Observable<any>
	 */
	public search(term: string): Observable<any> {
		return this.http.get(`stocks/search/${term}`)
			.map(this.handleHttpService.handleSuccess)
			.catch(this.handleHttpService.handleError);	
	}

}
