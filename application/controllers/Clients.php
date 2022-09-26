<?php

require APPPATH . 'libraries/REST_Controller.php';


class Clients extends REST_Controller
{




	public function __construct()
	{

		parent::__construct();

		$this->load->database();
		$this->load->model("clientsmodel", "", true);
		$this->lang->load('response', 'english');
	}



	function isAuthorized()
	{
		return $data = $this->authorization_token->validateToken();
	}



	/**

	 * Get All Data from this method.

	 *

	 * @return Response

	 */

	public function index_get($id = 0)
	{
		$isAuthorized = $this->authorization_token->validateToken();
		if ($isAuthorized['status'] == 1) {
			$message = "success";
			if (!empty($id)) {
				$data = $this->db->get_where("clients", ['id' => $id])->row_array();
				if (empty($data)) {
					$message = $this->lang->line('no_result_found');
				}
				$data = array('details' => $data);
			} else {
				$data = $this->Mydb->do_search('clients', 'clientsmodel');
				if (empty($data['data_list'])) {
					$message = $this->lang->line('no_result_found');
				}
			}
			$value  = withSuccess($message, $data);
			$this->response($value, REST_Controller::HTTP_OK);
		} else {
			$value = withSuccess($message = 'Unauthorized Access', '');
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
		$isAuthorized = $this->authorization_token->validateToken();
		if ($isAuthorized['status'] == 1) {

			$input = $this->input->post();
			$rules = [
				'name' => ['Name', 'required|max_length[200]'],
				'email' => ['Email', 'required|valid_email|max_length[120]'],
				'amount' => ['Amount', 'required']
			];

			$message = [
				'is_unique' => 'The %s is already exists',
			];
			Validator::setMessage($message);
			Validator::make($rules);

			if (!Validator::fails()) {
				Validator::error();
			} else {
				$data = array(
					'name' => $input['name'],
					'email' => $input['email'],
					'amount' => $input['amount'],
					'created_at' => cur_date_time(),
				);
				$id = $this->Mydb->insert_table_data('clients', $data);
				$result['details'] = $this->Mydb->get_table_data('clients', array('id' => $id));
				$value  = withSuccess($this->lang->line('customer_created_success'), $result);
				$this->response($value, REST_Controller::HTTP_OK);
			}
		} else {
			$value = withSuccess($message = 'Unauthorized Access', '');
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
		$isAuthorized = $this->authorization_token->validateToken();
		if ($isAuthorized['status'] == 1) {

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
			if (!empty($input['amount'])) {
				$rules['amount'] = ['Amount', 'required'];
				$data['amount'] = $input['amount'];
			}

			$message = [
				'edit_unique' => 'The %s is already exists',
			];

			// print_R($input);
			// exit();
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
		} else {
			$value = withSuccess($message = 'Unauthorized Access', '');
			$this->response($value, REST_Controller::HTTP_OK);
		}
	}



	/**

	 * Delete data from this method.

	 *

	 * @return Response

	 */

	public function index_delete($id)
	{
		$isAuthorized = $this->authorization_token->validateToken();
		if ($isAuthorized['status'] == 1) {
				$data = $this->db->get_where("clients", ['id' => $id])->row_array();
				$res = $this->Mydb->delete_table_data('clients', array('id' => $id));
				if ($res == 1) {
					$result = array('details' => $data);
					$value  = withSuccess($this->lang->line('customer_deleted_success'), $result);
				} else if ($res == -1451) {
					$value = withErrors($this->lang->line('failed_to_delete'));
				} else {
					$value = withErrors($this->lang->line('failed_to_delete'));
				}
			$this->response($value, REST_Controller::HTTP_OK);
		} else {
			$value = withSuccess($message = 'Unauthorized Access', '');
			$this->response($value, REST_Controller::HTTP_OK);
		}
	}


}
