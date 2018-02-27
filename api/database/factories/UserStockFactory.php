<?php

use Faker\Generator as Faker;

$factory->define(App\UserStock::class, function (Faker $faker) {
	static $user_id;
	static $stock_id;

	return [
		'uuid' => $faker->uuid,
		'user_id' => $user_id ?: factory(App\User::class)->create()->id,
		'stock_id' => $stock_id ?: App\Stock::whereBetween('id', [1, 100])->get()->first()->id,
		'quantity' => 100,
		'date_buy' => $faker->dateTimeBetween('-1 year', 'now'),
		'price_buy' => $faker->numberBetween(1, 100),
		'exchange_fee_buy' => $faker->numberBetween(0, 10),
		'created_at' => \Carbon\Carbon::now(),
		'updated_at' => \Carbon\Carbon::now()
	];
});
