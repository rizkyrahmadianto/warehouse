<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        checkSessionLog();
    }

    public function index()
    {
        $info['title']     = 'Management Menu';
        $info['user']    = $this->Auth_model->getUserSession();

        $config['base_url']     = base_url() . 'menu/index';
        $config['total_rows']     = $this->db->count_all('user_menu');
        $config['per_page']     = 5;
        $config['uri_segment']     = 3;

        $choice = $config['total_rows'] / $config['per_page'];
        $config['num_links']     = floor($choice);

        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
        $config['full_tag_close']   = '</ul></nav></div>';

        $config['first_link']       = 'First';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close']  = '</span></li>';

        $config['last_link']        = 'Last';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close']   = '</span></li>';

        $config['next_link']        = '&gt;';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close']   = '<span aria-hidden="true"></span></span></li>';

        $config['prev_link']        = '&lt;';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close']   = '</span></li>';

        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';

        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';

        $this->pagination->initialize($config);

        $info['page']     = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $info['menu']    = $this->Menu_model->getAllMenu($config['per_page'], $info['page']);

        $info['pagination'] = $this->pagination->create_links();

        if ($this->input->post('search', true)) {
            $info['menu'] = $this->Menu_model->getSearchMenu($config['per_page'], $info['page']);
        }

        $this->load->view('templates/header', $info);
        $this->load->view('templates/sidebar', $info);
        $this->load->view('templates/topbar', $info);
        $this->load->view('menus/index', $info);
        $this->load->view('templates/footer');
    }

    public function addMenu()
    {
        $info['title']    = "Add New Menu";
        $info['user']    = $this->Auth_model->getUserSession();

        $this->form_validation->set_rules('name', 'menu name', 'trim|required|min_length[3]');

        $data = [
            'menu' => $this->security->xss_clean(html_escape($this->input->post('name', true)))
        ];

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $info);
            $this->load->view('templates/sidebar', $info);
            $this->load->view('templates/topbar', $info);
            $this->load->view('menu/add_menu', $info);
            $this->load->view('templates/footer');
        } else {
            $this->Menu_model->insertMenu($data);
            $this->session->set_flashdata('success', 'Added !');
            redirect('menu', 'refresh');
        }
    }

    public function editMenu($id)
    {
        $info['title']     = 'Edit Menu';
        $info['user']      = $this->Auth_model->getUserSession();
        $info['id']        = $this->Menu_model->getMenuById($id);

        $this->form_validation->set_rules('name', 'menu name', 'trim|required|min_length[3]');

        $file = ["menu" => $this->security->xss_clean(html_escape($this->input->post('name', true)))];

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $info);
            $this->load->view('templates/sidebar', $info);
            $this->load->view('templates/topbar', $info);
            $this->load->view('menus/edit_menu', $info);
            $this->load->view('templates/footer');
        } else {
            $this->Menu_model->updateMenu($file);
            $this->session->set_flashdata('success', 'Updated !');
            redirect('menu', 'refresh');
        }
    }

    public function deleteMenu($id)
    {
        $this->Menu_model->deleteMenu($id);
        $this->session->set_flashdata('success', 'Deleted !');
        redirect('menu', 'refresh');
    }

    public function subMenu()
    {
        $info['title']         = 'Management Sub Menu';
        $info['user']          = $this->Auth_model->getUserSession();

        $config['base_url']     = base_url() . 'menu/submenu';
        $config['total_rows']     = $this->Menu_model->getTotalRow();
        $config['per_page']     = 5;
        $config['uri_segment']     = 3;

        $choice = $config['total_rows'] / $config['per_page'];
        $config['num_links'] = floor($choice);

        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
        $config['full_tag_close']   = '</ul></nav></div>';

        $config['first_link']       = 'First';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close']  = '</span></li>';

        $config['last_link']        = 'Last';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close']   = '</span></li>';

        $config['next_link']        = '&gt;';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close']   = '<span aria-hidden="true"></span></span></li>';

        $config['prev_link']        = '&lt;';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close']   = '</span></li>';

        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';

        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';

        $this->pagination->initialize($config);

        $info['page']        = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $info['submenu']    = $this->Menu_model->getAllSubMenu($config['per_page'], $info['page']);

        $info['pagination'] =  $this->pagination->create_links();


        if ($this->input->post('search', true)) {
            $info['submenu'] = $this->Menu_model->getAllSubmenu($config['per_page'], $info['page']);
        }

        $this->load->view('templates/header', $info);
        $this->load->view('templates/sidebar', $info);
        $this->load->view('templates/topbar', $info);
        $this->load->view('submenus/index', $info);
        $this->load->view('templates/footer');
    }

    public function addSubMenu()
    {
        $info['title']         = 'Add New Management Sub Menu';
        $info['user']          = $this->Auth_model->getUserSession();
        $info['submenu']    = $this->Menu_model->getAllSubMenu_();
        $info['menu']        = $this->Menu_model->getAllMenu_();

        $this->form_validation->set_rules('name', 'submenu name', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('menu_opt', 'menu option', 'trim|required');
        $this->form_validation->set_rules('url', 'url', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('icon', 'icon', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('active', 'active submenu');

        $data = [
            'menu_id'   => $this->security->xss_clean(html_escape($this->input->post('menu_opt', true))),
            'url'       => $this->security->xss_clean(html_escape($this->input->post('url', true))),
            'title'     => $this->security->xss_clean(html_escape($this->input->post('name', true))),
            'icon'      => $this->security->xss_clean(html_escape($this->input->post('icon', true))),
            'is_active' => $this->security->xss_clean(html_escape($this->input->post('active', true)))
        ];

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $info);
            $this->load->view('templates/sidebar', $info);
            $this->load->view('templates/topbar', $info);
            $this->load->view('submenus/add_submenu', $info);
            $this->load->view('templates/footer');
        } else {
            $this->Menu_model->insertSubMenu($data);
            $this->session->set_flashdata('success', 'Added !');
            redirect('menu/submenu', 'refresh');
        }
    }

    public function editSubMenu($id)
    {
        $info['title']         = 'Edit Management Sub Menu';
        $info['user']          = $this->Auth_model->getUserSession();
        $info['submenu']    = $this->Menu_model->getSubMenuById($id);
        $info['menu']        = $this->Menu_model->getAllMenu_();

        $this->form_validation->set_rules('menu_opt', 'menu option', 'trim|required');
        $this->form_validation->set_rules('name', 'submenu name', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('url', 'url', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('icon', 'icon', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('active', 'active submenu');

        $data = [
            'menu_id'   => $this->security->xss_clean(html_escape($this->input->post('menu_opt', true))),
            'title'     => $this->security->xss_clean(html_escape($this->input->post('name', true))),
            'url'       => $this->security->xss_clean(html_escape($this->input->post('url', true))),
            'icon'      => $this->security->xss_clean(html_escape($this->input->post('icon', true))),
            'is_active' => $this->security->xss_clean(html_escape($this->input->post('active', true)))
        ];

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $info);
            $this->load->view('templates/sidebar', $info);
            $this->load->view('templates/topbar', $info);
            $this->load->view('submenus/edit_submenu', $info);
            $this->load->view('templates/footer');
        } else {
            $this->Menu_model->updateSubMenu($data);
            $this->session->set_flashdata('success', 'Edited !');
            redirect('menu/submenu', 'refresh');
        }
    }

    public function deleteSubMenu($id)
    {
        $this->Menu_model->deleteSubMenu($id);
        $this->session->set_flashdata('success', 'Deleted !');
        redirect('menu/submenu', 'refresh');
    }
}
