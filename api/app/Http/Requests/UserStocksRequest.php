<?php

namespace App\Http\Requests;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Support\Facades\Auth;

class UserStocksRequest extends ApiFormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return Auth::check();
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'stock' => 'required|exists:stocks,uuid',
			'quantity' => 'required|numeric',
			'price' => 'required|numeric',
			'date' => 'required|date_format:Y-m-d',
			'fee' => 'required|numeric',
		];
	}

	/**
     * Get custom messages for validator errors.
     *
     * @return array
     */
	public function messages()
	{
		return [
			'date.required' => 'O campo data de compra da ação é obrigatório.',
			'date.date_format' => 'A data de compra é inválida (formato).'
		];
	}
}
