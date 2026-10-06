<x-public-layout title="İhbar Sorgula">
    <div class="bg-white border-bottom py-4 mb-5">
        <div class="container">
            <h4 class="fw-bold mb-0"><i class="bi bi-search text-primary me-2"></i>İhbar Sorgula</h4>
            <p class="text-muted small mb-0">Takip kodunuzu girerek ihbarınızın durumunu öğrenin.</p>
        </div>
    </div>

    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card service-card">
                    <div class="card-body p-4">
                        <form action="{{ route('citizen.track') }}" method="POST" class="mb-4">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="tracking_code" class="form-control" placeholder="Örn: BLD-X7K2M9" value="{{ request('tracking_code') }}">
                                <button type="submit" class="btn btn-primary px-4">Sorgula</button>
                            </div>
                        </form>

                        @if (! empty($searched))
                            @if ($task)
                                <div class="bg-light rounded-4 p-4">
                                    <div class="small text-muted">İhbar Türü</div>
                                    <div class="fw-semibold mb-3">{{ $task->title }}</div>

                                    <div class="small text-muted">Durum</div>
                                    <span class="badge bg-{{ $task->status->badgeColor() }} fs-6 mb-3">{{ $task->status->label() }}</span>

                                    <div class="small text-muted">Bildirim Tarihi</div>
                                    <div>{{ $task->created_at->format('d.m.Y H:i') }}</div>
                                </div>
                            @else
                                <div class="alert alert-warning mb-0 rounded-4">
                                    <i class="bi bi-exclamation-triangle me-1"></i>
                                    Bu koda ait bir ihbar bulunamadı. Kodu kontrol edip tekrar deneyin.
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>