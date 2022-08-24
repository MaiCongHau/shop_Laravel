@extends('layout.app')

@section('content')
    <main id="maincontent" class="page-main">
        <div class="container">
            <div class="row">
                <div class="col-xs-9">
                    <ol class="breadcrumb">
                        <li><a href="/" target="_self">Trang chủ</a></li>
                        <li><span>/</span></li>
                        <li class="active"><span>Tài khoản</span></li>
                    </ol>
                </div>
                <div class="clearfix"></div>
                @include('customer.sidebar')
                <div class="col-md-9 order">
                    <div class="row">
                        <div class="col-xs-6">
                            <h4 class="home-title">Đơn hàng của tôi</h4>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-12">
                            <!-- Mỗi đơn hàng -->
                            @php
                                $cnt = 1;
                            @endphp
                            @foreach ($orders as $order)
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5>Đơn hàng <a
                                                href="{{ route('order.show', ['orderId' => $order->id]) }}">#{{ $cnt++ }}</a>
                                        </h5>
                                        <span class="date">
                                            Đặt hàng {{ $order->created_date }}</span>
                                        <hr>
                                        @foreach ($order->order_item as $product)
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <img src="../images/{{ $product->viewproduct->featured_image }}"
                                                        alt="" class="img-responsive">
                                                </div>
                                                @php
                                                    $prefixSlug = \Str::slug($product->viewproduct->name);
                                                    $slug = "{$prefixSlug}-{$product->viewproduct->id}";
                                                @endphp
                                                <div class="col-md-3">
                                                    <a class="product-name"
                                                        href="{{ route('product.show', ['slug' =>$slug]) }}">{{ $product->viewproduct->name }}</a>
                                                </div>
                                                <div class="col-md-2">
                                                    Số lượng: {{ $product->qty }}
                                                </div>
                                                <div class="col-md-2">
                                                    {{ $order->status->description }}
                                                </div>
                                                <div class="col-md-3">
                                                    Giao hàng {{ $order->delivered_date }}
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
