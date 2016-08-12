<?php
	date_default_timezone_set('Etc/UTC');

	require '/PHPMailer-master/PHPMailerAutoload.php';
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

function InsertEventoCalendario($dbLink, $nombre, $fecha_inicia, $color){


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
					(nombre, color, fecha_inicia, fecha_finaliza, todoeldia, estado, 
					fecha_creacion, fecha_actualizacion)
					VALUES
					('%s', '%s', '%s', '%s', 
					'%s', '%s', '%s', '%s')", $nombre, $color, $fecha_inicia, $fecha_inicia, 'S', 'P', $fecha_actual, $fecha_actual);

	$result = $dbLink->query($sql);


	if ($result == true) {
		
		$response =$dbLink->insert_id;
	}else{
		$response[] = $sql;
		$response[] = $dbLink->error;
	}

	$dbLink->close();

	return $response;
}


/*
	Funcion que obtiene los eventos para pintarlos en el calendario
*/

function SelectEventosCalendario($dbLink){
	$response = array();

	$sql = 'SELECT idevento, nombre, color, fecha_inicia, fecha_finaliza, todoeldia
			FROM EVENTOS' ;

	$result = $dbLink->query($sql);

	if ($result->num_rows != 0) {

		while ($registro = $result->fetch_array()) {
			$response [] = $registro;
		}
	}

	return $response;
}

/*
	Funcion que actualiza el evento al momento de moverlo o cambiar la hora dentro del calendario
*/

