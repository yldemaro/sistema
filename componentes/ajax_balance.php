<?php 
session_start();
include 'conexion.php';
include 'funciones.php';
include 'consultas.php';
$BD = new BD();


if(isset($_POST["RecargarPuntos"])){
	
	if (!empty($_SESSION['Administrador']) && !empty($_POST["RecargarPuntos"])) {
		$conexiondb = $BD->conectar();

		$monto 		= trim($conexiondb->real_escape_string($_POST["monto"]));
		$concepto 	= trim($conexiondb->real_escape_string($_POST["concepto"]));
		$tipo 		= trim($conexiondb->real_escape_string($_POST["tipo"]));
		$id_usuario = trim($conexiondb->real_escape_string($_POST["RecargarPuntos"]));
		$credito 	= $debito = 0;

		if($monto>0){
			$continuar = true;
			if ($tipo=='1') {
				$credito =  $monto;
			}elseif ($tipo=='2') {
				$debito =  $monto;
			}else{
				$continuar = false;
			}
			if ($continuar) {
				if(INSERT_balance_punto($credito, $debito, $concepto, $id_usuario, $_SESSION['Administrador']['id'])){
					$rps = json_encode(array("rps" => true, "respuesta" => '<i class="icon fa fa-check"></i> Puntos guardados.', 'puntos' => number_format(balance_puntos_usuario($id_usuario),2,'.',',') ));
				}else{
					$rps = json_encode(array("rps" => false, "respuesta" => '<em class="fa fa-warning"></em> No pudimos actualizar su contraseña.' ));
				}
			}else{
				$rps = json_encode(array("rps" => false, "respuesta" => '<i class="icon fa fa-ban"></i> Tipo de balance desconocido.' ));
			}
		}else{
			$rps = json_encode(array("rps" => false, "respuesta" => '<i class="icon fa fa-ban"></i> El monto debe ser mayor a cero.' ));
		}

		$conexiondb = $BD->cerrar();
	}else{
		$rps = json_encode(array("rps" => false, "respuesta" => '<i class="icon fa fa-ban"></i> No puedes realizar esta acción.' ));
	}

	echo $rps;
}else
if (isset($_POST["GraficaBalance"])) {
	$conexiondb = $BD->conectar();
	$fecha_obj 	= new DateTime();
	$hoy 	= $fecha_obj->format('Y-m-d');
	$mes 	= $fecha_obj->format('Y-m');
	$fecha_obj->modify('last day of this month');
	$ultimo = $fecha_obj->format('d');

	for ($i=1; $i <= $ultimo; $i++) { 
		$creditos[] = '';
		$debitos[] 	= '';
		$fechas[] 	= ($i>9)?$mes.'-'.$i:$mes.'-0'.$i;
	}

	$id_usuario = $_SESSION['Usuario']['id'];
	// @$desde = (isset($_GET["desde"]))?((!empty($_GET["desde"]))?$_GET["desde"]:$mes.'-01'):$mes.'-01';
	// $desde = $conexiondb->real_escape_string($desde);

	// @$hasta = (isset($_GET["hasta"]))?((!empty($_GET["hasta"]))?$_GET["hasta"]:$hoy):$hoy;
	// $hasta = $conexiondb->real_escape_string($hasta);
	$filtro=" AND fecha >='".$mes.'-01'."' ";
		
	$sql = "SELECT SUM(credito) as creditos, SUM(debito) as debitos, CONVERT(fecha, DATE) as fecha FROM balance_punto WHERE id_usuario = ? ".$filtro." GROUP BY CONVERT(fecha, DATE) ORDER BY fecha ASC";
	$sentencia = $conexiondb->prepare($sql);
	$sentencia->bind_param('i', $v1);
	$v1 = $id_usuario;

	$sentencia->execute();
	$sentencia->bind_result($credito, $debito, $fecha);

	$sentencia->store_result();
	if($sentencia->num_rows>0){
		while($filas = $sentencia->fetch()){
			// for ($i=1; $i <= $ultimo; $i++) { 
			// 	$creditos[] = 0;
			// 	$debitos[] 	= 0;
			// 	$fechas[] 	= ($i>9)?$mes.'-'.$i:$mes.'-0'.$i;
			// }
			$dia = (int)substr($fecha, -2)-1;
			$creditos[$dia] = $credito;
			$debitos[$dia] 	= $debito;
		}
	}

	$conexiondb->close();

	echo $rps = json_encode(array("rps" => true, "datos" => array($fechas, $creditos, $debitos) ));
}else
if (isset($_POST["GraficaBalanceFiltro"])) {
	$conexiondb = $BD->conectar();
	$fecha_obj 	= new DateTime();
	$mes_actual = $fecha_obj->format('m');

	$id_usuario = $_SESSION['Usuario']['id'];
	@$mes = (isset($_POST["mes"]))?((!empty($_POST["mes"]))?$_POST["mes"]:$fecha_obj->format('m')):$fecha_obj->format('m');
	$mes 	= $conexiondb->real_escape_string($mes);
	$desde 	= '2018-'.$mes.'-01';
	$mes_f 	= '2018-'.$mes;
	$ultimo = $fecha_obj->format('d');
	
	$fecha_obj 	= new DateTime('2018-'.$mes.'-01');
	if ((int)$mes==(int)$mes_actual) {
		$ultimo = ($ultimo<23)?$ultimo+2:$ultimo;
	}else{
		$fecha_obj->modify('last day of this month');
		$ultimo = $fecha_obj->format('d');
	}

	$hasta 	= '2018-'.$mes.'-'.$ultimo;
	for ($i=1; $i <= $ultimo; $i++) { 
		$creditos[] = '';
		$debitos[] 	= '';
		$fechas[] 	= ($i>9)?$mes_f.'-'.$i:$mes_f.'-0'.$i;
	}

	$sql = "SELECT SUM(credito) as creditos, SUM(debito) as debitos, CONVERT(fecha, DATE) as fecha FROM balance_punto WHERE id_usuario = ? AND fecha>='".$desde."' AND fecha<='".$hasta."' GROUP BY CONVERT(fecha, DATE) ORDER BY fecha ASC";
	$sentencia = $conexiondb->prepare($sql);
	$sentencia->bind_param('i', $v1);
	$v1 = $id_usuario;

	$sentencia->execute();
	$sentencia->bind_result($credito, $debito, $fecha);

	$sentencia->store_result();
	if($sentencia->num_rows>0){
		while($filas = $sentencia->fetch()){
			// for ($i=1; $i <= $ultimo; $i++) { 
			// 	$creditos[] = 0;
			// 	$debitos[] 	= 0;
			// 	$fechas[] 	= ($i>9)?$mes.'-'.$i:$mes.'-0'.$i;
			// }
			$dia = (int)substr($fecha, -2)-1;
			$creditos[$dia] = $credito;
			$debitos[$dia] 	= $debito;
		}
	}

	$conexiondb->close();

	echo $rps = json_encode(array("rps" => true, "datos" => array($fechas, $creditos, $debitos) ));
}

?>