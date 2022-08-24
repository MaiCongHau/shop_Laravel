<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Tổng quan</title>
    <!-- Create favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('') }}/admin/images/logo.jpg" />
    <!-- Custom fonts for this template-->
    <link href="{{ asset('') }}/admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Page level plugin CSS-->
    <link href="{{ asset('') }}/admin/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="{{ asset('') }}/admin/css/sb-admin.css" rel="stylesheet">
    <link href="{{ asset('') }}/admin/css/admin.css" rel="stylesheet">
</head>

<body id="page-top">
    <nav class="navbar navbar-expand navbar-dark bg-dark static-top">
        <a class="navbar-brand mr-1" href="index.html">Mỹ Phẩm YouT</a>
        <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
            <i class="fas fa-bars"></i>
        </button>
        <!-- Navbar Search -->
        <!-- Navbar -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item no-arrow text-white">
                <span>Chào {{Auth::user()->name}}</span> |
                <a class="text-white nounderline" href="#" data-toggle="modal"
                    data-target="#logoutModal">Thoát</a>
            </li>
        </ul>
    </nav>
    @php
        $currentRoute = Route::currentRouteName();
    @endphp
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="sidebar navbar-nav">
            <li class="nav-item {{$currentRoute == 'dashboard' ? "active":""}}">
                <a class="nav-link" href="{{route('dashboard')}}"><i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Tổng quan</span></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id=""><i
                        class="fas fa-shopping-cart"></i> <span>Đơn hàng</span></a>
                <div class="dropdown-menu" aria-labelledby="">
                    <a class="dropdown-item" href="../../pages/order/list.html">Danh sách</a>
                    <a class="dropdown-item" href="../../pages/order/add.html">Thêm</a>
                </div>
            </li>
            <li class="nav-item dropdown {{in_array($currentRoute,['admin.product.create','admin.product.show'])?"show":""}}">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="{{in_array($currentRoute,['admin.product.create','admin.product.show'])?"true":""}}"><i
                        class="fab fa-product-hunt"></i> <span>Sản phẩm</span></a>
                <div class="dropdown-menu {{in_array($currentRoute,['admin.product.create','admin.product.show'])?"show":""}}" aria-labelledby="">
                    <a class="dropdown-item {{$currentRoute == "admin.product.show"?"active":""}}" href="{{route('admin.product.show')}}">Danh sách</a>
                    <a class="dropdown-item {{$currentRoute == "admin.product.create"?"active":""}}" href="{{route('admin.product.create')}}">Thêm</a>
                </div>
            </li>
            
            
            <li class="nav-item dropdown {{$currentRoute=='admin.product.comment' ? "show" :""}}">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="{{$currentRoute=='admin.product.comment' ?"true":""}}"><i
                        class="fas fa-comments"></i> <span>Comment</span></a>
                <div class="dropdown-menu {{$currentRoute=='admin.product.comment'?"show":""}}" aria-labelledby="">
                    <a class="dropdown-item {{$currentRoute=='admin.product.comment'?"active":""}}" href="{{route('admin.product.comment',['id'=>0])}}">Danh sách</a>
                </div>
            </li>

            <li class="nav-item dropdown {{in_array($currentRoute,['admin.product.customer','admin.product.customer.create'])?"show":""}} ">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="{{in_array($currentRoute,['admin.product.customer','admin.product.customer.create'])?"true":""}}"><i
                        class="fas fa-user-alt"></i> <span>Khách hàng</span></a>
                <div class="dropdown-menu  {{in_array($currentRoute,['admin.product.customer','admin.product.customer.create'])?"show":""}}" aria-labelledby="">
                    <a class="dropdown-item  {{in_array($currentRoute,['admin.product.customer'])?"active":""}}" href="{{route('admin.product.customer')}}">Danh sách</a>
                    <a class="dropdown-item {{in_array($currentRoute,['admin.product.customer.create'])?"active":""}}" href="{{route('admin.product.customer.create')}}">Thêm</a>
                </div>
            </li>
            <li class="nav-item dropdown {{in_array($currentRoute,['admin.product.category','admin.product.category.create'])?"show":""}}">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="{{in_array($currentRoute,['admin.product.category','admin.product.category.create'])?"true":""}}"><i
                        class="fas fa-folder"></i> <span>Danh mục</span></a>
                <div class="dropdown-menu {{in_array($currentRoute,['admin.product.category','admin.product.category.create'])?"show":""}}" aria-labelledby="">
                    <a class="dropdown-item {{in_array($currentRoute,['admin.product.category'])?"active":""}}" href="{{route('admin.product.category')}}">Danh sách</a>
                    <a class="dropdown-item {{in_array($currentRoute,['admin.product.category.create'])?"active":""}}" href="{{route('admin.product.category.create')}}">Thêm</a>
                </div>
            </li>
            <li class="nav-item dropdown {{in_array($currentRoute,['admin.product.discount'])?"show":""}}">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="{{in_array($currentRoute,['admin.product.discount'])?"true":""}}"><i
                        class="fas fa-percentage"></i> <span>Khuyến mãi</span></a>
                <div class="dropdown-menu {{in_array($currentRoute,['admin.product.discount'])?"show":""}}" aria-labelledby="">
                    <a class="dropdown-item {{in_array($currentRoute,['admin.product.discount'])?"active":""}}" href="{{route('admin.product.discount')}}">Danh sách</a>
                    <a class="dropdown-item" href="../../pages/promotion/add.html">Thêm</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id=""><i
                        class="fas fa-shipping-fast"></i> <span>Phí giao hàng</span></a>
                <div class="dropdown-menu" aria-labelledby="">
                    <a class="dropdown-item" href="../../pages/transport/list.html">Danh sách</a>
                    <a class="dropdown-item" href="../../pages/transport/add.html">Thêm</a>
                </div>
            </li>
        @can('staff', App\Models\Staff::class)
        <li class="nav-item dropdown {{in_array($currentRoute,['admin.product.staff'])?"show":""}}">
            <a class="nav-link dropdown-toggle " aria-expanded="{{in_array($currentRoute,['admin.product.staff'])?"true":""}}" data-toggle="dropdown" href="#" id=""><i
                    class="fas fa-users"></i> <span>Nhân viên</span></a>
            <div class="dropdown-menu {{in_array($currentRoute,['admin.product.staff'])?"show":""}}" aria-labelledby="">
                <a class="dropdown-item {{in_array($currentRoute,['admin.product.staff'])?"active":""}}" href="{{route('admin.product.staff')}}">Danh sách</a>
                <a class="dropdown-item" href="../../pages/staff/add.html">Thêm</a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id=""><i
                    class="fas fa-user-shield"></i> <span>Phân quyền</span></a>
            <div class="dropdown-menu" aria-labelledby="">
                <a class="dropdown-item" href="../../pages/permission/roles.html">Danh sách vai trò</a>
                <a class="dropdown-item" href="../../pages/permission/add_role.html">Thêm vai trò</a>
                <a class="dropdown-item" href="../../pages/permission/actions.html">Danh sách tác vụ</a>
            </div>
        </li>

        @endcan
           
            <li class="nav-item">
                <a class="nav-link" href="../../pages/order_status/list.html"><i class="fas fa-star-half-alt"></i>
                    <span>Trạng thái đơn hàng</span></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id=""><i
                        class="fas fa-file-alt"></i> <span>News letter</span></a>
                <div class="dropdown-menu" aria-labelledby="">
                    <a class="dropdown-item" href="../../pages/newsletter/list.html">Danh sách</a>
                    <a class="dropdown-item" href="../../pages/newsletter/send.html">Gởi mail</a>
                </div>
            </li>
        </ul>


        @yield('content')
        
    </div>
    <!-- /.content-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Bạn muốn thoát?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Hủy</button>
                    
                    <form action="{{route('admin.logout')}}" method="POST">
                        @csrf
                        <button class="btn btn-primary" type="submit">Thoát</button>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('') }}/admin/vendor/jquery/jquery.min.js"></script>
    <script src="{{ asset('') }}/admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{ asset('') }}/admin/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <script src="{{ asset('') }}/admin/vendor/datatables/jquery.dataTables.js"></script>
    <script src="{{ asset('') }}/admin/vendor/datatables/dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="{{ asset('') }}/admin/js/sb-admin.min.js"></script>
    <!-- Demo scripts for this page-->
    <script src="{{ asset('') }}/admin/js/demo/datatables-demo.js"></script>
    <script src="{{ asset('') }}/admin/js/admin.js"></script>
    
</body>

</html>
