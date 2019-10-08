<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model {

	function __construct()
	{
		parent::__construct(); // construct the Model class
	}

	public function get_categories () {
		$this->db->select("*");
		$this->db->from("categories");
		$query = $this->db->get();
		$data = $query->result_array();
		return $data;
	}
}