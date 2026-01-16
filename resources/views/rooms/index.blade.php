<x-layouts title="Phòng Học">
    <!-- Hero Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container">
            <div class="row align-items-center min-vh-50">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">
                        Phòng học tại {{ App\Helpers\SettingHelper::get('center_name', 'Trung tâm đào tạo') }}
                    </h1>
                    <p class="lead">Khám phá các phòng học hiện đại và tiện nghi của chúng tôi, nơi mang đến trải
                        nghiệm học tập tốt nhất.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Classrooms Grid -->
    <section class="py-5">
        <div class="container">
            @if ($rooms->count() > 0)
                <div class="row g-4">
                    @foreach ($rooms as $room)
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 border-0 shadow-sm transition-transform"
                                style="transition: transform 0.3s; cursor: pointer;"
                                onmouseover="this.style.transform='translateY(-5px)'"
                                onmouseout="this.style.transform='translateY(0)'">
                                <div class="position-relative" style="height: 250px; overflow: hidden;">
                                    <img src="{{ Storage::url($room->image) }}" class="w-100 h-100"
                                        alt="{{ $room->name }}" style="object-fit: cover;">
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title fw-bold">
                                        <a href="{{ route('rooms.show', $room->id) }}"
                                            class="text-decoration-none text-dark">
                                            {{ $room->name }}
                                        </a>
                                    </h5>
                                    
                                    <!-- Capacity -->
                                    <div class="mb-3">
                                        <span class="badge bg-info">
                                            <i class="bi bi-people me-1"></i>{{ $room->capacity }} chỗ ngồi
                                        </span>
                                    </div>

                                    <!-- Equipment -->
                                    <div class="mb-3 flex-grow-1">
                                        <p class="small fw-bold mb-2">Trang thiết bị:</p>
                                        @forelse ($room->equipment as $equipment)
                                            <span class="badge bg-light text-dark me-2 mb-2">
                                                <i class="bi bi-check-circle me-1"></i>{{ $equipment->name }}
                                            </span>
                                        @empty
                                            <p class="text-muted small">Không có trang thiết bị</p>
                                        @endforelse
                                    </div>

                                    <div class="mt-auto pt-3 border-top">
                                        <a href="{{ route('rooms.show', $room->id) }}"
                                            class="btn btn-primary btn-sm w-100">
                                            <i class="bi bi-arrow-right me-2"></i>Xem chi tiết
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info text-center py-5" role="alert">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Không có phòng học nào</strong>
                    <p class="mb-0 mt-2">Vui lòng quay lại sau hoặc liên hệ với chúng tôi để biết thêm thông tin.</p>
                </div>
            @endif
        </div>
    </section>
</x-layouts>
