<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Validation\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
	  * @var $statusCode = int
	  */
	protected $statusCode = IlluminateResponse::HTTP_OK;

	/**
	  * @return mixed
	  */
	public function getStatusCode()
	{
		return $this->statusCode;
	}

	/**
	  * @param mixed $statusCode
	  * @return $this
	  */
	public function setStatusCode($statusCode)
	{
		$this->statusCode = $statusCode;

		return $this;
	}

	/**
	  * @param string $message
	  * @return $this->respondWithError
	  */
	public function respondNotFound($message = "not_found")
	{
		return $this->setStatusCode(IlluminateResponse::HTTP_NOT_FOUND)
					->respondWithError($message);
	}

	/**
	  * @param string $message
	  * @return $this->respond
	  */
	public function respondFailed($message = '')
	{
		return $this->setStatusCode(IlluminateResponse::HTTP_UNPROCESSABLE_ENTITY)
					->respond([
						'error' => [
							'message' => $message,
							'status_code' => $this->getStatusCode()
						]
					]);
	}

	/**
	  * @param string $message
	  * @return $this->respond
	  */
	public function respondValidationFailed($errors)
	{
		return $this->setStatusCode(IlluminateResponse::HTTP_UNPROCESSABLE_ENTITY)
					->respond([
						'error' => [
							'message' => $errors,
							'status_code' => $this->getStatusCode()
						]
					]);
	}

	/**
	  * @param string $message
	  * @return $this->respond
	  */
	public function respondSuccess($message = "ok")
	{
		return $this->setStatusCode(IlluminateResponse::HTTP_OK)
					->respond([
						'data' => [
							'message' => $message,
							'status_code' => $this->getStatusCode()
						]
					]);
	}

	/**
	  * @param string $message
	  * @param array $headers
	  * @return Response::json
	  */
	private function respond($data, $headers = [])
	{
		return \Response::json($data, $this->getStatusCode(), $headers);
	}
}
