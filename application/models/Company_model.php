<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Company_model extends CI_Model
{

  public function getCompany()
  {
    $query = $this->db->get('company');
    return $query->result_array();
  }

  public function insert($data)
  {
    $this->db->insert('company', $data);
  }

  public function getCompanyById($id = null)
  {
    // return $this->db->get_where('company', ['id' => $id])->row_array();
    if ($id) {
      return $this->db->get_where('company', ['id' => $id])->row_array();
    }
  }

  public function update($data, $id)
  {
    if ($data && $id) {
      $this->db->where('id', $id);
      $this->db->update('company', $data);
    }
  }

  public function delete($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('company');
  }
}
  
  /* End of file Company_model.php */
