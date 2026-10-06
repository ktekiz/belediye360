<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Models\Department;
use App\Models\Task;
use App\Models\User;
use App\Services\TaskService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function __construct(private readonly TaskService $taskService)
    {
    }

    public function index(Request $request): View
{
    $this->authorize('viewAny', Task::class);

    $user = $request->user();

    $query = Task::with(['department', 'assignee', 'creator'])->latest();

    if ($user->isStaff()) {
        $query->where('assigned_to', $user->id);
    } elseif ($user->isAdmin()) {
        
        if ($request->filled('department_id')) {
            $query->where('department_id', $request->integer('department_id'));
        }
    } else {
        
        $query->where('department_id', $user->department_id);
    }

    $tasks = $query->paginate(10);

    $departments = $user->isAdmin()
        ? \App\Models\Department::orderBy('name')->get()
        : collect();

    return view('tasks.index', compact('tasks', 'departments'));
}

    public function create(Request $request): View
    {
        $this->authorize('create', Task::class);

        $user = $request->user();

        $departments = $user->isAdmin()
            ? Department::where('is_active', true)->orderBy('name')->get()
            : Department::where('id', $user->department_id)->get();

        $staff = User::where('role', 'staff')
            ->when(! $user->isAdmin(), fn ($q) => $q->where('department_id', $user->department_id))
            ->orderBy('name')
            ->get();

        return view('tasks.create', compact('departments', 'staff'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Task::class);

        $user = $request->user();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'department_id' => 'required|exists:departments,id',
            'assigned_to' => 'nullable|exists:users,id',
            'priority' => 'required|in:low,medium,high,urgent',
            'address' => 'nullable|string|max:255',
            'neighborhood' => 'nullable|string|max:255',
            'due_date' => 'nullable|date',
        ]);

        
        if (! $user->isAdmin() && (int) $validated['department_id'] !== $user->department_id) {
            abort(403, 'Sadece kendi müdürlüğünüze görev oluşturabilirsiniz.');
        }
        if (! empty($validated['assigned_to'])) {
            $assignee = User::find($validated['assigned_to']);
        
            if (! $assignee || $assignee->department_id !== (int) $validated['department_id']) {
                abort(403, 'Sadece görevin ait olduğu müdürlükteki personele atama yapabilirsiniz.');
            }
        }
        $validated['created_by'] = $user->id;
        $validated['status'] = $validated['assigned_to'] ? TaskStatus::ASSIGNED->value : TaskStatus::PENDING->value;

        $task = Task::create($validated);

        return redirect()
            ->route('tasks.index')
            ->with('success', "\"{$task->title}\" görevi oluşturuldu.");
    }

    public function edit(Task $task): View
{
    $this->authorize('update', $task);

    $user = request()->user();

    $departments = $user->isAdmin()
        ? Department::where('is_active', true)->orderBy('name')->get()
        : Department::where('id', $user->department_id)->get();

    $staff = User::where('role', 'staff')
        ->where('department_id', $task->department_id)
        ->orderBy('name')
        ->get();

    return view('tasks.edit', compact('task', 'departments', 'staff'));
}

public function update(Request $request, Task $task): RedirectResponse
{
    $this->authorize('update', $task);

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'priority' => 'required|in:low,medium,high,urgent',
        'address' => 'nullable|string|max:255',
        'neighborhood' => 'nullable|string|max:255',
        'due_date' => 'nullable|date',
    ]);

    $task->update($validated);

    return redirect()
        ->route('tasks.show', $task)
        ->with('success', 'Görev güncellendi.');
}

    public function show(Request $request, Task $task): View
    {
        $this->authorize('view', $task);

        $task->load(['department', 'assignee', 'creator', 'updates.user']);

        return view('tasks.show', compact('task'));
    }

    public function updateStatus(Request $request, Task $task): RedirectResponse
    {
    $this->authorize('updateStatus', $task);

    $validated = $request->validate([
        'status' => 'required|in:pending,assigned,in_progress,completed,cancelled',
        'note' => 'nullable|string',
        'photo' => 'nullable|image|max:5120',
    ]);
    
    $photoPath = null;
    
    if ($request->hasFile('photo')) {
        $photoPath = $request->file('photo')->store('task-photos', 'public');
    }

    $this->taskService->changeStatus(
        $task,
        TaskStatus::from($validated['status']),
        $request->user(),
        $validated['note'] ?? null,
        $photoPath
    );

    return redirect()
        ->route('tasks.show', $task)
        ->with('success', 'Görev durumu güncellendi.');
    }
    public function assign(Request $request, Task $task): RedirectResponse
{
    $this->authorize('update', $task);

    $validated = $request->validate([
        'assigned_to' => 'required|exists:users,id',
    ]);

    $assignee = User::find($validated['assigned_to']);

    if (! $assignee || $assignee->department_id !== $task->department_id) {
        abort(403, 'Sadece görevin ait olduğu müdürlükteki personele atama yapabilirsiniz.');
    }

    $task->update([
        'assigned_to' => $assignee->id,
        'status' => TaskStatus::ASSIGNED->value,
    ]);

    $task->updates()->create([
        'user_id' => $request->user()->id,
        'old_status' => TaskStatus::PENDING->value,
        'new_status' => TaskStatus::ASSIGNED->value,
        'note' => "{$assignee->name} isimli personele atandı.",
    ]);

    return redirect()
        ->route('tasks.show', $task)
        ->with('success', 'Görev personele atandı.');
}
    public function destroy(Task $task): RedirectResponse
    {
        $this->authorize('delete', $task);

        $task->delete();

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Görev iptal edildi.');
    }
}