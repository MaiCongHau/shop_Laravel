function openMenuMobile() {
    $(".menu-mb").width("250px");
    $(".btn-menu-mb").hide("slow");
}

function closeMenuMobile() {
    $(".menu-mb").width(0);
    $(".btn-menu-mb").show("slow");
}

$(function(){

    // submit form liên hệ
    $("form.form-contact").validate({
        rules: {
            fullname:{
                required:true,
            },
            email:{
                required:true,
                email:true
            },
            mobile:{
                required:true,
            },
            content:{
                required:true,
            }
        },
        messages:{
            fullname:{
                required:"Vui lòng nhập name",
            },
            email:{
                required:"Vui lòng nhập email",
                email:"Vui lòng nhập đúng định dạng email"
            },
            mobile:{
                required:"Vui lòng nhập số điện thoại",
            },
            content:{
                required:"Vui lòng nhập nội dung",
            }
        },
        // bootstrap 3 
        errorClass: "invalid-feedback d-block help-block",
        highlight: function(element) // dữ liệu lỗi thì nó add thêm class is-invalid
        {
            $(element).parent('div').addClass("has-error");
        },
        unhighlight: function(element) //dữ liệu ko lỗi thì nó remove  class is-invalid
        {
            $(element).parent('div').removeClass("has-error");
        },

        submitHandler: function(form) {
            var post_url = $(form).attr("action"); //get form action url
            var request_method = $(form).attr("method"); //get form GET/POST method
            var form_data = $(form).serialize(); // gửi chuỗi qua thằng ContactController vào function sendEmail, thằng sendEmail bên đó dùng $_POST để hứng dữ liệu này, và nó magic qua đó cái nó thành array
            $(".message").html("Hệ thống đang gởi email... Vui lòng chờ");
            $("button[type=submit]").attr("disabled", "disabled");
            $.ajax({
                url: post_url,
                type: request_method,
                data: form_data
            })
            .done(function(data) {
                $(".message").html(data);
                $("button[type=submit]").removeAttr("disabled");
            });
          }

       });



    // $("form.form-contact").submit(function(event) {
    //         /* Act on the event */
    //         event.preventDefault(); //prevent default action
    //         var post_url = $(this).attr("action"); //get form action url
    //         var request_method = $(this).attr("method"); //get form GET/POST method
    //         var form_data = $(this).serialize(); //Encode form elements for submission
    //         $(".message").html("Hệ thống đang gởi email... Vui lòng chờ");
    //         $("button[type=submit]").attr("disabled", "disabled");
    //         $.ajax({
    //             url: post_url,
    //             type: request_method,
    //             data: form_data
    //         })
    //         .done(function(data) {
    //             $(".message").html(data);
    //             $("button[type=submit]").removeAttr("disabled");
    //         });
    //     });


  // Thay đổi province -> district
  $("main .province").change(function(event) {
    /* Act on the event */
    var province_id = $(this).val();

    if (!province_id) {
        updateSelectBox(null, "main .district");
        updateSelectBox(null, "main .ward");
        return;
    }

    $.ajax({
        url: `/address/${province_id}/districts` //ES6
    })
    
    .done(function(data) {
        
        updateSelectBox(data, "main .district");
        updateSelectBox(null, "main .ward");
    });

    if ($("main .shipping-fee").length) {
        $.ajax({
            url: `/shippingfee/${province_id}`, // ES6
        })
        .done(function(data) {
          
            //update shipping fee and total on UI
            let shipping_fee = Number(data);
            let payment_total = Number($("main .total").attr("data")) + shipping_fee - Number($("main .voucher").attr("data"));
            $("main .shipping-fee").html(number_format(shipping_fee) + "₫");
            $("main .payment-total").html(number_format(payment_total) + "₫");
        });
    }  
});


// Thay đổi District ->ward
$("main .district").change(function(event) {
    /* Act on the event */
    var district_id = $(this).val();

    if (!district_id) {
        updateSelectBox(null, "main .province");
        updateSelectBox(null, "main .ward");
        return;
    }

    $.ajax({
        url: `/address/${district_id}/wards` //ES6
    })
    .done(function(data) {
        
        updateSelectBox(data, "main .ward");
    });
});



    // Thêm sản phẩm vào giỏ hàng
    $("main .buy-in-detail").click(function(event) {
        /* Act on the event */
        var qty = $(this).prev("input").val();
        var product_id = $(this).attr("product-id");
        $.ajax({
            url: '/carts/add',
            type: 'GET',
            data: {product_id: product_id, qty:qty}
        })
        .done(function(data) {
            displayCart(data);
            
        });
    });


    // Thêm sản phẩm vào giỏ hàng
    $("main .buy").click(function(event) {
        /* Act on the event */
        var product_id = $(this).attr("product-id");
        $.ajax({
            url: '/carts/add',
            type: 'GET',
            data: {product_id: product_id, qty:1} // theo cơ chế của nó cái qty nó sẽ tự động tăng khi mà mình bấm thêm lần nữa
        })

        .done(function(data) {
            displayCart(data);
            
        });
    });
    
    
    // Validate với trình duyệt đăng ký
        $("[name=registration]").validate({
            rules: {
                name: {
                    required:true,
                    regex:
                    /^[a-zAZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s]+$/i,
                    maxlength:20,
                },
                mobile: {
                    required:true,
                    regex:/^0([0-9]{9,9})$/,
                },
                email:{
                    required:true,
                    email:true,
                    remote:"/exittingEmail"
                },
                password:{
                    required:true,
                    regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/
                  },
                password_confirmation:{
                    required:true,
                    equalTo:"[name=password]"
                  },
                hiddenRecaptcha: { // lưu ý phải có thằng input hiddenRecapcha
                    //true: lỗi
                    //false: passed
                    required: function () {
                        if (grecaptcha.getResponse() == '') {
                            return true;
                        } else {
                            return false;
                        }
                    }
                }
            
            },
            messages:{
                name: {
                    required:"vui lòng điển tên",
                    regex:"Vui lòng nhập đúng Tiếng Việt",
                    maxlength:"Vui lòng nhập không quá 20 ký tự",
                },
                mobile: {
                    required:"vui lòng nhập số điện thoại",
                    regex:"Vui lòng bắt đầu từ số 0",
                },
                email:{
                    required:"Vui lòng nhập email",
                    email:"Vui lòng nhập email. VD abc@gmail.com",
                    remote:"Email đã tồn tại"
                },
                password:{
                    required:"Vui lòng nhập mật khẩu",
                    regex:"Vui lòng nhập chữ hoa, thường, số và ký tự đặt biệt có độ dài 8 ký tự"
                },
                password_confirmation:{
                    required:"Vui lòng nhập mật khẩu xác nhận",
                    equalTo:"Vui lòng nhập giống mật khẩu ở trên"
                },
                hiddenRecaptcha: {
                    required:"Vui lòng xác nhận"
                }
        
            },
            // bootstrap 3 
            errorClass: "invalid-feedback d-block help-block",
            highlight: function(element) // dữ liệu lỗi thì nó add thêm class is-invalid
            {
                $(element).parent('div').addClass("has-error");
            },
            unhighlight: function(element) //dữ liệu ko lỗi thì nó remove  class is-invalid
            {
                $(element).parent('div').removeClass("has-error");
            }
        });

   
        // Validate với trình duyệt đăng nhập
        $("#login").validate({
            rules: {
                email:{
                    required:true,
                    email:true
                },
                password:{
                    required:true,
                }
            },
            messages:{
                email:{
                    required:"Vui lòng nhập email",
                    email:"Vui lòng nhập email. VD abc@gmail.com"
                },
                password:{
                    required:"Vui lòng nhập password",
                }
            },
            // bootstrap 3 
            errorClass: "invalid-feedback d-block help-block",
            highlight: function(element) // dữ liệu lỗi thì nó add thêm class is-invalid
            {
                $(element).parent('div').addClass("has-error");
            },
            unhighlight: function(element) //dữ liệu ko lỗi thì nó remove  class is-invalid
            {
                $(element).parent('div').removeClass("has-error");
            }
           });

        // Submit đánh giá sản phẩm
        $("form.form-comment").submit(function(event) {
        /* Act on the event */
        event.preventDefault(); //ngăn chặn nó chuyển qua thằng CommentController để ta ko phải load lại trang
        var post_url = $(this).attr("action"); //get form action url
        var request_method = $(this).attr("method"); //get form GET/POST method
        var form_data = $(this).serialize(); // mã hóa tất cả các giá trị trong thằng "form" thành chuỗi, tức là nó sẽ thêm các dấu "&" để nối các chuỗi lại với nhau 
       
        $.ajax({
            url: post_url, // comment/store
            type: request_method, // POST
            data: form_data, // gửi chuỗi qua thằng CommentController vào function store, thằng store bên đó dùng $_POST để hứng dữ liệu này, và nó magic qua đó cái nó thành array
        })

        .done(function(data) {
          
            $(".comment-list").html(data); // data này chính là code view 
            updateAnsweredRating(); // cập nhật lại cái ngôi sao trong mấy cái đánh giá
            $('form.form-comment').trigger("reset"); // submit xong reset lại form
        });
        });


        // Ajax search
        var timeout = null;
        $("header form.header-form .search").keyup(function(event) { // .keyup: khi chỉ cần gõ phím là nó vào thằng này
        /* Act on the event */
        clearTimeout(timeout); // nghĩa là vừa vào thì thằng tiemout ko dc chạy
        var pattern = $(this).val();

        $(".search-result").html(""); // dữ liệu đổ về thì chứa ở đây

        timeout = setTimeout(function(){ // code trong thằng setTimeout sẽ bị delay đi 500mili giây
        if (pattern) {

            $.ajax({
            url: 'san-pham/search', // route
            type: 'GET',
            data: {pattern123: pattern},//key:value
            })
            
        .done(function(data) { 

            $(".search-result").html(data); // add dữ liệu vô thằng .search-result
            $(".search-result").show(); // chuyển từ display: none thành display:block

        });
        }

        },500);

        });  


    // sắp xếp tăng giảm 
    $("#sort-select").change(function (e) { 
        $data = $("#sort-select option:selected").attr("data_url");
        window.location.href=$data;
    });


    // Tìm kiếm theo range 
    $(".col-md-3 .price-range input").click(function (e) { 
         $price_range = $(this).val();
         window.location.href = "?price-range="+$price_range;
    });



    $(".product-container").hover(function(){
        $(this).children(".button-product-action").toggle(400);
    });

    // Display or hidden button back to top
    $(window).scroll(function() { 
		 if ($(this).scrollTop()) { 
			 $(".back-to-top").fadeIn();
		 } 
		 else { 
			 $(".back-to-top").fadeOut(); 
		 } 
	 }); 

    // Khi click vào button back to top, sẽ cuộn lên đầu trang web trong vòng 0.8s
	 $(".back-to-top").click(function() { 
		$("html").animate({scrollTop: 0}, 800); 
	 });

	 // Hiển thị form đăng ký
	 $('.btn-register').click(function () {
	 	$('#modal-login').modal('hide');
        $('#modal-register').modal('show');
    });

	 // Hiển thị form forgot password
	$('.btn-forgot-password').click(function () {
		$('#modal-login').modal('hide');
    	$('#modal-forgot-password').modal('show');
    });

	 // Hiển thị form đăng nhập
	$('.btn-login').click(function () {
    	$('#modal-login').modal('show');
    });

	// Fix add padding-right 17px to body after close modal
	// Don't rememeber also attach with fix css
	$('.modal').on('hide.bs.modal', function (e) {
        e.stopPropagation();
        $("body").css("padding-right", 0);
        
    });

    // Hiển thị cart dialog
    $('.btn-cart-detail').click(function () {
    	$('#modal-cart-detail').modal('show');
    });

    // Hiển thị aside menu mobile
    $('.btn-aside-mobile').click(function () {
        $("main aside .inner-aside").toggle();
    });

    // Hiển thị carousel for product thumnail
    $('main .product-detail .product-detail-carousel-slider .owl-carousel').owlCarousel({
        margin: 10,
        nav: true
        
    });
    // Bị lỗi hover ở bộ lọc (mobile) & tạo thanh cuộn ngang
    // Khởi tạo zoom khi di chuyển chuột lên hình ở trang chi tiết
    // $('main .product-detail .main-image-thumbnail').ezPlus({
    //     zoomType: 'inner',
    //     cursor: 'crosshair',
    //     responsive: true
    // });
    
    // Cập nhật hình chính khi click vào thumbnail hình ở slider
    $('main .product-detail .product-detail-carousel-slider img').click(function(event) {
        /* Act on the event */
        $('main .product-detail .main-image-thumbnail').attr("src", $(this).attr("src"));
        var image_path = $('main .product-detail .main-image-thumbnail').attr("src");
        $(".zoomWindow").css("background-image", "url('" + image_path + "')");
        
    });

    $('main .product-detail .product-description .rating-input').rating({
        min: 0,
        max: 5,
        step: 1,
        size: 'md',
        stars: "5",
        showClear: false,
        showCaption: false
    });

    $('main .product-detail .product-description .answered-rating-input').rating({
        min: 0,
        max: 5,
        step: 1,
        size: 'md',
        stars: "5",
        showClear: false,
        showCaption: false,
        displayOnly: false,
        hoverEnabled: true
    });

    $('main .ship-checkout[name=payment_method]').click(function(event) {
        /* Act on the event */
    });
    
    // Hiển thị carousel for relative products
    $('main .product-detail .product-related .owl-carousel').owlCarousel({
        loop:false,
        margin: 10,
        nav: true,
        dots:false,
        responsive:{
        0:{
            items:2
        },
        600:{
            items:4
        },
        1000:{
            items:5
        }
    }
        
    });
});

