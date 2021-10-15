<?php
include_once('classes/connection.php');
class crud extends database{
	function fetch_data($sql){
		$result = $this->conn->prepare($sql);
		$result->execute();
		return $result;
	}
	function create($sql){
		$result = $this->conn->prepare($sql);
		$data = $result->execute();
		return $data;
	}
	function update($sql){
		$result = $this->conn->prepare($sql);
		$data = $result->execute();
		return $data;
	}

	function delete($sql){
		$result = $this->conn->prepare($sql);
		$result->execute();
		return $result;
	}

	function row_count($sql){
		$data = $this->conn->query($sql);
		return $data->rowCount();
	}

	function server_ip(){
		$sql = "SELECT server_ip FROM servers";
		$result = $this->conn->prepare($sql);
		$result->execute();
		$data = $result->fetch();
		return $data;
	}
	function update_server($sql){
		$result = $this->conn->prepare($sql);
		$data = $result->execute();
		return $data;
	}
	function check($ticket_id){

		$sql = "SELECT *  FROM `ticket`.`ticket` WHERE `id` ='".$ticket_id."'";
		$result = $this->conn->prepare($sql);
		$result->execute();
		return $result;

	}



}
?>