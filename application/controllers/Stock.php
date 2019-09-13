<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Stock extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();

    checkSessionLog();
  }

  public function index()
  {
    $info['title'] = "Stock";
    $info['user'] = $this->Auth_model->getUserSession();

    // SEARCHING
    if ($this->input->post('search', true)) {
      $info['keyword'] = $this->input->post('search', true);
      $this->session->set_userdata('keyword', $info['keyword']);
    } else {
      $info['keyword'] = $this->session->set_userdata('keyword');
    }

    // DB PAGINATION FOR SEARCHING
    $this->db->select('*, suppliers.supplier_name as supplier_name, products.product_name as product_name');
    $this->db->from('product_stocks');
    $this->db->join('suppliers', 'suppliers.supplier_id = product_stocks.supplier_id');
    $this->db->join('products', 'products.product_id = product_stocks.product_id');

    $this->db->like('supplier_name', $info['keyword']);
    $this->db->or_like('product_name', $info['keyword']);
    $this->db->or_like('quantity', $info['keyword']);

    // PAGINATION
    $config['base_url']     = base_url() . 'stock/index';
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

    $info['start']    = $this->uri->segment(3);
    $info['customer'] = $this->Stock_model->getAllStock($config['per_page'], $info['start'], $info['keyword']);

    $info['pagination'] = $this->pagination->create_links();

    // PASSING DATA
    $this->load->view('templates/header', $info);
    $this->load->view('templates/sidebar', $info);
    $this->load->view('templates/topbar', $info);
    $this->load->view('stocks/index', $info);
    $this->load->view('templates/footer');
  }
}
  
  /* End of file Stock.php */
