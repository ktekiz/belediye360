<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">Kontrol Paneli</h2>
    </x-slot>

    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-3 me-3">
                        <i class="bi bi-list-check fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Toplam Görev</div>
                        <div class="fs-3 fw-bold">{{ $stats['total'] }}</div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-6 col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-secondary bg-opacity-10 text-secondary p-3 me-3">
                        <i class="bi bi-hourglass-split fs-4"></i>
                    </div>
                    <div>


                        <div class="text-muted small">Bekleyen</div>
                        <div class="fs-3 fw-bold">{{ $stats['pending'] }}</div>
                    </div>
                </div>
                </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-warning bg-opacity-10 text-warning p-3 me-3">
                        <i class="bi bi-gear-wide-connected fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Devam Eden</div>
                        <div class="fs-3 fw-bold">{{ $stats['in_progress'] }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-success bg-opacity-10 text-success p-3 me-3">
                        <i class="bi bi-check-circle fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Tamamlanan</div>
                        <div class="fs-3 fw-bold">{{ $stats['completed'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($stats['overdue'] > 0)
        <div class="alert alert-danger">
            <strong>{{ $stats['overdue'] }}</strong> geciken görev var — son teslim tarihi geçmiş ama hâlâ tamamlanmamış.
        </div>
    @endif

    <div class="row g-3">
        @if ($user->isAdmin())
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Müdürlüğe Göre Görev Dağılımı</h5>
                        <table class="table table-sm">
                            <tbody>
                                @forelse ($byDepartment as $row)
                                    <tr>
                                        <td>{{ $row->department->name ?? 'Bilinmiyor' }}</td>
                                        <td class="text-end fw-bold">{{ $row->total }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted">Veri yok.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Açık Görevlerin Önceliği</h5>
                        <table class="table table-sm">
                            <tbody>
                                <tr>
                                    <td><span class="badge bg-danger">Acil</span></td>
                                    <td class="text-end fw-bold">{{ $byPriority['urgent']->total ?? 0 }}</td>
                                </tr>
                                <tr>
                                    <td><span class="badge bg-warning">Yüksek</span></td>
                                    <td class="text-end fw-bold">{{ $byPriority['high']->total ?? 0 }}</td>
                                </tr>
                                <tr>
                                    <td><span class="badge bg-info text-dark">Orta</span></td>
                                    <td class="text-end fw-bold">{{ $byPriority['medium']->total ?? 0 }}</td>
                                </tr>
                                <tr>
                                    <td><span class="badge bg-light text-dark">Düşük</span></td>
                                    <td class="text-end fw-bold">{{ $byPriority['low']->total ?? 0 }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Personel Performansı</h5>
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Personel</th>
                                <th class="text-end">Tamamlanan</th>
                                <th class="text-end">Toplam</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($staffPerformance as $person)
                                <tr>
                                    <td>{{ $person->name }}</td>
                                    <td class="text-end">{{ $person->completed_count }}</td>
                                    <td class="text-end">{{ $person->total_count }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted">Veri yok.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>