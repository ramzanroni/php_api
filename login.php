<?php
include_once('classes/crud.php');
$crud = new crud;

$API_Key = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpYXQiOjE2MTg4OTU1MjIsImp0aSI6IlRQSTVmdFFUeU5MR1ZLenFOZlVhYThyRURpdEJkRmpIS0ErUGVFMTFjMTg9IiwiaXNzIjoicHVsc2VzZXJ2aWNlc2JkLmNvbSIsImRhdGEiOnsidXNlcklkIjoiMjg4MTUiLCJ1c2VyTGV2ZWwiOjJ9fQ.wQ5AQR-fIGRZgt3CN9-W6v4PkvTIvNVP8HzCOiHHeKwcd8NT1R1Dxz_XpJH9jOa7CsDzCYBklEPRtQus11NiEQ";

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
$data = json_decode(file_get_contents("php://input"));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$allHeaders = getallheaders();
	if ($allHeaders['Content-Type'] == 'application/json') {
		if (!empty($allHeaders['Authorization'])) {
			if ($API_Key == $allHeaders['Authorization']) {
				if (!empty($data->username) && !empty($data->password)) {

					$username = $data->username;
					$password = $data->password;
					$sql = "SELECT COUNT(*) AS total, `office_head_user_id`,`office_head_password`, `feeder_supervisor_user_id`, `feeder_supervisor_password`, `feeder_incharge_user_id`, `feeder_incharge_password`, `id`, `admin_user`, `admin_pass` FROM `feeder_info`WHERE (`office_head_user_id`='".$username."' AND `office_head_password`='".$password."') OR (`admin_user`='".$username."' AND `admin_pass`='".$password."' ) OR (`feeder_supervisor_user_id`='".$username."' AND `feeder_supervisor_password`='".$password."') OR (`feeder_incharge_user_id`='".$username."' AND `feeder_incharge_password`='".$password."')";
					$result = mysqli_query($con,$sql);
					$rowCount = mysqli_num_rows($result);
					if ($rowCount > 0) {
						while($row = mysqli_fetch_assoc($result)) {
							$json_row['message']       = "Login Successfully";
						
							$json[] = $json_row;
						}
						echo json_encode($json);
					} else {
						echo json_encode(
							array('message' => 'No Data Available')
						);
					}
				} else {
					echo json_encode(
						array('message' => 'No Date Not Allowed')
					);
				}
			}else{
				echo json_encode(
					array('message' => 'Authentication Failed...')
				);
			}
		}else{
			echo json_encode(
				array('message' => 'Authentication Required')
			);
		}
	}else{
		echo json_encode(
			array('message' => 'Content Type Not Allowed')
		);
	}
}else{
	echo json_encode(
		array('message' => 'Request Type Not Allowed')
	);
}
?>
