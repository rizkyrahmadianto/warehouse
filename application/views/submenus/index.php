<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><?php echo $title; ?></h1>

    <div class="row mb-4">
        <div class="col-lg-4">
            <!-- search form -->
            <form action="" method="post">
                <div class="input-group">
                    <input type="text" name="search" id="search" class="form-control" placeholder="Search...">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-secondary"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
            <!-- /.search form -->
        </div>
        <div class="col-lg-8">
            <a href="<?php echo base_url() ?>menu/addsubmenu" class="btn btn-primary"><i class="fa fa-plus"></i> Sub Menu</a>
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
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Title</th>
                            <th>Menu</th>
                            <th>Url</th>
                            <th>Icon</th>
                            <th>Active</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = $this->uri->segment(3) + 1;
                        foreach ($submenu as $sm) : ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $sm['title']; ?></td>
                                <td><?php echo $sm['menu']; ?></td>
                                <td><?php echo $sm['url']; ?></td>
                                <td><?php echo $sm['icon']; ?></td>
                                <td><?php echo $sm['is_active']; ?></td>
                                <td>
                                    <a href="<?php echo base_url() ?>deletesubmenu/<?php echo $sm['id'] ?>" class="btn btn-sm btn-danger button-delete">Delete</a>
                                    <a href="<?php echo base_url() ?>menu/editsubmenu/<?php echo $sm['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php echo $pagination; ?>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->