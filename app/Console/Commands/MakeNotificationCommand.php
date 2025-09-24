<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Models\User;
use App\Notifications\TaskAssignedNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class MakeNotificationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:make-notification-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $userId = $this->ask('Type user id');
        $taskId = $this->ask('Type task id');
        $task = Task::query()->find($taskId);

        if ($task) {
            $user = User::query()->find($userId);
            if ($user) {
                Notification::send($user, new TaskAssignedNotification($task));
                $this->info('Notification sent successfully.');
            } else {
                $this->error('User not found.');
            }
        } else {
            $this->error('Task not found.');
        }
    }
}
