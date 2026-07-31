@extends('admin.layouts.admin')

@section('title', 'Thùng rác sản phẩm')

@section('content')
    <h2 class="mb-3">DANH SÁCH SẢN PHẨM - ĐANG CHỜ XÓA</h2>
    <x-admin.alert />

    <div class="d-flex gap-2 mb-3">
        <a href="{{ route('admin.products.index') }}" class="btn btn-primary">
            <i class="bi bi-arrow-left"></i> Quay lại danh sách
        </a>
        @if($trashCount > 0)
            <form action="{{ route('admin.products.restoreAll') }}" method="POST" class="d-inline">
                @csrf
                @method('PATCH')
                <button class="btn btn-success" onclick="return confirm('Khôi phục tất cả?')">Khôi phục tất cả</button>
            </form>
            <form action="{{ route('admin.products.forceDeleteAll') }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" onclick="return confirm('Xóa vĩnh viễn tất cả?')">Xóa vĩnh viễn tất cả</button>
            </form>
        @endif
    </div>

    <table class="table table-bordered table-hover table-striped">
        <thead class="table-dark">
            <tr>
                <th>STT</th>
                <th>Hình ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Trạng thái</th>
                <th width="220">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($list as $item)
                <tr>
                    <td>{{ $list->firstItem() + $loop->index }}</td>
                    <td>
                        @if ($item->image)
                            <img src="{{ asset('storage/products/' . $item->image) }}" width="80" class="img-thumbnail">
                        @endif
                    </td>
                    <td>{{ $item->productname }}</td>
                    <td>{{ number_format($item->price, 0) }} đ</td>
                    <td>
                        @if($item->status)
                            <span class="badge bg-success">Hiển thị</span>
                        @else
                            <span class="badge bg-danger">Ẩn</span>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('admin.products.restore', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-success btn-sm">Khôi phục</button>
                        </form>
                        <form action="{{ route('admin.products.forceDelete', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Xóa vĩnh viễn?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $list->links() }}
    </div>
@endsection