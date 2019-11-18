<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="mb-4 col-md-6">
    <h1 class="h3 mb-2 text-gray-800"><?php echo $title; ?></h1>
  </div>

  <section class="content-header">
    <div class="row">
      <div class="col-lg-12">
        <?php if ($this->session->flashdata('success')) { ?>
          <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Alert!</h4>
            <?php echo $this->session->flashdata('success'); ?>
          </div>
        <?php } else if ($this->session->flashdata('error')) { ?>
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-ban"></i> Alert!</h4>
            <?php echo $this->session->flashdata('error'); ?>
          </div>
        <?php } ?>
      </div>
    </div>
  </section>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-body">
      <form action="" method="POST">
        <div class="col-md-6 col-xs-12">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="supplier">Supplier</label>
              <select name="supplier" id="supplier" class="form-control select_supplier supplier" onchange="getSupplierData()" required>
                <option value=""></option>
                <?php foreach ($supplier as $s) : ?>
                  <?php if ($s['supplier_id'] == $detailsupplier['supplier_id']) : ?>
                    <option value="<?php echo $s['supplier_id'] ?>" selected><?php echo $s['supplier_name'] ?></option>
                  <?php else : ?>
                    <option value="<?php echo $s['supplier_id'] ?>"><?php echo $s['supplier_name'] ?></option>
                  <?php endif; ?>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label for="order_date">Order Date</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                </div>
                <input type="date" class="form-control" name="order_date" id="order_date" placeholder="Date Order.." value="<?php echo $detailsupplier['order_date']; ?>" required>
              </div>
            </div>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-bordered" id="product_info_table" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th style="width:40%">Product</th>
                <th style="width:20%">Unit Price (Rp.)</th>
                <th style="width:10%">Quantity</th>
                <th style="width:20%">Amount</th>
                <th style="width:10%">
                  <button type="button" id="add_row" name="add_row" class="btn btn-primary btn-sm add_row"> <i class="fas fa-plus"></i></i> </button>
                </th>
              </tr>
            </thead>
            <tbody>
              <?php if (isset($order_data['order_detail'])) : ?>
                <?php $i = 1; ?>
                <?php foreach ($order_data['order_detail'] as $key => $val) : ?>
                  <tr id="row_<?php echo $i; ?>">
                    <td>
                      <select name="product[]" id="product_<?php echo $i; ?>" class="form-control select_group product" data-row-id="row_<?php echo $i; ?>" style="width: 100%;" onchange="getProductData(<?php echo $i; ?>)" required>
                        <option value=""></option>
                        <?php foreach ($product as $p) : ?>
                          <?php if ($val['product_id'] == $p['product_id']) : ?>
                            <option value="<?php echo $p['product_id'] ?>" selected><?php echo $p['product_name'] ?></option>
                          <?php else : ?>
                            <option value="<?php echo $p['product_id'] ?>"><?php echo $p['product_name'] ?></option>
                          <?php endif; ?>
                        <?php endforeach; ?>
                      </select>
                    </td>
                    <td>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><b>Rp</b></span>
                        </div>
                        <input type="text" name="price[]" id="price_<?php echo $i; ?>" class="form-control" autocomplete="off" onkeyup="getTotal(<?php echo $i; ?>); numberFormat(this)" value="<?php echo $val['unit_price'] ?>">
                      </div>
                    </td>
                    <td>
                      <input type="text" name="qty[]" id="qty_<?php echo $i; ?>" class="form-control" required onkeyup="getTotal(<?php echo $i; ?>); numberFormat(this)" value="<?php echo $val['qty']; ?>">
                    </td>
                    <td>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><b>Rp</b></span>
                        </div>
                        <input type="text" name="amount[]" id="amount_<?php echo $i; ?>" class="form-control" disabled autocomplete="off" value="<?php echo $val['amount'] ?>">
                        <input type="hidden" name="amount_value[]" id="amount_value_<?php echo $i; ?>" class="form-control" autocomplete="off" value="<?php echo $val['amount'] ?>">
                      </div>
                    </td>
                    <td>
                      <button type="button" name="remove" id="remove" class="btn btn-danger btn-sm" onclick="removeRow('1')"><i class="fas fa-times"></i></button>
                    </td>
                  </tr>
                  <?php $i++; ?>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <div class="col-md-3 col-xs-12">
          <div class="form-group">
            <label for="gross_amount">Gross Amount</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><b>Rp</b></span>
              </div>
              <input type="text" class="form-control" id="gross_amount" name="gross_amount" disabled autocomplete="off" value="<?php echo $order_data['order']['gross_amount'] ?>">
            </div>
            <input type="hidden" class="form-control" id="gross_amount_value" name="gross_amount_value" autocomplete="off" value="<?php echo $order_data['order']['gross_amount'] ?>">
          </div>
          <div class="form-group">
            <label for="ship_amount">Ship Amount</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><b>Rp</b></span>
              </div>
              <input type="text" class="form-control" id="ship_amount" name="ship_amount" onkeyup="subAmount(); numberFormat(this)" placeholder="Ship Amount.." value="<?php echo $order_data['order']['ship_amount'] ?>">
            </div>
          </div>
          <div class="form-group">
            <label for="tax_charge">Tax %</label>
            <div class="input-group">
              <input type="text" class="form-control" id="tax_charge" name="tax_charge" onkeyup="subAmount(); numberFormat(this)" placeholder="Tax.." value="<?php echo $order_data['order']['tax_amount'] ?>">
              <div class="input-group-append">
                <span class="input-group-text"><i class="fas fa-percentage"></i></span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="discount">Discount %</label>
            <div class="input-group">
              <input type="text" class="form-control" id="discount" name="discount" placeholder="Discount..." onkeyup="subAmount(); numberFormat(this)" value="<?php echo $order_data['order']['discount'] ?>">
              <div class="input-group-append">
                <span class="input-group-text"><i class="fas fa-percentage"></i></span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="net_amount">Net Amount</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><b>Rp</b></span>
              </div>
              <input type="text" class="form-control" id="net_amount" name="net_amount" disabled autocomplete="off" value="<?php echo $order_data['order']['net_amount'] ?>">
              <input type="hidden" class="form-control" id="net_amount_value" name="net_amount_value" autocomplete="off" value="<?php echo $order_data['order']['net_amount'] ?>">
            </div>
          </div>
        </div>

        <a href="<?php echo base_url(); ?>purchase" class="btn btn-secondary">Back</a>
        <input type="submit" name="save" value="Update Order" class="btn btn-success pull-right">
      </form>
    </div>
  </div>

