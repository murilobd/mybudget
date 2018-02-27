<?php

namespace App\Helpers;

class Mail {

	public static function currency($value = 0)
	{
		return 'R$' . number_format((string) $value, 2, ',', '.');
	}

	public static function percentage($value = 0)
	{
		return number_format((string) $value, 2, ',', '.') . '%';
	}

	public static function getColor($value)
	{
		return (string) $value >= 0 ? 'green' : 'red';
	}
}