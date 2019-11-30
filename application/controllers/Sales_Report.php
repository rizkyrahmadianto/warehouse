<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Sales_Report extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();

    checkSessionLog();
  }

  public function index()
  {
    $info['title'] = "Sales Report";
    $info['user'] = $this->Auth_model->getUserSession();

    $this->form_validation->set_rules('startdate', 'field start date', 'required|trim|strip_tags|htmlspecialchars');
    $this->form_validation->set_rules('enddate', 'field end date', 'required|trim|strip_tags|htmlspecialchars');

    $startdate = date("Y-m-d", strtotime($this->input->get('startdate')));
    $enddate = date("Y-m-d", strtotime($this->input->get('enddate')));

    $info['cetak'] = 'sales_report/print_sales?startdate=' . $startdate . '&enddate=' . $enddate . '';

    $info['data'] = $this->Sales_model->dateRangeFilter($startdate, $enddate);

    $this->load->view('templates/header', $info);
    $this->load->view('templates/sidebar', $info);
    $this->load->view('templates/topbar', $info);
    $this->load->view('reports/sales-report', $info);
    $this->load->view('templates/footer');
  }

  public function print_sales()
  {
    $info['title'] = 'Print Sales Order Report';
    $info['user'] = $this->Auth_model->getUserSession();

    $info['startdate'] = $this->input->get('startdate');
    $info['enddate'] = $this->input->get('enddate');

    $info['data'] = $this->Sales_model->dateRangeFilter($info['startdate'], $info['enddate']);

    $this->load->view('reports/print-sales-report', $info);
  }
}
  
  /* End of file Sales_Report.php */
