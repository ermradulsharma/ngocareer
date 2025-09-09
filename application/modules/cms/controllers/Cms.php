<?php defined('BASEPATH') or exit('No direct script access allowed');

/* Author: Khairul Azam
 * Date : 2016-10-11
 */

class Cms extends Admin_controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Cms_model');
        $this->load->helper('cms');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q      = urldecode($this->input->get('q', TRUE));
        $start  = intval($this->input->get('start'));


        $config['base_url']     = build_pagination_url(Backend_URL . 'cms', 'start');
        $config['first_url']    = build_pagination_url(Backend_URL . 'cms', 'start');


        $config['per_page']     = 25;
        $config['page_query_string'] = TRUE;


        $config['total_rows'] = $this->Cms_model->total_rows($q);
        $cms = $this->Cms_model->get_limit_data($config['per_page'], $start, $q);


        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $new_tree = array();
        foreach ($cms as $page) {
            $new_tree[$page->id]            = (array) $page;
            $new_tree[$page->id]['name']    = $page->post_title;
            $new_tree[$page->id]['child']   = $this->butildCMSTree($page->id);
        }

        $data = array(
            'cms_data'   => $new_tree,
            'q'          => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start'      => $start,
        );
        $this->viewAdminContent('cms/page/index', $data);
    }

    private function butildCMSTree($parent_id = 0)
    {
        $this->db->select('id,parent_id,post_title,post_url,status,page_order,created,modified');
        $this->db->where('parent_id', $parent_id);
        $this->db->where('post_type', 'page');
        $this->db->order_by('page_order', 'ASC');
        return $this->db->get('cms')->result();
    }

    public function create()
    {
        $data = array(
            'button' => 'Create Page',
            'action' => site_url('admin/cms/create_action'),
            'id' => set_value('id'),
            'user_id' => set_value('user_id'),
            'parent_id' => set_value('parent_id'),
            'post_type' => set_value('post_type'),
            'menu_name' => set_value('menu_name'),
            'post_title' => set_value('post_title'),
            'post_url' => set_value('post_url'),
            'content' => set_value('content'),
            'seo_title' => set_value('seo_title'),
            'seo_keyword' => set_value('seo_keyword'),
            'seo_description' => set_value('seo_description'),
            'thumb' => set_value('thumb'),
            'template' => set_value('template'),
            'created' => set_value('created'),
            'modified' => set_value('modified'),
            'status' => set_value('status'),
            'page_order' => set_value('page_order'),
            'revisions_data' => []
        );

        $this->viewAdminContent('cms/page/form', $data);
    }

    public function create_action()
    {

        $photo = uploadPhoto($_FILES['thumb'], 'uploads/cms/banner/', date('Y-m-d-H-i-s_') . rand(0, 9));

     
        
        $data = array(
            'user_id'       => $this->user_id,
            'parent_id'     => (int) $this->input->post('parent_id'),
            'post_type'     => 'page',
            'menu_name'     => $this->input->post('post_title', TRUE),
            'post_title'    => $this->input->post('post_title', TRUE),
            'post_url'      => slugify($this->input->post('post_url', TRUE)),
            'content'       => $_POST['content'],
            'seo_title'     => $this->input->post('seo_title', TRUE),
            'seo_keyword'   => $this->input->post('seo_keyword', TRUE),
            'seo_description' => $this->input->post('seo_description', TRUE),
            'thumb'         => $photo,
            'template'      => $this->input->post('template', TRUE),
            'status'        => $this->input->post('status', TRUE),
            'page_order'    => $this->input->post('page_order', TRUE),
            'created'       => date('Y-m-d H:i:s'),
            'modified'      => date('Y-m-d H:i:s'),
        );

        $this->Cms_model->insert($data);
        $page_id = $this->db->insert_id();
        $this->session->set_flashdata('msgs', 'Page Created Successfully.');
        redirect(site_url(Backend_URL . "cms/update/{$page_id}"));
    }

    public function update($id)
    {

        $row = $this->Cms_model->get_by_id($id);
        
        $revision_id = (int) $this->input->get('rev_id');
        
        if($revision_id){
            $row = $this->Cms_model->get_restore_point($revision_id);
            $row->post_url = current(explode(':', $row->post_url));
        }                
        
        if ($row) {
            $data = array(
                'button' => 'Update Page',
                'action' => site_url(Backend_URL . 'cms/update_action'),
                'id' => set_value('id', $id),
                'user_id' => set_value('user_id', $row->user_id),
                'parent_id' => set_value('parent_id', $row->parent_id),
                'post_type' => set_value('post_type', $row->post_type),
                'menu_name' => set_value('menu_name', $row->menu_name),
                'post_title' => set_value('post_title', $row->post_title),
                'post_url' => set_value('post_url', $row->post_url),
                'content' => set_value('content', $row->content),
                'seo_title' => set_value('seo_title', $row->seo_title),
                'seo_keyword' => set_value('seo_keyword', $row->seo_keyword),
                'seo_description' => set_value('seo_description', $row->seo_description),
                'thumb' => set_value('thumb', $row->thumb),
                'template' => set_value('template', $row->template),
                'status' => set_value('status', $row->status),
                'page_order' => set_value('page_order', $row->page_order),
            );
            $data['revisions'] = $this->Cms_model->get_revisions( $id );
            $this->viewAdminContent('cms/page/form', $data);
        } else {
            $this->session->set_flashdata('msgw', 'Page Not Found');
            redirect(site_url(Backend_URL . 'cms'));
        }
    }

    public function update_action()
    {
        $page_id = intval($this->input->post('id', TRUE));

        $this->cmsRevision($page_id);

        
        $row   = $this->db->get_where('cms', ['id' => $page_id])->row();
        $photo = uploadPhoto($_FILES['thumb']['name'], 'uploads/cms/banner/', uniqid('ban_') );                

        if (empty($_FILES['thumb']['name'])) {
            $photo = $row->thumb;
        } else {
            removeImage($row->thumb);
        }

        $data = array(
            'parent_id' => $this->input->post('parent_id', TRUE),
            'post_type' => 'page',
            'menu_name' => $this->input->post('post_title', TRUE),
            'post_title' => $this->input->post('post_title', TRUE),
            'post_url' => slugify($this->input->post('post_url', TRUE)),
            'content' => $_POST['content'],
            'seo_title' => $this->input->post('seo_title', TRUE),
            'seo_keyword' => $this->input->post('seo_keyword', TRUE),
            'seo_description' => $this->input->post('seo_description', TRUE),
            'thumb' => $photo,
            'template' => $this->input->post('template', TRUE),
            'status' => $this->input->post('status', TRUE),
            'page_order' => intval($this->input->post('page_order', TRUE)),
            'modified' => date('Y-m-d H:i:s'),
        );

        $this->Cms_model->update($page_id, $data);
        $this->session->set_flashdata('msgs', 'Update Record Success');
        redirect(site_url(Backend_URL . 'cms/update/' . $page_id));
    }

    public function delete($id)
    {
        $this->load->library('user_agent');
        $ref_url = $this->agent->referrer();

        //dd( $ref_url );

        $row = $this->Cms_model->get_by_id($id);
        if ($row) {
            removeImage($row->thumb);
            $this->Cms_model->delete($id);

            $this->db->where('obj_id', $id);
            $this->db->delete('cms_relations', $id);

            $this->session->set_flashdata('msgs', 'Post/Page Deleted Successfully');
            redirect($ref_url);
        } else {
            $this->session->set_flashdata('msgw', 'Post/Page Not Found');
            redirect($ref_url);
        }
    }

    // for using blog post 
    public function posts()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        $config['base_url']     = build_pagination_url(Backend_URL . 'cms/posts/', 'start');
        $config['first_url']    = build_pagination_url(Backend_URL . 'cms/posts/', 'start');

        $config['per_page'] = 25;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Cms_model->total_rows_post($q);

        $posts = $this->Cms_model->get_data_for_post($config['per_page'], $start, $q);
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'posts' => $posts,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->viewAdminContent('cms/post/index', $data);
    }

    public function update_status()
    {
        $post_id    = intval($this->input->post('post_id'));
        $status     = $this->input->post('status');
        $this->db->set('status', $status)->where('id', $post_id)->update('cms');

        switch ($status) {
            case 'Publish':
                $status = '<i class="fa fa-check"></i> Publish';
                $class = 'btn-success';
                break;
            case 'Trash':
                $status = '<i class="fa fa-trash-o"></i> Trash';
                $class = 'btn-danger';
                break;
            case 'Draft':
                $status = '<i class="fa fa-file-o" ></i> Draft';
                $class = 'btn-default';
                break;
        }
        echo json_encode(['Status' => $status . ' &nbsp; <i class="fa fa-angle-down"></i>', 'Class' => $class]);
    }

    public function new_post()
    {
        $data = array(
            'button'     => 'Create Post',
            'action'     => site_url(Backend_URL . 'cms/create_action_post'),
            'id'         => set_value('id'),
            'user_id'    => set_value('user_id'),
            'parent_id'  => set_value('parent_id'),
            'post_type'  => set_value('post_type'),
            'menu_name'  => set_value('menu_name'),
            'post_title' => set_value('post_title'),
            'post_url'   => set_value('post_url'),
            'content'    => set_value('content'),
            'seo_title'  => set_value('seo_title'),
            'seo_keyword' => set_value('seo_keyword'),
            'seo_description' => set_value('seo_description'),
            'thumb'     => set_value('thumb'),
            'template'  => set_value('template'),
            'created'   => set_value('created'),
            'modified'  => set_value('modified'),
            'status'    => set_value('status'),
            'page_order' => set_value('page_order'),
        );
        $this->viewAdminContent('cms/post/form', $data);
    }

    public function create_action_post()
    {
        $photo = uploadPhoto($_FILES['thumb'], 'uploads/cms/post/', date('Y-m-d-H-i-s_') . rand(0, 9));
        $data = array(
            'user_id'       => $this->user_id,
            'parent_id'     => $this->input->post('parent_id', TRUE),
            'post_type'     => 'post',
            'menu_name'     => $this->input->post('post_title', TRUE),
            'post_title'    => $this->input->post('post_title', TRUE),
            'post_url'      => slugify($this->input->post('post_url', TRUE)),
            'content'       => $_POST['content'],
            'seo_title'     => $this->input->post('seo_title', TRUE),
            'seo_keyword'   => $this->input->post('seo_keyword', TRUE),
            'seo_description' => $this->input->post('seo_description', TRUE),
            'thumb' => $photo,
            'template' => '',
            'status' => $this->input->post('status', TRUE),
            'page_order' => 0,
            'created' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s'),
        );

        $this->Cms_model->insert($data);
        $insert_id = $this->db->insert_id();
        $this->session->set_flashdata('msgs', 'Post Added Successfully');
        redirect(site_url(Backend_URL . 'cms/update_post/' . $insert_id));
    }

    public function update_post($id)
    {
        $row = $this->Cms_model->get_by_id($id);
        if ($row) {
            $data = array(
                'button'            => 'Update Post',
                'action'            => site_url(Backend_URL . 'cms/update_action_post'),
                'id'                => set_value('id', $row->id),
                'user_id'           => set_value('user_id', $row->user_id),
                'parent_id'         => set_value('parent_id', $row->parent_id),
                'post_type'         => set_value('post_type', $row->post_type),
                'menu_name'         => set_value('menu_name', $row->menu_name),
                'post_title'        => set_value('post_title', $row->post_title),
                'post_url'          => set_value('post_url', $row->post_url),
                'content'           => set_value('content', $row->content),
                'seo_title'         => set_value('seo_title', $row->seo_title),
                'seo_keyword'       => set_value('seo_keyword', $row->seo_keyword),
                'seo_description'   => set_value('seo_description', $row->seo_description),
                'thumb'             => set_value('thumb', $row->thumb),
                //'template' => set_value('template', $row->template),
                'created'           => set_value('created', $row->created),
                'modified'          => set_value('modified', $row->modified),
                'status'            => set_value('status', $row->status),
                //'page_order' => set_value('page_order', $row->page_order),
            );
            $this->viewAdminContent('cms/post/form', $data);
        } else {
            $this->session->set_flashdata('msgw', 'Post Not Found');
            redirect(site_url('cms/posts'));
        }
    }

    public function update_action_post()
    {

        $id = (int) $this->input->post('id');
        $old_thumb = $this->input->post('old_thumb', TRUE);

        $photo = uploadPhoto($_FILES['thumb'], 'uploads/cms/post/', date('Y-m-d-H-i-s_') . rand(0, 9));

        if (empty($_FILES['thumb']['name'])) {
            $photo = $old_thumb;
        } else {
            removeImage($old_thumb);
        }

        $data = array(
            'parent_id'     => (int) $this->input->post('parent_id'),
            'menu_name'     => $this->input->post('post_title', TRUE),
            'post_title'    => $this->input->post('post_title', TRUE),
            'post_url'      => slugify($this->input->post('post_url', TRUE)),
            'content'       => $this->input->post('content', TRUE),
            'seo_title'     => $this->input->post('seo_title', TRUE),
            'seo_keyword'   => $this->input->post('seo_keyword', TRUE),
            'seo_description' => $this->input->post('seo_description', TRUE),
            'thumb'         => $photo,
            'status'        => $this->input->post('status', TRUE),
            'modified'      => date('Y-m-d H:i:s'),
        );

        $this->Cms_model->update($id, $data);
        $this->session->set_flashdata('msgs', 'Post Updated Successfully');
        redirect(site_url(Backend_URL . "cms/update_post/{$id}"));
    }

    private function cmsRevision($id)
    {
        $row = $this->Cms_model->get_row($id);
        if ($row) {
            $data = array(
                'user_id' => $row->user_id,
                'parent_id' => $id,
                'post_type' => 'inherit',
                'menu_name' => $row->menu_name,
                'post_title' => $row->post_title,
                'post_url' => $row->post_url . uniqid(':revision_'),
                'content' => $row->content,
                'seo_title' => $row->seo_title,
                'seo_keyword' => $row->seo_keyword,
                'seo_description' => $row->seo_description,
                'thumb' => $row->thumb,
                'template' => $row->template,
                'status' => 'Revision',
                'page_order' => $row->page_order,
                'created' => date('Y-m-d H:i:s'),
            );
            $this->db->insert('cms', $data);
        }
        return TRUE;
    }

    public function remove_featured_image(){
        ajaxAuthorized();

        $id = (int) $this->input->post('id');

        $row = $this->db->select('thumb')->get_where('cms', ['id' => $id])->row();

        if($row){
            removeImage($row->thumb);
            $this->db->update('cms', ['thumb' => null], ['id' => $id]);
            echo ajaxRespond('OK', '<p class="ajax_success">Featured image remove success!</p>');
        } else{
            echo ajaxRespond('FAIL', '<p class="ajax_error">Something went wrong please try again!</p>');
        }        
    }

    public  function _menu()
    {
        return buildMenuForMoudle([
            'module'    => 'CMS',
            'icon'      => 'fa-list',
            'href'      => 'cms',
            'children'  => [
                [
                    'title' => 'Pages',
                    'icon'  => 'fa fa-file-o',
                    'href'  => 'cms'
                ], [
                    'title' => ' |__ New Page',
                    'icon'  => 'fa fa-circle-o',
                    'href'  => 'cms/create'
                ], [
                    'title' => 'Post',
                    'icon'  => 'fa fa-file-o',
                    'href'  => 'cms/posts'
                ], [
                    'title' => ' |__ New Post',
                    'icon'  => 'fa fa-circle-o',
                    'href'  => 'cms/new_post'
                ], [
                    'title' => ' |__ Comments',
                    'icon'  => 'fa fa-comment',
                    'href'  => 'cms/comment'
                ], [
                    'title' => ' |__ Manage Category',
                    'icon'  => 'fa fa-circle-o',
                    'href'  => 'cms/category'
                ], [
                    'title' => 'Menu Manager',
                    'icon'  => 'fa fa-gear',
                    'href'  => 'cms/menu'
                ], [
                    'title' => 'Widget Manager',
                    'icon'  => 'fa fa-gear',
                    'href'  => 'cms/widget'
                ]
            ]
        ]);
    }
}
