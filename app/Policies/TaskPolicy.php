<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, [UserRole::ADMIN, UserRole::MANAGER, UserRole::CHIEF, UserRole::STAFF], true);
    }

    public function view(User $user, Task $task): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isStaff()) {
            return $task->assigned_to === $user->id;
        }

        //sadece kendi müdürlüğü
        return $task->department_id === $user->department_id;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isManager() || $user->isChief();
    }

    public function update(User $user, Task $task): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return ($user->isManager() || $user->isChief())
            && $task->department_id === $user->department_id;
    }

    public function updateStatus(User $user, Task $task): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isStaff()) {
            return $task->assigned_to === $user->id;
        }

        return ($user->isManager() || $user->isChief())
            && $task->department_id === $user->department_id;
    }

    public function delete(User $user, Task $task): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return ($user->isManager() || $user->isChief())
            && $task->created_by === $user->id;
    }
}