<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserControll_model extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
  }

  public function getAllUser($limit, $offset, $keyword)
  {
    if ($keyword) {
      $this->db->like('users.role_id', $keyword);
      $this->db->or_like('name', $keyword);
      $this->db->or_like('email', $keyword);
      $this->db->or_like('user_role.role', $keyword); // yang dimaksud bukan integernya tapi stringnya dari table user_role
    }

    $this->db->select('users.*, user_role.role');
    $this->db->from('users');
    $this->db->join('user_role', 'users.role_id = user_role.id');

    $this->db->order_by('name', 'ASC'); // must be specify which the part of table

    $this->db->limit($limit, $offset);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function _getAllRole()
  {
    $query = $this->db->get('user_role');
    return $query->result_array();
  }

  public function getUserControllById($id)
  {
    return $this->db->get_where('users', ['id' => $id])->row_array();
  }

  public function updateUserControll($data)
  {
    $this->db->where('id', $this->input->post('id'));
    $this->db->update('users', $data);
  }

  public function deleteUserControll($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('users');
  }
}
