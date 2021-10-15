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
		if (!empty($data->employee_id)) {
			$assignd = $data->employee_id;
			$sql = "SELECT * FROM `ticket` WHERE `assign_to`='$assignd' OR `assign_cc1`='$assignd' OR `assign_cc2`='$assignd'";
			$result = $crud->fetch_data($sql);
			$num = $result->rowCount();
			if ($num > 0) {
				$ticket_arr = array();

				while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
					extract($row);
					$ticket_item = array(
						'id'             => $id,
						'cus_name'       => $cus_name,
						'cus_contact'    => $cus_contact,
						'ticket_type'    => $ticket_type,
						'problem'        => $problem,
						'fault_address'  => $fault_address,
						'fault_location' => $fault_location,
						'status'         => html_entity_decode($status),					
						'from'           => $from,
						'assignd'        => $assignd
					);
					array_push($ticket_arr, $ticket_item);
				}
				echo json_encode($ticket_arr);

			} else {
				echo json_encode(
					array('message' => 'No ticket Found')
				);
			}
		}else{
			echo json_encode(
				array('message' => 'No assignd person not allowed..')
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