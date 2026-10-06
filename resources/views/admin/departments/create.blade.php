<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">Yeni Müdürlük</h2>
    </x-slot>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.departments.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Müdürlük Adı</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Açıklama</label>
                    <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Kaydet</button>
                <a href="{{ route('admin.departments.index') }}" class="btn btn-outline-secondary">Vazgeç</a>
            </form>
        </div>
    </div>
</x-app-layout>