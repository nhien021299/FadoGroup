function addBrand(){
	var tenhang = document.getElementById("brand-form").tenhang;
	var mahang = document.getElementById("brand-form").mahang;
	
	var form_data = new FormData();
	
	if (mahang.value==""){
		alert("Mã hãng không được để trống!");
		malsp.focus();
		return;
	}

	if (tenhang.value==""){
		alert("Tên hãng không được để trống!");
		tenlsp.focus();
		return;
	}
	
	form_data.append('action','addBrand');
	form_data.append('mahang',mahang.value);
	form_data.append('tenhang',tenhang.value);
	
	jQuery.ajax({
		type: "POST",
		url: '../php/PHP-admin-brand.php',
		dataType: 'text',
		cache: false,
		contentType: false,
		processData: false,
		data : form_data,
		success:function(res){
			switch(res){
				case "0":{
					alert("Thêm hãng thành công!");
					document.getElementById("brand-form").reset();
					window.location.href = "brand.php";
				}break;
			}
		}
	});
	
}

function editBrand(){
	var tenhang = document.getElementById("brand-form").tenhang;
	var mahang = document.getElementById("brand-form").mahang;
	var mahangCu = document.getElementById("brand-form").code;
	
	var form_data = new FormData();
	
	if (mahang.value==""){
		alert("Mã hãng không được để trống!");
		malsp.focus();
		return;
	}

	if (tenhang.value==""){
		alert("Tên hãng không được để trống!");
		tenlsp.focus();
		return;
	}
	
	form_data.append('action','editBrand');
	form_data.append('mahang',mahang.value);
	form_data.append('tenhang',tenhang.value);
	form_data.append('mahangCu',mahangCu.value);
	
	jQuery.ajax({
		type: "POST",
		url: '../php/PHP-admin-brand.php',
		dataType: 'text',
		cache: false,
		contentType: false,
		processData: false,
		data : form_data,
		success:function(res){
			switch(res){
				case "0":{
					alert("Sửa hãng thành công!");
					document.getElementById("brand-form").reset();
					window.location.href = "brand.php";
				}break;
			}
		}
	});
	
}
function deleteBrand(mahang){
	var r = confirm("Bạn có chắc chắn muốn xóa hãng này không?");
	if (r == true) {
		var form_data = new FormData();
		form_data.append('mahang',mahang);
		form_data.append('action','deleteBrand');
		
		jQuery.ajax({
			type: "POST",
			url: '../php/PHP-admin-brand.php',
			dataType: 'text',
			cache: false,
			contentType: false,
			processData: false,
			data : form_data,
			success:function(res){
				switch(res){
					case "0":{
						alert("Xóa hãng thành công!");
						if(window.location.href.includes("brandform.php")){
							document.getElementById("brand-form").reset();
							window.location.href = "brand.php";
						} else {
							location.reload();
						}
					}break;
				}
			}
		});
	} else {}
}