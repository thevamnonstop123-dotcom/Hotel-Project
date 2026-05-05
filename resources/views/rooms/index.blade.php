@extends('layouts.app')

@section('title', 'Rooms')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/rooms/index.css') }}">
@endpush

@section('content')

<div class="rooms-page">
    <div class="page-header">
        <div>
            <h2><i class="fa-solid fa-bed" style="color: var(--color-primary); margin-right: 8px;"></i>Rooms</h2>
            <p class="page-subtitle">Manage hotel rooms and configurations</p>
        </div>
        <a href="{{ route('rooms.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Create Room
        </a>
    </div>

    @if($rooms->count() > 0)
    <div class="rooms-stats">
        <div class="room-stat-card">
            <div class="stat-icon blue">
                <i class="fa-solid fa-door-open"></i>
            </div>
            <div class="stat-info">
                <h4>{{ $rooms->count() }}</h4>
                <span>Total Rooms</span>
            </div>
        </div>
        <div class="room-stat-card">
            <div class="stat-icon green">
                <i class="fa-solid fa-wifi"></i>
            </div>
            <div class="stat-info">
                <h4>{{ $rooms->where('has_wifi', true)->count() }}</h4>
                <span>With WiFi</span>
            </div>
        </div>
        <div class="room-stat-card">
            <div class="stat-icon purple">
                <i class="fa-solid fa-list-check"></i>
            </div>
            <div class="stat-info">
                <h4>{{ $rooms->filter(fn($r) => $r->amenities->count() > 0)->count() }}</h4>
                <span>With Amenities</span>
            </div>
        </div>
    </div>
    @endif

    <div class="rooms-table">
        <div class="table-header">
            <h3>All Rooms</h3>
            <span class="count-badge">{{ $rooms->count() }} total</span>
        </div>

        <div class="table-wrapper">
            @if($rooms->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Room Number</th>
                            <th>Price/Night</th>
                            <th>Bed Type</th>
                            <th>WiFi</th>
                            <th>Amenities</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rooms as $room)
                            <tr>
                                <td>
                                    <span class="room-number-badge">
                                        <i class="fa-solid fa-hashtag"></i> {{ $room->room_number }}
                                    </span>
                                </td>
                                <td class="price-cell">${{ number_format($room->price, 2) }}</td>
                                <td>
                                    <span class="bed-type-badge {{ $room->bed_type === 'single' ? 'bed-single' : 'bed-double' }}">
                                        {{ ucfirst($room->bed_type) }}
                                    </span>
                                </td>
                                <td>
                                    @if($room->has_wifi)
                                        <span class="wifi-yes">
                                            <i class="fa-solid fa-wifi"></i> Yes
                                        </span>
                                    @else
                                        <span class="wifi-no">No</span>
                                    @endif
                                </td>
                                <td>
                                    @if($room->amenities->count() > 0)
                                        <div class="amenities-tags">
                                            @foreach($room->amenities as $amenity)
                                                <span class="amenity-tag">{{ $amenity->name }}</span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="no-amenities">— None —</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="actions-cell">
                                        <a href="{{ route('rooms.edit', $room->id) }}" class="btn-edit">
                                            <i class="fa-solid fa-pen"></i> Edit
                                        </a>
                                        <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" class="delete-form" onsubmit="return confirm('Are you sure you want to delete Room {{ $room->room_number }}?')">
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
                <div class="rooms-empty">
                    <i class="fa-solid fa-bed"></i>
                    <p>No rooms found. Start by creating one!</p>
                    <a href="{{ route('rooms.create') }}" class="btn btn-primary">
                        <i class="fa-solid fa-plus"></i> Create First Room
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection