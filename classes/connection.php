<?php 
class database {
	private $host = 'localhost';
	private $db_name = 'ticket';
	private $username = 'root';
	private $password = 'iHelpBD@2017';
	public $conn;
	function __construct(){
		$this->conn = null;
		try {
			$this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch(PDOException $e) {
			echo 'Connection Error: ' . $e->getMessage();
			die();
		}
	}
}
$con = mysqli_connect("localhost","root","iHelpBD@2017","ticket");
?>