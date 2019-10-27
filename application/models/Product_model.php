<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Product_model extends CI_Model
{

  public function getAllProduct($limit, $offset, $keyword)
  {
    // $this->db->select('products.*, product_categories.name as category_name, product_brands.name as brand_name'); // , product_categories.id as category_id, product_brands.id as brand_id
    $this->db->select('*');
    $this->db->from('products');
    $this->db->join('product_categories', 'product_categories.category_id = products.category_id');
    $this->db->join('product_brands', 'product_brands.brand_id = products.brand_id');

    if ($keyword) {
      $this->db->like('product_id', $keyword);
      $this->db->or_like('product_name', $keyword);
      $this->db->or_like('brand_name', $keyword);
      $this->db->or_like('category_name', $keyword);
    }

    $this->db->order_by('created_at', 'DESC');

    $this->db->limit($limit, $offset);

    $query = $this->db->get();
    return $query->result_array();
  }

  public function getProduct()
  {
    $query = $this->db->get('products');
    return $query->result_array();
  }

  public function insert($data)
  {
    $this->db->insert('products', $data);
  }

  public function getProductById($id)
  {
    return $this->db->get_where('products', ['product_id' => $id])->row_array();
  }

  public function update($data, $id)
  {
    $this->db->where('product_id', $id);
    $this->db->update('products', $data);
  }

  public function delete($id)
  {
    $this->db->where('product_id', $id);
    $this->db->delete('products');
  }
}
  
  /* End of file ModelName.php */
