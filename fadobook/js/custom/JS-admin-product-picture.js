function uploadImage(){
	var images = document.getElementById("images");
	var productID = document.getElementById("productID");
	var form_data = new FormData();
	
	 // Read selected files
	var totalfiles = images.files.length;
	if(totalfiles == 0){
		alert("Hãy chọn một ảnh!");
		images.focus();
		return;
	} else {
		for (var i = 0; i < totalfiles; i++) {
			var fileName = images.files[i].name;
			var extension = fileName.split('.').pop().toLowerCase();
			if ($.inArray(extension, ['png','jpeg', 'jpg']) == -1) {
			  alert("File ảnh không hợp lệ! Ảnh phải là file PNG, JPEG, JPG");
			  images.focus();
			  return;
			}
			var fileSize = images.files[i].size / 1024 / 1024; // in MB
			if (fileSize > 2) {
				alert('Ảnh '+fileName+' vượt quá kích thước cho phép (2MB)');
				images.focus();
				return;
			}
			form_data.append("files[]", images.files[i]);
		}
	}
	form_data.append('action','uploadImage');
	form_data.append('productID',productID.value);
	
	$.ajax({
		url: '../php/PHP-admin-product.php', 
		type: 'post',
		data: form_data,
		dataType: 'text',
		contentType: false,
		processData: false,
		success: function (response) {
			var data = JSON.parse(response);
			var str ="";
			for(var i = 0; i < data.length; i++) {
				str +="<div class='picture-container'>"+
					"<img src='../img/sanpham/"+data[i].Image+"' style='width:250px; border: 1px solid rgba(0, 0, 0, .1)'>"+
					"<div class='bg-opacity'>"+
						"<input type='button' value='Xóa ảnh' class='btn bg-danger text-white' onclick='deleteImage("+data[i].ID+")'></input>"+
					"</div>"+
				"</div>";
			}
			document.getElementById("allPictures").innerHTML = str;
			hinh.value="";
		}
		
	});	
}
function deleteImage(id){
	var r = confirm("Bạn có chắc muốn xóa hình ảnh này không?");
	if( r == true) {
		var form_data = new FormData();
		var productID = document.getElementById("productID");
		form_data.append('productID',productID.value);
		form_data.append('id',id);
		form_data.append('action','deleteImage');
		
		jQuery.ajax({
			type: "POST",
			url: '../php/PHP-admin-product.php',
			dataType: 'text',
			cache: false,
			contentType: false,
			processData: false,
			data : form_data,
			success: function (response) {
				var data = JSON.parse(response);
				var str ="";
				for(var i = 0; i < data.length; i++) {
					str +="<div class='picture-container'>"+
						"<img src='../img/sanpham/"+data[i].Image+"' style='width:250px; border: 1px solid rgba(0, 0, 0, .1)'>"+
						"<div class='bg-opacity'>"+
							"<input type='button' value='Xóa ảnh' class='btn bg-danger text-white' onclick='deleteImage("+data[i].ID+")'></input>"+
						"</div>"+
					"</div>";
				}
				document.getElementById("allPictures").innerHTML = str;
			}
		});
	} else {}
}
