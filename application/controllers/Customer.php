<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends CI_Controller
{


  public function __construct()
  {
    parent::__construct();

    checkSessionLog();
  }

  public function index()
  {
    $info['title'] = "Customer";
    $info['user'] = $this->Auth_model->getUserSession();

    // SEARCHING
    if ($this->input->post('search', true)) {
      $info['keyword'] = $this->input->post('search', true);
      $this->session->set_userdata('keyword', $info['keyword']);
    } else {
      $info['keyword'] = $this->session->set_userdata('keyword');
    }

    // DB PAGINATION FOR SEARCHING
    $this->db->like('customer_email', $info['keyword']);
    $this->db->or_like('customer_name', $info['keyword']);
    $this->db->or_like('customer_phone', $info['keyword']);
    $this->db->or_like('customer_address', $info['keyword']);
    $this->db->or_like('bank_name', $info['keyword']);
    $this->db->or_like('bank_account_number', $info['keyword']);
    $this->db->from('customers');

    // PAGINATION
    $config['base_url']     = base_url() . 'customer/index';
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
    $info['customer']    = $this->Customer_model->getAllCustomer($config['per_page'], $info['start'], $info['keyword']);

    $info['pagination'] = $this->pagination->create_links();

    // PASSING DATA
    $this->load->view('templates/header', $info);
    $this->load->view('templates/sidebar', $info);
    $this->load->view('templates/topbar', $info);
    $this->load->view('customers/index', $info);
    $this->load->view('customers/detail_customer', $info);
    $this->load->view('templates/footer');
  }

  public function addCustomer()
  {
    $info['title'] = "Add Customer";
    $info['user'] = $this->Auth_model->getUserSession();

    // CUSTOM GENERATE ID CUSTOMER
    $id = "CUST" . "-";
    $customid = $id . date('His') . date("m") . date('y');

    $this->form_validation->set_rules('name', 'customer name', 'trim|required|min_length[5]');
    $this->form_validation->set_rules('email', 'e-mail', 'trim|required|valid_email|is_unique[customers.customer_email]', [
      'is_unique' => 'e-mail has been registered, please use another e-mail.'
    ]);
    $this->form_validation->set_rules('phone', 'phone number', 'trim|required|min_length[7]|max_length[12]|numeric');
    $this->form_validation->set_rules('address', 'address', 'trim|required|min_length[5]');
    $this->form_validation->set_rules('bankname', 'bank name', 'trim|required|min_length[3]');
    $this->form_validation->set_rules('banknumber', 'bank account number', 'trim|required|min_length[5]|numeric');

    $file = [
      'customer_id' => $customid,
      'customer_name' => $this->security->xss_clean(html_escape($this->input->post('name', true))),
      'customer_email' => $this->security->xss_clean(html_escape($this->input->post('email', true))),
      'customer_phone' => $this->security->xss_clean(html_escape($this->input->post('phone', true))),
      'customer_address' => $this->security->xss_clean(html_escape($this->input->post('address', true))),
      'bank_name' => $this->security->xss_clean(html_escape($this->input->post('bankname', true))),
      'bank_account_number' => $this->security->xss_clean(html_escape($this->input->post('banknumber', true)))
    ];

    if ($this->form_validation->run() == FALSE) {
      $this->load->view('templates/header', $info);
      $this->load->view('templates/sidebar', $info);
      $this->load->view('templates/topbar', $info);
      $this->load->view('customers/add-customer', $info);
      $this->load->view('templates/footer');
    } else {
      $this->Customer_model->insert($file);
      $this->session->set_flashdata('success', 'Your data has been added !');
      redirect('customer', 'refresh');
    }
  }

  public function editCustomer($id)
  {
    $info['title']     = 'Edit Customer';
    $info['user']      = $this->Auth_model->getUserSession();
    $info['id']        = $this->Customer_model->getCustomerById($id);
    date_default_timezone_set('Asia/Jakarta');

    $this->form_validation->set_rules('name', 'customer name', 'trim|required|min_length[5]');
    $this->form_validation->set_rules('phone', 'phone number', 'trim|required|min_length[7]|max_length[12]|numeric');
    $this->form_validation->set_rules('address', 'address', 'trim|required|min_length[5]');
    $this->form_validation->set_rules('bankname', 'bank name', 'trim|required|min_length[3]');
    $this->form_validation->set_rules('banknumber', 'bank account number', 'trim|required|min_length[5]|numeric');

    $file = [
      'customer_name' => $this->security->xss_clean(html_escape($this->input->post('name', true))),
      'customer_phone' => $this->security->xss_clean(html_escape($this->input->post('phone', true))),
      'customer_address' => $this->security->xss_clean(html_escape($this->input->post('address', true))),
      'bank_name' => $this->security->xss_clean(html_escape($this->input->post('bankname', true))),
      'bank_account_number' => $this->security->xss_clean(html_escape($this->input->post('banknumber', true))),
      'updated_date' => date('Y-m-d H:i:s')
    ];

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $info);
      $this->load->view('templates/sidebar', $info);
      $this->load->view('templates/topbar', $info);
      $this->load->view('customers/edit-customer', $info);
      $this->load->view('templates/footer');
    } else {
      $this->Customer_model->update($file);
      $this->session->set_flashdata('success', 'Data customer has been updated !');
      redirect('customer', 'refresh');
    }
  }

  public function deleteCustomer($id)
  {
    $this->Customer_model->delete($id);
    $this->session->set_flashdata('success', 'Data customer has been deleted !');
    redirect('customer', 'refresh');
  }
}

/* End of file Controllername.php */