</div>
<!-- /.container-fluid -->

<script type="text/javascript">
  var base_url = "<?php echo base_url(); ?>";

  $(document).ready(function(e) {
    $(".select_supplier").select2();
    $(".select_group").select2();
    // $("#description").wysihtml5();

    $("#mainOrdersNav").addClass('active');
    $("#addOrderNav").addClass('active');
    // Add Row
    $("#add_row").click(function(e) {
      var table = $("#product_info_table");
      var count_table_tbody_tr = $("#product_info_table tbody tr").length;
      var row_id = count_table_tbody_tr + 1;
      var html = '';

      $.ajax({
        url: base_url + 'Purchase/getTableProductRow/', // base_url + 'Sales/getTableProductRow/'
        type: 'POST',
        dataType: 'JSON',
        success: function(response) {
          html = '<tr id="row_' + row_id + '">' +
            '<td>' +
            '<select class="form-control select_group product" data-row-id="' + row_id + '" id="product_' + row_id + '" name="product[]" style="width:100%;" onchange="getProductData(' + row_id + ')">' +
            '<option value=""></option>';
          $.each(response, function(index, value) {
            html += '<option value="' + value.product_id + '">' + value.product_name + '</option>';
          });
          html += '</select></td>';
          // html += '<td><input name="product[]" id="product_' + row_id + '" class="form-control product" style="width: 100%;" required></td>';
          html += '<td><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><b>Rp</b></span></div><input type="text" name="price[]" id="price_' + row_id + '" class="form-control" onkeyup="getTotal(' + row_id + '); numberFormat(this)" required autocomplete="off"></div></td>';
          html += '<td><input type="text" name="qty[]" id="qty_' + row_id + '" class="form-control qty" required onkeyup="getTotal(' + row_id + '); numberFormat(this)"></td>';
          html += '<td><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><b>Rp</b></span></div><input type="text" name="amount[]" id="amount_' + row_id + '" class="form-control amount" disabled autocomplete="off"><input type="hidden" name="amount_value[]" id="amount_value_' + row_id + '" class="form-control"></div></td>';
          html += '<td><button type="button" name="remove" id="remove" class="btn btn-danger btn-sm"  onclick="removeRow(\'' + row_id + '\')"><i class="fas fa-times"></i></button></td>';
          html += '</tr>';
          // $("#product_info_table").append(html);

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
    // remove
    // $(document).on('click', '#remove', function(e) {
    //   $(this).closest('tr').remove();
    // });
  }); // /document

  function numberFormat(element) {
    element.value = element.value.replace(/[^0-9]+/g, "");
  }

  function getSupplierData() {
    var supplier_id = $('#supplier').val();
    if (supplier_id == "") {
      $('#phone').val("");
      $('#address').val("");
    } else {
      $.ajax({
        url: base_url + 'Purchase/getSupplierValueById',
        type: 'POST',
        data: {
          supplier_id: supplier_id
        },
        dataType: 'JSON',
        success: function(response) {
          $("#phone").val(response.supplier_phone);
          $("#address").val(response.supplier_address);
          $(".supplier").select2();
        }
      });
      return false;
    }
  }

  function getTotal(row = null) {
    if (row) {
      var total = Number($("#price_" + row).val()) * Number($("#qty_" + row).val());
      total = total.toFixed();
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
      // $("#price_value_" + row_id).val("");

      $("#qty_" + row_id).val("");

      $("#amount_" + row_id).val("");
      $("#amount_value_" + row_id).val("");

    } else {
      $.ajax({
        url: base_url + 'Purchase/getProductValueById', // base_url + 'Sales/getProductValueById' 
        type: 'POST',
        data: {
          product_id: product_id
        },
        dataType: 'JSON',
        success: function(response) {
          // setting the price value into the price input field

          $("#price_" + row_id).val(response.price);
          // $("#price_value_" + row_id).val(response.price);

          $("#qty_" + row_id).val(1);
          $("#qty_value_" + row_id).val(1);

          var total = Number(response.price) * 1;
          total = total.toFixed();
          $("#amount_" + row_id).val(total);
          $("#amount_value_" + row_id).val(total);

          subAmount();
        } // /success
      }); // /ajax function to fetch the product data
    }
  }

  // calculate the total amount of the order
  function subAmount() {
    var tax_charge = Number($("#tax_charge").val());
    var discount = Number($("#discount").val());
    var ship_amount = Number($("#ship_amount").val());
    var grandTotalSubAmount = 0;

    var tableProductLength = $("#product_info_table tbody tr").length;
    var totalSubAmount = 0;
    for (x = 0; x < tableProductLength; x++) {
      var tr = $("#product_info_table tbody tr")[x];
      var count = $(tr).attr('id');
      count = count.substring(4);

      totalSubAmount = Number(totalSubAmount) + Number($("#amount_" + count).val());
    } // /for

    // totalSubAmount = totalSubAmount.toFixed();
    $("#gross_amount").val(totalSubAmount);
    $("#gross_amount_value").val(totalSubAmount);

    if (ship_amount) {
      grandTotalSubAmount = totalSubAmount + ship_amount;
      grandTotalSubAmount = grandTotalSubAmount.toFixed();
      Number($("#net_amount").val(grandTotalSubAmount));
      Number($("#net_amount_value").val(grandTotalSubAmount));
    } else {
      grandTotalSubAmount = totalSubAmount.toFixed();
      Number($("#net_amount").val(grandTotalSubAmount));
      Number($("#net_amount_value").val(grandTotalSubAmount));
    }
    // totalSubAmount = totalSubAmount.toFixed();

    // tax
    if (tax_charge && discount) {
      var setDiscount = Number(grandTotalSubAmount) * (discount / 100);
      var getDiscount = Number(grandTotalSubAmount) - setDiscount;

      var setTax = (tax_charge / 100) * getDiscount;
      var grandTotal = getDiscount + setTax;
      grandTotal = grandTotal.toFixed();
      $("#net_amount").val(grandTotal);
      $("#net_amount_value").val(grandTotal);

      /* var tax = (Number(totalSubAmount) / 100) * tax_charge;
      tax = tax.toFixed();
      var totalAmount = (Number(totalSubAmount) + Number(tax));
      totalAmount = totalAmount.toFixed();

      var grandTotal = Number(totalAmount) - discount;
      grandTotal = grandTotal.toFixed();
      $("#net_amount").val(grandTotal); */
    } else if (tax_charge) {
      var tax = (Number(grandTotalSubAmount) / 100) * tax_charge;
      // tax = tax.toFixed();
      var totalAmount = (Number(grandTotalSubAmount) + Number(tax));
      totalAmount = totalAmount.toFixed();
      $("#net_amount").val(totalAmount);
      $("#net_amount_value").val(totalAmount);
    } else if (discount) {
      var getDiscount = Number(grandTotalSubAmount) * (discount / 100);
      var grandTotal = Number(grandTotalSubAmount) - getDiscount;
      grandTotal = grandTotal.toFixed();
      $("#net_amount").val(grandTotal);
      $("#net_amount_value").val(grandTotal);
    } else {
      $("#net_amount").val(grandTotalSubAmount);
      $("#net_amount_value").val(grandTotalSubAmount);
    }



    // tax_charge.val(tax);

    // var discount = $("#discount").val();
    /* if (discount) {
      if ($("#tax_charge").val()) {
        var grandTotal = Number(totalAmount) - discount;
        grandTotal = grandTotal.toFixed();
        $("#net_amount").val(grandTotal);
      } else {
        var getDiscount = Number(totalSubAmount) * (discount / 100);
        var grandTotal = Number(totalSubAmount) - getDiscount;
        grandTotal = grandTotal.toFixed();
        $("#net_amount").val(grandTotal);
      }
    }

    $("#net_amount").val(totalSubAmount); */

  } // /sub total amount

  function removeRow(tr_id) {
    $("#product_info_table tbody tr#row_" + tr_id).remove();
    subAmount();
  }
</script>