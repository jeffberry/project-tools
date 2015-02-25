<?php namespace PortOneFive\ProjectTools;

use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class Application extends BaseApplication {

    protected $name = 'Port One Five Project Tools';

    protected $version = '1.0.0';

    protected $directory = '';

    protected $configFile = 'portonefive.config';

    public function __construct($directory)
    {
        parent::__construct($this->name, $this->version);

        $this->setDirectory($directory);
    }

    public function bootstrap()
    {
        \Dotenv::load($this->directory);

        $this->registerCommands();
    }

    public function setDirectory($directory)
    {
        $this->directory = $directory;
    }

    protected function registerCommands()
    {
        $commands = Finder::create()->files()->depth(0)->in(__DIR__ . '/Console/Commands')->name('*Command.php');

        foreach ($commands as $command)
        {
            /** @var SplFileInfo $command */
            $className = __NAMESPACE__ . '\\Console\\Commands\\' . $command->getBasename('.php');
            $this->add(new $className);
        }
    }
}
