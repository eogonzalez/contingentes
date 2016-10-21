<?php
	if (isset($_GET) && !empty($_GET)) {
		
		// Array de respuesta y regreso en JSON
		$response = array(
			'result' 	=> false,
			'mensaje' 	=> "No fue posible ejecutar la peticion para Defensa Comercial",
			'datos'		=> ""
		);

		//Incluimos la conexcion a la base de datos
		include('../connection.php');
		include('defensa.php');

		
		//Conexion con la base de datos
		if ($errorDbConexion) {
			
			// verificamos la accion que vamos a ejecutar
			if (isset($_GET['action'])) {

				if ($_GET['action'] == 'InsertTema') {
					$nombreTema = $_GET['nombreTema'];
					

					//Mandamos a llamar a la funcion que selecciona los datos de la DB
					if ($datosRegFuncion = InsertTema($mysqli2, $nombreTema)) {
					
						$response['result'] = true;
						$response['mensaje'] = 'Datos devueltos';
						$response['datos'] = $datosRegFuncion;

					}else{
						$response['mensaje'] = 'No se pudo realizar InsertTipoEvento';
					}
				}

				if ($_GET['action'] == 'SelectTemas') {
				 	
					if ($datosRegFuncion = SelectTemas($mysqli2)) {
						$response['result'] = true;
						$response['mensaje'] = 'Datos devueltos';
						$response['datos'] = $datosRegFuncion;
						
					}else{
						$response['mensaje'] = 'No es posible realizar consulta SelectTemas';
					}
				}

				if ($_GET['action'] == 'SelectTema') {
					$idTema = (int) $_GET['idTema'];
				 	
					if ($datosRegFuncion = SelectTema($mysqli2, $idTema)) {
						$response['result'] = true;
						$response['mensaje'] = 'Datos devueltos';
						$response['datos'] = $datosRegFuncion;
						
					}else{
						$response['mensaje'] = 'No es posible realizar consulta SelectTema';
					}
				}

				if ($_GET['action'] == 'UpdateTema') {

					$idTema = (int) $_GET['idTema'];
					$nombreTema = $_GET['nombreTema'];
					

					if ($datosRegFuncion = UpdateTema($mysqli2, $idTema, $nombreTema)) {
						$response['result'] = true;
						$response['mensaje'] = 'datos devueltos';
						$response['datos'] = $datosRegFuncion;
					}else{
						$response['mensaje'] = 'No es posible realizar actualizacion de Tema.';
					}
				}

				if ($_GET['action'] == 'InsertTipoActividad') {
					$nombreTipoActividad = $_GET['nombreTipoActividad'];
					

					//Mandamos a llamar a la funcion que selecciona los datos de la DB
					if ($datosRegFuncion = InsertTipoActividad($mysqli2, $nombreTipoActividad)) {
					
						$response['result'] = true;
						$response['mensaje'] = 'Datos devueltos';
						$response['datos'] = $datosRegFuncion;

					}else{
						$response['mensaje'] = 'No se pudo realizar InsertTipoActividad';
					}
				}

				if ($_GET['action'] == 'SelectTipoActividades') {
				 	
					if ($datosRegFuncion = SelectTipoActividades($mysqli2)) {
						$response['result'] = true;
						$response['mensaje'] = 'Datos devueltos';
						$response['datos'] = $datosRegFuncion;
						
					}else{
						$response['mensaje'] = 'No es posible realizar consulta SelectTipoActividades';
					}
				}

				if ($_GET['action'] == 'SelectTipoActividad') {
					$idTipoActividad = (int) $_GET['idTipoActividad'];
				 	
					if ($datosRegFuncion = SelectTipoActividad($mysqli2, $idTipoActividad)) {
						$response['result'] = true;
						$response['mensaje'] = 'Datos devueltos';
						$response['datos'] = $datosRegFuncion;
						
					}else{
						$response['mensaje'] = 'No es posible realizar consulta SelectTipoActividad';
					}
				}

				if ($_GET['action'] == 'UpdateTipoActividad') {

					$idTipoActividad = (int) $_GET['idTipoActividad'];
					$nombreTipoActividad = $_GET['nombreTipoActividad'];
					

					if ($datosRegFuncion = UpdateTipoActividad($mysqli2, $idTipoActividad, $nombreTipoActividad)) {
						$response['result'] = true;
						$response['mensaje'] = 'datos devueltos';
						$response['datos'] = $datosRegFuncion;
					}else{
						$response['mensaje'] = 'No es posible realizar actualizacion de Tipo Actividad.';
					}
				}

				if ($_GET['action'] == 'InsertUsuario') {
					$nombre = $_GET['nombre'];
					$usuario = $_GET['usuario'];
					$correo = $_GET['correo'];
					

					//Mandamos a llamar a la funcion que selecciona los datos de la DB
					if ($datosRegFuncion = InsertUsuario($mysqli2, $nombre, $usuario, $correo)) {
					
						$response['result'] = true;
						$response['mensaje'] = 'Datos devueltos';
						$response['datos'] = $datosRegFuncion;

					}else{
						$response['mensaje'] = 'No se pudo realizar InsertUsuario';
					}
				}

				if ($_GET['action'] == 'SelectUsuarios') {
				 	
					if ($datosRegFuncion = SelectUsuarios($mysqli2)) {
						$response['result'] = true;
						$response['mensaje'] = 'Datos devueltos';
						$response['datos'] = $datosRegFuncion;
						
					}else{
						$response['mensaje'] = 'No es posible realizar consulta SelectUsuarios';
					}
				}

				if ($_GET['action'] == 'SelectUsuario') {
					$idUsuario = (int) $_GET['idUsuario'];
				 	
					if ($datosRegFuncion = SelectUsuario($mysqli2, $idUsuario)) {
						$response['result'] = true;
						$response['mensaje'] = 'Datos devueltos';
						$response['datos'] = $datosRegFuncion;
						
					}else{
						$response['mensaje'] = 'No es posible realizar consulta SelectUsuario';
					}
				}

				if ($_GET['action'] == 'UpdateUsuario') {

					$idUsuario = (int) $_GET['idUsuario'];
					$nombre = $_GET['nombre'];
					$correo = $_GET['correo'];
					

					if ($datosRegFuncion = UpdateUsuario($mysqli2, $idUsuario, $nombre, $correo)) {
						$response['result'] = true;
						$response['mensaje'] = 'datos devueltos';
						$response['datos'] = $datosRegFuncion;
					}else{
						$response['mensaje'] = 'No es posible realizar actualizacion de Usuario.';
					}
				}

				if ($_GET['action'] == 'InsertActividad') {
					$idTema = (int) $_GET['idTema'];
					$idTipoActividad = (int) $_GET['idTipoActividad'];
					$idUsuario = (int) $_GET['idUsuario'];
					$fecha_inicio = $_GET['fecha_inicio'];
					$descripcion = $_GET['descripcion'];
					$estado = $_GET['estado'];
					$otroscorreos = $_GET['otroscorreos'];

					//Mandamos a llamar a la funcion que selecciona los datos de la DB
					if ($datosRegFuncion = InsertActividad($mysqli2, $idTema, $idTipoActividad, $idUsuario, $fecha_inicio, $descripcion, $estado, $otroscorreos)) {
					
						$response['result'] = true;
						$response['mensaje'] = 'Datos devueltos';
						$response['datos'] = $datosRegFuncion;

					}else{
						$response['mensaje'] = 'No se pudo realizar InsertActividad';
					}
				}

				if ($_GET['action'] == 'SelectActividades') {
					
					$noActividad = $_GET['noActividad'];
					$estado = $_GET['estado'];
					$tema = $_GET['tema'];
					$tipoAct = $_GET['tipoAct'];
					$fechaIni = $_GET['fechaIni'];
					$fechaFin = $_GET['fechaFin'];
				 	
					if ($datosRegFuncion = SelectActividades($mysqli2, $noActividad, $estado, $tema, $tipoAct, $fechaIni, $fechaFin)) {
						$response['result'] = true;
						$response['mensaje'] = 'Datos devueltos';
						$response['datos'] = $datosRegFuncion;
						
					}else{
						$response['mensaje'] = 'No es posible realizar consulta SelectActividades';
					}
				}

				if ($_GET['action'] == 'SelectActividad') {
					$idActividad = (int) $_GET['idActividad'];
				 	
					if ($datosRegFuncion = SelectActividad($mysqli2, $idActividad)) {
						$response['result'] = true;
						$response['mensaje'] = 'Datos devueltos';
						$response['datos'] = $datosRegFuncion;
						
					}else{
						$response['mensaje'] = 'No es posible realizar consulta SelectActividad';
					}
				}

				if ($_GET['action'] == 'UpdateActividad') {
					$idActividad = (int) $_GET['idActividad'];
					$idTema = (int) $_GET['idTema'];
					$idTipoActividad = (int) $_GET['idTipoActividad'];
					$idUsuario = (int) $_GET['idUsuario'];
					$fecha_inicio = $_GET['fecha_inicio'];
					$descripcion = $_GET['descripcion'];
					$estado = $_GET['estado'];
					$otroscorreos = $_GET['otroscorreos'];

					if ($datosRegFuncion = UpdateActividad($mysqli2, $idTema, $idTipoActividad, $idUsuario, $fecha_inicio, $descripcion, $idActividad, $estado, $otroscorreos)) {
						$response['result'] = true;
						$response['mensaje'] = 'datos devueltos';
						$response['datos'] = $datosRegFuncion;
					}else{
						$response['mensaje'] = 'No es posible realizar actualizacion de Tema.';
					}
				}

				if ($_GET['action'] == 'SelectCorreo') {
					
					$idUsuario = (int) $_GET['idUsuario'];
					
					if ($datosRegFuncion = SelectCorreo($mysqli2, $idUsuario)) {
						$response['result'] = true;
						$response['mensaje'] = 'datos devueltos';
						$response['datos'] = $datosRegFuncion;
					}else{
						$response['mensaje'] = 'No es posible realizar consulta de correo.';
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
			'mensaje' 	=> "No fue posible ejecutar la peticion para Defensa Comercial",
			'datos'		=> ""
		);

		//Incluimos la conexcion a la base de datos
		include('../connection.php');
		include('../defensa/defensa.php');

		//conexion con la base de datos
		if ($errorDbConexion) {

			if (isset($_POST['action'])) {

				

				if ($_POST['action'] == 'UpdateGrupo') {
					$idGrupo = (int) $_POST['idGrupo'];
					$nombreGrupo = $_POST['nombreGrupo'];
					
					

					if ($datosRegFuncion = UpdateGrupo($mysqli2, $idGrupo, $nombreGrupo)) {
						$response['result'] = true;
						$response['mensaje'] = 'Datos Devueltos';
						$response['datos'] = $datosRegFuncion;
					}else{
						$response['mensaje'] = 'No es posible realizar actualizacion del evento.';
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