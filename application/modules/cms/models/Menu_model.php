<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends Fm_model {

    public function __construct() {
        parent::__construct();
    }
         
    public function getMenus($id = 0) {
        if($id == 0){ return array(); }
        
        $this->db->select('opr.id, opr.parent');
        $this->db->select('opr.obj_id');

        $this->db->select("case when `opr`.`type` = 'category' then op.name else c.menu_name END AS menu_title");
        
        $this->db->from('cms_relations as opr');
        $this->db->join('cms_options as op', 'op.id=opr.obj_id', 'LEFT');
        $this->db->join('cms as c', 'c.id=opr.obj_id', 'LEFT');
        $this->db->where('opr.opt_id', $id);
        $this->db->order_by('opr.order', 'ASC');
        $menus = $this->db->get()->result();

        $array = array();
        foreach ($menus as $menu) {
            $array[$menu->id] = array(
                'id'        => $menu->id,
                'parent_id' => $menu->parent,
                'title'     => $menu->menu_title
            );
        }
        return $array;
    }

    public function selectable_menu_option() {
        
        $this->db->select('*');        
        $this->db->where('post_type', 'page');
        $this->db->where('status', 'Publish');
        $this->db->order_by('page_order', 'ASC');
        $page_list = $this->db->get('cms')->result();
                        
        $pages = array();
        foreach ($page_list as $page) {
            $pages[$page->id] = array(
                'id' => $page->id,
                'title' => $page->post_title,
                'parent_id' => $page->parent_id
            );
        }
        return selectable_menu_tree($pages, 0);
    }


    public function selectable_categories_menu_option() {
        $this->db->select('*');
        $this->db->where('type', 'category');
        $this->db->order_by('id', 'DESC');
        $cat_list = $this->db->get('cms_options')->result();
                        
        $categories = array();
        foreach ($cat_list as $cat) {
            $categories[$cat->id] = array(
                'id' => $cat->id,
                'title' => $cat->name,
                'parent_id' => $cat->parent,
                'url' => $cat->url,
            );
        }
        return selectable_category_menu_tree($categories, 0);
    }
      
}
