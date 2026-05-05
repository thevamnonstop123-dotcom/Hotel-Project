@extends('layouts.app')

@section('title', 'Bookings')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/bookings/index.css') }}">
@endpush

@section('content')

<div class="bookings-page">
    <div class="page-header">
        <div>
            <h2><i class="fa-solid fa-calendar-check" style="color: var(--color-primary); margin-right: 8px;"></i>Bookings</h2>
            <p class="page-subtitle">Manage all room bookings and reservations</p>
        </div>
        <a href="{{ route('bookings.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> New Booking
        </a>
    </div>

    {{-- Optional Stats Row (if you have counts) --}}
    @if($bookings->count() > 0)
    <div class="bookings-stats">
        <div class="booking-stat-card">
            <div class="stat-icon blue">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <div class="stat-info">
                <h4>{{ $bookings->count() }}</h4>
                <span>Total Bookings</span>
            </div>
        </div>
        <div class="booking-stat-card">
            <div class="stat-icon green">
                <i class="fa-solid fa-check-circle"></i>
            </div>
            <div class="stat-info">
                <h4>{{ $bookings->where('status', 'confirmed')->count() }}</h4>
                <span>Confirmed</span>
            </div>
        </div>
        <div class="booking-stat-card">
            <div class="stat-icon amber">
                <i class="fa-solid fa-clock"></i>
            </div>
            <div class="stat-info">
                <h4>{{ $bookings->where('status', 'pending')->count() }}</h4>
                <span>Pending</span>
            </div>
        </div>
        <div class="booking-stat-card">
            <div class="stat-icon red">
                <i class="fa-solid fa-xmark-circle"></i>
            </div>
            <div class="stat-info">
                <h4>{{ $bookings->where('status', 'cancelled')->count() }}</h4>
                <span>Cancelled</span>
            </div>
        </div>
    </div>
    @endif

    <div class="bookings-table">
        <div class="table-header">
            <h3>All Bookings</h3>
            <span class="count-badge">{{ $bookings->count() }} total</span>
        </div>

        <div class="table-wrapper">
            @if($bookings->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Room</th>
                            <th>Guest</th>
                            <th>Phone</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                            <tr>
                                <td style="color: var(--text-muted); width: 50px;">{{ $loop->iteration }}</td>
                                <td>
                                    <span class="room-badge">
                                        <i class="fa-solid fa-bed"></i> {{ $booking->room->room_number }}
                                    </span>
                                </td>
                                <td><strong>{{ $booking->guest_name }}</strong></td>
                                <td>{{ $booking->guest_phone }}</td>
                                <td>{{ \Carbon\Carbon::parse($booking->check_in)->format('M d, Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($booking->check_out)->format('M d, Y') }}</td>
                                <td class="price-cell">${{ number_format($booking->total_price, 2) }}</td>
                                <td>
                                    @php
                                        $statusClass = match($booking->status) {
                                            'confirmed' => 'status-confirmed',
                                            'pending' => 'status-pending',
                                            'cancelled' => 'status-cancelled',
                                            'checked-in' => 'status-checked-in',
                                            'checked-out' => 'status-checked-out',
                                            default => 'status-pending'
                                        };
                                    @endphp
                                    <span class="status-badge {{ $statusClass }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="actions-cell">
                                        <a href="{{ route('bookings.edit', $booking->id) }}" class="btn-edit">
                                            <i class="fa-solid fa-pen"></i> Edit
                                        </a>
                                        <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" class="delete-form" onsubmit="return confirm('Are you sure you want to delete this booking?')">
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
                <div class="bookings-empty">
                    <i class="fa-solid fa-calendar-xmark"></i>
                    <p>No bookings found. Start by creating one!</p>
                    <a href="{{ route('bookings.create') }}" class="btn btn-primary">
                        <i class="fa-solid fa-plus"></i> Create First Booking
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection