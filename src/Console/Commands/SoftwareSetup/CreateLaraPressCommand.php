<?php namespace PortOneFive\ProjectTools\Console\Commands\SoftwareSetup;

use PortOneFive\ProjectTools\Console\Command;

class CreateLaraPressCommand extends Command
{
    protected $name = 'LaraPress';

    protected function fire()
    {
        $this->info('Beginning installation of LaraPress...');
    }
}
