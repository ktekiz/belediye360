<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">Müdürlük Düzenle</h2>
    </x-slot>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.departments.update', $department) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Müdürlük Adı</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $department->name) }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Açıklama</label>
                    <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $department->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', $department->is_active) ? 'checked' : '' }}>
                    <label for="is_active" class="form-check-label">Aktif</label>
                </div>

                <button type="submit" class="btn btn-primary">Güncelle</button>
                <a href="{{ route('admin.departments.index') }}" class="btn btn-outline-secondary">Vazgeç</a>
            </form>
        </div>
    </div>
</x-app-layout>