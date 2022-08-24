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
                <div class="col-md-9 order-info">
                    <div class="row">
                        <div class="col-xs-6">
                            <h4 class="home-title">Đơn hàng #{{ $orders->id }}</h4>
                        </div>
                        <div class="clearfix"></div>

                        <aside class="col-md-7 cart-checkout">
                            @foreach ($orders->order_item as $orderItem)
                                <div class="row">
                                    <div class="col-xs-2">
                                        <img class="img-responsive"
                                            src="../images/{{ $orderItem->viewproduct->featured_image }}"
                                            alt="Sữa tắm Sandras Mỹ chai 250ml">
                                    </div>
                                    <div class="col-xs-7">
                                        @php
                                            $prefixSlug = \Str::slug($orderItem->viewproduct->name);
                                            $slug = "{$prefixSlug}-{$orderItem->viewproduct->id}";
                                        @endphp
                                        <a class="product-name" href="{{ route('product.show', ['slug' => $slug]) }}"
                                            title="{{ $orderItem->viewproduct->name }}">{{ $orderItem->viewproduct->name }}</a>
                                        <br>
                                        <span>{{ $orderItem->qty }}</span> x
                                        <span>{{ number_format($orderItem->unit_price) }}₫</span>
                                    </div>
                                    <div class="col-xs-3 text-right">
                                        <span>{{ number_format($orderItem->total_price) }}₫</span>
                                    </div>
                                </div>
                                <hr>
                            @endforeach

                            <div class="row">
                                <div class="col-xs-6">
                                    Tạm tính
                                </div>
                                <div class="col-xs-6 text-right">
                                    {{number_format($orders->price_total)}}₫
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-xs-6">
                                    Giảm giá
                                </div>
                                <div class="col-xs-6 text-right">
                                    - {{number_format($orders->discount_amount)}}₫
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-xs-6">
                                    Tổng tiền
                                </div>
                                <div class="col-xs-6 text-right">
                                    {{number_format($orders->sub_total)}}₫
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-xs-6">
                                    VAT:
                                </div>
                                <div class="col-xs-6 text-right">
                                    {{number_format($orders->tax)}}₫
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-xs-6">
                                    Tổng tiền bao gồm thuế
                                </div>
                                <div class="col-xs-6 text-right">
                                    {{number_format($orders->price_inc_tax_total)}}₫
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-6">
                                    Voucher:
                                </div>
                                <div class="col-xs-6 text-right">
                                    - {{number_format($orders->voucher_amount)}}₫
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-6">
                                    Phí vận chuyển
                                </div>
                                <div class="col-xs-6 text-right">
                                    {{number_format($orders->shipping_fee)}}₫
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-xs-6">
                                    Tổng cộng
                                </div>
                                <div class="col-xs-6 text-right">
                                    {{number_format($orders->payment_total)}}₫
                                </div>
                            </div>
                        </aside>
                        <div class="ship-checkout col-md-5">
                            <h4>Thông tin giao hàng</h4>
                            <div>
                                Họ và tên: {{$orders->shipping_fullname}}
                            </div>
                            <div>
                                Số điện thoại: {{$orders->shipping_mobile}}
                            </div>
                            <div>
                                {{$orders->ward->district->province->name}}
                            </div>
                            <div>
                                {{$orders->ward->district->name}}
                            </div>
                            <div>
                                {{$orders->ward->name}}
                            </div>
                            <div>
                                {{$orders->shipping_housenumber_street}}
                            </div>
                            <div>
                                Phương thức thanh toán: {{$orders->payment_method == 0 ? "COD" :"Thanh toán qua ngân hàng"}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
