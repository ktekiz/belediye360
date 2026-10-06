<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">{{ $task->title }}</h2>
            @can('update', $task)
                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-pencil"></i> Düzenle
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="row">
        <div class="col-md-7">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Görev Bilgileri</h5>
                    <p class="text-muted">{{ $task->description ?? 'Açıklama yok.' }}</p>

                    <dl class="row mb-0">
                        <dt class="col-sm-4">Müdürlük</dt>
                        <dd class="col-sm-8">{{ $task->department->name }}</dd>

                        <dt class="col-sm-4">Atanan Personel</dt>
                        <dd class="col-sm-8">{{ $task->assignee?->name ?? 'Atanmadı' }}</dd>

                        <dt class="col-sm-4">Oluşturan</dt>
                        <dd class="col-sm-8">
                            @if ($task->creator)
                                {{ $task->creator->name }}
                            @elseif ($task->source === 'citizen')
                                <span class="badge bg-info text-dark"><i class="bi bi-person-badge"></i> Vatandaş İhbarı</span>
                                <div class="small text-muted mt-1">{{ $task->reporter_name }} — {{ $task->reporter_phone }}</div>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </dd>

                        <dt class="col-sm-4">Öncelik</dt>
                        <dd class="col-sm-8"><span class="badge bg-{{ $task->priority->badgeColor() }}">{{ $task->priority->label() }}</span></dd>

                        <dt class="col-sm-4">Durum</dt>
                        <dd class="col-sm-8"><span class="badge bg-{{ $task->status->badgeColor() }}">{{ $task->status->label() }}</span></dd>

                        <dt class="col-sm-4">Adres</dt>
                        <dd class="col-sm-8">{{ $task->address ?? '-' }} {{ $task->neighborhood ? '/ '.$task->neighborhood : '' }}</dd>

                        <dt class="col-sm-4">Son Tarih</dt>
                        <dd class="col-sm-8">{{ $task->due_date?->format('d.m.Y') ?? '-' }}</dd>
                    </dl>
                </div>
            </div>
            @if (! $task->assigned_to && $task->status->value === 'pending')
            @can('update', $task)
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-person-plus me-1"></i>Personel Ata</h5>
        
                        <form action="{{ route('tasks.assign', $task) }}" method="POST">
                            @csrf
                            @method('PATCH')
        
                            <div class="mb-3">
                                <select name="assigned_to" class="form-select @error('assigned_to') is-invalid @enderror" required>
                                    <option value="">Personel seçin</option>
                                    @foreach (\App\Models\User::where('role', 'staff')->where('department_id', $task->department_id)->withCount(['assignedTasks as active_tasks_count' => fn ($q) => $q->whereNotIn('status', ['completed', 'cancelled'])])->get() as $person)
                                        <option value="{{ $person->id }}">{{ $person->name }} ({{ $person->active_tasks_count }} aktif görev)</option>
                                    @endforeach
                                </select>
                                @error('assigned_to')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
        
                            <button type="submit" class="btn btn-primary">Ata</button>
                        </form>
                    </div>
                </div>
            @endcan
        @endif
            @can('updateStatus', $task)
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Durum Güncelle</h5>

                        @php
                            $nextOptions = $task->status->allowedTransitions();
                        @endphp

                        @if (count($nextOptions) > 0)
                        <form action="{{ route('tasks.update-status', $task) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                        
                            <div class="mb-3">
                                <label for="status" class="form-label">Yeni Durum</label>
                                <select name="status" id="status" class="form-select">
                                    @foreach ($nextOptions as $option)
                                        <option value="{{ $option->value }}">{{ $option->label() }}</option>
                                    @endforeach
                                </select>
                            </div>
                        
                            <div class="mb-3">
                                <label for="note" class="form-label">Not (isteğe bağlı)</label>
                                <textarea name="note" id="note" rows="2" class="form-control"></textarea>
                            </div>
                        
                            <div class="mb-3">
                                <label for="photo" class="form-label">Fotoğraf (isteğe bağlı)</label>
                                <input type="file" name="photo" id="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/*">
                                @error('photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        
                            <button type="submit" class="btn btn-primary">Durumu Güncelle</button>
                        </form>
                        @else
                            <p class="text-muted mb-0">Bu görev için başka durum değişikliği yapılamaz.</p>
                        @endif
                    </div>
                </div>
            @endcan
        </div>

        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Geçmiş</h5>

                    @forelse ($task->updates as $update)
                        <div class="border-bottom pb-2 mb-2">
                            <div class="small text-muted">
                                {{ $update->user->name }} — {{ $update->created_at->format('d.m.Y H:i') }}
                            </div>
                            @if ($update->old_status && $update->new_status)
                                <div>
                                    <span class="badge bg-secondary">{{ \App\Enums\TaskStatus::from($update->old_status)->label() }}</span>
                                    →
                                    <span class="badge bg-primary">{{ \App\Enums\TaskStatus::from($update->new_status)->label() }}</span>
                                </div>
                            @endif
                            @if ($update->note)
                            <div class="mt-1">{{ $update->note }}</div>
                                @endif
                                @if ($update->photo_path)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $update->photo_path) }}" alt="Görev fotoğrafı" class="img-thumbnail" style="max-width: 200px;">
                                    </div>
                                @endif
                        </div>
                    @empty
                        <p class="text-muted mb-0">Henüz işlem yapılmamış.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>