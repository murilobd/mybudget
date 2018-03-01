import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms';

import { AuthService } from '@app/core/services/auth.service';

@Component({
	selector: 'app-forgot-password',
	templateUrl: './forgot-password.component.html',
	styleUrls: ['./forgot-password.component.scss']
})
export class ForgotPasswordComponent implements OnInit {

	public form: FormGroup;

	public errors = [];
	public backend_errors = {};

	constructor(
		private fb: FormBuilder,
		private router: Router,
		private authService: AuthService) { }

	ngOnInit() {
		this.createForm();
	}

	createForm() {
		this.form = this.fb.group ( {
			email: [null , Validators.compose([ Validators.required, Validators.email ])],
		});
	}

	onSubmit() {
		this.authService.forgotPassword(this.form.value.email)
			.subscribe(
				res => {
					alert('Check your inbox! You will receive soon an e-mail with instructions to reset your password');
					this.router.navigate ( [ '/auth/signin' ] );
				},
				err => {
					this.handleError(err);
					console.warn(err);
				}
			);
	}

	handleError(err: any) {
		if (err instanceof Array) {
			for (let _err of err)
				this.errors.push(_err);

		} else if (err instanceof Object) {
			const keys = Object.keys(err);
			for (let i = 0; i < keys.length; i++) {

				this.backend_errors = Object.assign({}, this.backend_errors, {[keys[i]]: err[keys[i]][0]});

				const control = this.form.controls[keys[i]];
				control.setErrors({backend: true});
			}
		} else if (typeof err == 'string') {
			this.errors.push(err);
		} else {
			this.errors.push("Ocorreu um problema")
		}
	}

}
