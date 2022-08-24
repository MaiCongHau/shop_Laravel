@extends('layout.app')

@section('content')
<main id="maincontent" class="page-main">
    <div class="container">

        <div class="row equal">
            <div class="col-xs-12">
                <h4 class="home-title">Sản phẩm nổi bật</h4>
            </div>
            @foreach ($featuredProducts as $product)
            <div class="col-xs-6 col-sm-3">
               @include('layout.product')
            </div>
            @endforeach

        </div>

        <div class="row equal">
            <div class="col-xs-12">
                <h4 class="home-title">Sản phẩm mới nhất</h4>
            </div>
          
            @foreach ($lastestProducts as $product) 
            <div class="col-xs-6 col-sm-3">
                @include('layout.product')
            </div>
            @endforeach    
        </div>

        @foreach ($categoryProducts as $categoryName => $categoryProduct)
         
        <div class="row equal">
            <div class="col-xs-12">
                <h4 class="home-title">{{ $categoryName }}</h4>
            </div>
            @foreach ($categoryProduct as $product) 
            <div class="col-xs-6 col-sm-3">
                @include('layout.product')
            </div>
            @endforeach  
        </div>

        @endforeach



    </div>
</main>
@endsection