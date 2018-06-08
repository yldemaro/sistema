<?php
session_start();
include 'conexion.php';
include 'consultas.php';

$BD = new BD();


if(isset($_GET["tipo"])){
	if($_GET["tipo"]=='ListaPuntos' && (!empty($_SESSION["Usuario"]) || !empty($_SESSION["Administrador"]) )){
		$conexiondb = $BD->conectar();
		@$id = (isset($_GET["id"]))?$_GET["id"]:$_SESSION["Usuario"]['id'];
		$id = $conexiondb->real_escape_string($id);

		@$desde = (isset($_GET["desde"]))?((!empty($_GET["desde"]))?$_GET["desde"]:'0000-00-00'):'0000-00-00';
		$desde = $conexiondb->real_escape_string($desde);

		@$hasta = (isset($_GET["hasta"]))?((!empty($_GET["hasta"]))?$_GET["hasta"]:'2019-01-01'):'2019-01-01';
		$hasta = $conexiondb->real_escape_string($hasta);

		$sql = "SELECT fecha, (SELECT u.usuario FROM administrador u WHERE u.id = b.id_administrador) as administrador, concepto, credito, debito FROM balance_punto b WHERE b.id_usuario = ? AND fecha>= ? AND fecha<= ? ";
		$sentencia = $conexiondb->prepare($sql);
		$sentencia->bind_param('iss', $a, $d, $h);
		$a = $id;
		$d = $desde.' 00:00:00';
		$h = $hasta.' 23:59:59';

		$sentencia->execute();
		$sentencia->bind_result($fecha, $administrador, $concepto, $credito, $debito);

		$sentencia->store_result();
		if($sentencia->num_rows>0){

			while($filas = $sentencia->fetch()){

				$credito = '<span class="text-success">'.$credito.'</span>';
				$debito = '<span class="text-danger">'.$debito.'</span>';
				$campo[] = array($fecha, $administrador, $concepto, $credito, $debito);
			}
		}else{
			$campo[] = array('', '', '', '', '');
		}
		$conexiondb = $BD->cerrar();
		$data = json_encode(array("data" =>	$campo));

	}if($_GET["tipo"]=='ListaPuntosGeneral' &&  !empty($_SESSION["Administrador"]) ){
		$conexiondb = $BD->conectar();

		@$desde = (isset($_GET["desde"]))?((!empty($_GET["desde"]))?$_GET["desde"]:'0000-00-00'):'0000-00-00';
		$desde = $conexiondb->real_escape_string($desde);

		@$hasta = (isset($_GET["hasta"]))?((!empty($_GET["hasta"]))?$_GET["hasta"]:'2019-01-01'):'2019-01-01';
		$hasta = $conexiondb->real_escape_string($hasta);

		$sql = "SELECT fecha, (SELECT u.usuario FROM administrador u WHERE u.id = b.id_administrador) as administrador, (SELECT CONCAT(nombre,' ',apellido) FROM usuario u WHERE u.id = b.id_usuario) as usuario, concepto, credito, debito FROM balance_punto b WHERE fecha>= ? AND fecha<= ? ";
		$sentencia = $conexiondb->prepare($sql);
		$sentencia->bind_param('ss', $d, $h);
		$d = $desde.' 00:00:00';
		$h = $hasta.' 23:59:59';

		$sentencia->execute();
		$sentencia->bind_result($fecha, $administrador, $usuario, $concepto, $credito, $debito);

		$sentencia->store_result();
		if($sentencia->num_rows>0){

			while($filas = $sentencia->fetch()){

				$credito = '<span class="text-success">'.$credito.'</span>';
				$debito = '<span class="text-danger">'.$debito.'</span>';
				$campo[] = array($fecha, $administrador, $usuario, $concepto, $credito, $debito);
			}
		}else{
			$campo[] = array('', '', '', '', '','');
		}
		$conexiondb = $BD->cerrar();
		$data = json_encode(array("data" =>	$campo));

	}else if($_GET["tipo"]=='ListaUsuarios' && !empty($_SESSION["Administrador"])){
		$conexiondb = $BD->conectar();
		$sql = "SELECT nombre, apellido, correo, telefono, bloqueado, fecha, id, (SELECT SUM(b.credito-b.debito) FROM balance_punto b WHERE b.id_usuario = u.id ) as puntos FROM usuario u WHERE eliminado ='0' ";
		$sentencia = $conexiondb->prepare($sql);

		$sentencia->execute();
		$sentencia->bind_result($nombre, $apellido, $correo, $telefono, $bloqueado, $fecha, $id, $puntos);

		$sentencia->store_result();
		if($sentencia->num_rows>0){

			while($filas = $sentencia->fetch()){

				$bloqueado = ($bloqueado=='1')?'<span class="label label-danger" title="No tiene acceso al sistema"><em class="fa fa-warning"></em> Bloqueado</span>':'<span class="label label-success" title="Si tiene acceso al sistema"><i class="icon fa fa-check"></i> Activo</span>';

				$menu = '<div class="margin">
						<div class="btn-group">
		                    <a href="usuario-perfil-'.$id.'" class="btn btn-xs btn-info">Detalles</a>
		                    <button type="button" class="btn btn-xs btn-info dropdown-toggle" data-toggle="dropdown">
		                    </button>
		                    <div class="dropdown-menu" role="menu">
		                      <a class="dropdown-item" href="usuario-balance-'.$id.'">Balance</a>
		                      <div class="dropdown-divider"></div>
		                      <a class="dropdown-item" href="#!" onclick="eliminarUsuario(\''.$id.'\',\''.$nombre.' '.$apellido.'\' )">Eliminar</a>
		                    </div>
		                </div>
		                </div>';

				$campo[] = array($nombre, $apellido, $correo, $telefono, $bloqueado, number_format($puntos,2,'.',','), $fecha, $menu);
			}
		}else{
$campo[] = array('', '', '', '', '', '', '','');		}
		$conexiondb = $BD->cerrar();
		$data = json_encode(array("data" =>	$campo));

	}

	echo $data;
}

?>