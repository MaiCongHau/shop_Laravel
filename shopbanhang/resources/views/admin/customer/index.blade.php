@extends('admin.layout.app')

@section('content')
    <div id="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">Quản lý</a>
                </li>
                <li class="breadcrumb-item active">Khách hàng</li>
            </ol>
            <!-- DataTables Example -->
            <div class="action-bar">
                <input type="submit" class="btn btn-primary btn-sm" value="Thêm" name="add">
                <a class="btn btn-danger btn-sm" href="#">Xóa</a>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" onclick="checkAll(this)"></th>
                                    <th>Tên </th>
                                    <th>Email</th>
                                    <th>Số điện thoại</th>
                                    <th>Đăng nhập từ</th>
                                    <th>Địa chỉ</th>
                                    <th>Tên người nhận</th>
                                    <th>Điện thoại người nhận</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customers as $customer)
                                    <tr>
                                        <td><input type="checkbox"></td>
                                        <td>{{ $customer->name }}</td>
                                        <td>{{ $customer->email }}</td>
                                        <td>{{ $customer->mobile }}</td>
                                        <td>{{ $customer->login_by }}</td>
                                        <td>{{ $customer->ward->district->province->name . ' ,' . $customer->ward->district->name . ' ,' . $customer->ward->name }}
                                        </td>
                                        <td>{{ $customer->shipping_name }}</td>
                                        <td>{{ $customer->shipping_mobile }}</td>
                                        <td>{{ $customer->is_active == 0 ? 'Chưa kích hoạt' : 'Đã kích hoạt' }}</td>
                                        <td> <input type="button" onclick="Edit('1');" value="Sửa"
                                                class="btn btn-warning btn-sm"></td>

                                        <td> <a class="btn btn-danger btn-sm"
                                                href="{{ route('admin.product.customer.delete', ['id' => $customer->id]) }}">Xóa</a>
                                        </td>
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection
