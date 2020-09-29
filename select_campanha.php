<?php
    header("Content-Type: Application/json");

    include("conexao.php");

    $consulta = "SELECT * FROM campanha";

    $resultado = mysqli_query($conexao, $consulta) or die ("0" . mysqli_error($conexao));

    while($linha = mysqli_fetch_assoc($resultado)){
        $matriz["campanhas"][] = $linha;
    }

    echo json_encode($matriz);
?>