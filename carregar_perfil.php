<?php
    header("Content-Type: Application/json");

    include("conexao.php");

    $ident = $_POST["ident"];
    $oqe = $_POST["oqe"];

    if($oqe == "Física"){
        $select = "SELECT * FROM usuario WHERE CPF = '$ident'";
    }else{
        $select = "SELECT * FROM local WHERE CNPJ = '$ident'";
    }

    $resultado = mysqli_query($conexao, $select);

    while($linha = mysqli_fetch_assoc($resultado)){
        $matriz["perfil"][] = $linha;
    }

    echo json_encode($matriz);
?>