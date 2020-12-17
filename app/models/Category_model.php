<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model {

	function __construct()
	{
		parent::__construct(); // construct the Model class
	}

	// SITEMAP USE
	public function get_categories () {
		$this->db->select("*");
		$this->db->from("categories");
		$query = $this->db->get();
		$data = $query->result_array();
		return $data;
	}

	public function get_category ($url) {
		$this->db->select("*");
		$this->db->from("categories");
		$this->db->where("url_name", $url);
		$query = $this->db->get();
		$data = $query->result_array();
		return $data[0];
	}
}