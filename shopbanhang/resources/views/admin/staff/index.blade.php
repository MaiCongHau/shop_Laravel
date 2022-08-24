@extends('admin.layout.app')

@section('content')
<div id="content-wrapper">
    <div class="container-fluid">
       <!-- Breadcrumbs-->
       <ol class="breadcrumb">
          <li class="breadcrumb-item">
             <a href="#">Quản lý</a>
          </li>
          <li class="breadcrumb-item active">Nhân viên</li>
       </ol>
       <!-- DataTables Example -->
       <div class="action-bar">
          <input type="submit" class="btn btn-primary btn-sm" value="Thêm" name="add">
          <input type="submit" class="btn btn-danger btn-sm" value="Xóa" name="delete">
       </div>
       <div class="card mb-3">
          <div class="card-body">
             <div class="table-responsive">
                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                       <tr>
                   <th><input type="checkbox" onclick="checkAll(this)"></th>
                          <th >Tên </th>
                          <th >Tên đăng nhập</th>
                          <th >Email</th>
                          <th >Số điện thoại</th>
                          <th> Vai trò </th>
                          <th></th>
                          <th></th>
                       </tr>
                    </thead>
                    <tbody>
                        @foreach ($staffs as $staff)
                        <tr>
                            <td><input type="checkbox"></td>
                                    <td >{{$staff->name}}</td>
                                    <td >{{$staff->username}}</td>
                                    <td >{{$staff->email}}</td>
                                    <td >{{$staff->mobile}}</td>
                                    <td> @foreach ($staff->roles as $role)
                                        {{$role->name}}
                                    @endforeach
                                    </td>
                                    <td > <input type="button" onclick="Edit('1');" value="Sửa" class="btn btn-warning btn-sm"></td>
                                    @can('staff', App\Models\Staff::class)
                                     <td ><a class="btn btn-danger btn-sm" href="{{route('admin.product.staff.delete',['id'=>$staff->id])}}">Xóa</a></td>
                                    @endcan
                                   
                                 </tr>
                        @endforeach
                       
                      
                    </tbody>
                </table>
             </div>
          </div>
       </div>
    </div>
 </div>
@endsection
