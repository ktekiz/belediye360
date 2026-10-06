<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Models\Task;
use App\Models\TaskCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CitizenReportController extends Controller
{
    public function create(): View
    {
        $categories = TaskCategory::with('department')->orderBy('name')->get();

        return view('citizen.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'reporter_name' => 'required|string|max:255',
            'reporter_tc' => 'required|digits:11',
            'reporter_phone' => 'required|string|max:20',
            'category_id' => 'required|exists:task_categories,id',
            'description' => 'required|string',
            'address' => 'required|string|max:255',
            'neighborhood' => 'nullable|string|max:255',
        ]);

        $category = TaskCategory::findOrFail($validated['category_id']);

        $trackingCode = 'BLD-' . strtoupper(Str::random(6));

        $task = Task::create([
            'title' => $category->name . ' İhbarı',
            'description' => $validated['description'],
            'department_id' => $category->department_id,
            'category_id' => $category->id,
            'priority' => 'medium',
            'status' => TaskStatus::PENDING->value,
            'address' => $validated['address'],
            'neighborhood' => $validated['neighborhood'] ?? null,
            'source' => 'citizen',
            'reporter_name' => $validated['reporter_name'],
            'reporter_tc' => $validated['reporter_tc'],
            'reporter_phone' => $validated['reporter_phone'],
            'tracking_code' => $trackingCode,
        ]);

        return redirect()
            ->route('citizen.success', $task->tracking_code);
    }

    public function success(string $trackingCode): View
    {
        return view('citizen.success', compact('trackingCode'));
    }

    public function trackForm(): View
    {
        return view('citizen.track');
    }

    public function track(Request $request): View
    {
        $validated = $request->validate([
            'tracking_code' => 'required|string',
        ]);

        $task = Task::where('tracking_code', $validated['tracking_code'])->first();

        return view('citizen.track', ['task' => $task, 'searched' => true]);
    }
}