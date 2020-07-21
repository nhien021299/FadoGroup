function addType(){
	var typeName = document.getElementById("type-form").typeName;
	var typeID = document.getElementById("type-form").typeID;
	
	var form_data = new FormData();
	
	if (typeID.value==""){
		alert("Mã loại sản phẩm không được để trống!");
		typeID.focus();
		return;
	}

	if (typeName.value==""){
		alert("Tên loại sản phẩm không được để trống!");
		typeName.focus();
		return;
	}
	
	form_data.append('action','addType');
	form_data.append('typeID',typeID.value);
	form_data.append('typeName',typeName.value);
	
	jQuery.ajax({
		type: "POST",
		url: '../php/PHP-admin-type.php',
		dataType: 'text',
		cache: false,
		contentType: false,
		processData: false,
		data : form_data,
		success:function(res){
			switch(res){
				case "0":{
					alert("Thêm loại sản phẩm thành công!");
					document.getElementById("type-form").reset();
					window.location.href = "type.php";
				}break;
			}
		}
	});
	
}

function editType(){
	var typeName = document.getElementById("type-form").typeName;
	var newTypeID = document.getElementById("type-form").typeID;
	var oldTypeID = document.getElementById("type-form").code;
	
	var form_data = new FormData();
	
	if (typeID.value==""){
		alert("Mã loại sản phẩm không được để trống!");
		typeID.focus();
		return;
	}

	if (typeName.value==""){
		alert("Tên loại sản phẩm không được để trống!");
		typeName.focus();
		return;
	}
	
	form_data.append('action','editType');
	form_data.append('newTypeID',newTypeID.value);
	form_data.append('typeName',typeName.value);
	form_data.append('oldTypeID',oldTypeID.value);
	
	jQuery.ajax({
		type: "POST",
		url: '../php/PHP-admin-type.php',
		dataType: 'text',
		cache: false,
		contentType: false,
		processData: false,
		data : form_data,
		success:function(res){
			switch(res){
				case "0":{
					alert("Sửa loại sản phẩm thành công!");
					document.getElementById("type-form").reset();
					window.location.href = "type.php";
				}break;
			}
		}
	});
	
}
function deleteType(typeID){
	var r = confirm("Bạn có chắc chắn muốn xóa loại sản phẩm này không?");
	if (r == true) {
		var form_data = new FormData();
		form_data.append('typeID',typeID);
		form_data.append('action','deleteType');
		
		jQuery.ajax({
			type: "POST",
			url: '../php/PHP-admin-type.php',
			dataType: 'text',
			cache: false,
			contentType: false,
			processData: false,
			data : form_data,
			success:function(res){
				switch(res){
					case "0":{
						alert("Xóa loại sản phẩm thành công!");
						if(window.location.href.includes("typeform.php")){
							document.getElementById("type-form").reset();
							window.location.href = "type.php";
						} else {
							location.reload();
						}
					}break;
				}
			}
		});
	} else {}
}