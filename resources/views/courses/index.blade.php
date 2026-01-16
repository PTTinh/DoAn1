<x-layouts title="Khóa học">
    <!-- Hero Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container">
            <div class="row align-items-center min-vh-50">
                <div class="col-lg-8">
                    @if (isset($category))
                        <h1 class="display-4 fw-bold mb-3">{{ $category->name }}</h1>
                        <p class="lead">{{ $category->description }}</p>
                    @else
                        <h1 class="display-4 fw-bold mb-3">Tất cả các khóa học</h1>
                        <p class="lead">Khám phá các khóa học chất lượng cao tại trung tâm đào tạo của chúng tôi.</p>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Courses Grid -->
    <section class="py-5">
        <div class="container">
            @if ($courses->count() > 0)
                <div class="row g-4">
                    @foreach ($courses as $course)
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 border-0 shadow-sm transition-transform"
                                style="transition: transform 0.3s; cursor: pointer;"
                                onmouseover="this.style.transform='translateY(-5px)'"
                                onmouseout="this.style.transform='translateY(0)'">
                                <div class="position-relative">
                                    <img src="{{ Storage::url($course->featured_image) }}" class="card-img-top"
                                        alt="{{ $course->title }}" style="height: 250px; object-fit: cover;">
                                    <span class="badge bg-primary position-absolute top-0 start-0 m-3">
                                        {{ $course->category->name }}
                                    </span>
                                    @if ($course->start_date)
                                        <span class="badge bg-success position-absolute bottom-0 start-0 m-3">
                                            <i class="bi bi-calendar me-1"></i>{{ $course->start_date->format('d/m/Y') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title fw-bold">
                                        <a href="{{ route('courses.show', $course->slug) }}"
                                            class="text-decoration-none text-dark">
                                            {{ $course->title }}
                                        </a>
                                    </h5>
                                    <p class="card-text text-muted flex-grow-1">
                                        {{ Str::limit($course->short_description ?? $course->description, 100) }}
                                    </p>
                                    @if ($course->end_registration_date)
                                        <small class="text-muted d-block mb-3">
                                            <i class="bi bi-hourglass-split me-1"></i>
                                            <strong>Hạn đăng ký:</strong> {{ $course->end_registration_date->format('d/m/Y') }}
                                        </small>
                                    @endif
                                    <div class="mt-3 pt-3 border-top">
                                        <a href="{{ route('courses.show', $course->slug) }}"
                                            class="btn btn-primary btn-sm w-100">
                                            <i class="bi bi-arrow-right me-2"></i>Xem chi tiết
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if ($courses->hasPages())
                    <nav aria-label="Page navigation" class="mt-5">
                        {{ $courses->links('pagination::bootstrap-5') }}
                    </nav>
                @endif
            @else
                <div class="alert alert-info text-center py-5" role="alert">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Không có khóa học nào</strong>
                    <p class="mb-0 mt-2">Vui lòng quay lại sau hoặc liên hệ với chúng tôi để biết thêm thông tin.</p>
                </div>
            @endif
        </div>
    </section>
</x-layouts>
