<?php
    header("Content-Type: Application/json");

    include("conexao.php");

    $consulta = "SELECT descricao as 'desc_doa', 
                        quantidade as 'qtd_doa', 
                        tipo as 'tipo_doa', 
                        data_inicio as 'ini_doa', 
                        data_fim as 'fim_doa', 
                        arre_doar as 'oqe'
                    FROM doacoes";

    $resultado = mysqli_query($conexao, $consulta);

    while($linha = mysqli_fetch_assoc($resultado)){
        $matriz["arredoar"][] = $linha;
    }

    echo json_encode($matriz);
    // echo "1";
?>