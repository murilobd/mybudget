import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms';
import { AuthService } from '@app/core/services/auth.service';
import { PasswordValidation } from '../password-validation';


@Component({
	selector: 'app-register',
	templateUrl: './register.component.html',
	styleUrls: ['./register.component.scss']
})
export class RegisterComponent implements OnInit {

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
			name: [null , Validators.compose([ Validators.required, Validators.minLength(2) ])] ,
			email: [null , Validators.compose([ Validators.required, Validators.email ])] ,
			password: [null , Validators.compose([ Validators.required, Validators.minLength(6) ])],
			password_confirmation: [null, Validators.required]
		}, {
			validator: PasswordValidation.MatchPassword
		});
	}

	onSubmit() {
		const values = this.form.value;
		this.errors = [];
		this.backend_errors = {};

		this.authService.register(values.name, values.email, values.password, values.password_confirmation)
			.subscribe(
				res => this.router.navigate(['/']),
				err => {
					console.warn(err);
					this.handleError(err);
				}
			);
	}

	/**
	 * Handle errors from login
	 *
	 * @param: any res
	 * @return: 
	 */
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
