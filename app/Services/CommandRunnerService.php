<?php

namespace App\Services;

use App\Models\ScheduledCommand;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

class CommandRunnerService
{
    /**
     * Run all scheduled commands that are due
     */
    public function runDueCommands(): void
    {
        $dueCommands = ScheduledCommand::where('is_active', true)->get();

        foreach ($dueCommands as $scheduledCommand) {
            if ($scheduledCommand->shouldRun()) {
                $this->runCommand($scheduledCommand);
            }
        }
    }

    /**
     * Run a specific scheduled command
     */
    public function runCommand(ScheduledCommand $scheduledCommand): void
    {
        try {
            Log::info("Running scheduled command: {$scheduledCommand->name}");

            if ($scheduledCommand->run_in_background) {
                $this->runInBackground($scheduledCommand);
            } else {
                $this->runInForeground($scheduledCommand);
            }

            $scheduledCommand->markAsRun();
            Log::info("Completed scheduled command: {$scheduledCommand->name}");
        } catch (\Exception $e) {
            Log::error("Failed to run scheduled command: {$scheduledCommand->name}", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Run command in foreground using Artisan
     */
    protected function runInForeground(ScheduledCommand $scheduledCommand): void
    {
        $command = $scheduledCommand->command;
        $arguments = $scheduledCommand->arguments ?? [];

        // Set timeout if specified
        if ($scheduledCommand->timeout > 0) {
            ini_set('max_execution_time', $scheduledCommand->timeout);
        }

        Artisan::call($command, $arguments);

        $output = Artisan::output();
        Log::info("Command output for {$scheduledCommand->name}: " . $output);
    }

    /**
     * Run command in background using Process
     */
    protected function runInBackground(ScheduledCommand $scheduledCommand): void
    {
        $fullCommand = $scheduledCommand->getFullCommand();
        $artisanCommand = "php " . base_path('artisan') . " {$fullCommand}";

        $process = Process::fromShellCommandline($artisanCommand);
        $process->setTimeout($scheduledCommand->timeout);

        // Run in background
        $process->start();

        Log::info("Started background command: {$scheduledCommand->name} with PID: " . $process->getPid());
    }

    /**
     * Get all active scheduled commands
     */
    public function getActiveCommands(): \Illuminate\Database\Eloquent\Collection
    {
        return ScheduledCommand::where('is_active', true)
            ->orderBy('next_run_at')
            ->get();
    }

    /**
     * Enable/disable a scheduled command
     */
    public function toggleCommand(int $commandId, bool $active = null): bool
    {
        $command = ScheduledCommand::findOrFail($commandId);
        $command->is_active = $active ?? !$command->is_active;

        if ($command->is_active) {
            $command->calculateNextRun();
        }

        return $command->save();
    }
}
