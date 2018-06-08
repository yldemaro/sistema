<?php

function SELECT_datos_usuario($correo){
	$BD = new BD();
	$conexiondb = $BD->conectar();
	$sql = "SELECT id, usuario, clave, nombre, apellido, correo, telefono, direccion, fecha, rol FROM usuario WHERE correo = ? AND bloqueado = ? AND eliminado = ? ";
	$sentencia = $conexiondb->prepare($sql);
	$sentencia->bind_param('sss', $v1, $v2, $v3);
	$v1 = $correo;
	$v2 = '0';
	$v3 = '0';

	$sentencia->execute();
	$sentencia->bind_result($id, $usuario, $clave, $nombre, $apellido, $correo, $telefono, $direccion, $fecha , $rol);

	$sentencia->store_result();
	if($sentencia->num_rows>0){
		$filas 	= $sentencia->fetch();
		$result = array('existe' => true, 'id' => $id, 'usuario' => $usuario, 'clave' => $clave, 'nombre' => $nombre, 'apellido' => $apellido, 'correo' => $correo, 'telefono' => $telefono, 'direccion' => $direccion, 'fecha' => $fecha, 'rol' => $rol);
	}else{
		$result = array('existe' => false);
	}

	$conexiondb->close();

	return $result;
}

function SELECT_datos_usuario_id($id){
	$BD = new BD();
	$conexiondb = $BD->conectar();
	$sql = "SELECT id, usuario, clave, nombre, apellido, correo, telefono, direccion, fecha, bloqueado, rol, CONCAT(nombre,' ',apellido) as nombre_completo FROM usuario WHERE id = ? AND eliminado = ?  ";
	$sentencia = $conexiondb->prepare($sql);
	$sentencia->bind_param('is', $v1, $v2);
	$v1 = $id;
	$v2 = '0';

	$sentencia->execute();
	$sentencia->bind_result($id, $usuario, $clave, $nombre, $apellido, $correo, $telefono, $direccion, $fecha, $bloqueado, $rol, $nombre_completo );

	$sentencia->store_result();
	if($sentencia->num_rows>0){
		$filas 	= $sentencia->fetch();
		$result = array('existe' => true, 'id' => $id, 'usuario' => $usuario, 'clave' => $clave, 'nombre' => $nombre, 'apellido' => $apellido, 'correo' => $correo, 'telefono' => $telefono, 'direccion' => $direccion, 'fecha' => $fecha, 'bloqueado' => $bloqueado, 'rol' => $rol, 'nombre_completo'=> $nombre_completo);
	}else{
		$result = array('existe' => false);
	}

	$conexiondb->close();

	return $result;
}

function SELECT_datos_administrador($correo){
	$BD = new BD();
	$conexiondb = $BD->conectar();
	$sql = "SELECT id, usuario, clave, nombre, apellido, correo, rol, telefono FROM administrador WHERE correo = ? AND bloqueado = ? AND eliminado = ? ";
	$sentencia = $conexiondb->prepare($sql);
	$sentencia->bind_param('sss', $v1, $v2, $v3);
	$v1 = $correo;
	$v2 = '0';
	$v3 = '0';

	$sentencia->execute();
	$sentencia->bind_result($id, $usuario, $clave, $nombre, $apellido, $correo, $rol, $telefono );

	$sentencia->store_result();
	if($sentencia->num_rows>0){
		$filas 	= $sentencia->fetch();
		$result = array('existe' => true, 'id' => $id, 'usuario' => $usuario, 'clave' => $clave, 'nombre' => $nombre, 'apellido' => $apellido, 'correo' => $correo, 'rol' => $rol, 'telefono' => $telefono);
	}else{
		$result = array('existe' => false);
	}

	$conexiondb->close();

	return $result;
}

function UPDATE_clave_usuario($clave, $id){
	$BD = new BD();
	$conexiondb = $BD->conectar();
	$sql = "UPDATE `usuario` SET `clave` = ? WHERE `id` = ? ";
	$sentencia = $conexiondb->prepare($sql);
	$sentencia->bind_param('si', $v1, $v2);
	$v1 = $clave;
	$v2 = $id;

	if ($sentencia->execute()) {
		$result = true;		
	}else{
		$result = false;
	}

	$conexiondb->close();

	return $result;
}

