<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:tmp')]
#[Description('Command description')]
class tmp extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
