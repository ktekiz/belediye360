<x-public-layout title="Personel Girişi">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card service-card">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <i class="bi bi-person-circle text-primary" style="font-size: 2.5rem;"></i>
                            <h4 class="fw-bold mt-2 mb-0">Personel Girişi</h4>
                            <p class="text-muted small">Belediye360 yönetim paneline erişin</p>
                        </div>

                        @if (session('status'))
                            <div class="alert alert-success small">{{ session('status') }}</div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">E-posta</label>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Şifre</label>
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-check mb-3">
                                <input type="checkbox" name="remember" id="remember" class="form-check-input">
                                <label for="remember" class="form-check-label small">Beni hatırla</label>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-semibold">
                                Giriş Yap
                            </button>

                            <div class="text-center mt-3">
                                <a href="{{ route('welcome') }}" class="small text-muted text-decoration-none">
                                    <i class="bi bi-arrow-left me-1"></i>Ana Sayfaya Dön
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>