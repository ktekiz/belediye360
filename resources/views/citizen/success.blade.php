<x-public-layout title="İhbarınız Alındı">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <div class="card service-card p-4">
                    <div class="card-body">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                        <h3 class="mt-3 fw-bold">İhbarınız Alındı</h3>
                        <p class="text-muted">İlgili müdürlüğümüz en kısa sürede incelemeye alacaktır.</p>

                        <div class="bg-light rounded-4 p-4 mt-4">
                            <div class="text-muted small">Takip Kodunuz</div>
                            <div class="fs-3 fw-bold text-primary">{{ $trackingCode }}</div>
                            <p class="small text-muted mt-2 mb-0">Bu kodu not alın, ihbarınızın durumunu bu kodla sorgulayabilirsiniz.</p>
                        </div>

                        <div class="d-flex gap-2 justify-content-center mt-4">
                            <a href="{{ route('citizen.track-form') }}" class="btn btn-outline-primary rounded-pill px-4">İhbar Sorgula</a>
                            <a href="{{ route('welcome') }}" class="btn btn-primary rounded-pill px-4">Ana Sayfa</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>