<?php
include_once('classes/crud.php');
$crud = new crud;
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
$data = json_decode(file_get_contents("php://input"));
//var_dump($data);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$allHeaders = getallheaders();
	if ($allHeaders['Content-Type'] == 'application/json') {
		if(!empty($data->ticket_id)){

			// $data->priority;
			// $data->ticket_status;
			// $data->attachment;
			// $data->remarks;
			// $data->updated_by;

			// checking extension existance 
			$sql = "SELECT `id` FROM `ticket` WHERE `id` = '" . $data->ticket_id ."'";
			$result = $crud->row_count($sql);
			if ($result <= 0){
				echo 'Ticket does not exist';
			} else {

				$ticket_update_sql = "UPDATE `ticket` SET `status`='".$data->ticket_status."',`details`='".$data->remarks."',`priority`='".$data->priority."',`attachment`='".$data->attachment."',`updated_by` = '".$data->updated_by."' WHERE `id`='".$data->ticket_id."'";

				$update_phone = $crud->update($ticket_update_sql);
				if($update_phone > 0){
					echo json_encode(
						array('message' => 'Ticket updated successfully!!!')
					);
				}else{
					echo json_encode(
						array('message' => 'ticket does not update!')
					);
				}
			}		

		}else{
			echo json_encode(
				array('message' => '204 No ticket ID Not Allowed')
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