<?php namespace PortOneFive\ProjectTools\Console\Commands;

use PortOneFive\ProjectTools\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class CreateProjectCommand extends Command {

    protected $name = 'project:create';

    protected $softwareCommands = [
        'LaraPress' => 'PortOneFive\\ProjectTools\\Console\\Commands\\SoftwareSetup\\CreateLaraPressCommand',
    ];

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['project-name', InputArgument::REQUIRED, 'Project Name']
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['empty', 'e', InputOption::VALUE_NONE, 'Quick-create empty project']
        ];
    }

    public function fire()
    {
        $this->info("\nCreating project: " . $this->argument('project-name') . "\n");

        foreach ($this->softwareCommands as $softwareCommand => $command)
        {
            $this->getApplication()->add(new $command);
        }

        $software = $this->choice(
            'What software would you like to initialize this project with?',
            [
                'larapress' => 'LaraPress',
                'laravel'   => 'Laravel',
                'wordpress' => 'WordPress',
                'none'      => 'None'
            ]
        );

        if ($software !== 'None')
        {
            if ( ! $this->getApplication()->has($software))
            {
                throw new \BadMethodCallException('Could not find software installation command for ' . $software);
            }

            $this->call($software);
        }
    }
}
