<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Supplier_model  extends CI_Model
{

  public function getAllSupplier($limit, $offset, $keyword)
  {
    if ($keyword) {
      $this->db->like('supplier_id', $keyword);
      $this->db->or_like('supplier_name', $keyword);
      $this->db->or_like('supplier_phone', $keyword);
      $this->db->or_like('supplier_address', $keyword);
      $this->db->or_like('credit_card_type', $keyword);
      $this->db->or_like('credit_card_number', $keyword);
    }

    $this->db->order_by('created_at', 'DESC');

    $query = $this->db->get('suppliers', $limit, $offset);
    return $query->result_array();
  }

  public function getSupplier()
  {
    $query = $this->db->get('suppliers');
    return $query->result_array();
  }

  public function insert($data)
  {
    $this->db->insert('suppliers', $data);
  }

  public function getSupplierById($id)
  {
    return $this->db->get_where('suppliers', ['supplier_id' => $id])->row_array();
  }

  public function update($data)
  {
    $this->db->where('supplier_id', $this->input->post('id'));
    $this->db->update('suppliers', $data);
  }

  public function delete($id)
  {
    $this->db->where('supplier_id', $id);
    $this->db->delete('suppliers');
  }
}
  
  /* End of file ModelName.php */
