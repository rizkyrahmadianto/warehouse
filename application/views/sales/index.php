<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800"><?php echo $title; ?></h1>


  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div class="d-sm-flex mt-4">
      <a href="<?php echo base_url() ?>sales/neworder" class="btn btn-success"><i class="fa fa-plus"></i> New Order</a>
    </div>
    <div class="d-sm-flex mt-4">
      <!-- search form -->
      <form action="" method="post">
        <div class="input-group">
          <input type="text" name="search" id="search" class="form-control" placeholder="Search..." autocomplete="off" autofocus>
          <div class="input-group-append">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
          </div>
        </div>
      </form>
      <!-- /.search form -->
    </div>
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
      <div class="table-responsive">
        <table class="table table-bordered" id="table" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Order ID</th>
              <th>Customer Name</th>
              <th>Customer Phone</th>
              <th>Order Date</th>
              <th>Total Products</th>
              <th>Total Amount</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($sales) :
              foreach ($sales as $s) : ?>
                <tr>
                  <td><?php echo $s['id']; ?></td>
                  <td><?php echo $s['customer_name']; ?></td>
                  <td><?php echo $s['customer_phone']; ?></td>
                  <td><?php echo date('d M Y', strtotime($s['order_date'])); ?></td>
                  <td><?php echo $s['jumlah']; ?></td>
                  <td><?php echo "Rp. " . number_format($s['net_amount'], 0, ',', '.'); ?></td>
                  <td>
                    <a href="<?php echo base_url() ?>sales/editorder/<?php echo $s['id'] ?>" class="btn btn-sm btn-warning btn-circle"><i class="fas fa-pencil-alt"></i></a>
                    <a target="__blank" href="<?php echo base_url() ?>sales/printorder/<?php echo $s['id'] ?>" class="btn btn-sm btn-secondary btn-circle"><i class="fas fa-print"></i></a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else : ?>
              <tr>
                <td colspan="8" style="text-align: center">Data not found !</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
      <div class="row">
        <div class="col-md-12">
          <?php echo $pagination; ?>
        </div>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->