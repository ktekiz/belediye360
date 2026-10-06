<h5 class="card-title">Şifre Değiştir</h5>
<p class="text-muted small">Hesap güvenliğiniz için uzun, rastgele bir şifre kullanmanızı öneririz.</p>

<form method="POST" action="{{ route('password.update') }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="update_password_current_password" class="form-label">Mevcut Şifre</label>
        <input type="password" name="current_password" id="update_password_current_password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror">
        @error('current_password', 'updatePassword')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="update_password_password" class="form-label">Yeni Şifre</label>
        <input type="password" name="password" id="update_password_password" class="form-control @error('password', 'updatePassword') is-invalid @enderror">
        @error('password', 'updatePassword')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="update_password_password_confirmation" class="form-label">Yeni Şifre (Tekrar)</label>
        <input type="password" name="password_confirmation" id="update_password_password_confirmation" class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror">
        @error('password_confirmation', 'updatePassword')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex align-items-center gap-3">
        <button type="submit" class="btn btn-primary">Kaydet</button>

        @if (session('status') === 'password-updated')
            <span class="text-success small">Kaydedildi.</span>
        @endif
    </div>
</form>