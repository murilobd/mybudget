import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { LayoutComponent } from './layout/layout.component';
import { LoginComponent } from './login/login.component';
import { RegisterComponent } from './register/register.component';
import { ForgotPasswordComponent } from './forgot-password/forgot-password.component';
import { ResetPasswordComponent } from './reset-password/reset-password.component';

const routes: Routes = [{
	path: 'auth',
	component: LayoutComponent,
	children: [
		{ path: 'signin',  component: LoginComponent },
		{ path: 'signup',  component: RegisterComponent },
		{ path: 'forgot-password',  component: ForgotPasswordComponent },
		{ path: 'reset-password/:token',  component: ResetPasswordComponent },
	]

}];

@NgModule({
	imports: [RouterModule.forChild(routes)],
	exports: [RouterModule]
})
export class AuthRoutingModule { }
