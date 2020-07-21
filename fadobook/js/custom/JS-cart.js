function formatPricetoPrint(a) {
	a = a.toLocaleString();
	a = a.split(',').join('.');
	return a;
}

function addToCart(ID) {
	let quantity = 1;
	if (document.getElementById("quantity") != null) {
		var format = /^([0-9]{1,})$/;
		if (format.test(document.getElementById("quantity").value) == false || document.getElementById("quantity").value <= 0 ) {
			alert("Số lượng sản phẩm không hợp lệ");
			document.getElementById("quantity").focus();
			return;
		}
		quantity = document.getElementById("quantity").value;
	}


	let form_data = new FormData();

	form_data.append('action', 'addToCart');
	form_data.append('ID', parseInt(ID));
	form_data.append('quantity', parseInt(quantity));

	$.ajax({
		url: './php/PHP-cart.php',
		type: 'post',
		data: form_data,
		dataType: 'text',
		contentType: false,
		processData: false,
		success: function (response) {
			if (response == 1) {
				alert("Số lượng sản phẩm cần đặt lớn hơn số lượng sản phẩm có sẵn");
				return;
			}
			var getData = JSON.parse(response);
			var string = "<div class='cart-info'>";
			var totalCartQuantity = 0;
			var totalCartMoney = 0;
			for (var i = 0; i < getData.length; i++) {
				var totalPrice = getData[i].Quantity * getData[i].Price;
				string += "<div class='cart-prodect d-flex justify-content-between'>" +
					"<div class='cart-img'>" +
					`<img src='./img/sanpham/${getData[i].Pic}' >` +
					"</div>" +
					"<div class='cart-product'>" +
					`<a href='product-detail.php?id=${getData[i].ID}'>${getData[i].Name}</a>` +
					`<p style='color: black; font-size: 13px'>Số lượng: ${getData[i].Quantity}</p>` +
					`<p>${formatPricetoPrint(totalPrice)}₫</p>` +
					"</div>" +
					`<a href='#' onclick='removeFromCart("${getData[i].ID}")'  class='close-icon d-flex align-items-center'><i class='ion-close'></i></a>` +
					"</div>";
				totalCartQuantity += parseInt(getData[i].Quantity);
				totalCartMoney += parseInt(totalPrice);
			}
			string += "</div>";
			string += "<div class='price-prodect d-flex align-items-center justify-content-between'>" +
				"<p class='total'>Tổng cộng</p>" +
				`<p class='total-price'>${formatPricetoPrint(totalCartMoney)}₫</p>` +
				"</div>" +
				"<div class='cart-btn'>" +
				"<a href='cart.php' class='btn btn-primary'>Xem giỏ hàng</a>" +
				"</div>";
			document.getElementById("cartBox").innerHTML = string;
			document.getElementById("tongSoLuongSPGioHang").innerHTML = totalCartQuantity;
			alert("Sản phẩm đã được cho vào giỏ hàng");
		}
	});

}

