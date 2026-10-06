<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">Görev Düzenle</h2>
    </x-slot>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('tasks.update', $task) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="title" class="form-label">Başlık</label>
                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $task->title) }}">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Açıklama</label>
                    <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $task->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="priority" class="form-label">Öncelik</label>
                        <select name="priority" id="priority" class="form-select @error('priority') is-invalid @enderror">
                            <option value="low" {{ old('priority', $task->priority->value) === 'low' ? 'selected' : '' }}>Düşük</option>
                            <option value="medium" {{ old('priority', $task->priority->value) === 'medium' ? 'selected' : '' }}>Orta</option>
                            <option value="high" {{ old('priority', $task->priority->value) === 'high' ? 'selected' : '' }}>Yüksek</option>
                            <option value="urgent" {{ old('priority', $task->priority->value) === 'urgent' ? 'selected' : '' }}>Acil</option>
                        </select>
                        @error('priority')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="due_date" class="form-label">Son Teslim Tarihi</label>
                        <input type="date" name="due_date" id="due_date" class="form-control @error('due_date') is-invalid @enderror" value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}">
                        @error('due_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="address" class="form-label">Adres</label>
                        <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address', $task->address) }}">
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="neighborhood" class="form-label">Mahalle</label>
                        <input type="text" name="neighborhood" id="neighborhood" class="form-control" value="{{ old('neighborhood', $task->neighborhood) }}">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Güncelle</button>
                <a href="{{ route('tasks.show', $task) }}" class="btn btn-outline-secondary">Vazgeç</a>
            </form>
        </div>
    </div>
</x-app-layout>