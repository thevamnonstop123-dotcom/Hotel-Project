@extends('layouts.app')

@section('title', 'Edit Amenity')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/components/forms.css') }}">
    <link rel="stylesheet" href="{{ asset('css/amenities/edit.css') }}">
@endpush

@section('content')

<div class="edit-amenity-wrapper">
    <div class="page-header">
        <h2><i class="fa-solid fa-pen-to-square" style="color: var(--color-warning); margin-right: 8px;"></i>Edit Amenity</h2>
        <a href="{{ route('amenities.index') }}" class="btn btn-secondary btn-sm">
            <i class="fa-solid fa-arrow-left"></i> Back to List
        </a>
    </div>

    <form action="{{ route('amenities.update', $amenity->id) }}" method="POST" class="edit-amenity-form">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name" class="form-label">Amenity Name <span style="color: var(--color-danger);">*</span></label>
            <input 
                type="text" 
                name="name" 
                id="name" 
                class="form-input" 
                value="{{ old('name', $amenity->name) }}"
                placeholder="e.g. WiFi, Pool, Gym, Spa..."
                required
            >
            @error('name')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-actions">
            <a href="{{ route('amenities.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-check"></i> Update Amenity
            </button>
        </div>
    </form>
</div>

@endsection