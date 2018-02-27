<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Http\JsonResponse;

class ApiFormRequest extends FormRequest {

	/**
	 * (Overwrite method) Handle a failed validation attempt.
	 *
	 * @param  \Illuminate\Contracts\Validation\Validator  $validator
	 * @return void
	 *
	 * @throws \Illuminate\Http\Exceptions\HttpResponseException
	 */
	protected function failedValidation(Validator $validator)
	{
		$status_code = IlluminateResponse::HTTP_UNPROCESSABLE_ENTITY;
		$data = [
			'error' => [
				'message' => $validator->errors(),
				'status_code' => $status_code
			]
		];

		$response = IlluminateResponse::json($data, $status_code, []);

		throw (new HttpResponseException($response));
	}

}