function addCategory(){
	var categoryName = document.getElementById("category-form").categoryName;
	var categoryID = document.getElementById("category-form").categoryID;
	
	var form_data = new FormData();
	
	if (categoryID.value==""){
		alert("Mã thể loại không được để trống!");
		categoryID.focus();
		return;
	}

	if (categoryName.value==""){
		alert("Tên thể loại không được để trống!");
		categoryName.focus();
		return;
	}
	
	form_data.append('action','addCategory');
	form_data.append('categoryID',categoryID.value);
	form_data.append('categoryName',categoryName.value);
	
	jQuery.ajax({
		type: "POST",
		url: '../php/PHP-admin-category.php',
		dataType: 'text',
		cache: false,
		contentType: false,
		processData: false,
		data : form_data,
		success:function(res){
			switch(res){
				case "0":{
					alert("Thêm thể loại thành công!");
					document.getElementById("category-form").reset();
					window.location.href = "category.php";
				}break;
			}
		}
	});
	
}

function editCategory(){
	var categoryName = document.getElementById("category-form").categoryName;
	var newCategoryID = document.getElementById("category-form").categoryID;
	var oldCategoryID = document.getElementById("category-form").code;
	
	var form_data = new FormData();
	
	if (newCategoryID.value==""){
		alert("Mã thể loại không được để trống!");
		newCategoryID.focus();
		return;
	}

	if (categoryName.value==""){
		alert("Tên thể loại không được để trống!");
		categoryName.focus();
		return;
	}
	
	form_data.append('action','editCategory');
	form_data.append('newCategoryID',newCategoryID.value);
	form_data.append('categoryName',categoryName.value);
	form_data.append('oldCategoryID',oldCategoryID.value);
	
	jQuery.ajax({
		type: "POST",
		url: '../php/PHP-admin-category.php',
		dataType: 'text',
		cache: false,
		contentType: false,
		processData: false,
		data : form_data,
		success:function(res){
			switch(res){
				case "0":{
					alert("Sửa thể loại thành công!");
					document.getElementById("category-form").reset();
					window.location.href = "category.php";
				}break;
			}
		}
	});
	
}
function deleteCategory(categoryID){
	var r = confirm("Bạn có chắc chắn muốn xóa thể loại này không?");
	if (r == true) {
		var form_data = new FormData();
		form_data.append('categoryID',categoryID);
		form_data.append('action','deleteCategory');
		
		jQuery.ajax({
			type: "POST",
			url: '../php/PHP-admin-category.php',
			dataType: 'text',
			cache: false,
			contentType: false,
			processData: false,
			data : form_data,
			success:function(res){
				switch(res){
					case "0":{
						alert("Xóa thể loại thành công!");
						if(window.location.href.includes("categoryform.php")){
							document.getElementById("category-form").reset();
							window.location.href = "category.php";
						} else {
							location.reload();
						}
					}break;
				}
			}
		});
	} else {}
}