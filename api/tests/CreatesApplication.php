<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Process\Process;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

         // Delete and create sqlite database file. Guarantee database test file is correct
        $process_delete = new Process("rm -rf " . database_path('database.sqlite'));
        $process_delete->run();

        $process_create = new Process("touch " . database_path('database.sqlite'));
        $process_create->run();

        $process_chmod = new Process("chmod 777 " . database_path('database.sqlite'));
        $process_chmod->run();

        Hash::setRounds(4);

        return $app;
    }
}
