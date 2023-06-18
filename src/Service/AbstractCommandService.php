<?php

namespace App\Service;

use Symfony\Component\Process\Process;

abstract readonly class AbstractCommandService
{
    private const PROCESS_TIMEOUT = 600;

    protected function runCommand(array $command, $printOutput = false): Process
    {
        $process = new Process($command);
        $process->setTimeout(self::PROCESS_TIMEOUT);
        $process->start();

        if ($printOutput) {
            $this->printOutput($process);
        }

        $process->wait();

        return $process;
    }

    protected function runCommandWithoutIterativeOutput(array $command): void
    {
        $process = new Process($command);
        $process->run();

        echo $process->getErrorOutput();
    }

    private function printOutput(Process $process): void
    {
        while ($process->isRunning()) {
            foreach ($process as $type => $data) {
                if ($process::OUT === $type) {
                    $lines = explode("\n", $data);
                    $this->parseOutput($lines);
                } else {
                    echo 'Error: ';
                    $errorOutput = "\033[0;31m" . $data . "\033[0m";
                    echo $errorOutput;
                }
            }
        }
    }

    private function parseOutput(array $lines): void
    {
        foreach ($lines as $possiblyJsonLine) {
            $arrayData = json_decode($possiblyJsonLine, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $this->prettyPrint($arrayData);
            } else {
                echo $possiblyJsonLine . PHP_EOL;
            }
        }
    }

    private function prettyPrint(array $arrayData): void
    {
        echo "\n[";
        foreach ($arrayData as $key => $value) {
            echo sprintf("\n    \"%s\" => \"%s\",", $key, $value);
        }
        echo "\n]\n\n";
    }
}