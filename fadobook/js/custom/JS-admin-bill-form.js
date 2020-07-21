function editStatus(){
	var id = document.getElementById("id");
	var status = document.getElementById("status");
	
	var form_data = new FormData();
	
	if (status.value == "3"){
		var ask = confirm("Bạn có chắc muốn hủy đơn hàng này? Sau khi hủy sẽ không thể hoàn lại");
		if (ask == false) {
			return;
		} 
	} else {
		var ask = confirm("Bạn có chắc muốn thay đổi trạng thái đơn hàng này?");
		if (ask == false) {
			return;
		} 
	}
	


	form_data.append('action','editStatus');
	form_data.append('id',id.value);
	form_data.append('status',status.value);

	jQuery.ajax({
		type: "POST",
		url: '../php/PHP-admin-bill.php',
		dataType: 'text',
		cache: false,
		contentType: false,
		processData: false,
		data : form_data,
		success:function(res){
			switch(res){
				case "0":{
					alert("Lưu thông tin thành công!");
					window.location.href = "bill.php";
				}break;
			}
		}
	});
	
}