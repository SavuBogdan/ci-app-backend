<?php

namespace App\Service;

use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

abstract readonly class AbstractCommandService
{
    private const PROCESS_TIMEOUT = 600;

    protected function runCommand(array $command, $printOutput = false): Process
    {
        $process = new Process($command);
        $process->setTimeout(self::PROCESS_TIMEOUT);

        $output = new BufferedOutput();
        $process->run(function ($type, $buffer) use ($output, $printOutput) {
            $output->write($buffer, false, OutputInterface::OUTPUT_RAW);
            if ($printOutput) {
                echo $buffer;
            }
        });

//        $storedOutput = $output->fetch();
//        echo addcslashes($storedOutput, "\e");
//        echo stripcslashes($storedOutput);

        return $process;
    }
}