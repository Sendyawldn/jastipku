@extends('layouts.app') {{-- Sesuaikan dengan layout utama Anda --}}

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">
                <i class="fas fa-money-bill-transfer me-2"></i>
                Riwayat Penarikan Saldo
            </h2>
            <div>
                <a href="{{ route('traveler.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Kembali ke Dashboard
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header bg-secondary text-white py-3">
                <h5 class="mb-0">Riwayat Penarikan Saldo</h5>
            </div>
            <div class="card-body">
                @if ($withdrawals->isEmpty())
                    <div class="alert alert-info mb-0">Belum ada riwayat penarikan saldo.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Jumlah</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Status</th>
                                    <th>Rekening Tujuan</th>
                                    <th>Tanggal Disetujui/Ditolak</th>
                                    <th>Catatan Admin</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($withdrawals as $withdrawal)
                                    <tr>
                                        <td>Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}</td>
                                        <td>{{ $withdrawal->requested_at->format('d M Y H:i') }}</td>
                                        <td>
                                            @if ($withdrawal->status === 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif ($withdrawal->status === 'approved')
                                                <span class="badge bg-info">Disetujui</span>
                                            @elseif ($withdrawal->status === 'rejected')
                                                <span class="badge bg-danger">Ditolak</span>
                                            @elseif ($withdrawal->status === 'completed')
                                                <span class="badge bg-success">Selesai</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $withdrawal->bank_name }} - {{ $withdrawal->bank_account_number }}
                                            <br>
                                            A.N. {{ $withdrawal->bank_account_name }}
                                        </td>
                                        <td>
                                            @if ($withdrawal->approved_at)
                                                <span
                                                    class="text-success">{{ $withdrawal->approved_at->format('d M Y H:i') }}</span>
                                            @elseif ($withdrawal->rejected_at)
                                                <span
                                                    class="text-danger">{{ $withdrawal->rejected_at->format('d M Y H:i') }}</span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            {{ Str::limit($withdrawal->admin_notes, 50) ?? '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