// regex 
$.validator.addMethod(
    "regex",
    function (value, element, regexp) {
      if (regexp.constructor != RegExp) regexp = new RegExp(regexp);
      else if (regexp.global) regexp.lastIndex = 0;
      return this.optional(element) || regexp.test(value);
    },
    "Please check your input."
  );



// Hiển thị những rating của những đánh giá
function updateAnsweredRating() {
    $('main .product-detail .product-description .answered-rating-input').rating({
        min: 0,
        max: 5,
        step: 1,
        size: 'md',
        stars: "5",
        showClear: false,
        showCaption: false,
        displayOnly: false,
        hoverEnabled: true
    });
}

// Hiển thị cart
function displayCart(data) {
    var cart = JSON.parse(data);

    var count = cart.count;
    $(".btn-cart-detail .number-total-product").html(count);

    var subtotal = cart.subtotal;
    $("#modal-cart-detail .price-total").html(subtotal+"₫");
    
    var items = cart.items;
    $("#modal-cart-detail .cart-product").html(items);
}

// delete shooping cart 
function deleteProductInCart(rowId) {
    $.ajax({
        url: `/carts/delete/${rowId}`,//literal template es6 '/carts/delete/' + rowId
        type: 'GET',
    })
    .done(function(data) {
        displayCart(data);
        
    });
}

//cập nhật số lượng sản phẩm
function updateProductInCart(self,rowId) {
    var qty = $(self).val();

    $.ajax({
        url: `/carts/update/${rowId}/${qty}`,
        type: 'GET',
    })
    .done(function(data) {
        displayCart(data);
        
    });
}

// Cập nhật các option cho thẻ select
function updateSelectBox(data, selector) {

    var items = JSON.parse(data);
    $(selector).find('option').not(':first').remove(); // tìm cai selector giữ lại thằng đầu còn lại remove hết
    if (!data) return;
    for (let i = 0; i < items.length; i++) {
        let item = items[i];
        let option = '<option value="' + item.id + '"> ' + item.name + '</option>';
        $(selector).append(option); //thêm sau thằng selector
    } 
    
}



// Login in google
function onSignIn(googleUser) {
    var id_token = googleUser.getAuthResponse().id_token;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'http://study.com/register/google/backend/process.php');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
      console.log('Signed in as: ' + xhr.responseText);
    };
    xhr.send('idtoken=' + id_token);
}