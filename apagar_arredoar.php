<?php
    include("conexao.php");

    $id = $_POST["id"];

    $excluir = "DELETE FROM doacoes WHERE id_doacoes = $id";

    mysqli_query($conexao, $excluir) or die("Erro: " . mysqli_error($conexao));

    echo "1";
?>