<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Warehouse | <?php echo $title; ?></title>

  <link rel="shortcut icon" type="image/png" href="<?= base_url(); ?>assets/img/logo/warehouse.png">
  <!-- Custom fonts for this template-->
  <link href="<?php echo base_url(); ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">


  <!-- Custom styles for this template-->
  <link href="<?php echo base_url(); ?>assets/css/sb-admin-2.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/css/select2.min.css" rel="stylesheet">

  <!-- Bootstrap core JavaScript-->
  <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?php echo base_url(); ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?php echo base_url(); ?>assets/js/sb-admin-2.min.js"></script>

  <!-- Custom Script -->
  <script src="<?php echo base_url(); ?>assets/sweet_alert/dist/sweetalert2.all.min.js"></script>
</head>

<body onload="window.print();">
  <div class="container">
    <div class="card">
      <div class="card-header">
        Invoice
        <strong><?php echo $order_date; ?></strong>
        <!-- <span class="float-right"> <strong>Status:</strong> -</span> -->
        <span class="float-right"> <strong>BILL ID:</strong> <?php echo $order_data['id'] ?></span>
      </div>
      <div class="card-body">
        <div class="row mb-4">
          <div class="col-sm-6">
            <h6 class="mb-3">From:</h6>
            <div>
              <strong><?php echo $supplier_info['supplier_name']; ?></strong>
            </div>
            <div><?php echo $supplier_info['supplier_address']; ?></div>
            <div><?php echo $supplier_info['supplier_phone']; ?></div>
          </div>

          <div class="col-sm-6">
            <h6 class="mb-3">To:</h6>
            <div>
              <strong><?php echo $company_info['company_name'] ?></strong>
            </div>
            <div><?php echo $company_info['address'] ?></div>
            <div><?php echo $company_info['phone'] ?></div>
          </div>



        </div>

        <div class="table-responsive-sm">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Amount</th>
              </tr>
            </thead>
            <tbody>
              <?php echo $show_detail; ?>
            </tbody>
          </table>
        </div>
        <div class="row">
          <div class="col-lg-4 col-sm-5">

          </div>

          <div class="col-lg-4 col-sm-5 ml-auto">
            <table class="table table-clear">
              <tbody>
                <tr>
                  <td class="left">
                    <strong>Ship Amount:</strong>
                  </td>
                  <td class="right"><?php echo $order_data['ship_amount'] ?></td>
                </tr>

                <tr>
                  <td class="left">
                    <strong>Tax Amount:</strong>
                  </td>
                  <td class="right"><?php echo $order_data['tax_amount'] ?></td>
                </tr>

                <tr>
                  <td class="left">
                    <strong>Discount:</strong>
                  </td>
                  <td class="right"><?php echo $order_data['discount'] ?></td>
                </tr>

                <tr>
                  <td class="left">
                    <strong>Net Amount:</strong>
                  </td>
                  <td class="right">
                    <strong><?php echo $order_data['net_amount'] ?></strong>
                  </td>
                </tr>
              </tbody>
            </table>

          </div>

        </div>

      </div>
    </div>
  </div>
</body>

</html>