function removeFromCart(ID) {
	if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng")) {
		let form_data = new FormData();
		form_data.append('action', 'removeFromCart');
		form_data.append('ID', parseInt(ID));

		$.ajax({
			url: './php/PHP-cart.php',
			type: 'post',
			data: form_data,
			dataType: 'text',
			contentType: false,
			processData: false,
			success: function (response) {
				if (response == "0") {
					var string = "<div class='cart-info'>" +
						"<div class='cart-prodect d-flex'>" +
						"<p>Giỏ hàng của bạn chưa có sản phẩm nào</p>" +
						"</div>" +
						"</div>";
					document.getElementById("cartBox").innerHTML = string;
					document.getElementById("tongSoLuongSPGioHang").innerHTML = 0;
					alert("Sản phẩm đã xóa khỏi giỏ hàng");
					if (window.location.href.includes("cart.php")) {
						string = "<h3>Giỏ hàng của bạn chưa có sản phẩm nào</h3>";
						document.getElementById('cartDetailContainer').innerHTML = string;
					}
					if (window.location.href.includes("checkout.php")) {
						window.location.href = "cart.php";
					}
				}
				else {
					var getData = JSON.parse(response);
					var string = "<div class='cart-info'>";
					var totalCartQuantity = 0;
					var totalCartMoney = 0;
					for (var i = 0; i < getData.length; i++) {
						var totalPrice = getData[i].Quantity * getData[i].Price;
						string += "<div class='cart-prodect d-flex justify-content-between'>" +
							"<div class='cart-img'>" +
							`<img src='./img/sanpham/${getData[i].Pic}' >` +
							"</div>" +
							"<div class='cart-product'>" +
							`<a href='product-detail.php?id=${getData[i].ID}'>${getData[i].Name}</a>` +
							`<p style='color: black; font-size: 13px'>Số lượng: ${getData[i].Quantity}</p>` +
							`<p>${formatPricetoPrint(totalPrice)}₫</p>` +
							"</div>" +
							`<a href='#' onclick='removeFromCart("${getData[i].ID}")'  class='close-icon d-flex align-items-center'><i class='ion-close'></i></a>` +
							"</div>";
						totalCartQuantity += parseInt(getData[i].Quantity);
						totalCartMoney += parseInt(totalPrice);
					}
					string += "</div>";
					string += "<div class='price-prodect d-flex align-items-center justify-content-between'>" +
						"<p class='total'>Tổng cộng</p>" +
						`<p class='total-price'>${formatPricetoPrint(totalCartMoney)}₫</p>` +
						"</div>" +
						"<div class='cart-btn'>" +
						"<a href='cart.php' class='btn btn-primary'>Xem giỏ hàng</a>" +
						"</div>";
					document.getElementById("cartBox").innerHTML = string;
					document.getElementById("tongSoLuongSPGioHang").innerHTML = totalCartQuantity;
					alert("Sản phẩm đã xóa khỏi giỏ hàng");

					if (window.location.href.includes("cart.php")) {
						string = "<div class='col-md-8'>" +
							"<table class='table table-bordered'>" +
							"<thead>" +
							"<tr>" +
							"<td class='text-center td-image'>Hình ảnh</td>" +
							"<td class='text-center td-name'>Tên sản phẩm</td>" +
							"<td class='text-center td-qty'>Số lượng</td>" +
							"<td class='text-center td-price'>Đơn giá</td>" +
							"<td class='text-center td-total'>Tổng cộng</td>" +
							"</tr>" +
							"</thead>" +
							"<tbody>";
						for (var i = 0; i < getData.length; i++) {
							var totalMoney = getData[i].Quantity * getData[i].Price;
							string += "<tr>" +
								`<td class='text-center td-image '> <img src='./img/sanpham/${getData[i].Pic}' style='width:60px;height:60px'> </td>` +
								`<td class='text-left td-name ><a href='product-detail.php?id=${getData[i].ID}'>${getData[i].Name}</a></td>` +
								"<td class='text-center td-qty '>" +
								"<div class='input-group btn-block '>" +
								`<input type='text' value='${getData[i].Quantity}'  size='1' class='quantity custom-form-control'>` +
								"<span class='input-group-btn'>" +
								`<button type='submit' data-toggle='tooltip' class='btn btn-update' onclick='updateQuantity(this,${getData[i].ID})' data-original-title='Update'><i class='fa fa-refresh'></i></button>` +
								`<button type='button' data-toggle='tooltip' class='btn btn-remove' onclick='removeFromCart(${getData[i].ID})' data-original-title='Remove'><i class='fa fa-times-circle'></i></button>` +
								"</span>" +
								"</div>" +
								"</td>" +
								`<td class='text-center td-price '>${formatPricetoPrint(parseInt(getData[i].Price))}₫</td>` +
								`<td class='text-center td-total '>${formatPricetoPrint(totalMoney)}₫</td>` +
								"</tr>";
						}
						string += "</tbody>" +
							"</table>" +
							"</div>" +
							"<div class='col-md-4' >" +
							"<div style='background-color:rgba(238, 238, 238, 1); padding: 1em 0.75em 1em 0.75em; border: 1px solid #dee2e6'>" +
							"<div class='cart-total' style='background: rgba(255, 255, 255, 1); border: 1px solid #dee2e6'>" +
							"<div>" +
							"<div style='padding: 1em 0.5em 1em 0.5em; '>" +
							"<span class='float-left w-50'><strong>Tổng tiền: </strong></span>" +
							`<span >${formatPricetoPrint(totalCartMoney)}₫</span>` +
							"</div>" +
							"<div style='padding: 1em 0.5em 1em 0.5em; '>" +
							"<span class='float-left w-50'><strong>Thành tiền: </strong></span>" +
							`<span >${formatPricetoPrint(totalCartMoney)}₫</span>` +
							"</div>" +
							"</div>" +
							"</div>" +
							"<div class='cart-control' style='margin-top: 20px'>" +
							"<a href='index.php' class='btn btn-primary'>Tiếp tục mua hàng</a>" +
							"<a href='checkout.php'class='btn btn-primary float-right'>Thanh toán</a>" +
							"</div>" +
							"</div>" +
							"</div>";
						document.getElementById('cartDetailContainer').innerHTML = string;
						$('[data-toggle="tooltip"], .tooltip').tooltip("hide");
						$('[data-toggle="tooltip"], .tooltip').tooltip();

					} if (window.location.href.includes("checkout.php")) {
						string = "<div class='col-md-12' style='background: rgba(240, 242, 245, 1); border: 1px solid #dee2e6'>" +
							"<div class='mb-1 mt-1'>" +
							"<h3>Giỏ hàng</h3>" +
							"</div>" +
							"<table class='table table-bordered'>" +
							"<thead>" +
							"<tr>" +
							"<td class='text-center td-image bg-white'>Hình ảnh</td>" +
							"<td class='text-center td-name bg-white'>Tên sản phẩm</td>" +
							"<td class='text-center td-qty bg-white'>Số lượng</td>" +
							"<td class='text-center td-price bg-white'>Đơn giá</td>" +
							"<td class='text-center td-total bg-white'>Tổng cộng</td>" +
							"</tr>" +
							"</thead>" +
							"<tbody>";
						for (var i = 0; i < getData.length; i++) {
							var totalMoney = getData[i].Quantity * getData[i].Price;
							string += "<tr>" +
								`<td class='text-center td-image bg-white'> <img src='./img/sanpham/${getData[i].Pic}' style='width:60px;height:60px' alt='${getData[i].Name}'> </td>` +
								`<td class='text-left td-name bg-white' ><a href='product-detail.php?id=${getData[i].ID}'>${getData[i].Name}</a></td>` +
								"<td class='text-center td-qty bg-white'>" +
								"<div class='input-group btn-block '>" +
								`<input type='text' value='${getData[i].Quantity}'   size='1' class='quantity custom-form-control'>` +
								"<span class='input-group-btn'>" +
								`<button type='submit' data-toggle='tooltip' class='btn btn-update' onclick='updateQuantity(this,${getData[i].ID})' data-original-title='Update'><i class='fa fa-refresh'></i></button>` +
								`<button type='button' data-toggle='tooltip' class='btn btn-remove' onclick='removeFromCart(${getData[i].ID})' data-original-title='Remove'><i class='fa fa-times-circle'></i></button>` +
								"</span>" +
								"</div>" +
								"</td>" +
								`<td class='text-center td-price bg-white'>${formatPricetoPrint(parseInt(getData[i].Price))}₫</td>` +
								`<td class='text-center td-total bg-white'>${formatPricetoPrint(totalMoney)}₫</td>` +
								"</tr>";
						}
						string += "<tr>" +
							"<td class='cart-total' style='background-color:rgba(238, 238, 238, 1);' colspan='5'>" +
							"<div>" +
							"<div style='padding: 0.5em 0;'>" +
							"<span class='float-left w-25'><strong>Tổng tiền: </strong></span>" +
							`<span >${formatPricetoPrint(totalCartMoney)}₫</span>` +
							"</div>" +
							"<div style='padding: 0.5em 0; '>" +
							"<span class='float-left w-25'><strong>Thành tiền: </strong></span>" +
							`<span >${formatPricetoPrint(totalCartMoney)}₫</span>` +
							"</div>" +
							"</div>" +
							"</td>" +
							"</tr>" +
							"</tbody>" +
							"</table>" +
							"</div>";
						document.getElementById('cartDetailContainer').innerHTML = string;
						$('[data-toggle="tooltip"], .tooltip').tooltip("hide");
						$('[data-toggle="tooltip"], .tooltip').tooltip();
					}
				}
				return true;
			}
		});
	} else {
		return false;
	}
}

