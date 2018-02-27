import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms';

import { PasswordValidation } from '../password-validation';


@Component({
	selector: 'app-register',
	templateUrl: './register.component.html',
	styleUrls: ['./register.component.scss']
})
export class RegisterComponent implements OnInit {

	public form: FormGroup;

	constructor(
		private fb: FormBuilder,
		private router: Router) { }

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
		this.router.navigate ( [ '/' ] );
	}
}
