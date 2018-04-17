<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * User_model class.
 *
 * @extends CI_Model
 */
class User_product extends CI_Model {
	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {

		parent::__construct();
		$this->load->database();

	}

	/**
	 * create_product function.
	 *
	 * @access public
	 * @param mixed $price
	 * @param mixed $name
	 * @return bool true on success, false on failure
	 */
	public function create_product($name, $price) {

		$data = array(
			'name'   => $name,
			'price'      => $price,
		);

		return $this->db->insert('product', $data);

	}

  /**
	 * add_delivery_id_from_id_user
	 *
	 * @access public
	 * @param mixed $id_product
   * @param mixed $id_user
	 * @return bool true on success, false on failure
	 */
	public function add_delivery_id_from_id_user($id_product,$id_user) {

    $data = array(

      'id_user'   => $id_user,
      'id_product'      => $id_product,
    );

    return $this->db->insert('delivery', $data);

	}

	/**
	 * get_product_id_from_name function.
	 *
	 * @access public
	 * @param mixed $name
	 * @return int the product id
	 */
	public function get_product_id_from_name($name) {

		$this->db->select('id');
		$this->db->from('product');
		$this->db->where('name', $name);
		return $this->db->get()->row('id');

	}

	/**
	 * get_product function.
	 *
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_product() {

    $query = $this->db->select('*')->from('product')->get();
    return $query->result();

	}




}
