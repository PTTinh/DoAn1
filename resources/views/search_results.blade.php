{{-- filepath: resources/views/search_results.blade.php --}}
@php
    $query = request('q', $query ?? '');
    $safeQuery = e($query);
    $sections = [
        'courses' => $courses ?? collect(),
        'news' => $news ?? collect(),
    ];
    $total = $sections['courses']->count() + $sections['news']->count();

    function highlight_fragment($text, $q) {
        if (!$q) return e($text);
        return preg_replace('/(' . preg_quote($q, '/') . ')/iu', '<mark style="background-color: #fff3cd; padding: 2px 6px; border-radius: 3px; font-weight: 600;">$1</mark>', e($text));
    }
@endphp

<x-layouts :title="'Tìm kiếm: ' . $query" :ogTitle="'Kết quả tìm kiếm cho: ' . $query" :ogDescription="'Có ' . $total . ' kết quả cho từ khóa ' . $query">
    {{-- Hero Section --}}
    <div class="bg-gradient-to-r from-primary to-info py-5 mb-5 rounded-bottom" style="background: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%);">
        <div class="container py-4">
            <h1 class="display-4 fw-bold text-white mb-3">Kết quả tìm kiếm</h1>
            <p class="lead text-white-50 mb-4">
                Từ khóa: <strong class="text-white">"{{ $safeQuery }}"</strong>
                @if($query)
                    <span class="ms-2 badge bg-info fs-6">{{ $total }} kết quả</span>
                @endif
            </p>

            {{-- Search Form --}}
            <form action="{{ route('search') }}" method="GET" role="search" class="mb-4">
                <div class="input-group input-group-lg">
                    <input type="text" name="q" value="{{ $query }}" class="form-control border-2" 
                           placeholder="Nhập từ khóa khác..." aria-label="Từ khóa">
                    <button class="btn btn-light fw-semibold" type="submit">
                        <i class="bi bi-search"></i> Tìm
                    </button>
                </div>
            </form>

            {{-- Filter Buttons --}}
            <div class="d-flex flex-wrap gap-2" aria-label="Bộ lọc kết quả">
                <button class="filter-btn btn btn-light active fw-semibold" data-target="all">
                    Tất cả <span class="badge bg-info ms-2">{{ $total }}</span>
                </button>
                <button class="filter-btn btn btn-outline-light fw-semibold" data-target="courses">
                    Khóa học <span class="badge bg-info ms-2">{{ $sections['courses']->count() }}</span>
                </button>
                <button class="filter-btn btn btn-outline-light fw-semibold" data-target="news">
                    Tin tức <span class="badge bg-info ms-2">{{ $sections['news']->count() }}</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Results Section --}}
    <div class="container mb-5">
        @if($total === 0)
            <div class="alert alert-info text-center py-5 rounded-3" role="alert">
                <h3 class="mb-3">
                    <i class="bi bi-search fs-1"></i>
                </h3>
                <h4>Không có kết quả phù hợp</h4>
                <p class="mb-0 text-muted">Gợi ý: Thử rút ngắn hoặc thay đổi từ khóa, kiểm tra chính tả.</p>
            </div>
        @endif

        {{-- Courses Section --}}
        @if($sections['courses']->count())
            <div class="result-group mb-5" data-group="courses">
                <div class="mb-4">
                    <h2 class="h3 fw-bold text-primary mb-1">
                        <i class="bi bi-book"></i> Khóa học
                    </h2>
                    <p class="text-muted">Tìm thấy {{ $sections['courses']->count() }} khóa học phù hợp</p>
                </div>

                <div class="row g-4">
                    @foreach($sections['courses'] as $course)
                        <div class="col-lg-6">
                            <div class="card h-100 shadow-sm border-0 overflow-hidden transition-all" 
                                 style="transition: transform 0.3s ease, box-shadow 0.3s ease;">
                                {{-- Image --}}
                                <div class="position-relative overflow-hidden" style="height: 200px;">
                                    <a href="{{ route('courses.show', $course->slug) }}" class="text-decoration-none">
                                        <img src="{{ Storage::url($course->featured_image) }}" 
                                             alt="{{ $course->title }}" 
                                             class="w-100 h-100 object-fit-cover"
                                             style="object-fit: cover;">
                                    </a>
                                    <span class="badge bg-primary position-absolute top-0 start-0 m-3">
                                        {{ $course->category->name }}
                                    </span>
                                </div>

                                {{-- Content --}}
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title fw-bold mb-3">
                                        <a href="{{ route('courses.show', $course->slug) }}" class="text-decoration-none text-dark">
                                            {!! highlight_fragment($course->title, $query) !!}
                                        </a>
                                    </h5>

                                    {{-- Meta Info --}}
                                    <div class="mb-3 small text-muted">
                                        @if ($course->start_date)
                                            <div class="mb-2">
                                                <i class="bi bi-calendar-event text-info"></i>
                                                <strong>Khai giảng:</strong> {{ $course->start_date->format('d/m/Y') }}
                                            </div>
                                        @endif
                                        @if ($course->end_registration_date)
                                            <div>
                                                <i class="bi bi-clock-history text-warning"></i>
                                                <strong>Hạn đăng ký:</strong> {{ $course->end_registration_date->format('d/m/Y') }}
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Description --}}
                                    <p class="card-text text-muted flex-grow-1 mb-3">
                                        {{ Str::limit($course->short_description ?? $course->description, 100) }}
                                    </p>

                                    {{-- Price --}}
                                    <div class="mb-3">
                                        @if ($course->is_price_visible)
                                            <span class="h5 text-success fw-bold">
                                                {{ number_format($course->price, 0, ',', '.') }}
                                                <small class="fw-normal">VNĐ/{{ App\Helpers\SettingHelper::get('course_unit', 'khóa') }}</small>
                                            </span>
                                        @else
                                            <span class="text-muted fst-italic">Liên hệ để biết giá</span>
                                        @endif
                                    </div>

                                    {{-- Button --}}
                                    <a href="{{ route('courses.show', $course->slug) }}" class="btn btn-primary w-100 fw-semibold">
                                        <i class="bi bi-arrow-right"></i> Xem chi tiết
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- News Section --}}
        @if($sections['news']->count())
            <div class="result-group" data-group="news">
                <div class="mb-4">
                    <h2 class="h3 fw-bold text-primary mb-1">
                        <i class="bi bi-newspaper"></i> Tin tức
                    </h2>
                    <p class="text-muted">Tìm thấy {{ $sections['news']->count() }} bài viết phù hợp</p>
                </div>

                <div class="row g-4">
                    @foreach($sections['news'] as $item)
                        <div class="col-lg-6">
                            <div class="card h-100 shadow-sm border-0 overflow-hidden transition-all"
                                 style="transition: transform 0.3s ease, box-shadow 0.3s ease;">
                                {{-- Image --}}
                                <div class="position-relative overflow-hidden" style="height: 200px;">
                                    <a href="{{ route('news.show', $item->slug) }}" class="text-decoration-none">
                                        <img src="{{ Storage::url($item->featured_image) }}" 
                                             alt="{{ $item->title }}" 
                                             class="w-100 h-100 object-fit-cover"
                                             style="object-fit: cover;">
                                    </a>
                                    <span class="badge bg-success position-absolute top-0 start-0 m-3">
                                        {{ $item->news_category->name }}
                                    </span>
                                </div>

                                {{-- Content --}}
                                <div class="card-body d-flex flex-column">
                                    <small class="text-muted mb-2">
                                        <i class="bi bi-calendar3"></i> {{ $item->published_at?->format('d/m/Y') }}
                                    </small>

                                    <h5 class="card-title fw-bold mb-3">
                                        <a href="{{ route('news.show', $item->slug) }}" class="text-decoration-none text-dark">
                                            {!! highlight_fragment($item->title, $query) !!}
                                        </a>
                                    </h5>

                                    <p class="card-text text-muted flex-grow-1 mb-3">
                                        {{ Str::limit(strip_tags($item->summary ?? $item->content), 100) }}
                                    </p>

                                    {{-- Stats --}}
                                    <div class="mb-3 small text-muted">
                                        <i class="bi bi-eye"></i>
                                        {{ $item->view_count ?? 0 }} lượt xem
                                    </div>

                                    {{-- Button --}}
                                    <a href="{{ route('news.show', $item->slug) }}" class="btn btn-outline-success w-100 fw-semibold">
                                        <i class="bi bi-arrow-right"></i> Xem thêm
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    {{-- Filter Script --}}
    <script>
        document.querySelectorAll(".filter-btn").forEach(btn => {
            btn.addEventListener("click", function() {
                document.querySelectorAll(".filter-btn").forEach(b => {
                    b.classList.remove("active");
                    b.classList.add("btn-outline-light");
                    b.classList.remove("btn-light");
                });
                
                this.classList.add("active", "btn-light");
                this.classList.remove("btn-outline-light");
                
                const target = this.dataset.target;
                document.querySelectorAll(".result-group").forEach(group => {
                    if(target === "all" || group.dataset.group === target) {
                        group.style.display = "block";
                    } else {
                        group.style.display = "none";
                    }
                });
            });
        });

        // Hover effect on cards
        document.querySelectorAll(".card").forEach(card => {
            card.addEventListener("mouseenter", function() {
                this.style.transform = "translateY(-5px)";
                this.style.boxShadow = "0 0.5rem 1rem rgba(0, 0, 0, 0.15)";
            });
            card.addEventListener("mouseleave", function() {
                this.style.transform = "translateY(0)";
                this.style.boxShadow = "0 0.125rem 0.25rem rgba(0, 0, 0, 0.075)";
            });
        });
    </script>

    <style>
        mark {
            background-color: #fff3cd;
            padding: 2px 6px;
            border-radius: 3px;
            font-weight: 600;
        }

        .object-fit-cover {
            object-fit: cover;
        }

        .filter-btn {
            transition: all 0.3s ease;
        }

        .filter-btn.active {
            background-color: #fff;
            color: #0d6efd;
        }

        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }

        .result-group {
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
</x-layouts>