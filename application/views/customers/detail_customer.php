<?php foreach ($customer as $c) : ?>
  <div class="modal fade bd-example-modal-lg" id="detail-modal<?= $c['customer_id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title">Detail Customer</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="form-group">
            <label for="">Customer ID</label>
            <input type="text" class="form-control" readonly value="<?= $c['customer_id']; ?>">
          </div>

          <div class="form-group">
            <label for="">Customer Name</label>
            <input type="text" class="form-control" readonly value="<?= $c['customer_name']; ?>">
          </div>

          <div class="form-group">
            <label for="">Email</label>
            <input type="email" class="form-control" readonly value="<?= $c['customer_email']; ?>">
          </div>

          <div class="form-group">
            <label for="">Phone</label>
            <input type="text" class="form-control" readonly value="<?= $c['customer_phone']; ?>">
          </div>

          <div class="form-group">
            <label for="">Address</label>
            <textarea class="form-control" readonly rows="3"><?= $c['customer_address']; ?></textarea>
          </div>

          <div class="form-group">
            <label for="">Bank Name</label>
            <input type="text" class="form-control" readonly value="<?= $c['bank_name']; ?>">
          </div>

          <div class="form-group">
            <label for="">Bank Account Number</label>
            <input type="text" class="form-control" readonly value="<?= $c['bank_account_number']; ?>">
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
  </div>
<?php endforeach; ?>