import { Injectable } from '@angular/core';
import { AbstractControl } from '@angular/forms';
import { StocksService } from '@app/core/services/stocks.service';
import { Stock } from '../models/stock.interface';
import { Observable } from 'rxjs/Observable';

@Injectable()
export class FilterStocksService {
	
	constructor(private stockService: StocksService) { }

	/**
	 * Search stock based on a search term
	 *
	 * @param: Observable<string> term
	 * @return: Observable<Stock[]>
	 */
	public searchStock(term: Observable<string>): Observable<Stock[]> {
			return term
				.startWith('')
				.debounceTime(300)
				.filter(term => term !== '' && typeof term !== 'object')
				.flatMap(query => this.stockService.search(query).map(res => res.stocks));
	}


}
