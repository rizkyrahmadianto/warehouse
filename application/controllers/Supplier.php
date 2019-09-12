<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Supplier extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();

    checkSessionLog();
  }

  public function index()
  {
    $info['title'] = "Supplier";
    $info['user'] = $this->Auth_model->getUserSession();

    // SEARCHING
    if ($this->input->post('search', true)) {
      $info['keyword'] = $this->input->post('search', true);
      $this->session->set_userdata('keyword', $info['keyword']);
    } else {
      $info['keyword'] = $this->session->set_userdata('keyword');
    }

    // DB PAGINATION FOR SEARCHING
    $this->db->like('supplier_id', $info['keyword']);
    $this->db->or_like('supplier_name', $info['keyword']);
    $this->db->or_like('supplier_phone', $info['keyword']);
    $this->db->or_like('supplier_address', $info['keyword']);
    $this->db->or_like('credit_card_type', $info['keyword']);
    $this->db->or_like('credit_card_number', $info['keyword']);
    $this->db->from('suppliers');

    // PAGINATION
    $config['base_url']     = base_url() . 'supplier/index';
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
    $info['supplier']    = $this->Supplier_model->getAllSupplier($config['per_page'], $info['start'], $info['keyword']);

    $info['pagination'] = $this->pagination->create_links();

    // PASSING DATA
    $this->load->view('templates/header', $info);
    $this->load->view('templates/sidebar', $info);
    $this->load->view('templates/topbar', $info);
    $this->load->view('suppliers/index', $info);
    $this->load->view('suppliers/detail_supplier', $info);
    $this->load->view('templates/footer');
  }

  public function addSupplier()
  {
    $info['title'] = "Add Supplier";
    $info['user'] = $this->Auth_model->getUserSession();

    // CUSTOM GENERATE ID CUSTOMER
    $id = "SPL" . "-";
    $customid = $id . date('His') . date("m") . date('y');

    $this->form_validation->set_rules('name', 'supplier name', 'trim|required|min_length[5]|is_unique[suppliers.supplier_name]', [
      'is_unique' => 'Supplier has been registered, please register another supplier.'
    ]);
    $this->form_validation->set_rules('phone', 'phone number', 'trim|required|min_length[7]|max_length[12]|numeric');
    $this->form_validation->set_rules('address', 'address', 'trim|required|min_length[5]');
    $this->form_validation->set_rules('credit_card_type', 'bank name', 'trim|required|min_length[3]');
    $this->form_validation->set_rules('credit_card_number', 'bank account number', 'trim|required|min_length[5]|numeric');

    $file = [
      'supplier_id' => $customid,
      'supplier_name' => $this->security->xss_clean(html_escape($this->input->post('name', true))),
      'supplier_phone' => $this->security->xss_clean(html_escape($this->input->post('phone', true))),
      'supplier_address' => $this->security->xss_clean(html_escape($this->input->post('address', true))),
      'credit_card_type' => $this->security->xss_clean(html_escape($this->input->post('credit_card_type', true))),
      'credit_card_number' => $this->security->xss_clean(html_escape($this->input->post('credit_card_number', true)))
    ];

    if ($this->form_validation->run() == FALSE) {
      $this->load->view('templates/header', $info);
      $this->load->view('templates/sidebar', $info);
      $this->load->view('templates/topbar', $info);
      $this->load->view('suppliers/add-supplier', $info);
      $this->load->view('templates/footer');
    } else {
      $this->Supplier_model->insert($file);
      $this->session->set_flashdata('success', 'Your data has been added !');
      redirect('supplier', 'refresh');
    }
  }

  public function editSupplier($id)
  {
    $info['title']     = 'Edit Supplier';
    $info['user']      = $this->Auth_model->getUserSession();
    $info['id']        = $this->Supplier_model->getSupplierById($id);
    date_default_timezone_set('Asia/Jakarta');

    $this->form_validation->set_rules('phone', 'phone number', 'trim|required|min_length[7]|max_length[12]|numeric');
    $this->form_validation->set_rules('address', 'address', 'trim|required|min_length[5]');
    $this->form_validation->set_rules('credit_card_type', 'bank name', 'trim|required|min_length[3]');
    $this->form_validation->set_rules('credit_card_number', 'bank account number', 'trim|required|min_length[5]|numeric');

    $file = [
      'supplier_phone' => $this->security->xss_clean(html_escape($this->input->post('phone', true))),
      'supplier_address' => $this->security->xss_clean(html_escape($this->input->post('address', true))),
      'credit_card_type' => $this->security->xss_clean(html_escape($this->input->post('credit_card_type', true))),
      'credit_card_number' => $this->security->xss_clean(html_escape($this->input->post('credit_card_number', true))),
      'updated_at' => date('Y-m-d H:i:s')
    ];

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $info);
      $this->load->view('templates/sidebar', $info);
      $this->load->view('templates/topbar', $info);
      $this->load->view('suppliers/edit-supplier', $info);
      $this->load->view('templates/footer');
    } else {
      $this->Supplier_model->update($file);
      $this->session->set_flashdata('success', 'Data supplier has been updated !');
      redirect('supplier', 'refresh');
    }
  }

  public function deleteSupplier($id)
  {
    $this->Supplier_model->delete($id);
    $this->session->set_flashdata('success', 'Data supplier has been deleted !');
    redirect('supplier', 'refresh');
  }
}
  
  /* End of file Supplier.php */
