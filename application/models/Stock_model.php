<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Stock_model extends CI_Model
{

  public function getAllStock($limit, $offset, $keyword)
  {
    $this->db->select('*, suppliers.supplier_name as supplier_name, products.product_name as product_name');
    $this->db->from('product_stocks');
    $this->db->join('suppliers', 'suppliers.supplier_id = product_stocks.supplier_id');
    $this->db->join('products', 'products.product_id = product_stocks.product_id');

    if ($keyword) {
      $this->db->like('supplier_name', $keyword);
      $this->db->or_like('product_name', $keyword);
      $this->db->or_like('quantity', $keyword);
    }

    $this->db->order_by('supplier_name', 'DESC');

    $this->db->limit($limit, $offset);

    $query = $this->db->get();
    return $query->result_array();
  }
}
  
  /* End of file Stock_model.php */
