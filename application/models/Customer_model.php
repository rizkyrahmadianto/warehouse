<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Customer_model extends CI_Model
{

  public function getAllCustomer($limit, $offset, $keyword)
  {
    if ($keyword) {
      $this->db->like('customer_email', $keyword);
      $this->db->or_like('customer_name', $keyword);
      $this->db->or_like('customer_phone', $keyword);
      $this->db->or_like('customer_address', $keyword);
      $this->db->or_like('bank_name', $keyword);
      $this->db->or_like('bank_account_number', $keyword);
    }

    $this->db->order_by('created_date', 'DESC');

    $query = $this->db->get('customers', $limit, $offset);
    return $query->result_array();
  }

  public function getCustomer()
  {
    $query = $this->db->get('customers');
    return $query->result_array();
  }

  public function insert($data)
  {
    $this->db->insert('customers', $data);
  }

  public function getCustomerById($id)
  {
    return $this->db->get_where('customers', ['customer_id' => $id])->row_array();
  }

  public function update($data)
  {
    $this->db->where('customer_id', $this->input->post('id'));
    $this->db->update('customers', $data);
  }

  public function delete($id)
  {
    $this->db->where('customer_id', $id);
    $this->db->delete('customers');
  }
}
  
  /* End of file ModelName.php */
