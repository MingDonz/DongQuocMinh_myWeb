@extends('admin.layouts.admin')

@section('title', 'Thêm người dùng')

@section('content')
    <div class="border rounded bg-white p-4 shadow-sm">
        <h3 class="mb-4">Thêm người dùng</h3>

        {{-- gọi component --}}
        <x-admin.alert />

        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Họ tên</label>
                <input type="text" name="fullname" class="form-control" value="{{ old('fullname') }}">
            </div>
            {{-- hiển thị lỗi cho trường fullname --}}
            @error('fullname')
                <span class="text-danger">{{ $message }}</span>
            @enderror

            <div class="mb-3">
                <label>Tên đăng nhập</label>
                <input type="text" name="username" class="form-control" value="{{ old('username') }}">
            </div>
            {{-- hiển thị lỗi cho trường username --}}
            @error('username')
                <span class="text-danger">{{ $message }}</span>
            @enderror

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
            </div>
            {{-- hiển thị lỗi cho trường email --}}
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror

            <div class="mb-3">
                <label>Mật khẩu</label>
                <input type="password" name="password" class="form-control">
            </div>
            {{-- hiển thị lỗi cho trường password --}}
            @error('password')
                <span class="text-danger">{{ $message }}</span>
            @enderror

            <div class="mb-3">
                <label>Điện thoại</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
            </div>
            {{-- hiển thị lỗi cho trường phone --}}
            @error('phone')
                <span class="text-danger">{{ $message }}</span>
            @enderror

            <div class="mb-3">
                <label>Địa chỉ</label>
                <input type="text" name="address" class="form-control" value="{{ old('address') }}">
            </div>
            {{-- hiển thị lỗi cho trường address --}}
            @error('address')
                <span class="text-danger">{{ $message }}</span>
            @enderror

            <div class="mb-3">
                <label>Giới tính</label>
                <select name="gender" class="form-control">
                    <option value="">-- Chọn giới tính --</option>
                    <option value="1" {{ old('gender') == 1 ? 'selected' : '' }}>Nam</option>
                    <option value="2" {{ old('gender') == 2 ? 'selected' : '' }}>Nữ</option>
                    <option value="0" {{ old('gender') == 0 ? 'selected' : '' }}>Không cung cấp</option>
                </select>
                {{-- hiển thị lỗi cho trường gender --}}
                @error('gender')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label>Ngày sinh</label>
                <input type="date" name="birthday" class="form-control" value="{{ old('birthday') }}">
            </div>
            {{-- hiển thị lỗi cho trường birthday --}}
            @error('birthday')
                <span class="text-danger">{{ $message }}</span>
            @enderror

            <div class="mb-3">
                <label>Vai trò</label>
                <select name="role" class="form-control">
                    <option value="1" {{ old('role', 1) == 1 ? 'selected' : '' }}>Quản lý</option>
                    <option value="2" {{ old('role', 2) == 2 ? 'selected' : '' }}>Nhân viên</option>
                </select>
                {{-- hiển thị lỗi cho trường role --}}
                @error('role')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label d-block">Trạng thái</label>
                <input type="radio" class="btn-check" name="status" id="active" value="1" {{ old('status', 1) == 1 ? 'checked' : '' }}>
                <label class="btn btn-outline-success" for="active">
                    Kích hoạt
                </label>

                <input type="radio" class="btn-check" name="status" id="inactive" value="0" {{ old('status', 1) == 0 ? 'checked' : '' }}>
                <label class="btn btn-outline-danger" for="inactive">
                    Khóa
                </label>
                {{-- hiển thị lỗi cho trường status --}}
                @error('status')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Lưu</button>
        </form>
    </div>
@endsection