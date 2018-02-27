import { environment } from '@environments/environment';

export const AppConfig = {
	apiEndpoint: environment.apiEndpoint,
	tokenName: environment.tokenName,
	refreshTokenName: environment.refreshtokenName,
	userTokenName: environment.usertokenName
};
