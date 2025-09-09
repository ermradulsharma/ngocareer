<?php

defined('BASEPATH') or exit('No direct script access allowed');
/* Author: Khairul Azam
 * Date : 2016-11-04
 */

class Menu extends Admin_controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Menu_model');
        $this->load->helper('menu');
        $this->load->helper('cms');
    }

    public function index()
    {
        $id     = (int) $this->input->get('id');
        $pages  = $this->Menu_model->selectable_menu_option();
        $categories  = $this->Menu_model->selectable_categories_menu_option();
        $menus  = $this->Menu_model->getMenus($id);

        $tree = [];
        foreach ($menus as $item) {
            $tree[$item['parent_id']][] = $item;
        }

        $data['id'] = $id;
        $data['menus'] = $tree;
        $data['pages'] = $pages;
        $data['categories'] = $categories;

        $this->viewAdminContent('cms/menu/index', $data);
    }

    public function add_menu()
    {
        $data = [
            'parent' => 0,
            'type'  => 'menu',
            'name'  => $this->input->post('new_menu'),
            'url'   => $this->input->post('new_menu') . rand(4444, 5555) . '.html',
        ];
        $this->db->insert('cms_options', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            $this->session->set_flashdata('msgs', 'New Menu Added!');
            redirect(Backend_URL . "cms/menu/?id={$insert_id}");
        } else {
            $this->session->set_flashdata('msge', 'New Menu Added Faild!');
            redirect(Backend_URL . 'cms/menu');
        }
    }

    public function delete_menu()
    {
        ajaxAuthorized();

        $menu_id = $this->input->post('menu_id');
        $this->db->trans_start();
        $this->db->delete('cms_options', ['id' => $menu_id]);
        $this->db->delete('cms_relations', ['opt_id' => $menu_id]);
        $this->db->trans_complete();
        echo ajaxRespond('OK', '<p class="ajax_success">Menu Delete Success!</p>');
    }

    public function add_category_to_menu()
    {
        $menu_id    = $this->input->post('id');
        $category_ids   = $this->input->post('category_ids');
        $menus      = array();

        foreach ($category_ids as $category_id) {
            $menus[] = array(
                'opt_id' => $menu_id,
                'parent' => 0,
                'obj_id' => $category_id,
                'order'  => 0,
                'type'   => 'category',
            );
        }

        if (!empty($menus)) {
            $this->db->insert_batch('cms_relations', $menus);
            $this->session->set_flashdata('msgs', 'New Category Added With Menu');
            redirect(Backend_URL . "cms/menu/?id={$menu_id}");
        } else {
            $this->session->set_flashdata('msge', 'No Category Added');
            redirect(Backend_URL . "cms/menu/?id={$menu_id}");
        }
    }

    public function add_page_to_menu()
    {
        $menu_id    = $this->input->post('id');
        $page_ids   = $this->input->post('page_ids');
        $menus      = array();

        foreach ($page_ids as $page_id) {
            $menus[] = array(
                'opt_id' => $menu_id,
                'parent' => 0,
                'obj_id' => $page_id,
                'order'  => 0,
                'type'   => 'page',
            );
        }

        if (!empty($menus)) {
            $this->db->insert_batch('cms_relations', $menus);
            $this->session->set_flashdata('msgs', 'New Page Added With Menu');
            redirect(Backend_URL . "cms/menu/?id={$menu_id}");
        } else {
            $this->session->set_flashdata('msge', 'No Page Added');
            redirect(Backend_URL . "cms/menu/?id={$menu_id}");
        }
    }

    public function add_custom_link_to_menu()
    {
        $menu_id    = (int) $this->input->post('id');

        $this->db->insert('cms', [
            'user_id' => $this->user_id,
            'post_type' => 'link',
            'menu_name' => $this->input->post('title'),
            'post_title' => $this->input->post('title'),
            'post_url' => $this->input->post('url'),
            'status' => 'Publish',
            'created' => date('Y-m-d H:i:s'),
        ]);

        $page_id = $this->db->insert_id();
        
        $menus = array(
            'opt_id' => $menu_id,
            'parent' => 0,
            'obj_id' => $page_id,
            'order'  => 0,
            'type'   => 'link',
        );

        if (!empty($menus)) {
            $this->db->insert('cms_relations', $menus);
            $this->session->set_flashdata('msgs', 'New Link Added With Menu');
            redirect(Backend_URL . "cms/menu/?id={$menu_id}");
        } else {
            $this->session->set_flashdata('msge', 'No Page Added');
            redirect(Backend_URL . "cms/menu/?id={$menu_id}");
        }
    }


    public function save_order()
    {
        ajaxAuthorized();
        $json_string = $this->input->post('json');

        $items = json_decode($json_string, true);
        if (empty($items)) {
            echo ajaxRespond('Fail', '<p class="ajax_error">Noting Saved.</p>');
            exit;
        }

        $menu = array();
        $order = 0;
        foreach ($items as $item) {
            ++$order;
            $menu[] = array(
                'id' => $item['id'],
                'parent' => 0,
                'order' => $order
            );
            if (!empty($item['children'])) {
                foreach ($item['children'] as $child) {
                    ++$order;
                    $menu[] = array(
                        'id' => $child['id'],
                        'parent' => $item['id'],
                        'order' => $order
                    );

                    if (!empty($child['children'])) {
                        foreach ($child['children'] as $third) {
                            ++$order;
                            $menu[] = array(
                                'id' => $third['id'],
                                'parent' => $child['id'],
                                'order' => $order
                            );
                        }
                    }
                }
            }
        }
        if (!empty($menu)) {
            $this->db->update_batch('cms_relations', $menu, 'id');
            echo ajaxRespond('OK', '<p class="ajax_success">Menu Saved.</p>');
        } else {
            echo ajaxRespond('Fail', '<p class="ajax_error">Noting Saved.</p>');
        }
    }

    public function item_remove()
    {
        ajaxAuthorized();
        $page_id = $this->input->post('id');
        $this->db->where('id', $page_id);
        $this->db->delete('cms_relations');
        echo ajaxRespond('OK', '<p class="ajax_success">Page Removed From Menu</p>');
    }

    public function item_edit()
    {
        ajaxAuthorized();
        $id     = (int) $this->input->post('id');

        $this->db->select('opr.id, opr.parent, opr.type');
        $this->db->select('opr.obj_id');

        $this->db->select("case when `opr`.`type` = 'category' then op.name else c.menu_name END AS menu_title");
        
        $this->db->from('cms_relations as opr');
        $this->db->join('cms_options as op', 'op.id=opr.obj_id', 'LEFT');
        $this->db->join('cms as c', 'c.id=opr.obj_id', 'LEFT');
        $this->db->where('opr.id', $id);
        $cms = $this->db->get()->row();

        $html = '';
        $html .= "<input name=\"rel_id\" value=\"{$id}\" type=\"hidden\"/>";
        $html .= "<input name=\"obj_id\" value=\"{$cms->obj_id}\" type=\"hidden\"/>";
        $html .= "<input name=\"type\" value=\"{$cms->type}\" type=\"hidden\"/>";
        $html .= "<input id=\"title\" name=\"title\" value=\"{$cms->menu_title}\" type=\"text\" class=\"form-control\"/>";
        echo $html;
    }

    public function item_edit_action()
    {
        ajaxAuthorized();
        $obj_id = (int) $this->input->post('obj_id');
        $rel_id = (int) $this->input->post('rel_id');
        $type   = $this->input->post('type');
        $title  = $this->input->post('title');

        if($type == 'page' || $type == 'link'){
            $this->db->set('menu_name', $title);
            $this->db->where('id', $obj_id);
            $respond = $this->db->update('cms');
        } elseif($type == 'category'){
            $this->db->set('name', $title);
            $this->db->where('id', $obj_id);
            $respond = $this->db->update('cms_options');
        }

        if ($respond) {
            echo ajaxRespond('OK', '<p class="ajax_success">Title Saved Successfully</p>');
        } else {
            echo ajaxRespond('Fail', '<p class="ajax_error">Update Fail</p>');
        }
    }
}
