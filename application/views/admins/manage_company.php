<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="mb-4 mx-auto">
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
  <div class="card shadow mb-4 mx-auto">
    <div class="card-body">
      <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label for="">Company Name</label>
          <input type="text" class="form-control" id="name" name="name" placeholder="Enter Company's Name.." value="<?php echo $company['company_name']; ?>">
          <small class="form-text text-danger"><?= form_error('name'); ?></small>
        </div>

        <div class="form-group">
          <label for="">Phone</label>
          <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number.." value="<?php echo $company['phone']; ?>">
          <small class="form-text text-danger"><?= form_error('phone'); ?></small>
        </div>

        <div class="form-group">
          <label for="">Address</label>
          <textarea class="form-control" id="address" name="address" rows="3" placeholder="Address.."><?php echo $company['address']; ?></textarea>
          <small class="form-text text-danger"><?= form_error('address'); ?></small>
        </div>

        <div class="form-group">
          <label for="">Charge Amount (%)</label>
          <input type="text" class="form-control" id="servicecharge" name="servicecharge" placeholder="Charge Amount.." value="<?php echo $company['service_charge_value']; ?>">
          <small class="form-text text-danger"><?= form_error('servicecharge'); ?></small>
        </div>

        <div class="form-group">
          <label for="">Vat Charge (%)</label>
          <input type="text" class="form-control" id="vatcharge" name="vatcharge" placeholder="Vat Charge.." value="<?php echo $company['vat_charge_value']; ?>">
          <small class="form-text text-danger"><?= form_error('vatcharge'); ?></small>
        </div>

        <button type="submit" class="btn btn-success pull-right">Save</button>
      </form>
    </div>
  </div>

</div>
<!-- /.container-fluid -->