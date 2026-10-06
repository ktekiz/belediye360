<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">Yeni Görev</h2>
    </x-slot>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('tasks.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="title" class="form-label">Başlık</label>
                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
                    @error('title')
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

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="department_id" class="form-label">Müdürlük</label>
                        <select name="department_id" id="department_id" class="form-select @error('department_id') is-invalid @enderror">
                            <option value="">Seçiniz</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('department_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="assigned_to" class="form-label">Atanacak Personel</label>
                        <select name="assigned_to" id="assigned_to" class="form-select @error('assigned_to') is-invalid @enderror">
                            <option value="">Şimdilik atama (Bekliyor)</option>
                            @foreach ($staff as $person)
                                <option value="{{ $person->id }}" {{ old('assigned_to') == $person->id ? 'selected' : '' }}>
                                    {{ $person->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('assigned_to')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="priority" class="form-label">Öncelik</label>
                        <select name="priority" id="priority" class="form-select @error('priority') is-invalid @enderror">
                            <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>Düşük</option>
                            <option value="medium" {{ old('priority', 'medium') === 'medium' ? 'selected' : '' }}>Orta</option>
                            <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>Yüksek</option>
                            <option value="urgent" {{ old('priority') === 'urgent' ? 'selected' : '' }}>Acil</option>
                        </select>
                        @error('priority')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="due_date" class="form-label">Son Teslim Tarihi</label>
                        <input type="date" name="due_date" id="due_date" class="form-control @error('due_date') is-invalid @enderror" value="{{ old('due_date') }}">
                        @error('due_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="address" class="form-label">Adres</label>
                        <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}">
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="neighborhood" class="form-label">Mahalle</label>
                        <input type="text" name="neighborhood" id="neighborhood" class="form-control @error('neighborhood') is-invalid @enderror" value="{{ old('neighborhood') }}">
                        @error('neighborhood')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Görevi Oluştur</button>
                <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">Vazgeç</a>
            </form>
        </div>
    </div>
</x-app-layout>