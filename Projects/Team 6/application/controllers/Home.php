<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {

		parent::__construct();
		$this->load->library(array('session'));
		$this->load->helper(array('url'));
		$this->load->model('user_model');

	}
	public function index()
	{
		$data = new stdClass();

		$this->load->view('header');
		$this->load->view('home', $data);
		$this->load->view('footer');
	}
}
