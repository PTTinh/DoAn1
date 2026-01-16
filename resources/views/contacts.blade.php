<x-layouts title="Liên hệ">
    <!-- Hero Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container">
            <div class="row align-items-center min-vh-50">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">Liên hệ với chúng tôi</h1>
                    <p class="lead">Hãy liên hệ để được tư vấn và hỗ trợ tốt nhất về các dịch vụ đào tạo và học tập.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Information Cards -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <!-- Address Card -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm text-center">
                        <div class="card-body">
                            <div class="mb-3">
                                <i class="bi bi-geo-alt text-primary" style="font-size: 2.5rem;"></i>
                            </div>
                            <h5 class="card-title fw-bold">Địa chỉ</h5>
                            <p class="card-text text-muted">
                                {{ App\Helpers\SettingHelper::get('address', 'Chưa cập nhật') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Phone Card -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm text-center">
                        <div class="card-body">
                            <div class="mb-3">
                                <i class="bi bi-telephone text-success" style="font-size: 2.5rem;"></i>
                            </div>
                            <h5 class="card-title fw-bold">Điện thoại</h5>
                            <p class="card-text">
                                <a href="tel:{{ App\Helpers\SettingHelper::get('phone', '') }}"
                                    class="text-decoration-none text-muted">
                                    {{ App\Helpers\SettingHelper::get('phone', 'Chưa cập nhật') }}
                                </a>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Email Card -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm text-center">
                        <div class="card-body">
                            <div class="mb-3">
                                <i class="bi bi-envelope text-danger" style="font-size: 2.5rem;"></i>
                            </div>
                            <h5 class="card-title fw-bold">Email</h5>
                            <p class="card-text">
                                <a href="mailto:{{ App\Helpers\SettingHelper::get('email', '') }}"
                                    class="text-decoration-none text-muted">
                                    {{ App\Helpers\SettingHelper::get('email', 'Chưa cập nhật') }}
                                </a>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Working Hours Card -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm text-center">
                        <div class="card-body">
                            <div class="mb-3">
                                <i class="bi bi-clock text-warning" style="font-size: 2.5rem;"></i>
                            </div>
                            <h5 class="card-title fw-bold">Giờ làm việc</h5>
                            <p class="card-text small text-muted mb-1">
                                <strong>Thứ 2 - Thứ 7</strong>
                            </p>
                            <p class="card-text small text-muted mb-1">
                                <strong>Sáng:</strong> 8:00 - 11:30
                            </p>
                            <p class="card-text small text-muted mb-1">
                                <strong>Tối:</strong> 18:00 - 21:00
                            </p>
                            <p class="card-text small text-muted">
                                <strong>Chủ nhật:</strong> Nghỉ
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Google Map Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="display-5 fw-bold mb-5 text-primary">Vị trí trung tâm</h2>
            <div class="ratio ratio-16x9 rounded-3 overflow-hidden shadow">
                <iframe src="{{ App\Helpers\SettingHelper::get('google_map', '') }}"
                    style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </section>
</x-layouts>
