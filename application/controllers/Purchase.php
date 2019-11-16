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
      'ship_amount' => $this->input->post('ship_amount', true),
      'tax_amount' => $this->input->post('tax_charge', true),
      'discount' => $this->input->post('discount', true),
      'net_amount' => $this->input->post('net_amount_value', true),
      'paid_status' => 2,
      'user_id' => /* $this->session->userdata('id') */ 1
    ];

    if ($this->form_validation->run() == FALSE) {
      $this->load->view('templates/header', $info);
      $this->load->view('templates/sidebar', $info);
      $this->load->view('templates/topbar', $info);
      $this->load->view('purchase/add-order', $info);
      $this->load->view('templates/footer');
    } else {
      $this->Purchase_model->insertOrders($file);

      // Store to sales_order_details
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
}
  
  /* End of file Purchase.php */
