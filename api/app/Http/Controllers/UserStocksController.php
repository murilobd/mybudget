<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStocksRequest;
use App\Stock;
use App\UserStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserStocksController extends Controller
{
	function __construct()
	{
		$this->middleware('auth:api');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$user = Auth::user();

		$stocks = $user->getConsolidatedStocksInfos();

		return $this->respondSuccess([
			'stocks' => $stocks
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param    $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(UserStocksRequest $request)
	{
		$user = Auth::user();
		$stock = Stock::where('uuid', $request->stock)->get()->first();

		$user_stock = $user->stocks()->create([
			'stock_id' => $stock->id,
			'quantity' => $request->quantity,
			'date_buy' => $request->date,
			'price_buy' => $request->price,
			'exchange_fee_buy' => $request->fee
		]);
		if (!$user_stock)
			return $this->respondFailed('failed_adding_stock_to_user');

		return $this->respondSuccess([
			'stock' => $user_stock->toArray()
		]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		// 
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UserStocksRequest $request, $uuid)
	{
		$user = Auth::user();

		$user_stock = $user->stocks()->where('uuid', $uuid)->get()->first();
		if (!$user_stock)
			return $this->respondFailed('stock_not_found');

		$stock = Stock::where('uuid', $request->stock)->get()->first();

		$user_stock_update = $user_stock->update([
			'stock_id' => $stock->id,
			'quantity' => $request->quantity,
			'date_buy' => $request->date,
			'price_buy' => $request->price,
			'exchange_fee_buy' => $request->fee
		]);

		if (!$user_stock_update)
			return $this->respondFailed('failed_updating_stock_to_user');

		return $this->respondSuccess([
			'stock' => $user_stock->toArray()
		]);
	}

	/**
	 * Remove all stocks from user based on stock symbol
	 *
	 * @param: string $symbol Stock symbol
	 * @return: Illuminate\Http\Response
	 */
	public function removeAllStocksFromSymbol($symbol)
	{
		$user = Auth::user();

		$stock = Stock::where('symbol', $symbol)->get()->first();
		if (!$stock)
			return $this->respondFailed('stock_not_found');

		$user->stocks()->where('stock_id', $stock->id)->delete();

		return $this->respondSuccess();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  string  $uuid
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($uuid)
	{
		$user = Auth::user();
		$stock = $user->stocks()->where('uuid', $uuid)->get()->first();
		if (!$stock)
			return $this->respondFailed('stock_not_found');

		if (!$stock->delete())
			return $this->respondFailed('failed_deleting_stock_from_user');

		return $this->respondSuccess();
	}
}
