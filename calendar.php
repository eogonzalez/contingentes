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
		$response[] = true;
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