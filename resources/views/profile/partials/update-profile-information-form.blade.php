<h5 class="card-title">Profil Bilgileri</h5>
<p class="text-muted small">Hesap adınızı ve e-posta adresinizi güncelleyin.</p>

<form method="POST" action="{{ route('profile.update') }}">
    @csrf
    @method('PATCH')

    <div class="mb-3">
        <label for="name" class="form-label">Ad Soyad</label>
        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">E-posta</label>
        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex align-items-center gap-3">
        <button type="submit" class="btn btn-primary">Kaydet</button>

        @if (session('status') === 'profile-updated')
            <span class="text-success small">Kaydedildi.</span>
        @endif
    </div>
</form>