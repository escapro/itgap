<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Url extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
	}

	public function redirect($url)
	{
        if($url === 'bM3oLxMJeGE') {
            redirect('https://ad.admitad.com/g/2okw72te6g3e3da004095fb557f5d8/?i=4&subid=timeweb', 'refresh');
        }
    }
}
