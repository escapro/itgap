<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Errors extends CI_Controller {

	public function show_404()
	{
		$this->load->view('errors/404.php');
	}
}