function UPDATE_datos_usuario($id, $nombre, $apellido, $correo, $telefono, $direccion){
	$BD = new BD();
	$conexiondb = $BD->conectar();
	$sql = "UPDATE `usuario` SET nombre = ?, apellido = ?, correo = ?, telefono = ?, direccion = ? WHERE `id` = ? ";
	$sentencia = $conexiondb->prepare($sql);
	$sentencia->bind_param('sssssi', $v1, $v2, $v3, $v4, $v5, $v6);
	$v1 = $nombre;
	$v2 = $apellido;
	$v3 = $correo;
	$v4 = $telefono;
	$v5 = $direccion;
	$v6 = $id;

	if ($sentencia->execute()) {
		$result = true;		
	}else{
		$result = false;
	}

	$conexiondb->close();

	return $result;
}

 function UPDATE_cambiar_estado_usuario($campo, $valor, $id_usuario)
{

	$extra = ($campo=='eliminado')?', correo = CONCAT(correo,"Del'.date('mdhis').'") ':'';

	$BD = new BD();
	$conexiondb = $BD->conectar();
	$sql = "UPDATE `usuario` SET ".$campo." = ? ".$extra." WHERE `id` = ? ";
	$sentencia = $conexiondb->prepare($sql);
	$sentencia->bind_param('si', $v1, $v2);
	$v1 = $valor;
	$v2 = $id_usuario;

	if ($sentencia->execute()) {
		$result = true;		
	}else{
		$result = false;
	}

	$conexiondb->close();

	return $result;
}

function CREATE_datos_usuario($administrador, $nombre, $apellido, $correo, $telefono, $direccion, $clave){
	$BD = new BD();
	$conexiondb = $BD->conectar();
	$sql = "INSERT INTO `usuario` (`id_administrador`, `nombre`, `apellido`, `correo`, `telefono`, `direccion`, `clave`, `fecha`) VALUES (?,?,?,?,?,?,?,?)";
	$sentencia = $conexiondb->prepare($sql);
	$sentencia->bind_param('isssssss', $v0, $v1, $v2, $v3, $v4, $v5, $v6, $v7);
	$v0 = $_SESSION['Administrador']['id'];
	$v1 = $nombre;
	$v2 = $apellido;
	$v3 = $correo;
	$v4 = $telefono;
	$v5 = $direccion;
	$v6 = $clave;
	$v7 = Fecha();

	if ($sentencia->execute()) {
		$result = true;		
	}else{
		$result = false;
		echo "Falló la ejecución: (" . $sentencia->errno . ") " . $sentencia->error;

	}

	$conexiondb->close();

	return $result;
}

function INSERT_balance_punto($credito, $debito, $concepto, $id_usuario, $administrador){
	$BD = new BD();
	$conexiondb = $BD->conectar();
	$sql = "INSERT INTO `balance_punto` (`id_administrador`, `id_usuario`, `concepto`, `credito`, `debito`, `fecha`) VALUES (?,?,?,?,?,?)";
	$sentencia = $conexiondb->prepare($sql);
	$sentencia->bind_param('iisdds', $v0, $v1, $v2, $v3, $v4, $v5);
	$v0 = $_SESSION['Administrador']['id'];
	$v1 = $id_usuario;
	$v2 = $concepto;
	$v3 = $credito;
	$v4 = $debito;
	$v5 = Fecha();

	if ($sentencia->execute()) {
		$result = true;		
	}else{
		$result = false;
	}

	$conexiondb->close();

	return $result;
}

function balance_puntos_usuario($id){
	$BD = new BD();
	$conexiondb = $BD->conectar();
	$sql = "SELECT COALESCE(SUM(credito-debito),0) as total FROM balance_punto WHERE id_usuario = ? ";
	$sentencia = $conexiondb->prepare($sql);
	$sentencia->bind_param('i', $v1);
	$v1 = $id;

	$sentencia->execute();
	$sentencia->bind_result($total);
	$filas 	= $sentencia->fetch();
	$result = $total;

	$conexiondb->close();

	return $result;
}

