<?php

namespace App\Commands;

use App\App\Commands\OrderExportCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;
use function PHPUnit\Framework\assertStringMatchesFormatFile;

class OrderExportCommandTest extends KernelTestCase
{

    public function testExecute(){


        $filePath = __DIR__."\orders.jsonl";
        $output_file = __DIR__."\\testout.csv";
        $kernel = static::createKernel();
        $kernel->boot();

        $application = new Application($kernel);
        $application->add(new OrderExportCommand($filePath));

        $command = $application->find('app:export-order');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command' => $command->getName()
        ));

        assertStringMatchesFormatFile($output_file, 'orderId,orderDatetime,totalOrderValue,averageUnitPrice,distinctUnitCount,totalUnitsCount,customerState
1002,2019-03-08T13:45:01+0000,83.637,14.704285714286,3,7,"NEW SOUTH WALES"
');

    }
}
