<x-layouts title="Khóa Học - {{ $course->title }}" ogTitle="{{ $course->seo_title }}"
    ogDescription="{{ $course->seo_description }}" ogImage="{{ $course->seo_image }}">

    <!-- Hero Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container">
            <div class="row align-items-center min-vh-50">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">{{ $course->title }}</h1>
                    <p class="lead">{{ $course->description ?? 'Khám phá khóa học chất lượng cao tại ' . App\Helpers\SettingHelper::get('center_name', 'Trung tâm đào tạo') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Course Detail Content -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <!-- Course Image & Meta -->
                    <div class="card border-0 shadow-sm mb-4">
                        <img src="{{ Storage::url($course->featured_image) }}" class="card-img-top" alt="{{ $course->title }}"
                            style="height: 400px; object-fit: cover;">
                        <div class="card-body">
                            <span class="badge bg-primary mb-3">{{ $course->category->name }}</span>
                            
                            <!-- Course Meta Info -->
                            <div class="row g-3 mb-4">
                                @if ($course->start_date)
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-calendar text-primary fs-5 me-2"></i>
                                            <div>
                                                <small class="d-block text-muted">Khai giảng</small>
                                                <strong>{{ $course->start_date->format('d/m/Y') }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if ($course->registration_deadline)
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-hourglass-split text-warning fs-5 me-2"></i>
                                            <div>
                                                <small class="d-block text-muted">Hạn đăng ký</small>
                                                <strong>{{ $course->registration_deadline->format('d/m/Y') }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-people text-success fs-5 me-2"></i>
                                        <div>
                                            <small class="d-block text-muted">Sức chứa</small>
                                            <strong>{{ $course->max_students }} người</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-info-circle text-info fs-5 me-2"></i>
                                        <div>
                                            <small class="d-block text-muted">Trạng thái</small>
                                            <strong>
                                                @php
                                                    $statusText = match ($course->status) {
                                                        'published' => 'Đang hoạt động',
                                                        'draft' => 'Chưa công bố',
                                                        default => 'Không hoạt động',
                                                    };
                                                    $statusColor = match ($course->status) {
                                                        'published' => 'success',
                                                        'draft' => 'warning',
                                                        default => 'danger',
                                                    };
                                                @endphp
                                                <span class="badge bg-{{ $statusColor }}">{{ $statusText }}</span>
                                            </strong>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Price -->
                            <hr>
                            <div class="py-3">
                                @if ($course->is_price_visible)
                                    <p class="mb-0">
                                        <span class="h4 text-primary fw-bold">{{ number_format($course->price, 0, ',', '.') }} VNĐ</span>
                                        <small class="text-muted">/{{ App\Helpers\SettingHelper::get('course_rental_unit', 'khóa') }}</small>
                                    </p>
                                @else
                                    <p class="mb-0 text-muted">
                                        <em>Liên hệ để biết thêm chi tiết giá</em>
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Course Content -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h4 class="card-title fw-bold mb-4">Nội dung khóa học</h4>
                            <div class="course-content-body">
                                {!! $course->content !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar - Registration Form -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm position-sticky" style="top: 20px;">
                        <div class="card-body">
                            <h5 class="card-title fw-bold mb-4">Đăng ký tư vấn</h5>
                            <form action="{{ route('courses.registration') }}" method="POST" class="needs-validation">
                                @csrf
                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                                <x-app-input 
                                    name="name" 
                                    label="Họ và tên" 
                                    placeholder="Nhập họ và tên" 
                                    required 
                                />
                                <x-app-input 
                                    type="email"
                                    name="email" 
                                    label="Email" 
                                    placeholder="Nhập email" 
                                    required 
                                />
                                <x-app-input 
                                    type="tel"
                                    name="phone" 
                                    label="Số điện thoại" 
                                    placeholder="Nhập số điện thoại" 
                                    required 
                                />
                                <!-- reCAPTCHA -->
                                @if (config('services.recaptcha.enabled', false))
                                    <x-recaptcha form-type="course-registration" />
                                @endif

                                <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold">
                                    <i class="bi bi-check-circle me-2"></i>Đăng ký tư vấn
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <x-slot:scripts>
        @if (config('services.recaptcha.enabled', false))
            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        @endif
    </x-slot:scripts>
</x-layouts>
