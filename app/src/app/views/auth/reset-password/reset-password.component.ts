import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms';

import { PasswordValidation } from '../password-validation';

@Component({
	selector: 'app-reset-password',
	templateUrl: './reset-password.component.html',
	styleUrls: ['./reset-password.component.scss']
})
export class ResetPasswordComponent implements OnInit {

	public form: FormGroup;

	constructor(
		private fb: FormBuilder,
		private router: Router) { }

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
		this.router.navigate ( [ '/' ] );
	}

}
