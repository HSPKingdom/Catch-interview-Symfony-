<?php

namespace App\App\Commands;

use App\Controller\DTO\OrderInformation;
use App\Service\Serializer\DTOSerializer;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\Output;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @property string $inputJsonLine
 */
class OrderExportCommand extends Command
{
    // Console command to access this class
    protected static $defaultName = 'app:export-order';

    private $outputFileLocation = "./public/out.";

    private $output_format;

    public function __construct()
    {
        // Get input file from env variable
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
        $this->output_format = $input->getArgument('output');
        $output->writeln("<comment>User input:" . $this->output_format . "</comment>");

        // If user argument output format not supported, Display error and exit
        if ($this->output_format != "csv") {

            $output->writeln("<comment>System only accept output format: csv, json, yaml, xml</comment>");
            $output->writeln("<error>Output format not supported, please try again!</error>");
            return 0;   // Exit
        }
        $this->outputFileLocation .= $this->output_format;

        // Process data and export to file with memory control
        return $this->streamCSVProcess($output);
    }

    /**
     * Stream the data process flow input and output with memory control
     *
     * @param OutputInterface $output
     * @return int
     */
    public function streamCSVProcess(OutputInterface $output): int
    {

        // Initialize Serializer
        $serializer = new DTOSerializer();

        // Show CSV header on the first Run
        $firstLine = true;

        // Get JSON Line file from URL
        $output->writeln("\n<fg=green>Reading File from :<href=" . $this->inputJsonLine . ">"
            . $this->inputJsonLine . "</>...</>");

        // Return error if file format is not JSON Line
        if (($path_info = pathinfo($this->inputJsonLine, PATHINFO_EXTENSION)) != "jsonl"){
            $output->writeln("\n<error>Error</error>");
            $output->writeln("\n<error>File format received: ".$path_info."</error>");
            $output->writeln("<error>This application only supports JSONL format as input file</error>");
            $output->writeln("<error>Please update the input source under .env</error>");
            return 0;
        }

        // Delete Existing file
        if (file_exists($this->outputFileLocation)) {
            unlink($this->outputFileLocation);
        }

        // Read file content
        if ( ($file_stream = fopen($this->inputJsonLine, "r"))!==false ){

            // Reading lines by line
            while (($line = stream_get_line($file_stream, 20480, "\n")) != false) {

                // Deserialize
                $orderInformation = $serializer->deserialize($line, OrderInformation::class, 'json');

                // Get Cart Total, with discount applied
                $orderExport = $orderInformation->getOrderExportInformation();

                // If the total order value is 0, skipped in the export queue
                if ($orderExport->getTotalOrderValue() == 0) {
                    $output->writeln("<comment>Order " . $orderExport->getOrderId() . " skipped, Total order value = 0</>");
                } // Add it in the export to file
                else {
                    $output->writeln("\n<fg=green>Processing Order " . $orderExport->getOrderId() . "...</fg=green>");

                    // Serialize Data
                    $serializedData = $serializer->serialize($orderExport, $this->output_format);

                    // Ignore CSV header if not the first line of data
                    if ($firstLine and $this->output_format=="csv"){
                        $firstLine = False;
                    }
                    else if (!$firstLine){
                        $serializedData = preg_split('#\n#', $serializedData, 2)[1];
                    }

                    // export to file
                    $this->writeToFile($output, $serializedData);

                    $output->writeln("<fg=green>Processed</fg=green>");
                }

            }
            fclose($file_stream);

            $output->writeln("\n\n<fg=green>Done</>");
        }
        // Return error if file cannot be opened
        else{
            $output->writeln("\n<error>Error</error>");
            $output->writeln("\n<error>Could not open file: ".$this->inputJsonLine."</error>");
            $output->writeln("<error>Please check the input source path under .env</error>");
            return 0;
        }
        return 1;
    }


    /**
     * Write data into file with output filestream
     *
     * @param OutputInterface $output
     * @param $serializedData
     * @return void
     */
    public function writeToFile(OutputInterface $output, $serializedData)
    {
        $fileStartPosition = 0;
        $fileWriteSize = 1024;
        $fileSize = strlen($serializedData);

        $output->writeln("<fg=green>Exporting to file</>");

        // Write to File
        $exportFile = fopen($this->outputFileLocation, 'a');
        while ($fileSize > $fileStartPosition) {

            // Input data into file
            fputs($exportFile, substr($serializedData, $fileStartPosition, $fileWriteSize));

            // Select next writing chunk
            $fileStartPosition += $fileWriteSize;
            if ($fileStartPosition > $fileSize) {
                $fileStartPosition = $fileSize;
            }
            $output->writeln("<fg=green>Writing... \t".ceil(($fileStartPosition/$fileSize)*100)."%</>");
        }
        fclose($exportFile);
    }

}