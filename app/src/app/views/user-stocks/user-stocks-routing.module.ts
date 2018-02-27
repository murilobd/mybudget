import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { UserStocksComponent } from './user-stocks.component';
import { CommonLayoutComponent } from '@app/shared/common-layout/common-layout.component';

const routes: Routes = [{
	path: 'user',
	component: CommonLayoutComponent,
	children: [
		{ path: '', redirectTo: '/user/stocks' },
		{ path: 'stocks', component: UserStocksComponent }
	]
}];

@NgModule({
	imports: [RouterModule.forChild(routes)],
	exports: [RouterModule]
})
export class UserStocksRoutingModule { }
