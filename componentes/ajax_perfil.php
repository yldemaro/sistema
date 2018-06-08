<?php 
session_start();
include 'conexion.php';
include 'funciones.php';
include 'consultas.php';
include("../assets/plugins/phpass-0.3/PasswordHash.php");
$BD = new BD();


if(isset($_POST["CambiarContraseña"])){
	
	$conexiondb = $BD->conectar();

	$clave_actual 	= trim($conexiondb->real_escape_string($_POST["clave_actual"]));
	$repetir_clave 	= trim($conexiondb->real_escape_string($_POST["repetir_clave"]));

	$DatosUsuario 	= SELECT_datos_usuario_id($_SESSION['Usuario']['id']);
	$hasher = new PasswordHash(10, FALSE);
	$check = $hasher->CheckPassword($clave_actual, $DatosUsuario['clave']);

	if($check){
		$clave 	= $hasher->HashPassword($repetir_clave);
		if(UPDATE_clave_usuario($clave, $DatosUsuario['id'])){
			$rps = json_encode(array("rps" => true, "respuesta" => '<i class="icon fa fa-check"></i> Contraseña actualizada.' ));
		}else{
			$rps = json_encode(array("rps" => false, "respuesta" => '<em class="fa fa-warning"></em> No pudimos actualizar su contraseña.' ));
		}
	}else{
		$rps = json_encode(array("rps" => false, "respuesta" => '<i class="icon fa fa-ban"></i> Contraseña actual incorrecta.' ));
	}

	$conexiondb = $BD->cerrar();
	echo $rps;
}else
if(isset($_POST["CambiarContraseñaUsuario"])){
	
	if (!empty($_SESSION['Administrador']) && !empty($_POST["CambiarContraseñaUsuario"])) {
		$conexiondb = $BD->conectar();

		$repetir_clave 	= trim($conexiondb->real_escape_string($_POST["repetir_clave"]));
		$id_usuario 	= trim($conexiondb->real_escape_string($_POST["CambiarContraseñaUsuario"]));


		if(!empty($repetir_clave )){
			$hasher = new PasswordHash(10, FALSE);
			$clave 	= $hasher->HashPassword($repetir_clave);

			if(UPDATE_clave_usuario($clave, $id_usuario)){
				$rps = json_encode(array("rps" => true, "respuesta" => '<i class="icon fa fa-check"></i> Contraseña actualizada.' ));
			}else{
				$rps = json_encode(array("rps" => false, "respuesta" => '<em class="fa fa-warning"></em> No pudimos actualizar su contraseña.' ));
			}
		}else{
			$rps = json_encode(array("rps" => false, "respuesta" => '<i class="icon fa fa-ban"></i> No contraseña no puede ser vacia.' ));
		}

		$conexiondb = $BD->cerrar();
	}else{
		$rps = json_encode(array("rps" => false, "respuesta" => '<i class="icon fa fa-ban"></i> No puedes realizar esta acción.' ));
	}

	echo $rps;
}else
if(isset($_POST["EditarPerfil"])){
	
	$conexiondb = $BD->conectar();

	$nombre 	= trim($conexiondb->real_escape_string($_POST["nombre"]));
	$apellido 	= trim($conexiondb->real_escape_string($_POST["apellido"]));
	$correo 	= trim($conexiondb->real_escape_string($_POST["correo"]));
	$correo_actual 	= trim($conexiondb->real_escape_string($_POST["correo_actual"]));
	$telefono 	= trim($conexiondb->real_escape_string($_POST["telefono"]));
	$direccion 	= trim($conexiondb->real_escape_string($_POST["direccion"]));

	if (correo_existente($correo) && $correo != $correo_actual) {
		$rps = json_encode(array("rps" => false, "respuesta" => '<em class="fa fa-warning"></em> Correo en uso.' ));
	}else{
		if(UPDATE_datos_usuario($_SESSION['Usuario']['id'], $nombre, $apellido, $correo, $telefono, $direccion )){
			$_SESSION['Usuario'] = SELECT_datos_usuario($correo);;
			$rps = json_encode(array("rps" => true, "respuesta" => '<i class="icon fa fa-check"></i> Datos actualizados.' ));
		}else{
			$rps = json_encode(array("rps" => false, "respuesta" => '<em class="fa fa-warning"></em> No pudimos actualizar sus datos' ));
		}
	}
	
	
	$conexiondb = $BD->cerrar();
	echo $rps;
}else
if(isset($_POST["EditarPerfilUsuario"])){
	if (!empty($_SESSION['Administrador']) && !empty($_POST["EditarPerfilUsuario"])) {
		$conexiondb = $BD->conectar();

		$nombre 	= trim($conexiondb->real_escape_string($_POST["nombre"]));
		$apellido 	= trim($conexiondb->real_escape_string($_POST["apellido"]));
		$correo 	= trim($conexiondb->real_escape_string($_POST["correo"]));
		$correo_actual 	= trim($conexiondb->real_escape_string($_POST["correo_actual"]));
		$telefono 	= trim($conexiondb->real_escape_string($_POST["telefono"]));
		$direccion 	= trim($conexiondb->real_escape_string($_POST["direccion"]));
		@$bloqueado 	= trim($conexiondb->real_escape_string($_POST["bloqueado"]));
		$bloqueado 	= ($bloqueado=='on')?'1':'0';
		$id_usuario = trim($conexiondb->real_escape_string($_POST["EditarPerfilUsuario"]));

		if (correo_existente($correo) && $correo != $correo_actual) {
		$rps = json_encode(array("rps" => false, "respuesta" => '<em class="fa fa-warning"></em> Correo en uso.' ));
		}else{
			if(UPDATE_datos_usuario($id_usuario, $nombre, $apellido, $correo, $telefono, $direccion )){
				UPDATE_cambiar_estado_usuario('bloqueado', $bloqueado, $id_usuario);
				$rps = json_encode(array("rps" => true, "respuesta" => '<i class="icon fa fa-check"></i> Datos actualizados.' ));
			}else{
				$rps = json_encode(array("rps" => false, "respuesta" => '<em class="fa fa-warning"></em> No pudimos actualizar los datos' ));
			}
		}

		$conexiondb = $BD->cerrar();
	}else{
		$rps = json_encode(array("rps" => false, "respuesta" => '<i class="icon fa fa-ban"></i> No puedes realizar esta acción.' ));
	}
	
	echo $rps;
}else
if(isset($_FILES["ImagenPerfil"])){

	if($_FILES["ImagenPerfil"]["error"] > 0){
		$continuar = false;
	}else{
		$continuar = true;
	}

	if($continuar){

		$name_img = $_SESSION["Usuario"]['id'];

		$archivo = $_FILES["ImagenPerfil"];
		$extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);

		$permitidos = array("image/jpg", "image/jpeg", "image/png");
		$file_name = $_FILES["ImagenPerfil"]["name"];

		if(in_array($_FILES['ImagenPerfil']['type'], $permitidos)){
			$ruta = "../assets/img-usuario/";
			if (!file_exists($ruta)) {
				mkdir('../assets/img-usuario/', 0777, true);
				file_put_contents('../assets/img-usuario/index.php', '¿Estas perdido?');
			}

			//la imegen anterior
			if($_FILES["ImagenPerfil"]['type']=="image/png"){
				if(file_exists($ruta.$name_img.'.jpg')){
					unlink($ruta.$name_img.'.jpg');
				}
			}else if($_FILES["ImagenPerfil"]['type']=="image/jpg"){
				if(file_exists($ruta.$name_img.'.png')){
					unlink($ruta.$name_img.'.png');
				}
			}

			$upload = $ruta.$name_img.'.'.$extension;
			$resultado = @move_uploaded_file($_FILES["ImagenPerfil"]["tmp_name"], $upload);

			if($resultado){
				$rps = json_encode(array("rps"=> 1, "respuesta" => '<i class="icon fa fa-check"></i>  Imagen actualizada, refresca la pagina para ver el cambio'));
			}else{
				$rps = json_encode(array("rps"=> 0, "respuesta" => '<i class="icon fa fa-check"></i>  No fue posible subir la imagen'));
			}
		}else{
			$rps = json_encode(array("rps"=> 0, "respuesta"=> '<i class="icon fa fa-check"></i>  Tipo de archivo no permitido'));
		}

	}else{
		$rps = json_encode(array("rps"=> 0, "respuesta" => '<em class="fa fa-warning"></em> Ocurrio un error al subir la imagen'));
	}


	echo $rps;
}else
if (isset($_POST['EliminarUsuario'])) {
	$conexiondb = $BD->conectar();
	$id_usuario = trim($conexiondb->real_escape_string($_POST["EliminarUsuario"]));

	if (!empty($id_usuario)) {
		if (!empty($_SESSION['Administrador'])) {
			if (UPDATE_cambiar_estado_usuario('eliminado', '1', $id_usuario)) {
				$rps = json_encode(array("rps" => true, "respuesta" => 'Usuario eliminado correctamente' ));	
			}else{
				$rps = json_encode(array("rps" => false, "respuesta" => 'No fue posible eliminar al usuario' ));
			}
		}else{
			$rps = json_encode(array("rps" => false, "respuesta" => 'No puedes realizar esta accion' ));
		}
	}else{
		$rps = json_encode(array("rps" => false, "respuesta" => 'Usuario invalido' ));
	}
	echo $rps;
}else
if(isset($_POST["NuevoUsuario"])){
	
	if (!empty($_SESSION['Administrador']['id'])) {
		$conexiondb = $BD->conectar();

		$nombre 	= trim($conexiondb->real_escape_string($_POST["nombre"]));
		$apellido 	= trim($conexiondb->real_escape_string($_POST["apellido"]));
		$correo 	= trim($conexiondb->real_escape_string($_POST["correo"]));
		$telefono 	= trim($conexiondb->real_escape_string($_POST["telefono"]));
		$direccion 	= trim($conexiondb->real_escape_string($_POST["direccion"]));
		$clave 	= trim($conexiondb->real_escape_string($_POST["repetir_clave"]));

		if (correo_existente($correo)) {
		$rps = json_encode(array("rps" => false, "respuesta" => '<em class="fa fa-warning"></em> Correo en uso.' ));
		}else{
			$hasher = new PasswordHash(10, FALSE);
			$clave 	= $hasher->HashPassword($clave);
echo CREATE_datos_usuario($_SESSION['Administrador']['id'], $nombre, $apellido, $correo, $telefono, $direccion, $clave);
if(CREATE_datos_usuario($_SESSION['Administrador']['id'], $nombre, $apellido, $correo, $telefono, $direccion, $clave)){;
			if(CREATE_datos_usuario($_SESSION['Administrador']['id'], $nombre, $apellido, $correo, $telefono, $direccion, $clave)){
				$rps = json_encode(array("rps" => true, "respuesta" => '<i class="icon fa fa-check"></i> Usuario creado correctamente.' ));
			}else{
				$rps = json_encode(array("rps" => false, "respuesta" => '<em class="fa fa-warning"></em> No fue posible crear el usuario' ));
			}
		}
		$conexiondb = $BD->cerrar();
	}else{
		$rps = json_encode(array("rps" => false, "respuesta" => '<em class="fa fa-warning"></em> No puedes realizar esta accion' ));
	}

	echo $rps;
}else
if(isset($_FILES["ImagenPerfilAdmin"])){

	if($_FILES["ImagenPerfilAdmin"]["error"] > 0){
		$continuar = false;
	}else{
		$continuar = true;
	}

	if($continuar){

		$name_img = $_SESSION["Administrador"]['id'];

		$archivo = $_FILES["ImagenPerfilAdmin"];
		$extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);

		$permitidos = array("image/jpg", "image/jpeg", "image/png");
		$file_name = $_FILES["ImagenPerfilAdmin"]["name"];

		if(in_array($_FILES['ImagenPerfilAdmin']['type'], $permitidos)){
			$ruta = "../assets/img-admin/";
			if (!file_exists($ruta)) {
				mkdir('../assets/img-admin/', 0777, true);
				file_put_contents('../assets/img-admin/index.php', '¿Estas perdido?');
			}

			//la imegen anterior
			if($_FILES["ImagenPerfilAdmin"]['type']=="image/png"){
				if(file_exists($ruta.$name_img.'.jpg')){
					unlink($ruta.$name_img.'.jpg');
				}
			}else if($_FILES["ImagenPerfilAdmin"]['type']=="image/jpg"){
				if(file_exists($ruta.$name_img.'.png')){
					unlink($ruta.$name_img.'.png');
				}
			}

			$upload = $ruta.$name_img.'.'.$extension;
			$resultado = @move_uploaded_file($_FILES["ImagenPerfilAdmin"]["tmp_name"], $upload);

			if($resultado){
				$rps = json_encode(array("rps"=> 1, "respuesta" => '<i class="icon fa fa-check"></i>  Imagen actualizada, refresca la pagina para ver el cambio'));
			}else{
				$rps = json_encode(array("rps"=> 0, "respuesta" => '<i class="icon fa fa-check"></i>  No fue posible subir la imagen'));
			}
		}else{
			$rps = json_encode(array("rps"=> 0, "respuesta"=> '<i class="icon fa fa-check"></i>  Tipo de archivo no permitido'));
		}

	}else{
		$rps = json_encode(array("rps"=> 0, "respuesta" => '<em class="fa fa-warning"></em> Ocurrio un error al subir la imagen'));
	}


	echo $rps;
}else
if(isset($_POST["CambiarContraseñaAdmin"])){
	
	$conexiondb = $BD->conectar();

	$clave_actual 	= trim($conexiondb->real_escape_string($_POST["clave_actual"]));
	$repetir_clave 	= trim($conexiondb->real_escape_string($_POST["repetir_clave"]));

	$DatosUsuario 	= SELECT_datos_administrador_id($_SESSION['Administrador']['id']);

	$hasher = new PasswordHash(10, FALSE);
	$check = $hasher->CheckPassword($clave_actual, $DatosUsuario['clave']);

	if($check){
		$clave 	= $hasher->HashPassword($repetir_clave);
		if(UPDATE_clave_administrador($clave, $DatosUsuario['id'])){
			$rps = json_encode(array("rps" => true, "respuesta" => '<i class="icon fa fa-check"></i> Contraseña actualizada.' ));
		}else{
			$rps = json_encode(array("rps" => false, "respuesta" => '<em class="fa fa-warning"></em> No pudimos actualizar su contraseña.' ));
		}
	}else{
		$rps = json_encode(array("rps" => false, "respuesta" => '<i class="icon fa fa-ban"></i> Contraseña actual incorrecta.' ));
	}

	$conexiondb = $BD->cerrar();
	echo $rps;
}else
if(isset($_POST["EditarPerfilAdmin"])){
	
	$conexiondb = $BD->conectar();

	$nombre 	= trim($conexiondb->real_escape_string($_POST["nombre"]));
	$apellido 	= trim($conexiondb->real_escape_string($_POST["apellido"]));
	$correo 	= trim($conexiondb->real_escape_string($_POST["correo"]));
	$correo_actual 	= trim($conexiondb->real_escape_string($_POST["correo_actual"]));
	$telefono 	= trim($conexiondb->real_escape_string($_POST["telefono"]));
	@$direccion 	= trim($conexiondb->real_escape_string($_POST["direccion"]));

	if (correo_existente($correo) && $correo != $correo_actual) {
		$rps = json_encode(array("rps" => false, "respuesta" => '<em class="fa fa-warning"></em> Correo en uso.' ));
	}else{

		if(UPDATE_datos_administrador($_SESSION['Administrador']['id'], $nombre, $apellido, $correo, $telefono )){
			$_SESSION['Administrador'] = SELECT_datos_administrador($correo);;
			$rps = json_encode(array("rps" => true, "respuesta" => '<i class="icon fa fa-check"></i> Datos actualizados.' ));
		}else{
			$rps = json_encode(array("rps" => false, "respuesta" => '<em class="fa fa-warning"></em> No pudimos actualizar sus datos' ));
		}
	}

	$conexiondb = $BD->cerrar();
	echo $rps;
}
?>