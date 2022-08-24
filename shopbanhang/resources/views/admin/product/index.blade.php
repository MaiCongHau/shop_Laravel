@extends('admin.layout.app')

@section('content')
<div id="content-wrapper">
    <div class="container-fluid">
       <!-- Breadcrumbs-->
       <ol class="breadcrumb">
          <li class="breadcrumb-item">
             <a href="#">Quản lý</a>
          </li>
          <li class="breadcrumb-item active">Sản phẩm</li>
       </ol>
       <!-- DataTables Example -->
       <div class="action-bar">
          <a value="Xóa" class="btn btn-primary btn-sm" href="{{route('admin.product.create')}}">Thêm</a>
       </div>
       <div class="card mb-3">
          <div class="card-body">
             <div class="table-responsive">
                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                   <thead>
                      <tr>
                         <th><input type="checkbox" onclick="checkAll(this)"></th>
                         <th>Mã</th>
                         <th style="width:50px">Tên </th>
                                 <th>Hình ảnh</th>
                         <th>Giá bán thực tế</th>
                         <th>Lượng tồn</th>
                         <th>Đánh giá</th>
                         <th>Nội bật</th>
                         <th>Danh mục</th>
                         <th>Ngày tạo</th>
                         <th>Mô tả</th>
                         <th></th>
                         <th></th>
                         <th></th>
                         <th></th>
                      </tr>
                   </thead>
                   <tbody>
                    @foreach ($products as $product)
                    <tr>
                        <td><input type="checkbox"></td>
                        <td>#{{$product->id}}</td>
                        <td>{{$product->name}}</td>
                         <td><img src="../../images/{{$product->featured_image}}"></td>
                        <td>{{ number_format( $product->price)}} ₫</td>
                        <td>{{$product->inventory_qty}}</td>
                        <td>{{$product->star}}</td>
                        <td>{{$product->featured}}</td>
                        <td>{{$product->category->name}}</td>
                        <td>{{$product->created_date}}</td>
                        <td>{{$product->description}}</td>
                        <td><a href="{{route('admin.product.comment',['id'=>$product->id])}}">Đánh giá</a></td>
                        <td><a href="../../pages/image/list.html">Hình ảnh</a></td>
                        <td><input type="button" onclick="Edit('25');" value="Sửa" class="btn btn-warning btn-sm"></td>
                        <td><a value="Xóa" class="btn btn-danger btn-sm" href="{{route('admin.product.delete',['id'=>$product->id])}}">Xóa</a></td>
                     </tr>
                    @endforeach
                   </tbody>
                </table>
             </div>
          </div>
       </div>
    </div>
 </div>
 <!-- /.content-wrapper -->
</div>
@endsection
