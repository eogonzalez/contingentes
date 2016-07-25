<?php

/*
	Funcion que selecciona los tipos de eventos creados en el calendario
*/
function SelectTipoEvento($dbLink){
	$response = array();

	$sql = "SELECT idtipo_evento, nombre, color
			FROM trazabilidad.tipo_eventos
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
	Funcion que inserta el tipo de evento creado
*/
function InsertTipoEvento($dbLink, $nombreEvento, $color){
	$response = array();

	$dia = (string) date("d");
	$mes = (string) date("m");
	$anio = (string) date("Y");

	$fecha_actual = $anio."-".$mes."-".$dia;

	//Query que consulta tratados
	$sql = sprintf("INSERT INTO tipo_eventos
					(nombre, color, estado, fecha_creacion, fecha_actualizacion)
					VALUES
					('%s','%s','%s','%s','%s')", $nombreEvento, $color, 'A', $fecha_actual, $fecha_actual);


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
	Funcion que elimina el tipo de evento
*/
function DeleteTipoEvento($dbLink, $idtipo_evento){
	$response = array();

	$sql = sprintf("DELETE FROM trazabilidad.tipo_eventos 
					WHERE idtipo_evento= %d", $idtipo_evento);

	//Ejecutamos delete
	$result = $dbLink->query($sql);

	if ($result == true) {
		$response[] = true;
	}else{
		$response[] = $dbLink->error;
	}

	$dbLink->close();

	return $response;
}

/*
	Funcion que Inserta el evento en el calendario al memento de arrastrarlo al calendario
*/

function InsertEventoCalendario($dbLink, $nombre, $fecha_inicia){


	/*$newDate = date("Y-m-d H:i:s", strtotime($fecha_inicia));*/

	$response = array();

	$dia = (string) date("d");
	$mes = (string) date("m");
	$anio = (string) date("Y");

	$fecha_actual = $anio."-".$mes."-".$dia;

	/*
	estado
	P = Pendiente
	A = Alta
	C = Cancelado
	*/

	$sql = sprintf("INSERT INTO EVENTOS
					(nombre, fecha_inicia, fecha_finaliza, todoeldia, estado, 
					fecha_creacion, fecha_actualizacion)
					VALUES
					('%s', '%s', '%s', 
					'%s', '%s', '%s', '%s')", $nombre, $fecha_inicia, $fecha_inicia, 'S', 'P', $fecha_actual, $fecha_actual);

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

?>