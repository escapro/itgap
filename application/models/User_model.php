<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	public function get_userData () {
		$this->db->select("*");
		$this->db->from("user");
		$query = $this->db->get();
		$data = $query->result_array();
		return $data;
	}

	public function get_user_avatar ($user_id) {
		$this->db->select("image_url");
		$this->db->from("user_avatars");
		$this->db->where("user_id", $user_id);
		$query = $this->db->get();
		$data = $query->result_array();
		return $data[0]['image_url'];
	}
}