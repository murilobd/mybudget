<?php

namespace Tests\Feature\v1;

use App\Stock;
use App\User;
use App\UserStock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserStocksTest extends TestCase
{
	use RefreshDatabase;

	private $user;
	private $company;

	function setUp()
	{
		parent::setUp();

		$this->user = factory(User::class)->create();
	}

	/** @test */
	function test_get_user_stocks()
	{
		$url = '/v1/user/stocks';

		$user_stock1 = $this->addStockToUser(1);
		$user_stock2 = $this->addStockToUser(2);
		$user_stock3 = $this->addStockToUser(3);

		$response = $this->callGET($url, $this->user);

		$response
			->assertExactJson([
				'data' => [
					'message' => [
						'stocks' => [
							[
								'uuid' => $user_stock1->stock->uuid,
								'symbol' => $user_stock1->stock->symbol,
								'quantity' => $user_stock1->quantity,
								'avg_buy_price' => $user_stock1->price_buy,
								'last_price' => $user_stock1->stock->infos->price,
								'price_variation' => $user_stock1->stock->infos->variation,
								'last_date' => $user_stock1->stock->infos->updated_at->toIso8601String(),
								'total_profit' => ($user_stock1->stock->infos->price - $user_stock1->price_buy) * $user_stock1->quantity - $user_stock1->exchange_fee_buy,
								'total_profit_percentage' => -100,
							],
							[
								'uuid' => $user_stock2->stock->uuid,
								'symbol' => $user_stock2->stock->symbol,
								'quantity' => $user_stock2->quantity,
								'avg_buy_price' => $user_stock2->price_buy,
								'last_price' => $user_stock2->stock->infos->price,
								'price_variation' => $user_stock2->stock->infos->variation,
								'last_date' => $user_stock2->stock->infos->updated_at->toIso8601String(),
								'total_profit' => ($user_stock2->stock->infos->price - $user_stock2->price_buy) * $user_stock2->quantity - $user_stock2->exchange_fee_buy,
								'total_profit_percentage' => -100,
							],
							[
								'uuid' => $user_stock3->stock->uuid,
								'symbol' => $user_stock3->stock->symbol,
								'quantity' => $user_stock3->quantity,
								'avg_buy_price' => $user_stock3->price_buy,
								'last_price' => $user_stock3->stock->infos->price,
								'price_variation' => $user_stock3->stock->infos->variation,
								'last_date' => $user_stock3->stock->infos->updated_at->toIso8601String(),
								'total_profit' => ($user_stock3->stock->infos->price - $user_stock3->price_buy) * $user_stock3->quantity - $user_stock3->exchange_fee_buy,
								'total_profit_percentage' => -100,
							],
						]
					],
					'status_code' => 200
				]
			])
			->assertStatus(200);
	}

	/** @test */
	function test_add_stock_to_user()
	{
		$url = '/v1/user/stocks';

		$stock = Stock::first();

		$infos = [
			'stock' => $stock->uuid,
			'quantity' => 100,
			'price' => 8.45,
			'date' => '2017-10-10',
			'fee' => 10
		];

		$response = $this->callPOST($url, $infos, $this->user);
		$response
			->assertExactJson([
				'data' => [
					'message' => [
						'stock' => [
							'uuid' => $this->user->stocks->first()->uuid,
							'symbol' => $stock->symbol,
							'name' => $stock->name,
							'qtt' => 100,
							'buy_price' => 8.45,
							'exchange_fee' => 10
						]
					],
					'status_code' => 200
				]
			])
			->assertStatus(200);
	}

	/** @test */
	function test_update_user_stock_infos()
	{
		$user_stock = $this->addStockToUser(1);
		$stock2 = Stock::find(2);
		$stock2->update(['name' => 'Test stock name']);

		$infos = [
			'stock' => $stock2->uuid,
			'quantity' => 100,
			'price' => 9.45,
			'date' => '2017-10-10',
			'fee' => 10
		];

		$url = "/v1/user/stocks/{$user_stock->uuid}";

		$response = $this->callPUT($url, $infos, $this->user);

		$user_stock->refresh();

		$response
			->assertExactJson([
				'data' => [
					'message' => [
						'stock' => [
							'uuid' => $user_stock->uuid,
							'symbol' => $user_stock->stock->symbol,
							'name' => $user_stock->stock->name,
							'qtt' => $user_stock->quantity,
							'buy_price' => $user_stock->price_buy,
							'exchange_fee' => $user_stock->exchange_fee_buy,
						]
					],
					'status_code' => 200
				]
			])
			->assertStatus(200);
	}

	/** @test */
	function test_remove_stock_from_user()
	{
		$stock = $this->addStockToUser(1);

		$url = "/v1/user/stocks/{$stock->uuid}";

		$response = $this->callDELETE($url, [], $this->user);
		$response
			->assertExactJson([
				'data' => [
					'message' => 'ok',
					'status_code' => 200
				]
			])
			->assertStatus(200);
	}

	/**
	 * Add stock to user (factory UserStock)
	 *
	 * @param: int $stock_id
	 * @param: mixed $user_id
	 * @return: App\UserStock
	 */
	private function addStockToUser($stock_id, $user_id = null)
	{
		if (is_null($user_id))
			$user_id = $this->user->id;

		return factory(UserStock::class)->create([
			'stock_id' => $stock_id,
			'user_id' => $user_id
		]);
	}
}
