function creatChart(){
	var dateFrom = document.getElementById("dateFrom");
	var dateTo = document.getElementById("dateTo");
	var type = document.getElementById("type");

	productChart(type.value, dateFrom.value, dateTo.value);
	billChart(dateFrom.value, dateTo.value);
}

function productChart(type,dateFrom,dateTo){

	var form_data = new FormData();
	form_data.append('action','productChart');
	form_data.append('dateFrom',dateFrom);
	form_data.append('dateTo',dateTo);
	form_data.append('type',type);

	jQuery.ajax({
		type: "POST",
		url: '../php/PHP-admin-chart.php',
		dataType: 'text',
		cache: false,
		contentType: false,
		processData: false,
		data : form_data,
		success:function(res){
			var getData = JSON.parse(res);
			getData = getData.sort(compareDataPoint);
			var chart = new CanvasJS.Chart("productChartContainer", {
				theme: "light2", // "light1", "light2", "dark1", "dark2"
				exportEnabled: true,
				animationEnabled: true,
				title: {
					text: "Thống kê sản phẩm bán ra"
				  },
				legend:{
					verticalAlign: "center",
					horizontalAlign: "right",
					cursor: "pointer",
					itemclick: explodePie
				},
				data: [{
				  type: "pie",
				  startAngle: 270,
				  toolTipContent: "<b>{label}</b>: {y} sản phẩm",
				  dataPoints: getData
				}]
			  });
			  chart.render();
			var totalMoney = 0;
			var totalQuantity = 0;
			for(var i = 0; i < getData.length; i++){
				totalMoney += getData[i].y * getData[i].Price;
				totalQuantity += parseInt(getData[i].y);
			}
			document.getElementById('total-quantity').innerHTML = totalQuantity + " sản phẩm";
			document.getElementById('total-money').innerHTML = formatPricetoPrint(totalMoney) + "₫";
		}
	});
}

function billChart(dateFrom,dateTo){

	var form_data = new FormData();
	form_data.append('action','billChart');
	form_data.append('dateFrom',dateFrom);
	form_data.append('dateTo',dateTo);

	jQuery.ajax({
		type: "POST",
		url: '../php/PHP-admin-chart.php',
		dataType: 'text',
		cache: false,
		contentType: false,
		processData: false,
		data : form_data,
		success:function(res){
			var getData = JSON.parse(res);
			getData = getData.sort(compareDataPoint);
			var chart = new CanvasJS.Chart("billChartContainer", {
				theme: "light2", // "light1", "light2", "dark1", "dark2"
				exportEnabled: true,
				animationEnabled: true,
				title: {
					text: "Thống kê đơn hàng"
				  },
				legend:{
					verticalAlign: "center",
					horizontalAlign: "right",
					cursor: "pointer",
					itemclick: explodePie
				},
				data: [{
				  type: "pie",
				  startAngle: 270,
				  toolTipContent: "<b>{label}</b>: {y} đơn hàng",
				  dataPoints: getData
				}]
			  });
			  chart.render();
			var totalBill = 0;
			for(var i = 0; i < getData.length; i++){
				totalBill += parseInt(getData[i].y);
			}
			document.getElementById('total-bill').innerHTML = totalBill + " đơn hàng";
		}
	});
}
function explodePie (e) {
    if(typeof (e.dataSeries.dataPoints[e.dataPointIndex].exploded) === "undefined" || !e.dataSeries.dataPoints[e.dataPointIndex].exploded) {
        e.dataSeries.dataPoints[e.dataPointIndex].exploded = true;
    } else {
        e.dataSeries.dataPoints[e.dataPointIndex].exploded = false;
    }
    e.chart.render();

}
function formatPricetoPrint(a){
	a=a.toLocaleString()
	a=a.split(',').join('.');
	return a;
}
function compareDataPoint(dataPoint1, dataPoint2) {
    if (dataPoint1.y < dataPoint2.y){return -1}
    if ( dataPoint1.y > dataPoint2.y){return 1}
    return 0;
}