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
						$response['mensaje'] = 'No es posible realizar consulta SelectTipoEvento';
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
				  	$fechainicia =  $_GET['fechainicia'];
				  	$color = $_GET['color'];

				 	if ($datosRegFuncion = InsertEventoCalendario($mysqli2, $nombre, $fechainicia, $color)) {
				 		$response['result'] = true;
				 		$response['mensaje'] = 'Se agrega evento al calendario.';
				 		$response['datos']= $datosRegFuncion;
				 	}else{
				 		$response['datos'] = $datosRegFuncion;
				 		$response['mensaje'] = 'No se pudo agregar evento al calendario.';
				 	}
				} 

				if ($_GET['action'] == 'SelectEventosCalendario') {
					if ($datosRegFuncion = SelectEventosCalendario($mysqli2)) {
						$response['result'] = true;
						$response['mensaje'] = 'datos devueltos';
						$response['datos'] = $datosRegFuncion;
					}else{
						$response['mensaje'] = 'No es posible realizar consulta de Eventos del Calendario';
					}
				}

				if ($_GET['action'] == 'UpdateEventoCalendario') {

					$idevento = (int) $_GET['idevento'];
					$todoeldia = $_GET['todoeldia'];
					$fechainicia = $_GET['fechainicia'];
					$fechafinaliza = $_GET['fechafinaliza'];

					if ($datosRegFuncion = UpdateEventoCalendario($mysqli2, $idevento, $todoeldia, $fechainicia, $fechafinaliza)) {
						$response['result'] = true;
						$response['mensaje'] = 'datos devueltos';
						$response['datos'] = $datosRegFuncion;
					}else{
						$response['mensaje'] = 'No es posible realizar actualizacion de Evento.';
					}
				}

				if ($_GET['action'] == 'SelectEvento') {
					$idevento = (int) $_GET['idevento'];

					if ($datosRegFuncion = SelectEvento($mysqli2, $idevento)) {
						$response['result'] = true;
						$response['mensaje'] = 'datos devueltos';
						$response['datos'] = $datosRegFuncion;
					}else{
						$response['mensaje'] = 'No es posible realizar consulta del Evento.';
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
	}elseif (isset($_POST) && !empty($_POST)) {

				// Array de respuesta y regreso en JSON
		$response = array(
			'result' 	=> false,
			'mensaje' 	=> "No fue posible ejecutar la peticion para el calendario",
			'datos'		=> ""
		);

		//Incluimos la conexcion a la base de datos
		include('connection.php');
		include('calendar.php');

		//conexion con la base de datos
		if ($errorDbConexion) {

			if (isset($_POST['action'])) {

				if ($_POST['action'] == 'UpdateEventoFormulario') {
					$idevento = (int) $_POST['idevento'];
					$nombre = $_POST['nombre'];
					$todoeldia = $_POST['todoeldia'];
					$fecha_inicia = $_POST['fecha_inicia'];
					$fecha_finaliza = $_POST['fecha_finaliza'];
					$color = $_POST['color'];
					$lugar = $_POST['lugar'];
					$descripcion = $_POST['descripcion'];
					$adjunto = $_POST['adjunto'];
					$idgrupo = (int) $_POST['idgrupo'];
					$otroscorreos = $_POST['otroscorreos'];
					$estado = $_POST['estado'];

					if ($datosRegFuncion = UpdateEventoFormulario($mysqli2, $idevento, $nombre, $todoeldia, $fecha_inicia, 
						$fecha_finaliza, $color, $lugar, $descripcion, $adjunto, $idgrupo, $otroscorreos, $estado)) {
						$response['result'] = true;
						$response['mensaje'] = 'Datos Devueltos';
						$response['datos'] = $datosRegFuncion;
					}else{
						$response['mensaje'] = 'No es posible realizar actualizacion del evento.';
					}
				}

				if ($_POST['action'] == 'SendEmail') {
					$para = $_POST['para'];
					$nombre = $_POST['nombre'];
					$asunto = $_POST['asunto'];
					$descripcion = $_POST['descripcion'];

					if ($datosRegFuncion = SendEmail($para, $nombre, $asunto, $descripcion)) {
						$response['result'] = true;
						$response['mensaje'] = 'Correo Enviado';
						$response['datos'] = $datosRegFuncion;
					}else{
						$response['mensaje'] = 'No es posible enviar correo.';
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
	}
	else{
		echo "No se puede ejecutar este script";
	}

?>