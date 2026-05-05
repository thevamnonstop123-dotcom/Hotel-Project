@extends('layouts.app')

@section('title', 'Create Amenity')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/components/forms.css') }}">
    <link rel="stylesheet" href="{{ asset('css/amenities/create.css') }}">
@endpush

@section('content')

<div class="create-amenity-wrapper">
    <div class="page-header">
        <h2><i class="fa-solid fa-plus-circle" style="color: var(--color-primary); margin-right: 8px;"></i>Create Amenity</h2>
        <a href="{{ route('amenities.index') }}" class="btn btn-secondary btn-sm">
            <i class="fa-solid fa-arrow-left"></i> Back to List
        </a>
    </div>

    <form action="{{ route('amenities.store') }}" method="POST" class="create-amenity-form">
        @csrf

        <div class="form-group">
            <label for="name" class="form-label">Amenity Name <span style="color: var(--color-danger);">*</span></label>
            <input 
                type="text" 
                name="name" 
                id="name" 
                class="form-input" 
                placeholder="e.g. WiFi, Pool, Gym, Spa..."
                value="{{ old('name') }}"
                required
            >
            <p class="form-hint">Enter the name of the amenity (e.g., Free WiFi, Swimming Pool).</p>
            @error('name')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-actions">
            <a href="{{ route('amenities.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> Create Amenity
            </button>
        </div>
    </form>
</div>

@endsection