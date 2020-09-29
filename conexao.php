<?php
    // XAMPP
	$local = "localhost";
	$bd = "tcc";
	$senha = "";
	$usuario = "root";

	// USBWEBSERVER
	// $local = "localhost:3307";
	// $usuario = "root";
	// $senha = "usbw";
	// $bd = "tcc";

	$conexao = mysqli_connect($local,$usuario,$senha,$bd) or die("ERRO");
	
	mysqli_set_charset($conexao, 'utf8');
?>