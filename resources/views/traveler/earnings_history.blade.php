@extends('layouts.app')

@section('title', 'Riwayat Penarikan Dana')

@section('content')
<div class="container-fluid p-4">
    <div class="row mb-4">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('traveler.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('traveler.earnings.index') }}">Penghasilan</a></li>
                    <li class="breadcrumb-item active">Riwayat Penarikan</li>
                </ol>
            </nav>
            <h2 class="fw-bold text-dark mb-1">Riwayat Penarikan Dana</h2>
            <p class="text-muted">Daftar semua transaksi penarikan dana yang pernah Anda ajukan.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            @if ($withdrawals->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Tanggal Diajukan</th>
                            <th>Jumlah Penarikan</th>
                            <th>Bank Tujuan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($withdrawals as $withdrawal)
                        <tr>
                            <td class="ps-4">
                                <div>
                                    <div class="fw-semibold text-dark">{{ $withdrawal->created_at->format('d M Y') }}</div>
                                    <small class="text-muted">{{ $withdrawal->created_at->format('H:i') }} WIB</small>
                                </div>
                            </td>
                            <td>
                                <span class="fw-bold text-danger">Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}</span>
                            </td>
                            <td>
                                <div>
                                    <div class="fw-semibold text-dark">{{ $withdrawal->bank_name }}</div>
                                    <small class="text-muted">{{ $withdrawal->bank_account_number }} (a.n {{ $withdrawal->bank_account_name }})</small>
                                </div>
                            </td>
                            <td>
                                @php
                                    $statusClasses = [
                                        'Pending' => 'bg-warning text-dark',
                                        'Processing' => 'bg-info text-white',
                                        'Completed' => 'bg-success text-white',
                                        'Rejected' => 'bg-danger text-white',
                                    ];
                                @endphp
                                <span class="badge {{ $statusClasses[$withdrawal->status] ?? 'bg-secondary' }}">{{ $withdrawal->status }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($withdrawals->hasPages())
            <div class="card-footer bg-white d-flex justify-content-center">
                {{ $withdrawals->links() }}
            </div>
            @endif
            @else
            <div class="text-center py-5">
                <i class="fas fa-history fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada riwayat penarikan dana.</h5>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
