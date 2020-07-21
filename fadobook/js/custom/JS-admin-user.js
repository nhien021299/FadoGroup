function changeStatus(status, email){
	let form_data = new FormData();
	form_data.append('action','changeStatus');
	form_data.append('email',email);
	form_data.append('status',status);

	jQuery.ajax({
		type: "POST",
		url: '../php/PHP-admin-user.php',
		dataType: 'text',
		cache: false,
		contentType: false,
		processData: false,
		data : form_data,
		success:function(res){
			switch(res){
				case "0":{
					alert("Lưu thông tin thành công!");
					location.reload();
				}break;
				case "1":{
					alert("Đã xảy ra lỗi");
					location.reload();
				}break;
			}
		}
	});
	
}