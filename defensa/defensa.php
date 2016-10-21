<?php
	date_default_timezone_set('Etc/UTC');

	//require '/PHPMailer-master/PHPMailerAutoload.php';
/*
	Funcion que selecciona todos los temas activos
*/
function SelectTemas($dbLink){
	$response = array();

	$sql = "SELECT idg_temas, nombre
			FROM trazabilidad.g_temas
			where estado = 'A'";

	$result = $dbLink->query($sql);

	if ($result->num_rows != 0) {

		while ($registro = $result->fetch_array()) {
			$response [] = $registro;
		}
	}

	return $response;
}


/*
	Funcion que inserta tema
*/
function InsertTema($dbLink, $nombre){
	$response = array();

	$dia = (string) date("d");
	$mes = (string) date("m");
	$anio = (string) date("Y");

	$fecha_actual = $anio."-".$mes."-".$dia;

	//Query que consulta tratados
	$sql = sprintf("INSERT INTO g_temas
					(nombre, estado, fecha_creacion, fecha_actualizacion)
					VALUES
					('%s','%s','%s','%s')", $nombre, 'A', $fecha_actual, $fecha_actual);


	// Ejecutamos la consulta
	$result = $dbLink->query($sql);

	if ($result == true) {
		
		$response [] = true;
		
	}
	else{
		$response [] = $dbLink->error;
	}

	$dbLink->close();

	return $response;
}

/*
	Funcion que selecciona tema especifico
*/

function SelectTema($dbLink, $idTema){
	$response = array();

	$sql = sprintf("SELECT nombre
			FROM trazabilidad.g_temas
			where idg_temas = %d ",$idTema);

	$result = $dbLink->query($sql);

	if ($result->num_rows != 0) {

		while ($registro = $result->fetch_array()) {
			$response [] = $registro;
		}
	}

	return $response;
}


/*
	Funcion que actualiza tema
*/

function UpdateTema($dbLink, $idTema, $nombre){
	$response = array();
	$dia = (string) date("d");
	$mes = (string) date("m");
	$anio = (string) date("Y");

	$fecha_actual = $anio."-".$mes."-".$dia;


	$sql = sprintf("UPDATE 
						trazabilidad.g_temas
					SET
						nombre = '%s',
						fecha_actualizacion = '%s'
					WHERE idg_temas = %d ", $nombre, $fecha_actual, $idTema);

	$result = $dbLink->query($sql);

	if ($result == true) {
		$response[] = true;
	}else{
		$response[] = $sql;
		$response[] = $dbLink->error;
	}

	$dbLink->close();

	return $response;
}


/*
	Funcion que selecciona tipos de actividad activo
*/
function SelectTipoActividades($dbLink){
	$response = array();

	$sql = "SELECT idg_actividad, nombre
			FROM trazabilidad.g_actividad
			where estado = 'A'";

	$result = $dbLink->query($sql);

	if ($result->num_rows != 0) {

		while ($registro = $result->fetch_array()) {
			$response [] = $registro;
		}
	}

	return $response;
}


/*
	Funcion que inserta tipo de actividad
*/
function InsertTipoActividad($dbLink, $nombre){
	$response = array();

	$dia = (string) date("d");
	$mes = (string) date("m");
	$anio = (string) date("Y");

	$fecha_actual = $anio."-".$mes."-".$dia;

	//Query que consulta tratados
	$sql = sprintf("INSERT INTO g_actividad
					(nombre, estado, fecha_creacion, fecha_actualizacion)
					VALUES
					('%s','%s','%s','%s')", $nombre, 'A', $fecha_actual, $fecha_actual);


	// Ejecutamos la consulta
	$result = $dbLink->query($sql);

	if ($result == true) {
		
		$response [] = true;
		
	}
	else{
		$response [] = $dbLink->error;
	}

	$dbLink->close();

	return $response;
}

/*
	Funcion que selecciona tipo de actividad especifico
*/

function SelectTipoActividad($dbLink, $idTipoActividad){
	$response = array();

	$sql = sprintf("SELECT nombre
			FROM trazabilidad.g_actividad
			where idg_actividad = %d ",$idTipoActividad);

	$result = $dbLink->query($sql);

	if ($result->num_rows != 0) {

		while ($registro = $result->fetch_array()) {
			$response [] = $registro;
		}
	}

	return $response;
}


/*
	Funcion que actualiza tipo de actividad
*/

function UpdateTipoActividad($dbLink, $idTipoActividad, $nombre){
	$response = array();
	$dia = (string) date("d");
	$mes = (string) date("m");
	$anio = (string) date("Y");

	$fecha_actual = $anio."-".$mes."-".$dia;


	$sql = sprintf("UPDATE 
						trazabilidad.g_actividad
					SET
						nombre = '%s',
						fecha_actualizacion = '%s'
					WHERE idg_actividad = %d ", $nombre, $fecha_actual, $idTipoActividad);

	$result = $dbLink->query($sql);

	if ($result == true) {
		$response[] = true;
	}else{
		$response[] = $sql;
		$response[] = $dbLink->error;
	}

	$dbLink->close();

	return $response;
}

/*
	Funcion que selecciona todos los usuarios activos
*/
function SelectUsuarios($dbLink){
	$response = array();

	$sql = "SELECT idusuarios, nombre
			FROM trazabilidad.usuarios
			where estado = 'A'";

	$result = $dbLink->query($sql);

	if ($result->num_rows != 0) {

		while ($registro = $result->fetch_array()) {
			$response [] = $registro;
		}
	}

	return $response;
}

/*
	Funcion que inserta usuario
*/
function InsertUsuario($dbLink, $nombre, $usuario, $correo){
	$response = array();

	$dia = (string) date("d");
	$mes = (string) date("m");
	$anio = (string) date("Y");

	$fecha_actual = $anio."-".$mes."-".$dia;

	//Query que consulta tratados
	$sql = sprintf("INSERT INTO usuarios
					(nombre, usuario, contraseña, correo, estado, fecha_creacion, fecha_actualizacion)
					VALUES
					('%s','%s','%s','%s','%s','%s','%s')", $nombre, $usuario, '123456', $correo, 'A', $fecha_actual, $fecha_actual);


	// Ejecutamos la consulta
	$result = $dbLink->query($sql);

	if ($result == true) {
		
		$response [] = true;
		
	}
	else{
		$response [] = $dbLink->error;
	}

	$dbLink->close();

	return $response;
}

/*
	Funcion que selecciona usuario especifico
*/

function SelectUsuario($dbLink, $idUsuario){
	$response = array();

	$sql = sprintf("SELECT nombre, usuario, correo
			FROM trazabilidad.usuarios
			where idusuarios = %d ",$idUsuario);

	$result = $dbLink->query($sql);

	if ($result->num_rows != 0) {

		while ($registro = $result->fetch_array()) {
			$response [] = $registro;
		}
	}

	return $response;
}


/*
	Funcion que actualiza usuario
*/

function UpdateUsuario($dbLink, $idUsuario, $nombre, $correo){
	$response = array();
	$dia = (string) date("d");
	$mes = (string) date("m");
	$anio = (string) date("Y");

	$fecha_actual = $anio."-".$mes."-".$dia;


	$sql = sprintf("UPDATE 
						trazabilidad.usuarios
					SET
						nombre = '%s',
						correo = '%s',
						fecha_actualizacion = '%s'
					WHERE idusuarios = %d ", $nombre, $correo, $fecha_actual, $idUsuario);

	$result = $dbLink->query($sql);

	if ($result == true) {
		$response[] = true;
	}else{
		$response[] = $sql;
		$response[] = $dbLink->error;
	}

	$dbLink->close();

	return $response;
}


/*
	Funcion que selecciona todos los usuarios activos
*/
function SelectActividades($dbLink, $noActividad, $estado, $tema, $tipoAct, $fechaIni, $fechaFin){
	$response = array();

	//echo "$noActividad";
	if (strlen($noActividad) > 0 ) {
		// So Actividad no viene vacia

		if ($noActividad == 0) {
			//Si la consulta se realiza daesde el load
			
			$fechaNew = strtotime($fechaIni);

			$mes = date("m", $fechaNew);

			$sql = sprintf("SELECT  gr.idg_RegistroActividades, 
							gr.idg_tema, gt.nombre as nombreTema , 
							gr.idg_actividad, ga.nombre as nombreTipoActividad,
							gr.idusuarios, u.nombre as nombreUsuario,
							gr.fecha_inicio, gr.descripcion, gr.estado
					FROM 
						trazabilidad.g_registroactividades gr
					join 
						trazabilidad.g_temas gt on
						gr.idg_tema = gt.idg_temas
					join
						trazabilidad.g_actividad ga on
						gr.idg_actividad = ga.idg_actividad
					join
						trazabilidad.usuarios u on
						gr.idusuarios = u.idusuarios
					WHERE month(fecha_inicio) = '%d'
					ORDER BY gr.idg_RegistroActividades DESC", $mes);

		}else{

			$sql = " SELECT  gr.idg_RegistroActividades, 
							gr.idg_tema, gt.nombre as nombreTema , 
							gr.idg_actividad, ga.nombre as nombreTipoActividad,
							gr.idusuarios, u.nombre as nombreUsuario,
							gr.fecha_inicio, gr.descripcion, gr.estado
					FROM 
						trazabilidad.g_registroactividades gr
					join 
						trazabilidad.g_temas gt on
						gr.idg_tema = gt.idg_temas
					join
						trazabilidad.g_actividad ga on
						gr.idg_actividad = ga.idg_actividad
					join
						trazabilidad.usuarios u on
						gr.idusuarios = u.idusuarios 
					WHERE 
						idg_RegistroActividades=".$noActividad." AND gr.fecha_inicio >= '".$fechaIni."' AND gr.fecha_inicio <= '".$fechaFin."'"
						 ;

			if ($estado != "Todos") {				
				$sql .= " AND gr.estado = '".$estado."'";
			}

			
			if ($tema != 0) {
				$sql .= " AND gr.idg_tema = '".$tema."'";	
			}

			if ($tipoAct != 0) {
				$sql .= " AND gr.idg_actividad = '".$tipoAct."'";
			}

			$sql .= " ORDER BY gr.idg_RegistroActividades DESC ";
		}
	}else{
		//Si Actividad viene vacia

			$sql = " SELECT  gr.idg_RegistroActividades, 
							gr.idg_tema, gt.nombre as nombreTema , 
							gr.idg_actividad, ga.nombre as nombreTipoActividad,
							gr.idusuarios, u.nombre as nombreUsuario,
							gr.fecha_inicio, gr.descripcion, gr.estado
					FROM 
						trazabilidad.g_registroactividades gr
					join 
						trazabilidad.g_temas gt on
						gr.idg_tema = gt.idg_temas
					join
						trazabilidad.g_actividad ga on
						gr.idg_actividad = ga.idg_actividad
					join
						trazabilidad.usuarios u on
						gr.idusuarios = u.idusuarios 
					WHERE
						gr.fecha_inicio >= '".$fechaIni."' AND gr.fecha_inicio <= '".$fechaFin."'";

			

			if ($estado != "Todos") {
				
				$sql .= " AND gr.estado = '".$estado."'";
			}


			if ($tema != 0) {

				$sql .= " AND gr.idg_tema = '".$tema."'";	
			}

			if ($tipoAct != 0) {

					$sql .= " AND gr.idg_actividad = '".$tipoAct."'";

			}

			$sql .= " ORDER BY gr.idg_RegistroActividades DESC ";

	}

	$result = $dbLink->query($sql);

	if ($result->num_rows != 0) {

		while ($registro = $result->fetch_array()) {
			$response [] = $registro;
		}
	}

	return $response;
}

/*
	Funcion que inserta actividad
*/
function InsertActividad($dbLink, $idTema, $idTipoActividad, $idUsuario, $fecha_inicio, $descripcion, $estado, $otroscorreos){
	$response = array();

	$dia = (string) date("d");
	$mes = (string) date("m");
	$anio = (string) date("Y");

	$fecha_actual = $anio."-".$mes."-".$dia;

	//Query que consulta tratados
	$sql = sprintf("INSERT INTO g_registroactividades
					(idg_tema, idg_actividad, idusuarios, fecha_inicio, fecha_final, descripcion, estado, otroscorreos, fecha_creacion, fecha_actualizacion)
					VALUES
					('%d','%d','%d','%s','%s','%s','%s', '%s', '%s', '%s')", $idTema, $idTipoActividad, $idUsuario, $fecha_inicio, $fecha_inicio, $descripcion, $estado, $otroscorreos, $fecha_actual, $fecha_actual);


	// Ejecutamos la consulta
	$result = $dbLink->query($sql);

	if ($result == true) {
		
		$response [] = true;
		
	}
	else{
		$response [] = $dbLink->error;
	}

	$dbLink->close();

	return $response;
}

/*
	Funcion que selecciona actividad especifica
*/

function SelectActividad($dbLink, $idActividad){
	$response = array();

	$sql = sprintf("SELECT idg_tema, idg_actividad, idUsuarios, fecha_inicio, descripcion, estado, otroscorreos
			FROM trazabilidad.g_registroactividades
			where idg_RegistroActividades = %d ",$idActividad);

	$result = $dbLink->query($sql);

	if ($result->num_rows != 0) {

		while ($registro = $result->fetch_array()) {
			$response [] = $registro;
		}
	}

	return $response;
}


/*
	Funcion que actualiza usuario
*/

function UpdateActividad($dbLink, $idTema, $idTipoActividad, $idUsuario, $fecha_inicio, $descripcion, $idActividad, $estado, $otroscorreos){
	$response = array();
	$dia = (string) date("d");
	$mes = (string) date("m");
	$anio = (string) date("Y");

	$fecha_actual = $anio."-".$mes."-".$dia;


	$sql = sprintf("UPDATE 
						trazabilidad.g_registroactividades
					SET
						idg_tema = '%d',
						idg_actividad = '%d',
						idUsuarios = '%d',
						fecha_inicio = '%s',
						descripcion = '%s',
						fecha_actualizacion = '%s',
						estado = '%s',
						otroscorreos = '%s'
					WHERE idg_RegistroActividades = %d ", 
					$idTema, $idTipoActividad, $idUsuario, $fecha_inicio, $descripcion, $fecha_actual, $estado, $otroscorreos, $idActividad);

	$result = $dbLink->query($sql);

	if ($result == true) {
		$response[] = true;
	}else{
		$response[] = $sql;
		$response[] = $dbLink->error;
	}

	$dbLink->close();

	return $response;
}

function SelectCorreo($dbLink, $idUsuario){
	$response = array();

	$sql = sprintf(" SELECT correo 
					from usuarios 
					where idusuarios = %d ", $idUsuario);

	$result = $dbLink->query($sql);

	if ($result->num_rows != 0) {

		while ($registro = $result->fetch_array()) {
			$response [] = $registro;
		}
	}

	return $response;
}

?>