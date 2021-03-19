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
	
	// HOSPEDAGEM
	// $local = "localhost";
	// $bd = "id15219962_tcc";
	// $senha = "[6N{Mo/1usrCX>ng";
	// $usuario = "id15219962_amandeia";

	$conexao = mysqli_connect($local,$usuario,$senha,$bd) or die("ERRO");
	
	mysqli_set_charset($conexao, 'utf8');
?>