<?php
include_once('classes/crud.php');
$crud = new crud;
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
$data = json_decode(file_get_contents("php://input"));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$allHeaders = getallheaders();

	if ($allHeaders['Content-Type'] == 'application/json') {
		if(!empty($data->customer_phone) && !empty($data->customer_id) && !empty($data->problem_type) && !empty($data->problem) && !empty($data->problem_details)&& !empty($data->fault_address) && !empty($data->fault_map)){

			$customer_no = $data->customer_id;
			$feeder_no=substr($customer_no,0,5);
			$sql = "SELECT * FROM feeder_info where feeder_no='".$feeder_no."'";
			$select_feeder_row = $crud->fetch_data($sql);
			while ($row = $select_feeder_row->fetch(PDO::FETCH_ASSOC)) {
				extract($row);
				$assign_to = $office_head_user_id;
				$feeder_supervisor_user_id = $feeder_supervisor_user_id;
				$feeder_incharge_user_id = $feeder_incharge_user_id;
			}

			$create_ticket_sql = "INSERT INTO `ticket`.`ticket` (`ticket_type`, `problem`, `from`, `assignd`,`cus_contact`, `cus_name`, `cus_ac`, `status`, `details`, `date`, `stamp`, `priority`,`assign_to`,`assign_cc1`,`assign_cc2`, `fault_address`, `fault_location`) VALUES ('".$data->problem_type."', '".$data->problem."', 'App','','".$data->customer_phone."', '".$data->customer_name."', '".$data->customer_id."','New', '".$data->problem_details."', CURRENT_TIMESTAMP, '0000-00-00 00:00:00', '0','".$assign_to."', '".$feeder_supervisor_user_id."', '".$feeder_incharge_user_id."', '".$data->fault_address."', '".$data->fault_map."')";
			$create_ticket = $crud->create($create_ticket_sql);
			if($create_ticket > 0){
				echo json_encode(
					array('message' => 'Ticket created successfully!!!')
				);
			}else{
				echo json_encode(
					array('message' => 'Ticket not Created!')
				);
			}

		}else{
			echo json_encode(
				array('message' => 'All field required')
			);
		}
	}else{
		echo json_encode(
			array('message' => 'Content Type Not Allowed')
		);
	}
}else{
	echo json_encode(
		array('message' => '405 Method Not Allowed')
	);
}
?>