function balance_puntos_general(){
	$BD = new BD();
	$conexiondb = $BD->conectar();
	$sql = "SELECT COALESCE(SUM(credito-debito),0) as total FROM balance_punto ";
	$sentencia = $conexiondb->prepare($sql);

	$sentencia->execute();
	$sentencia->bind_result($total);
	$filas 	= $sentencia->fetch();
	$result = $total;

	$conexiondb->close();

	return $result;
}

function correo_existente($correo){
	$BD = new BD();
	$conexiondb = $BD->conectar();
	$sql = "SELECT id FROM administrador WHERE correo = ?  ";
	$sentencia = $conexiondb->prepare($sql);
	$sentencia->bind_param('s', $v1);
	$v1 = $correo;

	$sentencia->execute();
	$sentencia->bind_result($id);

	$sentencia->store_result();
	if($sentencia->num_rows>0){
		$result = true;
	}else{
		$sql = "SELECT id FROM usuario WHERE correo = ?  ";
		$sentencia2 = $conexiondb->prepare($sql);
		$sentencia2->bind_param('s', $v1);
		$v1 = $correo;

		$sentencia2->execute();
		$sentencia2->bind_result($id);

		$sentencia2->store_result();
		if($sentencia2->num_rows>0){
			$result = true;
		}else{
			$result = false;
		}
	}

	$conexiondb->close();

	return $result;
}

//ADMINISTRADOR
function UPDATE_datos_administrador($id, $nombre, $apellido, $correo, $telefono){
	$BD = new BD();
	$conexiondb = $BD->conectar();
	$sql = "UPDATE `administrador` SET nombre = ?, apellido = ?, correo = ?, telefono = ? WHERE `id` = ? ";
	$sentencia = $conexiondb->prepare($sql);
	$sentencia->bind_param('ssssi', $v1, $v2, $v3, $v4, $v6);
	$v1 = $nombre;
	$v2 = $apellido;
	$v3 = $correo;
	$v4 = $telefono;
	$v6 = $id;

	if ($sentencia->execute()) {
		$result = true;		
	}else{
		$result = false;
	}

	$conexiondb->close();

	return $result;
}

function SELECT_datos_administrador_id($id){
	$BD = new BD();
	$conexiondb = $BD->conectar();
	$sql = "SELECT id, usuario, clave, nombre, apellido, correo, telefono, fecha, bloqueado, rol, CONCAT(nombre,' ',apellido) as nombre_completo FROM administrador WHERE id = ? AND eliminado = ?  ";
	$sentencia = $conexiondb->prepare($sql);
	$sentencia->bind_param('is', $v1, $v2);
	$v1 = $id;
	$v2 = '0';

	$sentencia->execute();
	$sentencia->bind_result($id, $usuario, $clave, $nombre, $apellido, $correo, $telefono, $fecha, $bloqueado, $rol, $nombre_completo );

	$sentencia->store_result();
	if($sentencia->num_rows>0){
		$filas 	= $sentencia->fetch();
		$result = array('existe' => true, 'id' => $id, 'usuario' => $usuario, 'clave' => $clave, 'nombre' => $nombre, 'apellido' => $apellido, 'correo' => $correo, 'telefono' => $telefono, 'fecha' => $fecha, 'bloqueado' => $bloqueado, 'rol' => $rol, 'nombre_completo'=> $nombre_completo);
	}else{
		$result = array('existe' => false);
	}

	$conexiondb->close();

	return $result;
}

function UPDATE_clave_administrador($clave, $id){
	$BD = new BD();
	$conexiondb = $BD->conectar();
	$sql = "UPDATE `administrador` SET `clave` = ? WHERE `id` = ? ";
	$sentencia = $conexiondb->prepare($sql);
	$sentencia->bind_param('si', $v1, $v2);
	$v1 = $clave;
	$v2 = $id;

	if ($sentencia->execute()) {
		$result = true;		
	}else{
		$result = false;
	}

	$conexiondb->close();

	return $result;
}
?>