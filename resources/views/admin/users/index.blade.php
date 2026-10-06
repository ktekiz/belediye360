<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">Personel Yönetimi</h2>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Yeni Personel
            </a>
        </div>
    </x-slot>

    <div class="card">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Ad Soyad</th>
                        <th>E-posta</th>
                        <th>Rol</th>
                        <th>Müdürlük</th>
                        <th>Durum</th>
                        <th class="text-end">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td><span class="badge bg-info text-dark">{{ $user->role->label() }}</span></td>
                            <td>{{ $user->department?->name ?? '-' }}</td>
                            <td>
                                @if ($user->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Pasif</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-secondary">
                                    Düzenle
                                </a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu personeli silmek istediğine emin misin?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Sil</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Henüz personel eklenmemiş.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>