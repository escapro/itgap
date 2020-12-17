<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	public function get_description ($type) {
		$this->db->select("text");
		$this->db->from("page_descriptions");
		$this->db->where("type", $type);
		$query = $this->db->get();
		$data = $query->result_array();
		return $data[0]['text'];
	}
}