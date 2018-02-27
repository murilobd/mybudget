import { NgModule, Optional, SkipSelf } from '@angular/core';
import { CommonModule } from '@angular/common';
import { HttpClientModule, HTTP_INTERCEPTORS } from '@angular/common/http';
import { RouterModule } from '@angular/router';
import { RequestInterceptorService } from './services/request-interceptor.service';
import { HandleHttpResponsesService } from './services/handle-http-responses.service';
import { AuthService } from './services/auth.service';
import { AuthGuardService } from './guards/auth-guard.service';
import { StocksService } from './services/stocks.service';
import { NotFoundComponent } from './components/not-found/not-found.component';
import './rxjs-operators';

@NgModule({
	imports: [
		CommonModule,
		HttpClientModule,
		RouterModule,
	],
	declarations: [
		NotFoundComponent
	],
	providers: [
		AuthService,
		AuthGuardService,
		{
			provide: HTTP_INTERCEPTORS,
			useClass: RequestInterceptorService,
			multi: true
		},
		HandleHttpResponsesService,
		StocksService,
	]
})
export class CoreModule {

	/**
	 * Throw an error if CoreModule is imported more than once
	 */
	constructor (@Optional() @SkipSelf() core: CoreModule) {
		if (core)
			throw new Error('Multiple instantiations of CoreModule.');
	}
	
}
