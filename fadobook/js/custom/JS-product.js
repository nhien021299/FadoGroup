function formatPricetoPrint(a) {
	a=a.toLocaleString();
	a=a.split(',').join('.');
	return a;
}

function paginationGetData(numOfItems,currentPage){
	var sortBasic = document.getElementById('sortBasic').value;
	var sortType = document.getElementById('sortType').value;
	var sortCategory = document.getElementById('sortCategory').value;

	let form_data = new FormData();
	form_data.append('action','paginationGetData');
	form_data.append('sortBasic',sortBasic);
	form_data.append('sortType',sortType);
	form_data.append('sortCategory',sortCategory);
	form_data.append('numOfItems',parseInt(numOfItems));
	form_data.append('currentPage',parseInt(currentPage));

	paginationGetPages(numOfItems,currentPage);

	$.ajax({
		url: './php/PHP-product.php', 
		type: 'post',
		data: form_data,
		dataType: 'text',
		contentType: false,
		processData: false,
		success: function (response) {
			var getData = JSON.parse(response);
			var string = "";
			for( var i = 0; i < getData.length; i++){
				string +=`<div class="col-md-3 mb-5">
					<div class="item">
						<div class="product-box common-cart-box">
							<div class="product-img common-cart-img">
								<img src="./img/sanpham/${getData[i].Pic}" alt="product-img" class="img-product" >
								<div class="hover-option">
									<ul class="hover-icon">
										<li><a href="#" onclick='addToCart(${parseInt(getData[i].ID)})'><i class="fa fa-shopping-cart"></i></a></li>
										<li><a href="#quickview-popup" class="quickview-popup-link" onclick='quickView(${parseInt(getData[i].ID)})'><i class="fa fa-eye"></i></a></li>
									</ul>
								</div>
							</div>
							<div class="product-info common-cart-info" style="text-align: center;">
								<a href="product-detail.php?id=${parseInt(getData[i].ID)}" class="cart-name">${getData[i].Name}</a>
								<p class="cart-price">${formatPricetoPrint(parseInt(getData[i].Price))}₫</p>
							</div>
						</div>
					</div>
				</div>`;
			}
			document.getElementById("product-container").innerHTML = string;
			$('.quickview-popup-link').magnificPopup({
				type: 'inline',
				alignTop: false,
				overflowY: 'scroll',
				midClick: true,
				callbacks: {
					open: function () {
						$('body').addClass('zoom_image');
						// Will fire when this exact popup is opened
						if ($(window).width() >= 768) {
							var firstImgHeight = $(".quickview-popup .product_img").height();
							var divWidth = $(".quickview-product-detail").width();
							$(".quickview-popup .product_img").elevateZoom({
								cursor: "crosshair",
								easing: true,
								scrollZoom: true,
								gallery: 'product_gallery',
								zoomWindowOffetx: 30,
								zoomWindowWidth: divWidth,
								zoomWindowHeight: firstImgHeight,
								borderSize: 0,
								galleryActiveClass: "active"
							});
						}
						else {
							$(".quickview-popup .product_img").elevateZoom({
								cursor: "crosshair",
								zoomType: "inner",
								gallery: 'product_gallery',
								galleryActiveClass: "active"
							});
						}
					},
					close: function () {
						// Wait until overflow:hidden has been removed from the html tag
						setTimeout(function () {
							$('body').removeClass('zoom_image');
							$('.zoomContainer:nth-child(2)').remove();
						}, 100)
					}
				}
			});
		}
	});	
}

function paginationGetPages(numOfItems,currentPage){
	var sortBasic = document.getElementById('sortBasic').value;
	var sortType = document.getElementById('sortType').value;
	var sortCategory = document.getElementById('sortCategory').value;
	

	let form_data = new FormData();
	form_data.append('action','paginationGetPages');
	form_data.append('sortCategory',sortCategory);
	form_data.append('sortBasic',sortBasic);
	form_data.append('sortType',sortType);

	$.ajax({
		url: './php/PHP-product.php', 
		type: 'post',
		data: form_data,
		dataType: 'text',
		contentType: false,
		processData: false,
		success: function (response) {
			var numOfPage = Math.ceil(response/numOfItems);
			if(numOfPage > 1){
				var string = "<ul class='pagination'><li>";
				if(currentPage != 1 ){
					string +=`<a href="#" onclick='paginationGetData(${numOfItems},1)' title="Trang đầu">&lt;&lt;</a>`;
					string +=`<a href="#" onclick='paginationGetData(${numOfItems},${currentPage-1})' title="Trang trước">&lt;</a>`;
				}		
				for( var i = 1; i <= numOfPage; i++){
					if( i == currentPage ){
						string += `<a href="#" class='pagination-active'>${i}</a>`;
					} else {
						string += `<a href="#" onclick='paginationGetData(${numOfItems},${i})'>${i}</a>`;
					}
				}
				if(currentPage != numOfPage){
					string +=`<a href="#" onclick='paginationGetData(${numOfItems},${currentPage+1})' title="Trang sau">&gt;</a>`;
					string +=`<a href="#" onclick='paginationGetData(${numOfItems},${numOfPage})' title="Trang cuối">&gt;&gt;</a>`;
				}
				string +="</li></ul>";
				document.getElementById("pagination-section").innerHTML=string;
			}
			
		}
	});	
}
