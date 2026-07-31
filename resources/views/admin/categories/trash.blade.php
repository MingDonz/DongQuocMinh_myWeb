@extends('admin.layouts.admin')
@section('title', 'Trash-Loại Sản phẩm')
@section('content')
    <h2 class="mb-3">DANH SÁCH LOẠI SẢN PHẨM - ĐANG CHỜ XÓA</h2>
    {{-- gọi component --}}
    <x-admin.alert />
    <a href="{{ route('admin.categories.index') }}" class="btn btn-primary mb-2">
        <i class="bi bi-plus-circle"></i>
        Quay lại danh sách
    </a>
    @if($trashCount > 0)
        <form action="{{ route('admin.categories.restoreAll') }}" method="POST" class="d-inline">
            @csrf
            @method('PATCH')
            <button class="btn btn-success" onclick="return confirm('Khôi phục tất cả?')">Khôi phục tất cả</button>
        </form>
        <form action="{{ route('admin.categories.forceDeleteAll') }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger" onclick="return confirm('Xóa vĩnh viễn tất cả?')">Xóa vĩnh viễn tất cả</button>
        </form>
    @endif
    <table class="table table-bordered table-hover table-striped">
        <thead class="table-dark">
            <tr>
                <th>STT</th>
                <th>Hình ảnh</th>
                <th>Tên loại</th>
                <th>Slug</th>
                <th>Trạng thái</th>
                <th width="200">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($list as $item)
                <tr>
                    <td>{{ $list->firstItem() + $loop->index }}</td>

                    <td>
                        @if ($item->image)
                            <img src="{{ asset('storage/categories/' . $item->image) }}" width="80" class="img-thumbnail">
                        @endif
                    </td>

                    <td>{{ $item->catename }}</td>
                    <td>{{ $item->slug }}</td>

                    <td>
                        @if ($item->status == 1)
                            <span class="badge bg-success">Hiển thị</span>
                        @else
                            <span class="badge bg-danger">Ẩn</span>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('admin.categories.restore', $item->cateid)}}" method="POST" class="d-inline">

                            @csrf
                            @method('PATCH')
                            <button class="btn btn-success btn-sm">Khôi phục</button>
                        </form>
                        <form action="{{ route('admin.categories.forceDelete', $item->cateid) }}" method="POST"
                            class="d-inline">

                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Xóa vĩnh viễn?')" class="btn btn-danger btn-sm">
                                Xóa
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- Hien thi phan trang --}}
    <div class="d-flex justify-content-center">
        {{ $list->links() }}
    </div>
@endsection