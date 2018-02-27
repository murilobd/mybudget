export interface Stock {
	symbol: string;
	quantity: number;
	avg_buy_price: number;
	final_price: number;
	price_variation: number;
	total_profit: number;
	total_profit_percentage: number;
}