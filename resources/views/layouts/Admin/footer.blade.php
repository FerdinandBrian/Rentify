<footer class="footer">
    <div class="container-fluid d-flex justify-content-between">
        <nav class="pull-left">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('orders.index') }}">Pesanan</a>
                </li>
                @if(Auth::user()->role_id === 2 && Route::has('returns.index'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('returns.index') }}">Pengembalian</a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.cars.index') }}">Mobil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('documents.index') }}">Dokumen</a>
                </li>
            </ul>
        </nav>
        <div class="copyright">
            {{ date('Y') }}, dibuat untuk <a href="{{ route('dashboard') }}">Rentify</a>
        </div>
        <div>
            <span class="text-muted">&copy; {{ date('Y') }} Rentify. All rights reserved.</span>
        </div>
    </div>
</footer>
