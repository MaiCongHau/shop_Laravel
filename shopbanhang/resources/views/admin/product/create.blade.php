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
       <!-- /form -->
       <form method="post" action="{{route('admin.product.store')}}" enctype="multipart/form-data">
         @csrf
          <div class="form-group row">
             <label class="col-md-12 control-label" for="name">Tên </label>  
             <div class="col-md-9 col-lg-6">
                <input name="name" id="name" type="text" value="" class="form-control">								
             </div>
          </div>
          <div class="form-group row">
             <label class="col-md-12 control-label" for="wholesale-price">Giá bán lẻ </label>  
             <div class="col-md-9 col-lg-6">
                <input name="wholesale-price" id="wholesale-price" type="text" value="" class="form-control">	
             </div>
          </div>
          
          <div class="form-group row">
             <label class="col-md-12 control-label" for="inventory-number">Lượng tồn</label>  
             <div class="col-md-9 col-lg-6">
                <input name="inventory-number" id="inventory-number" type="text" value="" class="form-control">			
             </div>
          </div>
          
          <div class="form-group row">
             <label class="col-md-12 control-label" for="category">Danh mục </label>  
             <div class="col-md-9 col-lg-6">
                <select name="category" id="category" class="form-control">
                   <option value="1">Kem Chống Nắng</option>
                   <option value="2">Kem Dưỡng Da</option>
                   <option value="3">Kem Trị Mụn</option>
                   <option value="4">Kem Trị Thâm Nám</option>
                   <option value="5">Sữa Rửa Mặt</option>
                   <option value="6">Sữa Tắm</option>
                </select>
             </div>
          </div>
          <div class="form-group row">
             <label class="col-md-12 control-label">Nổi bật</label>  
             <div class="col-md-9 col-lg-6">
                <input type="checkbox" value="1">
             </div>
          </div>
          <div class="form-group row">
             <label class="col-md-12 control-label" for="image">Hình ảnh </label>
             <div class="col-md-9 col-lg-6">
                <input type="file" name="image" id="image">              
             </div>
          </div>
          <div class="form-group row">
             <label class="col-md-12 control-label" for="description">Mô tả</label>  
             <div class="col-md-12">
                <textarea name="description" id="description" rows="10" cols="80"></textarea>
             </div>
          </div>
          <div class="form-action">
             <input type="submit" class="btn btn-primary btn-sm" value="Lưu" name="save">
          </div>
       </form>
       <script type="text/javascript" src="{{ asset('admin') }}/vendor/ckeditor/ckeditor.js"></script>
       <script>CKEDITOR.replace('description');</script>
       <!-- /form -->
       <!-- /.container-fluid -->
       <!-- Sticky Footer -->
    </div>
    <!-- /.content-wrapper -->
 </div>
 <!-- /#wrapper -->
 <!-- Scroll to Top Button-->
 <a class="scroll-to-top rounded" href="#page-top">
 <i class="fas fa-angle-up"></i>
 </a>
 <!-- Logout Modal-->
 <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
          <div class="modal-header">
             <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
             <button class="close" type="button" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">×</span>
             </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
             <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
             <a class="btn btn-primary" href="login.html">Logout</a>
          </div>
       </div>
    </div>
 </div>
  
@endsection