function UpdateEventoCalendario($dbLink, $idevento, $todoeldia, $fecha_inicia, $fecha_finaliza){
	$response = array();
	$dia = (string) date("d");
	$mes = (string) date("m");
	$anio = (string) date("Y");

	$fecha_actual = $anio."-".$mes."-".$dia;


	$sql = sprintf("UPDATE 
						eventos
					SET
						todoeldia = '%s',
						fecha_inicia = '%s',
						fecha_finaliza = '%s',
						fecha_actualizacion = '%s'
					WHERE idevento = %d ", $todoeldia, $fecha_inicia, $fecha_finaliza, $fecha_actual, $idevento);

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
	Funcion que selecciona los datos del evento para llenar el formulario de edicion
*/

function SelectEvento($dbLink, $idevento){
	$response = array();

	$sql = sprintf('SELECT nombre, color, fecha_inicia, fecha_finaliza, todoeldia, lugar,
					descripcion, adjunto, idgrupo, otroscorreos, estado
					FROM EVENTOS
					where 
					idevento = %d', $idevento);

	$result = $dbLink->query($sql);

	if ($result->num_rows != 0) {
		while ($registro = $result->fetch_array()) {
			$response [] = $registro;
		}
	}

	return $response;
}

/*
	Funcion que actualiza la informacion del evento del formulario
*/

function UpdateEventoFormulario($dbLink, $idevento, $nombre, $todoeldia, $fecha_inicia, $fecha_finaliza, $color, $lugar, $descripcion, $adjunto, $idgrupo, $otroscorreos, $estado){

	$response = array();
	$dia = (string) date("d");
	$mes = (string) date("m");
	$anio = (string) date("Y");

	$fecha_actual = $anio."-".$mes."-".$dia;

	$sql = sprintf("UPDATE 
						eventos
					SET
						nombre = '%s',
						todoeldia = '%s',
						fecha_inicia = '%s',
						fecha_finaliza = '%s',
						color = '%s',
						lugar = '%s',
						descripcion = '%s',
						adjunto = '%s',
						idgrupo = '%s',
						otroscorreos = '%s',
						estado = '%s',
						fecha_actualizacion = '%s'
					WHERE idevento = %d ", $nombre, $todoeldia, $fecha_inicia, $fecha_finaliza, $color, $lugar, $descripcion, $adjunto, $idgrupo, $otroscorreos, $estado, $fecha_actual, $idevento);

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

function SendEmail($para, $nombre, $asunto, $descripcion){

	//Creacion de instancia de PHPMailer
	$mail = new PHPMailer;

	//Utilizar SMTP
	$mail->isSMTP();

	//Habilitar SMTP debugging
	// 0 = off (for production use)
	// 1 = client messages
	// 2 = client and server messages

	$mail->SMTPDebug = 2;

	$mail->Debugoutput = 'html';
	$mail->Host = 'smtp.gmail.com';

	//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
	$mail->Port = 587;
	//Set the encryption system to use - ssl (deprecated) or tls
	$mail->SMTPSecure = 'tls';

	//Whether to use SMTP authentication
	$mail->SMTPAuth = true;

	//Username to use for SMTP authentication - use full email address for gmail
	$mail->Username = "alertas.dace@gmail.com";
	
	//Password to use for SMTP authentication
	$mail->Password = "DACE87654321";

	//Set who the message is to be sent from
	$mail->setFrom('alertas.dace@gmail.com', 'Alertas DACE');

	//Set an alternative reply-to address
	//$mail->addReplyTo('replyto@example.com', 'First Last');

	//Set who the message is to be sent to
	$mail->addAddress($para, $nombre);
	//Set the subject line
	$mail->Subject = $asunto;

	//Read an HTML message body from an external file, convert referenced images to embedded,
	//convert HTML into a basic plain-text alternative body
	$mail->msgHTML($descripcion);

	//Replace the plain text body with one created manually
	$mail->AltBody = 'This is a plain-text message body';

	//Attach an image file
	//$mail->addAttachment('images/phpmailer_mini.png');

	//send the message, check for errors
	if (!$mail->send()) {
	    echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
	    echo "Message sent!";
	}
}

function InsertGrupo($dbLink, $nombreGrupo){

	$response = array();

	$dia = (string) date("d");
	$mes = (string) date("m");
	$anio = (string) date("Y");

	$fecha_actual = $anio."-".$mes."-".$dia;

	//Query que consulta tratados
	$sql = sprintf("INSERT INTO grupos
					(nombre, estado, fecha_creacion, fecha_actualizacion)
					VALUES
					('%s','%s','%s','%s')", $nombreGrupo, 'A', $fecha_actual, $fecha_actual);


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

function SelectGrupos($dbLink){

	$response = array();

	$sql = 'SELECT idGrupo, nombre, estado
			FROM grupos' ;

	$result = $dbLink->query($sql);

	if ($result->num_rows != 0) {

		while ($registro = $result->fetch_array()) {
			$response [] = $registro;
		}
	}

	return $response;
}

function SelectGrupo($dbLink, $idGrupo){

	$response = array();

	$sql = sprintf('SELECT nombre, estado
			FROM grupos
			WHERE idGrupo = %d', $idGrupo);

	$result = $dbLink->query($sql);

	if ($result->num_rows != 0) {

		while ($registro = $result->fetch_array()) {
			$response [] = $registro;
		}
	}

	return $response;
}

function UpdateGrupo($dbLink, $idGrupo, $nombreGrupo){
	$response = array();

	$dia = (string) date("d");
	$mes = (string) date("m");
	$anio = (string) date("Y");

	$fecha_actual = $anio."-".$mes."-".$dia;



	$sql = sprintf("UPDATE 
						grupos
					SET
						nombre = '%s',
						fecha_actualizacion = '%s'
					WHERE
						idGrupo = %d", $nombreGrupo, $fecha_actual, $idGrupo)	;


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

function SelectContactos($dbLink){

	$response = array();

	$sql = 'SELECT idContacto, nombre, correo, estado
			FROM contactos' ;

	$result = $dbLink->query($sql);

	if ($result->num_rows != 0) {

		while ($registro = $result->fetch_array()) {
			$response [] = $registro;
		}
	}

	return $response;
}

function InsertContacto($dbLink, $nombreContacto, $correoContacto, $telefonoContacto, $organizacionContacto){

	$response = array();

	$dia = (string) date("d");
	$mes = (string) date("m");
	$anio = (string) date("Y");

	$fecha_actual = $anio."-".$mes."-".$dia;

	//Query que consulta tratados
	$sql = sprintf("INSERT INTO contactos
					(nombre, correo, cel, organizacion, estado, fecha_creacion, fecha_actualizacion)
					VALUES
					('%s','%s','%s','%s','%s','%s','%s')", $nombreContacto, $correoContacto, $telefonoContacto, $organizacionContacto, 'A', $fecha_actual, $fecha_actual);


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

function SelectContacto($dbLink, $idContacto){

	$response = array();

	$sql = sprintf('SELECT nombre, correo, cel, organizacion, estado
			FROM contactos
			WHERE idContacto = %d', $idContacto);

	$result = $dbLink->query($sql);

	if ($result->num_rows != 0) {

		while ($registro = $result->fetch_array()) {
			$response [] = $registro;
		}
	}

	return $response;
}


function UpdateContacto($dbLink, $idContacto, $nombreContacto, $correoContacto, $telefonoContacto, $organizacion){
	$response = array();

	$dia = (string) date("d");
	$mes = (string) date("m");
	$anio = (string) date("Y");

	$fecha_actual = $anio."-".$mes."-".$dia;



	$sql = sprintf("UPDATE 
						contactos
					SET
						nombre = '%s',
						correo = '%s',
						cel = '%s',
						organizacion = '%s',
						fecha_actualizacion = '%s'
					WHERE
						idContacto = %d", $nombreContacto, $correoContacto, $telefonoContacto, $organizacion, $fecha_actual, $idContacto)	;


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


function SelectContactosGrupos($dbLink){

	$response = array();

	$sql = 'SELECT
				g.idcontacto_grupo , g.idcontacto, c.nombre as nombreContacto, g.idgrupo, gr.nombre as nombreGrupo
			from 
				contacto_grupo g
			join
				contactos c on
				g.idContacto = c.idContacto
			join
				grupos gr on
				g.idGrupo = gr.idGrupo';

	$result = $dbLink->query($sql);

	if ($result->num_rows != 0) {

		while ($registro = $result->fetch_array()) {
			$response [] = $registro;
		}
	}

	return $response;
}

function getListaGrupos($dbLink){
	
	$response = array();

	//Query que consulta tratados
	$sql = 'SELECT 
				idGrupo, nombre
			FROM 
				grupos';

	// Ejecutamos la consulta
	$result = $dbLink->query($sql);

	if ($result -> num_rows != 0) {
		while ($registro = $result -> fetch_array()) {
			$response [] = $registro;
		}
	}

	return $response;
}

function getListaContactos($dbLink){
	
	$response = array();

	//Query que consulta tratados
	$sql = 'SELECT 
				idContacto, nombre
			FROM 
				contactos';

	// Ejecutamos la consulta
	$result = $dbLink->query($sql);

	if ($result -> num_rows != 0) {
		while ($registro = $result -> fetch_array()) {
			$response [] = $registro;
		}
	}

	return $response;
}

function InsertContactoGrupo($dbLink, $idGrupo, $idContacto){
	$response = array();

	$dia = (string) date("d");
	$mes = (string) date("m");
	$anio = (string) date("Y");

	$fecha_actual = $anio."-".$mes."-".$dia;

	//Query que consulta tratados
	$sql = sprintf("INSERT INTO contacto_grupo
					(idGrupo, idContacto, fecha_creacion, fecha_actualizacion)
					VALUES
					(%d,%d,'%s','%s')", $idGrupo, $idContacto, $fecha_actual, $fecha_actual);


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

function UpdateContactoGrupo($dbLink, $idGrupoContacto, $idGrupo, $idContacto){
	$response = array();

	$dia = (string) date("d");
	$mes = (string) date("m");
	$anio = (string) date("Y");

	$fecha_actual = $anio."-".$mes."-".$dia;



	$sql = sprintf("UPDATE 
						contacto_grupo
					SET
						idGrupo = %d,
						idContacto = %d,
						fecha_actualizacion = '%s'
					WHERE
						idcontacto_grupo = %d", $idGrupo, $idContacto, $fecha_actual, $idGrupoContacto)	;


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

function SelectContactoGrupo($dbLink, $idContactoGrupo){

	$response = array();

	$sql = sprintf('SELECT
				g.idcontacto, g.idgrupo
			from 
				contacto_grupo g
			WHERE
				g.idcontacto_grupo = %d', $idContactoGrupo);

	$result = $dbLink->query($sql);

	if ($result->num_rows != 0) {

		while ($registro = $result->fetch_array()) {
			$response [] = $registro;
		}
	}

	return $response;
}


/*
select
a.*, b.nombre, b.email
from
(
select
e.empresaid, p.productoid
from 
empresacontingentes e
join
contingentes c on
c.contingenteid = e.contingenteid
join
productos p on
c.productoid = p.productoid
where
c.tratadoid = 1
and c.productoid = 1) a
join
authusuarios b on
a.empresaid = b.empresaid
*/

?>