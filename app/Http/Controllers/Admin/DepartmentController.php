<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', Department::class);

        $departments = Department::orderBy('name')->paginate(10);

        return view('admin.departments.index', compact('departments'));
    }

    public function create(): View
    {
        $this->authorize('create', Department::class);

        return view('admin.departments.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Department::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Department::create($validated);

        return redirect()
            ->route('admin.departments.index')
            ->with('success', 'Müdürlük başarıyla oluşturuldu.');
    }

    public function edit(Department $department): View
    {
        $this->authorize('update', $department);

        return view('admin.departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department): RedirectResponse
    {
        $this->authorize('update', $department);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $department->update($validated);

        return redirect()
            ->route('admin.departments.index')
            ->with('success', 'Müdürlük başarıyla güncellendi.');
    }

    public function destroy(Department $department): RedirectResponse
    {
        $this->authorize('delete', $department);

        $department->delete();

        return redirect()
            ->route('admin.departments.index')
            ->with('success', 'Müdürlük silindi.');
    }
}