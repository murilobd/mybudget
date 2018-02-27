import { Component, ViewChild, Input, Output, EventEmitter } from '@angular/core';
import { MatTable } from '@angular/material/table';
import * as moment from 'moment';

import { Stock } from '../models/stock';

@Component({
	selector: 'app-stocks',
	templateUrl: './stocks.component.html',
	styleUrls: ['./stocks.component.scss']
})
export class StocksComponent {

	public columnsToDisplay = ['symbol', 'buy_price', 'last_price', 'qtt', 'total_profit_percentage', 'actions'];
	public dataSource = [];

	@ViewChild (MatTable) table;
	@Input ('stocks') 
	set stocks(_stocks: Stock[]) {
		if (!_stocks)
			return;
		
		this.dataSource = _stocks;
		this.table.renderRows();
	}
	@Output ('onRemoveStock') onRemoveStock = new EventEmitter<string>();

	constructor() { }

	/**
	 * Remove stock
	 *
	 * @param: Stock stock
	 */
	removeStock(stock: Stock) {
		this.onRemoveStock.emit(stock.symbol);
	}

	formatLastPriceDate(date: string): string {
		return 'Last update at ' + moment(date, moment.ISO_8601).format('lll');
	}


}