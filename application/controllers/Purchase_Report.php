<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Purchase_Report extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();

    checkSessionLog();
  }

  public function index()
  {
    $info['title'] = "Purchase Report";
    $info['user'] = $this->Auth_model->getUserSession();

    $this->form_validation->set_rules('startdate', 'field start date', 'required|trim|strip_tags|htmlspecialchars');
    $this->form_validation->set_rules('enddate', 'field end date', 'required|trim|strip_tags|htmlspecialchars');

    $startdate = date("Y-m-d", strtotime($this->input->get('startdate')));
    $enddate = date("Y-m-d", strtotime($this->input->get('enddate')));

    $info['cetak'] = 'purchase_report/print_purchase?startdate=' . $startdate . '&enddate=' . $enddate . '';

    $info['data'] = $this->Purchase_model->dateRangeFilter($startdate, $enddate);


    $this->load->view('templates/header', $info);
    $this->load->view('templates/sidebar', $info);
    $this->load->view('templates/topbar', $info);
    $this->load->view('reports/purchase-report', $info);
    $this->load->view('templates/footer');
  }

  public function print_purchase()
  {
    $info['title'] = 'Print Purchase Order Report';
    $info['user'] = $this->Auth_model->getUserSession();

    $info['startdate'] = $this->input->get('startdate');
    $info['enddate'] = $this->input->get('enddate');

    $info['data'] = $this->Purchase_model->dateRangeFilter($info['startdate'], $info['enddate']);

    $this->load->view('reports/print-purchase-report', $info);
  }
}
  
  /* End of file Purchase_Report.php */
