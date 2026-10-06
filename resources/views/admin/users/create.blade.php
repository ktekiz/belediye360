<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">Yeni Personel</h2>
    </x-slot>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Ad Soyad</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">E-posta</label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Şifre</label>
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">Rol</label>
                    <select name="role" id="role" class="form-select @error('role') is-invalid @enderror">
                        <option value="">Seçiniz</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Sistem Yöneticisi</option>
                        <option value="manager" {{ old('role') === 'manager' ? 'selected' : '' }}>Müdür</option>
                        <option value="chief" {{ old('role') === 'chief' ? 'selected' : '' }}>Şef</option>
                        <option value="staff" {{ old('role') === 'staff' ? 'selected' : '' }}>Saha Personeli</option>
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="department_id" class="form-label">Müdürlük</label>
                    <select name="department_id" id="department_id" class="form-select @error('department_id') is-invalid @enderror">
                        <option value="">Bağlı değil (Sistem Yöneticisi için)</option>
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

                <button type="submit" class="btn btn-primary">Kaydet</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Vazgeç</a>
            </form>
        </div>
    </div>
</x-app-layout>