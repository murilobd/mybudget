import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms';
import { AuthService } from '@app/core/services/auth.service';

import { PasswordValidation } from '../password-validation';

@Component({
	selector: 'app-reset-password',
	templateUrl: './reset-password.component.html',
	styleUrls: ['./reset-password.component.scss']
})
export class ResetPasswordComponent implements OnInit {

	public form: FormGroup;

	private token: string = '';

	public errors = [];
	public backend_errors = {};

	constructor(
		private fb: FormBuilder,
		private router: Router,
		private activatedRoute: ActivatedRoute,
		private authService: AuthService) {

		this.activatedRoute.params
			.subscribe(_params => this.token = _params.token || '');
	}

	ngOnInit() {
		this.createForm();
	}

	createForm() {
		this.form = this.fb.group ( {
			email: [null , Validators.compose([ Validators.required, Validators.email ])],
			password: [null , Validators.compose([ Validators.required, Validators.minLength(6) ])],
			password_confirmation: [null , Validators.compose([ Validators.required ])],
		}, {
			validator: PasswordValidation.MatchPassword
		});
	}

	onSubmit() {
		this.errors = [];
		this.backend_errors = {};

		const values = this.form.value;
		this.authService.resetPassword(values.email, values.password, values.password_confirmation, this.token)
			.subscribe(
				res => this.router.navigate ( [ '/' ] ),
				err => this.handleError(err)
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
