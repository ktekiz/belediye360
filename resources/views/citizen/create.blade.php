<x-public-layout title="İhbar Bildir">
    <div class="bg-white border-bottom py-4 mb-4">
        <div class="container">
            <h4 class="fw-bold mb-0"><i class="bi bi-megaphone-fill text-primary me-2"></i>İhbar Bildir</h4>
            <p class="text-muted small mb-0">Karşılaştığınız sorunu bizimle paylaşın, ilgili birimimiz incelesin.</p>
        </div>
    </div>

    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card service-card">
                    <div class="card-body p-4">
                        <div class="alert alert-light border small mb-4">
                            <i class="bi bi-info-circle me-1"></i>
                            Bu bir demo/staj projesidir, gerçek kimlik bilgisi girmenize gerek yoktur.
                        </div>

                        <form action="{{ route('citizen.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="reporter_name" class="form-label fw-semibold">Ad Soyad</label>
                                    <input type="text" name="reporter_name" id="reporter_name" class="form-control @error('reporter_name') is-invalid @enderror" value="{{ old('reporter_name') }}">
                                    @error('reporter_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="reporter_tc" class="form-label fw-semibold">TC Kimlik No</label>
                                    <input type="text" name="reporter_tc" id="reporter_tc" maxlength="11" class="form-control @error('reporter_tc') is-invalid @enderror" value="{{ old('reporter_tc') }}">
                                    @error('reporter_tc')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="reporter_phone" class="form-label fw-semibold">Telefon</label>
                                <input type="text" name="reporter_phone" id="reporter_phone" class="form-control @error('reporter_phone') is-invalid @enderror" value="{{ old('reporter_phone') }}">
                                @error('reporter_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="category_id" class="form-label fw-semibold">İhbar Türü</label>
                                <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                    <option value="">Seçiniz</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }} — {{ $category->department->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label fw-semibold">Açıklama</label>
                                <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror" placeholder="Örn: Atatürk Caddesi üzerinde büyük bir çukur var.">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="address" class="form-label fw-semibold">Adres</label>
                                    <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}">
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="neighborhood" class="form-label fw-semibold">Mahalle</label>
                                    <input type="text" name="neighborhood" id="neighborhood" class="form-control" value="{{ old('neighborhood') }}">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 rounded-pill fw-semibold">
                                <i class="bi bi-send-fill me-1"></i> İhbarı Gönder
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>