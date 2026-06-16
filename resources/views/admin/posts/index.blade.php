@extends('admin.layouts.admin')

@section('title', 'Danh sách bài viết')

@section('content')
<h2 class="mb-3">DANH SÁCH BÀI VIẾT</h2>

<table class="table table-bordered table-hover table-striped">
    <thead class="table-dark">
        <tr>
            <th>Mã bài viết</th>
            <th>Tiêu đề</th>
            <th>Slug</th>
            <th>Nội dung</th>
            <th>Trạng thái</th>
            <th>Người tạo</th>
        </tr>
    </thead>
    <tbody>
        @foreach($list as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->title }}</td>
                <td>{{ $item->slug }}</td>
                <td>{{ $item->content }}</td>
                <td>
                    @if($item->status == 1)
                        <span class="badge bg-success">Hiển thị</span>
                    @else
                        <span class="badge bg-danger">Ẩn</span>
                    @endif
                </td>
                <td>{{ $item->user?->username }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="d-flex justify-content-center">
        {{ $list->links() }}
    </div>
@endsection