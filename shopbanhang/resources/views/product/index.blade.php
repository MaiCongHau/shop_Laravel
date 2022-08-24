@extends('layout.app')

@section('content')
<main id="maincontent" class="page-main">
    <div class="container">
        <div class="row">
            <div class="col-xs-9">
                <ol class="breadcrumb">
                    <li><a href="/" target="_self">Trang chủ</a></li>
                    <li><span>/</span></li>

                    <li class="active"><span>{{$categories->find($categoryId)->name??"Tất cả sản phẩm"}}</span></li>
                </ol>
            </div>
            <div class="col-xs-3 hidden-lg hidden-md">
                <a class="hidden-lg pull-right btn-aside-mobile" href="javascript:void(0)">Bộ lọc <i class="fa fa-angle-double-right"></i></a>
            </div>
            <div class="clearfix"></div>
            @include('layout.sidebar')
            <div class="col-md-9 products">
                <div class="row equal">
                    <div class="col-xs-6">
                        <h4 class="home-title">{{$categories->find($categoryId)->name??"Tất cả sản phẩm"}}</h4>
                    </div>
                    <div class="col-xs-6 sort-by">
                        <div class="pull-right">
                            <label class="left hidden-xs" for="sort-select">Sắp xếp: </label>
                            @php
                                request()->has("sort")?$sort = request()->input("sort") :$sort="";
                            @endphp
                            
                            <select id="sort-select">
                                <option value="" {{$sort==""?"selected":""}} data_url={{trim(request()->fullUrlWithQuery(['sort' => null]),"?")}}>Mặc định</option>
                                <option  value="price-asc" {{$sort=="price-asc"?"selected":""}} data_url={{request()->fullUrlWithQuery(['sort' => 'price-asc'])}}>Giá tăng dần</option>
                                <option  value="price-desc" {{$sort=="price-desc"?"selected":""}} data_url={{request()->fullUrlWithQuery(['sort' => 'price-desc'])}} >Giá giảm dần</option>
                                <option  value="alpha-asc" {{$sort=="alpha-asc"?"selected":""}} data_url={{request()->fullUrlWithQuery(['sort' => 'alpha-asc'])}} >Từ A-Z</option>
                                <option  value="alpha-desc"  {{$sort=="alpha-desc"?"selected":""}} data_url={{request()->fullUrlWithQuery(['sort' => 'price-desc'])}} >Từ Z-A</option>
                                <option  value="created-asc" {{$sort=="created-asc"?"selected":""}} data_url={{request()->fullUrlWithQuery(['sort' => 'created-asc'])}} >Cũ đến mới</option>
                                <option  value="created-desc" {{$sort=="created-desc"?"selected":""}} data_url={{request()->fullUrlWithQuery(['sort' => 'created-asc'])}} >Mới đến cũ</option>
                            </select>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    @foreach ($products as $product)
                    <div class="col-xs-6 col-sm-4">
                        @include('layout.product')
                    </div>
                    @endforeach
                </div>
                <!-- Paging -->
                <ul class="pagination pull-right">
                    <div class="d-flex justify-content-end">
                        {{$products->links()}}
                    </div>
                </ul>
                <!-- End paging -->
                

            </div>
        </div>
    </div>
</main>
@endsection