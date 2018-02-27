import {AbstractControl} from '@angular/forms';

// reference: https://scotch.io/@ibrahimalsurkhi/match-password-validation-with-angular-2
export class PasswordValidation {
	
	/**
	 * Get password and password_confirmation fields from form and compare their values. If dosn't match, set an error to password_confirmation field
	 */
	static MatchPassword(AC: AbstractControl) {
		let password = AC.get('password').value; // to get value in input tag
		let confirmPassword = AC.get('password_confirmation').value; // to get value in input tag
		if (password !== confirmPassword) {
			AC.get('password_confirmation').setErrors( { MatchPassword: true } )
		} else {
			return null
		}
	}

}