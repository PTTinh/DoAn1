<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        {{ $attributes['title'] ? $attributes['title'] . ' - ' : '' }}{{ App\Helpers\SettingHelper::get('center_name', 'Trung tâm đào tạo') }}
    </title>

    <x-seo ogTitle="{{ $attributes['ogTitle'] ?? App\Helpers\SettingHelper::get('seo_title', 'Chưa cập nhật') }}"
        ogDescription="{{ $attributes['ogDescription'] ?? App\Helpers\SettingHelper::get('seo_description', 'Chưa cập nhật') }}"
        ogImage="{{ $attributes['ogImage'] ?? asset('storage/' . App\Helpers\SettingHelper::get('seo_image')) }}" />
    <link rel="icon" href="{{ asset('storage/' . App\Helpers\SettingHelper::get('logo')) }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
 
    <link rel="stylesheet" href="{{ asset('css/bootstrap-custom.css') }}">
    @if (App\Helpers\SettingHelper::get('custom_css'))
        <style>
            {!! App\Helpers\SettingHelper::get('custom_css') !!}
        </style>
    @endif
    @if (App\Helpers\SettingHelper::get('ga_head'))
        {!! App\Helpers\SettingHelper::get('ga_head') !!}
    @endif
</head>

<body>
    <!-- Top Bar -->
    <div class="bg-primary text-white py-2 border-bottom">
        <div class="container-fluid">
            <div class="row align-items-center g-3">
                <div class="col-12 col-md-6">
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="mailto:{{ App\Helpers\SettingHelper::get('email', '') }}" class="text-white text-decoration-none">
                            <i class="bi bi-envelope me-2"></i>
                            <span class="d-none d-sm-inline">{{ App\Helpers\SettingHelper::get('email', 'Chưa cập nhật') }}</span>
                        </a>
                        <a href="tel:{{ App\Helpers\SettingHelper::get('phone', '') }}" class="text-white text-decoration-none">
                            <i class="bi bi-telephone me-2"></i>
                            <span class="d-none d-sm-inline">{{ App\Helpers\SettingHelper::get('phone', 'Chưa cập nhật') }}</span>
                        </a>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="d-flex justify-content-md-end gap-3">
                        <a href="{{ App\Helpers\SettingHelper::get('facebook_fanpage', '#') }}" class="text-white" title="Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://youtube.com" class="text-white" title="YouTube">
                            <i class="bi bi-youtube"></i>
                        </a>
                        <a href="https://zalo.me/{{ App\Helpers\SettingHelper::get('zalo', '') }}" class="text-white" title="Zalo">
                            <i class="bi bi-chat-dots"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Header Navigation -->
    <header class="sticky-top bg-white border-bottom">
        <nav class="navbar navbar-expand-lg navbar-light py-3">
            <div class="container-fluid">
                <!-- Logo -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('storage/' . App\Helpers\SettingHelper::get('logo')) }}"
                        alt="{{ App\Helpers\SettingHelper::get('center_name', 'Trung tâm đào tạo') }}"
                        style="max-height: 50px;">
                </a>

                <!-- Mobile Search & Toggle -->
                <div class="d-lg-none d-flex align-items-center gap-2">
                    <button class="btn btn-link" data-bs-toggle="modal" data-bs-target="#searchModal">
                        <i class="bi bi-search text-dark"></i>
                    </button>
                    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>

                <!-- Search Form (Desktop) -->
                <form action="{{ route('search') }}" method="GET" class="d-none d-lg-flex mx-3 flex-grow-1" role="search">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control form-control-sm"
                            placeholder="Tìm kiếm khóa học, tin tức..." aria-label="Tìm kiếm">
                        <button class="btn btn-outline-primary btn-sm" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>

                <!-- Desktop Hotline -->
                <div class="d-none d-lg-flex align-items-center ms-auto">
                    <div class="text-end">
                        <small class="text-muted d-block">Hotline</small>
                        <a href="tel:{{ App\Helpers\SettingHelper::get('phone', '') }}"
                            class="text-primary text-decoration-none fw-bold">
                            {{ App\Helpers\SettingHelper::get('phone', 'Chưa cập nhật') }}
                        </a>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">
                                <i class="bi bi-house me-1"></i> Trang chủ
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/#about">
                                <i class="bi bi-info-circle me-1"></i> Giới thiệu
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs('courses.index') || request()->routeIs('courses.category') || request()->routeIs('courses.show') ? 'active' : '' }}"
                                href="{{ route('courses.index') }}" id="coursesDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-book me-1"></i> Khóa học
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="coursesDropdown">
                                <li>
                                    <a class="dropdown-item {{ request()->routeIs('courses.index') ? 'active' : '' }}"
                                        href="{{ route('courses.index') }}">Tất cả khóa học</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                @foreach (App\Models\Category::all() as $Category)
                                    <li>
                                        <a class="dropdown-item {{ request()->routeIs('courses.category') && request()->route('slug') == $Category->slug ? 'active' : '' }}"
                                            href="{{ route('courses.category', $Category->slug) }}">
                                            {{ $Category->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('rooms.index') || request()->routeIs('rooms.show') ? 'active' : '' }}"
                                href="{{ route('rooms.index') }}">
                                <i class="bi bi-building me-1"></i> Phòng học
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs('news.index') || request()->routeIs('news.category') || request()->routeIs('news.show') ? 'active' : '' }}"
                                href="{{ route('news.index') }}" id="newsDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-newspaper me-1"></i> Tin tức
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="newsDropdown">
                                <li>
                                    <a class="dropdown-item {{ request()->routeIs('news.index') ? 'active' : '' }}"
                                        href="{{ route('news.index') }}">Tất cả tin tức</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                @foreach (App\Models\NewsCategory::all() as $newsCategory)
                                    <li>
                                        <a class="dropdown-item {{ request()->routeIs('news.category') && request()->route('slug') == $newsCategory->slug ? 'active' : '' }}"
                                            href="{{ route('news.category', $newsCategory->slug) }}">
                                            {{ $newsCategory->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('contacts') ? 'active' : '' }}"
                                href="{{ route('contacts') }}">
                                <i class="bi bi-envelope me-1"></i> Liên hệ
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main>
        @include('includes._notify')
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white py-5 mt-5">
        <div class="container-fluid mb-5">
            <div class="row g-4">
                <!-- Khóa học -->
                <div class="col-md-6 col-lg-3">
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-book text-primary me-2"></i>Khóa học
                    </h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="{{ route('courses.index') }}" class="text-white text-decoration-none">
                                Tất cả khóa học
                            </a>
                        </li>
                        @foreach (App\Models\Category::all() as $Category)
                            <li class="mb-2">
                                <a href="{{ route('courses.category', $Category->slug) }}"
                                    class="text-white text-decoration-none">
                                    {{ $Category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Liên hệ -->
                <div class="col-md-6 col-lg-3">
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-telephone text-primary me-2"></i>Liên hệ
                    </h5>
                    <p class="mb-2">
                        <strong>Địa chỉ:</strong><br>
                        <a href="#" class="text-white text-decoration-none">
                            {{ App\Helpers\SettingHelper::get('address', 'Chưa cập nhật') }}
                        </a>
                    </p>
                    <p class="mb-2">
                        <strong>Điện thoại:</strong><br>
                        <a href="tel:{{ App\Helpers\SettingHelper::get('phone', '') }}" class="text-white text-decoration-none">
                            {{ App\Helpers\SettingHelper::get('phone', 'Chưa cập nhật') }}
                        </a>
                    </p>
                    <p class="mb-0">
                        <strong>Email:</strong><br>
                        <a href="mailto:{{ App\Helpers\SettingHelper::get('email', '') }}" class="text-white text-decoration-none">
                            {{ App\Helpers\SettingHelper::get('email', 'Chưa cập nhật') }}
                        </a>
                    </p>
                </div>

                <!-- Giờ làm việc -->
                <div class="col-md-6 col-lg-3">
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-clock text-primary me-2"></i>Giờ làm việc
                    </h5>
                    <p class="mb-1"><strong>Thứ 2 - Thứ 7</strong></p>
                    <p class="mb-1">
                        <strong>Sáng:</strong> 8:00 - 11:30
                    </p>
                    <p class="mb-1">
                        <strong>Tối:</strong> 18:00 - 21:00
                    </p>
                    <p class="mb-0">
                        <strong>Chủ nhật:</strong> Nghỉ
                    </p>
                </div>

                <!-- Bản đồ -->
                <div class="col-md-6 col-lg-3">
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-geo-alt text-primary me-2"></i>Vị trí
                    </h5>
                    <div class="ratio ratio-16x9">
                        <iframe src="{{ App\Helpers\SettingHelper::get('google_map', '') }}"
                            style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <hr class="border-secondary my-4">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-6 mb-3 mb-md-0">
                    <p class="mb-0">
                        &copy; {{ date('Y') }} {{ App\Helpers\SettingHelper::get('center_name', 'Trung tâm đào tạo') }}.
                        All rights reserved.
                    </p>
                </div>
                <div class="col-md-6">
                    <ul class="list-unstyled d-flex justify-content-md-end gap-4 flex-wrap mb-0">
                        <li>
                            <a href="/" class="text-white text-decoration-none">
                                <i class="bi bi-house me-1"></i>Trang chủ
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('courses.index') }}" class="text-white text-decoration-none">
                                <i class="bi bi-book me-1"></i>Khóa học
                            </a>
                        </li>
                        <li>
                            <a href="/#about" class="text-white text-decoration-none">
                                <i class="bi bi-info-circle me-1"></i>Giới thiệu
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('rooms.index') }}" class="text-white text-decoration-none">
                                <i class="bi bi-building me-1"></i>Phòng học
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('news.index') }}" class="text-white text-decoration-none">
                                <i class="bi bi-newspaper me-1"></i>Tin tức
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('contacts') }}" class="text-white text-decoration-none">
                                <i class="bi bi-envelope me-1"></i>Liên hệ
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating Contact Button -->
    <div class="fixed-bottom mb-3 me-3" style="z-index: 999;">
        <button class="btn btn-primary btn-lg rounded-circle shadow-lg" id="contactToggle"
            data-bs-toggle="offcanvas" data-bs-target="#contactOffcanvas" aria-controls="contactOffcanvas">
            <i class="bi bi-chat-left-dots"></i>
        </button>
    </div>

    <!-- Contact Offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="contactOffcanvas" aria-labelledby="contactLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="contactLabel">Liên hệ với chúng tôi</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="d-grid gap-2">
                <a href="tel:{{ App\Helpers\SettingHelper::get('phone', '') }}"
                    class="btn btn-outline-primary btn-lg d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-telephone"></i> Gọi điện
                </a>
                <a href="https://zalo.me/{{ App\Helpers\SettingHelper::get('zalo', '') }}" target="_blank"
                    class="btn btn-outline-info btn-lg d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-chat-dots"></i> Zalo
                </a>
                <a href="{{ App\Helpers\SettingHelper::get('facebook_fanpage', 'https://facebook.com') }}" target="_blank"
                    class="btn btn-outline-primary btn-lg d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-facebook"></i> Facebook
                </a>
            </div>
            <hr class="my-3">
            <div>
                <h6 class="fw-bold mb-2">Thông tin liên hệ</h6>
                <p class="mb-2">
                    <i class="bi bi-geo-alt text-primary me-2"></i>
                    {{ App\Helpers\SettingHelper::get('address', 'Chưa cập nhật') }}
                </p>
                <p class="mb-2">
                    <i class="bi bi-telephone text-primary me-2"></i>
                    <a href="tel:{{ App\Helpers\SettingHelper::get('phone', '') }}" class="text-decoration-none">
                        {{ App\Helpers\SettingHelper::get('phone', 'Chưa cập nhật') }}
                    </a>
                </p>
                <p class="mb-0">
                    <i class="bi bi-envelope text-primary me-2"></i>
                    <a href="mailto:{{ App\Helpers\SettingHelper::get('email', '') }}" class="text-decoration-none">
                        {{ App\Helpers\SettingHelper::get('email', 'Chưa cập nhật') }}
                    </a>
                </p>
            </div>
        </div>
    </div>

    <!-- Mobile Search Modal -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="searchModalLabel">Tìm kiếm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('search') }}" method="GET" class="mb-3">
                        <div class="input-group input-group-lg">
                            <input type="text" name="q" class="form-control"
                                placeholder="Tìm kiếm khóa học, tin tức..." autofocus>
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{ $scripts ?? '' }}
    
    {{-- Bootstrap 5 JS Bundle (includes Popper) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @if(App\Helpers\SettingHelper::get('ga_body'))
        {!! App\Helpers\SettingHelper::get('ga_body') !!}
    @endif
    </script>
    @if (App\Helpers\SettingHelper::get('custom_js'))
        <script>
            {!! App\Helpers\SettingHelper::get('custom_js') !!}
        </script>
    @endif
</body>

</html>