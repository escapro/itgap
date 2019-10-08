<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	public function search ($query) {
		$this->db->select("p.title, t.title as tag, p.preview_text, p.post_id as post_id, p.last_change, p.preview_image_url as image_url, p.post_name, t.tag as tag_url");
		$this->db->from("posts p");
		$this->db->join('active_posts a', 'p.id=a.post_id');
		$this->db->join('tags t', 't.id=p.tag_id');
		$this->db->like('p.title', $query);
		$query = $this->db->get();
		$data = $query->result_array();
		return $data;
	}
}