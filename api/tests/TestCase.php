<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp()
	{
		parent::setUp();

		Artisan::call('migrate');
		Artisan::call('db:seed');
	}

	public function tearDown()
	{
		Artisan::call('migrate:reset');
		parent::tearDown();
	}

	private function authenticateUser($user) {
		Passport::actingAs(
			$user,
			['*']
		);
	}

	public function callGET($uri, $user = null)
	{
		$header = (isset($user) ? ['Authorization' =>  'Bearer ' . $this->authenticateUser($user)] : []);
		return $this->json('GET', $uri, $header);
	}

	public function callPOST($uri, $data, $user = null)
	{
		$header = (isset($user) ? ['Authorization' =>  'Bearer ' . $this->authenticateUser($user)] : []);
		return $this->json('POST', $uri, $data, $header);
	}

	public function callPUT($uri, $data, $user = null)
	{
		$header = (isset($user) ? ['Authorization' =>  'Bearer ' . $this->authenticateUser($user)] : []);
		return $this->json('PUT', $uri, $data, $header);
	}

	public function callDELETE($uri, $data, $user = null)
	{
		$header = (isset($user) ? ['Authorization' =>  'Bearer ' . $this->authenticateUser($user)] : []);
		return $this->json('DELETE', $uri, $data, $header);
	}
}
