<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Sales_model extends CI_Model
{

  public function getAllSales($limit, $offset, $keyword)
  {
    $this->db->select('*, COUNT(order_id) as total');
    $this->db->from('sales_orders');
    $this->db->join('sales_order_details', 'sales_order_details.order_id = sales_orders.id');
    $this->db->group_by('order_id');
    // $this->db->join('sales_account_receivables', 'sales_account_receivables.order_id = sales_orders.id');


    if ($keyword) {
      $this->db->like('id', $keyword);
      $this->db->or_like('customer_name', $keyword);
      $this->db->or_like('customer_phone', $keyword);
      $this->db->or_like('customer_address', $keyword);
    }

    $this->db->order_by('order_date', 'DESC');

    $this->db->limit($limit, $offset);

    $query = $this->db->get();
    return $query->result_array();
  }

  public function getSales()
  {
    $query = $this->db->get('sales_orders');
    return $query->result_array();
  }

  public function insertOrders($data)
  {
    $this->db->insert('sales_orders', $data);
  }

  public function insertOrderDetails($data)
  {
    $this->db->insert('sales_order_details', $data);
  }

  public function getSalesOrdersById($id)
  {
    return $this->db->get_where('sales_orders', ['id' => $id])->row_array();
  }

  public function getSalesOrderDetailsById($id)
  {
    return $this->db->get_where('sales_order_details', ['order_id' => $id])->result_array();
  }

  public function update($id, $data)
  {
    $this->db->where('id', $id);
    $this->db->update('sales_orders', $data);
  }
}
  
  /* End of file Sales_model.php */
