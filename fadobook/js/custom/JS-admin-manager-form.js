function addManager(){
	var ID = document.getElementById("manager-form").ID;
	var password = document.getElementById("manager-form").password;
	
	var form_data = new FormData();
	
	if (ID.value==""){
		alert("Tài khoản không được để trống!");
		ID.focus();
		return;
	} else {
		var format = /^\w{6,12}$/igm;
		if(format.test(ID.value)==false){
			alert("Tài khoản phải từ 6-12 ký tự");
			ID.focus();
			return;	
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
	}
	
	form_data.append('action','addManager');
	form_data.append('ID',ID.value);
	form_data.append('password',password.value);
	
	jQuery.ajax({
		type: "POST",
		url: '../php/PHP-admin-manager.php',
		dataType: 'text',
		cache: false,
		contentType: false,
		processData: false,
		data : form_data,
		success:function(res){
			switch(res){
				case "0":{
					alert("Thêm tài khoản thành công!");
					document.getElementById("manager-form").reset();
					window.location.href = "manager.php";
				}break;
			}
		}
	});
	
}

function editManager(){
	var ID = document.getElementById("manager-form").ID;
	var password = document.getElementById("manager-form").password;
	
	var form_data = new FormData();
	
	if (ID.value==""){
		alert("Tài khoản không được để trống!");
		ID.focus();
		return;
	} else {
		var format = /^\w{6,12}$/igm;
		if(format.test(ID.value)==false){
			alert("Tài khoản phải từ 6-12 ký tự");
			ID.focus();
			return;	
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
	}
	
	form_data.append('action','editManager');
	form_data.append('ID',ID.value);
	form_data.append('password',password.value);
	
	jQuery.ajax({
		type: "POST",
		url: '../php/PHP-admin-manager.php',
		dataType: 'text',
		cache: false,
		contentType: false,
		processData: false,
		data : form_data,
		success:function(res){
			switch(res){
				case "0":{
					alert("Sửa tài khoản thành công!");
					document.getElementById("manager-form").reset();
					window.location.href = "manager.php";
				}break;
			}
		}
	});
	
}
function deleteManager(ID){
	var r = confirm("Bạn có chắc chắn muốn xóa tài khoản này không?");
	if (r == true) {
		var form_data = new FormData();
		form_data.append('ID',ID);
		form_data.append('action','deleteManager');
		
		jQuery.ajax({
			type: "POST",
			url: '../php/PHP-admin-manager.php',
			dataType: 'text',
			cache: false,
			contentType: false,
			processData: false,
			data : form_data,
			success:function(res){
				switch(res){
					case "0":{
						alert("Xóa tài khoản thành công!");
						if(window.location.href.includes("managerform.php")){
							document.getElementById("manager-form").reset();
							window.location.href = "manager.php";
						} else {
							location.reload();
						}
					}break;
				}
			}
		});
	} else {}
}