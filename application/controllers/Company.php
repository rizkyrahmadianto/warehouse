<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Company extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();

    checkSessionLog();
  }

  public function index()
  {
    $info['title'] = "Manage Company";
    $info['user'] = $this->Auth_model->getUserSession();

    $info['company'] = $this->Company_model->getCompanyById(1);

    // method number 2, logic to get id if exist will doing update, if not doing add

    $this->form_validation->set_rules('name', 'customer name', 'trim|required');
    $this->form_validation->set_rules('phone', 'phone number', 'trim|required|min_length[7]|max_length[12]|numeric');
    $this->form_validation->set_rules('address', 'address', 'trim|required|min_length[5]');
    $this->form_validation->set_rules('servicecharge', 'service charge', 'trim|required|numeric');
    $this->form_validation->set_rules('vatcharge', 'value added taxt charge', 'trim|required|numeric');

    $file = [
      'company_name' => $this->security->xss_clean(html_escape($this->input->post('name', true))),
      'phone' => $this->security->xss_clean(html_escape($this->input->post('phone', true))),
      'address' => $this->security->xss_clean(html_escape($this->input->post('address', true))),
      'service_charge_value' => $this->security->xss_clean(html_escape($this->input->post('servicecharge', true))),
      'vat_charge_value' => $this->security->xss_clean(html_escape($this->input->post('vatcharge', true)))
    ];

    if ($this->form_validation->run() == FALSE) {
      $this->load->view('templates/header', $info);
      $this->load->view('templates/sidebar', $info);
      $this->load->view('templates/topbar', $info);
      $this->load->view('admins/manage_company', $info);
      $this->load->view('templates/footer');
    } else {
      $this->Company_model->update($file, 1);
      $this->session->set_flashdata('success', 'Your data has been added !');
      redirect('company', 'refresh');
    }
  }
}
  
  /* End of file Company.php */
