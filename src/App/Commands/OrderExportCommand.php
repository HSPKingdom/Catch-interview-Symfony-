<?php

namespace App\App\Commands;

use App\Controller\DTO\OrderInformation;
use App\Service\Serializer\DTOSerializer;
use Symfony\Component\Config\Definition\Exception\Exception;
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

        // Deserialize JSON Object and Transform Object to exportable
        $orderData = $this->getJsonLineAsClass($serializer, $output);

        // TODO: Serialize Data to output format
        $output->writeln("\n<fg=green>Serializing Data...</>");
        $serializedData = $serializer->serialize($orderData, $output_format);
        $output->writeln("<fg=green>Done</>");

        // Export to file
        $this->writeToFile($output, $output_format, $serializedData);

        // Display Success message
        $output->writeln('<fg=green>Success</>');

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

        // Return error if file format is not JSON Line
        if (($path_info = pathinfo($this->inputJsonLine, PATHINFO_EXTENSION)) != "jsonl"){
            $output->writeln("\n<error>Error</error>");
            $output->writeln("\n<error>File format received: ".$path_info."</error>");
            $output->writeln("<error>This application only supports JSONL format as input file</error>");
            $output->writeln("<error>Please update the input source under .env</error>");
            die();
        }

        if ( file_exists($this->inputJsonLine) && ($file_stream = fopen($this->inputJsonLine, "rb"))!==false ){

            // Open File stream and read line by line
            while (($line = stream_get_line($file_stream, 20480, "\n")) != false) {

                // Deserialize
                $orderInformation = $serializer->deserialize($line, OrderInformation::class, 'json');

                // Get Cart Total, with discount applied
                $orderExport = $orderInformation->getOrderExportInformation();

                // If the total order value is 0, skipped in the export queue
                if ($orderExport->getTotalOrderValue() == 0) {
                    $output->writeln("<comment>Order " . $orderExport->getOrderId() . " skipped, Total order value = 0</>");
                } // Add it in the export queue
                else {
                    array_push($serializedOrders, $orderExport);
                    $output->writeln("<fg=green>Order " . $orderExport->getOrderId() . " Processed</fg=green>");
                }


            }
            fclose($file_stream);

            $output->writeln("<fg=green>Done</>");
        }
        else{
            $output->writeln("\n<error>Error</error>");
            $output->writeln("\n<error>Could not open file: ".$this->inputJsonLine."</error>");
            $output->writeln("<error>Please check the input source path under .env</error>");
            die();
        }
        return $serializedOrders;
    }

    /**
     * Write data into file with output filestream
     *
     * @param OutputInterface $output
     * @param $output_format
     * @param $serializedData
     * @return void
     */
    public function writeToFile(OutputInterface $output, $output_format, $serializedData)
    {
        $fileLocation = $this->outputFilePath . $this->outputFilename . "." . $output_format;
        $fileStartPosition = 0;
        $fileReadSize = 2048;
        $fileSize = strlen($serializedData);

        $output->writeln("\n<fg=green>Exporting to file ".$fileLocation."</>");

        //
        $exportFile = fopen($fileLocation, 'w');
        while ($fileSize > $fileStartPosition) {

            // Input data into file
            fputs($exportFile, substr($serializedData, $fileStartPosition, $fileReadSize));

            // Select next writing chunk
            $fileStartPosition += $fileReadSize;
            if ($fileStartPosition > $fileSize) {
                $fileStartPosition = $fileSize;
            }

            $output->writeln("<fg=green>Writing... \t".ceil(($fileStartPosition/$fileSize)*100)."%</>");

        }

        fclose($exportFile);

    }

}