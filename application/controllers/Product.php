<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Product extends CI_Controller
{


  public function __construct()
  {
    parent::__construct();

    checkSessionLog();
  }

  public function index()
  {
    $info['title'] = "Product";
    $info['user'] = $this->Auth_model->getUserSession();

    // SEARCHING
    if ($this->input->post('search', true)) {
      $info['keyword'] = $this->input->post('search', true);
      $this->session->set_userdata('keyword', $info['keyword']);
    } else {
      $info['keyword'] = $this->session->set_userdata('keyword');
    }

    // DB PAGINATION FOR SEARCHING
    // $this->db->select('products.*, product_categories.name as category_name, product_brands.name as brand_name'); // , product_categories.id as category_id, product_brands.id as brand_id
    $this->db->select('*');
    $this->db->from('products');
    $this->db->join('product_categories', 'product_categories.category_id = products.category_id');
    $this->db->join('product_brands', 'product_brands.brand_id = products.brand_id');

    $this->db->like('product_id', $info['keyword']);
    $this->db->or_like('product_name', $info['keyword']);
    $this->db->or_like('brand_name', $info['keyword']);
    $this->db->or_like('category_name', $info['keyword']);
    // $this->db->from('products');

    // PAGINATION
    $config['base_url']     = base_url() . 'product/index';
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
    $info['product']    = $this->Product_model->getAllProduct($config['per_page'], $info['start'], $info['keyword']);

    $info['pagination'] = $this->pagination->create_links();

    // PASSING DATA
    $this->load->view('templates/header', $info);
    $this->load->view('templates/sidebar', $info);
    $this->load->view('templates/topbar', $info);
    $this->load->view('products/index', $info);
    $this->load->view('products/detail_product', $info);
    $this->load->view('templates/footer');
  }

  public function addProduct()
  {
    $info['title'] = "Add Product";
    $info['user'] = $this->Auth_model->getUserSession();
    $info['brand'] = $this->Brand_model->getBrand();
    $info['category'] = $this->Category_model->getCategory();
    // CUSTOM GENERATE ID CUSTOMER
    $id = "PROD" . "-";
    $customid = $id . date('His') . date("m") . date('y');

    $this->form_validation->set_rules('product_name', 'product name', 'trim|required|min_length[5]');
    $this->form_validation->set_rules('brand_id', 'brand', 'trim|required');
    $this->form_validation->set_rules('category_id', 'category', 'trim|required');
    // $this->form_validation->set_rules('image', 'image', 'trim|required');
    $this->form_validation->set_rules('description', 'description product', 'trim|required|min_length[10]');
    $this->form_validation->set_rules('price', 'product price', 'trim|required');

    $convertCurrency = preg_replace('/\D/', '', $this->security->xss_clean(html_escape($this->input->post('price', true))));

    $file = [
      'product_id' => $customid,
      'product_name' => $this->security->xss_clean(html_escape($this->input->post('product_name', true))),
      'brand_id' => $this->security->xss_clean(html_escape($this->input->post('brand_id', true))),
      'category_id' => $this->security->xss_clean(html_escape($this->input->post('category_id', true))),
      // 'image' => $this->security->xss_clean(html_escape($this->input->post('image', true))),
      'description' => $this->security->xss_clean(html_escape($this->input->post('description', true))),
      'price' => $convertCurrency
    ];

    if ($this->form_validation->run() == FALSE) {
      $this->load->view('templates/header', $info);
      $this->load->view('templates/sidebar', $info);
      $this->load->view('templates/topbar', $info);
      $this->load->view('products/add-product', $info);
      $this->load->view('templates/footer');
    } else {
      $this->Product_model->insert($file);
      $this->session->set_flashdata('success', 'Your data has been added !');
      redirect('product', 'refresh');
    }
  }

  public function editProduct($id)
  {
    $info['title']      = 'Edit Product';
    $info['user']       = $this->Auth_model->getUserSession();
    $info['brand']      = $this->Brand_model->getBrand();
    $info['category']   = $this->Category_model->getCategory();
    $info['id']         = $this->Product_model->getProductById($id);
    date_default_timezone_set('Asia/Jakarta');

    $this->form_validation->set_rules('product_name', 'product name', 'trim|required|min_length[5]');
    $this->form_validation->set_rules('brand_id', 'brand', 'trim|required');
    $this->form_validation->set_rules('category_id', 'category', 'trim|required');
    // $this->form_validation->set_rules('image', 'image', 'trim|required');
    $this->form_validation->set_rules('description', 'description product', 'trim|required|min_length[10]');
    $this->form_validation->set_rules('price', 'product price', 'trim|required');

    $convertCurrency = preg_replace('/\D/', '', $this->security->xss_clean(html_escape($this->input->post('price', true))));

    $file = [
      'product_name' => $this->security->xss_clean(html_escape($this->input->post('product_name', true))),
      'brand_id' => $this->security->xss_clean(html_escape($this->input->post('brand_id', true))),
      'category_id' => $this->security->xss_clean(html_escape($this->input->post('category_id', true))),
      // 'image' => $this->security->xss_clean(html_escape($this->input->post('image', true))),
      'description' => $this->security->xss_clean(html_escape($this->input->post('description', true))),
      'price' => $convertCurrency,
      'updated_at' => date('Y-m-d H:i:s')
    ];

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $info);
      $this->load->view('templates/sidebar', $info);
      $this->load->view('templates/topbar', $info);
      $this->load->view('products/edit-product', $info);
      $this->load->view('templates/footer');
    } else {
      $this->Product_model->update($file);
      $this->session->set_flashdata('success', 'Data product has been updated !');
      redirect('product', 'refresh');
    }
  }

  public function deleteProduct($id)
  {
    $this->Product_model->delete($id);
    $this->session->set_flashdata('success', 'Data product has been deleted !');
    redirect('product', 'refresh');
  }
}

/* End of file Controllername.php */
