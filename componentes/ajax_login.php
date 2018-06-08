<?php 
session_start();
include 'conexion.php';
include 'consultas.php';
include 'funciones.php';
include("../assets/plugins/phpass-0.3/PasswordHash.php");
$BD = new BD();


if(isset($_POST["IniciarSesion"])){
	
	$conexiondb = $BD->conectar();

	$email 		= trim($conexiondb->real_escape_string($_POST["email"]));
	$password 	= trim($conexiondb->real_escape_string($_POST["password"]));

	$DatosUsuario = SELECT_datos_usuario($email);

	if($DatosUsuario['existe']){

		$hasher = new PasswordHash(10, FALSE);
		$check = $hasher->CheckPassword($password, $DatosUsuario['clave']);
		if($check){
			$_SESSION['Usuario'] = $DatosUsuario;
			$rps = json_encode(array("rps" => 1, "tipo" => 2));

		}else{
			$rps = json_encode(array("rps" => 0, "respuesta" => '<em class="fa fa-warning"></em> Credenciales incorrectas' ));
		}

	}else{

		$DatosAdmin = SELECT_datos_administrador($email);

		if($DatosAdmin['existe']){

			$hasher = new PasswordHash(10, FALSE);
			$check = $hasher->CheckPassword($password, $DatosAdmin['clave']);
			if($check){
				$_SESSION['Administrador'] = $DatosAdmin;
				$_SESSION['Administrador']['rol'] = 'Administrador';
				$rps = json_encode(array("rps" => 1, "tipo" => 1));

			}else{
				$rps = json_encode(array("rps" => 0, "respuesta" => '<em class="fa fa-warning text-inverse"></em> Credenciales incorrectas' ));
			}

		}else{
			$rps = json_encode(array("rps" => 0, "respuesta" => '<em class="fa fa-warning text-inverse"></em> Credenciales incorrectas' ));
		}
	}

	echo $rps;
}else
if(isset($_POST["RecuperarContraseña"])){
	
	$conexiondb = $BD->conectar();
	$email 		= trim($conexiondb->real_escape_string($_POST["correo"]));
	$DatosUsuario 	= SELECT_datos_usuario($email);
	$clave_ = generar_contrasena();
	$hasher = new PasswordHash(10, FALSE);
	$clave 	= $hasher->HashPassword($clave_);

	if($DatosUsuario['existe']){
		if(UPDATE_clave_usuario($clave, $DatosUsuario['id'])){
			$mensaje = '
					Hemos generado una nueva contraseña, al acceder recuerde cambiarla en Mi perfil->Cambiar contraseña<br><br>
					<b>Nueva contraseña: </b>'.$clave_.'
				';
			if(enviar_email($DatosUsuario['nombre'], $email, 'Recuperación de contraseña', $mensaje)){
				$rps = json_encode(array("rps" => true, "respuesta" => '<em class="fa fa-check"></em> Hemos envia un correo de recuperación' ));

			}else{
				$rps = json_encode(array("rps" => 0, "respuesta" => '<em class="fa fa-warning"></em> No fue posible enviar el correo de recuperacion' ));
			}
		}else{
			$rps = json_encode(array("rps" => false, "respuesta" => '<em class="fa fa-warning"></em> No pudimos iniciar el proceso de recuperacion.' ));
		}

	}else{

		$DatosAdmin = SELECT_datos_administrador($email);

		if($DatosAdmin['existe']){

			if(UPDATE_clave_administrador($clave, $DatosAdmin['id'])){
				$mensaje = '
					Hemos generado una nueva contraseña, al acceder recuerde cambiarla en Mi perfil->Cambiar contraseña<br><br>
					<b>Nueva contraseña: </b>'.$clave_.'
				';
				if(enviar_email($DatosUsuario['nombre'], $email, 'Recuperación de contraseña', $mensaje)){
					$rps = json_encode(array("rps" => true, "respuesta" => '<em class="fa fa-check"></em> Hemos envia un correo de recuperación' ));

				}else{
					$rps = json_encode(array("rps" => 0, "respuesta" => '<em class="fa fa-warning"></em> No fue posible enviar el correo de recuperacion' ));
				}

			}else{
				$rps = json_encode(array("rps" => 0, "respuesta" => '<em class="fa fa-warning text-inverse"></em> No pudimos iniciar el proceso de recuperacion.' ));
			}

		}else{
			$rps = json_encode(array("rps" => 0, "respuesta" => '<em class="fa fa-warning text-inverse"></em> Correo incorrecto' ));
		}
	}

	echo $rps;
}
?>