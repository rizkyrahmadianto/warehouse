<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="mb-4 col-md-6 mx-auto">
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
  <div class="card shadow mb-4 col-md-6 mx-auto">
    <div class="card-body">
      <form action="" method="post" enctype="multipart/form-data">

        <div class="form-group">
          <label for="">Customer Name</label>
          <input type="hidden" class="form-control" readonly value="<?= $id['customer_id'] ?>" name="id">
          <input type="text" class="form-control" id="name" name="name" placeholder="Enter Customer's Name.." value="<?= $id['customer_name']; ?>">
          <small class="form-text text-danger"><?= form_error('name'); ?></small>
        </div>

        <div class="form-group">
          <label for="">Email</label>
          <input type="text" class="form-control" id="email" name="email" placeholder="Email.." readonly value="<?= $id['customer_email']; ?>">
          <small class="form-text text-danger"><?= form_error('email'); ?></small>
        </div>

        <div class="form-group">
          <label for="">Phone</label>
          <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number.." value="<?= $id['customer_phone']; ?>">
          <small class="form-text text-danger"><?= form_error('phone'); ?></small>
        </div>

        <div class="form-group">
          <label for="">Address</label>
          <textarea class="form-control" id="address" name="address" rows="3"><?= $id['customer_address']; ?></textarea>
          <small class="form-text text-danger"><?= form_error('address'); ?></small>
        </div>

        <div class="form-group">
          <label for="">Bank Name</label>
          <input type="text" class="form-control" id="bankname" name="bankname" placeholder="Bank Name.." value="<?= $id['bank_name']; ?>">
          <small class="form-text text-danger"><?= form_error('bankname'); ?></small>
        </div>

        <div class="form-group">
          <label for="">Bank Account Number</label>
          <input type="text" class="form-control" id="banknumber" name="banknumber" placeholder="Bank Account Number.." value="<?= $id['bank_account_number']; ?>">
          <small class="form-text text-danger"><?= form_error('banknumber'); ?></small>
        </div>

        <a href="<?php echo base_url(); ?>customer" class="btn btn-secondary">Back</a>
        <button type="submit" class="btn btn-success pull-right">Update</button>
      </form>
    </div>
  </div>

</div>
<!-- /.container-fluid -->