<?php defined('BASEPATH') or exit('No direct script access allowed');

class Sitemap extends Frontend_controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $key = $this->input->get('key');
        if($key != 'RmxpY2sgTWVkaWE='){
            echo ajaxAuthorized();
        }

        $routes = $this->getRoutesURL();
        $pages  = $this->getCMSPages();
        $posts  = $this->getCMSPosts();
        $jobs  = $this->getJobs();

        $array = array_merge($routes, $pages, $posts, $jobs);
        $this->generateXML($array);

        echo 'Sitemap Generate Success!';
        redirect( site_url('admin') );
    }

    private function generateXML($array)
    {
        $xml = '';
        $xml .= '<?xml version="1.0" encoding="UTF-8"?>' . "\r\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">' . "\r\n";
        $xml .= "\r\n";

        foreach ($array as $data) {
            $xml .= "   <url>
       <loc>" . $data['url'] . "</loc>
       <lastmod>" . $data['lastmod'] . "</lastmod>
       <priority>" . $data['priority'] . "</priority>
   </url>" . "\r\n";
        }

        $xml .= "\r\n";
        $xml .= '</urlset>';
        file_put_contents( FCPATH . '/sitemap.xml', $xml);
        
    }
    

    private function formateLastmod($lastmod)
    {
        if ($lastmod == '0000-00-00 00:00:00' || $lastmod == '') {
            $lastmod = date('Y-m-d H:i:s');
        }

        $datetime = new DateTime($lastmod);
        return $datetime->format('Y-m-d\TH:i:sP');
    }

    private function getRoutesURL()
    {
        $routes = $this->router->routes;
        $data = [];
        foreach ($routes as $key => $value) {
            $num = preg_match('/(:num)/', $key);
            $any = preg_match('/(:any)/', $key);
            $controller = substr($value, 0, 8);

            if ($controller == 'frontend' && $num == 0 && $any == 0) {
                $data[] = [
                    'title'     => ucwords(str_replace(['-', '_'], ' ', $key)),
                    'url'       => base_url() . $key,
                    'priority'  => '1.00',
                    'lastmod'   => $this->formateLastmod(date('Y-m-d H:i:s')),
                ];
            }
        }
        return $data;
    }

    private function getCMSPosts()
    {
        $this->db->select('id, post_title, post_url, modified');
        $this->db->where('status', 'Publish');
        $this->db->where('post_type', 'post');
        $this->db->from('cms');
        $pages = $this->db->get()->result();

        $data = [];
        foreach ($pages as $page) {
            $data[] = [
                'title' => $page->post_title,
                'url' => base_url() . $page->post_url,
                'priority' => '0.80',
                'lastmod'   => $this->formateLastmod($page->modified),
            ];
        }
        return $data;
    }

    private function getJobs()
    {
        $this->db->select('id, title, updated_at');
        $this->db->where('status', 'Published');
        $this->db->where('deadline >', date('Y-m-d'));
        $this->db->from('jobs');
        $pages = $this->db->get()->result();

        $data = [];
        foreach ($pages as $page) {
            $data[] = [
                'title' => $page->title,
                'url' => site_url('job-details/'.$page->id.'/'.slugify($page->title).'.html'),
                'priority' => '0.80',
                'lastmod'   => $this->formateLastmod($page->updated_at),
            ];
        }
        return $data;
    }

    private function getCMSPages()
    {
        $this->db->select('id, post_title, post_url, modified');
        $this->db->where('status', 'Publish');
        $this->db->where('post_type', 'page');
        $this->db->from('cms');
        $pages = $this->db->get()->result();

        $data = [];
        foreach ($pages as $page) {
            $data[] = [
                'title' => $page->post_title,
                'url' => base_url() . $page->post_url,
                'priority' => '0.80',
                'lastmod'   => $this->formateLastmod($page->modified),
            ];
        }
        return $data;
    }
}
