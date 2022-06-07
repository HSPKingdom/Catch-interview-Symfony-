<?php

namespace App\App\Commands;

use App\Controller\DTO\OrderInformation;
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

    public function __construct()
    {
        $this->inputJsonLine = $_ENV['JSON_LINE_INPUT'];
        parent::__construct();
    }

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

        // Initialize Serializer
        $serializer = new DTOSerializer();

        // TODO: Deserialize JSON Object and Transform Object to exportable
        $orderData = $this->getJsonLineAsClass($serializer, $output);

        // TODO: Serialize Data to output format

        // TODO: Export to file


        return 1;
    }

    /**
     * Serialize Data to Class Object and transform it to OrderExport Class
     *
     * @param DTOSerializer $serializer
     * @param OutputInterface $output
     * @return array
     */
    public function getJsonLineAsClass(DTOSerializer $serializer, OutputInterface $output): array
    {

        // Array for Export orders
        $serializedOrders = array();

        // Get JSON Line file from URL
        $output->writeln("\n<fg=green>Reading File from :<href=" . $this->inputJsonLine . ">"
            . $this->inputJsonLine . "</>...</>");
        $json_file = fopen($this->inputJsonLine, "r");

        // Open File stream and read line by line
        if ($json_file) {
            while (($line = fgets($json_file)) != false) {

                // Deserialize
                $orderInformation = $serializer->deserialize($line, OrderInformation::class, 'json');

                // Get Cart Total, with discount applied
                // TODO: Get return data from func
                $orderInformation->getOrderExportInformation();

                // TODO: If the total order value is 0, skipped in the export queue

                // TODO: Add it in the export queue

            }
            fclose($json_file);

            $output->writeln("<fg=green>Done</>");
        }

        return $serializedOrders;

    }

}