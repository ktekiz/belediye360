<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">Müdürlükler</h2>
            <a href="{{ route('admin.departments.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Yeni Müdürlük
            </a>
        </div>
    </x-slot>

    <div class="card">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Ad</th>
                        <th>Açıklama</th>
                        <th>Durum</th>
                        <th class="text-end">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($departments as $department)
                        <tr>
                            <td>{{ $department->name }}</td>
                            <td>{{ $department->description ?? '-' }}</td>
                            <td>
                                @if ($department->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Pasif</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.departments.edit', $department) }}" class="btn btn-sm btn-outline-secondary">
                                    Düzenle
                                </a>
                                <form action="{{ route('admin.departments.destroy', $department) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu müdürlüğü silmek istediğine emin misin?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Sil</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">Henüz müdürlük eklenmemiş.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $departments->links() }}
        </div>
    </div>
</x-app-layout>