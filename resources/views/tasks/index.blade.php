<x-app-layout>
    <x-slot name="header">
        @if (isset($departments) && $departments->count() > 0)
    <form method="GET" class="mb-3" style="max-width: 300px;">
        <select name="department_id" class="form-select" onchange="this.form.submit()">
            <option value="">Tüm Müdürlükler</option>
            @foreach ($departments as $dept)
                <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>
                    {{ $dept->name }}
                </option>
            @endforeach
        </select>
    </form>
@endif
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">Görevler</h2>
            @can('create', \App\Models\Task::class)
                <a href="{{ route('tasks.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> Yeni Görev
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="card">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Başlık</th>
                        <th>Müdürlük</th>
                        <th>Atanan</th>
                        <th>Öncelik</th>
                        <th>Durum</th>
                        <th>Son Tarih</th>
                        <th class="text-end">İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tasks as $task)
    @php
        $isOverdue = $task->due_date
            && $task->due_date->isPast()
            && ! in_array($task->status->value, ['completed', 'cancelled']);
    @endphp
    <tr class="{{ $isOverdue ? 'table-danger' : '' }}">
        <td>{{ $task->title }} @if($isOverdue)<i class="bi bi-exclamation-triangle-fill text-danger ms-1" title="Gecikmiş"></i>@endif</td>
                            <td>{{ $task->department->name }}</td>
                            <td>{{ $task->assignee?->name ?? '-' }}</td>
                            <td><span class="badge bg-{{ $task->priority->badgeColor() }}">{{ $task->priority->label() }}</span></td>
                            <td><span class="badge bg-{{ $task->status->badgeColor() }}">{{ $task->status->label() }}</span></td>
                            <td>{{ $task->due_date?->format('d.m.Y') ?? '-' }}</td>
                            <td class="text-end">
                                <a href="{{ route('tasks.show', $task) }}" class="btn btn-sm btn-outline-primary">Detay</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Henüz görev yok.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $tasks->links() }}
        </div>
    </div>
</x-app-layout>