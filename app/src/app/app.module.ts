import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';

import { CoreModule } from '@app/core/core.module';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';

@NgModule({
	imports: [
		BrowserModule,
		BrowserAnimationsModule,
		CoreModule,
		AppRoutingModule,
	],
	declarations: [
		AppComponent
	],

	providers: [],
	bootstrap: [AppComponent]
})
export class AppModule { }
