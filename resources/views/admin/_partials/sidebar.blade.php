<div class="admin-sidebar bg-dark text-white p-3 vh-100">
    <h4 class="mb-4">
        <i class="bi bi-speedometer2"></i>
        Admin
    </h4>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.home') }}">
                <i class="bi bi-house-door"></i>
                Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="/admin/dashboard">
                <i class="bi bi-house-door"></i>
                Dashboard**
            </a>
        </li>
        {{-- Menu expand --}}
        <li   li class="nav-item">
            <a class="nav-link text-white" data-bs-toggle="collapse" href="#categoryMenu">
                <i class="bi bi-tags"></i>
                Quản lý danh mục
                <i class="bi bi-chevron-down float-end"></i>
            </a>
            <div class="collapse" id="categoryMenu">
                <ul class="nav flex-column ms-3">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.categories.index') }}">
                            Danh sách loại Sản phẩm
                        </a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.categories.create') }}">
                            Thêm loại Sản phẩm
                        </a>
                    </li> -->
                </ul>
            </div>
        </li>
        <li li class="nav-item">
        <a class="nav-link text-white" data-bs-toggle="collapse" href="#productMenu">
                <i class="bi bi-tags"></i>
                Quản lý sản phẩm
                <i class="bi bi-chevron-down float-end"></i>
            </a>

            <div class="collapse" id="productMenu">
                <ul class="nav flex-column ms-3">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.products.index') }}">
                            Danh sách Sản phẩm
                        </a>
                </ul>
            </div>
        </li>
    </ul>
</div>