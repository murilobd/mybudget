import { Component, OnInit } from '@angular/core';
import { StocksService } from '@app/core/services/stocks.service';
import { MatDialog } from '@angular/material';
import { DialogAddStockComponent } from './dialog-add-stock/dialog-add-stock.component';
import { Stock } from './models/stock';

@Component({
	selector: 'app-user-stocks',
	templateUrl: './user-stocks.component.html',
	styleUrls: ['./user-stocks.component.scss']
})
export class UserStocksComponent implements OnInit {

	public stocks: Stock[];

	constructor(private stocksService: StocksService,
				private dialog: MatDialog) { }

	ngOnInit() {
		this.getUserStocks();
	}

	/**
	 * Get all user stocks
	 */
	getUserStocks() {
		this.stocksService.getUserStocks()
			.subscribe(
				res => this.stocks = res.stocks,
				err => console.warn(err)
			);
	}

	/**
	 * Open AddStock Dialog
	 */
	openAddStockDialog() {
		this.dialog.open(DialogAddStockComponent, {
				width: '55vw'
			})
			.afterClosed().subscribe(
				stockInfos => this.addStockToUser(stockInfos)
			);
	}

	/**
	 * Add stock to user
	 *
	 * @param: object infos
	 */
	private addStockToUser(infos) {
		if (!infos)
			return;
		this.stocksService.addStockToUser(infos)
			.subscribe(
				res => this.getUserStocks(),
				err => {
					alert('Falha ao adicionar ação');
					console.warn(err);
				}
			);
	}

	/**
	 * Remove all stocks from user by stock's symbol
	 *
	 * @param: string symbol Stock's symbol
	 */
	onRemoveStock(symbol) {
		this.stocksService.removeBySymbolAllStocksFromUser(symbol)
			.subscribe(
				res => this.getUserStocks(),
				err => {
					alert('Falha ao excluir ação');
					console.warn(err);
				}
			)
	}

}
