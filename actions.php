<?php 

if (isset($_GET) && !empty($_GET)) {
	
	// Array de respuesta y regreso en JSON
	$response = array(
		'result' 	=> false,
		'mensaje' 	=> "No fue posible ejecutar la peticion",
		'datos'		=> ""
	);

	//Incluimos la conexcion a la base de datos
	include('connection.php');
	include('contingentes.php');

	
	//Conexion con la base de datos
	if ($errorDbConexion) {
		
		// verificamos la accion que vamos a ejecutar
		if (isset($_GET['action'])) {


			if ($_GET['action'] == 'getListaTratados') {
				//Mandamos a llamar a la funcion que selecciona los datos de la DB
				if ($datosRegFuncion = getListaTratados($mysqli)) {
				
					$response['result'] = true;
					$response['mensaje'] = 'Datos devueltos';
					$response['datos'] = $datosRegFuncion;

				}else{
					$response['mensaje'] = 'No se pudo realizar consulta';
				}
			} 

			if ($_GET['action'] == 'getListaContingentes'){
				$idTratado = (int) $_GET['idTratado'];

				if ($datosRegFuncion = getListaContingentes($mysqli, $idTratado)) {
				
					$response['result'] = true;
					$response['mensaje'] = 'Datos devueltos';
					$response['datos'] = $datosRegFuncion;

				}else{
					$response['mensaje'] = 'No existen contingentes para este tratado';
				}
			}

			if ($_GET['action'] == 'getListaPeriodo'){
				if ($datosRegFuncion = getListaPeriodo($mysqli)) {
					$response['result'] = true;
					$response['mensaje'] = 'Datos devueltos';
					$response['datos'] = $datosRegFuncion;

				}else{
					$response['mensaje'] = 'No se pudo realizar consulta de periodos';
				}
			}

			if ($_GET['action'] == 'getDatosTablero') {

				$idTratado = (int) $_GET['idTratado'];

				if ($idTratado != 0) {
					$idPeriodo = (int) $_GET['idPeriodo'];
					$idContingente = (int) $_GET['idContingente'];	
				}else{
					$idPeriodo = 0;
					$idContingente = 0;
				}

				if ($datosRegFuncion = getDatosTablero($mysqli, $idTratado, $idPeriodo, $idContingente)) {
					$response['result'] = true;
					$response['mensaje'] = 'Datos devueltos';
					$response['datos'] = $datosRegFuncion;
				}else{
					$response['mensaje'] = 'No se pudo realizar consulta de datos para el tablero';
				}
			}

			if ($_GET['action'] == 'getDatosControles') {
				
				$idTratado = (int) $_GET['idTratado'];
				$idContingente = (int) $_GET['idContingente'];
				$idPeriodo = (int) $_GET['idPeriodo'];

				if ($datosRegFuncion = getDatosControles($mysqli, $idTratado, $idContingente, $idPeriodo)) {
					$response['result'] = true;
					$response['mensaje'] = 'Datos devueltos';
					$response['datos'] = $datosRegFuncion;
				}else{
					$response['mensaje'] = 'No se pudo realizar consulta de datos para los controles del tablero';
				}
			}

			if ($_GET['action'] == 'getDatosReporte') {
				
				$idTratado = (int) $_GET['idTratado'];
				$idContingente = (int) $_GET['idContingente'];
				$idPeriodo = (int) $_GET['idPeriodo'];

				if ($datosRegFuncion = getDatosReporte($mysqli, $idTratado, $idContingente, $idPeriodo)) {
					$response['result'] = true;
					$response['mensaje'] = 'Datos devueltos';
					$response['datos'] = $datosRegFuncion;
				}else{
					$response['mensaje'] = 'No se pudo realizar consulta de datos para el reporte';
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