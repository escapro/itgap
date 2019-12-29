<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search_model extends CI_Model {

	private $offsetCount = POST_COUNT;

	function __construct()
	{
		parent::__construct();
	}

	public function search ($search_query, $page=1) {
		$this->db->select("p.title, p.preview_text, p.post_id as post_id, p.last_change, p.preview_image_url as image_url, p.post_name");
		$this->db->from("posts p");
		$this->db->join('active_posts a', 'p.id=a.post_id');
		$this->db->like('p.title', $search_query);
		$this->db->or_like('p.preview_text', $search_query);
		$this->db->order_by('p.last_change', 'desc');
		if($page !== 0) {
			$offset = ($page * $this->offsetCount) - $this->offsetCount;	
			$this->db->limit($this->offsetCount, $offset);
		}
		$query = $this->db->get();
		$data['posts'] = $query->result_array();


		$this->db->select("p.id");
		$this->db->from("posts p");
		$this->db->join('active_posts a', 'p.id=a.post_id');
		$this->db->like('p.title', $search_query);
		$query = $this->db->get();
		$post_count = count($query->result_array());
		$leftPages = $post_count / $this->offsetCount;
		$data['isLastPage'] = 0;
		if ($leftPages < $page) {
			$data['isLastPage'] = 1;
		}

		return $data;
	}
}