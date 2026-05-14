<footer class="footer">
    <div class="container-fluid d-flex justify-content-between">
        <nav class="pull-left">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.cars') }}">Mobil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.orders') }}">Pesanan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.documents') }}">Dokumen</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.profile.edit') }}">Profil</a>
                </li>
            </ul>
        </nav>
        <div class="copyright">
            {{ date('Y') }}, dibuat untuk <a href="{{ route('user.dashboard') }}">Rentify</a>
        </div>
        <div>
            <span class="text-muted">&copy; {{ date('Y') }} Rentify. All rights reserved.</span>
        </div>
    </div>
</footer>
