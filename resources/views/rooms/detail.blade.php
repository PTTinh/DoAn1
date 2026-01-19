<x-layouts title="Phòng Học - {{ $room->name }}" ogTitle="{{ $room->seo_title }}"
    ogDescription="{{ $room->seo_description }}" ogImage="{{ $room->seo_image }}">

    <!-- Hero Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container">
            <div class="row align-items-center min-vh-50">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">{{ $room->name }}</h1>
                    <span class="badge bg-success me-2">
                        @php
                            $statusText = match ($room->status) {
                                'available' => 'Có sẵn',
                                'maintenance' => 'Bảo trì',
                                default => 'Không có sẵn',
                            };
                        @endphp
                        {{ $statusText }}
                    </span>
                </div>
            </div>
        </div>
    </section>

    <!-- Room Detail -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <!-- Room Image -->
                    <div class="card border-0 shadow-sm mb-4">
                        <img src="{{ Storage::url($room->image) }}" class="card-img-top" alt="{{ $room->name }}"
                            style="height: 400px; object-fit: cover;">
                    </div>

                    <!-- Room Specs -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title fw-bold mb-4">Thông tin chi tiết</h5>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-people text-primary fs-5 me-3"></i>
                                        <div>
                                            <small class="d-block text-muted">Sức chứa</small>
                                            <strong class="fs-6">{{ $room->capacity }} người</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-geo-alt text-success fs-5 me-3"></i>
                                        <div>
                                            <small class="d-block text-muted">Vị trí</small>
                                            <strong class="fs-6">{{ $room->location }}</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-cash-coin text-warning fs-5 me-3"></i>
                                        <div>
                                            <small class="d-block text-muted">Giá thuê</small>
                                            <strong class="fs-6">{{ number_format($room->price, 0, ',', '.') }} VNĐ/{{ App\Helpers\SettingHelper::get('room_rental_unit') }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Room Description -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title fw-bold mb-4">Mô tả phòng học</h5>
                            <div class="content-body">
                                {!! $room->description !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar - Booking Form -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm position-sticky" style="top: 20px;">
                        <div class="card-body">
                            <h5 class="card-title fw-bold mb-4">Đặt phòng học</h5>
                            <form action="{{ route('rooms.bookings') }}" method="POST" class="needs-validation">
                                @csrf
                                <input type="hidden" name="room_id" value="{{ $room->id }}">
                                <x-app-input 
                                    name="name" 
                                    label="Họ và tên" 
                                    type="text" 
                                    :value="old('name')" 
                                    required 
                                />
                                <x-app-input 
                                    name="email" 
                                    label="Email" 
                                    type="email" 
                                    :value="old('email')" 
                                    required 
                                />
                                <x-app-input 
                                    name="phone" 
                                    label="Số điện thoại" 
                                    type="tel" 
                                    :value="old('phone')" 
                                    required 
                                />
                                <x-app-input 
                                    name="participants_count" 
                                    label="Số người tham gia" 
                                    type="number" 
                                    :value="old('participants_count', 5)" 
                                    required 
                                />
                                <x-app-input 
                                    name="reason" 
                                    label="Lý do đặt phòng" 
                                    type="text" 
                                    :value="old('reason')" 
                                    required 
                                />
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Ghi chú (không bắt buộc)</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="room_type" class="form-label">Loại đặt phòng</label>
                                    <select class="form-select @error('room_type') is-invalid @enderror" id="room_type" name="room_type" onchange="toggleRecurrence(this.value)">
                                        <option value="none" {{ old('room_type') == 'none' ? 'selected' : '' }}>Đặt theo ngày</option>
                                        <option value="weekly" {{ old('room_type') == 'weekly' ? 'selected' : '' }}>Đặt theo tuần</option>
                                    </select>
                                    @error('room_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div id="recurrence-days" style="display: {{ old('room_type') == 'weekly' ? 'block' : 'none' }}; margin-bottom: 1rem;">
                                    <label class="form-label">Chọn ngày trong tuần</label>
                                    <div class="d-grid gap-2">
                                        @php
                                            $daysOfWeek = [
                                                'monday' => 'Thứ 2',
                                                'tuesday' => 'Thứ 3',
                                                'wednesday' => 'Thứ 4',
                                                'thursday' => 'Thứ 5',
                                                'friday' => 'Thứ 6',
                                                'saturday' => 'Thứ 7',
                                                'sunday' => 'Chủ nhật',
                                            ];
                                        @endphp
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="all-days" name="all_days" value="all" {{ old('all_days') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="all-days">Chọn tất cả</label>
                                        </div>
                                        @foreach ($daysOfWeek as $key => $day)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="{{ $key }}" 
                                                    name="repeat_days[]" value="{{ $key }}" {{ in_array($key, old('repeat_days', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="{{ $key }}">{{ $day }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <x-app-input 
                                    name="start_date" 
                                    label="Ngày bắt đầu" 
                                    type="date" 
                                    :value="old('start_date')" 
                                    required 
                                />
                                <x-app-input 
                                    name="end_date" 
                                    label="Ngày kết thúc" 
                                    type="date" 
                                    :value="old('end_date')" 
                                    required 
                                />
                                <x-app-input 
                                    name="start_time" 
                                    label="Giờ bắt đầu" 
                                    type="time" 
                                    :value="old('start_time')" 
                                    required 
                                />
                                <x-app-input 
                                    name="end_time" 
                                    label="Giờ kết thúc" 
                                    type="time" 
                                    :value="old('end_time')" 
                                    required 
                                />
                                <!-- reCAPTCHA -->
                                @if (config('services.recaptcha.enabled', false))
                                    <x-recaptcha form-type="room-booking" />
                                @endif

                                <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold">
                                    <i class="bi bi-check-circle me-2"></i>Đặt phòng ngay
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

        <script>
            function toggleRecurrence(type) {
                const recurrenceDays = document.getElementById('recurrence-days');
                recurrenceDays.style.display = type === 'weekly' ? 'block' : 'none';
                const checkboxes = recurrenceDays.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach(checkbox => {
                    checkbox.disabled = type !== 'weekly';
                    if (type !== 'weekly') checkbox.checked = false;
                });
            }

            const allDaysCheckbox = document.getElementById('all-days');
            allDaysCheckbox?.addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('#recurrence-days input[type="checkbox"]:not(#all-days)');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });

            const startDate = document.getElementById('start_date');
            const endDate = document.getElementById('end_date');
            const roomType = document.getElementById('room_type');

            startDate?.addEventListener('change', function() {
                if (roomType.value === 'none') {
                    endDate.value = startDate.value;
                }
            });
        </script>
    </x-slot:scripts>
</x-layouts>
