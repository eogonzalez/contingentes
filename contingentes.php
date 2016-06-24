<?php
	
	function getListaTratados($dbLink){
		
		$response = array();

		//Query que consulta tratados
		$sql = 'SELECT 
					tratadoid, nombre
				FROM 
					tratados';

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

		/*$sql = sprintf(" SELECT idContingente, nombreContingente 
			FROM contingentes 
			WHERE idTratado=%d",$idTratado);*/

		$sql = sprintf("SELECT
							p.productoid, p.nombre
						FROM
							contingentes c
						JOIN
							productos p on
							c.productoid = p.productoid
						WHERE
							c.tratadoid = %d
						ORDER BY  c.productoid", $idTratado);		

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

		$sql = 'SELECT
					year(fechainicio) as idanio, year(fechainicio) as periodo
				FROM
					periodos
				GROUP BY idanio';

		$result =$dbLink->query($sql);

		if ($result->num_rows != 0) {
				while ($registro = $result->fetch_array()) {
					$response [] = $registro;
				}
		}

		return $response;
	}

	function getEstadoContingente($dbLink){
		$response = array();

		$sql = sprintf("SELECT
							sum(emitido) AS emitido, month(se.created_at) AS mes
						FROM
							solicitudesemision se
						JOIN
							periodos p ON
							se.periodoid = p.periodoid
						WHERE
							year(p.fechainicio) = '2016'
							and se.estado = 'Aprobada'
						group by mes");

		$result = $dbLink->query($sql);

		if ($result->num_rows != 0){
			while ($registro = $result->fetch_array()) {
				$response [] = $registro;
			}
		}

		return $response;
	}

	/*function getDatosTablero($dbLink, $idTratado, $idPeriodo, $idContingente){
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
	}*/


	function getDatosControles($dbLink, $idTratado, $idContingente, $idPeriodo){
		$respuesta = array();

		$sql = sprintf("SELECT *, (t2.vAsignado-t1.vEmitido) as vSaldo, round((t1.vEmitido/t3.vActivado)*100, 2) as pUtilizado from
					(SELECT sum(se.emitido) as vEmitido, count(se.solicitudemisionid) as cantNuevasAsigaciones
					from solicitudesemision se
					join periodos p on
					se.periodoid = p.periodoid
					join contingentes c on
					p.contingenteid = c.contingenteid
					join productos pro on
					pro.productoid = c.productoid
					where
					se.estado = 'Aprobada'
					and year(se.created_at) = %d
					and c.tratadoid = %d
					and c.productoid = %d) t1,
					-- Total asignado x tratado y contingente en el periodo
					(SELECT sum(sa.asignado) as vAsignado, count(sa.solicitudasignacionid) as cantAsignaciones
					from solicitudasignacion sa
					join periodos p on
					sa.periodoid = p.periodoid
					join contingentes c on
					p.contingenteid = c.contingenteid
					join productos pro on
					pro.productoid = c.productoid
					where
					sa.estado = 'Aprobada'
					and year(sa.created_at) = %d
					and c.tratadoid = %d
					and c.productoid = %d) t2,
					-- Activado x trata y contingente en el periodo
					(SELECT m.cantidad as vActivado
					from movimientos m
					join periodos p on
					p.periodoid = m.periodoid
					join contingentes c on
					c.contingenteid = p.contingenteid
					where year(p.fechainicio) = %d
					and m.tipomovimientoid = 1
					and c.tratadoid = %d
					and c.productoid = %d) t3;", $idPeriodo, $idTratado, $idContingente, $idPeriodo, $idTratado, $idContingente, $idPeriodo, $idTratado, $idContingente);

		$result = $dbLink->query($sql);

		if ($result->num_rows != 0) {
			while ($registro = $result->fetch_array()) {
				$respuesta [] = $registro;
			}
		}

		return $respuesta;
	}

	/*function getDatosReporte($dbLink, $idTratado, $idContingente, $idPeriodo){
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
	}*/


	function getDatosPieTratado($dbLink, $idPeriodo, $idTratado){
		$respuesta = array();

		$sql = sprintf("SELECT 
							pro.productoid, pro.nombre, sum(se.emitido) as vEmitido
						FROM
							contingentes c
						JOIN
							productos pro on
							c.productoid = pro.productoid
						JOIN
							periodos p on
							p.contingenteid = c.contingenteid
						JOIN
							solicitudesemision se on
							p.periodoid = se.periodoid
						WHERE
							year(se.created_at) = %d
							and c.tratadoid = %d
						group by pro.productoid, pro.nombre
						ORDER BY  c.productoid", $idPeriodo, $idTratado);

		$resultado = $dbLink->query($sql);

		if ($resultado->num_rows != 0) {
			while ($registro = $resultado->fetch_array()) {
				$respuesta [] = $registro;
			}
		}

		return $respuesta;
	}

?>