<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Sales extends CI_Controller
{


  public function __construct()
  {
    parent::__construct();

    checkSessionLog();
  }

  public function index()
  {
    $info['title'] = "Selling";
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
    $this->db->from('sales_order_details');
    $this->db->join('sales_orders', 'sales_orders.id = sales_order_details.order_id');
    $this->db->join('sales_account_receivables', 'sales_account_receivables.order_id = sales_orders.id');

    $this->db->like('id', $info['keyword']);
    $this->db->or_like('customer_name', $info['keyword']);
    $this->db->or_like('customer_phone', $info['keyword']);
    $this->db->or_like('customer_address', $info['keyword']);

    // PAGINATION
    $config['base_url']     = base_url() . 'sales/index';
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
    $info['sales']    = $this->Sales_model->getAllSales($config['per_page'], $info['start'], $info['keyword']);

    $info['pagination'] = $this->pagination->create_links();

    // PASSING DATA
    $this->load->view('templates/header', $info);
    $this->load->view('templates/sidebar', $info);
    $this->load->view('templates/topbar', $info);
    $this->load->view('sales/index', $info);
    $this->load->view('templates/footer');
  }

  public function newOrder()
  {
    $info['title'] = "Add New Order";
    $info['user'] = $this->Auth_model->getUserSession();
    $info['product'] = $this->Product_model->getProduct();

    $company = $this->Company_model->getCompanyById(1);
    $info['company_data'] = $company;
    $info['is_vat_enabled'] = ($company['vat_charge_value'] > 0) ? true : false;
    $info['is_service_enabled'] = ($company['service_charge_value'] > 0) ? true : false;

    // CUSTOM GENERATE ID NEW ORDER SELL
    $id = "SELL" . "-";
    $customid = $id . date('His') . date("m") . date('y');

    $this->form_validation->set_rules('name', 'customer name', 'trim|required|min_length[5]');
    $this->form_validation->set_rules('phone', 'phone number', 'trim|required|min_length[7]|max_length[12]|numeric');
    $this->form_validation->set_rules('address', 'address', 'trim|required|min_length[5]');
    // $this->form_validation->set_rules('bankname', 'bank name', 'trim|required|min_length[3]');
    // $this->form_validation->set_rules('banknumber', 'bank account number', 'trim|required|min_length[5]|numeric');

    $this->form_validation->set_rules('product[]', 'product', 'trim|required');


    $file = [
      'id' => $customid,
      'customer_name' => $this->input->post('name', true),
      'customer_phone' => $this->input->post('phone', true),
      'customer_address' => $this->input->post('address', true),
      'gross_amount' => $this->input->post('gross_amount_value', true),
      'service_charge_rate' => $this->input->post('service_charge_rate', true),
      'service_charge' => ($this->input->post('service_charge_value') > 0) ? $this->input->post('service_charge_value') : 0,
      'vat_charge_rate' => $this->input->post('vat_charge_rate', true),
      'vat_charge' => ($this->input->post('vat_charge_value') > 0) ? $this->input->post('vat_charge_value') : 0,
      'net_amount' => $this->input->post('net_amount_value', true),
      'discount' => $this->input->post('discount', true),
      'paid_status' => 2,
      'user_id' => $this->session->userdata('id')
    ];

    if ($this->form_validation->run() == FALSE) {
      $this->load->view('templates/header', $info);
      $this->load->view('templates/sidebar', $info);
      $this->load->view('templates/topbar', $info);
      $this->load->view('sales/add-order', $info);
      $this->load->view('templates/footer');
    } else {
      $this->Sales_model->insertOrders($file);

      // Store to sales_order_details
      $count_product = count($this->input->post('product'));
      for ($i = 0; $i < $count_product; $i++) {
        $products = array(
          'order_id' => $customid,
          'product_id' => $this->input->post('product')[$i],
          'qty' => $this->input->post('qty')[$i],
          'unit_price' => $this->input->post('price_value')[$i],
          'amount' => $this->input->post('amount_value')[$i]
        );

        $this->Sales_model->insertOrderDetails($products);

        // Update product to decrease stock after doing new order 
        $data_product = $this->Product_model->getProductById($this->input->post('product')[$i]);
        $qty = (int) $data_product['qty'] - (int) $this->input->post('qty')[$i];

        $update_product = array(
          'qty' => $qty
        );

        $this->Product_model->update($update_product, $this->input->post('product')[$i]);
      }

      $this->session->set_flashdata('success', 'Your order has been added !');
      redirect('sales', 'refresh');
    }
  }

  /*
	* It gets the product id passed from the ajax method.
	* It checks retrieves the particular product data from the product id 
	* and return the data into the json format.
	*/
  public function getProductValueById()
  {
    $product_id = $this->input->post('product_id');
    if ($product_id) {
      $product_data = $this->Product_model->getProductById($product_id);
      echo json_encode($product_data);
    }
  }

  /*
	* It gets the all the active product inforamtion from the product table 
	* This function is used in the order page, for the product selection in the table
	* The response is return on the json format.
  */
  public function getTableProductRow()
  {
    $product = $this->Product_model->getProduct();
    echo json_encode($product);
  }

  public function editOrder($id)
  {
    $info['title'] = 'Edit Sales Order';
    $info['user'] = $this->Auth_model->getUserSession();

    // to get all data order by ID
    $result = array();
    $orders_data = $this->Sales_model->getSalesOrdersById($id);
    $result['order'] = $orders_data;
    $orders_item = $this->Sales_model->getSalesOrderDetailsById($orders_data['id']);

    foreach ($orders_item as $key => $val) {
      $result['order_detail'][] = $val;
    }

    $info['order_data'] = $result;

    date_default_timezone_set('Asia/Jakarta');

    $info['product'] = $this->Product_model->getProduct();

    $company = $this->Company_model->getCompanyById(1);
    $info['company_data'] = $company;
    $info['is_vat_enabled'] = ($company['vat_charge_value'] > 0) ? true : false;
    $info['is_service_enabled'] = ($company['service_charge_value'] > 0) ? true : false;

    $this->form_validation->set_rules('name', 'customer name', 'trim|required|min_length[5]');
    $this->form_validation->set_rules('phone', 'phone number', 'trim|required|min_length[7]|max_length[12]|numeric');
    $this->form_validation->set_rules('address', 'address', 'trim|required|min_length[5]');

    $this->form_validation->set_rules('product[]', 'product', 'trim|required');


    $file = [
      'customer_name' => $this->input->post('name', true),
      'customer_phone' => $this->input->post('phone', true),
      'customer_address' => $this->input->post('address', true),
      'gross_amount' => $this->input->post('gross_amount_value', true),
      'service_charge_rate' => $this->input->post('service_charge_rate', true),
      'service_charge' => ($this->input->post('service_charge_value') > 0) ? $this->input->post('service_charge_value') : 0,
      'vat_charge_rate' => $this->input->post('vat_charge_rate', true),
      'vat_charge' => ($this->input->post('vat_charge_value') > 0) ? $this->input->post('vat_charge_value') : 0,
      'net_amount' => $this->input->post('net_amount_value', true),
      'discount' => $this->input->post('discount', true),
      'paid_status' => 2,
      'user_id' => $this->session->userdata('id'),
      'updated_at' => date('Y-m-d H:i:s')
    ];

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $info);
      $this->load->view('templates/sidebar', $info);
      $this->load->view('templates/topbar', $info);
      $this->load->view('sales/edit-order', $info);
      $this->load->view('templates/footer');
    } else {
      $this->Sales_model->update($id, $file);

      // Update to sales_order_details
      $get_order_details = $this->Sales_model->getSalesOrderDetailsById($id);
      foreach ($get_order_details as $v) {
        $product_id = $v['product_id'];
        $qty = $v['qty'];

        // get the product
        $product_data = $this->Product_model->getProductById($product_id);
        $update_qty = $qty + $product_data['qty'];
        $update_product_data = array('qty' => $update_qty);

        // update product quantity
        $this->Product_model->update($update_product_data, $product_id);
      }

      // remove the order details
      $this->db->where('order_id', $id);
      $this->db->delete('sales_order_details');

      // decrease the product quantity
      $count_product = count($this->input->post('product'));
      for ($i = 0; $i < $count_product; $i++) {
        $products = array(
          'order_id' => $id,
          'product_id' => $this->input->post('product')[$i],
          'qty' => $this->input->post('qty')[$i],
          'unit_price' => $this->input->post('price_value')[$i],
          'amount' => $this->input->post('amount_value')[$i]
        );

        $this->Sales_model->insertOrderDetails($products);

        // Decrease stock from table product 
        $product_data = $this->Product_model->getProductById($this->input->post('product')[$i]);
        $qty = (int) $product_data['qty'] - (int) $this->input->post('qty')[$i];

        $update_product = array('qty' => $qty);
        $this->Product_model->update($update_product, $this->input->post('product')[$i]);
      }
      // return true;

      $this->session->set_flashdata('success', 'Data order has been updated !');
      redirect('sales', 'refresh');
    }
  }

  public function printOrder($id)
  {
    $info['title'] = 'Print Sales Order ' . $id;
    $info['user'] = $this->Auth_model->getUserSession();

    $info['order_data'] = $this->Sales_model->getSalesOrdersById($id);
    $info['order_detail'] = $this->Sales_model->getSalesOrderDetailsById($id);

    $info['company_info'] = $this->Company_model->getCompanyById(1);

    $info['order_date'] = date('d M Y', strtotime($info['order_data']['order_date']));

    foreach ($info['order_detail'] as $key => $val) {
      $product_data = $this->Product_model->getProductById($val['product_id']);
      $info['show_detail'] = '
        <tr>
        <td>' . $product_data['product_name'] . '</td>
        <td>' . $val['unit_price'] . '</td>
        <td>' . $val['qty'] . '</td>
        <td>' . $val['amount'] . '</td>
        </tr>
      ';
    };

    $this->load->view('sales/print-order', $info);
  }
}
  
  /* End of file Sales.php */
