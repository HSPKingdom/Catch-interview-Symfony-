<?php

namespace App\App\Commands;

use App\Service\Serializer\DTOSerializer;
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
        // Get Output Format
        $output_format = $input->getArgument('output');
        $output->writeln("<comment>User input:" . $output_format . "</comment>");

        // If user argument output format not supported, Display error and exit
        if ($output_format != "csv" and $output_format != "json" and $output_format != "yaml" and $output_format != "xml") {
            $output->writeln("<comment>System only accept output format: csv, json, yaml, xml</comment>");
            $output->writeln("<error>Output format not supported, please try again!</error>");
            return 0;   // Exit
        }

        // TODO: Initialize Serializer

        // TODO: Deserialize JSON Object

        // TODO: Analyse and Transform object to Exportable

        // TODO: Serialize Data to output format

        // TODO: Export to file


        return 1;
    }
}