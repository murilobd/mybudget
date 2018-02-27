import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule } from '@angular/forms';
import { MAT_DIALOG_DEFAULT_OPTIONS } from '@angular/material';
import { MatMomentDateModule } from '@angular/material-moment-adapter';
import { SharedModule } from '@app/shared/shared.module';
import { FlexLayoutModule } from '@angular/flex-layout';
import { DateAdapter } from '@angular/material/core';
import { MomentDateAdapter } from '@angular/material-moment-adapter';

import { UserStocksRoutingModule } from './user-stocks-routing.module';
import { StocksComponent } from './stocks/stocks.component';
import { UserStocksComponent } from './user-stocks.component';
import { DialogAddStockComponent } from './dialog-add-stock/dialog-add-stock.component';

@NgModule({
	imports: [
		CommonModule,
		SharedModule,
		ReactiveFormsModule,
		FlexLayoutModule,
		MatMomentDateModule,
		UserStocksRoutingModule
	],
	declarations: [
		StocksComponent,
		UserStocksComponent,
		DialogAddStockComponent
	],
	entryComponents: [
		DialogAddStockComponent
	],
	providers: [
		{ provide: DateAdapter, useClass: MomentDateAdapter },
		{ provide: MAT_DIALOG_DEFAULT_OPTIONS, useValue: {hasBackdrop: true} }
	]
})
export class UserStocksModule { }
