<?php
    include("conexao.php");

    $email = $_POST["email"];
    $identificador = $_POST["ident"];
    $oqe = $_POST["oqe"];
    $nova_senha = $_POST["nova_senha"];

    if($oqe == "Física"){
        $consulta = "UPDATE usuario SET senha = '$nova_senha' WHERE CPF = '$identificador' AND email = '$email'";
    }else{
        $consulta = "UPDATE local SET senha = '$nova_senha' WHERE CNPJ = $identificador AND email = '$email'";
    }

    $resultado = mysqli_query($conexao, $consulta) or die("Erro: " .mysqli_error($conexao));

    echo "1";
?>