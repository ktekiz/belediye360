<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', User::class);

        $users = User::with('department')->orderBy('name')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function create(): View
    {
        $this->authorize('create', User::class);

        $departments = Department::where('is_active', true)->orderBy('name')->get();

        return view('admin.users.create', compact('departments'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', User::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,manager,chief,staff',
            'department_id' => 'nullable|exists:departments,id',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $validated['email_verified_at'] = now();

        User::create($validated);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Personel başarıyla oluşturuldu.');
    }

    public function edit(User $user): View
    {
        $this->authorize('update', $user);

        $departments = Department::where('is_active', true)->orderBy('name')->get();

        return view('admin.users.edit', compact('user', 'departments'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $this->authorize('update', $user);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:admin,manager,chief,staff',
            'department_id' => 'nullable|exists:departments,id',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if (! empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Personel başarıyla güncellendi.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
{
    if ($user->id === $request->user()->id) {
        return redirect()
            ->route('admin.users.index')
            ->with('error', 'Kendi hesabınızı silemezsiniz.');
    }

    $this->authorize('delete', $user);

    $user->delete();

    return redirect()
        ->route('admin.users.index')
        ->with('success', 'Personel silindi.');
}
}