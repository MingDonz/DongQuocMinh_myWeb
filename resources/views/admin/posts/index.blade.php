@extends('admin.layouts.admin')

@section('title', 'Bài viết')

@section('content')
    <h2 class="mb-3">DANH SÁCH BÀI VIẾT</h2>
    <div class="d-flex gap-2 mb-2">
        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i>
            Thêm mới
        </a>
        <a href="{{ route('admin.posts.trash') }}" class="btn btn-danger">
            <i class="bi bi-trash"></i>
            Thùng rác
            @if(!empty($trashCount))
                <span class="badge bg-light text-danger ms-1">{{ $trashCount }}</span>
            @endif
        </a>
    </div>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>STT</th>
                <th>Hình ảnh</th>
                <th>Tiêu đề</th>
                <th>Người viết</th>
                <th>Trạng thái</th>
                <th width="120">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($list as $item)
                <tr>
                    <td>{{ $list->firstItem() + $loop->index }}</td>

                    <td>
                        <img src="{{ asset($item->image ? 'images/posts/' . $item->image : 'images/default.png') }}"
                            alt="{{ $item->title }}" style="width: 50px; height: 50px; object-fit: cover;">
                    </td>

                    <td>{{ $item->title }}</td>
                    <td>{{ $item->user->fullname }}</td>
                    <td>
                        @if($item->status == 1)
                            <span class="badge bg-success">Hiển thị</span>
                        @else
                            <span class="badge bg-danger">Ẩn</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.posts.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('admin.posts.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Bạn có chắc muốn xóa?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
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