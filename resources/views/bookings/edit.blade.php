@extends('layouts.app')

@section('title', 'Edit Booking')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/bookings/edit.css') }}">
@endpush

@section('content')

<div class="edit-booking-wrapper">
    <div class="page-header">
        <h2><i class="fa-solid fa-pen-to-square" style="color: var(--color-warning); margin-right: 8px;"></i>Edit Booking</h2>
        <a href="{{ route('bookings.index') }}" class="btn btn-secondary btn-sm">
            <i class="fa-solid fa-arrow-left"></i> Back to Bookings
        </a>
    </div>

    <form action="{{ route('bookings.update', $booking->id) }}" method="POST" class="booking-edit-form">
        @csrf
        @method('PUT')

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
                        <option value="{{ $room->id }}" {{ old('room_id', $booking->room_id) == $room->id ? 'selected' : '' }}>
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
                        value="{{ old('guest_name', $booking->guest_name) }}"
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
                        value="{{ old('guest_phone', $booking->guest_phone) }}"
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

            <div class="current-info">
                <i class="fa-solid fa-circle-info"></i>
                <span>Current booking: <strong>{{ $booking->check_in }}</strong> to <strong>{{ $booking->check_out }}</strong></span>
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
                        value="{{ old('check_in', $booking->check_in) }}"
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
                        value="{{ old('check_out', $booking->check_out) }}"
                        required
                    >
                    <p class="form-hint">Check-out must be after check-in date.</p>
                    @error('check_out')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- FORM ACTIONS -->
        <div class="form-actions">
            <a href="{{ route('bookings.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fa-solid fa-check"></i> Update Booking
            </button>
        </div>
    </form>
</div>

@endsection