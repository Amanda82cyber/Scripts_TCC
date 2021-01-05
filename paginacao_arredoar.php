<?php
	include("conexao.php");

	$select = "SELECT * FROM doacoes ";

	if((isset($_POST["filtro1"])) || (isset($_POST["filtro2"])) || (isset($_POST["filtro3"]))){
		$filtro1 = $_POST["filtro1"];
		$filtro2 = $_POST["filtro2"];
		$filtro3 = $_POST["filtro3"];
		$data = date("Y-m-d");

		if(($filtro1 != "") && ($filtro2 == "") && ($filtro3 == "")){
			$select .= "WHERE tipo = '$filtro1'";
		}else if(($filtro1 == "") && ($filtro2 != "") && ($filtro3 == "")){
			if($filtro2 == "VÁLIDA"){
				$select .= "WHERE data_fim >= '$data'";
			}else{
				$select .= "WHERE data_fim <= '$data'";
			}		
		}else if(($filtro1 == "") && ($filtro2 == "") && ($filtro3 != "")){
			$select .= "WHERE descricao LIKE '%$filtro3%'";
		}else if(($filtro1 != "") && ($filtro2 != "") && ($filtro3 == "")){
			if($filtro2 == "VÁLIDA"){
				$select .= "WHERE tipo = '$filtro1' AND data_fim >= '$data'";
			}else{
				$select .= "WHERE tipo = '$filtro1' AND data_fim <= '$data'";
			}	
		}else if(($filtro1 != "") && ($filtro2 == "") && ($filtro3 != "")){
			$select .= "WHERE tipo = $filtro1 AND descricao LIKE '%$filtro3%'";
		}else if(($filtro1 == "") && ($filtro2 != "") && ($filtro3 != "")){
			if($filtro2 == "VÁLIDA"){
				$select .= "WHERE descricao LIKE '%$filtro3%' AND data_fim >= '$data'";
			}else{
				$select .= "WHERE descricao LIKE '%$filtro3%' AND data_fim <= '$data'";
			}
		}else{
			
			if($filtro2 == "VÁLIDA"){
				$select .= "WHERE tipo = '$filtro1' AND data_fim >= '$data' AND descricao LIKE '%$filtro3%'";
			}else{
				$select .= "WHERE tipo = '$filtro1' AND data_fim <= '$data' AND descricao LIKE '%$filtro3%'";
			}
		}
	}

	$resultado = mysqli_query($conexao, $select) or die("Erro: " .mysqli_error($conexao));
	
	$linha = mysqli_num_rows($resultado);
	
	$qtd_pagina = (int)($linha/10);
	
	if($linha%10 != 0){
		$qtd_pagina++;
		$qtd_pagina = (int)$qtd_pagina;
	}
	
	echo '<ul class = "pagination justify-content-center">';
	
	for($i = 1;$i <= $qtd_pagina; $i++){
		echo "<li class = 'page-item'><a name = 'btn_pagina' class = 'page-link cards_doacao border-primary'>$i</a></li>";
	}
	
	echo '</ul>';
?>