function updateQuantity(thisElement, ID) {
	let form_data = new FormData();
	form_data.append('action', 'updateQuantity');
	form_data.append('ID', parseInt(ID));

	var el = $(thisElement).closest("tr");
	var quantity = el.find(".quantity");

	if (quantity.val() != "" && quantity.val() != 0) {
		var format = /^([0-9]{1,})$/;
		if (format.test(quantity.val()) == false) {
			alert("Số lượng sản phẩm không hợp lệ");
			quantity.focus();
			return;
		} 
	} else {
		if (removeFromCart(ID))
			return;
		else
			return;
	}

	form_data.append('quantity', parseInt(quantity.val()));


	$.ajax({
		url: './php/PHP-cart.php',
		type: 'post',
		data: form_data,
		dataType: 'text',
		contentType: false,
		processData: false,
		success: function (response) {
			if (response == 1) {
				alert("Số lượng sản phẩm cần đặt lớn hơn số lượng sản phẩm có sẵn");
				return;
			}
			var getData = JSON.parse(response);
			var string = "<div class='cart-info'>";
			var totalCartQuantity = 0;
			var totalCartMoney = 0;
			for (var i = 0; i < getData.length; i++) {
				var totalPrice = getData[i].Quantity * getData[i].Price;
				string += "<div class='cart-prodect d-flex justify-content-between'>" +
					"<div class='cart-img'>" +
					`<img src='./img/sanpham/${getData[i].Pic}' >` +
					"</div>" +
					"<div class='cart-product'>" +
					`<a href='product-detail.php?id=${getData[i].ID}'>${getData[i].Name}</a>` +
					`<p style='color: black; font-size: 13px'>Số lượng: ${getData[i].Quantity}</p>` +
					`<p>${formatPricetoPrint(totalPrice)}₫</p>` +
					"</div>" +
					`<a href='#' onclick='removeFromCart("${getData[i].ID}")'  class='close-icon d-flex align-items-center'><i class='ion-close'></i></a>` +
					"</div>";
				totalCartQuantity += parseInt(getData[i].Quantity);
				totalCartMoney += parseInt(totalPrice);
			}
			string += "</div>";
			string += "<div class='price-prodect d-flex align-items-center justify-content-between'>" +
				"<p class='total'>Tổng cộng</p>" +
				`<p class='total-price'>${formatPricetoPrint(totalCartMoney)}₫</p>` +
				"</div>" +
				"<div class='cart-btn'>" +
				"<a href='cart.php' class='btn btn-primary'>Xem giỏ hàng</a>" +
				"</div>";
			document.getElementById("cartBox").innerHTML = string;
			document.getElementById("tongSoLuongSPGioHang").innerHTML = totalCartQuantity;
			alert("Đã cập nhật số lượng sản phẩm");
			if (window.location.href.includes("cart.php")) {
				string = "<div class='col-md-8'>" +
					"<table class='table table-bordered'>" +
					"<thead>" +
					"<tr>" +
					"<td class='text-center td-image'>Hình ảnh</td>" +
					"<td class='text-center td-name'>Tên sản phẩm</td>" +
					"<td class='text-center td-qty'>Số lượng</td>" +
					"<td class='text-center td-price'>Đơn giá</td>" +
					"<td class='text-center td-total'>Tổng cộng</td>" +
					"</tr>" +
					"</thead>" +
					"<tbody>";
				for (var i = 0; i < getData.length; i++) {
					var totalPrice = getData[i].Quantity * getData[i].Price;
					string += "<tr>" +
						`<td class='text-center td-image '> <img src='./img/sanpham/${getData[i].Pic}' style='width:60px;height:60px'> </td>` +
						`<td class='text-left td-name ><a href='product-detail.php?id=${getData[i].ID}'>${getData[i].Name}</a></td>` +
						"<td class='text-center td-qty '>" +
						"<div class='input-group btn-block '>" +
						`<input type='text' value='${getData[i].Quantity}'   size='1' class='quantity custom-form-control'>` +
						"<span class='input-group-btn'>" +
						`<button type='submit' data-toggle='tooltip' class='btn btn-update' onclick='updateQuantity(this,${getData[i].ID})' data-original-title='Update'><i class='fa fa-refresh'></i></button>` +
						`<button type='button' data-toggle='tooltip' class='btn btn-remove' onclick='removeFromCart(${getData[i].ID})' data-original-title='Remove'><i class='fa fa-times-circle'></i></button>` +
						"</span>" +
						"</div>" +
						"</td>" +
						`<td class='text-center td-price '>${formatPricetoPrint(parseInt(getData[i].Price))}₫</td>` +
						`<td class='text-center td-total '>${formatPricetoPrint(totalPrice)}₫</td>` +
						"</tr>";
				}
				string += "</tbody>" +
					"</table>" +
					"</div>" +
					"<div class='col-md-4' >" +
					"<div style='background-color:rgba(238, 238, 238, 1); padding: 1em 0.75em 1em 0.75em; border: 1px solid #dee2e6'>" +
					"<div class='cart-total' style='background: rgba(255, 255, 255, 1); border: 1px solid #dee2e6'>" +
					"<div>" +
					"<div style='padding: 1em 0.5em 1em 0.5em; '>" +
					"<span class='float-left w-50'><strong>Tổng tiền: </strong></span>" +
					`<span >${formatPricetoPrint(totalCartMoney)}₫</span>` +
					"</div>" +
					"<div style='padding: 1em 0.5em 1em 0.5em; '>" +
					"<span class='float-left w-50'><strong>Thành tiền: </strong></span>" +
					`<span >${formatPricetoPrint(totalCartMoney)}₫</span>` +
					"</div>" +
					"</div>" +
					"</div>" +
					"<div class='cart-control' style='margin-top: 20px'>" +
					"<a href='index.php' class='btn btn-primary'>Tiếp tục mua hàng</a>" +
					"<a href='checkout.php' class='btn btn-primary float-right'>Thanh toán</a>" +
					"</div>" +
					"</div>" +
					"</div>";
				document.getElementById('cartDetailContainer').innerHTML = string;
				$('[data-toggle="tooltip"], .tooltip').tooltip("hide");
				$('[data-toggle="tooltip"], .tooltip').tooltip();
			}
			if (window.location.href.includes("checkout.php")) {
				string = "<div class='col-md-12' style='background: rgba(240, 242, 245, 1); border: 1px solid #dee2e6'>" +
					"<div class='mb-1 mt-1'>" +
					"<h3>Giỏ hàng</h3>" +
					"</div>" +
					"<table class='table table-bordered'>" +
					"<thead>" +
					"<tr>" +
					"<td class='text-center td-image bg-white'>Hình ảnh</td>" +
					"<td class='text-center td-name bg-white'>Tên sản phẩm</td>" +
					"<td class='text-center td-qty bg-white'>Số lượng</td>" +
					"<td class='text-center td-price bg-white'>Đơn giá</td>" +
					"<td class='text-center td-total bg-white'>Tổng cộng</td>" +
					"</tr>" +
					"</thead>" +
					"<tbody>";
				for (var i = 0; i < getData.length; i++) {
					var totalPrice = getData[i].Quantity * getData[i].Price;
					string += "<tr>" +
						`<td class='text-center td-image bg-white '> <img src='./img/sanpham/${getData[i].Pic}' style='width:60px;height:60px'> </td>` +
						`<td class='text-left td-name bg-white '><a href='product-detail.php?id=${getData[i].ID}'>${getData[i].Name}</a></td>` +
						"<td class='text-center td-qty bg-white '>" +
						"<div class='input-group btn-block '>" +
						`<input type='text' value='${getData[i].Quantity}'   size='1' class='quantity custom-form-control'>` +
						"<span class='input-group-btn'>" +
						`<button type='submit' data-toggle='tooltip' class='btn btn-update' onclick='updateQuantity(this,${getData[i].ID})' data-original-title='Update'><i class='fa fa-refresh'></i></button>` +
						`<button type='button' data-toggle='tooltip' class='btn btn-remove' onclick='removeFromCart(${getData[i].ID})' data-original-title='Remove'><i class='fa fa-times-circle'></i></button>` +
						"</span>" +
						"</div>" +
						"</td>" +
						`<td class='text-center td-price bg-white '>${formatPricetoPrint(parseInt(getData[i].Price))}₫</td>` +
						`<td class='text-center td-total bg-white '>${formatPricetoPrint(totalPrice)}₫</td>` +
						"</tr>";
				}
				string += "<tr>" +
					"<td class='cart-total' style='background-color:rgba(238, 238, 238, 1);' colspan='5'>" +
					"<div>" +
					"<div style='padding: 0.5em 0;'>" +
					"<span class='float-left w-25'><strong>Tổng tiền: </strong></span>" +
					`<span >${formatPricetoPrint(totalCartMoney)}₫</span>` +
					"</div>" +
					"<div style='padding: 0.5em 0; '>" +
					"<span class='float-left w-25'><strong>Thành tiền: </strong></span>" +
					`<span >${formatPricetoPrint(totalCartMoney)}₫</span>` +
					"</div>" +
					"</div>" +
					"</td>" +
					"</tr>" +
					"</tbody>" +
					"</table>" +
					"</div>";
				document.getElementById('cartDetailContainer').innerHTML = string;
				$('[data-toggle="tooltip"], .tooltip').tooltip("hide");
				$('[data-toggle="tooltip"], .tooltip').tooltip();
			}
		}
	});
}

