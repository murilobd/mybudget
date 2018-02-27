import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms';

@Component({
	selector: 'app-forgot-password',
	templateUrl: './forgot-password.component.html',
	styleUrls: ['./forgot-password.component.scss']
})
export class ForgotPasswordComponent implements OnInit {

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
		});
	}

	onSubmit() {
		this.router.navigate ( [ '/' ] );
	}

}
