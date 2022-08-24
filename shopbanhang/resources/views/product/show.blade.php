@extends('layout.app')

@section('content')
    <main id="maincontent" class="page-main">
        <div class="container">
            <div class="row">
                <div class="col-xs-9">
                    <ol class="breadcrumb">
                        <li><a href="/" target="_self">Trang chủ</a></li>
                        <li><span>/</span></li>
                        <li class="active"><span>{{ $products->category->name }}</span></li>
                    </ol>
                </div>
                <div class="col-xs-3 hidden-lg hidden-md">
                    <a class="hidden-lg pull-right btn-aside-mobile" href="javascript:void(0)">Bộ lọc <i
                            class="fa fa-angle-double-right"></i></a>
                </div>
                <div class="clearfix"></div>
                @include('layout.sidebar')
                <div class="col-md-9 product-detail">
                    <div class="row product-info">
                        <div class="col-md-6">
                            <img data-zoom-image="{{ asset('') }}images/kemLamSangVungDaBikini.jpg"
                                class="img-responsive thumbnail main-image-thumbnail"
                                src="{{ asset('') }}images/{{ $products->featured_image }}" alt="">
                            <div class="product-detail-carousel-slider">

                                <div class="owl-carousel owl-theme">
                                    <div class="item thumbnail"><img
                                            src="{{ asset('') }}images/{{ $products->featured_image }}" alt="">
                                    </div>
                                    @foreach ($products->imageItem as $imageItem)
                                        <div class="item thumbnail"><img
                                                src="{{ asset('') }}images/{{ $imageItem->name }}" alt=""></div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5 class="product-name">{{ $products->name }}</h5>
                            <div class="brand">
                                <span>Nhãn hàng: </span> <span>{{ $products->brand->name }}</span>
                            </div>
                            <div class="product-status">
                                <span>Trạng thái: </span>

                                @if ($products->inventory_qty == 0)
                                    <span class="label-warning">Hết hàng</span>
                                @else
                                    <span class="label-success">Còn hàng</span>
                                @endif

                            </div>
                            <div class="product-item-price">
                                <span>Giá: </span>
                                @if ($products->sale_price != $products->price)
                                    <span class="product-item-regular">{{ number_format($products->price) }}₫</span>
                                    <span class="product-item-discount">{{ number_format($products->sale_price) }}₫</span>
                                @else
                                    <span class="product-item-discount">{{ number_format($products->sale_price) }}₫</span>
                                @endif

                            </div>
                            @if ($products->inventory_qty > 0)
                                <div class="input-group">
                                    <input type="number" class="product-quantity form-control" value="1"
                                        min="1" onchange="">
                                    <a href="javascript:void(0)" product-id="{{ $products->id }}"
                                        class="buy-in-detail btn btn-success cart-add-button ">
                                        <i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng
                                    </a>
                                </div>
                            @endif



                        </div>
                    </div>
                    <div class="row product-description">
                        <div class="col-xs-12">
                            <div role="tabpanel">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active">
                                        <a href="#product-description" aria-controls="home" role="tab"
                                            data-toggle="tab">Mô tả</a>
                                    </li>
                                    <li role="presentation">
                                        <a href="#product-comment" aria-controls="tab" role="tab" data-toggle="tab">Đánh
                                            giá</a>
                                    </li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="product-description">
                                        {!! $products->description !!}
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="product-comment">

                                        <form class="form-comment" action="{{ route('comment.store') }}" method="POST"
                                            role="form">
                                            @csrf
                                            <label>Đánh giá của bạn</label>
                                            <div class="form-group">
                                                <input type="hidden" name="product_id" value="{{ $products->id }}">
                                                <input class="rating-input" name="rating" type="text" title=""
                                                    value="4" />
                                                <input type="text" class="form-control" id="" name="fullname"
                                                    placeholder="Tên *" required>
                                                <input type="email" name="email" class="form-control" id=""
                                                    placeholder="Email *" required>
                                                <textarea name="description" id="input" class="form-control" rows="3" required placeholder="Nội dung *"></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Gửi</button>
                                        </form>

                                        @php
                                            $comments = $products->comments;
                                            $comments = $comments->sortByDesc('created_date'); // sắp xếp theo thứ tự giảm dần
                                        @endphp

                                        <div class="comment-list">
                                            @foreach ($comments as $comment)
                                                <hr>
                                                <span class="date pull-right">{{ $comment->created_date }}</span>
                                                <input class="answered-rating-input" name="rating" type="text"
                                                    title="" value="{{ $comment->star }}" readonly />
                                                <span class="by">{{ $comment->fullname }}</span>
                                                <p>{{ $comment->description }}</p>
                                            @endforeach
                                        </div>



                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row product-related equal">
                        <div class="col-md-12">
                            <h4 class="text-center">Sản phẩm liên quan</h4>
                            @php
                                $Relatedproducts = $products->category->products;
                                $temp = $products->id;
                            @endphp

                            <div class="owl-carousel owl-theme">
                                @foreach ($Relatedproducts as $product)
                                    {{-- Trùng với id của sp thì loại thằng đó luôn --}}
                                    @if ($temp != $product->id)
                                        <div class="item thumbnail">
                                            @include('layout.product')
                                        </div>
                                    @endif
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