function checkOut() {
	var name = document.getElementById("customer-info-form").name;
	var phone = document.getElementById("customer-info-form").phone;
	var address = document.getElementById("customer-info-form").address;
	var note = document.getElementById("customer-info-form").note;

	if (name.value == "") {
		alert("Họ và tên không được để trống");
		name.focus();
		return;
	} else {
		var format = /[0-9]/igm;
		if (format.test(name.value) == true) {
			alert("Họ và tên không thể chứa số");
			name.focus();
			return;
		}
	}

	if (phone.value == "") {
		alert("Số địa thoại không được để trống");
		phone.focus();
		return;
	} else {
		var pattern = /0[1-9]\d{8}$/;
		if (pattern.test(phone.value) == false) {
			alert("Số điện thoại không hợp lệ  VD: 09xxxxxxxx");
			phone.focus();
			return;
		}
	}

	if (address.value == "") {
		alert("Địa chỉ không được để trống");
		address.focus();
		return;
	}


	let form_data = new FormData();
	form_data.append('action', 'checkOut');
	form_data.append('name', name.value);
	form_data.append('phone', phone.value);
	form_data.append('address', address.value);
	form_data.append('note', note.value);

	$.ajax({
		url: './php/PHP-cart.php',
		type: 'post',
		data: form_data,
		dataType: 'text',
		contentType: false,
		processData: false,
		success: function (response) {
			switch (response) {
				case "0": {
					alert("Đặt hàng thành công");
					window.location.href = "index.php";
				} break;
				case "1": {
					alert("Đã xảy ra lỗi");
					window.location.href = "index.php";
				} break;
			}
		}
	});
}

