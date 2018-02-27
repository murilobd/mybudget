import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { AppComponent } from './app.component';
import { AuthGuardService } from '@app/core/guards/auth-guard.service';
import { NotFoundComponent } from '@app/core/components/not-found/not-found.component';

const routes: Routes = [
	{ path: '', redirectTo: '/user', pathMatch: 'full' },
	{ path: '', loadChildren: './views/auth/auth.module#AuthModule' },
	{
		path: '',
		canActivate: [AuthGuardService],
		children: [
			{ path: '', loadChildren: './views/user-stocks/user-stocks.module#UserStocksModule' },
		]
	},
	{ path: '**', component: NotFoundComponent }
];

@NgModule({
	imports: [RouterModule.forRoot(routes)],
	exports: [RouterModule]
})
export class AppRoutingModule { }
