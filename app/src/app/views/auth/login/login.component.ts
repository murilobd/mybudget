import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms';
import { AuthService } from '@app/core/services/auth.service';

@Component({
	selector: 'app-login',
	templateUrl: './login.component.html',
	styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

	public form: FormGroup;

	public errors = [];

	constructor(
		private fb: FormBuilder,
		private router: Router,
		private authService: AuthService) {
	}

	ngOnInit() {
		this.createForm();
	}

	/**
	 * Create login form
	 */
	createForm() {
		this.form = this.fb.group ( {
			email: [null , Validators.compose([Validators.required, Validators.email])] ,
			password: [null , Validators.compose([Validators.required])]
		});
	}

	/**
	 * On Submit form
	 */
	onSubmit() {
		if (!this.form.valid)
			return false;

		this.errors = [];

		const email = this.form.get('email').value;
		const password = this.form.get('password').value;
		this.authService.login(email, password)
			.subscribe(
				res => {
					if (this.authService.redirectUrl)
						this.router.navigate([this.authService.redirectUrl]);
					else
						this.router.navigate(['/user/stocks']);
				},
				err => this.handleError(err)
			);
	}

	/**
	 * Handle error from login
	 *
	 * @param: any err
	 */
	handleError(err: any) {
		if (err instanceof Array) {
			for (let _err of err)
				this.errors.push(_err);

		} else if (err instanceof Object) {
			for (let _err of Object.values(err)) {
				if (_err instanceof Array)
					this.handleError(_err);
				else
					this.errors.push(_err);
			}
		} else if (typeof err == 'string') {
			this.errors.push(err);
		} else {
			this.errors.push("Ops! Houston, we have a problem!")
		}
	}

}
