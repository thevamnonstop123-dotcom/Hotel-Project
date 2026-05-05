@extends('layouts.app')

@section('title', 'Amenities')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/amenities/index.css') }}">
@endpush

@section('content')

<div class="amenities-page">
    <div class="page-header">
        <div>
            <h2><i class="fa-solid fa-list-check" style="color: var(--color-primary); margin-right: 8px;"></i>Amenities</h2>
            <p class="page-subtitle">Manage hotel amenities and facilities</p>
        </div>
        <a href="{{ route('amenities.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Create Amenity
        </a>
    </div>

    <div class="amenities-table">
        <div class="table-header">
            <h3>All Amenities</h3>
            <span class="count-badge">{{ $amenities->count() }} total</span>
        </div>

        <div class="table-wrapper">
            @if($amenities->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($amenities as $amenity)
                            <tr>
                                <td style="color: var(--text-muted); width: 60px;">{{ $loop->iteration }}</td>
                                <td>
                                    <span style="font-weight: 500;">{{ $amenity->name }}</span>
                                </td>
                                <td>
                                    <div class="actions-cell">
                                        <a href="{{ route('amenities.edit', $amenity->id) }}" class="btn-edit">
                                            <i class="fa-solid fa-pen"></i> Edit
                                        </a>
                                        <form action="{{ route('amenities.destroy', $amenity->id) }}" method="POST" class="delete-form" onsubmit="return confirm('Are you sure you want to delete this amenity?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete">
                                                <i class="fa-solid fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="amenities-empty">
                    <i class="fa-solid fa-list-check"></i>
                    <p>No amenities found. Start by creating one!</p>
                    <a href="{{ route('amenities.create') }}" class="btn btn-primary">
                        <i class="fa-solid fa-plus"></i> Create First Amenity
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection