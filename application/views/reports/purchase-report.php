<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800"><?php echo $title; ?></h1>

  <form action="" method="GET">
    <div class="form-row">
      <div class="form-group col-md-3">
        <label for="startdate">Start Date</label>
        <input type="text" name="startdate" id="startdate" class="form-control datepicker" placeholder="yyyy-mm-dd" required autocomplete="off" value="<?php echo set_value('startdate'); ?>">
      </div>
      <div class="form-group col-md-3">
        <label for="enddate">End Date</label>
        <input type="text" name="enddate" id="enddate" class="form-control datepicker" placeholder="yyyy-mm-dd" required autocomplete="off" value="<?php echo set_value('enddate'); ?>">
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-1">
        <button type="submit" name="search" id="search" class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
      </div>
      <!-- <div class="form-group col-md-1">
        <a target="__blank" href="" class="btn btn-secondary"><i class="fas fa-print"></i> Print All</a>
      </div> -->
    </div>
  </form>

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
        <table class="table table-bordered" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Order ID</th>
              <th>Supplier Name</th>
              <th>Supplier Phone</th>
              <th>Order Date</th>
              <th>Total Products</th>
              <th>Total Amount</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            if ($data) :
              foreach ($data as $val) : ?>
                <tr>
                  <td><?php echo $no++; ?></td>
                  <td><?php echo $val['id']; ?></td>
                  <td><?php echo $val['supplier_name']; ?></td>
                  <td><?php echo $val['supplier_phone']; ?></td>
                  <td><?php echo date('d M Y', strtotime($val['order_date'])); ?></td>
                  <td><?php echo $val['jumlah']; ?></td>
                  <td><?php echo "Rp. " . number_format($val['net_amount'], 0, ',', '.'); ?></td>
                </tr>
              <?php endforeach; ?>
            <?php else : ?>
              <tr>
                <td colspan="7" style="text-align: center">Data not found !</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
      <div class="row">
        <div class="col-md-12">
          <a target="__blank" href="<?php echo $cetak; ?>" class="btn btn-secondary"><i class="fas fa-print"></i> Print All</a>
        </div>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->