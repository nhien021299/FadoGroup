function login() {
	var id = document.getElementById("login-form").id;
	var password = document.getElementById("login-form").password;

	if (id.value==""){
		alert("Tên đăng nhập không thể để trống!");
		id.focus();
		return;
	}

	if (password.value==""){
		alert("Mật khẩu không thể để trống!");
		password.focus();
		return;
	}

	var form_data = new FormData();
	form_data.append('action','login');
	form_data.append('id',id.value);
	form_data.append('password',password.value);

	jQuery.ajax({
		type: "POST",
		url: '../php/PHP-admin-login.php',
		dataType: 'text',
		cache: false,
		contentType: false,
		processData: false,
		data : form_data,
		success:function(res){
			switch(res){
				case "0":{
					window.location.href = "index.php";
				}break;
				case "1":{
					alert("Tên đăng nhập hoặc mật khẩu không chính xác");
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
		url: '../php/PHP-admin-login.php',
		dataType: 'text',
		cache: false,
		contentType: false,
		processData: false,
		data : form_data,
		success:function(res){
			
		}
	});
}