function addBanner(){
	var link = document.getElementById("banner-form").link;
	var position = document.getElementById("banner-form").position;
	var image = document.getElementById("banner-form").image;
	
	var form_data = new FormData();
	
	if (link.value==""){
		alert("Liên kết banner không được để trống!");
		link.focus();
		return;
	}
	
	if ( image.files.length == 0 ||  image.files.length > 1){
		alert("Xin chọn 1 ảnh");
		image.focus();
		return;
	} else {
		var test_value = image.files[0].name;
		var extension = test_value.split('.').pop().toLowerCase();

		if ($.inArray(extension, ['png','jpeg', 'jpg']) == -1) {
		  alert("File ảnh không hợp lệ! Ảnh phải là file PNG, JPEG, JPG");
		  image.focus();
		  return;
		}
	}
	
	var file_data = document.getElementById("image").files[0];
	
	form_data.append('action','addBanner');
	form_data.append('file', file_data);
	form_data.append('link',link.value);
	form_data.append('position',position.value);
	
	jQuery.ajax({
		type: "POST",
		url: '../php/PHP-admin-banner.php',
		dataType: 'text',
		cache: false,
		contentType: false,
		processData: false,
		data : form_data,
		success:function(res){
			switch(res){
				case "0":{
					alert("Thêm banner thành công!");
					document.getElementById("banner-form").reset();
					window.location.href = "banner.php";
				}break;
			}
		}
	});
	
}

function editBanner(){
	var link = document.getElementById("banner-form").link;
	var position = document.getElementById("banner-form").position;
	var image = document.getElementById("banner-form").image;
	var id = document.getElementById("banner-form").id;
	
	var form_data = new FormData();
	
	if (link.value==""){
		alert("Liên kết banner không được để trống!");
		link.focus();
		return;
	}
	
	if ( image.files.length == 1){
		var test_value = image.files[0].name;
		var extension = test_value.split('.').pop().toLowerCase();
		if ($.inArray(extension, ['png','jpeg', 'jpg']) == -1) {
		  alert("File ảnh không hợp lệ! Ảnh phải là file PNG, JPEG, JPG");
		  image.focus();
		  return;
		}
		var file_data = document.getElementById("image").files[0];
		form_data.append('havePic','true');
	} else {
		var file_data = "";
		form_data.append('havePic','false');
	}
	
	form_data.append('action','editBanner');
	form_data.append('file', file_data);
	form_data.append('link',link.value);
	form_data.append('position',position.value);
	form_data.append('id',id.value);
	
	jQuery.ajax({
		type: "POST",
		url: '../php/PHP-admin-banner.php',
		dataType: 'text',
		cache: false,
		contentType: false,
		processData: false,
		data : form_data,
		success:function(res){
			switch(res){
				case "0":{
					alert("Lưu thông tin thành công!");
					document.getElementById("banner-form").reset();
					window.location.href = "banner.php";
				}break;
			}
		}
	});
	
}
function deleteBanner(id){
	var r = confirm("Bạn có chắc chắn muốn xóa banner này không?");
	if (r == true) {
		var form_data = new FormData();
		form_data.append('id',id);
		form_data.append('action','deleteBanner');
		
		jQuery.ajax({
			type: "POST",
			url: '../php/PHP-admin-banner.php',
			dataType: 'text',
			cache: false,
			contentType: false,
			processData: false,
			data : form_data,
			success:function(res){
				switch(res){
					case "0":{
						alert("Xóa banner thành công!");
						if(window.location.href.includes("bannerform.php")){
							document.getElementById("banner-form").reset();
							window.location.href = "banner.php";
						} else {
							location.reload();
						}
					}break;
				}
			}
		});
	} else {}
}
