<?php

function DBCreation(){

    $conn = mysqli_connect ( "localhost", "administrador", "iO5TvRslT18VYcV9");

    $sql = ("drop database if exists ud4");
    $conn->query($sql);

    $sql = ("create database if not exists ud4");
    $conn->query($sql);

    $sql = ("use ud4");
    $conn->query($sql);

    $sql = file_get_contents('ud4.sql');
    $conn->multi_query($sql);

}

function conectar() {

    $conn = mysqli_connect( "localhost", "administrador", "iO5TvRslT18VYcV9", "ud4");

    return $conn;

}

function createUserUD4($usuario, $password, $email) {

        $conn = conectar();

        $sql = ("SELECT * FROM UD4.usuarios WHERE nombre='$usuario'");
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<p>Este nombre de usuario ya ha sido registrado en el sistema.<p>';
        }

        if ($result->num_rows == 0) {
            $sql = ("INSERT INTO UD4.usuarios(nombre,password,email) VALUES ('$usuario','$password','$email')");
            $result = $conn->query($sql);

            if ($result) {
                echo '<p class="success">Te has registrado correctamente.</p>';
            } else {
                echo '<p class="error">Algo salió mal.</p>';
            }

        }

}

function createUserWordpress($usuario, $password, $email) {

    $url = "http://localhost/wordpress/wp-json/wp/v2/users";
		$client = curl_init($url);
		curl_setopt($client, CURLOPT_POST, true);
		
		$data = [
			'username' => $usuario,
			'email' => $email,
			'password' => $password,
		];
		$payload = json_encode($data);
		$wpname = "wordpress";
		$wppass = "wordpress";
	
		curl_setopt($client, CURLOPT_USERPWD, $wpname . ":" . $wppass);
		curl_setopt($client, CURLOPT_POSTFIELDS, $payload);
		curl_setopt($client, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
		$response = curl_exec($client);

}

function createUserEspo ($usuario, $password, $email) {
    $url = "http://localhost/EspoCRM-7.0.9";
    require_once('EspoApiClient.php');

    $client = new EspoApiClient($url);
    $client->setApiKey('4a12502429e6516444c1bfe2504ce517');

    try {
        $response = $client->request('POST', 'Contact', [
            'firstName' => $usuario,
            'salutationName' => 'Señor',
            'lastName' => 'Ejemplo',
            'espo-emailAddress' => $email,
            'password' => $password,
    ]);
    } catch (\Exception $e) {
        $errorCode = $e->getCode();
    }
}

function iniSesion($usuario, $password) {

    $conn = conectar();
    $sql = "SELECT * FROM UD4.usuarios WHERE nombre = '$usuario' AND password = '$password'";

    return mysqli_query($conn, $sql)->fetch_assoc();

}

function createPostWordpress($titulo, $texto) {

    $url = "http://localhost/wordpress/wp-json/wp/v2/posts";
		$client = curl_init($url);
		curl_setopt($client, CURLOPT_POST, true);
		
		$data = [
			'title' => $titulo,
			'content' => $texto,
			'status' => 'publish',
		];

		$payload = json_encode($data);
		$wpuser = "wordpress";
		$wppass = "wordpress";
	
		curl_setopt($client, CURLOPT_USERPWD, $wpuser . ":" . $wppass);
		curl_setopt($client, CURLOPT_POSTFIELDS, $payload);
		curl_setopt($client, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
		$response = curl_exec($client);
    
    if ($response) {
        echo "<center><h2>Tu post se ha generado correctamente.</h2></center>";
    }

}

?>