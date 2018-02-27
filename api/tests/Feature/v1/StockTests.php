<?php

namespace Tests\Feature\v1;

use App\Stock;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StockTests extends TestCase
{
	use RefreshDatabase;

	private $user;

	function setUp()
	{
		parent::setUp();

		$this->user = factory(User::class)->create();
	}

	/** @test */
	function test_search_stock()
	{
		$term = 'val';

		$url = "/v1/stocks/search/{$term}";

		$stocks = Stock::where('symbol', 'like', "%{$term}%")
					->orWhere('name', 'like', "%{$term}%")
					->get();

		$response = $this->callGET($url, $this->user);
		$response
			->assertExactJson([
				'data' => [
					'message' => [
						'stocks' => [
							[
								'uuid' => $stocks->first()->uuid,
								'name' => $stocks->first()->name,
								'symbol' => $stocks->first()->symbol,
							]
						]
					],
					'status_code' => 200
				]
			])
			->assertStatus(200);
	}
}
