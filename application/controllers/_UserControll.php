<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserControll extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        checkSessionLog();
    }

    public function index()
    {
        $info['title']  = 'User Controll';
        $info['user']   = $this->Auth_model->getUserSession();

        // SEARCHING
        if ($this->input->post('search', true)) {
            $info['keyword'] = $this->input->post('search', true);
            $this->session->set_userdata('keyword', $info['keyword']);
        } else {
            $info['keyword'] = $this->session->set_userdata('keyword');
        }
        // SEARCHING

        // DB PAGINATION FOR SEARCHING
        $this->db->like('id', $info['keyword']);
        $this->db->or_like('role', $info['keyword']);
        $this->db->from('user_role');
        // DB PAGINATION FOR SEARCHING

        $config['base_url']     = base_url() . 'usercontroll/index';
        $config['total_rows']   = $this->db->count_all_results();
        $config['per_page']     = 5;
        $config['num_links']    = 5;

        // STYLING
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
        $config['full_tag_close']   = '</ul></nav></div>';

        $config['first_link']       = 'First';
        $config['first_tag_open']   = '<li class="page-item">';
        $config['first_tag_close']  = '</li>';

        $config['last_link']        = 'Last';
        $config['last_tag_open']    = '<li class="page-item">';
        $config['last_tag_close']   = '</li>';

        $config['next_link']        = '&raquo';
        $config['next_tag_open']    = '<li class="page-item">';
        $config['next_tag_close']   = '</li>';

        $config['prev_link']        = '&laquo';
        $config['prev_tag_open']    = '<li class="page-item">';
        $config['prev_tag_close']   = '</li>';

        $config['cur_tag_open']     = '<li class="page-item active"><a class="page-link">';
        $config['cur_tag_close']    = '</a></li>';

        $config['num_tag_open']     = '<li class="page-item">';
        $config['num_tag_close']    = '</li>';
        $config['attributes']       = array('class' => 'page-link');
        // STYLING

        $this->pagination->initialize($config);

        $info['start'] = $this->uri->segment(3);
        $info['usercontroll'] = $this->UserControll_model->getAllUser($config['per_page'], $info['start'], $info['keyword']);

        $info['pagination'] = $this->pagination->create_links();


        $this->load->view('templates/header', $info);
        $this->load->view('templates/sidebar', $info);
        $this->load->view('templates/topbar', $info);
        $this->load->view('user-controlls/index', $info);
        $this->load->view('templates/footer');
    }

    public function editUserControll($id)
    {
        $info['title']          = 'Edit Role';
        $info['user']           = $this->Auth_model->getUserSession();
        $info['usercontroll']   = $this->UserControll_model->getUserControllById($id);

        $data = [
            'role_id' => $this->security->xss_clean(html_escape($this->input->post('role', true))),
            'is_active' => $this->security->xss_clean(html_escape($this->input->post('status', true)))
        ];

        $this->Menu_model->updateUserControll($data);
        $this->session->set_flashdata('success', 'Edited !');
        redirect('usercontroll', 'refresh');
    }

    public function deleteUserControll($id)
    {
        $this->UserControll_model->deleteUserControll($id);
        $this->session->set_flashdata('success', 'Deleted !');
        redirect('usercontroll', 'refresh');
    }
}
