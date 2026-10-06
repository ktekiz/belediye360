<?php

namespace App\Services;

use App\Enums\TaskStatus;
use App\Models\Task;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class TaskService
{
    public function changeStatus(Task $task, TaskStatus $newStatus, User $actor, ?string $note = null, ?string $photoPath = null): Task
{
    $currentStatus = $task->status;

    if (! in_array($newStatus, $currentStatus->allowedTransitions(), true)) {
        throw ValidationException::withMessages([
            'status' => "'{$currentStatus->label()}' durumundan '{$newStatus->label()}' durumuna geçilemez.",
        ]);
    }

    $task->update(['status' => $newStatus]);

    $task->updates()->create([
        'user_id' => $actor->id,
        'old_status' => $currentStatus->value,
        'new_status' => $newStatus->value,
        'note' => $note,
        'photo_path' => $photoPath,
    ]);

    return $task->fresh();
}
    public function addNote(Task $task, User $actor, string $note, ?string $photoPath = null): Task
    {
        $task->updates()->create([
            'user_id' => $actor->id,
            'note' => $note,
            'photo_path' => $photoPath,
        ]);

        return $task->fresh();
    }
}