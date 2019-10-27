<!DOCTYPE html>
<html>

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

  <div class="container-fluid">
    <section>
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <?php echo $company_info['company_name']; ?>
            <small class="pull-right">Date: <?php echo $order_date; ?></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">

        <div class="col-sm-4 invoice-col">

          <b>Bill ID:</b> <?php echo $order_data['id'] ?><br>
          <b>Name:</b> <?php echo $order_data['customer_name'] ?><br>
          <b>Address:</b> <?php echo $order_data['customer_address'] ?> <br />
          <b>Phone:</b> <?php echo $order_data['customer_phone'] ?>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <div class="table-responsive">
          <table class="table table-bordered" id="table" width="100%" cellspacing="0">
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
      </div>

      <div class="row">
        <div class="table-responsive">
          <table class="table table-borderless" width="100%" cellspacing="0">
            <tr>
              <th style="width: 50%">Gross Amount:</th>
              <td><?php echo $order_data['gross_amount'] ?></td>
            </tr>

            <?php if ($order_data['service_charge'] > 0) : ?>
              <tr>
                <th>Service Charge (<?php echo $order_data['service_charge_rate'] ?>%)</th>
                <td><?php echo $order_data['service_charge'] ?></td>
              </tr>
            <?php endif; ?>

            <?php if ($order_data['vat_charge'] > 0) : ?>
              <tr>
                <th>Vat Charge (<?php echo $order_data['vat_charge_rate'] ?>%)</th>
                <td><?php echo $order_data['vat_charge'] ?></td>
              </tr>
            <?php endif; ?>

            <tr>
              <th>Discount:</th>
              <td><?php echo $order_data['discount'] ?></td>
            </tr>

            <tr>
              <th>Net Amount:</th>
              <td><?php echo $order_data['net_amount'] ?></td>
            </tr>
          </table>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
</body>

</html>