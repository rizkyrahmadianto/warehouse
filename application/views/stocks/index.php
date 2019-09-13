<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800"><?php echo $title; ?></h1>


  <div class="d-sm-flex align-items-center justify-content-between mb-4">
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

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="table" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Supplier</th>
              <th>Product</th>
              <th>Quantity</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($customer) :
              foreach ($customer as $c) : ?>
                <tr>
                  <td><?php echo ++$start; ?></td>
                  <td><?php echo $c['supplier_name']; ?></td>
                  <td><?php echo $c['product_name']; ?></td>
                  <td><?php echo $c['quantity']; ?></td>
                </tr>
              <?php endforeach; ?>
            <?php else : ?>
              <tr>
                <td colspan="4" style="text-align: center">Data not found !</td>
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