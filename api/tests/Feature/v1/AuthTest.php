<?php

namespace Tests\Feature\v1;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
	function test_register_new_user_fails()
	{
		$newuser = factory(User::class)->create(['email' => 'murilobd@gmail.com']);

		$url = '/v1/auth/register';

		$infos = [
			// 'name' => 'Murilo Delefrate',
			'email' => 'murilobd@gmail.com',
			'password' => '12345',
			'password_confirmation' => '1234'
		];

		$response = $this->callPOST($url, $infos);
		$response
			->assertExactJson([
				'error' => [
					'message' => [
						'name' => ['O campo nome é obrigatório.'],
						'email' => ['O campo email já está sendo utilizado.'],
						'password' => [
							'O campo senha deve ter pelo menos 6 caracteres.',
							'O campo senha de confirmação não confere.'
						],
					],
					'status_code' => 422
				]
			])
			->assertStatus(422);
	}

	/** @test */
	function test_login_user_fails()
	{
		$newuser = factory(User::class)->create();

		$url = '/v1/auth/login';

		$infos = [
			'email' => $newuser->email,
			'password' => '123'
		];

		$response = $this->callPOST($url, $infos);
		$response
			->assertExactJson([
				'error' => [
					'message' => 'Essas credenciais não constam em nossos registros.',
					'status_code' => 422
				]
			])
			->assertStatus(422);

	}
}
