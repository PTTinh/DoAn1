<x-layouts title="Tin Tức - {{ $news_item->title }}" ogTitle="{{ $news_item->seo_title }}"
    ogDescription="{{ $news_item->seo_description }}" ogImage="{{ $news_item->seo_image }}">

    <!-- Hero Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container">
            <div class="row align-items-center min-vh-50">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-4">{{ $news_item->title }}</h1>
                    <div class="d-flex gap-3 flex-wrap">
                        <small class="text-white-50">
                            <i class="bi bi-calendar-event me-1"></i>
                            {{ $news_item->published_at->format('d/m/Y') }}
                        </small>
                        <small class="text-white-50">
                            <i class="bi bi-person me-1"></i>
                            {{ $news_item->user->name }}
                        </small>
                        <small class="text-white-50">
                            <i class="bi bi-eye me-1"></i>
                            {{ $news_item->view_count }} lượt xem
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Content Section -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <!-- Featured Image -->
                    @if ($news_item->featured_image)
                        <div class="card border-0 shadow-sm mb-4 overflow-hidden">
                            <img src="{{ Storage::url($news_item->featured_image) }}" 
                                class="card-img-top" alt="{{ $news_item->title }}"
                                style="height: 400px; object-fit: cover;">
                        </div>
                    @endif

                    <!-- Article Content -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="content-body">
                                {!! $news_item->content !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Related News -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title fw-bold mb-4">
                                <i class="bi bi-link-45deg me-2"></i>Tin tức liên quan
                            </h5>
                            <div class="d-flex flex-column gap-3">
                                @forelse($relatedNews as $item)
                                    <a href="{{ route('news.show', $item->slug) }}" 
                                        class="text-decoration-none d-flex gap-2 p-2 rounded"
                                        style="transition: background-color 0.3s; hover">
                                        <img src="{{ Storage::url($item->featured_image) }}" 
                                            alt="{{ $item->title }}"
                                            class="rounded" style="width: 80px; height: 80px; object-fit: cover;">
                                        <div class="flex-grow-1 min-w-0">
                                            <p class="mb-1 fw-bold text-dark" style="font-size: 0.95rem;">
                                                {{ Str::limit($item->title, 45) }}
                                            </p>
                                            <small class="text-muted">
                                                {{ $item->published_at->format('d/m/Y') }}
                                            </small>
                                        </div>
                                    </a>
                                @empty
                                    <p class="text-muted small">Không có tin tức liên quan</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Recent News -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title fw-bold mb-4">
                                <i class="bi bi-clock-history me-2"></i>Tin tức mới nhất
                            </h5>
                            <div class="d-flex flex-column gap-3">
                                @forelse($recentNews as $item)
                                    <a href="{{ route('news.show', $item->slug) }}" 
                                        class="text-decoration-none d-flex gap-2 p-2 rounded"
                                        style="transition: background-color 0.3s;">
                                        <img src="{{ Storage::url($item->featured_image) }}" 
                                            alt="{{ $item->title }}"
                                            class="rounded" style="width: 80px; height: 80px; object-fit: cover;">
                                        <div class="flex-grow-1 min-w-0">
                                            <p class="mb-1 fw-bold text-dark" style="font-size: 0.95rem;">
                                                {{ Str::limit($item->title, 45) }}
                                            </p>
                                            <small class="text-muted">
                                                {{ $item->published_at->format('d/m/Y') }}
                                            </small>
                                        </div>
                                    </a>
                                @empty
                                    <p class="text-muted small">Không có tin tức mới</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts>
