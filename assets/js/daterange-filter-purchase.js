var baseUrl = "<?php echo base_url(); ?>";
var startDate = $("#startdate").val();
var endDate = $("#enddate").val();

$(document).ready(function() {
	$(".input-daterange").datepicker({
		todayBtn: "linked",
		format: "yyyy-mm-dd",
		autoclose: true
	});

	// $("#table-purchase").DataTable({
	// 	searching: false
	// });

	function fetch_data(startDate = "", endDate = "") {
		$("#table-purchase").DataTable({
			processing: true,
			serverSide: true,
			order: [],
			ajax: {
				url: baseUrl + "Purchase_Report/search",
				type: "POST",
				data: {
					startdate: startDate,
					enddate: endDate
				},
				success: function(data) {
					$("#table-purchase").html(data);
				}
			},
			columns: [
				{ data: "id" },
				{ data: "supplier_name" },
				{ data: "supplier_phone" },
				{ data: "order_date" },
				{ data: "total" },
				{ data: "net_amount" }
			]
		});
	}

	$("#search").click(function() {
		if (startDate != "" && endDate != "") {
			$("#table-purchase")
				.DataTable()
				.destroy();
			fetch_data(startDate, endDate);
		} else {
			alert("Both Date is required and press Search to show !");
		}
	});
});
