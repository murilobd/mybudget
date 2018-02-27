import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { FlexLayoutModule } from '@angular/flex-layout';

import { MaterialModules } from '@app/shared/material/material-modules.module';

import { AuthRoutingModule } from './auth-routing.module';
import { LoginComponent } from './login/login.component';
import { LayoutComponent } from './layout/layout.component';
import { RegisterComponent } from './register/register.component';
import { ForgotPasswordComponent } from './forgot-password/forgot-password.component';
import { ResetPasswordComponent } from './reset-password/reset-password.component';

@NgModule({
	imports: [
		CommonModule,
		MaterialModules,
		FormsModule,
		ReactiveFormsModule,
		FlexLayoutModule,
		AuthRoutingModule,
	],
	declarations: [
		LayoutComponent,
		LoginComponent,
		RegisterComponent,
		ForgotPasswordComponent,
		ResetPasswordComponent,
	]
})
export class AuthModule { }
