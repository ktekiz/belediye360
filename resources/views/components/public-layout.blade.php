<!DOCTYPE html>
<html lang="tr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title ?? 'Belediye360' }}</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <style>
            body { font-family: 'Inter', sans-serif; background-color: #f7f8fa; color: #1e2532; }

            .top-strip { background: #0a2540; color: #cbd5e1; font-size: 0.8rem; }
            .top-strip a { color: #cbd5e1; text-decoration: none; }
            .top-strip a:hover { color: #fff; }

            .navbar-main { background: #ffffff !important; box-shadow: 0 1px 4px rgba(0,0,0,0.06); }
            .navbar-main .navbar-brand { color: #0a2540 !important; font-weight: 800; letter-spacing: -0.5px; }
            .navbar-main .btn-outline-primary { border-radius: 2rem; }
            .navbar-main .btn-primary { border-radius: 2rem; }

            .hero {
                background: radial-gradient(circle at top left, #1e5fbf, #0a2540 70%);
                color: white;
                position: relative;
                overflow: hidden;
            }
            .hero::after {
                content: "";
                position: absolute;
                inset: 0;
                background-image: radial-gradient(rgba(255,255,255,0.08) 1px, transparent 1px);
                background-size: 22px 22px;
                opacity: 0.6;
            }
            .hero .container { position: relative; z-index: 1; }
            .hero .btn-light { border-radius: 2rem; font-weight: 600; }

            .stat-strip { background: #ffffff; border-top: 1px solid #eef0f3; border-bottom: 1px solid #eef0f3; }
            .stat-strip .stat-number { font-size: 1.8rem; font-weight: 800; color: #0a2540; }

            .service-card {
                border: none;
                border-radius: 1rem;
                box-shadow: 0 1px 3px rgba(0,0,0,0.06);
                transition: transform 0.15s ease, box-shadow 0.15s ease;
                height: 100%;
            }
            .service-card:hover { transform: translateY(-4px); box-shadow: 0 10px 20px rgba(10,37,64,0.08); }
            .service-icon {
                width: 52px; height: 52px; border-radius: 0.8rem;
                display: flex; align-items: center; justify-content: center;
                background: #e8f0fe; color: #1e5fbf; font-size: 1.4rem;
            }

            footer.site-footer { background: #0a2540; color: #b7c2d0; }
            footer.site-footer a { color: #e2e8f0; text-decoration: none; }
            footer.site-footer a:hover { color: #fff; }
            footer.site-footer h6 { color: #fff; font-weight: 700; }
        </style>
    </head>
    <body>
        <div class="top-strip py-1">
            <div class="container d-flex justify-content-between">
                <span><i class="bi bi-telephone-fill me-1"></i> 444 0 360 &nbsp; | &nbsp; <i class="bi bi-envelope-fill me-1"></i> info@belediye360.test</span>
                <span><i class="bi bi-geo-alt-fill me-1"></i> Merkez, Türkiye</span>
            </div>
        </div>

        <nav class="navbar navbar-expand-lg navbar-main py-3">
            <div class="container">
                <a class="navbar-brand fs-4" href="{{ route('welcome') }}">
                    <i class="bi bi-buildings-fill me-1"></i> Belediye360
                </a>
                <div class="ms-auto d-flex gap-2">
                    <a href="{{ route('citizen.track-form') }}" class="btn btn-outline-primary btn-sm px-3">
                        <i class="bi bi-search me-1"></i>İhbar Sorgula
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-primary btn-sm px-3">
                        <i class="bi bi-person-fill me-1"></i>Personel Girişi
                    </a>
                </div>
            </div>
        </nav>

        <main>
            {{ $slot }}
        </main>

        <footer class="site-footer pt-5 pb-4 mt-5">
            <div class="container">
                <div class="row g-4">
                    <div class="col-md-4">
                        <h6><i class="bi bi-buildings-fill me-1"></i> Belediye360</h6>
                        <p class="small">Şehrimize sahip çıkıyor, sorunları birlikte çözüyoruz. Bu bir staj/demo projesidir.</p>
                    </div>
                    <div class="col-md-4">
                        <h6>Hızlı Bağlantılar</h6>
                        <ul class="list-unstyled small">
                            <li class="mb-1"><a href="{{ route('citizen.create') }}"><i class="bi bi-chevron-right"></i> İhbar Bildir</a></li>
                            <li class="mb-1"><a href="{{ route('citizen.track-form') }}"><i class="bi bi-chevron-right"></i> İhbar Sorgula</a></li>
                            <li class="mb-1"><a href="{{ route('login') }}"><i class="bi bi-chevron-right"></i> Personel Girişi</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h6>İletişim</h6>
                        <ul class="list-unstyled small">
                            <li class="mb-1"><i class="bi bi-telephone-fill me-1"></i> 444 0 360</li>
                            <li class="mb-1"><i class="bi bi-envelope-fill me-1"></i> info@belediye360.test</li>
                            <li class="mb-1"><i class="bi bi-geo-alt-fill me-1"></i> Merkez, Türkiye</li>
                        </ul>
                    </div>
                </div>
                <hr class="border-secondary mt-4">
                <div class="text-center small">&copy; {{ date('Y') }} Belediye360 — Staj Projesi Demo</div>
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>