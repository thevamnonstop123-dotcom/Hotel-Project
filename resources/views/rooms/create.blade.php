@extends('layouts.app')

@section('title', 'Create Room')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/rooms/create.css') }}">
@endpush

@section('content')

<div class="create-room-wrapper">
    <div class="page-header">
        <h2><i class="fa-solid fa-plus-circle" style="color: var(--color-primary); margin-right: 8px;"></i>Create Room</h2>
        <a href="{{ route('rooms.index') }}" class="btn btn-secondary btn-sm">
            <i class="fa-solid fa-arrow-left"></i> Back to Rooms
        </a>
    </div>

    <form action="{{ route('rooms.store') }}" method="POST" class="room-form">
        @csrf

        <!-- ROOM DETAILS SECTION -->
        <div class="form-section">
            <div class="section-title">
                <i class="fa-solid fa-door-open"></i> Room Details
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="room_number" class="form-label">
                        Room Number <span class="required-star">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="room_number" 
                        id="room_number" 
                        class="form-input" 
                        placeholder="e.g. 101, A-102" 
                        value="{{ old('room_number') }}"
                        required
                    >
                    <p class="form-hint">Enter a unique room number or code.</p>
                    @error('room_number')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="price" class="form-label">
                        Price per Night <span class="required-star">*</span>
                    </label>
                    <div class="price-input-wrapper">
                        <span class="dollar-sign">$</span>
                        <input 
                            type="number" 
                            step="0.01" 
                            min="0"
                            name="price" 
                            id="price" 
                            class="form-input" 
                            placeholder="0.00" 
                            value="{{ old('price') }}"
                            required
                        >
                    </div>
                    @error('price')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- ROOM FEATURES SECTION -->
        <div class="form-section">
            <div class="section-title">
                <i class="fa-solid fa-sliders"></i> Room Features
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="bed_type" class="form-label">
                        Bed Type <span class="required-star">*</span>
                    </label>
                    <select name="bed_type" id="bed_type" class="form-select" required>
                        <option value="">-- Select Bed Type --</option>
                        <option value="single" {{ old('bed_type') == 'single' ? 'selected' : '' }}>🛏️ Single</option>
                        <option value="double" {{ old('bed_type') == 'double' ? 'selected' : '' }}>🛏️🛏️ Double</option>
                    </select>
                    @error('bed_type')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="has_wifi" class="form-label">
                        WiFi Available
                    </label>
                    <select name="has_wifi" id="has_wifi" class="form-select">
                        <option value="1" {{ old('has_wifi') == '1' ? 'selected' : '' }}>📶 Yes</option>
                        <option value="0" {{ old('has_wifi') == '0' ? 'selected' : '' }}>🚫 No</option>
                    </select>
                    @error('has_wifi')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- AMENITIES SECTION -->
        <div class="form-section">
            <div class="section-title">
                <i class="fa-solid fa-list-check"></i> Amenities
            </div>

            @if($amenities->count() > 0)
                <div class="amenities-grid">
                    @foreach ($amenities as $amenity)
                        <label class="amenity-checkbox-item">
                            <input 
                                type="checkbox" 
                                name="amenities[]" 
                                value="{{ $amenity->id }}"
                                {{ in_array($amenity->id, old('amenities', [])) ? 'checked' : '' }}
                            >
                            <span class="amenity-icon">
                                @php
                                    $iconMap = [
                                        'wifi' => 'fa-wifi',
                                        'pool' => 'fa-water-ladder',
                                        'gym' => 'fa-dumbbell',
                                        'spa' => 'fa-spa',
                                        'parking' => 'fa-square-parking',
                                        'ac' => 'fa-snowflake',
                                        'tv' => 'fa-tv',
                                        'breakfast' => 'fa-mug-saucer',
                                    ];
                                    $icon = $iconMap[strtolower($amenity->name)] ?? 'fa-check';
                                @endphp
                                <i class="fa-solid {{ $icon }}"></i>
                            </span>
                            <span>{{ $amenity->name }}</span>
                        </label>
                    @endforeach
                </div>
            @else
                <div class="no-amenities-message">
                    <i class="fa-solid fa-list-check"></i>
                    No amenities available.
                    <a href="{{ route('amenities.create') }}" style="color: var(--color-primary);">Create amenities first</a>
                </div>
            @endif

            @error('amenities')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- FORM ACTIONS -->
        <div class="form-actions">
            <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fa-solid fa-check-circle"></i> Save Room
            </button>
        </div>
    </form>
</div>

@endsection