<?php
/**
 * 
 */
class BD
{
	public $host;
	private $database;
	private $user;
	private $password;
	private $conexion;

	function __construct()
	{
		//ashley
		$this->host 	= 'localhost';
		$this->database = 'ashley';
		$this->user 	= 'sistemapuntos';
		$this->password = 'Internet11...';
	}

	public function conectar(){
		
		$this->conexion = new mysqli($this->host, $this->user, $this->password, $this->database);
		
		/* verificar conexión */
		if (mysqli_connect_errno()) {
		    printf("Connect failed: %s\n", mysqli_connect_error());
		    exit();
		}

		$this->conexion->set_charset("utf8");

		return $this->conexion;
	}

	public function cerrar(){
		$this->conexion->close();
	}
}

?>