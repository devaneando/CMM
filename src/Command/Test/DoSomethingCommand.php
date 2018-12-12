<?php

namespace App\Command\Test;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DoSomethingCommand extends Command
{
    public function __construct(string $name = null)
    {
        parent::__construct($name);
    }

    protected static $defaultName = 'test:do-something';

    protected function configure()
    {
        $this->setDescription('Do something I want for testing.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>'.$this->adminListBlockService->getName().'</info>');
    }
}