function quickView(ID) {
	let form_data = new FormData();

	form_data.append('action', 'quickView');
	form_data.append('ID', parseInt(ID));

	$.ajax({
		url: './php/PHP-cart.php',
		type: 'post',
		data: form_data,
		dataType: 'text',
		contentType: false,
		processData: false,
		success: function (response) {

			var data = JSON.parse(response);

			var string = "<div class='row'>" +
				"<div class='col-md-5'>" +
					"<div class='product-image'>" +
						`<img class='product_img quickview-img' src='img/sanpham/${data.Pic}' data-zoom-image='img/sanpham/${data.Pic}'/>` +
					"</div>" +
					"<div id='pr_item_gallery' class='product_gallery_item owl-thumbs-slider owl-carousel owl-theme'>";
			for (var i = 0; i < data.allPic.length; i++) {
				string += `<div class='item'>
							<a href='#' data-image='img/sanpham/${data.allPic[i]}' data-zoom-image='img/sanpham/${data.allPic[i]}'>
								<img src='img/sanpham/${data.allPic[i]}'/>
							</a>
						</div>`;
			}
			string +=`</div>
				</div>
				<div class='col-md-7'>
					<div class='quickview-product-detail'>
						<div class='box-title'>${data.Name}</div>
						<hr>
						<div class='box-price'>Giá: <p>${formatPricetoPrint(parseInt(data.Price))}₫</p></div>
						<div class="box-attribute">
							<div class="attribute-item">
								<p class="attribute-title">Tác giả:</p>
								<p class="attribute-content">${data.Author}</p>
							</div>
							<div class="attribute-item">
								<p class="attribute-title">Ngày xuất bản:</p>
								<p class="attribute-content">${data.Time}</p>
							</div>
							<div class="attribute-item">
								<p class="attribute-title">Thể Loại:</p>
								<p class="attribute-content">${data.Type}</p>
							</div>  
						</div>
						<hr>
						<p class="stock">Trạng thái: <span>Còn ${(data.Quantity)} sản phẩm</span></p>
						<div class="quantity-box">
							<p>Số lượng:</p>
							<div class='input-group'>
							<input id='quantity' class='quantity-number qty' type='text' value='1' min='1'>
						</div>
						<div class='quickview-cart-btn'>
							<button class='btn btn-primary text-white' onclick='addToCart(${data.ID})' ${data.Quantity != 0 ? '' : 'disabled'}><img src="img/cart-icon-1.png" alt="cart-icon-1"> Thêm vào giỏ hàng</button>
						</div>
					</div>
				</div>
			</div>
		</div>`;
			document.getElementById("quickview-popup").innerHTML = string;
		}
	});
}