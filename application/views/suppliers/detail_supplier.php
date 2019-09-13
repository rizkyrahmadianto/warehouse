<?php foreach ($supplier as $s) : ?>
  <div class="modal fade" id="detail-modal<?= $s['supplier_id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title">Detail Supplier</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="form-group">
            <label for="">Supplier ID</label>
            <input type="text" class="form-control" readonly value="<?= $s['supplier_id']; ?>">
          </div>

          <div class="form-group">
            <label for="">Supplier Name</label>
            <input type="text" class="form-control" readonly value="<?= $s['supplier_name']; ?>">
          </div>

          <div class="form-group">
            <label for="">Phone</label>
            <input type="text" class="form-control" readonly value="<?= $s['supplier_phone']; ?>">
          </div>

          <div class="form-group">
            <label for="">Address</label>
            <textarea class="form-control" readonly rows="3"><?= $s['supplier_address']; ?></textarea>
          </div>

          <div class="form-group">
            <label for="">Bank Name</label>
            <input type="text" class="form-control" readonly value="<?= $s['credit_card_type']; ?>">
          </div>

          <div class="form-group">
            <label for="">Bank Account Number</label>
            <input type="text" class="form-control" readonly value="<?= $s['credit_card_number']; ?>">
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
  </div>
<?php endforeach; ?>