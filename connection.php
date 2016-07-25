<?php
/*
function dbConnect (){
 	$conn =	null;
 	$host = 'localhost';
 	$db = 	'ejemplo';
 	$user = 'egonzalez';
 	$pwd = 	'87654321';
	try {
	   	$conn = new PDO('mysql:host='.$host.';dbname='.$db, $user, $pwd);
		//echo 'Connected succesfully.<br>';
	}
	catch (PDOException $e) {
		echo '<p>Cannot connect to database !!</p>';
	    exit;
	}
	return $conn;
 }
*/

/*
	define("server", 'localhost');
	define("user", 'egonzalez');
	define("pass", '87654321');
	define("mainDataBase", 'ejemplo');
*/
	define("server", '128.5.8.49');
	define("user", 'contingentes');
	define("pass", 'DACEGuate2015');
	define("mainDataBase", 'contingentes');

	define("server2", "localhost");
	define("user2", 'egonzalez');
	define("pass2", '87654321');
	define("mainDataBase2", 'trazabilidad');

	$errorDbConexion = true;
	$errorDbConexion2 = true;

	// Verificar constantes para conexión al servidor
	if(defined('server') && defined('user') && defined('pass') && defined('mainDataBase'))
	{
		// Conexión con la base de datos
		
		$mysqli = new mysqli(server, user, pass, mainDataBase);
		
		// Verificamos si hay error al conectar
		if (mysqli_connect_error()) {
		    $errorDbConexion = false;
		}
		else{
			// Evitando problemas con acentos
			$mysqli -> query('SET NAMES "utf8"');
		}
		
	}

	// Verificar constantes para conexión al servidor
	if (defined("server2") && defined("user2") && defined("pass2") && defined("mainDataBase2")) {

		// Conexión con la base de datos
		$mysqli2 = new mysqli(server2, user2, pass2, mainDataBase2);

		// Verificamos si hay error al conectar
		if (mysqli_connect_error()) {
			$errorDbConexion2 = false;
		}
		else{
			// Evitando problemas con acentos
			$mysqli2 -> query('SET NAMES "utf8"');
		}
	}

 ?>