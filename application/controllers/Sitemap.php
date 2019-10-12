<?php
class Sitemap extends CI_Controller {

	private $time = '';

	public function __construct()
	{
		parent::__construct();
		if(!is_cli()) {
			exit("Error 404");
		}
		$this->load->model('post_model');

		$this->time = date('Y-m-d').'T'.date('H:i:s').'+00:00';
	}

    public function generate()
    {

		$xml = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
		$xml .= $this->generate_tags();
		$xml .= $this->generate_posts();
		$xml .= '</urlset>';

		$dom = new DOMDocument;
		$dom->preserveWhiteSpace = FALSE;
		$dom->loadXML($xml);
		$dom->save('sitemap.xml');
	}

	private function generate_posts(){
		$string = '';
		$changefreq = 'daily';
		$priority = 1;

		$posts = $this->post_model->get_posts();
		
		foreach ($posts as $key => $value) {
			$string .= '<url>';
			$string .= '<loc>';
			$string .= base_url().$value['tag_url'].'/'.$value['post_name'];
			$string .= '</loc>';
			$string .= '<lastmod>';
			$string .= $this->time;
			$string .= '</lastmod>';
			$string .= '<changefreq>'.$changefreq.'</changefreq>';
			$string .= '<priority>'.$priority.'</priority>';
			$string .= '</url>';
		}
		return $string;
	}
	
	private function generate_tags(){
		$string = '';
		$changefreq = 'daily';
		$priority = 1;

		$tags = $this->post_model->get_tags()['tags'];

		foreach ($tags as $key => $value) {
			$string .= '<url>';
			$string .= '<loc>';
			$string .= base_url().'tag/'.$value['tag'];
			$string .= '</loc>';
			$string .= '<lastmod>';
			$string .= $this->time;
			$string .= '</lastmod>';
			$string .= '<changefreq>'.$changefreq.'</changefreq>';
			$string .= '<priority>'.$priority.'</priority>';
			$string .= '</url>';
		}
		return $string;
	}
}