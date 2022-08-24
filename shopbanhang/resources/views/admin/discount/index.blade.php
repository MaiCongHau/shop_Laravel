@extends('admin.layout.app')

@section('content')
<div id="content-wrapper">
    <div class="container-fluid">
       <!-- Breadcrumbs-->
       <ol class="breadcrumb">
          <li class="breadcrumb-item">
             <a href="#">Quản lý</a>
          </li>
          <li class="breadcrumb-item active">Khuyến mại</li>
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
                         <th >Code</th>
                         <th >Từ ngày</th>
                         <th >Đến ngày</th>
                         <th >Nội dung</th>
                         <th >Giảm</th>
                         <th >
                         </th>
                         <th >
                         </th>
                         <th >
                         </th>
                      </tr>
                   </thead>
                   <tbody>
                    @foreach ( $discounts as  $discount)
                    <tr>
                        <td><input type="checkbox"></td>
                        <td >{{ $discount->code}}</td>
                        <td >{{ $discount->starts_at}}</td>
                        <td >{{ $discount->expires_at}}</td>
                        <td>{{ $discount->description}}</td>
                        <td>{{ $discount->is_fixed == 0 ? "-".$discount->discount_amount."%" : "-".number_format($discount->discount_amount)}}</td>
                        <td >{{$discount->starts_at<date("Y-m-d H:i:s")&&date("Y-m-d H:i:s")<$discount->expires_at?"Có hiệu lực":"Không có hiệu lực"}}</td>
                        <td > <input type="button" onclick="Edit('1');" value="Sửa" class="btn btn-warning btn-sm"></td>
                        <td ><input type="button" onclick="Delete('1');" value="Xóa" class="btn btn-danger btn-sm"></td>
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
