<x-public-layout>
    <div class="hero py-5">
        <div class="container text-center py-5">
            <span class="badge bg-light text-primary px-3 py-2 mb-3 rounded-pill">
                <i class="bi bi-stars me-1"></i> Dijital Belediye Hizmetleri
            </span>
            <h1 class="display-5 fw-bold mb-3">Şehrimizi Birlikte<br>Daha İyi Hale Getirelim</h1>
            <p class="lead mb-4 mx-auto" style="max-width: 600px; opacity: 0.9;">
                Yolda bir çukur mu var? Sokak lambası mı yanmıyor? Sorunu görün, bize bildirin,
                ilgili müdürlüğümüz en kısa sürede çözüme kavuştursun.
            </p>
            <a href="{{ route('citizen.create') }}" class="btn btn-light btn-lg px-4 py-2">
                <i class="bi bi-megaphone-fill me-1"></i> Hemen İhbar Bildir
            </a>
        </div>
    </div>

    <div class="stat-strip py-4">
        <div class="container">
            <div class="row text-center g-3">
                <div class="col-6 col-md-3">
                    <div class="stat-number">7/24</div>
                    <div class="small text-muted">Kesintisiz Bildirim</div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-number">{{ \App\Models\Department::where('is_active', true)->count() }}</div>
                    <div class="small text-muted">Aktif Müdürlük</div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-number">{{ \App\Models\Task::where('source', 'citizen')->count() }}</div>
                    <div class="small text-muted">Alınan İhbar</div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-number">{{ \App\Models\Task::where('source', 'citizen')->where('status', 'completed')->count() }}</div>
                    <div class="small text-muted">Çözülen Sorun</div>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Nasıl Çalışır?</h2>
            <p class="text-muted">Sadece 3 adımda sesinizi duyurun</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card service-card p-4">
                    <div class="service-icon mb-3"><i class="bi bi-pencil-square"></i></div>
                    <h5>1. Bildirin</h5>
                    <p class="text-muted small mb-0">Karşılaştığınız sorunu, türünü ve konumunu belirterek kısaca anlatın.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card service-card p-4">
                    <div class="service-icon mb-3"><i class="bi bi-diagram-3-fill"></i></div>
                    <h5>2. Yönlendirilsin</h5>
                    <p class="text-muted small mb-0">İhbarınız otomatik olarak ilgili müdürlüğümüze ulaşır ve bir yetkiliye atanır.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card service-card p-4">
                    <div class="service-icon mb-3"><i class="bi bi-check-circle-fill"></i></div>
                    <h5>3. Takip Edin</h5>
                    <p class="text-muted small mb-0">Size verilen takip koduyla ihbarınızın güncel durumunu istediğiniz an sorgulayabilirsiniz.</p>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>