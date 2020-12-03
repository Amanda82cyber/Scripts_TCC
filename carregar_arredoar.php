<?php
    header("Content-Type: Application/json");

    include("conexao.php");

    $id = $_POST["ident"];

    $select = "SELECT * FROM doacoes WHERE id_doacoes = $id";

    $resultado = mysqli_query($conexao, $select);

    while($linha = mysqli_fetch_assoc($resultado)){
        $matriz["arredoar"][] = $linha;
    }

    echo json_encode($matriz);
?>