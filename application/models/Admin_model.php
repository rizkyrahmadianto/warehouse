<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getSalesEarningMonthly()
    {
        $this->db->select("SUM(net_amount) AS income_total");
        $this->db->group_by('order_date');
        $query = $this->db->get_where('sales_orders', 'MONTH(order_date) = MONTH(CURRENT_DATE()) AND YEAR(order_date) = YEAR(CURRENT_DATE())');
        return $query->row_array();
    }

    public function getSalesEarningAnnual()
    {
        $this->db->select("SUM(net_amount) AS income_total");
        $query = $this->db->get_where('sales_orders', 'YEAR(order_date) = YEAR(CURRENT_DATE())');
        // $query = $this->db->get_where('sales_orders', 'DATE_FORMAT(NOW(),"%Y-%m-01") AND LAST_DAY(NOW())');
        return $query->row_array();
    }

    public function getPurchaseEarningMonthly()
    {
        $this->db->select("SUM(net_amount) AS income_total");
        $this->db->group_by('order_date');
        $query = $this->db->get_where('purchase_orders', 'MONTH(order_date) = MONTH(CURRENT_DATE()) AND YEAR(order_date) = YEAR(CURRENT_DATE())');
        return $query->row_array();
    }

    public function getPurchaseEarningAnnual()
    {
        $this->db->select("SUM(net_amount) AS income_total");
        $query = $this->db->get_where('purchase_orders', 'YEAR(order_date) = YEAR(CURRENT_DATE())');
        // $query = $this->db->get_where('purchase_orders', 'DATE_FORMAT(NOW(),"%Y-%m-01") AND LAST_DAY(NOW())');
        return $query->row_array();
    }

    public function getUserCount()
    {
        $this->db->select('COUNT(*)');
        $this->db->from('users');
        return $this->db->count_all_results();
    }

    public function getUserOnline()
    {
        $this->db->select("SUM(online) AS isonline");
        $query = $this->db->get_where('users', 'online = 1');
        return $query->row_array();
    }

    public function getTotalRow()
    {
        $this->db->select('COUNT(*)');
        $this->db->from('regions');
        $this->db->join('person', 'regions.id = person.region_id');
        //$this->db->group_by('regions.id');
        return $this->db->count_all_results();
    }

    public function getSearchData($limit, $offset)
    {
        $keyword = $this->input->post('search', true);
        $this->db->or_like('name', $keyword);

        return $this->db->get('regions', $limit, $offset)->result_array();
    }

    public function getSearchRole($limit, $offset)
    {
        $keyword = $this->input->post('search', true);
        $this->db->or_like('role', $keyword);

        return $this->db->get('user_role', $limit, $offset)->result_array();
    }

    public function getUserSession()
    {
        return $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
    }

    public function getAllMenu()
    {
        $this->db->where('id !=', 1);
        $query = $this->db->get('user_menu');
        return $query->result_array();
    }

    public function getAllRole($limit, $offset, $keyword)
    {
        if ($keyword) {
            $this->db->like('id', $keyword);
            $this->db->or_like('role', $keyword);
        }

        $this->db->order_by('role', 'ASC');

        $query = $this->db->get('user_role', $limit, $offset);
        return $query->result_array();
    }

    public function getCheckRoleName($data)
    {
        $this->db->select('role');
        $this->db->where('role', $data);

        $query = $this->db->get('user_role');

        if ($query->num_rows() > 0) {
            //Value exists in database
            return TRUE;
        } else {
            //Value doesn't exist in database
            return FALSE;
        }
    }

    public function insertRole($data)
    {
        $this->db->insert('user_role', $data);
    }

    public function updateRole($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('user_role', $data);
    }

    public function getAccessById($id)
    {
        return $this->db->get_where('user_role', ['id' => $id])->row_array();
    }

    public function updateAccessRole($data)
    {
        $query = $this->db->get_where('user_access_menu', $data);

        if ($query->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
        } else {
            $this->db->delete('user_access_menu', $data);
        }
    }

    public function modelDeleteRole($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user_role');
    }
}
