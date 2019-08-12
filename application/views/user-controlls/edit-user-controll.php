<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><?php echo $title; ?></h1>

    <section class="content-header">
        <div class="row">
            <div class="col-lg-6">
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
                <form action="<?= base_url() ?>admin/updateUserControll" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">User Name</label>
                        <input type="hidden" class="form-control" name="id" id="id" value="<?php echo $usercontroll['id']; ?>">
                        <input type="text" class="form-control" id="name" name="name" readonly value="<?php echo $usercontroll['name']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">User Email</label>
                        <input type="text" class="form-control" id="email" name="email" readonly value="<?php echo $usercontroll['email']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="date">Created At</label>
                        <input type="text" class="form-control" id="date" name="date" readonly value="<?php echo date('d F Y', $usercontroll['created_at']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="role">Role User</label>
                        <select class="form-control" name="role" id="role">

                            <?php foreach ($userrole as $ur) : ?>
                                <?php if ($ur['id'] == $usercontroll['role_id']) : ?>
                                    <option value="<?php echo $ur['id'] ?>" selected><?php echo $ur['role'] ?></option>
                                <?php else : ?>
                                    <option value="<?php echo $ur['id'] ?>"><?php echo $ur['role'] ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>

                        </select>
                        <small class="form-text text-danger"><?= form_error('role'); ?></small>
                    </div>
                    <div class="form-group form-check">
                        <label>
                            <?php if ($usercontroll['is_active'] == 1) : ?>
                                <input type="checkbox" name="status" id="status" value="<?php echo $usercontroll['is_active'] ?>" checked>
                                Active ?
                            <?php else : ?>
                                <input type="checkbox" name="status" id="status" value="<?php echo $usercontroll['is_active'] ?>">
                                Active ?
                            <?php endif; ?>
                        </label>
                    </div>
                    <!-- /.box-body -->
                    <a href="<?php echo base_url(); ?>admin/usercontroll" class="btn btn-secondary">Back</a>
                    <button type="submit" value="save" name="save" class="btn btn-success pull-right">Update</button>
                </form>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->