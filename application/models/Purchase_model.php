<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Purchase_model extends CI_Model
{

  public function getAllPurchase($limit, $offset, $keyword)
  {
    $this->db->select('*, COUNT(order_id) as jumlah');
    $this->db->from('purchase_orders');
    $this->db->join('purchase_order_details', 'purchase_order_details.order_id = purchase_orders.id');
    $this->db->join('suppliers', 'suppliers.supplier_id = purchase_orders.supplier_id');
    $this->db->group_by('order_id');
    // $this->db->join('purchase_account_receivables', 'purchase_account_receivables.order_id = purchase_orders.id');


    if ($keyword) {
      $this->db->like('id', $keyword);
      $this->db->or_like('supplier_name', $keyword);
      $this->db->or_like('supplier_phone', $keyword);
    }

    $this->db->order_by('order_date', 'DESC');

    $this->db->limit($limit, $offset);

    $query = $this->db->get();
    return $query->result_array();
  }

  public function getSupplierInfo($id)
  {
    $this->db->select('*');
    $this->db->from('purchase_orders');
    $this->db->join('suppliers', 'suppliers.supplier_id = purchase_orders.supplier_id');
    $this->db->where('purchase_orders.id', $id);
    // $this->db->order_by('order_id');

    $query = $this->db->get();

    if ($query->num_rows() != 0) {
      return $query->row_array();
    } else {
      return false;
    }
  }

  public function getPurchase()
  {
    $query = $this->db->get('purchase_orders');
    return $query->result_array();
  }

  public function insertOrders($data)
  {
    $this->db->insert('purchase_orders', $data);
  }

  public function insertOrderDetails($data)
  {
    $this->db->insert('purchase_order_details', $data);
  }

  public function getPurchaseOrdersById($id)
  {
    return $this->db->get_where('purchase_orders', ['id' => $id])->row_array();
  }

  public function getPurchaseOrderDetailsById($id)
  {
    return $this->db->get_where('purchase_order_details', ['order_id' => $id])->result_array();
  }

  public function update($id, $data)
  {
    $this->db->where('id', $id);
    $this->db->update('purchase_orders', $data);
  }

  // Searching Filter
  public function dateRangeFilter($startdate, $enddate)
  {
    $this->db->select('*, COUNT(order_id) AS jumlah');
    $this->db->from('purchase_orders');
    $this->db->join('purchase_order_details', 'purchase_order_details.order_id = purchase_orders.id');
    $this->db->join('suppliers', 'suppliers.supplier_id = purchase_orders.supplier_id');
    $this->db->where('order_date >=', $startdate);
    $this->db->where('order_date <=', $enddate);
    $this->db->group_by('order_id');

    $this->db->order_by('order_date', 'DESC');

    $query = $this->db->get();
    return $query->result_array();
  }
}
  
  /* End of file Purchase_model.php */
