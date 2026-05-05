@extends('layouts.app')

@section('title', 'Create Booking')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/bookings/create.css') }}">
@endpush

@section('content')

<div class="create-booking-wrapper">
    <div class="page-header">
        <h2><i class="fa-solid fa-calendar-plus" style="color: var(--color-primary); margin-right: 8px;"></i>Create Booking</h2>
        <a href="{{ route('bookings.index') }}" class="btn btn-secondary btn-sm">
            <i class="fa-solid fa-arrow-left"></i> Back to Bookings
        </a>
    </div>

    <form action="{{ route('bookings.store') }}" method="POST" class="booking-form">
        @csrf

        <!-- ROOM SELECTION SECTION -->
        <div class="form-section">
            <div class="section-title">
                <i class="fa-solid fa-bed"></i> Room Selection
            </div>
            <div class="form-group">
                <label for="room_id" class="form-label">
                    Select Room <span class="required-star">*</span>
                </label>
                <select name="room_id" id="room_id" class="form-select" required>
                    <option value="">-- Choose a room --</option>
                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                            Room {{ $room->room_number }} — ${{ number_format($room->price, 2) }} / night
                        </option>
                    @endforeach
                </select>
                @error('room_id')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- GUEST DETAILS SECTION -->
        <div class="form-section">
            <div class="section-title">
                <i class="fa-solid fa-user"></i> Guest Details
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="guest_name" class="form-label">
                        Guest Name <span class="required-star">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="guest_name" 
                        id="guest_name" 
                        class="form-input" 
                        placeholder="Enter guest full name" 
                        value="{{ old('guest_name') }}"
                        required
                    >
                    @error('guest_name')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="guest_phone" class="form-label">
                        Guest Phone <span class="required-star">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="guest_phone" 
                        id="guest_phone" 
                        class="form-input" 
                        placeholder="e.g. +1 234 567 8900" 
                        value="{{ old('guest_phone') }}"
                        required
                    >
                    @error('guest_phone')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- DATES SECTION -->
        <div class="form-section">
            <div class="section-title">
                <i class="fa-solid fa-calendar-days"></i> Stay Dates
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="check_in" class="form-label">
                        Check-in Date <span class="required-star">*</span>
                    </label>
                    <input 
                        type="date" 
                        name="check_in" 
                        id="check_in" 
                        class="form-input" 
                        value="{{ old('check_in') }}"
                        required
                    >
                    @error('check_in')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="check_out" class="form-label">
                        Check-out Date <span class="required-star">*</span>
                    </label>
                    <input 
                        type="date" 
                        name="check_out" 
                        id="check_out" 
                        class="form-input" 
                        value="{{ old('check_out') }}"
                        required
                    >
                    <p class="form-hint">Check-out must be after check-in date.</p>
                    @error('check_out')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- PRICE PREVIEW (JS will calculate) -->
        <div class="price-preview" id="pricePreview" style="display: none;">
            <div class="price-icon">
                <i class="fa-solid fa-tag"></i>
            </div>
            <div class="price-info">
                <div class="price-label">Estimated Total Price</div>
                <div class="price-value" id="totalPrice">$0.00</div>
                <div class="price-per-night" id="nightsCount">0 nights</div>
            </div>
        </div>

        <!-- FORM ACTIONS -->
        <div class="form-actions">
            <a href="{{ route('bookings.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fa-solid fa-check-circle"></i> Book Room
            </button>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
    // Calculate price when dates change
    const checkIn = document.getElementById('check_in');
    const checkOut = document.getElementById('check_out');
    const roomSelect = document.getElementById('room_id');
    const pricePreview = document.getElementById('pricePreview');
    const totalPriceEl = document.getElementById('totalPrice');
    const nightsCountEl = document.getElementById('nightsCount');

    function calculatePrice() {
        const inDate = checkIn.value;
        const outDate = checkOut.value;
        const selectedOption = roomSelect.options[roomSelect.selectedIndex];
        
        if (inDate && outDate && roomSelect.value) {
            const start = new Date(inDate);
            const end = new Date(outDate);
            const nights = Math.ceil((end - start) / (1000 * 60 * 60 * 24));
            
            if (nights > 0) {
                const priceText = selectedOption.textContent;
                const priceMatch = priceText.match(/\$([\d,]+\.?\d*)/);
                const pricePerNight = priceMatch ? parseFloat(priceMatch[1].replace(/,/g, '')) : 0;
                const total = pricePerNight * nights;
                
                totalPriceEl.textContent = '$' + total.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                nightsCountEl.textContent = nights + (nights === 1 ? ' night' : ' nights');
                pricePreview.style.display = 'flex';
            } else {
                pricePreview.style.display = 'none';
            }
        } else {
            pricePreview.style.display = 'none';
        }
    }

    checkIn.addEventListener('change', calculatePrice);
    checkOut.addEventListener('change', calculatePrice);
    roomSelect.addEventListener('change', calculatePrice);
</script>
@endpush