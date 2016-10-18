<?php
	
	/*
		Funcion para obtener el listado de tratados
	*/
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

	/*
		Funcion para obtener los contingentes segun el tratado seleccionado
	*/
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

	/*
		Funcion que obtiene los periodos existentes 
	*/
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

	/*
		Funcion que obtiene informacion de resumen del contingente
	*/
	function getEstadoContingente($dbLink, $idTratado, $idContingente){
		$response = array();

		if ($idTratado == 0) {
			//Si la consulta se realiza en el load de la pagina
			//Id tratado viene 0


			//Query que obtiene informacion sobre los motos totales emitidos por mes
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

		}else{
			//Si la consulta se realiza mendiante el boton de consulta

			//Query que obtiene informacion sobre los montos totales emitidos por mes y  contingente
			$PrimerQuery = array();
			$SegundoQuery = array();


			$sql = sprintf(" SELECT * from 
								(SELECT
									sum(emitido) AS totalEmitido, month(se.created_at) AS mes
								FROM
									solicitudesemision se
								JOIN
									periodos p ON
									se.periodoid = p.periodoid
								WHERE
									year(p.fechainicio) = '2016'
									and se.estado = 'Aprobada'
								group by mes) t1, 
								(SELECT 
									m.cantidad as vActivado
								FROM 
									movimientos m
								JOIN 
									periodos p on
									p.periodoid = m.periodoid
								JOIN contingentes c on
									c.contingenteid = p.contingenteid
								WHERE 
									year(p.fechainicio) = 2016
								and m.tipomovimientoid = 1
								and c.tratadoid = %d 
								and c.productoid = %d
							) t2 ", $idTratado, $idContingente)	;

			$result = $dbLink->query($sql);

			

			if ($result->num_rows != 0){
				while ($registro = $result->fetch_array()) {
					

					$PrimerQuery [] = $registro;
				}
			}


			$sql = sprintf("SELECT 
								sum(se.emitido) as vEmitido, month(se.created_at) AS mes
							FROM 
								solicitudesemision se
							JOIN 
								periodos p on
								se.periodoid = p.periodoid
							JOIN 
								contingentes c on
								p.contingenteid = c.contingenteid
							JOIN 
								productos pro on
								pro.productoid = c.productoid
							WHERE
								se.estado = 'Aprobada'
								and year(se.created_at) = 2016
								and c.tratadoid = %d
								and c.productoid = %d
							group by mes", $idTratado, $idContingente);

			$result2 = $dbLink->query($sql);


			if ($result2->num_rows != 0){
				while ($registro = $result2->fetch_array()) {
					$SegundoQuery [] = $registro;
				}
			}





			//$response = array_merge($PrimerQuery, $SegundoQuery);

			$miArreglo = array(
				'mes' => 0 ,
				'totalEmitido' => 0.00,
				'vActivado' => 0.00,
				'vEmitido' => 0.00);

			foreach ($PrimerQuery as $fila => $mes) {
				
				
				//$MiContingente = new cEstadoContingente();
				$miArreglo['mes'] = $mes['mes'];
				$miArreglo['totalEmitido'] = $mes['totalEmitido'];
				$miArreglo['vActivado'] = $mes['vActivado'];

				foreach ($SegundoQuery as $fila2 => $mes2) {
		

					if ($fila == $fila2) {
						//Agrego valor al arreglo						
						$miArreglo['vEmitido'] = $mes2['vEmitido'];				
						break;

					}else{
						//Agrego valor igual a cero						
						$miArreglo['vEmitido'] = 0.00;				
					}

				}

				$response[] = $miArreglo;

			}	

		}

		return $response;
	}


	/*
		Funcion que obtiene datos para la ficha del contingente
	*/
	function getDatosControles($dbLink, $idTratado, $idContingente, $idPeriodo){
		$respuesta = array();

		$sql = sprintf("SELECT 
							* , (t2.vAsignado-t1.vEmitido) as vSaldo, round((t1.vEmitido/t3.vActivado)*100, 2) as pUtilizado from
						(SELECT 
							sum(se.emitido) as vEmitido, count(se.solicitudemisionid) as cantNuevasAsigaciones, count(distinct se.usuarioid) as cantEmpresas
						from 
							solicitudesemision se
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
						(SELECT 
							sum(sa.asignado) as vAsignado, count(sa.solicitudasignacionid) as cantAsignaciones
						from 
							solicitudasignacion sa
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
						(SELECT 
							m.cantidad as vActivado
						from 
							movimientos m
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

	/*
		Funcion que obtiene datos para llenar grafica de pie x tratado
	*/
	function getDatosPieTratado($dbLink, $idPeriodo, $idTratado){
		$respuesta = array();

		$sql = sprintf("SELECT t1.productoid, t1.nombre,  sum(case when t2.emitido is null then 0.00 else t2.emitido end) as vEmitido
						FROM
						(SELECT
							c.contingenteid, c.tratadoid, c.productoid, p.nombre, pe.fechainicio
						FROM
							contingentes c
						join
							productos p on
							c.productoid = p.productoid
						right join 
							periodos pe on
							pe.contingenteid = c.contingenteid
						where
							year(pe.fechainicio) = %d
						and c.tratadoid = %d) t1
						left join 
						(select
							c.contingenteid, c.tratadoid, c.productoid, p.nombre, pe.fechainicio, sum(case when se.emitido is NULL then 0.00 else se.emitido end) as emitido
						from
							contingentes c
						join
							productos p on
							c.productoid = p.productoid
						right join 
							periodos pe on
							pe.contingenteid = c.contingenteid
						right join
							solicitudesemision se on
							se.periodoid = pe.periodoid
						where
							se.estado = 'Aprobada'
							and year(pe.fechainicio) = %d
							and c.tratadoid = %d
						group by c.productoid) t2 on
							t1.productoid = t2.productoid
						group by t1.productoid
						order by t1.productoid", $idPeriodo, $idTratado, $idPeriodo, $idTratado);

		$resultado = $dbLink->query($sql);

		if ($resultado->num_rows != 0) {
			while ($registro = $resultado->fetch_array()) {
				$respuesta [] = $registro;
			}
		}

		return $respuesta;
	}

	/*
		Funcion que obtiene el top 5 de los contingentes

		**Mostrar los 5 contingentes mas utilizados (Volumen emitido)
		**Mostrar a que tratado pertenece cada contingente
		**Filtrar por periodo y tipo
	*/
	function getTopContingentes($dbLink, $idPeriodo, $tipoTLC){
		$respuesta = array();

		$tipo = '';

		if ($tipoTLC == 1) {
			$tipo = 'Importación';
		}elseif ($tipoTLC == 2) {
			$tipo = 'Exportación';
		}


		$sql = sprintf("SELECT
						c.tratadoid,t.nombre as tlcNombre, t.nombrecorto as tlcNombreCorto, c.productoid, p.nombre as pNombre, 
						sum(case when se.emitido is NULL then 0.00 else se.emitido end) as vemitido
						from
							contingentes c
						join
							productos p on
							c.productoid = p.productoid
						join
							tratados t on
							t.tratadoid = c.tratadoid
						right join 
							periodos pe on
							pe.contingenteid = c.contingenteid
						right join
							solicitudesemision se on
							se.periodoid = pe.periodoid
						where
							se.estado = 'Aprobada'
							and t.tipo = '%s'
							and year(pe.fechainicio) = %d
						group by c.productoid
						order by vemitido desc
						limit 5",  $tipo, $idPeriodo);

		$resultado = $dbLink->query($sql);


		if ($resultado->num_rows != 0) {
			while ($registro = $resultado->fetch_array()) {
				$respuesta [] = $registro;
			}
		}

		return $respuesta;
	}


	/*
		Funcion que obtiene el top 5 de empresas que mas contingentes utilizan

		**Mostrar las 5 empresas que mas volumen emitido utilizan
		**filtrar por periodo y tipo de tratado
	*/
	function getTopEmpresas($dbLink, $idPeriodo, $tipoTLC){

		$respuesta = array();

		$tipo = '';

		if ($tipoTLC == 1) {
			$tipo = 'Importación';
		}elseif ($tipoTLC == 2) {
			$tipo = 'Exportación';
		}

		$sql = sprintf("SELECT
							c.tratadoid, t.nombrecorto as tlcNombreCorto, se.usuarioid, a.nombre,
							sum(case when se.emitido is NULL then 0.00 else se.emitido end) as vemitido
						FROM
							contingentes c
						join
							productos p on
							c.productoid = p.productoid
						join
							tratados t on
							t.tratadoid = c.tratadoid
						right join 
							periodos pe on
							pe.contingenteid = c.contingenteid
						right join
							solicitudesemision se on
							se.periodoid = pe.periodoid
						join
							authusuarios a on
							a.usuarioid = se.usuarioid
						where
							se.estado = 'Aprobada'
							and t.tipo = '%s'
							and year(pe.fechainicio) = %d
						group by se.usuarioid
						order by vemitido desc
						limit 5", $tipo, $idPeriodo);


		$resultado = $dbLink->query($sql);


		if ($resultado->num_rows != 0) {
			while ($registro = $resultado->fetch_array()) {
				$respuesta [] = $registro;
			}
		}

		return $respuesta;
	}


	function getEmpresas($dbLink, $idPeriodo, $idTratado, $idContingente){
		$respuesta = array();

		$sql = sprintf(" SELECT 
					sum(se.emitido) as vEmitido, a.nombre
				FROM 
					solicitudesemision se
				LEFT JOIN authusuarios a on
					se.usuarioid = a.usuarioid
				JOIN periodos p on
					se.periodoid = p.periodoid
				JOIN contingentes c on
					p.contingenteid = c.contingenteid
				JOIN productos pro on
					pro.productoid = c.productoid
				WHERE
					se.estado = 'Aprobada'
					and year(se.created_at) = %d
					and c.tratadoid = %d
					and c.productoid = %d
				group by se.usuarioid 
				order by vEmitido desc ", $idPeriodo, $idTratado, $idContingente);

		$resultado = $dbLink->query($sql);

		if ($resultado->num_rows != 0) {
			while ($registro = $resultado->fetch_array()) {
				$respuesta [] = $registro;
			}
		}

		return $respuesta;
	}

	function getCertificados($dbLink, $idPeriodo, $idTratado, $idContingente){
		$respuesta = array();

		$sql = sprintf("SELECT 
							sum(se.emitido) as vEmitido, se.solicitudemisionid, se.usuarioid, se.created_at
						from 
							solicitudesemision se
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
							and c.productoid = %d
						group by se.solicitudemisionid
						order by se.created_at desc", $idPeriodo, $idTratado, $idContingente);

		$resultado = $dbLink->query($sql);

		if ($resultado->num_rows != 0) {
			while ($registro = $resultado->fetch_array()) {
				$respuesta [] = $registro; 
			}
		}

		return $respuesta;
	}

	function getInscripciones($dbLink, $idPeriodo, $estado, $noExp){
		$respuesta = array();

		if ($estado == 'Todos') {
			if ($noExp == 0) {

				$sql = sprintf("SELECT 
					solicitudinscripcionid as numeroexpediente, 
					created_at as fecha_solicitud, 
					estado, 
					updated_at as fecha_aprobacion
				FROM
					solicitudinscripciones
				WHERE
					year(created_at) = %d 
				ORDER BY numeroexpediente DESC ", $idPeriodo);
				
			}else{
				$sql = sprintf("SELECT 
						solicitudinscripcionid as numeroexpediente, 
						created_at as fecha_solicitud, 
						estado, 
						updated_at as fecha_aprobacion
					FROM
						solicitudinscripciones
					WHERE
						year(created_at) = %d
						and solicitudinscripcionid = %d 
					ORDER BY numeroexpediente DESC ", $idPeriodo, $noExp);	
			}
			
		}else{
			if ($noExp == 0) {

				$sql = sprintf("SELECT 
						solicitudinscripcionid as numeroexpediente, 
						created_at as fecha_solicitud, 
						estado, 
						updated_at as fecha_aprobacion
					FROM
						solicitudinscripciones
					WHERE
						year(created_at) = %d
						and estado = '%s' 
					ORDER BY numeroexpediente DESC ", $idPeriodo, $estado);
			}else{

				$sql = sprintf("SELECT 
						solicitudinscripcionid as numeroexpediente, 
						created_at as fecha_solicitud, 
						estado, 
						updated_at as fecha_aprobacion
					FROM
						solicitudinscripciones
					WHERE
						year(created_at) = %d
						and estado = '%s'
						and solicitudinscripcionid = %d 
					ORDER BY numeroexpediente DESC ", $idPeriodo, $estado, $noExp);	
			}
			
		}


		$resultado = $dbLink->query($sql);

		if ($resultado->num_rows != 0) {
			while ($registro = $resultado->fetch_array()) {
				$respuesta [] = $registro;
			}
		}

		return $respuesta;
	}

	function getAsignaciones($dbLink, $idPeriodo, $estado, $noExp){
		$respuesta = array();

		if ($estado == 'Todos') {
			if ($noExp == 0) {

				$sql = sprintf(" SELECT
									solicitudasignacionid as numeroexpediente,
									created_At as fecha_solicitud,
									estado,
									updated_at as fecha_aprobacion,
									observaciones,
									acta
								FROM
									solicitudasignacion
								WHERE
									year(created_at) = %d
								ORDER BY numeroexpediente DESC ", $idPeriodo);
				
			}else{
				$sql = sprintf(" SELECT 
									solicitudasignacionid as numeroexpediente,
									created_At as fecha_solicitud,
									estado,
									updated_at as fecha_aprobacion,
									observaciones,
									acta
								FROM
									solicitudasignacion
								WHERE 
									year(created_at) = '%d'
									AND solicitudasignacionid = %d									
								ORDER BY numeroexpediente DESC;", $idPeriodo, $noExp);	
			}
			
		}else{
			if ($noExp == 0) {

				$sql = sprintf("SELECT 
									solicitudasignacionid as numeroexpediente,
									created_At as fecha_solicitud,
									estado,
									updated_at as fecha_aprobacion,
									observaciones,
									acta
								FROM
									solicitudasignacion
								WHERE
									year(created_at) = '%d'
									AND estado = '%s'
								ORDER BY numeroexpediente DESC;", $idPeriodo, $estado);
			}else{

				$sql = sprintf("SELECT 
									solicitudasignacionid as numeroexpediente,
									created_At as fecha_solicitud,
									estado,
									updated_at as fecha_aprobacion,
									observaciones,
									acta
								FROM
									solicitudasignacion
								WHERE
									year(created_at) = '%d'
									AND estado = '%s'
									AND solicitudasignacionid = %d									
								ORDER BY numeroexpediente DESC;", $idPeriodo, $estado, $noExp);	
			}
			
		}


		$resultado = $dbLink->query($sql);

		if ($resultado->num_rows != 0) {
			while ($registro = $resultado->fetch_array()) {
				$respuesta [] = $registro;
			}
		}

		return $respuesta;
	}

	function getEmisiones($dbLink, $idPeriodo, $estado, $noExp){
		$respuesta = array();

		if ($estado == 'Todos') {
			if ($noExp == 0) {

				$sql = sprintf("SELECT 
									solicitudemisionid as numeroexpediente,
									created_at as fecha_solicitud,
									estado,
									created_at as fecha_aprobacion,
									observaciones
								FROM
									solicitudesemision
								WHERE
									year(created_at) = %d									
								ORDER BY numeroexpediente DESC", $idPeriodo);
				
			}else{
				$sql = sprintf("SELECT 
									solicitudemisionid as numeroexpediente,
									created_at as fecha_solicitud,
									estado,
									created_at as fecha_aprobacion,
									observaciones
								FROM
									solicitudesemision
								WHERE
									year(created_at) = %d
									AND solicitudemisionid = %d									
								ORDER BY numeroexpediente DESC;", $idPeriodo, $noExp);	
			}
			
		}else{
			if ($noExp == 0) {

				$sql = sprintf("SELECT 
									solicitudemisionid as numeroexpediente,
									created_at as fecha_solicitud,
									estado,
									created_at as fecha_aprobacion,
									observaciones
								FROM
									solicitudesemision
								WHERE
									year(created_at) = $d									
									AND estado = '%s'
								ORDER BY numeroexpediente DESC;", $idPeriodo, $estado);
			}else{

				$sql = sprintf("SELECT 
									solicitudemisionid as numeroexpediente,
									created_at as fecha_solicitud,
									estado,
									created_at as fecha_aprobacion,
									observaciones
								FROM
									solicitudesemision
								WHERE
									year(created_at) = %d
									AND estado = '%s'
									AND solicitudemisionid = %d
								order by numeroexpediente DESC;", $idPeriodo, $estado, $noExp);	
			}
			
		}


		$resultado = $dbLink->query($sql);

		if ($resultado->num_rows != 0) {
			while ($registro = $resultado->fetch_array()) {
				$respuesta [] = $registro;
			}
		}

		return $respuesta;
	}
?>