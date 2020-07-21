function formatPricetoPrint(a) {
	a = a.toLocaleString();
	a = a.split(',').join('.');
	return a;
}
function GetFormattedDate(string) {
    var Time = new Date(string);
	var month = Time.getMonth() + 1;
	if(month < 10) {
		month = "0"+month.toString();
	}
	var day = Time.getDate();
	if(day < 10) {
		day = "0"+day.toString();
	}
    var year = Time.getFullYear();
    return day + "/" + month + "/" + year;
}


function login() {
	var email = document.getElementById("login-form").email;
	var password = document.getElementById("login-form").password;

	if (email.value==""){
		alert("Email không thể để trống");
		email.focus();
		return;
	}

	if (password.value==""){
		alert("Mật khẫu không thể để trống");
		password.focus();
		return;
	}

	var form_data = new FormData();
	form_data.append('action','login');
	form_data.append('email',email.value);
	form_data.append('password',password.value);

	jQuery.ajax({
		type: "POST",
		url: './php/PHP-user.php',
		dataType: 'text',
		cache: false,
		contentType: false,
		processData: false,
		data : form_data,
		success:function(res){
			switch(res){
				case "0":{
					location.reload();
				}break;
				case "1":{
					alert("Email hoặc mật khẫu không chính xác");
				}break;
				case "2":{
					alert("Tài khoản của bạn đã bị khóa");
				}break;
			}
		}
	});
}
function signup() {
	var name = document.getElementById("signup-form").name;
	var email = document.getElementById("signup-form").email;
	var password = document.getElementById("signup-form").password;
	var assertPassword = document.getElementById("signup-form").assertPassword;
	var rules = document.getElementById("signup-form").rules;

	if (name.value == ""){
		alert("Họ và tên không được để trống");
		name.focus();
		return;
	} else {
		var format = /[0-9]/igm;
		if(format.test(name.value)==true){
			alert("Họ và tên không thể chứa số");
			name.focus();
			return;	
		}
	}


	if (email.value==""){
		alert("Email không được để trống");
		email.focus();
		return;
	} else {
		if (email.value.length<5){
			alert("Email không thể qua ngắn");
			email.focus();
			return;
		} else {
			var format = /^[a-z][a-z0-9_\.]{5,32}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$/igm;
			if(format.test(email.value)==false){
				alert("Email không hợp lệ");
				email.focus();
				return;	
			}
		}
	}

	if (password.value == ""){
		alert("Mật khẫu không thể để trống");
		password.focus();
		return;
	} else {
		var format = /^\w{8,16}$/igm;
		if(format.test(password.value)==false){
			alert("Mật khẩu phải từ 8-16 ký tự");
			password.focus();
			return;	
		}
		if( assertPassword.value == "" ){
			alert("Xác nhận mật khẫu không thể để trống");
			assertPassword.focus();
			return;
		} else {
			if( password.value != assertPassword.value ){
				alert("Mật khẫu và xác nhận không thể khác nhau");
				return;
			}
		}
	}

	if(rules.checked == false) {
		alert("Bạn cần chấp nhận những điều khoản của chúng tôi");
		return;
	}

	var form_data = new FormData();
	form_data.append('action','signup');
	form_data.append('email',email.value);
	form_data.append('name',name.value);
	form_data.append('password',password.value);

	jQuery.ajax({
		type: "POST",
		url: './php/PHP-user.php',
		dataType: 'text',
		cache: false,
		contentType: false,
		processData: false,
		data : form_data,
		success:function(res){
			switch(res){
				case "0":{
					alert("Đăng ký thành công");
					window.location.href = "index.php";
				}break;
				case "1":{
					alert("Email đã tồn tại");
				}break;
			}
		}
	});
}
function logout() {
	var form_data = new FormData();
	form_data.append('action','logout');

	jQuery.ajax({
		type: "POST",
		url: './php/PHP-user.php',
		dataType: 'text',
		cache: false,
		contentType: false,
		processData: false,
		data : form_data,
		success:function(res){
			switch(res){
				case "0":{
					location.reload();
				}break;
			}
		}
	});
}
function saveInfo() {
	var name = document.getElementById("information-form").name;
	var phone = document.getElementById("information-form").phone;
	var address = document.getElementById("information-form").address;

	if (name.value == ""){
		alert("Họ và tên không được để trống");
		name.focus();
		return;
	} else {
		var format = /[0-9]/igm;
		if(format.test(name.value) == true){
			alert("Họ và tên không thể chứa số");
			name.focus();
			return;	
		}
	}

	if (phone.value==""){
		alert("Số địa thoại không được để trống");
		phone.focus();
		return;
	} else {
		var pattern = /0[1-9]\d{8}$/;
		if(pattern.test(phone.value)==false){
			alert("Số điện thoại không hợp lệ");
			phone.focus();
			return;
		}
	}

	if (address.value==""){
		alert("Địa chỉ không được để trống");
		address.focus();
		return;
	}


	var form_data = new FormData();
	form_data.append('action','saveInfo');
	form_data.append('phone',phone.value);
	form_data.append('name',name.value);
	form_data.append('address',address.value);

	jQuery.ajax({
		type: "POST",
		url: './php/PHP-user.php',
		dataType: 'text',
		cache: false,
		contentType: false,
		processData: false,
		data : form_data,
		success:function(res){
			switch(res){
				case "0":{
					alert("Lưu thông tin thành công");
					window.location.href = "user.php";
				}break;
				case "1":{
					alert("Phiên đăng nhập đã hết hạn");
					window.location.href = "index.php";
				}break;
			}
		}
	});
}
function changePassword() {
	var oldPassword = document.getElementById("password-form").oldPassword;
	var newPassword = document.getElementById("password-form").newPassword;
	var assertNewPassword = document.getElementById("password-form").assertNewPassword;

	if (oldPassword.value == ""){
		alert("Mật khẫu cũ không được để trống");
		oldPassword.focus();
		return;
	} else {
		
	}

	if (newPassword.value == ""){
		alert("Mật khẫu mới không được để trống");
		newPassword.focus();
		return;
	} else {
		var format = /^\w{8,16}$/igm;
		if(format.test(newPassword.value)==false){
			alert("Mật khẩu mới phải từ 8-16 ký tự");
			newPassword.focus();
			return;	
		}
		if (assertNewPassword.value == ""){
			alert("Xác nhận mật khẫu mới không được để trống");
			assertNewPassword.focus();
			return;
		} else {
			if(newPassword.value != assertNewPassword.value){
				alert("Xác nhận mật khẫu mới không đúng");
				return;
			}
		}
	}

	var form_data = new FormData();
	form_data.append('action','changePassword');
	form_data.append('oldPassword',oldPassword.value);
	form_data.append('newPassword',newPassword.value);

	jQuery.ajax({
		type: "POST",
		url: './php/PHP-user.php',
		dataType: 'text',
		cache: false,
		contentType: false,
		processData: false,
		data : form_data,
		success:function(res){
			switch(res){
				case "0":{
					alert("Đổi mật khẫu thành công");
					window.location.href = "user.php";
				}break;
				case "1":{
					alert("Phiên đăng nhập đã hết hạn");
					window.location.href = "index.php";
				}break;
				case "2":{
					alert("Mật khẫu cũ không chính xác");
				}break;
			}
		}
	});
}
function showDetailBill(id){
	var form_data = new FormData();
	form_data.append('action','showDetailBill');
	form_data.append('id',id);

	jQuery.ajax({
		type: "POST",
		url: './php/PHP-user.php',
		dataType: 'text',
		cache: false,
		contentType: false,
		processData: false,
		data : form_data,
		success:function(res){
			if(res == 1){
				alert("Phiên đăng nhập của bạn đã hết hạn");
				window.location.href = "index.php";
			}
			if(res == 2){
				alert("Đã xảy ra lỗi");
				location.reload();
			}
			var data = JSON.parse(res);
			string = `<div>
				<span>Họ và tên: &nbsp; </span><span>${data.Name}</span>
			</div>
			<div>
				<span>Số điện thoại: &nbsp;</span><span>${data.Phone}</span>
			</div>
			<div>
				<span>Địa chỉ: &nbsp;</span><span>${data.Address}</span>
			</div>
			<div>
				<span>Số lượng: &nbsp;</span><span>${data.Quantity}</span>
			</div>
			<div>
				<span>Tổng tiền:&nbsp;</span><span>${formatPricetoPrint(Number(data.Total))}₫</span>
			</div>
			<div>
				<span>Thời gian: &nbsp;</span><span>${GetFormattedDate(data.Time)}</span>
			</div>
			<div>
				<span>Trạng thái: &nbsp;</span><span>${data.Status== 1 ? "Chờ xử lý" : "Đã xử lý"}</span>
			</div>
			<div>
				<span>Ghi chú: &nbsp;</span><span>${data.Note}</span>
			</div>`;
			document.getElementById("bill-info").innerHTML = string;
			showProductsBill(id);
		}
	});
}

function showProductsBill(id){
	var form_data = new FormData();
	form_data.append('action','showProductsBill');
	form_data.append('id',id);

	jQuery.ajax({
		type: "POST",
		url: './php/PHP-user.php',
		dataType: 'text',
		cache: false,
		contentType: false,
		processData: false,
		data : form_data,
		success:function(res){
			var data = JSON.parse(res);
			string = "";
			for(var i = 0; i < data.length; i++){
				string += `<tr>
					<td><img src="img/sanpham/${data[i].Pic}" style="width:60px; height:60px"></td>
					<td><a href="product-detail.php?id=${data[i].ID}">${data[i].Name}</a></td>
					<td>${data[i].Quantity}</td>
					<td>${formatPricetoPrint(Number(data[i].Price))}₫</td>
					<td>${formatPricetoPrint(data[i].Price*data[i].Quantity)}₫</td>
                </tr>`
			}
			document.getElementById("bill-product").innerHTML = string;

		}
	});
}