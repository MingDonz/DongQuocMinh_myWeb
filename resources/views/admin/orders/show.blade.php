@extends('admin.layouts.admin')

@section('title', 'Chi tiết đơn hàng')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Chi tiết đơn hàng #{{ $order->id }}</h2>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Quay lại</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <strong>Thông tin khách hàng</strong>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><strong>Họ tên:</strong> {{ $order->customer->fullname ?? 'N/A' }}</p>
                        <p class="mb-2"><strong>Email:</strong> {{ $order->customer->email ?? 'N/A' }}</p>
                        <p class="mb-2"><strong>Điện thoại:</strong> {{ $order->customer->phone ?? 'N/A' }}</p>
                        <p class="mb-2"><strong>Địa chỉ:</strong> {{ $order->customer->address ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                        <strong>Thông tin đơn hàng</strong>
                        <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST"
                            class="d-flex gap-2 align-items-center">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="form-select form-select-sm">
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Chờ xử lý
                                </option>
                                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Đang xử lý
                                </option>
                                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Hoàn thành
                                </option>
                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Đã hủy
                                </option>
                            </select>
                            <button class="btn btn-light btn-sm">Cập nhật</button>
                        </form>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><strong>Mã đơn:</strong> {{ $order->order_code }}</p>
                        <p class="mb-2"><strong>Trạng thái:</strong> {{ $order->status }}</p>
                        <p class="mb-2"><strong>Phương thức thanh toán:</strong> {{ $order->payment_method ?? 'N/A' }}</p>
                        <p class="mb-2"><strong>Trạng thái thanh toán:</strong> {{ $order->payment_status ?? 'N/A' }}</p>
                        <p class="mb-2"><strong>Ghi chú:</strong> {{ $order->note ?? 'Không có' }}</p>
                        <p class="mb-2"><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mt-4">
            <div class="card-header bg-secondary text-white">
                <strong>Sản phẩm trong đơn</strong>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Đơn giá</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->product->productname ?? 'N/A' }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->price, 0, ',', '.') }} đ</td>
                                <td>{{ number_format($item->price * $item->quantity, 0, ',', '.') }} đ</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-end">Tổng tiền</th>
                            <th class="text-danger fw-bold">{{ number_format($order->total_amount, 0, ',', '.') }} đ</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection