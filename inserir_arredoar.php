<?php
    include("conexao.php");
    session_start();

    $arre_doar = strtoupper($_POST["arre_doar"]);
    $desc = strtoupper($_POST["desc"]);
    $tipo = strtoupper($_POST["tipo"]);
    $q_tipo = strtoupper($_POST["q_tipo"]);
    $campanha = strtoupper($_POST["campanha"]);
    $quant = $_POST["quant"];
    $data_inicio = $_POST["data_inicio"];
    $data_fim = $_POST["data_fim"];
    $usuario = $_SESSION["identificador"][0];

    if($tipo == "OUTRO"){
        $tipo = $q_tipo;
    }

    if($_SESSION["acesso"] == "loja"){
        $inserir = "INSERT INTO doacoes(descricao, quantidade, tipo, data_inicio, data_fim, arre_doar, id_campanha, cnpj_local) VALUES('$desc', '$quant', '$tipo', '$data_inicio', '$data_fim', '$arre_doar', '$campanha', '$usuario')";
    }else{
        $inserir = "INSERT INTO doacoes(descricao, quantidade, tipo, data_inicio, data_fim, arre_doar, id_campanha, CPF_usuario) VALUES('$desc', '$quant', '$tipo', '$data_inicio', '$data_fim', '$arre_doar', '$campanha', '$usuario')";
    }

    mysqli_query($conexao, $inserir) or die(mysqli_error($conexao));

    echo "1";
?>