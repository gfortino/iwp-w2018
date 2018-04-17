<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * User class.
 *
 * @extends CI_Controller
 */
class Admin extends CI_Controller {
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
		$this->load->model('user_product');

	}


	public function index() {


	}

	/**
	 * login function.
	 *
	 * @access public
	 * @return void
	 */
	public function add() {

		// create the data object
		$data = new stdClass();

		// load form helper and validation library
		$this->load->helper('form');
		$this->load->library('form_validation');

		// set validation rules
		$this->form_validation->set_rules('name', 'name', 'required');
		$this->form_validation->set_rules('price', 'price', 'required');

		if ($this->form_validation->run() == false) {

			// validation not ok, send validation errors to the view
			$this->load->view('header');
			$this->load->view('admin/add/add');
			$this->load->view('footer');

		} else {

			// set variables from the form
			$name = $this->input->post('name');
			$price= (int)$this->input->post('price');

			if ($this->user_product->create_product($name, $price)) {
			  require_once	APPPATH. 'third_party/algoliasearch-client-php-master/algoliasearch.php';

				$client = new \AlgoliaSearch\Client('9USJ7O4AOH', '73f563c2409e28c9436e3eeac1ab8846');

				$index = $client->initIndex('FOOD');
				$index->addObject(
  			[
    			'name' => $name,
    			'price' => $price,
  			]
				);

				$this->load->view('header');
				$this->load->view('admin/add/add_sucess');
				$this->load->view('footer');

			} else {

				// login failed
				$data->error = 'Probleme';

				// send error to the view
				$this->load->view('header');
				$this->load->view('user/login/login', $data);
  			$this->load->view('footer');


			}

		}

	}

}
