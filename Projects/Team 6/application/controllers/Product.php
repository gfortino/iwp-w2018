<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * User class.
 *
 * @extends CI_Controller
 */
class Product extends CI_Controller {
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
	 * display function.
	 *
	 * @access public
	 * @return void
	 */
   	public function display() {

       $data['data'] = $this->user_product->get_product();
       $this->load->view('header');
       $this->load->view('product/display/display', $data);
       $this->load->view('footer');


    }
    public function details(){

        $data_id = $this->uri->segment(2);


    }
    /**
  	 * display function.
  	 *
  	 * @access public
  	 * @return void
  	 */
     	public function buy() {
         $id = $this->uri->segment(3);
         $this->user_product->add_delivery_id_from_id_user($id,$_SESSION['user_id']);
         $this->load->view('header');
         $this->load->view('product/buy/buy');
         $this->load->view('footer');


      }








}
