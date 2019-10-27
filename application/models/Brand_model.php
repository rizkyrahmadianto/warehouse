<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Brand_model extends CI_Model
{

  public function getAllBrand($limit, $offset, $keyword)
  {
    if ($keyword) {
      $this->db->like('brand_id', $keyword);
      $this->db->or_like('brand_name', $keyword);
    }

    $this->db->order_by('brand_name', 'ASC');

    $query = $this->db->get('product_brands', $limit, $offset);
    return $query->result_array();
  }

  public function getBrand()
  {
    $this->db->order_by('brand_name', 'ASC');
    $query = $this->db->get('product_brands');
    return $query->result_array();
  }

  public function insert($data)
  {
    $this->db->insert('product_brands', $data);
  }

  public function getBrandById($id)
  {
    return $this->db->get_where('product_brands', ['brand_id' => $id])->row_array();
  }

  public function update($data)
  {
    $this->db->where('brand_id', $this->input->post('id'));
    $this->db->update('product_brands', $data);
  }

  public function delete($id)
  {
    $this->db->where('brand_id', $id);
    $this->db->delete('product_brands');
  }
}
  
  /* End of file Brand_model.php */
