<?php

namespace App\Console\Commands;

use App\Services\CommandRunnerService;
use Illuminate\Console\Command;

class RunScheduledCommands extends Command
{
    protected $signature = 'scheduler:run-db';
    protected $description = 'Run scheduled commands stored in database';

    protected CommandRunnerService $commandRunner;

    public function __construct(CommandRunnerService $commandRunner)
    {
        parent::__construct();
        $this->commandRunner = $commandRunner;
    }

    public function handle(): int
    {
        $this->info('Checking for scheduled commands to run...');

        try {
            $this->commandRunner->runDueCommands();
            $this->info('Scheduled commands check completed.');
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Error running scheduled commands: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
