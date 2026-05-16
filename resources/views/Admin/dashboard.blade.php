@extends('layouts.Admin.master')

@section('content')
    @php
        $metrics = $dashboard['metrics'];
        $statCards = $dashboard['statCards'];
        $statusChart = $dashboard['statusChart'];
        $statusCounts = $metrics['status_counts'];
        $latestOrders = $metrics['latest_orders'] ?? [];
    @endphp

    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Dashboard Admin</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('dashboard') }}">
                            <i class="icon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                </ul>
            </div>

            <div class="card card-round rentify-hero-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <span class="badge bg-white/20 text-white mb-3 border border-white/30">Admin Control Center</span>
                            <h2 class="fw-bold text-white mb-2">Dashboard Operasional Rentify</h2>
                            <p class="text-white-50 mb-0">
                                Pantau pesanan, pendapatan, denda, dan status rental dari satu panel kontrol premium.
                            </p>
                        </div>
                        <div class="col-md-4 text-md-end mt-4 mt-md-0">
                            <a href="{{ route('orders.index') }}" class="btn btn-white btn-round">
                                <i class="fas fa-clipboard-list me-2"></i>Kelola Pesanan
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                @foreach ($statCards as $card)
                    <div class="col-sm-6 col-xl-3">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-icon">
                                        <div class="icon-big text-center icon-{{ $card['tone'] }} bubble-shadow-small">
                                            <i class="{{ $card['icon'] }}"></i>
                                        </div>
                                    </div>
                                    <div class="col col-stats ms-3 ms-sm-0">
                                        <div class="numbers">
                                            <p class="card-category">{{ $card['label'] }}</p>
                                            <h4 class="card-title">{{ $card['value'] }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card card-round">
                        <div class="card-header">
                            <div class="card-head-row">
                                <div class="card-title">Distribusi Status Pesanan</div>
                                <div class="card-tools">
                                    <a href="{{ route('orders.index') }}" class="btn btn-label-info btn-round btn-sm">
                                        Lihat Pesanan
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-container" style="min-height: 260px">
                                <canvas id="orderStatusChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card card-round">
                        <div class="card-header">
                            <div class="card-title">Ringkasan Status</div>
                        </div>
                        <div class="card-body pb-0">
                            @foreach ($statusCounts as $status => $total)
                                <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                                    <div>
                                        <h6 class="fw-bold mb-1">{{ ucfirst($status) }}</h6>
                                        <p class="text-muted mb-0">Total pesanan</p>
                                    </div>
                                    <span class="badge badge-count badge-{{ $status === 'dibatalkan' ? 'danger' : 'info' }}">
                                        {{ $total }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-round">
                        <div class="card-header">
                            <div class="card-title">Pesanan Terbaru</div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Pelanggan</th>
                                            <th>Mobil</th>
                                            <th>Periode</th>
                                            <th>Status</th>
                                            <th class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($latestOrders as $order)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('orders.show', $order['id']) }}" class="fw-bold">
                                                        {{ $order['id'] }}
                                                    </a>
                                                </td>
                                                <td>{{ $order['name'] }}</td>
                                                <td>{{ $order['car'] }}</td>
                                                <td>{{ $order['period'] }}</td>
                                                <td><span class="badge badge-info">{{ ucfirst($order['status']) }}</span></td>
                                                <td class="text-end">Rp {{ number_format($order['total'], 0, ',', '.') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted py-4">Belum ada pesanan.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extraCSS')
    <style>
        .rentify-hero-card {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            border: 0;
            margin-bottom: 24px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(249, 115, 22, 0.2);
        }

        .rentify-hero-card .card-body {
            padding: 32px;
        }
    </style>
@endsection

@section('extraJS')
    <script>
        const orderStatusChart = document.getElementById('orderStatusChart');

        if (orderStatusChart) {
            new Chart(orderStatusChart, {
                type: 'doughnut',
                data: {
                    labels: @json($statusChart['labels']),
                    datasets: [{
                        data: @json($statusChart['values']),
                        backgroundColor: @json($statusChart['colors']),
                        borderWidth: 0,
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    cutout: '65%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    }
                }
            });
        }
    </script>
@endsection
