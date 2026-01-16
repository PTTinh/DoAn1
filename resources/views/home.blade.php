<x-layouts>
    <!-- Welcome Banner -->
    <div class="alert alert-info mb-0 text-center py-3" role="alert" style="border-radius: 0;">
        <div class="text-nowrap overflow-hidden">
            <span class="d-inline-block animation-scroll">
                {!! App\Helpers\SettingHelper::get(
                    'welcome_message',
                    'Chào mừng bạn đến với ' .
                        App\Helpers\SettingHelper::get('center_name', 'Trung tâm đào tạo') .
                        ' - Nơi học tập và phát triển bản thân!',
                ) !!}
            </span>
        </div>
    </div>

    <!-- Hero Carousel Section -->
    <section id="heroCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
        <div class="carousel-indicators">
            @foreach ($slides as $index => $slide)
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $index }}"
                    class="{{ $index === 0 ? 'active' : '' }}" aria-label="Slide {{ $index + 1 }}"></button>
            @endforeach
        </div>
        <div class="carousel-inner">
            @foreach ($slides as $index => $slide)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}" data-url="{{ $slide->link_url }}" style="cursor: pointer;">
                    <img src="{{ Storage::url($slide->image_url) }}" class="d-block w-100" alt="{{ $slide->title }}"
                        style="height: 500px; object-fit: cover;">
                    <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 p-4">
                        <h2 class="fw-bold mb-3">{{ $slide->title }}</h2>
                        <p class="lead">{{ $slide->description }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </section>

    <!-- Stats Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="text-center">
                        <x-heroicon-s-check class="text-primary" style="width: 48px; height: 48px; margin: 0 auto 15px;" />
                        <h4 class="fw-bold text-primary mb-2">8+</h4>
                        <p class="text-muted">Năm kinh nghiệm và phát triển</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="text-center">
                        <x-heroicon-s-academic-cap class="text-success" style="width: 48px; height: 48px; margin: 0 auto 15px;" />
                        <h4 class="fw-bold text-success mb-2">100%</h4>
                        <p class="text-muted">Giảng viên có chứng chỉ quốc tế</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="text-center">
                        <x-heroicon-s-users class="text-warning" style="width: 48px; height: 48px; margin: 0 auto 15px;" />
                        <h4 class="fw-bold text-warning mb-2">1000+</h4>
                        <p class="text-muted">Học viên tin tưởng</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="text-center">
                        <x-heroicon-s-academic-cap class="text-danger" style="width: 48px; height: 48px; margin: 0 auto 15px;" />
                        <h4 class="fw-bold text-danger mb-2">100%</h4>
                        <p class="text-muted">Đạt mục tiêu đề ra</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Section -->
    <section class="py-5" id="about">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-6">
                    <h2 class="display-5 fw-bold mb-4 text-primary">Giới thiệu về {{ App\Helpers\SettingHelper::get('center_name', 'Trung tâm đào tạo') }}</h2>
                    <div class="lead text-muted lh-lg">
                        {!! App\Helpers\SettingHelper::get('description', 'Chưa cập nhật') !!}
                    </div>
                </div>
                @if (App\Helpers\SettingHelper::get('youtube_embed'))
                    <div class="col-lg-6">
                        <div class="ratio ratio-16x9">
                            <iframe src="{{App\Helpers\SettingHelper::get('youtube_embed')}}" title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
    <!-- Feedback/Testimonials Section -->
    @php
        $feedbacks = json_decode(App\Helpers\SettingHelper::get('feedback', '[]'), true);
        if (!is_array($feedbacks)) {
            $feedbacks = [];
        }
    @endphp
    @if ($feedbacks)
        <section class="py-5 bg-light">
            <div class="container">
                <h2 class="text-center display-5 fw-bold mb-5 text-primary">Học viên nói gì về chúng tôi</h2>
                <div id="feedbackCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($feedbacks as $index => $feedback)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body p-5">
                                                <div class="d-flex align-items-center mb-4">
                                                    <img src="{{ Storage::url($feedback['avatar']) }}" alt="{{ $feedback['name'] }}"
                                                        class="rounded-circle me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                                    <div>
                                                        <h5 class="card-title mb-1">{{ $feedback['name'] }}</h5>
                                                        <div class="text-warning">
                                                            @for ($i = 0; $i < 5; $i++)
                                                                <i class="bi bi-star-fill"></i>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="card-text fst-italic text-muted">{{ $feedback['content'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#feedbackCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#feedbackCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </section>
    @endif
    <!-- Latest Courses Section -->
    @if ($courses->count() > 0)
        <section class="py-5">
            <div class="container">
                <h2 class="display-5 fw-bold mb-5 text-primary">Khóa học mới nhất</h2>
                <div class="row g-4">
                    @foreach ($courses->take(6) as $course)
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 border-0 shadow-sm transition-transform" style="transition: transform 0.3s;">
                                <div class="position-relative">
                                    <img src="{{ Storage::url($course->featured_image) }}" class="card-img-top" alt="{{ $course->title }}" style="height: 250px; object-fit: cover;">
                                    <span class="badge bg-primary position-absolute top-0 start-0 m-3">{{ $course->category->name }}</span>
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title fw-bold">
                                        <a href="{{ route('courses.show', $course->slug) }}" class="text-decoration-none text-dark">
                                            {{ $course->title }}
                                        </a>
                                    </h5>
                                    <p class="card-text text-muted flex-grow-1">
                                        {{ Str::limit($course->short_description ?? $course->description, 100) }}
                                    </p>
                                    <div class="mt-3 pt-3 border-top">
                                        <a href="{{ route('courses.show', $course->slug) }}" class="btn btn-primary btn-sm w-100">Xem chi tiết</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if ($courses->count() > 6)
                    <div class="text-center mt-5">
                        <a href="{{ route('courses.index') }}" class="btn btn-outline-primary btn-lg">Xem tất cả khóa học</a>
                    </div>
                @endif
            </div>
        </section>
    @endif
    <!-- Latest News Section -->
    @if ($news->count() > 0)
        <section class="py-5 bg-light">
            <div class="container">
                <h2 class="display-5 fw-bold mb-5 text-primary">Tin tức mới nhất</h2>
                <div class="row g-4">
                    @foreach ($news as $item)
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="position-relative">
                                    <img src="{{ Storage::url($item->featured_image) }}" class="card-img-top" alt="{{ $item->title }}" style="height: 250px; object-fit: cover;">
                                    <span class="badge bg-info position-absolute top-0 start-0 m-3">{{ $item->news_category->name }}</span>
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <small class="text-muted mb-2">
                                        <i class="bi bi-calendar"></i> {{ $item->published_at?->format('d/m/Y') }}
                                    </small>
                                    <h5 class="card-title fw-bold">
                                        <a href="{{ route('news.show', $item->slug) }}" class="text-decoration-none text-dark">
                                            {{ $item->title }}
                                        </a>
                                    </h5>
                                    <p class="card-text text-muted flex-grow-1">
                                        {{ Str::limit(strip_tags($item->summary ?? $item->content), 100) }}
                                    </p>
                                    <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <i class="bi bi-eye"></i> {{ $item->view_count }} lượt xem
                                        </small>
                                        <a href="{{ route('news.show', $item->slug) }}" class="btn btn-link btn-sm text-decoration-none">Xem thêm →</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if ($news->count() > 3)
                    <div class="text-center mt-5">
                        <a href="{{ route('news.index') }}" class="btn btn-outline-primary btn-lg">Xem tất cả tin tức</a>
                    </div>
                @endif
            </div>
        </section>
    @endif
    <x-slot:scripts>
        <script>
            // Hero carousel - click to navigate to link_url
            document.querySelectorAll('.carousel-item').forEach(item => {
                item.addEventListener('click', function() {
                    const url = this.dataset.url;
                    if (url) window.open(url, '_blank');
                });
            });
        </script>
    </x-slot:scripts>
</x-layouts>
