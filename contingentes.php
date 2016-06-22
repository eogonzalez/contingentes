<?php
	
	function getListaTratados($dbLink){
		
		$response = array();

		//Query que consulta tratados
		$sql = 'SELECT * FROM tratados';

		// Ejecutamos la consulta
		$result = $dbLink->query($sql);

		if ($result -> num_rows != 0) {
			while ($registro = $result -> fetch_array()) {
				$response [] = $registro;
			}
		}

		return $response;
	}

	function getListaContingentes($dbLink,$idTratado){
		$response = array();

		$sql = sprintf(" SELECT idContingente, nombreContingente 
			FROM contingentes 
			WHERE idTratado=%d",$idTratado);		

		$result = $dbLink->query($sql);

		if ($result->num_rows != 0) {

			while ($registro = $result->fetch_array()) {
				$response [] = $registro;
			}
		}

		return $response;
	}

	function getListaPeriodo($dbLink){
		$response = array();

		$sql = 'SELECT * FROM periodos';

		$result =$dbLink->query($sql);

		if ($result->num_rows != 0) {
				while ($registro = $result->fetch_array()) {
					$response [] = $registro;
				}
		}

		return $response;
	}


	function getDatosTablero($dbLink, $idTratado, $idPeriodo, $idContingente){
		$response = array();



		//Valido si se reciben parametros para ejecutar querys
		if ($idTratado != 0 ) {

				$sql = sprintf("SELECT 
									mes, sum(vActivado) as vActivado, sum(vAsignado) as vAsignado,
									sum(vEmetido) as vEmitido, sum(pUtilizado)/6 as pUtilizado
								FROM
									tablerocontingentes
								WHERE
									idPeriodo = %d and
									idTratado = %d and
									idContingente = %d
								group by idMes ", $idPeriodo, $idTratado, $idContingente);


		}else{
				$sql = 'SELECT
							mes, sum(vActivado) as vActivado, sum(vAsignado) as vAsignado,
							sum(vEmetido) as vEmitido, sum(pUtilizado)/6 as pUtilizado
						FROM
							tablerocontingentes
						group by idMes';
		}

		$result = $dbLink->query($sql);

		if ($result->num_rows != 0) {
			while ($registro = $result->fetch_array()) {
				$response [] = $registro;
			}
		}

		return $response;
	}


	function getDatosControles($dbLink, $idTratado, $idContingente, $idPeriodo){
		$respuesta = array();

		$sql = sprintf("SELECT 
							sum(vActivado) as vActivado, sum(vAsignado) as vAsignado,
							sum(vEmetido) as vEmitido, ROUND(sum(pUtilizado)/6,2) as pUtilizado,
							sum(cantNuevasAsignaciones) as cNuevasAsigna, sum(TotalAsignadas) as cTotAsigna,
							sum(nuevasInscripciones) as nInscrip, sum(totalInscripciones) as cTotIncrip
						FROM
							tablerocontingentes
						WHERE
							idPeriodo = %d and
							idTratado = %d and
							idContingente = %d ", $idPeriodo, $idTratado, $idContingente);

		$result = $dbLink->query($sql);

		if ($result->num_rows != 0) {
			while ($registro = $result->fetch_array()) {
				$respuesta [] = $registro;
			}
		}

		return $respuesta;
	}

	function getDatosReporte($dbLink, $idTratado, $idContingente, $idPeriodo){
		$respuesta = array();

		$sql = sprintf("SELECT 
							mes, vActivado, vAsignado, vEmetido, pUtilizado
						FROM 
							tablerocontingentes
						WHERE
							idPeriodo = %d and
							idTratado = %d and
							idContingente = %d ", $idPeriodo, $idTratado, $idContingente);

		$resultado = $dbLink->query($sql);

		if ($resultado->num_rows != 0) {
			while ($registro = $resultado->fetch_array()) {
				$respuesta [] = $registro;
			}
		}

		return $respuesta;
	}

?>