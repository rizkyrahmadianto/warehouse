<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Category extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();

    checkSessionLog();
  }

  public function index()
  {
    $info['title'] = "Product Category";
    $info['user'] = $this->Auth_model->getUserSession();

    // SEARCHING
    if ($this->input->post('search', true)) {
      $info['keyword'] = $this->input->post('search', true);
      $this->session->set_userdata('keyword', $info['keyword']);
    } else {
      $info['keyword'] = $this->session->set_userdata('keyword');
    }

    // DB PAGINATION FOR SEARCHING
    $this->db->like('category_id', $info['keyword']);
    $this->db->or_like('category_name', $info['keyword']);
    $this->db->from('product_categories');

    // PAGINATION
    $config['base_url']     = base_url() . 'category/index';
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
    $info['category']    = $this->Category_model->getAllCategory($config['per_page'], $info['start'], $info['keyword']);

    $info['pagination'] = $this->pagination->create_links();

    // PASSING DATA
    $this->load->view('templates/header', $info);
    $this->load->view('templates/sidebar', $info);
    $this->load->view('templates/topbar', $info);
    $this->load->view('categories/index', $info);
    $this->load->view('templates/footer');
  }

  public function add()
  {
    $info['title'] = "Add Category";
    $info['user'] = $this->Auth_model->getUserSession();

    // CUSTOM GENERATE ID Category
    $id = "CAT" . "-";
    $customid = $id . date('His') . date("m") . date('y');

    $this->form_validation->set_rules('name', 'category name', 'trim|required|min_length[5]|is_unique[product_categories.category_name]', [
      'is_unique' => 'category has been registered, please use another category.'
    ]);

    $file = [
      'category_id' => $customid,
      'category_name' => $this->security->xss_clean(html_escape($this->input->post('name', true)))
    ];

    if ($this->form_validation->run() == FALSE) {
      $this->load->view('templates/header', $info);
      $this->load->view('templates/sidebar', $info);
      $this->load->view('templates/topbar', $info);
      $this->load->view('categories/add-category', $info);
      $this->load->view('templates/footer');
    } else {
      $this->Category_model->insert($file);
      $this->session->set_flashdata('success', 'Your data has been added !');
      redirect('category', 'refresh');
    }
  }

  public function edit($id)
  {
    $info['title']     = 'Edit Category';
    $info['user']      = $this->Auth_model->getUserSession();
    $info['id']        = $this->Category_model->getCategoryById($id);

    $this->form_validation->set_rules('name', 'customer name', 'trim|required|min_length[5]|is_unique[product_categories.category_name]', [
      'is_unique' => 'category has been registered, please use another category.'
    ]);

    $file = [
      'category_name' => $this->security->xss_clean(html_escape($this->input->post('name', true)))
    ];

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $info);
      $this->load->view('templates/sidebar', $info);
      $this->load->view('templates/topbar', $info);
      $this->load->view('categories/edit-category', $info);
      $this->load->view('templates/footer');
    } else {
      $this->Category_model->update($file);
      $this->session->set_flashdata('success', 'Data category has been updated !');
      redirect('category', 'refresh');
    }
  }

  public function delete($id)
  {
    $this->Category_model->delete($id);
    $this->session->set_flashdata('success', 'Data category has been deleted !');
    redirect('category', 'refresh');
  }
}
  
  /* End of file Category.php */
