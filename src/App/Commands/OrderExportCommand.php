<?php

namespace App\App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @property string $inputJsonLine
 */
class OrderExportCommand extends Command
{
    // Console command to access this class
    protected static $defaultName = 'app:export-order';

    // Define output file location
    /** @var string */
    private $outputFilePath = "./public/";
    /** @var string */
    private $outputFilename = "out";


    protected function configure()
    {
        // Set the access Command with parameter OUTPUT to specify output format (Default as CSV)
        $this->setDescription('Export Order')
            ->addArgument('output', InputArgument::OPTIONAL, 'Output file format', 'csv');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        return 1;
    }
}