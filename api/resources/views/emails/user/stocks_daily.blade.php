@component('mail::message')
# Daily Stocks E-mail

@php
	$stocks = $user->getConsolidatedStocksInfos();
	$today = \Carbon\Carbon::today()->format('d/m/Y');
	$total_invested = 0;
	$total_earned = 0;
	$sum_total_profit = 0;
	$sum_total_profit_percentage = 0;
@endphp

## Check how your stocks performed today ({{ $today }})!

@component('mail::table')
| Stock | Avg buy price<sup>*</sup> | Final price | Profit<sup>**</sup> |
| :------: | :------: | :------:   | :------: |
@for ($i = 0; $i < count($stocks); $i++)
	@php
		$symbol = $stocks[$i]['symbol'];
		$avg_price = $stocks[$i]['avg_buy_price'];
		$last_price = $stocks[$i]['last_price'];
		$price_variation = $stocks[$i]['price_variation'];
		$total_profit = $stocks[$i]['total_profit'];
		$total_profit_percentage = $stocks[$i]['total_profit_percentage'];

		$quantity = $stocks[$i]['quantity'];
		$total_invested += $quantity * $avg_price;
		$total_earned += $quantity * $last_price;
		$sum_total_profit += $total_profit;
		$sum_total_profit_percentage += $total_profit_percentage;
	@endphp
	| <strong>{{ $symbol }}</strong> | @currency {{ $avg_price }} @endcurrency | @currency {{ $last_price }} @endcurrency \(@percentage(['color' => true]) {{ $price_variation }} @endpercentage) | @currency {{ $total_profit }} @endcurrency \(@percentage(['color' => true]) {{ $total_profit_percentage }} @endpercentage) |
@endfor
| | | | @currency(['color' => true]) {{ $sum_total_profit }} @endcurrency \(@percentage(['color' => true]) {{ $sum_total_profit_percentage/count($stocks) }} @endpercentage) |
@endcomponent
<p>
	<small>* Avarage price of bought stocks</small><br>
	<small>** Value already subtracting exchange fees</small>
</p>

@component('mail::table')
| Total invested | Final position |
| :------: | :------: |
| @currency {{ $total_invested }} @endcurrency | @currency(['color' => true]) {{ $total_earned }} @endcurrency|
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
