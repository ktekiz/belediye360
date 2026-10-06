<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Enums\UserRole;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        if ($user->isStaff()) {
            abort(403, 'Bu sayfaya erişim yetkiniz yok.');
        }

        $baseQuery = Task::query();

        if (! $user->isAdmin()) {
            $baseQuery->where('department_id', $user->department_id);
        }

        $stats = [
            'total' => (clone $baseQuery)->count(),
            'pending' => (clone $baseQuery)->where('status', TaskStatus::PENDING)->count(),
            'in_progress' => (clone $baseQuery)->where('status', TaskStatus::IN_PROGRESS)->count(),
            'completed' => (clone $baseQuery)->where('status', TaskStatus::COMPLETED)->count(),
            'overdue' => (clone $baseQuery)
                ->whereNotIn('status', [TaskStatus::COMPLETED, TaskStatus::CANCELLED])
                ->whereNotNull('due_date')
                ->where('due_date', '<', now())
                ->count(),
        ];

        $byDepartment = (clone $baseQuery)
            ->selectRaw('department_id, count(*) as total')
            ->groupBy('department_id')
            ->with('department')
            ->get();
        $byDepartment = (clone $baseQuery)
            ->selectRaw('department_id, count(*) as total')
            ->groupBy('department_id')
            ->with('department')
            ->get();
        
        $byPriority = (clone $baseQuery)
            ->whereNotIn('status', [TaskStatus::COMPLETED, TaskStatus::CANCELLED])
            ->selectRaw('priority, count(*) as total')
            ->groupBy('priority')
            ->get()
            ->keyBy(fn ($row) => $row->priority->value);
        $staffPerformance = User::where('role', UserRole::STAFF)
            ->when(! $user->isAdmin(), fn ($q) => $q->where('department_id', $user->department_id))
            ->withCount([
                'assignedTasks as completed_count' => fn ($q) => $q->where('status', TaskStatus::COMPLETED),
                'assignedTasks as total_count',
            ])
            ->orderByDesc('completed_count')
            ->get();

            return view('dashboard', compact('stats', 'byDepartment', 'byPriority', 'staffPerformance', 'user'));
    }
}