<?php foreach ($product as $p) : ?>
  <div class="modal fade" id="detail-modal<?= $p['product_id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title">Detail Product</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="form-group">
            <label for="">Product ID</label>
            <input type="text" class="form-control" readonly value="<?= $p['product_id']; ?>">
          </div>

          <div class="form-group">
            <label for="">Product Name</label>
            <input type="text" class="form-control" readonly value="<?= $p['product_name']; ?>">
          </div>

          <div class="form-group">
            <label for="">Brand</label>
            <input type="text" class="form-control" readonly value="<?= $p['brand_name']; ?>">
          </div>

          <div class="form-group">
            <label for="">Category</label>
            <input type="text" class="form-control" readonly value="<?= $p['category_name']; ?>">
          </div>

          <hr>

          <!-- <div class="form-row">
            <div class="form-group col-md-4">
              <label for="">Image</label>
              <input type="text" class="form-control" readonly value="<?= $p['image']; ?>">
            </div>
            <div class="form-group col-md-8">
              <img src="<?= base_url(); ?>assets/product_images/<?= $p['image'] ?>" class="img-responsive" alt="<?= $p['image'] ?>" width="304" height="236">
            </div>
          </div> -->

          <div class="form-group">
            <img src="<?= base_url(); ?>assets/product_images/<?= $p['image'] ?>" class="img-responsive" alt="<?= $p['image'] ?>" width="304" height="236">
          </div>

          <div class="form-group">
            <label for="">Image</label>
            <input type="text" class="form-control" readonly value="<?= $p['image']; ?>">
          </div>

          <hr>

          <div class="form-group">
            <label for="">Description</label>
            <textarea class="form-control" readonly rows="3"><?= $p['description']; ?></textarea>
          </div>

          <div class="form-group">
            <label for="">Product Price</label>
            <input type="text" class="form-control" readonly value="<?= "Rp. " . number_format($p['price'], 0, ',', '.'); ?>">
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
  </div>
<?php endforeach; ?>