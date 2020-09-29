<?php
    include("conexao.php");

    $descricao = strtoupper($_POST["descricao"]);
    $data_ini = $_POST["data_ini"];
    $data_ter = $_POST["data_ter"];

    $inserir = "INSERT INTO campanha(descricao, data_inicio, data_fim) VALUES('$descricao', '$data_ini', '$data_ter')";
    mysqli_query($conexao, $inserir) or die(mysqli_error($conexao));

    echo "1";
?>