<nav class="navbar navbar-light bg-light admin-header">
    <div class="container-fluid">
        <span class="navbar-brand">Admin Panel</span>
        <div class="d-flex align-items-center gap-3">
            <span>Xin chào <strong>{{ Auth::user()->fullname }}</strong></span>
            <form action="{{ route('admin.logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn btn-link p-0 text-decoration-none">
                    Đăng xuất
                </button>
            </form>
        </div>
    </div>
</nav>