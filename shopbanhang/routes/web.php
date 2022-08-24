<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\FacebookController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ForgotpasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
//admin
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetpasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminCommentController;
use App\Http\Controllers\Admin\AdminCustomerController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminDiscountController;
use App\Http\Controllers\Admin\AdminStaffController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', HomeController::class . "@index")->name("index");
Route::get('san-pham', ProductController::class . "@index")->name("product.index");
Route::get('danh-muc/{slug}', ProductController::class . "@index")->name("category.show");
Route::get('san-pham/{slug}.html', ProductController::class . "@show")->name("product.show");
Route::get('san-pham/search', ProductController::class . "@search")->name("product.search");
Route::post('comment/store', CommentController::class . "@store")->name("comment.store");
Route::post('register', RegisterController::class . "@register")->name("register");
Route::post('login', LoginController::class . "@login")->name("login");
Route::post('logout', LoginController::class . "@logout")->name("logout");
Route::get('exittingEmail', RegisterController::class . "@exittingEmail")->name("exittingEmail");

// Route::middleware("auth")->group(function(){ //middleware("auth"): do mình dùng Auth được cung cấp sẵn bởi laravel cho form Register và Login nên khi đăng nhập nó mới dùng dc middleware này
Route::get('carts/add', CartController::class . "@store")->name("cart.store");
Route::get('carts/show', CartController::class . "@show")->name("cart.show");
Route::get('carts/delete/{rowId}', CartController::class . "@delete")->name("cart.delete");
Route::get('carts/update/{rowId}/{qty}', CartController::class . "@update")->name("cart.update");
Route::get('carts/discount', CartController::class . "@discount")->name("cart.discount");

Route::get('carts/voucher', CartController::class . "@voucher")->name("cart.voucher");

Route::get('payment/checkout', PaymentController::class . "@create")->name("payment.create");

Route::post('payment/store', PaymentController::class . "@store")->name("payment.store");

Route::get('address/{province_id}/districts', AddressController::class . "@districts")->name("address.districts");
Route::get('address/{district_id}/wards', AddressController::class . "@wards")->name("address.wards");

Route::get('shippingfee/{province_id}', AddressController::class . "@shippingFee")->name("address.shippingFee");

Route::get('address/show', AddressController::class . "@show")->name("address.show");
Route::get('lien-he.html', ContactController::class . "@show")->name("contact.show");
Route::post('contact/sendEmail', ContactController::class . "@sendEmail")->name("contact.sendEmail");

Route::post('password/email', ForgotpasswordController::class . "@sendResetLinkEmail")->name("password.email");
Route::get('password/reset/{token}', ResetpasswordController::class . "@showResetForm")->name("password.reset");
Route::post('password/reset', ResetpasswordController::class . "@reset")->name("password.update");

Route::get('auth/google', GoogleController::class . '@redirectToGoogle')->name("google.login");
Route::get('auth/google/callback', GoogleController::class . '@handleGoogleCallback');
Route::get('auth/facebook', FacebookController::class . '@redirectToFacebook')->name("facebook.login");
Route::get('auth/facebook/callback', FacebookController::class . '@handleFacebookCallback');

Route::get('email/verify/{id}/{token}', RegisterController::class . '@verify')->name("register.verify");

// });

Route::middleware("auth")->group(function () {
    Route::get('customer/show', CustomerController::class . "@show")->name("customer.show");
    Route::post('customer/update', CustomerController::class . "@update")->name("customer.update");

    Route::get('customer/address', CustomerController::class . "@address")->name("customer.address");
    Route::post('customer/Updateaddress', CustomerController::class . "@Updateaddress")->name("customer.Updateaddress");

    Route::get('order/index', OrderController::class . "@index")->name("order.index");

    Route::get('orders/{orderId}', OrderController::class . "@show")->name("order.show");
});
//admin
Route::prefix('admin')->group(function () {

    Route::middleware("authAdmin:admin")->group(function () {
        Route::get('dashboard', DashboardController::class . "@index")->name("dashboard");
        Route::get('product/create', AdminProductController::class . "@create")->name("admin.product.create");
        Route::post('product/store', AdminProductController::class . "@store")->name("admin.product.store");
        Route::get('product/show', AdminProductController::class . "@show")->name("admin.product.show");
        Route::get('product/delete/{id}', AdminProductController::class . "@delete")->name("admin.product.delete");
        Route::get('product/comment/{id}', AdminCommentController::class . "@index")->name("admin.product.comment");
        Route::get('product/comment/delete/{id}', AdminCommentController::class . "@delete")->name("admin.product.comment.delete");
        Route::get('product/customer', AdminCustomerController::class . "@index")->name("admin.product.customer");
        Route::get('product/customer/create', AdminCustomerController::class . "@create")->name("admin.product.customer.create");
        Route::post('product/customer/store', AdminCustomerController::class . "@store")->name("admin.product.customer.store");
        Route::get('product/customer/delete/{id}', AdminCustomerController::class . "@delete")->name("admin.product.customer.delete");
        Route::get('product/customer/{province_id}/district', AdminCustomerController::class . "@district")->name("admin.product.customer.district");
        Route::get('product/customer/{district_id}/ward', AdminCustomerController::class . "@ward")->name("admin.product.customer.ward");
        Route::get('product/category', AdminCategoryController::class . "@index")->name("admin.product.category");
        Route::get('product/category/create', AdminCategoryController::class . "@create")->name("admin.product.category.create");
        Route::post('product/category/store', AdminCategoryController::class . "@store")->name("admin.product.category.store");
        Route::get('product/discount', AdminDiscountController::class . "@index")->name("admin.product.discount");

        Route::get('product/staff', AdminStaffController::class . "@index")->name("admin.product.staff");
        Route::get('product/staff/delete/{id}', AdminStaffController::class . "@delete")->name("admin.product.staff.delete");

    });
    Route::get('login', AdminLoginController::class . "@index")->name("admin.login.form");
    Route::post('login', AdminLoginController::class . "@login")->name("admin.login");
    Route::post('logout', AdminLoginController::class . "@logout")->name("admin.logout");

});
