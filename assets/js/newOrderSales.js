var base_url = "<?php echo base_url(); ?>";

$(document).ready(function () {
	$(".select_group").select2();
	// $("#description").wysihtml5();

	$("#mainOrdersNav").addClass('active');
	$("#addOrderNav").addClass('active');

	// Add new row in the table
	$("#add_row").unbind('click').bind('click', function () {
		var table = $("#product_info_table");
		var count_table_tbody_tr = $("#product_info_table tbody tr").length;
		var row_id = count_table_tbody_tr + 1;

		$.ajax({
			url: 'getTableProductRow/', // base_url + 'Sales/getTableProductRow/'
			type: "POST",
			dataType: "JSON",
			success: function (response) {

				// console.log(reponse.x);
				var html = '<tr id="row_' + row_id + '">' +
					'<td>' +
					'<select class="form-control select_group product" data-row-id="' + row_id + '" id="product_' + row_id + '" name="product[]" style="width:100%;" onchange="getProductData(' + row_id + ')">' +
					'<option value=""></option>';
				$.each(response, function (index, value) {
					html += '<option value="' + value.product_id + '">' + value.product_name + '</option>';
				});

				html += '</select>' +
					'</td>' +
					'<td><input type="number" name="qty[]" id="qty_' + row_id + '" class="form-control" onkeyup="getTotal(' + row_id + ')"></td>' +
					'<td><input type="text" name="rate[]" id="price_' + row_id + '" class="form-control" disabled><input type="hidden" name="price_value[]" id="price_value_' + row_id + '" class="form-control"></td>' +
					'<td><input type="text" name="amount[]" id="amount_' + row_id + '" class="form-control" disabled><input type="hidden" name="amount_value[]" id="amount_value_' + row_id + '" class="form-control"></td>' +
					'<td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(\'' + row_id + '\')"><i class="fas fa-times"></i></button></td>' +
					'</tr>';

				if (count_table_tbody_tr >= 1) {
					$("#product_info_table tbody tr:last").after(html);
				} else {
					$("#product_info_table tbody").html(html);
				}

				$(".product").select2();

			}
		});

		return false;
	});

}); // /document

function getTotal(row = null) {
	if (row) {
		var total = Number($("#price_value_" + row).val()) * Number($("#qty_" + row).val());
		total = total.toFixed(2);
		$("#amount_" + row).val(total);
		$("#amount_value_" + row).val(total);

		subAmount();

	} else {
		alert('no row !! please refresh the page');
	}
}

// get the product information from the server
function getProductData(row_id) {
	var product_id = $("#product_" + row_id).val();
	if (product_id == "") {
		$("#price_" + row_id).val("");
		$("#price_value_" + row_id).val("");

		$("#qty_" + row_id).val("");

		$("#amount_" + row_id).val("");
		$("#amount_value_" + row_id).val("");

	} else {
		$.ajax({
			url: 'getProductValueById/', // base_url + 'Sales/getProductValueById' 
			type: "POST",
			data: {
				product_id: product_id
			},
			dataType: "JSON",
			success: function (response) {
				// setting the price value into the price input field

				$("#price_" + row_id).val(response.price);
				$("#price_value_" + row_id).val(response.price);

				$("#qty_" + row_id).val(1);
				$("#qty_value_" + row_id).val(1);

				var total = Number(response.price) * 1;
				total = total.toFixed(2);
				$("#amount_" + row_id).val(total);
				$("#amount_value_" + row_id).val(total);

				subAmount();
			} // /success
		}); // /ajax function to fetch the product data
	}
}

// calculate the total amount of the order
function subAmount() {
	var service_charge = "<?php echo ($company_data['service_charge_value'] > 0) ? $company_data['service_charge_value'] : 0; ?>";
	var vat_charge = "<?php echo ($company_data['vat_charge_value'] > 0) ? $company_data['vat_charge_value'] : 0; ?>";

	var tableProductLength = $("#product_info_table tbody tr").length;
	var totalSubAmount = 0;
	for (x = 0; x < tableProductLength; x++) {
		var tr = $("#product_info_table tbody tr")[x];
		var count = $(tr).attr('id');
		count = count.substring(4);

		totalSubAmount = Number(totalSubAmount) + Number($("#amount_" + count).val());
	} // /for

	totalSubAmount = totalSubAmount.toFixed(2);

	// sub total
	$("#gross_amount").val(totalSubAmount);
	$("#gross_amount_value").val(totalSubAmount);

	// vat
	var vat = (Number($("#gross_amount").val()) / 100) * vat_charge;
	vat = vat.toFixed(2);
	$("#vat_charge").val(vat);
	$("#vat_charge_value").val(vat);

	// service
	var service = (Number($("#gross_amount").val()) / 100) * service_charge;
	service = service.toFixed(2);
	$("#service_charge").val(service);
	$("#service_charge_value").val(service);

	// total amount
	var totalAmount = (Number(totalSubAmount) + Number(vat) + Number(service));
	totalAmount = totalAmount.toFixed(2);
	// $("#net_amount").val(totalAmount);
	// $("#totalAmountValue").val(totalAmount);

	var discount = $("#discount").val();
	if (discount) {
		var grandTotal = Number(totalAmount) - Number(discount);
		grandTotal = grandTotal.toFixed(2);
		$("#net_amount").val(grandTotal);
		$("#net_amount_value").val(grandTotal);
	} else {
		$("#net_amount").val(totalAmount);
		$("#net_amount_value").val(totalAmount);

	} // /else discount

} // /sub total amount

function removeRow(tr_id) {
	$("#product_info_table tbody tr#row_" + tr_id).remove();
	subAmount();
}
