import { NgModule } from '@angular/core';
import { MatCardModule } from '@angular/material/card';
import { MatIconModule, MatInputModule, MatCheckboxModule,
		MatSidenavModule, MatButtonModule, MatToolbarModule, MatMenuModule,
		MatTableModule, MatDialogModule, MatAutocompleteModule, MatDatepickerModule,
		MatTooltipModule, } from '@angular/material';

@NgModule({
	imports: [
		MatIconModule,
		MatCardModule,
		MatInputModule,
		MatCheckboxModule,
		MatSidenavModule,
		MatButtonModule,
		MatToolbarModule,
		MatMenuModule,
		MatTableModule,
		MatDialogModule,
		MatAutocompleteModule,
		MatDatepickerModule,
		MatTooltipModule,
	],
	exports: [
		MatIconModule,
		MatCardModule,
		MatInputModule,
		MatCheckboxModule,
		MatSidenavModule,
		MatButtonModule,
		MatToolbarModule,
		MatMenuModule,
		MatTableModule,
		MatDialogModule,
		MatAutocompleteModule,
		MatDatepickerModule,
		MatTooltipModule,
	],
})
export class MaterialModules { }
