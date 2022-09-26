<?php

require APPPATH . 'libraries/REST_Controller.php';


class Customers extends REST_Controller
{




	public function __construct()
	{

		parent::__construct();

		$this->load->database();
		$this->load->model("customersmodel", "", true);
		$this->lang->load('response', 'english');
	}



	/**

	 * Get All Data from this method.

	 *

	 * @return Response

	 */

	public function index_get($id = 0)
	{
		$message = "success";
		if (!empty($id)) {
			$data = $this->db->get_where("customers", ['id' => $id])->row_array();
			if (empty($data)) {
				$message = $this->lang->line('no_result_found');
			}
			$data = array('details' => $data);
		} else {
			$data = $this->Mydb->do_search('customers', 'customersmodel');
			if (empty($data['data_list'])) {
				$message = $this->lang->line('no_result_found');
			}
		}
		$value  = withSuccess($message, $data);
		$this->response($value, REST_Controller::HTTP_OK);
	}

	/**
	 * Login User using JWT 
	 * 
	 * @return Response
	 
	 */
	public function login_post()
	{
		$this->load->library('Authorization_Token');
		$input = $this->input->post();

		$rules = [
			'email' => ['Password', 'required|max_length[200]'],
			'password' => ['Password', 'required'],
		];

		$message = [
			'is_unique' => 'The %s is already exists',
		];
		Validator::setMessage($message);
		Validator::make($rules);

		if (!Validator::fails()) {
			Validator::error();
		} else {
			$token = '';
			$q = $this->db->get_where('customers', array('email' => $input['email']))->row_array();
			if (!empty($q)) {
				$verify_pass = password_verify($input['password'], $q['password']);
				if ($verify_pass) {
					$message = "User authenticated Successfullly";
					$token = $this->authorization_token->generateToken($q);
				} else {
					$message = $this->lang->line('Invalid Credentials');
				}
			} else {
				$message = "Invalid Credentials";
			}
			$value  = withSuccess($message, $token);
			$this->response($value, REST_Controller::HTTP_OK);
		}
	}

	public function customers_list_get(){
		$data = $this->authorization_token->validateToken();
		$message = '';
		$result = '';
		if($data['status']!=1){
			$value = withSuccess($message = 'You are not authorized to access customers');
			$this->response($value, REST_Controller::HTTP_OK);
		}else{
			$users = $this->db->get('customers')->result_array();
			$message = 'Authenticated Successfully';
			$value  = withSuccess($message, $users);
			$this->response($value, REST_Controller::HTTP_OK);
		}
	}



	/**

	 * Get the list of customers from this method.

	 *

	 * @return Response

	 */

	function list_get()
	{
		$message = "success";
		$data = $this->db->get_where("customers")->result_array();
		if (empty($data)) {
			$message = $this->lang->line('no_result_found');
		}
		$data = array('data_list' => $data);
		$value  = withSuccess($message, $data);
		$this->response($value, REST_Controller::HTTP_OK);
	}



	/**

	 * Insert data from this method.

	 *

	 * @return Response

	 */

	public function index_post()
	{
		$input = $this->input->post();
		$rules = [
			'name' => ['Name', 'required|max_length[200]'],
			'email' => ['Email', 'required|valid_email|max_length[120]'],
			'password' => ['Phone', 'required|max_length[20]|min_length[5]'],
		];

		$message = [
			'is_unique' => 'The %s is already exists',
		];
		Validator::setMessage($message);
		Validator::make($rules);

		//print_r(Validator::fails());
		if (!Validator::fails()) {
			Validator::error();
		} else {
			$data = array(
				'name' => $input['name'],
				'email' => $input['email'],
				'password' => $input['password'],
				'created_at' => cur_date_time(),
				'created_by' => $input['created_by'],
			);
			$id = $this->Mydb->insert_table_data('customers', $data);
			$result['details'] = $this->Mydb->get_table_data('customers', array('id' => $id));
			$value  = withSuccess($this->lang->line('customer_created_success'), $result);
			$this->response($value, REST_Controller::HTTP_OK);
		}
	}



	/**

	 * Update data from this method.

	 *

	 * @return Response

	 */

	public function index_put($id)
	{
		$rules = array();
		$data = array();

		$input = $this->put();
		if (!empty($input['name'])) {
			$rules['name'] = ['Name', 'required|min_length[3]|max_length[200]'];
			$data['name'] = $input['name'];
		}
		if (!empty($input['email'])) {
			$rules['email'] = ['Email', 'required|valid_email|min_length[3]|max_length[200]'];
			$data['email'] = $input['email'];
		}
		if (empty($input['password'])) {
			$rules['password'] = ['Password', 'required|min_length[6]|max_length[20]'];
			$data['password'] = $input['email'];
		}
		if (!empty($input['updated_by'])) {
			$data['updated_by'] = $input['updated_by'];
		}

		$message = [
			'edit_unique' => 'The %s is already exists',
		];

		Validator::setMessage($message);

		if (array_filter($input)) {
			if (!empty($rules)) {
				Validator::make($rules);
			}
			if (!Validator::fails()) {
				Validator::error();
			}
		}

		$data['updated_at'] = cur_date_time();

		$is_update = $this->Mydb->update_table_data('customers', array('id' => $id), $data);
		$result['details'] = $this->Mydb->get_table_data('customers', array('id' => $id));
		if ($is_update > 0) {
			$value  = withSuccess($this->lang->line('customer_updated_success'), $result);
		} else {
			$value  = withErrors($this->lang->line('failed_to_update'), $result);
		}
		$this->response($value, REST_Controller::HTTP_OK);
	}



	/**

	 * Delete data from this method.

	 *

	 * @return Response

	 */

	public function index_delete($id)
	{
		$p_data = $this->db->get_where("customer_branches", ['customers_id' => $id])->num_rows();
		if ($p_data == 0) {
			$data = $this->db->get_where("customers", ['id' => $id])->row_array();
			$res = $this->Mydb->delete_table_data('customers', array('id' => $id));
			if ($res == 1) {
				$result = array('details' => $data);
				$value  = withSuccess($this->lang->line('customer_deleted_success'), $result);
			} else
			if ($res == -1451) {
				$value = withErrors($this->lang->line('failed_to_delete'));
			} else {
				$value = withErrors($this->lang->line('failed_to_delete'));
			}
		} else {
			$value = withErrors($this->lang->line('customer_has_branch'));
		}

		$this->response($value, REST_Controller::HTTP_OK);
	}
}
