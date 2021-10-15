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
		if(!empty($data->ticket_id)){
			$sql = "SELECT id FROM ticket WHERE id = '" . $data->ticket_id . "'";
			$result = $crud->row_count($sql);
			if ($result <= 0) {
				echo 'Ticket Not Exist';
			} else {

				if (!empty($data->ticket_id)) {
					$ticket_result = $crud->check($data->ticket_id);
					if($ticket_result->rowCount() > 0){
						$up_sql = "DELETE FROM `ticket`  WHERE `id` ='".$data->ticket_id."'";
						$delete_ticket = $crud->delete($up_sql);
						if($delete_ticket->rowCount() > 0){
							echo json_encode(
								array('message' => 'Record Deleted successfully!!!')
							);
						}else{
							echo json_encode(
								array('message' => 'Failed to delete Record!')
							);
						}
					}else{
						echo json_encode(
							array('message' => 'No ticket found!')
						);
					}
				}		
			}
		}else{
			echo json_encode(
				array('message' => '204 No Ticket ID Not Allowed')
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




