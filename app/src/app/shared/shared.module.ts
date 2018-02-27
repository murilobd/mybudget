import { NgModule } from '@angular/core';
import { RouterModule } from '@angular/router';
import { FlexLayoutModule } from '@angular/flex-layout';
import { MaterialModules } from './material/material-modules.module';
import { CommonLayoutComponent } from './common-layout/common-layout.component';

@NgModule({
	imports: [
		FlexLayoutModule,
		RouterModule,
		MaterialModules
	],
	declarations: [
		CommonLayoutComponent
	],
	exports: [
		CommonLayoutComponent,
		MaterialModules
	]
})
export class SharedModule { }
