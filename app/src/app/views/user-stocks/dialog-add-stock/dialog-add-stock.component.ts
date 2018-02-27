import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms';
import { MatDialogRef } from '@angular/material/dialog';
import { Observable } from 'rxjs/Observable';

import { StocksService } from '@app/core/services/stocks.service';
import { Stock } from './models/stock.interface';
import { FilterStocksService } from './services/filter-stocks.service';

@Component({
	selector: 'app-dialog-add-stock',
	templateUrl: './dialog-add-stock.component.html',
	styleUrls: ['./dialog-add-stock.component.scss'],
	providers: [ 
		FilterStocksService
	]
})
export class DialogAddStockComponent implements OnInit {

	public form: FormGroup;

	public searchedStocks$: Observable<Stock[]>;

	constructor(private fb: FormBuilder,
	            private filter: FilterStocksService,
	            public dialogRef: MatDialogRef<DialogAddStockComponent>) { }

	ngOnInit() {
		this.createForm();

		let termField = this.form.get('stock').valueChanges;
		this.searchedStocks$ = this.filter.searchStock(termField);
	}

	/**
	 * Create form
	 */
	createForm() {
		this.form = this.fb.group ( {
			stock: [null , Validators.required],
			quantity: [0 , Validators.required],
			price: [null , Validators.required],
			date: [{value: null, disabled: true} , Validators.required],
			fee: [0 , Validators.required],
		});
	}

	/**
	 * Display the symbol of selected stock in Autocomplete
	 *
	 * @param: {Stock} stock
	 * @return: string | undefined
	 */
	displayStockAutocompleteFn(stock?: Stock): string | undefined {
		return stock ? stock.symbol : undefined;
	}

	/**
	 * On submit stock form
	 */
	submit() {
		this.form.get('date').enable();
		let values = this.form.value;
		if (!values.date) {
			this.form.get('date').markAsTouched();
			return false;
		}

		values = Object.assign({}, values, {
			stock: values.stock.uuid,
			date: values.date.format('YYYY-MM-DD')
		});

		this.form.get('date').disable();
		
		this.dialogRef.close(values);
	}

}
