<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Category_model extends CI_Model
{

  public function getAllCategory($limit, $offset, $keyword)
  {
    if ($keyword) {
      $this->db->like('category_id', $keyword);
      $this->db->or_like('category_name', $keyword);
    }

    $this->db->order_by('category_name', 'ASC');

    $query = $this->db->get('product_categories', $limit, $offset);
    return $query->result_array();
  }

  public function getCategory()
  {
    $this->db->order_by('category_name', 'ASC');
    $query = $this->db->get('product_categories');
    return $query->result_array();
  }

  public function insert($data)
  {
    $this->db->insert('product_categories', $data);
  }

  public function getCategoryById($id)
  {
    return $this->db->get_where('product_categories', ['category_id' => $id])->row_array();
  }

  public function update($data)
  {
    $this->db->where('category_id', $this->input->post('id'));
    $this->db->update('product_categories', $data);
  }

  public function delete($id)
  {
    $this->db->where('category_id', $id);
    $this->db->delete('product_categories');
  }
}
  
  /* End of file Category_model.php */
