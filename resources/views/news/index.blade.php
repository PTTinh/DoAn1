<x-layouts title="Tin Tức">
    <!-- Hero Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container">
            <div class="row align-items-center min-vh-50">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">
                        @if (isset($newsCategory))
                            {{ $newsCategory->name }}
                        @else
                            Tin tức nổi bật
                        @endif
                    </h1>
                    <p class="lead">
                        @if (isset($newsCategory))
                            {{ $newsCategory->description }}
                        @else
                            Khám phá những tin tức mới nhất và nổi bật từ trung tâm đào tạo của chúng tôi
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- News Articles -->
    <section class="py-5">
        <div class="container">
            @forelse ($news as $item)
                <div class="card border-0 shadow-sm mb-4 overflow-hidden">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="{{ Storage::url($item->featured_image) }}" 
                                alt="{{ $item->title }}" 
                                class="img-fluid h-100" style="object-fit: cover; min-height: 250px;">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body h-100 d-flex flex-column">
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <span class="badge bg-info">{{ $item->news_category->name }}</span>
                                    <small class="text-muted">
                                        <i class="bi bi-calendar-event me-1"></i>
                                        {{ $item->published_at?->format('d/m/Y') ?? $item->created_at->format('d/m/Y') }}
                                    </small>
                                    <small class="text-muted ms-auto">
                                        <i class="bi bi-eye me-1"></i>
                                        {{ $item->view_count ?? 0 }} lượt xem
                                    </small>
                                </div>
                                <h5 class="card-title fw-bold mb-3 flex-grow-1">{{ $item->title }}</h5>
                                <p class="card-text text-muted mb-4">{{ Str::limit(strip_tags($item->summary ?? $item->content), 140) }}</p>
                                <a href="{{ route('news.show', $item->slug) }}" 
                                    class="btn btn-primary btn-sm align-self-start">
                                    <i class="bi bi-arrow-right me-2"></i>Xem thêm
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Thông báo:</strong> Chưa có tin tức nào
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endforelse
        </div>
    </section>

    <!-- News Grid -->
    {{-- <section class="news-main-section">
        <div class="news-container">
            <div class="news-sidebar">
                <div class="sidebar-widget">
                    <h4>Tin tức mới nhất</h4>
                    <div class="recent-news">
                        <div class="recent-item">
                            <img src="https://khoinguonsangtao.vn/wp-content/uploads/2022/07/hinh-nen-may-tinh-thien-nhien-tuyet-tac-dong-co-xanh.jpg"
                                alt="Recent news">
                            <div class="recent-content">
                                <h5>Khai giảng lớp IELTS Speaking chuyên sâu</h5>
                                <span class="recent-date">14/12/2024</span>
                            </div>
                        </div>
                        <div class="recent-item">
                            <img src="https://khoinguonsangtao.vn/wp-content/uploads/2022/07/hinh-nen-may-tinh-thien-nhien-tuyet-tac-dong-co-xanh.jpg"
                                alt="Recent news">
                            <div class="recent-content">
                                <h5>Workshop: "Phương pháp học từ vựng hiệu quả"</h5>
                                <span class="recent-date">13/12/2024</span>
                            </div>
                        </div>
                        <div class="recent-item">
                            <img src="https://khoinguonsangtao.vn/wp-content/uploads/2022/07/hinh-nen-may-tinh-thien-nhien-tuyet-tac-dong-co-xanh.jpg"
                                alt="Recent news">
                            <div class="recent-content">
                                <h5>Chúc mừng 20 học viên đạt IELTS 7.0+</h5>
                                <span class="recent-date">12/12/2024</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div class="sidebar-widget">
                    <h4>Sự kiện sắp diễn ra</h4>
                    <div class="upcoming-events">
                        <div class="event-item">
                            <div class="event-date">
                                <span class="day">25</span>
                                <span class="month">THG 12</span>
                            </div>
                            <div class="event-info">
                                <h5>Christmas English Party 2024</h5>
                                <p>18:00 - 21:00</p>
                            </div>
                        </div>
                        <div class="event-item">
                            <div class="event-date">
                                <span class="day">05</span>
                                <span class="month">THG 1</span>
                            </div>
                            <div class="event-info">
                                <h5>Khai giảng khóa IELTS mùa xuân</h5>
                                <p>08:00 - 17:00</p>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>

            <div class="news-content">
                <div class="news-grid-main" id="newsGrid">
                    <!-- News articles will be populated here -->
                    <article class="news-article" data-category="events">
                        <div class="article-image">
                            <img src="https://khoinguonsangtao.vn/wp-content/uploads/2022/07/hinh-nen-may-tinh-thien-nhien-tuyet-tac-dong-co-xanh.jpg"
                                alt="News" loading="lazy">
                            <div class="article-category">Sự kiện</div>
                        </div>
                        <div class="article-content">
                            <div class="article-meta">
                                <span class="article-date">15/12/2024</span>
                                <span class="article-author">Admin</span>
                            </div>
                            <h3>Khai giảng khóa IELTS cấp tốc tháng 1/2025</h3>
                            <p>Study Academy thông báo khai giảng khóa luyện thi IELTS cấp tốc dành cho học viên có nền
                                tảng, mục tiêu đạt 6.5+ trong 2 tháng. Đăng ký ngay để nhận ưu đãi đặc biệt!</p>
                            <div class="article-footer">
                                <div class="article-stats">
                                    <span>
                                        <x-heroicon-o-eye class="inline w-5 h-5 text-gray-500" />
                                        856
                                    </span>
                                    <span>
                                        <x-heroicon-o-chat-bubble-left-ellipsis class="inline w-5 h-5 text-gray-500" />
                                        12
                                    </span>
                                </div>
                                <button class="read-more">Đọc thêm</button>
                            </div>
                        </div>
                    </article>

                    <article class="news-article" data-category="courses">
                        <div class="article-image">
                            <img src="https://khoinguonsangtao.vn/wp-content/uploads/2022/07/hinh-nen-may-tinh-thien-nhien-tuyet-tac-dong-co-xanh.jpg"
                                alt="News" loading="lazy">
                            <div class="article-category">Khóa học</div>
                        </div>
                        <div class="article-content">
                            <div class="article-meta">
                                <span class="article-date">10/12/2024</span>
                                <span class="article-author">Giáo vụ</span>
                            </div>
                            <h3>Cập nhật chương trình học mới cho khóa Business English</h3>
                            <p>Study Academy cập nhật chương trình học Business English với nội dung thực tế hơn, phù
                                hợp với môi trường làm việc hiện đại.</p>
                            <div class="article-footer">
                                <div class="article-stats">
                                    <span>
                                        <x-heroicon-o-eye class="inline w-5 h-5 text-gray-500" />
                                        423
                                    </span>
                                    <span>
                                        <x-heroicon-o-chat-bubble-left-ellipsis class="inline w-5 h-5 text-gray-500" />
                                        6
                                    </span>
                                </div>
                                <button class="read-more">Đọc thêm</button>
                            </div>
                        </div>
                    </article>
                </div>

                <!-- Pagination -->
                <div class="pagination">
                    <button class="page-btn prev-page" disabled>‹ Trước</button>
                    <button class="page-btn active">1</button>
                    <button class="page-btn">2</button>
                    <button class="page-btn">3</button>
                    <span class="page-dots">...</span>
                    <button class="page-btn">8</button>
                    <button class="page-btn next-page">Sau ›</button>
                </div>
            </div>
        </div>
    </section> --}}
</x-layouts>
