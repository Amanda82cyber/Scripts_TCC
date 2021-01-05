<?php
    header("Content-Type: Application/json");

    include("conexao.php");

    $p = $_POST["p"];

    $consulta = "SELECT descricao as 'desc_doa', 
                        quantidade as 'qtd_doa', 
                        tipo as 'tipo_doa', 
                        data_inicio as 'ini_doa', 
                        data_fim as 'fim_doa', 
                        arre_doar as 'oqe',
                        foto_doacao as 'foto',
                        id_doacoes
                    FROM doacoes ";

    if(($_POST["filtro1"] != "") || ($_POST["filtro2"] != "") || ($_POST["filtro3"] != "")){
        $filtro1 = $_POST["filtro1"];
        $filtro2 = $_POST["filtro2"];
        $filtro3 = $_POST["filtro3"];
        $data = date("Y-m-d");    

        if(($filtro1 != "") && ($filtro2 == "") && ($filtro3 == "")){
            $consulta .= "WHERE tipo = '$filtro1'";
        }else if(($filtro1 == "") && ($filtro2 != "") && ($filtro3 == "")){
            if($filtro2 == "VÁLIDA"){
                $consulta .= "WHERE data_fim >= '$data'";
            }else{
                $consulta .= "WHERE data_fim <= '$data'";
            }		
        }else if(($filtro1 == "") && ($filtro2 == "") && ($filtro3 != "")){
            $consulta .= "WHERE descricao LIKE '%$filtro3%'";
        }else if(($filtro1 != "") && ($filtro2 != "") && ($filtro3 == "")){
            if($filtro2 == "VÁLIDA"){
                $consulta .= "WHERE tipo = '$filtro1' AND data_fim >= '$data'";
            }else{
                $consulta .= "WHERE tipo = '$filtro1' AND data_fim <= '$data'";
            }	
        }else if(($filtro1 != "") && ($filtro2 == "") && ($filtro3 != "")){
            $consulta .= "WHERE tipo = '$filtro1' AND descricao LIKE '%$filtro3%'";
        }else if(($filtro1 == "") && ($filtro2 != "") && ($filtro3 != "")){
            if($filtro2 == "VÁLIDA"){
                $consulta .= "WHERE data_fim >= '$data' AND descricao LIKE '%$filtro3%'";
            }else{
                $consulta .= "WHERE data_fim <= '$data' AND descricao LIKE '%$filtro3%'";
            }
        }else{
            if($filtro2 == "VÁLIDA"){
				$consulta .= "WHERE tipo = '$filtro1' AND data_fim >= '$data' AND descricao LIKE '%$filtro3%'";
			}else{
				$consulta .= "WHERE tipo = '$filtro1' AND data_fim <= '$data' AND descricao LIKE '%$filtro3%'";
			}
        }

        if($_POST["ident"] != ""){
            $ident = $_POST["ident"];
            $consulta .= " AND CPF_usuario = '$ident' OR cnpj_local = '$ident'";
        }
    }else{
        if($_POST["ident"] != ""){
            $ident = $_POST["ident"];
            $consulta .= "WHERE CPF_usuario = '$ident' OR cnpj_local = '$ident'";
        }
    }

    $consulta .= "ORDER BY data_fim DESC LIMIT $p,10";

    $resultado = mysqli_query($conexao, $consulta);

    while($linha = mysqli_fetch_assoc($resultado)){
        $matriz["arredoar"][] = $linha;
    }

    echo json_encode($matriz);
    // echo "1";
?>