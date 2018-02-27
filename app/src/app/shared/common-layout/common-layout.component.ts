import { Component, OnInit } from '@angular/core';
import { AuthService } from '@app/core/services/auth.service';

@Component({
	selector: 'app-common-layout',
	templateUrl: './common-layout.component.html',
	styleUrls: ['./common-layout.component.scss']
})
export class CommonLayoutComponent implements OnInit {

	constructor(private authService: AuthService) { }

	ngOnInit() {
	}

	logout() {
		this.authService.logoutUser();
	}

}
