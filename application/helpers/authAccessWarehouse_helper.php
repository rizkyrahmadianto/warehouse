<?php
function checkSessionLog()
{
    $check = &get_instance();

    if (!$check->session->userdata('email')) {
        redirect('auth');
    } else {
        $id_role = $check->session->userdata('role_id');

        // Karena ngecek http://localhost/sensus/menu "Menu"-nya segment = 1, 
        // Kalau http://localhost/sensus/menu/add "add"nya segment = 2 dst
        $menu = $check->uri->segment(1);

        //  Metod ini hanya menjawab jika submenu hanya sedikit
        // $query = $check->db->get_where('user_menu', ['menu' => $menu])->row_array();
        // $id_menu = $query['id'];

        // $access = $check->db->get_where('user_access_menu', [
        //     'role_id' => $id_role,
        //     'menu_id' => $id_menu
        // ]);

        // if ($access->num_rows() < 1) {
        //     redirect('auth/denied');
        // }

        //  Metode ini hanya menjawab jika submenu banyak
        $query = $check->db->get_where('user_sub_menu', ['level' => $menu])->row_array();
        $id_menu = $query['menu_id'];

        $access = $check->db->get_where('user_access_menu', [
            'role_id' => $id_role,
            'menu_id' => $id_menu
        ])->row_array();

        if (empty($access)) {
            redirect('auth/denied');
        }
    }
}

function checkAccess($role_id, $menu_id)
{
    $check = &get_instance();

    /*$check->db->where('role_id', $role_id);
		$check->db->where('menu_id', $menu_id);
        $result = $check->db->get('user_access_menu');*/

    $result = $check->db->get_where('user_access_menu', [
        'role_id' => $role_id,
        'menu_id' => $menu_id
    ]);


    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
}
