<h5 class="card-title text-danger">Hesabı Sil</h5>
<p class="text-muted small">Hesabınız silindiğinde tüm verileri kalıcı olarak kaldırılır. Devam etmeden önce emin olun.</p>

<button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
    Hesabı Sil
</button>

<div class="modal fade" id="deleteAccountModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('profile.destroy') }}" class="modal-content">
            @csrf
            @method('DELETE')

            <div class="modal-header">
                <h5 class="modal-title">Hesabınızı silmek istediğinize emin misiniz?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted small">Bu işlem geri alınamaz. Devam etmek için şifrenizi girin.</p>

                <label for="delete_password" class="form-label">Şifre</label>
                <input type="password" name="password" id="delete_password" class="form-control @error('password', 'userDeletion') is-invalid @enderror">
                @error('password', 'userDeletion')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Vazgeç</button>
                <button type="submit" class="btn btn-danger">Hesabı Sil</button>
            </div>
        </form>
    </div>
</div>