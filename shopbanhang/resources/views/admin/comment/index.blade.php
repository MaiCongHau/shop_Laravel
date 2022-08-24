@extends('admin.layout.app')

@section('content')
<div id="content-wrapper">
    <div class="container-fluid">
       <!-- Breadcrumbs-->
       <ol class="breadcrumb">
          <li class="breadcrumb-item">
             <a href="#">Quản lý</a>
          </li>
          <li class="breadcrumb-item active">Đánh giá</li>
       </ol>
       <!-- DataTables Example -->
       <div class="action-bar">
          
          <input type="submit" class="btn btn-danger btn-sm" value="Xóa" name="delete">
       </div>
       <div class="card mb-3">
          <div class="card-body">
             <div class="table-responsive">
                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                   <thead>
                      <tr>
                         <th><input type="checkbox" onclick="checkAll(this)"></th>
                         <th>Email</th>
                         <th>Tên </th>
                         <th>Số sao</th>
                         <th>Ngày tạo</th>
                         <th>Nội dung</th>
                         <th>Tên sản phẩm</th>
                         <th></th>
                      </tr>
                   </thead>
                   <tbody>
                    @foreach ($comments as $comment)
                    <tr>
                        <td><input type="checkbox"></td>
                        <td>{{$comment->email}}</td>
                        <td>{{$comment->fullname}} </td>
                        <td>{{$comment->star}}</td>
                        <td>{{$comment->created_date}}</td>
                        <td>{{$comment->description}}</td>
                        <td>{{$comment->viewproduct->name}}</td>
                        <td> <a class="btn btn-danger btn-sm" href="{{route('admin.product.comment.delete',['id'=>$comment->id])}}">Xóa</a></td>
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
