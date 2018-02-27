<?php

use App\Holiday;
use Illuminate\Database\Seeder;

class Holidays2018Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$holidays = [
    		['date' => '01-01', 'description' => 'Ano novo'],
    		['date' => '01-15', 'description' => 'Bolsa de NY fechada (Aniversário de Martin Luther King)'],
    		['date' => '01-25', 'description' => 'Aniversário de São Paulo'],
    		['date' => '02-12', 'description' => 'Carnaval'],
    		['date' => '02-13', 'description' => 'Carnaval'],
    		['date' => '02-19', 'description' => 'Bolsa de NY fechada (Aniversário de Washington)'],
    		['date' => '03-30', 'description' => 'Paixão de Cristo'],
    		['date' => '05-01', 'description' => 'Dia do trabalho'],
    		['date' => '05-29', 'description' => 'Bolsa de NY fechada (Memorial day)'],
    		['date' => '05-31', 'description' => 'Corpus Christi'],
    		['date' => '07-04', 'description' => 'Bolsa de NY fechada (Dia da independência dos EUA)'],
    		['date' => '07-09', 'description' => 'Revolução constitucionalista'],
    		['date' => '09-03', 'description' => 'Bolsa de NY fechada (Dia do trabalho nos EUA)'],
    		['date' => '09-07', 'description' => 'Independência do Brasil'],
    		['date' => '10-08', 'description' => 'Bolsa de NY fechada (Columbus day)'],
    		['date' => '10-12', 'description' => 'Nossa senhora aparecida'],
    		['date' => '11-02', 'description' => 'Finados'],
    		['date' => '11-12', 'description' => 'Bolsa de NY fechada (Veterans day)'],
    		['date' => '11-15', 'description' => 'Proclamação da república'],
    		['date' => '11-20', 'description' => 'Consciência negra'],
    		['date' => '11-23', 'description' => 'Bolsa de NY fechada (Thanksgiving day)'],
    		['date' => '12-24', 'description' => 'Véspera de Natal'],
    		['date' => '12-25', 'description' => 'Natal'],
    		['date' => '12-31', 'description' => 'Véspera de ano novo'],
    	];

    	foreach ($holidays as $holiday) {
    		Holiday::firstOrCreate([
    			'date' => '2018-'.$holiday['date']
    		], [
    			'description' => $holiday['description']
    		]);
    	}
    }
}
