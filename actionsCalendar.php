<?php
	if (isset($_GET) && !empty($_GET)) {
		
		// Array de respuesta y regreso en JSON
		$response = array(
			'result' 	=> false,
			'mensaje' 	=> "No fue posible ejecutar la peticion para el calendario",
			'datos'		=> ""
		);

		//Incluimos la conexcion a la base de datos
		include('connection.php');
		include('calendar.php');

		
		//Conexion con la base de datos
		if ($errorDbConexion) {
			
			// verificamos la accion que vamos a ejecutar
			if (isset($_GET['action'])) {

				if ($_GET['action'] == 'InsertTipoEvento') {
					$nombreEvento = $_GET['nombreEvento'];
					$color = $_GET['color'];

					//Mandamos a llamar a la funcion que selecciona los datos de la DB
					if ($datosRegFuncion = InsertTipoEvento($mysqli2, $nombreEvento, $color)) {
					
						$response['result'] = true;
						$response['mensaje'] = 'Datos devueltos';
						$response['datos'] = $datosRegFuncion;

					}else{
						$response['mensaje'] = 'No se pudo realizar InsertTipoEvento';
					}
				}

				if ($_GET['action'] == 'SelectTipoEvento') {
				 	
					if ($datosRegFuncion = SelectTipoEvento($mysqli2)) {
						$response['result'] = true;
						$response['mensaje'] = 'Datos devueltos';
						$response['datos'] = $datosRegFuncion;
						
					}else{
						$response['mensaje'] = 'No se puedo realizar consulta SelectTipoEvento';
					}

				}

				if ($_GET['action'] == 'DeleteTipoEvento') {
				 	$idtipo_evento = (int) $_GET['idtipo_evento'];

				 	if ($datosRegFuncion = DeleteTipoEvento($mysqli2, $idtipo_evento)) {
				 		$response['result'] = true;
				 		$response['mensaje'] = 'Tipo Evento Eliminado';
				 		$response['datos'] = $datosRegFuncion;
				 	}else{
				 		$response['mensaje'] = 'No se pudo eliminar tipo de evento';
				 	}
				}

				if ($_GET['action'] == 'InsertEventoCalendario') {

				  	$nombre = $_GET['nombre'];
				  	$fechainicio =  $_GET['fechainicio'];


				 	if ($datosRegFuncion = InsertEventoCalendario($mysqli2, $nombre, $fechainicio)) {
				 		$response['result'] = true;
				 		$response['mensaje'] = 'Se agrega evento al calendario.';
				 		$response['datos']= $datosRegFuncion;
				 	}else{
				 		$response['datos'] = $datosRegFuncion;
				 		$response['mensaje'] = 'No se pudo agregar evento al calendario.';
				 	}

				} 

			}else{
				$response['mensaje'] = "Variable Action no Declarada";
			}
		}else{
			$response['mensaje'] = "Error con la conexion a la base de datos";
		}

		//salida JSON
		echo json_encode($response);
	}else{
		echo "No se puede ejecutar este script";
	}

?>