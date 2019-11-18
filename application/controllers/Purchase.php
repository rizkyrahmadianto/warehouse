<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Purchase extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();

    checkSessionLog();
  }

  public function index()
  {
    $info['title'] = "Purchase";
    $info['user'] = $this->Auth_model->getUserSession();

    // SEARCHING
    if ($this->input->post('search', true)) {
      $info['keyword'] = $this->input->post('search', true);
      $this->session->set_userdata('keyword', $info['keyword']);
    } else {
      $info['keyword'] = $this->session->set_userdata('keyword');
    }

    // DB PAGINATION FOR SEARCHING
    $this->db->select('*');
    $this->db->from('purchase_orders');
    $this->db->join('purchase_order_details', 'purchase_order_details.order_id = purchase_orders.id');
    $this->db->join('suppliers', 'suppliers.supplier_id = purchase_orders.supplier_id');

    $this->db->like('id', $info['keyword']);
    $this->db->or_like('supplier_name', $info['keyword']);
    $this->db->or_like('supplier_phone', $info['keyword']);

    // PAGINATION
    $config['base_url']     = base_url() . 'purchase/index';
    $config['total_rows']   = $this->db->count_all_results();
    $config['per_page']     = 10;
    $config['num_links']    = 5;

    // STYLING
    $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
    $config['full_tag_close']   = '</ul></nav></div>';

    $config['first_link']       = 'First';
    $config['first_tag_open']   = '<li class="page-item">';
    $config['first_tag_close']  = '</li>';

    $config['last_link']        = 'Last';
    $config['last_tag_open']    = '<li class="page-item">';
    $config['last_tag_close']   = '</li>';

    $config['next_link']        = '&raquo';
    $config['next_tag_open']    = '<li class="page-item">';
    $config['next_tag_close']   = '</li>';

    $config['prev_link']        = '&laquo';
    $config['prev_tag_open']    = '<li class="page-item">';
    $config['prev_tag_close']   = '</li>';

    $config['cur_tag_open']     = '<li class="page-item active"><a class="page-link">';
    $config['cur_tag_close']    = '</a></li>';

    $config['num_tag_open']     = '<li class="page-item">';
    $config['num_tag_close']    = '</li>';
    $config['attributes']       = array('class' => 'page-link');

    // GENERATE PAGE
    $this->pagination->initialize($config);

    $info['start']   = $this->uri->segment(3);
    $info['purchases']    = $this->Purchase_model->getAllPurchase($config['per_page'], $info['start'], $info['keyword']);

    $info['pagination'] = $this->pagination->create_links();

    // PASSING DATA
    $this->load->view('templates/header', $info);
    $this->load->view('templates/sidebar', $info);
    $this->load->view('templates/topbar', $info);
    $this->load->view('purchase/index', $info);
    $this->load->view('templates/footer');
  }

  public function getSupplierValueById()
  {
    $supplier_id = $this->input->post('supplier_id');
    if ($supplier_id) {
      $supplier_data = $this->Supplier_model->getSupplierById($supplier_id);
      echo json_encode($supplier_data);
    }
  }

  public function getTableProductRow()
  {
    $product = $this->Product_model->getProduct();
    echo json_encode($product);
  }

  public function getProductValueById()
  {
    $product_id = $this->input->post('product_id');
    if ($product_id) {
      $product_data = $this->Product_model->getProductById($product_id);
      echo json_encode($product_data);
    }
  }

  public function newOrder()
  {
    $info['title'] = "Add New Purchase";
    $info['user'] = $this->Auth_model->getUserSession();
    $info['supplier'] = $this->Supplier_model->getSupplier();
    $info['product'] = $this->Product_model->getProduct();

    // CUSTOM GENERATE ID NEW PURCHASE ORDER
    $id = "BUY" . "-";
    $customid = $id . date('His') . date("m") . date('y');

    $this->form_validation->set_rules('supplier', 'supplier', 'required');
    $this->form_validation->set_rules('order_date', 'order date', 'required');
    // $this->form_validation->set_rules('bankname', 'bank name', 'trim|required|min_length[3]');
    // $this->form_validation->set_rules('banknumber', 'bank account number', 'trim|required|min_length[5]|numeric');

    $this->form_validation->set_rules('product[]', 'product', 'trim|required');

    $file = [
      'id' => $customid,
      'supplier_id' => $this->input->post('supplier', true),
      'order_date' => $this->input->post('order_date', true),
      'gross_amount' => $this->input->post('gross_amount_value', true),
      'ship_amount' => $this->input->post('ship_amount', true),
      'tax_amount' => $this->input->post('tax_charge', true),
      'discount' => $this->input->post('discount', true),
      'net_amount' => $this->input->post('net_amount_value', true),
      'paid_status' => 2,
      'user_create' => $this->session->userdata('email')
    ];

    if ($this->form_validation->run() == FALSE) {
      $this->load->view('templates/header', $info);
      $this->load->view('templates/sidebar', $info);
      $this->load->view('templates/topbar', $info);
      $this->load->view('purchase/add-order', $info);
      $this->load->view('templates/footer');
    } else {
      $this->Purchase_model->insertOrders($file);

      // Store to purchase_order_details
      $count_product = count($this->input->post('product'));
      for ($i = 0; $i < $count_product; $i++) {
        $products = array(
          'order_id' => $customid,
          'product_id' => $this->input->post('product')[$i],
          'unit_price' => $this->input->post('price')[$i],
          'qty' => $this->input->post('qty')[$i],
          'amount' => $this->input->post('amount_value')[$i]
        );

        $this->Purchase_model->insertOrderDetails($products);

        // Update product to increase stock after doing new order 
        $data_product = $this->Product_model->getProductById($this->input->post('product')[$i]);
        $qty = $data_product['qty'] + $this->input->post('qty')[$i];
        $price = $this->input->post('price')[$i];

        $update_product = array(
          'qty' => $qty,
          'price' => $price
        );

        $this->Product_model->update($update_product, $this->input->post('product')[$i]);
      }

      $this->session->set_flashdata('success', 'Your order has been added !');
      redirect('purchase', 'refresh');
    }
  }

  public function editOrder($id)
  {
    $info['title'] = 'Edit Purchase Order';
    $info['user'] = $this->Auth_model->getUserSession();

    // to get all data order by ID
    $result = array();
    $orders_data = $this->Purchase_model->getPurchaseOrdersById($id);
    $result['order'] = $orders_data;
    $orders_item = $this->Purchase_model->getPurchaseOrderDetailsById($orders_data['id']);

    foreach ($orders_item as $key => $val) {
      $result['order_detail'][] = $val;
    }

    $info['order_data'] = $result;

    date_default_timezone_set('Asia/Jakarta');

    $info['supplier'] = $this->Supplier_model->getSupplier();
    $info['product'] = $this->Product_model->getProduct();
    $info['detailsupplier'] = $this->Purchase_model->getPurchaseOrdersById($id);

    $this->form_validation->set_rules('supplier', 'supplier', 'required');
    // $this->form_validation->set_rules('bankname', 'bank name', 'trim|required|min_length[3]');
    // $this->form_validation->set_rules('banknumber', 'bank account number', 'trim|required|min_length[5]|numeric');

    $this->form_validation->set_rules('product[]', 'product', 'trim|required');


    $file = [
      'supplier_id' => $this->input->post('supplier', true),
      'order_date' => $this->input->post('order_date', true),
      'gross_amount' => $this->input->post('gross_amount_value', true),
      'ship_amount' => $this->input->post('ship_amount', true),
      'tax_amount' => $this->input->post('tax_charge', true),
      'discount' => $this->input->post('discount', true),
      'net_amount' => $this->input->post('net_amount_value', true),
      'paid_status' => 2,
      'user_update' => $this->session->userdata('email'),
      'updated_at' => date('Y-m-d H:i:s')
    ];

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $info);
      $this->load->view('templates/sidebar', $info);
      $this->load->view('templates/topbar', $info);
      $this->load->view('purchase/edit-order', $info);
      $this->load->view('templates/footer');
    } else {
      $this->Purchase_model->update($id, $file);

      // Update to purchase_order_details
      $get_order_details = $this->Purchase_model->getPurchaseOrderDetailsById($id);
      foreach ($get_order_details as $v) {
        $product_id = $v['product_id'];
        $qty = $v['qty'];

        // get the product
        $product_data = $this->Product_model->getProductById($product_id);
        $update_qty = abs($qty - $product_data['qty']);
        $update_product_data = array('qty' => $update_qty);

        // update product quantity
        $this->Product_model->update($update_product_data, $product_id);
      }

      // remove the order details
      $this->db->where('order_id', $id);
      $this->db->delete('purchase_order_details');

      // increase the product quantity
      $count_product = count($this->input->post('product'));
      for ($i = 0; $i < $count_product; $i++) {
        $products = array(
          'order_id' => $id,
          'product_id' => $this->input->post('product')[$i],
          'unit_price' => $this->input->post('price')[$i],
          'qty' => $this->input->post('qty')[$i],
          'amount' => $this->input->post('amount_value')[$i]
        );

        $this->Purchase_model->insertOrderDetails($products);

        // Increase stock from table product 
        $product_data = $this->Product_model->getProductById($this->input->post('product')[$i]);
        $qty = $product_data['qty'] + $this->input->post('qty')[$i];
        $price = $this->input->post('price')[$i];

        $update_product = array(
          'qty' => $qty,
          'price' => $price
        );
        $this->Product_model->update($update_product, $this->input->post('product')[$i]);
      }
      // return true;

      $this->session->set_flashdata('success', 'Data order has been updated !');
      redirect('purchase', 'refresh');
    }
  }

  public function printOrder($id)
  {
    $title = 'Print Purchase Order ' . $id;
    $user = $this->Auth_model->getUserSession();

    $order_data = $this->Purchase_model->getPurchaseOrdersById($id);
    $order_detail = $this->Purchase_model->getPurchaseOrderDetailsById($id);

    $company_info = $this->Company_model->getCompanyById(1);
    $supplier_info = $this->Purchase_model->getSupplierInfo($id);

    $order_date = date('d M Y', strtotime($order_data['order_date']));

    // Checking for ship amount exist
    if ($order_data['ship_amount'] > 0) {
      $ship_amount = 'Rp. ' . number_format($order_data['ship_amount'], 0, ',', '.');
    } else {
      $ship_amount = '-';
    }

    // Checking for tax amount exist 
    if ($order_data['tax_amount'] > 0) {
      $tax_amount = $order_data['tax_amount'] . '%';
    } else {
      $tax_amount = '-';
    }

    // Checking for discount exist order_data['discount']
    if ($order_data['discount']) {
      $discount  = $order_data['discount'] . '%';
    } else {
      $discount = '-';
    }

    $html = '
    <!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Warehouse | ' . $title . '</title>

  <link rel="shortcut icon" type="image/png" href="' . base_url() . 'assets/img/logo/warehouse.png">
  <!-- Custom fonts for this template-->
  <link href="' . base_url() . 'assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">


  <!-- Custom styles for this template-->
  <link href="' . base_url() . 'assets/css/sb-admin-2.min.css" rel="stylesheet">
  <link href="' . base_url() . 'assets/css/select2.min.css" rel="stylesheet">

  <!-- Bootstrap core JavaScript-->
  <script src="' . base_url() . 'assets/vendor/jquery/jquery.min.js"></script>
  <script src="' . base_url() . 'assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="' . base_url() . 'assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="' . base_url() . 'assets/js/sb-admin-2.min.js"></script>

  <!-- Custom Script -->
  <script src="' . base_url() . 'assets/sweet_alert/dist/sweetalert2.all.min.js"></script>
</head>

<body onload="window.print();">
  <div class="container">
    <div class="card">
      <div class="card-header">
        Invoice
        <strong>' . $order_date . '</strong>
        <!-- <span class="float-right"> <strong>Status:</strong> -</span> -->
        <span class="float-right"> <strong>BILL ID:</strong> ' . $order_data['id'] . '</span>
      </div>
      <div class="card-body">
        <div class="row mb-4">
          <div class="col-sm-6">
            <h6 class="mb-3">From:</h6>
            <div>
              <strong>' . $supplier_info['supplier_name'] . '</strong>
            </div>
            <div>' . $supplier_info['supplier_address'] . '</div>
            <div>' . $supplier_info['supplier_phone'] . '</div>
          </div>

          <div class="col-sm-6">
            <h6 class="mb-3">To:</h6>
            <div>
              <strong>' . $company_info['company_name'] . '</strong>
            </div>
            <div>' . $company_info['address'] . '</div>
            <div>' . $company_info['phone'] . '</div>
          </div>



        </div>

        <div class="table-responsive-sm">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Amount</th>
              </tr>
            </thead>
            <tbody>
    ';
    foreach ($order_detail as $key => $val) {
      $product_data = $this->Product_model->getProductById($val['product_id']);

      $html .= '
      <tr>
        <td>' . $product_data['product_name'] . '</td>
        <td>Rp. ' . number_format($val['unit_price'], 0, ',', '.') . '</td>
        <td>' . $val['qty'] . '</td>
        <td>Rp. ' . number_format($val['amount'], 0, ',', '.') . '</td>
      </tr>
      ';
    }

    $html .= '
    </tbody>
    </table>
  </div>
  <div class="row">
    <div class="col-lg-4 col-sm-5">

    </div>

    <div class="col-lg-4 col-sm-5 ml-auto">
      <table class="table table-clear">
        <tbody>
          <tr>
            <td class="left">
              <strong>Gross Amount:</strong>
            </td>
            <td class="right">Rp. 
            ' . number_format($order_data['gross_amount'], 0, ',', '.') . '
            </td>
          </tr>

          <tr>
            <td class="left">
              <strong>Ship Amount:</strong>
            </td>
            <td class="right"> 
            ' . $ship_amount . '
            </td>
          </tr>

          <tr>
            <td class="left">
              <strong>Tax Amount:</strong>
            </td>
            <td class="right">' . $tax_amount . '</td>
          </tr>

          <tr>
            <td class="left">
              <strong>Discount:</strong>
            </td>
            <td class="right">' . $discount . '</td>
          </tr>

          <tr>
            <td class="left">
              <strong>Net Amount:</strong>
            </td>
            <td class="right">
              <strong>Rp. ' . number_format($order_data['net_amount'], 0, ',', '.') . '</strong>
            </td>
          </tr>
        </tbody>
      </table>

    </div>

  </div>

</div>
</div>
</div>
</body>

</html>
    ';
    echo $html;
  }

  // public function printOrder($id)
  // {
  //   $info['title'] = 'Print Purchase Order ' . $id;
  //   $info['user'] = $this->Auth_model->getUserSession();

  //   $info['order_data'] = $this->Purchase_model->getPurchaseOrdersById($id);
  //   $order_detail = $this->Purchase_model->getPurchaseOrderDetailsById($id);

  //   $info['company_info'] = $this->Company_model->getCompanyById(1);
  //   $info['supplier_info'] = $this->Purchase_model->getSupplierInfo($id);

  //   $info['order_date'] = date('d M Y', strtotime($info['order_data']['order_date']));

  //   foreach ($order_detail as $key => $val) {
  //     $product_data = $this->Product_model->getProductById($val['product_id']);
  //     $info['show_detail'] = '
  //       <tr>
  //       <td>' . $product_data['product_name'] . '</td>
  //       <td>' . $val['unit_price'] . '</td>
  //       <td>' . $val['qty'] . '</td>
  //       <td>' . $val['amount'] . '</td>
  //       </tr>
  //     ';
  //   };

  //   $this->load->view('purchase/print-order', $info);
  // }
}
  
  /* End of file Purchase.php */
